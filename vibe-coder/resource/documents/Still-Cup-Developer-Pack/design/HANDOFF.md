# Still Cup — designer-to-developer handoff

Design version 1.3 · 12 November 2026

## Primary deliverable

Open [source/Still-Cup-Design.pen](source/Still-Cup-Design.pen) in Pencil using File → Open. This is the editable design master. Select layers to inspect measurements and styles; use [specs.md](../specs.md) as the exported reference for exact values. Source layer names correspond to the screen index in [delivery.md](../delivery.md).

## Included artboards

| Artboard | Size, px |
|---|---|
| 01 Home · Desktop | 1440 × 1780 |
| 02 Product · Desktop | 1440 × 1110 |
| 03 Shop · Desktop | 1440 × 1100 |
| 04 Bag · Desktop | 1440 × 900 |
| 05 Checkout · Desktop | 1440 × 1380 |
| 06 Home · Mobile 390 | 390 × 1580 |
| 07 Product · Mobile 390 | 390 × 1340 |
| 08 Checkout · Mobile 390 | 390 × 1780 |

## Designer's direction

A quiet ceramic storefront: warm off-white surfaces, dark green text/actions, restrained sage panels, Newsreader headings and Inter body text. Keep the product imagery prominent and the route from product selection to payment clear. Repeated headers, buttons and fields should become shared implementation components. The design master currently uses named layers rather than formal reusable Pencil components.

## Implementation references

- [Customer requirements](../requirements.md) define what the shop must do.
- [Exact specifications](../specs.md) define the current drawn appearance.
- [Delivery instructions](../delivery.md) define interactions and responsive behaviour.
- [Decisions](../decisions.md) record implementation corrections to schematic controls.
- [Acceptance checklist](../acceptance.md) defines later testing and owner sign-off.

## Source dependencies and review status

Reference photos are external image fills, not final product photography. Inter and Newsreader are named fonts; font binaries are not bundled. Replace the images with approved product assets during development and confirm product claims and business data.

This fictional client brief is ready for development review. Customer approval and implementation acceptance have not been recorded. Supporting pages, mobile Shop/Bag, and additional interaction states are specified in writing, not additional high-fidelity artboards. Do not interpret their absence as removal from the agreed scope.

Separate artboard PNG/PDF exports remain unavailable because Pencil's export command failed. The native layered design is included and the old screenshots have been removed.
