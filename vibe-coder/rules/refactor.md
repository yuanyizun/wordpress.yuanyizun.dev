# Refactor rules (agent)

- Do **not** create `vibe-coder/work/plans/{id}.md`
- Implement the refactor according to the brief’s `## Instructions`
- If UI is touched: search `vibe-coder/resource/ui/` first; document new UI there after use
- **Results** — write `vibe-coder/work/results/{id}.md` after the refactor; must include files changed and verification steps; humans never edit
- Do **not** edit any `catalog.md` by hand — use the CLI (see `vibe-coder/rules/catalog.md`)
- After creating/updating results:
  `npx vibe catalog sync {id}`
- When finished:
  `npx vibe done {id} --summary "<one-line summary>"`
