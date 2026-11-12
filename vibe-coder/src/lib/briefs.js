import fs from 'node:fs';
import path from 'node:path';
import {
  TYPES,
  RESOURCE_DIRS,
  WORK_DIR,
  TEMPLATES_DIR,
  RULES_DIR,
} from './constants.js';
import { NotesError } from './errors.js';
import {
  resolveRoot,
  typeDirPath,
  briefPath as briefPathAt,
  planPath,
  resultsPath,
  typeCatalogPath,
  plansCatalogPath,
  resultsCatalogPath,
  uiDir,
} from './paths.js';
import { nextId, assertValidId, isValidId, idToType, typeToPrefix } from './ids.js';
import { getFmValue, setFmValue, localDate, extractSummary } from './frontmatter.js';
import {
  ensureTypeCatalog,
  ensurePlansCatalog,
  ensureResultsCatalog,
  catalogHas,
  upsertRow,
  formatTypeRow,
  formatPlansRow,
  formatResultsRow,
} from './catalog.js';
import { templateFor, applyTemplate, appendBullets } from './templates.js';

function requireBrief(root, id) {
  const type = idToType(id);
  const file = briefPathAt(root, type, id);
  if (!fs.existsSync(file)) throw new NotesError(`Brief not found: ${file}`);
  return file;
}

function planCol(root, id) {
  let brief;
  try {
    brief = requireBrief(root, id);
  } catch {
    return '—';
  }
  const type = getFmValue(brief, 'type');
  const scope = getFmValue(brief, 'scope');
  if (type === 'feature') {
    if (scope === 'minor') return 'minor';
    if (fs.existsSync(planPath(root, id))) {
      return `[plan](../plans/${id}.md)`;
    }
    return 'AI';
  }
  return '—';
}

function resultsCol(root, id) {
  if (fs.existsSync(resultsPath(root, id))) {
    return `[results](../results/${id}.md)`;
  }
  return 'AI';
}

function upsertTypeCatalog(root, id) {
  const type = idToType(id);
  const brief = requireBrief(root, id);
  const title = getFmValue(brief, 'title');
  const status = getFmValue(brief, 'status') || 'draft';
  const cat = typeCatalogPath(root, type);
  return upsertRow(
    cat,
    id,
    (created) => formatTypeRow(id, title, planCol(root, id), status, resultsCol(root, id), created),
    { ensure: () => ensureTypeCatalog(cat, type) },
  );
}

function upsertPlansCatalog(root, id) {
  const plan = planPath(root, id);
  if (!fs.existsSync(plan)) return null;
  const brief = requireBrief(root, id);
  const title = getFmValue(brief, 'title');
  const status = getFmValue(plan, 'status') || getFmValue(brief, 'status') || 'draft';
  const cat = plansCatalogPath(root);
  return upsertRow(
    cat,
    id,
    (created) => formatPlansRow(id, title, status, `[plan](./${id}.md)`, created),
    { ensure: () => ensurePlansCatalog(cat) },
  );
}

function upsertResultsCatalog(root, id, summaryOverride) {
  const results = resultsPath(root, id);
  if (!fs.existsSync(results)) return null;
  const brief = requireBrief(root, id);
  const type = getFmValue(brief, 'type') || idToType(id);
  const title = getFmValue(brief, 'title');
  const status = getFmValue(brief, 'status') || 'draft';
  const summary =
    summaryOverride != null && String(summaryOverride).trim()
      ? String(summaryOverride).trim()
      : extractSummary(results) || '';
  const cat = resultsCatalogPath(root);
  return upsertRow(
    cat,
    id,
    (created) =>
      formatResultsRow(id, type, title, status, summary, `[results](./${id}.md)`, created),
    { ensure: () => ensureResultsCatalog(cat) },
  );
}

