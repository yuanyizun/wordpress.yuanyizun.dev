import fs from 'node:fs';
import path from 'node:path';
import { TEMPLATES_DIR } from './constants.js';
import { NotesError } from './errors.js';

export function templateFor(root, type, minor) {
  if (type === 'feature' && minor) {
    return path.join(root, TEMPLATES_DIR, 'feature-minor.md');
  }
  return path.join(root, TEMPLATES_DIR, `${type}.md`);
}

export function applyTemplate(template, dest, id, title, date) {
  if (!fs.existsSync(template)) throw new NotesError(`Template not found: ${template}`);
  const values = { id, title, date };
  const text = fs.readFileSync(template, 'utf8').replace(
    /\{\{(id|title|date)\}\}/g,
    (_, key) => values[key],
  );
  fs.mkdirSync(path.dirname(dest), { recursive: true });
  fs.writeFileSync(dest, text);
}

/** Append instruction bullets before the ## Agent section */
export function appendBullets(file, bullets) {
  if (bullets.length === 0) return;
  const lines = fs.readFileSync(file, 'utf8').split('\n');
  const out = [];
  for (const line of lines) {
    if (line.replace(/\r$/, '').startsWith('## Agent')) {
      for (const bullet of bullets) out.push(`- ${bullet}`);
      out.push('');
    }
    out.push(line);
  }
  fs.writeFileSync(file, out.join('\n'));
}
