# vibe-coder

AI-driven workflow CLI. The package root is **`vibe-coder/`** — agent paths, rules, and templates all use that prefix (not `notes/`).

**Humans** edit only `## Instructions` or `## Question` in briefs.  
**AI** owns YAML frontmatter, plans, results, and all catalogs (via CLI only).  
Briefs point at `vibe-coder/rules/{type}.md` — attach that file; do not paste contracts into the brief.

Requires **Node.js 20.12+**. CLI: `npx vibe`.

## Quick start

```bash
cd vibe-coder
npm install
npx vibe                 # interactive menu (TTY)
npx vibe init            # ensure folders + seven catalogs
npx vibe new feature "Comment embed widget"
```

Also: `npm run vibe -- <args>` or `npm exec vibe -- <args>`.

## Ownership

| Area | Who | Edits |
|------|-----|--------|
| Brief body (`## Instructions` / `## Question`) | Human | Body only |
| Brief YAML frontmatter | AI (CLI seeds on create) | Header fields |
| `vibe-coder/work/plans/`, `vibe-coder/work/results/` | AI only | Full files |
| Every `catalog.md` | AI via CLI only | Never hand-edit |
| `vibe-coder/rules/` | Maintainers / workflow authors | Agent contracts |

## Workflow types

| Type | ID prefix | Plan? | Human section |
|------|-----------|-------|---------------|
| `feature` (full) | `feature-NNN` | Yes | Instructions |
| `feature` (`--minor`) | `feature-NNN` | No | Instructions |
| `fix` | `fix-NNN` | No | Instructions |
| `analysis` | `analysis-NNN` | No | Question |
| `refactor` | `refactor-NNN` | No | Instructions |
| `qa` | `qa-NNN` | No | Instructions |

There is **no** `feat` alias — use `feature`.

## Catalog CLI (agents)

Do not edit catalog tables in the editor. From `vibe-coder/`:

```bash
npx vibe catalog sync feature-001
npx vibe catalog sync feature-001 --summary "Added embed widget"
npx vibe catalog status feature-001 in-progress
npx vibe done feature-001 --summary "Added embed widget"
```

`catalog sync` upserts the type catalog from the brief + plan/results on disk; upserts plans/results catalogs when those files exist. `Created` is set on insert and preserved on update.

See `vibe-coder/rules/catalog.md` and the per-type rule files under `vibe-coder/rules/`.

## Layout

```
vibe-coder/
├── bin/vibe.js           # package bin shim → src/cli.js
├── src/                  # Commander CLI + lib + Clack menu
├── templates/            # slim briefs (+ plan/results scaffolding)
├── rules/                # full agent contracts
├── work/{feature,fix,analysis,refactor,qa,plans,results}/
├── resource/{keys,images,files,documents,ui}/
└── skills/               # host-specific; gitignored by default
```

No top-level `documents/` or `UI/`. UI lives at `vibe-coder/resource/ui/`; documents at `vibe-coder/resource/documents/`.

## Commands

| Command | Behavior |
|---------|----------|
| `(default)` / `menu` | Clack UI if TTY; else help |
| `init` | Work dirs + seven catalogs + resource tree |
| `new <type> <title>` | Human brief types; `--id`, `--minor`, `--force`, `--bullet` |
| `catalog sync <id>` | Upsert catalogs; optional `--summary` |
| `catalog status <id> <status>` | Patch status + sync |
| `done <id> --summary <text>` | Close-out helper |
| `list [type]` | Dump catalogs |
| `show <id>` / `open <id>` | Paths + status |

## Agent attach model

1. Human fills the brief body under `vibe-coder/work/{type}/`.
2. Agent reads the brief’s single `## Agent` pointer → attaches `vibe-coder/rules/{type}.md`.
3. Agent follows that rules file (skills/resource as required), writes plan/results under `vibe-coder/work/`, then runs `npx vibe catalog sync` / `npx vibe done`.
