# Results file rules (agent)

Results under `vibe-coder/work/results/` are **AI-only**. Humans never edit them.

- Create from `vibe-coder/templates/results.md` after implementation, analysis, or QA
- Keep `## Summary` accurate — catalog sync may use it when `--summary` is omitted
- After saving the results file:
  `npx vibe catalog sync {id}`
  or close out with `npx vibe done {id} --summary "<one-line summary>"`
- Never hand-edit `vibe-coder/work/results/catalog.md` (see `vibe-coder/rules/catalog.md`)
