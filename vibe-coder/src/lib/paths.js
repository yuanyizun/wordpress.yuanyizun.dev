import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { WORK_DIR, TEMPLATES_DIR, RULES_DIR, TYPES } from './constants.js';
import { NotesError } from './errors.js';

const HERE = path.dirname(fileURLToPath(import.meta.url));

/** Package root = directory containing package.json (parent of src/) */
export function defaultRoot() {
  return path.resolve(HERE, '../..');
}

export function resolveRoot(root) {
  return path.resolve(root ?? defaultRoot());
}

export function typeDirPath(root, type) {
  if (!TYPES.includes(type)) throw new NotesError(`Unknown type: ${type}`);
  return path.join(root, WORK_DIR, type);
}

export function plansDirPath(root) {
  return path.join(root, WORK_DIR, 'plans');
}

export function resultsDirPath(root) {
  return path.join(root, WORK_DIR, 'results');
}

export function planPath(root, id) {
  return path.join(plansDirPath(root), `${id}.md`);
}

export function resultsPath(root, id) {
  return path.join(resultsDirPath(root), `${id}.md`);
}

export function briefPath(root, type, id) {
  return path.join(typeDirPath(root, type), `${id}.md`);
}

export function typeCatalogPath(root, type) {
  return path.join(typeDirPath(root, type), 'catalog.md');
}

export function plansCatalogPath(root) {
  return path.join(plansDirPath(root), 'catalog.md');
}

export function resultsCatalogPath(root) {
  return path.join(resultsDirPath(root), 'catalog.md');
}

export function templatesDir(root) {
  return path.join(root, TEMPLATES_DIR);
}

export function rulesDir(root) {
  return path.join(root, RULES_DIR);
}

export function rulesPath(root, name) {
  return path.join(rulesDir(root), name.endsWith('.md') ? name : `${name}.md`);
}

export function uiDir(root) {
  return path.join(root, 'resource', 'ui');
}
