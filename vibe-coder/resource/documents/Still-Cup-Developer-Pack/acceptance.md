# Still Cup — acceptance checklist

Status: planned and unexecuted. These are developer testing and owner sign-off criteria, not a report of passed website tests.

## Acceptance tests before I sign off
- [ ] I can complete a guest purchase on desktop and mobile using test card and PayPal payments.
- [ ] A 300 ml Everyday Mug is $32; the 400 ml option is $36; selected variation appears correctly in cart and order.
- [ ] One $32 cup plus standard shipping totals $41.95 in the stated example configuration.
- [ ] A discounted merchandise subtotal of $99.99 charges shipping; $100 qualifies for free shipping.
- [ ] An unsupported shipping destination cannot proceed with an inaccurate shipping quote.
- [ ] Quantity limits, sold-out variations, discounts and stock reductions behave correctly.
- [ ] Declines, cancelled authentication, PayPal cancellation and delayed confirmation show accurate outcomes.
- [ ] Refreshing/retrying does not duplicate payment; validated payment notifications update the correct order.
- [ ] Confirmation and owner emails arrive; supported refund flow is verified in the provider and WooCommerce.
- [ ] Menu, search, checkout and variation selection are usable with a keyboard; mobile layout has no horizontal overflow.
- [ ] I can independently edit a product, adjust stock, change homepage text and process an order.
- [ ] Backup recovery is demonstrated and ownership/access/renewals are documented.
- [ ] Placeholder photos, dummy contact details, sample policies and test credentials are removed before launch.

Suggested sequence: approve scope → confirm owner content/accounts → staging setup → theme/components → catalogue → shipping/tax → payments → supporting pages/states → testing → owner training/approval → controlled launch and live verification.
