---
id: feature-002
type: feature
status: done
title: Still Cup theme foundation — design tokens and site chrome
date: 2026-11-12
scope: full
---

# Still Cup theme foundation — design tokens and site chrome

## Instructions

Human: add requirements as bullet points below.

-

- Build a minimal WooCommerce-compatible theme (or child theme) for Still Cup on the existing staging site (feature-001 / https://wordpress.yuanyizun.dev).
- Implement design tokens from Still-Cup-Developer-Pack specs.md: colours (#F6F2EB, #243A31, #E9E0D3, #DDE2D7, #CFCFC4, finish swatches), Newsreader + Inter fonts, spacing/gutters (desktop 64px, mobile 20px), breakpoint 1024px.
- Implement shared chrome only: shipping announcement bar, header with wordmark + nav + utility (search/account/bag), keyboard-operable mobile menu panel, and footer. Match delivery.md responsive rules.
- Activate the theme; leave homepage/shop/product/cart/checkout templates, catalogue data, shipping and payments for later features.
- Follow decisions.md exceptions that affect chrome (Cups in category nav labels when shown; ≥44px touch targets). Document reusable UI in vibe-coder/resource/ui/.
- Reference: vibe-coder/work/results/analysis-001.md step 3; Still-Cup-Developer-Pack requirements R01–R02, delivery.md, specs.md, design/HANDOFF.md.

## Agent

- Follow `vibe-coder/rules/feature.md` (attach that file; do not paste it here)
