# Decisions, assumptions and outstanding inputs

## Confirmed for this fictional exercise

- WordPress + WooCommerce; Australian market and AUD; six cup products.
- Card payments via Stripe and PayPal as separate checkout choices.
- Free shipping at a discounted merchandise subtotal **at least $100**, otherwise $9.95 standard shipping for eligible Australian delivery. This precise rule takes precedence over informal “over $100” marketing copy.
- Customer owns the domain, hosting, payment and licence accounts. Credentials are not included.

## Design-to-build exceptions

- Add Cups to the category navigation/filtering where relevant; the sample desktop navigation only shows Mugs and Tumblers.
- Show six products per shop page. The artboard has three example cards and illustrative page 2; remove page 2 when all six results fit.
- Desktop checkout draws State/postcode together. Build separate State and Postcode fields, optional Address line 2 and a separate billing-address option.
- Use at least 16px mobile editable-input text. The extracted Pencil form-value size is 15px; specs.md preserves the actual drawn value.
- Use readable long-copy line-height around 1.5 in implementation where needed. The extracted canvas values are 1.2/1.25; specs.md preserves those actual values.
- Stripe and PayPal provide the real payment UI, required fields and authentication. The drawn card controls are schematic.
- Keep essential touch targets at least 44px even though the drawn colour circles are 38/40px.
- Artboard heights are presentation bounds. Website pages grow and scroll with content.

## Owner inputs still needed before production

- Approved final photography, SKU-level inventory, weights/dimensions, care and material claims.
- Verified business/contact details, actual tax configuration, shipping exclusions and approved policies.
- Owner-owned hosting/domain and payment accounts, plus authorised access invitations.
- Real approval of sample prices and dispatch/delivery promises; all current catalogue/business data is fictional.

## Outstanding design deliverables

- Editable Pencil source is included. Optional PNG/PDF artboard exports remain unavailable because Pencil export failed; see [design/SOURCE-STATUS.md](design/SOURCE-STATUS.md).
- Photographs are external mood references, not supplied final product assets. See [asset register](assets/asset-register.md).
- Supporting pages and unillustrated states follow [delivery.md](delivery.md); no separate high-fidelity artboards exist for them.

This package is ready to send as a documented development brief with these limitations. It is not a launched store, an implemented checkout, or a record of executed acceptance tests.
