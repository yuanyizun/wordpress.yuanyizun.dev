---
id: feature-003
type: feature
status: done
title: Still Cup page templates — Home, Shop, Product, Bag, Checkout
date: 2026-11-12
scope: full
---

# Still Cup page templates — Home, Shop, Product, Bag, Checkout

## Instructions

Human: add requirements as bullet points below.

-

- Implement WooCommerce-compatible page templates in the still-cup theme to match Still-Cup-Developer-Pack artboards and delivery.md responsive/interaction rules (analysis-001 step 4).
- Home: block-editable layout — hero (text before image on mobile), benefits strip, featured products (3 desktop / 2 mobile), story band — owner can edit hero text/link and featured selection without PHP.
- Shop: category filters (All cups, Mugs, Cups, Tumblers), sort (Featured, price asc/desc, Latest), product cards linking to products, 6 per page, 3/2/1 columns by breakpoint; follow decisions.md (Cups in filters; drop page-2 control when ≤6 results).
- Product: gallery, finish swatches with labels + selected outline, capacity options, price/stock/qty/add-to-bag, details accordions (collapsed on mobile); Sand/300 ml defaults per delivery when purchasable.
- Bag and Checkout: layout and chrome from Pencil (summary placement desktop vs mobile); use native Woo fields (separate State/Postcode, optional address line 2). Order-result thank-you styling. Thin page.php for supporting pages.
- Out of scope: real six-product catalogue dataset (next feature), shipping rates, Stripe/PayPal, coupons. Use placeholders or whatever products exist. Document new UI in vibe-coder/resource/ui/still-cup/.
- Reference: specs.md, delivery.md, decisions.md, design/HANDOFF.md, feature-002 chrome, analysis-001.

## Agent

- Follow `vibe-coder/rules/feature.md` (attach that file; do not paste it here)
