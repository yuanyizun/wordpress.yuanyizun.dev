# Still Cup — page templates

Theme version 0.4.2 · feature-004 (full Tailwind) + fix-002

All template markup uses Tailwind utilities. Shared product/Woo leftovers live in `assets/src/css/overrides.css` — see `tailwind.md`.

## Home (`front-page.php`)

Hero (`bg-hero`), benefits strip, featured grid, story (`bg-story`). Customizer still drives copy/image. Product cards from `content-product.php`.

## Shop

Intro + slash filters + sort from `inc/woocommerce.php`. Product grid via Woo `ul.products` (grid in overrides). Cards: `content-product.php` (`sc-shop:` aspect/title tweaks).

## Product

`content-single-product.php` grid + `sc-product` hook for Woo gallery/title/price/form. Details accordion: `product-details.php` + `product.js` (`data-accordion`). Variations: Tailwind classes emitted from `product.js` + `.is-selected` in overrides.

## Bag / Checkout

Cart/checkout templates use utilities; bag totals use `sc-bag-summary` / `sc-bag-items` hooks for Woo table float resets. Checkout summary `order-first` on mobile.

## Supporting pages

`page.php` utilities shell; cart/checkout omit page H1.
