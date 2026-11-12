# Still Cup — page templates

Theme version 0.5.0 · refactor-001 (layouts matched to `static_html_design`)

All template markup uses Tailwind utilities. Shared product/Woo leftovers live in `assets/src/css/overrides.css` — see `tailwind.md`.

## Home (`front-page.php`)

Desktop hero is a 570px band: copy on the left (~754/1440), image flush right. Mobile stacks copy, a full-width CTA, then a 330px image. Benefits are a centered desktop-only row. Featured heading sits with “Shop all cups ↗”; home cards show finish names on desktop and stack the price under the title on mobile. Story eyebrow and link are desktop-only.

## Shop

Intro + surface filter bar (All cups / Mugs / Tumblers) + sort. Product grid via Woo `ul.products`. Cards use a 422/390 image and “N finishes available”.

## Product

`content-single-product.php` grid. Mobile gallery is full-bleed (390/370); desktop image is 690/640. Finish attributes render as circles with a “Colour: …” label (`product.js`). Capacity stays a surface `<select>` (210px on desktop). Quantity is a − / + stepper. Details rows are open on desktop and collapsed accordions on mobile.

## Bag / Checkout

Bag line items use a 180px image on desktop, a surface quantity stepper, and a summary with a “Checkout” button. Checkout uses a reduced header. The form column is 730px and the summary is 476px; on mobile the summary comes first. Email sits above “Delivery details”. Shipping choices render in the left column; payment and “Pay {total}” sit there too. The summary holds the line, “Edit bag”, a discount field, and “Total AUD”.

## Supporting pages

`page.php` utilities shell; cart/checkout omit page H1.
