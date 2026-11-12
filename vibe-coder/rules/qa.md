# QA rules (agent)

- Do **not** create `vibe-coder/work/plans/{id}.md`
- Execute against the brief’s `## Instructions` (scope / cases)
- **Results** — write findings, pass/fail notes, and recommendations to `vibe-coder/work/results/{id}.md`; humans never edit
- Do **not** edit any `catalog.md` by hand — use the CLI (see `vibe-coder/rules/catalog.md`)
- After creating/updating results:
  `npx vibe catalog sync {id}`
- When finished:
  `npx vibe done {id} --summary "<one-line summary>"`
