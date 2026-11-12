# Feature rules (agent)

- **Plan** — create and maintain `vibe-coder/work/plans/{id}.md` (use `vibe-coder/templates/plan.md`); humans never edit
- Implement according to the plan and the brief’s `## Instructions`
- Search `vibe-coder/resource/ui/` before designing new UI; after new UI is used, document it there
- **Results** — write `vibe-coder/work/results/{id}.md` after implementation (use `vibe-coder/templates/results.md`); humans never edit
- Do **not** edit any `catalog.md` by hand — use the CLI (see `vibe-coder/rules/catalog.md`)
- After creating/updating plan and/or results:
  `npx vibe catalog sync {id}`
- When finished:
  `npx vibe done {id} --summary "<one-line summary>"`
