# Still Cup — customer requirements

Version 1.3 · 12 November 2026 · Fictional practice project

## My request as your customer
I run Still Cup, a small Australian ceramic cup brand. I want a calm, premium shop that makes my products the focus. Customers should be able to find a cup, select its finish and capacity, pay, and receive confirmation without contacting me. After launch, I want to manage the shop and edit content myself without coding.

All products, prices, business details and fulfilment promises in this exercise are fictional requirements. Stock photography is mood and layout reference only, not evidence of actual products, materials, provenance or finishes. Replace it before launch.

## Required launch scope
| ID | Requirement | Acceptance condition |
|---|---|---|
| R01 | WordPress + WooCommerce | Owner can manage content and products through the dashboard. |
| R02 | Responsive storefront | Usable from 320px mobile width through desktop, with no horizontal overflow. |
| R03 | Six launch products | Categories: Mugs, Cups, Tumblers. Product cards link to the right product. |
| R04 | Product options | Finish and capacity select a real variation; price, image and stock reflect the selection. |
| R05 | Shopping bag | Add, change quantities and remove items; totals update correctly. Bag persists across page navigation. |
| R06 | Guest checkout | Account creation is optional. Existing customers can sign in. |
| R07 | Card payments | Stripe processes supported credit/debit cards, including required authentication. |
| R08 | PayPal | Customer can choose PayPal and return to an accurate order result. |
| R09 | Shipping | Australia only; standard $9.95; free standard shipping when discounted merchandise subtotal is at least $100. |
| R10 | Inventory | Stock tracked per variation; backorders disabled; unavailable variations cannot be purchased. |
| R11 | Coupons | Owner can create percentage or fixed discounts, limits and expiry dates. |
| R12 | Order emails | Customer receives order confirmation and relevant status emails; owner receives new-order notification. |
| R13 | Owner workflow | Owner can update photos, prices, stock, descriptions, orders, coupons and homepage content. |
| R14 | Supporting pages | Our story, Contact, Care guide, Shipping & returns, Privacy, Terms. |
| R15 | Search and accounts | Product search; customer account for orders, addresses and password reset. |

Bank card payments are handled through Stripe. Direct bank transfer is not part of launch scope. No subscriptions, wholesale portal, product personalisation, artwork uploads, gift cards, multilingual content or international shipping at launch.

## Catalogue for the exercise
| Product | Category | Capacity | Price AUD | Finishes |
|---|---|---|---|---|
| Everyday Mug | Mugs | 300 / 400 ml | $32 / $36 | Sand, Olive, Chalk |
| Slow Morning Cup | Cups | 250 ml | $28 | Sand, Olive, Chalk |
| Studio Tumbler | Tumblers | 300 ml | $30 | Sand, Olive, Chalk |
| Tall Ritual Mug | Mugs | 450 ml | $38 | Sand, Chalk |
| Espresso Pair | Cups | 2 × 90 ml | $42 per pair | Sand, Olive |
| Daily Tumbler | Tumblers | 400 ml | $34 | Olive, Chalk |

Owner supplies actual SKU, variation stock, product weight, dimensions, care claims and photography before production. Use a clearly identified test dataset on staging; do not invent real inventory. Product example in the designs: Everyday Mug / Sand / 300 ml / quantity 1 = $32 + $9.95 shipping = $41.95.

Delivery promise for this exercise: dispatch in 2–3 business days, then standard delivery estimated at 3–7 business days. Owner must approve these promises and all policies before launch. Owner/accountant supplies tax registration and tax configuration; do not add tax twice to the displayed example prices.

## What I need to manage myself
- Add or retire products; edit variation options, photos, descriptions, prices and stock.
- See paid/unpaid orders, update fulfilment status and add tracking details when available.
- Issue supported refunds and understand the difference between updating order records and returning money.
- Create coupons and edit homepage hero text, link, featured products and story copy.
- Edit supporting pages and view enquiries.

Use editable blocks/templates and standard WooCommerce data. Provide Shop Manager access for daily work and a customer-owned administrator account. Do not make routine changes depend on editing PHP or a hard-coded homepage.

## Owner-supplied items before production
- Domain and hosting account access through invitations, where supported.
- Customer-owned Stripe and PayPal accounts, verification and payout setup.
- Actual product photography, product data and inventory.
- Approved brand/story text, contact email and business details.
- Shipping destinations/rates/exclusions and final returns policy.
- Tax configuration approved by the owner/accountant and approved privacy/terms text.

## Related documents

Exact design values: [specs.md](specs.md). Implementation behaviour: [delivery.md](delivery.md). Sign-off: [acceptance.md](acceptance.md).
