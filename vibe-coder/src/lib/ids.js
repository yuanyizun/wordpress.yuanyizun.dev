import fs from 'node:fs';
import { PREFIX, TYPES } from './constants.js';
import { NotesError } from './errors.js';
import { typeDirPath } from './paths.js';

export function typeToPrefix(type) {
  const prefix = PREFIX[type];
  if (!prefix) throw new NotesError(`Unknown type: ${type}`);
  return prefix;
}

export function idToType(id) {
  if (id.startsWith('feature-')) return 'feature';
  if (id.startsWith('fix-')) return 'fix';
  if (id.startsWith('analysis-')) return 'analysis';
  if (id.startsWith('refactor-')) return 'refactor';
  if (id.startsWith('qa-')) return 'qa';
  throw new NotesError(`Cannot infer type from id: ${id}`);
}

/** Alias used by path helpers — folder matches type name */
export function idToTypeDir(id) {
  return idToType(id);
}

export function isValidId(type, id) {
  const prefix = PREFIX[type];
  if (!prefix) return false;
  return new RegExp(`^${prefix}-\\d+$`).test(id);
}

export function assertValidId(type, id) {
  if (!isValidId(type, id)) {
    throw new NotesError(`Invalid ID: ${id} (expected ${typeToPrefix(type)}-<number>)`);
  }
}

export function nextId(root, type) {
  if (!TYPES.includes(type)) throw new NotesError(`Unknown type: ${type}`);
  const prefix = typeToPrefix(type);
  const dir = typeDirPath(root, type);
  let max = 0;
  if (fs.existsSync(dir)) {
    for (const name of fs.readdirSync(dir)) {
      if (!name.startsWith(`${prefix}-`) || !name.endsWith('.md')) continue;
      const suffix = name.slice(prefix.length + 1, -3);
      if (!/^\d+$/.test(suffix)) continue;
      const num = Number.parseInt(suffix, 10);
      if (num > max) max = num;
    }
  }
  return `${prefix}-${String(max + 1).padStart(3, '0')}`;
}
