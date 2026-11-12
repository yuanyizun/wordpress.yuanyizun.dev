# Catalog rules (agent)

Do **not** hand-edit any `catalog.md`. All catalog writes go through the CLI.

From the package root (`vibe-coder/`):

```bash
npm install   # once

# After creating/updating plan and/or results
npx vibe catalog sync {id}

# Force results Summary cell
npx vibe catalog sync {id} --summary "one-line summary"

# Patch brief status only, then sync
npx vibe catalog status {id} <status>

# Preferred close-out
npx vibe done {id} --summary "one-line summary"
```

Equivalent: `npm exec vibe -- catalog sync {id}` or `npm run vibe -- catalog sync {id}`.

Catalogs exist under:

- `vibe-coder/work/{feature,fix,analysis,refactor,qa}/catalog.md`
- `vibe-coder/work/plans/catalog.md`
- `vibe-coder/work/results/catalog.md`

`Created` is set on insert and preserved on later upserts.
