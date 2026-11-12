# Still Cup — site chrome

Theme: `wp-content/themes/still-cup` (v0.1.0)

## Tokens

CSS variables on `:root` in `assets/css/main.css` (mirrored in `theme.json` palette):

| Token | Value | Role |
|---|---|---|
| `--sc-color-page` | `#F6F2EB` | Page background |
| `--sc-color-primary` | `#243A31` | Text, buttons, announcement/footer |
| `--sc-color-hero` | `#E9E0D3` | Hero surfaces (later templates) |
| `--sc-color-story` | `#DDE2D7` | Story band (later) |
| `--sc-color-border` | `#CFCFC4` | Dividers / field borders |
| `--sc-color-summary` | `#E9E8DF` | Order summary (later) |
| `--sc-color-muted` | `#59645D` | Muted text |
| `--sc-color-sand/olive/chalk` | `#CBB89E` / `#7F8D70` / `#E5E0D7` | Finish swatches |
| `--sc-gutter` | 20px / 64px ≥1024 | Side gutters |
| `--sc-bp` | 1024px | Nav / layout switch |
| `--sc-touch` | 44px | Minimum control size |

Fonts: **Newsreader** (wordmark/headings), **Inter** (UI/body). Body line-height 1.5; inputs ≥16px.

## Components

### Announcement (`.sc-announcement`)
Full-bleed primary bar. Text from Customizer → Still Cup chrome → Announcement bar (`still_cup_announcement` theme mod).

### Header (`.sc-header`)
- Wordmark → home
- Desktop (≥1024): primary nav (Shop all, Mugs, Cups, Tumblers), Search / Account / Bag
- Mobile (<1024): Menu toggle, centred wordmark, Bag; search/account in panel or utilities as styled
- Inner pages (`body.sc-has-header-rule`): 1px border under header inner (Pencil nav divider)

### Mobile nav (`.sc-mobile-nav`)
Dialog panel; open/close buttons; Escape + backdrop click; focus trap; focus returns to Menu. Script: `assets/js/navigation.js`.

### Search (`.sc-search`)
Toggle panel; GET `/?s=`; Close control.

### Footer (`.sc-footer`)
Primary band; brand; placeholder links (Our story, Care, Shipping & returns, Contact, Privacy, Terms); copyright line. Override with Footer menu location when assigned.

## Classes cheat-sheet

`sc-announcement`, `sc-header`, `sc-nav`, `sc-mobile-nav`, `sc-search`, `sc-footer`, `sc-shell`, `sc-main`, `sc-skip-link`
