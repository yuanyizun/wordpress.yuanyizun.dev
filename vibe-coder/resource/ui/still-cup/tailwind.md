# Still Cup — Tailwind CSS (full move)

Theme version 0.5.0 · refactor-001

## Setup

From `wp-content/themes/still-cup`:

```bash
npm install
npm run build   # → assets/css/app.css (committed)
npm run watch
```

| Path | Role |
|---|---|
| `assets/src/css/app.css` | Tailwind entry (`@theme`, custom variants) |
| `assets/src/css/overrides.css` | Tokens, base, body hooks, Woo/JS leftovers only |
| `assets/css/app.css` | Built stylesheet (`still-cup-app`) |

**Deleted:** `assets/css/main.css`, `assets/css/templates.css` — do not recreate. Style in PHP/JS with utilities.

Preflight is **off**. Base body/link/focus live in `overrides.css` inside `@layer base`. Woo leftovers stay **unlayered** so they still beat utilities.

**Link colours:** `theme.json` sets `elements.link.color` to `inherit`. WordPress global-styles still emits unlayered `a:where(:not(.wp-element-button))`, which beats `@layer utilities` — so `overrides.css` bridges `a.text-inverse` / `a.text-primary` / `a.text-muted` / `a.text-inherit`. Prefer those utilities (or `!text-inverse`) on primary CTAs; do not rely on layered `text-*` alone for anchors.

Body is a column flex container (`min-height: 100dvh`); `main { flex: 1 }` pins the footer on short pages.

## Rule

| Prefer | Use for |
|---|---|
| **Tailwind utilities in PHP/JS** | Almost all layout, spacing, type, colour |
| **`overrides.css` `@layer base`** | Reset, body sticky-footer shell, link/focus defaults |
| **`overrides.css` unlayered** | `:root` gutter tokens; `body.sc-menu-open` / `sc-has-header-rule`; Woo floats/notices/forms; variation `.is-selected`; product details `[data-accordion]` |

Hook classes still used on purpose (not BEM skins): `sc-header-inner`, `sc-product`, `sc-bag-items`, `sc-bag-summary`, `sc-details-*`, `sc-swatch` / `sc-chip`.

## Variants

| Variant | Meaning |
|---|---|
| `desktop:` | ≥1024px |
| `sc-shop:` | descendant of `body.sc-is-shop` |

## Token → utility

| Role | Utility |
|---|---|
| Page / primary / surface / hero / story / summary | `bg-page`, `text-primary`, `bg-hero`, … |
| Muted / border / finishes | `text-muted`, `border-border`, `bg-sand` |
| Fonts | `font-display`, `font-body` |
| Widths | `max-w-content`, `max-w-prose-page` |
| Touch | `min-h-touch`, `min-w-touch` |
| Gutters | `px-[var(--sc-gutter)]` (20→64 at desktop via `:root`) |

Dynamic PHP/JS classes must appear as **complete** strings in source for the scanner.
