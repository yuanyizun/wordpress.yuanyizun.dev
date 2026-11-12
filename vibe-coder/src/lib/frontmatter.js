import fs from 'node:fs';
import { NotesError } from './errors.js';

export function getFmValue(file, key) {
  const text = fs.readFileSync(file, 'utf8');
  let fm = 0;
  for (const line of text.split(/\n/)) {
    if (line.replace(/\r$/, '') === '---') {
      fm += 1;
      if (fm >= 2) break;
      continue;
    }
    if (fm !== 1) continue;
    const raw = line.replace(/\r$/, '');
    const prefix = `${key}:`;
    if (!raw.startsWith(prefix)) continue;
    return raw.slice(prefix.length).trimStart().replace(/^["']/, '').replace(/["']$/, '');
  }
  return '';
}

/** Patch a single key inside the first YAML frontmatter block */
export function setFmValue(file, key, value) {
  if (!fs.existsSync(file)) throw new NotesError(`File not found: ${file}`);
  const text = fs.readFileSync(file, 'utf8');
  const lines = text.split(/\n/);
  let fm = 0;
  let found = false;
  const out = [];
  for (const line of lines) {
    const raw = line.replace(/\r$/, '');
    if (raw === '---') {
      fm += 1;
      out.push(line);
      continue;
    }
    if (fm === 1 && !found && raw.startsWith(`${key}:`)) {
      out.push(`${key}: ${value}`);
      found = true;
      continue;
    }
    out.push(line);
  }
  if (fm < 2) throw new NotesError(`No frontmatter in: ${file}`);
  if (!found) throw new NotesError(`Frontmatter key not found: ${key}`);
  fs.writeFileSync(file, out.join('\n'));
}

export function localDate(now = new Date()) {
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day = String(now.getDate()).padStart(2, '0');
  return `${now.getFullYear()}-${month}-${day}`;
}

/** Extract first ## Summary section body (one line for catalog) */
export function extractSummary(file) {
  if (!fs.existsSync(file)) return '';
  const text = fs.readFileSync(file, 'utf8');
  const lines = text.split(/\n/);
  let inSummary = false;
  const parts = [];
  for (const line of lines) {
    const raw = line.replace(/\r$/, '');
    if (raw.startsWith('## ')) {
      if (inSummary) break;
      inSummary = raw === '## Summary';
      continue;
    }
    if (!inSummary) continue;
    const trimmed = raw.trim();
    if (!trimmed) {
      if (parts.length) break;
      continue;
    }
    parts.push(trimmed);
  }
  return parts.join(' ').trim();
}