export function createBriefsApi(root = resolveRoot()) {
  const notesRoot = resolveRoot(root);

  function briefPath(type, id) {
    return briefPathAt(notesRoot, type, id);
  }

  function findBrief(id) {
    return requireBrief(notesRoot, id);
  }

  function createItem({ type, title, id, minor = false, force = false, bullets = [] }) {
    if (type === 'feat') {
      throw new NotesError('Unknown type: feat (use "feature")');
    }
    if (!TYPES.includes(type)) throw new NotesError(`Unknown type: ${type}`);
    if (minor && type !== 'feature') throw new NotesError('--minor is only valid for feature');
    if (!title || !String(title).trim()) throw new NotesError('Title required');
    const itemId = id == null ? nextId(notesRoot, type) : id;
    assertValidId(type, itemId);
    const dest = briefPath(type, itemId);
    if (fs.existsSync(dest) && !force) {
      throw new NotesError(`Brief exists: ${dest} (use --force)`);
    }
    applyTemplate(templateFor(notesRoot, type, minor), dest, itemId, title, localDate());
    appendBullets(dest, bullets);
    ensureTypeCatalog(typeCatalogPath(notesRoot, type), type);
    upsertTypeCatalog(notesRoot, itemId);
    return { briefPath: dest, id: itemId, type, minor };
  }

  function createdMessage(result) {
    const lines = [`Created: ${result.briefPath}`, `ID:      ${result.id}`];
    if (result.type === 'feature') {
      if (result.minor) {
        lines.push(
          'Scope:   minor (no plan)',
          'Next:    Edit ## Instructions in the brief; attach rules/skills/resource in Cursor',
          `         AI will create vibe-coder/work/results/${result.id}.md only`,
        );
      } else {
        lines.push(
          'Scope:   full (with plan)',
          'Next:    Edit ## Instructions in the brief; attach rules/skills/resource in Cursor',
          `         AI will create vibe-coder/work/plans/${result.id}.md and vibe-coder/work/results/${result.id}.md`,
        );
      }
    } else if (result.type === 'fix' || result.type === 'refactor' || result.type === 'qa') {
      lines.push(
        'Next:    Edit ## Instructions in the brief',
        `         AI will create vibe-coder/work/results/${result.id}.md (no plan)`,
      );
    } else if (result.type === 'analysis') {
      lines.push(
        'Next:    Edit ## Question in the brief if needed',
        `         AI will create vibe-coder/work/results/${result.id}.md with findings`,
      );
    }
    return lines.join('\n');
  }

  function catalogSync(id, { summary } = {}) {
    if (!id) throw new NotesError('Usage: vibe catalog sync <id>');
    requireBrief(notesRoot, id);
    const touched = [];
    const typeResult = upsertTypeCatalog(notesRoot, id);
    touched.push(typeResult.path);
    const plansResult = upsertPlansCatalog(notesRoot, id);
    if (plansResult) touched.push(plansResult.path);
    const resultsResult = upsertResultsCatalog(notesRoot, id, summary);
    if (resultsResult) touched.push(resultsResult.path);
    return { id, touched: [...new Set(touched)] };
  }

  function catalogStatus(id, status, { summary } = {}) {
    if (!id) throw new NotesError('Usage: vibe catalog status <id> <status>');
    if (!status || !String(status).trim()) throw new NotesError('Status required');
    const brief = requireBrief(notesRoot, id);
    setFmValue(brief, 'status', String(status).trim());
    return catalogSync(id, { summary });
  }

  function done(id, { summary } = {}) {
    if (!id) throw new NotesError('Usage: vibe done <id> --summary "…"');
    if (!summary || !String(summary).trim()) {
      throw new NotesError('Usage: vibe done <id> --summary "one line"');
    }
    const brief = requireBrief(notesRoot, id);
    const results = resultsPath(notesRoot, id);
    if (!fs.existsSync(results)) {
      throw new NotesError(`Results file missing: ${results}`);
    }
    setFmValue(brief, 'status', 'done');
    return catalogSync(id, { summary: String(summary).trim() });
  }

  function listText(filter = 'all') {
    const kinds =
      filter === 'all'
        ? TYPES
        : filter === 'plans' || filter === 'results'
          ? [filter]
          : [filter];
    if (filter !== 'all' && !TYPES.includes(filter) && filter !== 'plans' && filter !== 'results') {
      throw new NotesError(`Unknown type: ${filter}`);
    }
    let out = '';
    for (const kind of kinds) {
      const cat =
        kind === 'plans'
          ? plansCatalogPath(notesRoot)
          : kind === 'results'
            ? resultsCatalogPath(notesRoot)
            : typeCatalogPath(notesRoot, kind);
      if (!fs.existsSync(cat)) continue;
      let text = fs.readFileSync(cat, 'utf8');
      if (!text.endsWith('\n')) text += '\n';
      out += `\n${text}`;
    }
    return out;
  }

  function showText(id) {
    if (!id) throw new NotesError('Usage: vibe show <id>');
    const brief = findBrief(id);
    const type = getFmValue(brief, 'type');
    const lines = [`ID:      ${id}`, `Type:    ${type}`, `Brief:   ${brief}`];
    if (type === 'feature') {
      const scope = getFmValue(brief, 'scope');
      if (scope === 'minor') {
        lines.push('Scope:   minor', 'Plan:    (none)');
      } else {
        const plan = planPath(notesRoot, id);
        const flag = fs.existsSync(plan) ? '[exists — AI managed]' : '[AI will create]';
        lines.push('Scope:   full', `Plan:    ${plan} ${flag}`);
      }
      const results = resultsPath(notesRoot, id);
      const resultsFlag = fs.existsSync(results) ? '[exists — AI managed]' : '[AI will create]';
      lines.push(`Results: ${results} ${resultsFlag}`, `UI:      ${uiDir(notesRoot)}/`);
    } else if (TYPES.includes(type)) {
      lines.push('Plan:    (none)');
      const results = resultsPath(notesRoot, id);
      const resultsFlag = fs.existsSync(results) ? '[exists — AI managed]' : '[AI will create]';
      lines.push(`Results: ${results} ${resultsFlag}`);
    }
    return lines.join('\n');
  }

  function openText(id) {
    if (!id) throw new NotesError('Usage: vibe open <id>');
    return `${showText(id)}\n\nAttach the brief’s rules pointer (vibe-coder/rules/…), plus skills/resource in Cursor.`;
  }

  function init() {
    const dirs = [
      TEMPLATES_DIR,
      RULES_DIR,
      'bin',
      'src',
      ...TYPES.map((t) => path.join(WORK_DIR, t)),
      path.join(WORK_DIR, 'plans'),
      path.join(WORK_DIR, 'results'),
      ...RESOURCE_DIRS,
      'skills',
    ];
    for (const dir of dirs) fs.mkdirSync(path.join(notesRoot, dir), { recursive: true });

    for (const rel of [
      'resource/keys/.gitkeep',
      'resource/images/.gitkeep',
      'resource/files/.gitkeep',
      'resource/documents/.gitkeep',
      'resource/ui/.gitkeep',
    ]) {
      const file = path.join(notesRoot, rel);
      fs.mkdirSync(path.dirname(file), { recursive: true });
      fs.closeSync(fs.openSync(file, 'a'));
    }

    const uiReadme = path.join(notesRoot, 'resource', 'ui', 'README.md');
    if (!fs.existsSync(uiReadme)) {
      fs.writeFileSync(
        uiReadme,
        '# UI reference\n\nDocument reusable UI patterns here after implementation.\n',
      );
    }
    const docsReadme = path.join(notesRoot, 'resource', 'documents', 'README.md');
    if (!fs.existsSync(docsReadme)) {
      fs.writeFileSync(
        docsReadme,
        '# Documents\n\nAttach relevant docs in Cursor — do not paste into briefs.\n',
      );
    }

    for (const type of TYPES) {
      ensureTypeCatalog(typeCatalogPath(notesRoot, type), type);
    }
    ensurePlansCatalog(plansCatalogPath(notesRoot));
    ensureResultsCatalog(resultsCatalogPath(notesRoot));

    return `Vibe structure ready at ${notesRoot}`;
  }

  function listBriefs() {
    const items = [];
    for (const type of TYPES) {
      const dir = typeDirPath(notesRoot, type);
      if (!fs.existsSync(dir)) continue;
      for (const name of fs.readdirSync(dir)) {
        if (!name.endsWith('.md') || name === 'catalog.md') continue;
        const file = path.join(dir, name);
        if (!fs.statSync(file).isFile()) continue;
        items.push({
          id: name.slice(0, -'.md'.length),
          folder: type,
          type: getFmValue(file, 'type') || type,
          title: getFmValue(file, 'title') || name,
          status: getFmValue(file, 'status') || 'draft',
          scope: getFmValue(file, 'scope'),
          file,
        });
      }
    }
    items.sort((a, b) => a.id.localeCompare(b.id));
    return items;
  }

  function countsLine() {
    const grouped = Object.fromEntries(TYPES.map((type) => [type, []]));
    for (const item of listBriefs()) grouped[item.folder].push(item);
    return TYPES.map((type) => {
      const rows = grouped[type];
      if (rows.length === 0) return `${type} 0`;
      const draft = rows.filter((row) => row.status === 'draft').length;
      const doneCount = rows.filter((row) => row.status === 'done').length;
      const other = rows.length - draft - doneCount;
      const parts = [];
      if (draft) parts.push(`${draft} draft`);
      if (doneCount) parts.push(`${doneCount} done`);
      if (other) parts.push(`${other} other`);
      return `${type} ${parts.join(', ')}`;
    }).join(' · ');
  }

  return {
    root: notesRoot,
    TYPES,
    isValidId,
    typeToPrefix,
    nextId: (type) => nextId(notesRoot, type),
    briefPath,
    findBrief,
    createItem,
    createdMessage,
    catalogSync,
    catalogStatus,
    done,
    listText,
    showText,
    openText,
    init,
    listBriefs,
    countsLine,
    catalogHas: (type, id) => catalogHas(typeCatalogPath(notesRoot, type), id),
  };
}
