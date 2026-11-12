import fs from 'node:fs';
import { spawn, spawnSync } from 'node:child_process';
import * as p from '@clack/prompts';
import { NotesError } from '../lib/errors.js';

const HOME = [
  { value: 'new', label: 'New' },
  { value: 'browse', label: 'Browse' },
  { value: 'init', label: 'Init' },
  { value: 'help', label: 'Help' },
  { value: 'quit', label: 'Quit' },
];

function hasCursor() {
  const result = spawnSync('which', ['cursor'], { encoding: 'utf8' });
  return result.status === 0;
}

function openInCursor(file) {
  const child = spawn('cursor', [file], { detached: true, stdio: 'ignore' });
  child.on('error', () => {});
  child.unref();
}

async function newWizard(api) {
  const type = await p.select({
    message: 'Type',
    options: [
      { value: 'feature', label: 'Feature', hint: 'full or minor' },
      { value: 'fix', label: 'Fix' },
      { value: 'refactor', label: 'Refactor' },
      { value: 'analysis', label: 'Analysis', hint: 'question' },
      { value: 'qa', label: 'QA', hint: 'test cases' },
    ],
  });
  if (p.isCancel(type)) {
    p.log.warn('Cancelled.');
    return;
  }

  let minor = false;
  if (type === 'feature') {
    const scope = await p.select({
      message: 'Feature scope',
      options: [
        { value: 'full', label: 'Full feature (with plan)' },
        { value: 'minor', label: 'Minor feature (no plan)' },
      ],
    });
    if (p.isCancel(scope)) {
      p.log.warn('Cancelled.');
      return;
    }
    minor = scope === 'minor';
  }

  const title = await p.text({
    message: type === 'analysis' ? 'Question to investigate' : 'Title / short description',
    placeholder: type === 'analysis' ? 'How does login work?' : 'Comment embed widget',
    validate(value) {
      if (!value || !value.trim()) return 'Title is required';
    },
  });
  if (p.isCancel(title)) {
    p.log.warn('Cancelled.');
    return;
  }

  const suggested = api.nextId(type);
  const id = await p.text({
    message: 'ID',
    initialValue: suggested,
    placeholder: suggested,
    validate(value) {
      const next = (value || '').trim();
      if (!next) return 'ID is required';
      if (!api.isValidId(type, next)) {
        const prefix = suggested.replace(/-\d+$/, '');
        return `Use ${prefix}-<number>`;
      }
    },
  });
  if (p.isCancel(id)) {
    p.log.warn('Cancelled.');
    return;
  }

  const cleanTitle = title.trim();
  const cleanId = id.trim();
  const dest = api.briefPath(type, cleanId);
  const exists = fs.existsSync(dest);
  const summary = [
    `Type:   ${type}`,
    type === 'feature' ? `Scope:  ${minor ? 'minor' : 'full'}` : null,
    `Title:  ${cleanTitle}`,
    `ID:     ${cleanId}`,
    `File:   ${dest}`,
    exists ? 'Status: overwrite existing brief' : null,
  ]
    .filter(Boolean)
    .join('\n');
  p.log.message(summary);

  const ok = await p.confirm({
    message: exists ? 'Overwrite this brief?' : 'Create this brief?',
    initialValue: !exists,
  });
  if (p.isCancel(ok) || !ok) {
    p.log.warn('Cancelled.');
    return;
  }

  try {
    const result = api.createItem({
      type,
      title: cleanTitle,
      id: cleanId,
      minor,
      force: exists,
    });
    p.log.success(`Created ${result.id}`);
    p.log.message(api.createdMessage(result));
  } catch (error) {
    if (error instanceof NotesError) {
      p.log.error(error.message);
      return;
    }
    throw error;
  }
}

async function browse(api) {
  const items = api.listBriefs();
  if (items.length === 0) {
    p.log.warn('No briefs yet.');
    return;
  }

  const picked = await p.autocomplete({
    message: 'Browse briefs',
    placeholder: 'Filter by id, title, or status',
    maxItems: 8,
    options: items.map((item) => ({
      value: item.id,
      label: `${item.id}  ${item.title}`,
      hint: [item.status, item.scope].filter(Boolean).join(' · '),
    })),
  });
  if (p.isCancel(picked) || !picked) {
    p.log.warn('Cancelled.');
    return;
  }

  p.log.message(api.showText(picked));
  const options = [{ value: 'back', label: 'Back' }];
  if (hasCursor()) options.unshift({ value: 'open', label: 'Open in Cursor', hint: 'brief file' });
  const action = await p.select({ message: 'Next', options });
  if (p.isCancel(action) || action === 'back') return;
  if (action === 'open') {
    const file = api.findBrief(picked);
    openInCursor(file);
    p.log.success(`Opened ${file}`);
  }
}

const HELP = `Commands (also via npx vibe …):
  menu / (default)   Interactive menu
  init               Ensure folders and catalogs
  new <type> <title> Create brief (feature|fix|analysis|refactor|qa)
  catalog sync <id>  Upsert catalogs from disk
  catalog status …   Patch status + sync
  done <id> --summary "…"  Close-out
  list [type]        Show catalogs
  show|open <id>     Paths

Humans edit ## Instructions / ## Question only.
Agents follow the brief’s single rules pointer, then use catalog CLI.`;

export async function runMenu(api) {
  p.intro('Vibe Workflow');
  try {
    while (true) {
      p.note(api.countsLine(), 'Catalog');
      const action = await p.select({
        message: 'What do you want to do?',
        options: HOME,
      });
      if (p.isCancel(action) || action === 'quit') {
        p.outro('Bye.');
        return;
      }
      if (action === 'new') await newWizard(api);
      else if (action === 'browse') await browse(api);
      else if (action === 'init') p.log.success(api.init());
      else if (action === 'help') p.note(HELP, 'Help');
    }
  } finally {
    if (process.stdin.isTTY && typeof process.stdin.setRawMode === 'function') {
      process.stdin.setRawMode(false);
    }
  }
}
