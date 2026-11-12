# Still Cup — page templates

Theme version 0.2.1 · fix-001

## Home (`front-page.php`)

| Block | Classes | Edit |
|---|---|---|
| Hero | `.sc-hero` | Customizer → Still Cup homepage |
| Benefits | `.sc-benefits` | Customizer |
| Featured | `.sc-featured`, `.sc-product-grid--featured` | WooCommerce **Featured** products (fallback: latest 3) |
| Story | `.sc-story` | Customizer |

Responsive: hero copy before image &lt;1024px; featured 2 cols mobile / 3 desktop. Cards use `.sc-card__row` (title + price).

## Shop

Intro `.sc-shop-intro`: eyebrow “The collection”, heading “Find your kind of cup.”, supporting copy. Toolbar `.sc-shop-toolbar`: slash filters All cups / Mugs / Cups / Tumblers + bordered sort. Count `.sc-shop-count`. Product cards `.sc-card` with title/price row. Six products per page; 3/2/1 columns. Header rule via `body.sc-has-header-rule`.

## Product

`.sc-product` grid: breadcrumb → gallery (690) + summary → `.sc-product-details` rows (Details / Care / Shipping & returns). Photo note under gallery; stock + shipping notes in summary. Finish swatches / capacity chips via `assets/js/product.js`. Add to bag CTA includes price. Mobile details use accordion (`sc-product-details--accordion`). Optional meta: `_sc_collection`, `_sc_details`, `_sc_care`, `_sc_shipping`.

## Bag / Checkout

Cart page skips page H1; bag templates own the heading. Filled bag `.sc-bag` two-column layout (items + `.sc-bag-summary` “Order summary”). Empty bag `.sc-bag--empty` + Shop cups CTA. Threshold message `.sc-bag__threshold`. Checkout `.sc-checkout` with Pencil heading + `.sc-checkout__layout` (summary first on mobile). Thank-you `.sc-order-result`.

## Supporting pages

`page.php` → `.sc-page` long-copy shell (cart/checkout use `.sc-woo-page` without page title).

## CSS

`assets/css/templates.css` (depends on `main.css` tokens). Woo price/notice colours overridden to primary in `main.css`.
