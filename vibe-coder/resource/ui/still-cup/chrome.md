# Still Cup — site chrome

Theme: `wp-content/themes/still-cup` (v0.5.0)

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
Home only. Full-bleed primary bar, 30px mobile / 32px desktop. Hidden on shop, product, bag, and checkout.

### Header
Utilities on `header.php`. Inner uses hook class `sc-header-inner`. Inner pages (`body.sc-has-header-rule`, everything except the front page) draw an inset bottom rule via a 1px gradient, aligned to the content width. Desktop nav via `still_cup_render_primary_nav( 'desktop' )`; mobile via `'mobile'`. Default links: Shop all, Mugs, Tumblers, Our story.

Checkout (not the thank-you page) replaces the nav with the wordmark and “Secure checkout”, plus “← Return to bag” on desktop.

### Mobile nav / search
IDs unchanged for `navigation.js`: `sc-menu-open`, `sc-menu-close`, `sc-mobile-nav`, `sc-search-open`, `sc-search-close`, `sc-search-panel`, `sc-search-field`. The menu control shows ☰. Body gets `sc-menu-open` while open. Checkout does not render the menu or search.

### Footer
Utilities on `footer.php`. Desktop shows the wordmark, link row, and “© Still Cup · AUD · PayPal / Visa / Mastercard”. Mobile hides the wordmark. Default links: Contact, Shipping & returns, Care guide, Privacy, Terms.
