# Still Cup — page templates

Theme version 0.2.0 · feature-003

## Home (`front-page.php`)

| Block | Classes | Edit |
|---|---|---|
| Hero | `.sc-hero` | Customizer → Still Cup homepage |
| Benefits | `.sc-benefits` | Customizer |
| Featured | `.sc-featured`, `.sc-product-grid--featured` | WooCommerce **Featured** products (fallback: latest 3) |
| Story | `.sc-story` | Customizer |

Responsive: hero copy before image &lt;1024px; featured 2 cols mobile / 3 desktop.

## Shop

Toolbar `.sc-shop-toolbar`: filters All cups / Mugs / Cups / Tumblers + sort. Product cards `.sc-card`. Six products per page; 3/2/1 columns.

## Product

`.sc-product` gallery + summary + `.sc-product__details`. Finish swatches / capacity chips via `assets/js/product.js` (`.sc-variation-ui`). Defaults prefer Sand / Everyday Mug 300 ml when purchasable.

## Bag / Checkout

Classic shortcodes on Cart/Checkout pages. Empty bag CTA `.sc-bag-empty` → Shop cups. Checkout `.sc-checkout__layout` (summary first on mobile). Thank-you `.sc-order-result`.

## Supporting pages

`page.php` → `.sc-page` long-copy shell.

## CSS

`assets/css/templates.css` (depends on `main.css` tokens).
