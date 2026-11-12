# Still Cup — site chrome

Theme: `wp-content/themes/still-cup` (v0.4.2)

Chrome markup uses **Tailwind utilities** (see `tailwind.md`). Built CSS: `assets/css/app.css`.

## Tokens

`:root` in `assets/src/css/overrides.css` (mirrored in `theme.json` + `@theme`):

| Token | Value | Role |
|---|---|---|
| `--sc-color-page` | `#F6F2EB` | Page background |
| `--sc-color-primary` | `#243A31` | Text, buttons, announcement/footer |
| `--sc-color-hero` | `#E9E0D3` | Hero surfaces |
| `--sc-color-story` | `#DDE2D7` | Story band |
| `--sc-color-border` | `#CFCFC4` | Dividers / field borders |
| `--sc-color-summary` | `#E9E8DF` | Order summary |
| `--sc-color-muted` | `#59645D` | Muted text |
| `--sc-color-sand/olive/chalk` | `#CBB89E` / `#7F8D70` / `#E5E0D7` | Finish swatches |
| `--sc-gutter` | 20px / 64px ≥1024 | Side gutters |
| `--sc-touch` | 44px | Minimum control size |

Fonts: **Newsreader** (wordmark/headings), **Inter** (UI/body).

`theme.json` link colour is **inherit** (not primary) so announcement/footer chrome and Tailwind `text-inverse` CTAs are not forced to primary green.

## Components

### Announcement
Full-bleed primary bar. Text from Customizer → Still Cup chrome → Announcement bar.

### Header
Utilities on `header.php`. Inner uses hook class `sc-header-inner` for `body.sc-has-header-rule` bottom border. Desktop nav via `still_cup_render_primary_nav( 'desktop' )`; mobile via `'mobile'`.

### Mobile nav / search
IDs unchanged for `navigation.js`: `sc-menu-open`, `sc-menu-close`, `sc-mobile-nav`, `sc-search-open`, `sc-search-close`, `sc-search-panel`, `sc-search-field`. Body gets `sc-menu-open` while open.

### Footer
Utilities on `footer.php`; footer menu links get classes via `still_cup_link_class`.
