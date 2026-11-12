# Analysis rules (agent)

- Do **not** create `vibe-coder/work/plans/{id}.md`
- Investigate the brief’s `## Question`; do **not** replace the brief with the full write-up
- **Results** — write findings and a clear recommendation to `vibe-coder/work/results/{id}.md`; humans never edit
- Do **not** edit any `catalog.md` by hand — use the CLI (see `vibe-coder/rules/catalog.md`)
- After creating/updating results:
  `npx vibe catalog sync {id}`
- When finished:
  `npx vibe done {id} --summary "<one-line summary>"`
