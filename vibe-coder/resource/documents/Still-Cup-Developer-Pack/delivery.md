# Still Cup — developer delivery instructions

## Pencil screen index
The Pencil canvas contains named frames, in this order:

| Frame | Node | Purpose |
|---|---|---|
| 01 Home · Desktop | bi8Au | Brand, hero, featured products, story and footer |
| 02 Product · Desktop | nrpry | Gallery, variations, stock, quantity, add to bag and details |
| 03 Shop · Desktop | x8DQP | Category controls, sort, results and pagination |
| 04 Bag · Desktop | H58YO6 | Line item, quantity, shipping estimate and checkout |
| 05 Checkout · Desktop | P3vyT | Contact, delivery, payment and order summary |
| 06 Home · Mobile 390 | iOcpQ | Stacked hero and two-column product previews |
| 07 Product · Mobile 390 | mIRY5 | Mobile product selection and purchase controls |
| 08 Checkout · Mobile 390 | dzIY3 | Single-column form and payment selection |

Desktop frames are 1440px wide. Mobile frames are 390px wide. Designs are static references, not an interactive prototype. Supporting pages, account screens, menu/search panels, empty/error states and confirmation page use the rules below and standard WooCommerce behaviour; they do not have separate high-fidelity frames. On the product desktop frame the expanded details rows show content; mobile uses collapsed accordions.

## Responsive rules
- At 1024px and above, use desktop navigation and a two-column product/checkout layout.
- Below 1024px, use the mobile menu and stack complex layouts when space requires it; do not compress the desktop navigation.
- Home hero: text before image on mobile. Featured products: two columns on mobile and three on desktop.
- Shop: three columns on desktop, two on mobile where readable; one column if 320px width requires it. Show six items per page. Pencil displays three sample cards to establish styling; remove the illustrative page 2 control when all six products fit on the first page.
- Mobile bag stacks image/details above totals. Checkout summary appears before the contact form; desktop summary sits to the right. Keep payment and final total close to the submit action.
- Forms use separate State and Postcode fields and an optional Address line 2. Desktop Pencil combines State/postcode as a space illustration; implementation should use separate native WooCommerce fields. Phone is optional unless the selected carrier requires it.
- Mobile gallery supports swipe plus accessible buttons. Product photos should use consistent crops without cutting off the product. Do not stretch images.

## Interaction and state requirements
Navigation: wordmark goes home; Shop all goes to shop; category navigation filters the catalogue. Menu opens a keyboard-operable panel with visible close control and returns focus to its trigger. Search supports submitting a query, matching results and no-results guidance.

Shop: categories All cups, Mugs, Cups, Tumblers; sorting Featured, Price low to high, Price high to low, Latest. Use a clear active filter state and reset control. Product cards open their product; variation selection happens on the product page.

Product: Sand is the initial finish only when that variation exists and is purchasable. For Everyday Mug, 300 ml is the initial capacity. Colour swatches have text labels and a visible selected outline; colour alone must not convey selection. Changing to 400 ml updates price to $36 and updates the add-to-bag total. Quantity must be a positive integer within stock. Adding successfully updates the bag count and announces success with a View bag link. Missing choices, insufficient stock and request failures show specific messages. Sold-out variations are marked unavailable; do not silently substitute an option. Single-capacity products show capacity as text.

Bag: plus/minus and remove recalculate line totals, discounts, shipping and total. Free-shipping message uses the discounted merchandise subtotal. Before an address is provided, shipping is an estimate; confirm eligibility at checkout. Empty bag offers a Shop cups action. Invalid coupons produce a clear message and preserve cart contents.

Checkout: validate required fields with field-level messages and a linked error summary. Invalid Australian postcodes/unsupported destinations show a useful error. Never discard entered address data after validation failure. Recalculate shipping and final total after address or coupon changes. Billing defaults to delivery address with an option to enter another address.

Payments: actual Stripe fields and PayPal controls come from their gateway integrations; their security controls, branding and required fields take precedence over the schematic Pencil fields. Card selected: final action reads Pay [total]. PayPal selected: show the provider's supported continuation/button flow; do not imply payment completed before confirmation. Display a processing state that prevents duplicate submission. Handle success, decline, authentication cancellation, PayPal cancellation, network interruption and delayed payment confirmation. Use provider confirmation and validated webhooks, not only the browser redirect, to mark orders paid. A retry must not create duplicate charges.

Order result: only confirmed payment shows Thank you, order number, items, totals, delivery address, dispatch estimate and email confirmation notice. Pending/unconfirmed payment shows an accurate pending message; cancelled/failed payment offers a retry route. Never display card numbers or payment secrets. Checkout is excluded from caching.

Accessibility: visible keyboard focus, descriptive image alternatives, real form labels, keyboard-operable swatches and accordions, sufficient contrast, announced cart/error/status changes and meaningful control names. Aim for WCAG 2.2 AA and test manually with keyboard navigation. Decorative photos use empty alt text.

## Development deliverables
1. Staging site implementing the approved design and requirements.
2. Minimal WooCommerce-compatible theme/child theme, editable content and documented custom functionality.
3. Tested Stripe and PayPal integrations in sandbox, followed by production configuration.
4. Customer-owned hosting/domain/licences, backup schedule and a tested restoration procedure.
5. Product/content entry, approved policies and reliable transactional email delivery.
6. Responsive, browser and accessibility checks; acceptance test results and resolved issues.
7. Source repository, dependency/licence inventory, setup/deployment instructions and renewal schedule.
8. A recorded owner walkthrough, short operating guide, agreed support period and named maintenance responsibility.

Keep custom code out of WooCommerce core. Use maintained integrations and minimise extensions. Store secrets outside source control. Document any WooCommerce template overrides and how future updates will be reviewed.

## Specification precedence

Use [specs.md](specs.md) for exact drawn dimensions and typography. Use the explicit build exceptions in [decisions.md](decisions.md) for differences between schematic artboards and required behaviour. These are design instructions; the website has not been built or tested.
