# Feature (minor) rules (agent)

- Do **not** create `vibe-coder/work/plans/{id}.md`
- Implement according to the brief’s `## Instructions`
- Search `vibe-coder/resource/ui/` before designing new UI; after new UI is used, document it there
- **Results** — write `vibe-coder/work/results/{id}.md` after implementation; humans never edit
- Do **not** edit any `catalog.md` by hand — use the CLI (see `vibe-coder/rules/catalog.md`)
- After creating/updating results:
  `npx vibe catalog sync {id}`
- When finished:
  `npx vibe done {id} --summary "<one-line summary>"`
