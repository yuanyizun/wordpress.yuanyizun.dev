import assert from 'node:assert/strict';
import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';
import { test } from 'node:test';
import {
  catalogTimestamp,
  sanitizeCell,
  ensureTypeCatalog,
  upsertRow,
  formatTypeRow,
  existingCreated,
  catalogHas,
} from '../src/lib/catalog.js';
import { setFmValue, getFmValue } from '../src/lib/frontmatter.js';
import { isValidId, idToType, nextId } from '../src/lib/ids.js';
import { createBriefsApi } from '../src/lib/briefs.js';

test('sanitizeCell escapes pipes and newlines', () => {
  assert.equal(sanitizeCell('a|b\nc'), 'a\\|b c');
});

test('catalogTimestamp shape', () => {
  assert.match(catalogTimestamp(new Date('2026-10-22T20:58:03')), /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/);
});

test('upsert preserves Created on update', () => {
  const dir = fs.mkdtempSync(path.join(os.tmpdir(), 'notes-cat-'));
  const cat = path.join(dir, 'catalog.md');
  ensureTypeCatalog(cat, 'feature');
  const first = upsertRow(cat, 'feature-001', (created) =>
    formatTypeRow('feature-001', 'One', 'AI', 'draft', 'AI', created),
  );
  assert.equal(first.inserted, true);
  assert.ok(catalogHas(cat, 'feature-001'));
  const created = existingCreated(cat, 'feature-001');
  assert.equal(created, first.created);

  const second = upsertRow(cat, 'feature-001', (c) =>
    formatTypeRow('feature-001', 'Two', 'AI', 'done', 'AI', c),
  );
  assert.equal(second.inserted, false);
  assert.equal(existingCreated(cat, 'feature-001'), created);
  assert.match(fs.readFileSync(cat, 'utf8'), /\| feature-001 \| Two \|/);
});

test('ids: feature maps to feature folder type', () => {
  assert.equal(idToType('feature-001'), 'feature');
  assert.equal(isValidId('feature', 'feature-001'), true);
  assert.equal(isValidId('feat', 'feature-001'), false);
});

test('frontmatter status patch', () => {
  const dir = fs.mkdtempSync(path.join(os.tmpdir(), 'notes-fm-'));
  const file = path.join(dir, 'brief.md');
  fs.writeFileSync(
    file,
    `---\nid: feature-001\ntype: feature\nstatus: draft\ntitle: T\ndate: 2026-10-22\n---\n\n# T\n`,
  );
  setFmValue(file, 'status', 'done');
  assert.equal(getFmValue(file, 'status'), 'done');
  assert.match(fs.readFileSync(file, 'utf8'), /# T/);
});

test('smoke: init + new + catalog sync in temp dir', () => {
  const root = fs.mkdtempSync(path.join(os.tmpdir(), 'notes-root-'));
  // Copy templates into temp root
  const templatesSrc = path.resolve(import.meta.dirname, '../templates');
  fs.cpSync(templatesSrc, path.join(root, 'templates'), { recursive: true });
  fs.mkdirSync(path.join(root, 'rules'), { recursive: true });

  const api = createBriefsApi(root);
  api.init();
  assert.ok(fs.existsSync(path.join(root, 'work/feature/catalog.md')));
  assert.ok(fs.existsSync(path.join(root, 'work/plans/catalog.md')));
  assert.ok(fs.existsSync(path.join(root, 'work/results/catalog.md')));
  assert.ok(fs.existsSync(path.join(root, 'resource/ui')));

  const id = nextId(root, 'feature');
  const created = api.createItem({ type: 'feature', title: 'Smoke test', id });
  assert.equal(created.id, id);
  const brief = fs.readFileSync(created.briefPath, 'utf8');
  assert.match(brief, /type: feature/);
  assert.match(brief, /vibe-coder\/rules\/feature\.md/);
  assert.doesNotMatch(brief, /Agent-only/);

  assert.throws(() => api.createItem({ type: 'feat', title: 'Nope' }), /feature/);

  fs.writeFileSync(
    path.join(root, 'work/plans', `${id}.md`),
    `---\nid: ${id}\ntype: plan\nstatus: done\ntitle: Plan\ndate: 2026-10-22\n---\n\n# Plan\n\n## Summary\n\nPlanned smoke\n`,
  );
  fs.writeFileSync(
    path.join(root, 'work/results', `${id}.md`),
    `---\nid: ${id}\ntype: results\nstatus: done\ntitle: Results\ndate: 2026-10-22\n---\n\n# Results\n\n## Summary\n\nDid the smoke\n`,
  );

  const sync = api.catalogSync(id, { summary: 'Smoke summary' });
  assert.ok(sync.touched.length >= 2);
  const typeCat = fs.readFileSync(path.join(root, 'work/feature/catalog.md'), 'utf8');
  assert.match(typeCat, new RegExp(`\\| ${id} \\|`));
  assert.match(typeCat, /Created/);
  const plansCat = fs.readFileSync(path.join(root, 'work/plans/catalog.md'), 'utf8');
  assert.match(plansCat, new RegExp(`\\| ${id} \\|`));
  const resultsCat = fs.readFileSync(path.join(root, 'work/results/catalog.md'), 'utf8');
  assert.match(resultsCat, /Smoke summary/);

  const done = api.done(id, { summary: 'Finished smoke' });
  assert.equal(getFmValue(created.briefPath, 'status'), 'done');
  assert.ok(done.touched.length >= 1);
  assert.match(fs.readFileSync(path.join(root, 'work/results/catalog.md'), 'utf8'), /Finished smoke/);
});
