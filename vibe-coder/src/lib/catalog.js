import fs from 'node:fs';
import path from 'node:path';
import { NotesError } from './errors.js';

export function catalogTimestamp(now = new Date()) {
  const y = now.getFullYear();
  const m = String(now.getMonth() + 1).padStart(2, '0');
  const d = String(now.getDate()).padStart(2, '0');
  const hh = String(now.getHours()).padStart(2, '0');
  const mm = String(now.getMinutes()).padStart(2, '0');
  const ss = String(now.getSeconds()).padStart(2, '0');
  return `${y}-${m}-${d}T${hh}:${mm}:${ss}`;
}

export function sanitizeCell(value) {
  return String(value).replace(/\r?\n/g, ' ').replace(/\|/g, '\\|');
}

function ensureDir(file) {
  fs.mkdirSync(path.dirname(file), { recursive: true });
}

export function ensureTypeCatalog(cat, name) {
  const header =
    `# ${name} catalog\n\n` +
    `| ID | Title | Plan | Status | Results | Created |\n` +
    `|----|-------|------|--------|---------|---------|\n`;
  if (!fs.existsSync(cat) || !fs.readFileSync(cat, 'utf8').includes('| ID |')) {
    ensureDir(cat);
    fs.writeFileSync(cat, header);
  }
}

export function ensurePlansCatalog(cat) {
  const header =
    `# plans catalog\n\n` +
    `| ID | Title | Status | File | Created |\n` +
    `|----|-------|--------|------|---------|\n`;
  if (!fs.existsSync(cat) || !fs.readFileSync(cat, 'utf8').includes('| ID |')) {
    ensureDir(cat);
    fs.writeFileSync(cat, header);
  }
}

export function ensureResultsCatalog(cat) {
  const header =
    `# results catalog\n\n` +
    `| ID | Type | Title | Status | Summary | File | Created |\n` +
    `|----|------|-------|--------|---------|------|---------|\n`;
  if (!fs.existsSync(cat) || !fs.readFileSync(cat, 'utf8').includes('| ID |')) {
    ensureDir(cat);
    fs.writeFileSync(cat, header);
  }
}

export function catalogHas(cat, id) {
  if (!fs.existsSync(cat)) return false;
  return fs.readFileSync(cat, 'utf8').split('\n').some((line) => line.startsWith(`| ${id} |`));
}

/** Parse cells from a markdown table row starting with `| id |` */
export function parseRowCells(line) {
  const trimmed = line.trim();
  if (!trimmed.startsWith('|') || !trimmed.endsWith('|')) return [];
  return trimmed
    .slice(1, -1)
    .split('|')
    .map((cell) => cell.trim());
}

export function existingCreated(cat, id) {
  if (!fs.existsSync(cat)) return '';
  for (const line of fs.readFileSync(cat, 'utf8').split('\n')) {
    if (!line.startsWith(`| ${id} |`)) continue;
    const cells = parseRowCells(line);
    return cells[cells.length - 1] || '';
  }
  return '';
}

export function formatTypeRow(id, title, plan, status, results, created) {
  return `| ${id} | ${sanitizeCell(title)} | ${plan} | ${status} | ${results} | ${created} |`;
}

export function formatPlansRow(id, title, status, file, created) {
  return `| ${id} | ${sanitizeCell(title)} | ${status} | ${file} | ${created} |`;
}

export function formatResultsRow(id, type, title, status, summary, file, created) {
  return (
    `| ${id} | ${type} | ${sanitizeCell(title)} | ${status} | ` +
    `${sanitizeCell(summary)} | ${file} | ${created} |`
  );
}

/**
 * Upsert a row: insert if missing, else replace the `| {id} |` line.
 * Preserves Created from existing row when updating.
 */
export function upsertRow(cat, id, buildRow, { ensure } = {}) {
  if (ensure) ensure();
  if (!fs.existsSync(cat)) throw new NotesError(`Catalog not found: ${cat}`);
  const created = existingCreated(cat, id) || catalogTimestamp();
  const row = buildRow(created);
  let text = fs.readFileSync(cat, 'utf8');
  const lines = text.split('\n');
  let found = false;
  const next = lines.map((line) => {
    if (line.startsWith(`| ${id} |`)) {
      found = true;
      return row;
    }
    return line;
  });
  if (found) {
    fs.writeFileSync(cat, next.join('\n'));
  } else {
    if (!text.endsWith('\n')) text += '\n';
    fs.writeFileSync(cat, `${text}${row}\n`);
  }
  return { path: cat, created, inserted: !found };
}
