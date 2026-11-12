# Still Cup — design specifications

Extracted from the active Pencil canvas `Still-Cup-Design.pen` on 12 November 2026. All dimensions and font sizes are in pixels. Values below describe the current design, including small differences between screens; they are not rounded or normalised into a new design system. Photographic image colours are excluded from the UI palette.

## Pages and artboard dimensions

| Page / screen | Width | Height | Pencil node |
| --- | --- | --- | --- |
| 01 Home · Desktop | 1440 | 1780 | `bi8Au` |
| 02 Product · Desktop | 1440 | 1110 | `nrpry` |
| 03 Shop · Desktop | 1440 | 1100 | `x8DQP` |
| 04 Bag · Desktop | 1440 | 900 | `H58YO6` |
| 05 Checkout · Desktop | 1440 | 1380 | `P3vyT` |
| 06 Home · Mobile 390 | 390 | 1580 | `iOcpQ` |
| 07 Product · Mobile 390 | 390 | 1340 | `mIRY5` |
| 08 Checkout · Mobile 390 | 390 | 1780 | `dzIY3` |

Eight designed screens represent five page types: Home, Product, Shop, Bag, Checkout. Mobile variants exist for Home, Product and Checkout.

Additional pages required by the customer brief but without dedicated Pencil artboards: Our story, Contact, Care guide, Shipping & returns, Privacy, Terms, Search results, Customer account/sign-in/order history/password reset, and Order confirmation. Their specific widths and typography have not been drawn separately.

## Layout widths

| Layout | Width / columns | Gutters / gaps |
| --- | --- | --- |
| Desktop artboard | 1440 | Main left/right gutter: 64 |
| Desktop main content span | 1312 | 1440 − 2 × 64 |
| Mobile artboard | 390 | Main left/right gutter: 20 |
| Mobile main content span | 350 | 390 − 2 × 20 |
| Home desktop hero image | 686 × 570 | Starts at x = 754 |
| Desktop featured/shop images | 422 each; 3 columns | 23 between images; x = 64, 509, 954 |
| Product desktop photo / purchase area | Photo 690; purchase area about 556 | Photo x = 64; purchase controls x = 820 |
| Bag desktop summary | 376 | x = 1000; inner text 320; inset 28 |
| Checkout desktop form / summary | 730 / 476 | Form x = 64; summary x = 900; separation 106 |
| Checkout desktop paired inputs | 351 + 351 | 28 between fields |
| Checkout desktop summary contents | 410 | 32 left inset |
| Home mobile featured images | 168 + 168 | 14 between images |
| Mobile checkout summary | 350 | Inner text 318; inset 16 |
| Mobile controls / full-width inputs | 350 | 20 outer gutters |

Column widths are inferred from the shown element geometry where no enclosing column frame exists. Exact node widths are listed per page below. Artboard heights are static presentation heights, not fixed website heights.

## Hex colours

| Hex | Role | Status |
| --- | --- | --- |
| `#F6F2EB` | Page background | Used on canvas |
| `#243A31` | Primary text, buttons, announcement/footer backgrounds, selected outlines | Used on canvas |
| `#FFFFFF` | Input/secondary-control backgrounds; inverse text | Used on canvas |
| `#E9E0D3` | Desktop hero background | Used on canvas |
| `#DDE2D7` | Story panels | Used on canvas |
| `#CFCFC4` | Dividers, field borders, unselected outlines | Used on canvas |
| `#CBB89E` | Sand swatch | Used on canvas |
| `#7F8D70` | Olive swatch | Used on canvas |
| `#E5E0D7` | Chalk swatch | Used on canvas |
| `#E9E8DF` | Order-summary panels | Used on canvas |

| Hex | Role | Status |
| --- | --- | --- |
| `#59645D` | Secondary/muted text token | Defined in Pencil variables; not applied to current nodes |

## Font families and size inventory

- **Newsreader**: wordmark, headings and product names. Sizes: 18px, 19px, 20px, 24px, 28px, 30px, 32px, 33px, 34px, 38px, 40px, 44px, 46px, 50px, 54px, 56px, 60px, 62px, 80px.
- **Inter**: body copy, navigation, prices, labels and controls. Sizes: 11px, 12px, 13px, 14px, 15px, 16px, 17px, 18px, 19px, 20px, 22px, 24px.

All extracted text nodes use `fontWeight: normal` (regular). Text alignment is left/default. The desktop homepage uses line-height **1.2**; the remaining screens use **1.25**. Text nodes use fixed-width wrapping. Exact sizes and text-box widths follow in the page tables.

## Page specifications

Positions in the tables are relative to the immediate parent named in the Parent column, not always to the artboard. Text widths are text-box widths, which may differ from their containing button or field. `Image fill` denotes photography rather than a hex fill. Text tables include empty form-value nodes because their typography is explicitly defined in Pencil.

### 01 Home · Desktop

Artboard: **1440 × 1780**. Background: `#F6F2EB`. Main gutter: **64px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Shipping announcement | 01 Home · Desktop | 0 | 0 | 1440 | 32 | `#243A31` | — |
| Hero editorial background | 01 Home · Desktop | 0 | 114 | 1440 | 570 | `#E9E0D3` | — |
| Shop collection | 01 Home · Desktop | 68 | 508 | 236 | 52 | `#243A31` | — |
| Ceramic lifestyle hero image | 01 Home · Desktop | 754 | 114 | 686 | 570 | Image fill | — |
| Everyday Mug image | 01 Home · Desktop | 64 | 916 | 422 | 350 | Image fill | — |
| Slow Morning Cup image | 01 Home · Desktop | 509 | 916 | 422 | 350 | Image fill | — |
| Studio Tumbler image | 01 Home · Desktop | 954 | 916 | 422 | 350 | Image fill | — |
| Story band | 01 Home · Desktop | 0 | 1400 | 1440 | 240 | `#DDE2D7` | — |
| Footer | 01 Home · Desktop | 0 | 1640 | 1440 | 140 | `#243A31` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Announcement | 01 Home · Desktop | 420 | 8 | 650 | Inter | 13 | 1.2 | `#FFFFFF` |
| Wordmark | 01 Home · Desktop | 64 | 53 | 240 | Newsreader | 38 | 1.2 | `#243A31` |
| Main navigation | 01 Home · Desktop | 510 | 68 | 600 | Inter | 15 | 1.2 | `#243A31` |
| Utility navigation | 01 Home · Desktop | 1135 | 68 | 280 | Inter | 14 | 1.2 | `#243A31` |
| Hero eyebrow | 01 Home · Desktop | 64 | 186 | 470 | Inter | 13 | 1.2 | `#243A31` |
| Hero heading | 01 Home · Desktop | 64 | 224 | 650 | Newsreader | 80 | 1.2 | `#243A31` |
| Hero description | 01 Home · Desktop | 68 | 423 | 530 | Inter | 18 | 1.2 | `#243A31` |
| Shop collection label | Shop collection | 20 | 16 | 204 | Inter | 15 | 1.2 | `#FFFFFF` |
| Hero image caption | 01 Home · Desktop | 790 | 636 | 520 | Inter | 12 | 1.2 | `#FFFFFF` |
| Benefits strip | 01 Home · Desktop | 216 | 718 | 1100 | Inter | 15 | 1.2 | `#243A31` |
| Featured eyebrow | 01 Home · Desktop | 64 | 804 | 650 | Inter | 12 | 1.2 | `#243A31` |
| Featured heading | 01 Home · Desktop | 64 | 835 | 1000 | Newsreader | 46 | 1.2 | `#243A31` |
| Shop all link | 01 Home · Desktop | 1200 | 858 | 180 | Inter | 15 | 1.2 | `#243A31` |
| Everyday Mug | 01 Home · Desktop | 64 | 1286 | 320 | Newsreader | 20 | 1.2 | `#243A31` |
| Everyday Mug price | 01 Home · Desktop | 384 | 1289 | 100 | Inter | 15 | 1.2 | `#243A31` |
| Everyday Mug finishes | 01 Home · Desktop | 64 | 1320 | 350 | Inter | 14 | 1.2 | `#243A31` |
| Slow Morning Cup | 01 Home · Desktop | 509 | 1286 | 320 | Newsreader | 20 | 1.2 | `#243A31` |
| Slow Morning Cup price | 01 Home · Desktop | 829 | 1289 | 100 | Inter | 15 | 1.2 | `#243A31` |
| Slow Morning Cup finishes | 01 Home · Desktop | 509 | 1320 | 350 | Inter | 14 | 1.2 | `#243A31` |
| Studio Tumbler | 01 Home · Desktop | 954 | 1286 | 320 | Newsreader | 20 | 1.2 | `#243A31` |
| Studio Tumbler price | 01 Home · Desktop | 1274 | 1289 | 100 | Inter | 15 | 1.2 | `#243A31` |
| Studio Tumbler finishes | 01 Home · Desktop | 954 | 1320 | 350 | Inter | 14 | 1.2 | `#243A31` |
| Story eyebrow | 01 Home · Desktop | 64 | 1440 | 400 | Inter | 12 | 1.2 | `#243A31` |
| Story heading | 01 Home · Desktop | 64 | 1477 | 660 | Newsreader | 44 | 1.2 | `#243A31` |
| Story copy | 01 Home · Desktop | 770 | 1456 | 600 | Inter | 18 | 1.2 | `#243A31` |
| Story link | 01 Home · Desktop | 770 | 1540 | 300 | Inter | 16 | 1.2 | `#243A31` |
| Footer brand | 01 Home · Desktop | 64 | 1670 | 300 | Newsreader | 34 | 1.2 | `#FFFFFF` |
| Footer links | 01 Home · Desktop | 490 | 1680 | 850 | Inter | 14 | 1.2 | `#FFFFFF` |
| Footer details | 01 Home · Desktop | 490 | 1720 | 850 | Inter | 13 | 1.2 | `#FFFFFF` |

### 02 Product · Desktop

Artboard: **1440 × 1110**. Background: `#F6F2EB`. Main gutter: **64px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Navigation divider | 02 Product · Desktop | 64 | 99 | 1312 | 1 | `#CFCFC4` | — |
| Product main photo — reference only | 02 Product · Desktop | 64 | 180 | 690 | 640 | Image fill | — |
| Sand selected | 02 Product · Desktop | 820 | 482 | 38 | 38 | `#CBB89E` | `#243A31` / 3px |
| Olive | 02 Product · Desktop | 878 | 482 | 38 | 38 | `#7F8D70` | `#CFCFC4` / 1px |
| Chalk | 02 Product · Desktop | 936 | 482 | 38 | 38 | `#E5E0D7` | `#CFCFC4` / 1px |
| Capacity selector | 02 Product · Desktop | 820 | 576 | 210 | 52 | `#FFFFFF` | — |
| Quantity | 02 Product · Desktop | 820 | 691 | 144 | 52 | `#FFFFFF` | — |
| Add to bag | 02 Product · Desktop | 980 | 691 | 392 | 52 | `#243A31` | — |
| Details rule | 02 Product · Desktop | 64 | 891 | 1312 | 1 | `#CFCFC4` | — |
| Care rule | 02 Product · Desktop | 64 | 946 | 1312 | 1 | `#CFCFC4` | — |
| Shipping & returns rule | 02 Product · Desktop | 64 | 1001 | 1312 | 1 | `#CFCFC4` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Brand | 02 Product · Desktop | 64 | 32 | 250 | Newsreader | 38 | 1.25 | `#243A31` |
| Navigation | 02 Product · Desktop | 510 | 47 | 550 | Inter | 15 | 1.25 | `#243A31` |
| Utilities | 02 Product · Desktop | 1120 | 47 | 300 | Inter | 14 | 1.25 | `#243A31` |
| Breadcrumb | 02 Product · Desktop | 64 | 127 | 700 | Inter | 13 | 1.25 | `#243A31` |
| Collection label | 02 Product · Desktop | 820 | 185 | 550 | Inter | 12 | 1.25 | `#243A31` |
| Product title | 02 Product · Desktop | 820 | 220 | 560 | Newsreader | 56 | 1.25 | `#243A31` |
| Product price | 02 Product · Desktop | 820 | 296 | 500 | Inter | 24 | 1.25 | `#243A31` |
| Description | 02 Product · Desktop | 820 | 351 | 540 | Inter | 17 | 1.25 | `#243A31` |
| Colour label | 02 Product · Desktop | 820 | 447 | 500 | Inter | 15 | 1.25 | `#243A31` |
| Size label | 02 Product · Desktop | 820 | 548 | 500 | Inter | 14 | 1.25 | `#243A31` |
| Capacity selector label | Capacity selector | 20 | 16 | 178 | Inter | 15 | 1.25 | `#243A31` |
| Stock message | 02 Product · Desktop | 820 | 653 | 550 | Inter | 14 | 1.25 | `#243A31` |
| Quantity label | Quantity | 20 | 16 | 112 | Inter | 15 | 1.25 | `#243A31` |
| Add to bag label | Add to bag | 20 | 16 | 360 | Inter | 15 | 1.25 | `#FFFFFF` |
| Shipping policy | 02 Product · Desktop | 820 | 770 | 550 | Inter | 14 | 1.25 | `#243A31` |
| Photo note | 02 Product · Desktop | 64 | 841 | 700 | Inter | 13 | 1.25 | `#243A31` |
| Details | 02 Product · Desktop | 64 | 904 | 350 | Newsreader | 18 | 1.25 | `#243A31` |
| Details content | 02 Product · Desktop | 460 | 904 | 850 | Inter | 15 | 1.25 | `#243A31` |
| Care | 02 Product · Desktop | 64 | 959 | 350 | Newsreader | 18 | 1.25 | `#243A31` |
| Care content | 02 Product · Desktop | 460 | 959 | 850 | Inter | 15 | 1.25 | `#243A31` |
| Shipping & returns | 02 Product · Desktop | 64 | 1014 | 350 | Newsreader | 18 | 1.25 | `#243A31` |
| Shipping & returns content | 02 Product · Desktop | 460 | 1014 | 850 | Inter | 15 | 1.25 | `#243A31` |

### 03 Shop · Desktop

Artboard: **1440 × 1100**. Background: `#F6F2EB`. Main gutter: **64px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Navigation divider | 03 Shop · Desktop | 64 | 99 | 1312 | 1 | `#CFCFC4` | — |
| Category filter | 03 Shop · Desktop | 64 | 345 | 480 | 52 | `#FFFFFF` | — |
| Sort selector | 03 Shop · Desktop | 1110 | 345 | 260 | 52 | `#FFFFFF` | — |
| Everyday Mug reference photo | 03 Shop · Desktop | 64 | 475 | 422 | 390 | Image fill | — |
| Slow Morning Cup reference photo | 03 Shop · Desktop | 509 | 475 | 422 | 390 | Image fill | — |
| Studio Tumbler reference photo | 03 Shop · Desktop | 954 | 475 | 422 | 390 | Image fill | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Brand | 03 Shop · Desktop | 64 | 32 | 250 | Newsreader | 38 | 1.25 | `#243A31` |
| Navigation | 03 Shop · Desktop | 510 | 47 | 550 | Inter | 15 | 1.25 | `#243A31` |
| Utilities | 03 Shop · Desktop | 1120 | 47 | 300 | Inter | 14 | 1.25 | `#243A31` |
| Eyebrow | 03 Shop · Desktop | 64 | 155 | 600 | Inter | 12 | 1.25 | `#243A31` |
| Heading | 03 Shop · Desktop | 64 | 192 | 1000 | Newsreader | 62 | 1.25 | `#243A31` |
| Intro | 03 Shop · Desktop | 64 | 280 | 1000 | Inter | 18 | 1.25 | `#243A31` |
| Category filter label | Category filter | 20 | 16 | 448 | Inter | 15 | 1.25 | `#243A31` |
| Sort selector label | Sort selector | 20 | 16 | 228 | Inter | 15 | 1.25 | `#243A31` |
| Result count | 03 Shop · Desktop | 64 | 425 | 500 | Inter | 14 | 1.25 | `#243A31` |
| Everyday Mug | 03 Shop · Desktop | 64 | 888 | 310 | Newsreader | 24 | 1.25 | `#243A31` |
| Everyday Mug price | 03 Shop · Desktop | 384 | 896 | 100 | Inter | 15 | 1.25 | `#243A31` |
| Everyday Mug finish | 03 Shop · Desktop | 64 | 930 | 400 | Inter | 14 | 1.25 | `#243A31` |
| Slow Morning Cup | 03 Shop · Desktop | 509 | 888 | 310 | Newsreader | 24 | 1.25 | `#243A31` |
| Slow Morning Cup price | 03 Shop · Desktop | 829 | 896 | 100 | Inter | 15 | 1.25 | `#243A31` |
| Slow Morning Cup finish | 03 Shop · Desktop | 509 | 930 | 400 | Inter | 14 | 1.25 | `#243A31` |
| Studio Tumbler | 03 Shop · Desktop | 954 | 888 | 310 | Newsreader | 24 | 1.25 | `#243A31` |
| Studio Tumbler price | 03 Shop · Desktop | 1274 | 896 | 100 | Inter | 15 | 1.25 | `#243A31` |
| Studio Tumbler finish | 03 Shop · Desktop | 954 | 930 | 400 | Inter | 14 | 1.25 | `#243A31` |
| Pagination | 03 Shop · Desktop | 602 | 1020 | 400 | Inter | 15 | 1.25 | `#243A31` |

### 04 Bag · Desktop

Artboard: **1440 × 900**. Background: `#F6F2EB`. Main gutter: **64px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Navigation divider | 04 Bag · Desktop | 64 | 99 | 1312 | 1 | `#CFCFC4` | — |
| Cart product reference | 04 Bag · Desktop | 64 | 322 | 180 | 180 | Image fill | — |
| Cart quantity | 04 Bag · Desktop | 280 | 422 | 160 | 52 | `#FFFFFF` | — |
| Order summary | 04 Bag · Desktop | 1000 | 310 | 376 | 405 | `#E9E8DF` | — |
| Checkout | Order summary | 28 | 292 | 320 | 52 | `#243A31` | — |
| Continue shopping | 04 Bag · Desktop | 64 | 625 | 270 | 52 | `#FFFFFF` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Brand | 04 Bag · Desktop | 64 | 32 | 250 | Newsreader | 38 | 1.25 | `#243A31` |
| Navigation | 04 Bag · Desktop | 510 | 47 | 550 | Inter | 15 | 1.25 | `#243A31` |
| Utilities | 04 Bag · Desktop | 1120 | 47 | 300 | Inter | 14 | 1.25 | `#243A31` |
| Heading | 04 Bag · Desktop | 64 | 154 | 800 | Newsreader | 60 | 1.25 | `#243A31` |
| Count | 04 Bag · Desktop | 64 | 234 | 900 | Inter | 18 | 1.25 | `#243A31` |
| Product | 04 Bag · Desktop | 280 | 327 | 500 | Newsreader | 28 | 1.25 | `#243A31` |
| Variant | 04 Bag · Desktop | 280 | 375 | 500 | Inter | 16 | 1.25 | `#243A31` |
| Cart quantity label | Cart quantity | 20 | 16 | 128 | Inter | 15 | 1.25 | `#243A31` |
| Remove | 04 Bag · Desktop | 470 | 438 | 200 | Inter | 14 | 1.25 | `#243A31` |
| Line price | 04 Bag · Desktop | 758 | 330 | 200 | Inter | 20 | 1.25 | `#243A31` |
| Summary title | Order summary | 28 | 28 | 320 | Newsreader | 28 | 1.25 | `#243A31` |
| Subtotal | Order summary | 28 | 94 | 320 | Inter | 16 | 1.25 | `#243A31` |
| Shipping | Order summary | 28 | 138 | 320 | Inter | 16 | 1.25 | `#243A31` |
| Estimate note | Order summary | 28 | 178 | 320 | Inter | 13 | 1.25 | `#243A31` |
| Total | Order summary | 28 | 231 | 320 | Inter | 19 | 1.25 | `#243A31` |
| Checkout label | Checkout | 20 | 16 | 288 | Inter | 15 | 1.25 | `#FFFFFF` |
| Threshold message | 04 Bag · Desktop | 64 | 557 | 820 | Inter | 16 | 1.25 | `#243A31` |
| Continue shopping label | Continue shopping | 20 | 16 | 238 | Inter | 15 | 1.25 | `#243A31` |
| Tax note | 04 Bag · Desktop | 64 | 755 | 900 | Inter | 14 | 1.25 | `#243A31` |

### 05 Checkout · Desktop

Artboard: **1440 × 1380**. Background: `#F6F2EB`. Main gutter: **64px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Divider | 05 Checkout · Desktop | 64 | 100 | 1312 | 1 | `#CFCFC4` | — |
| Email address field | 05 Checkout · Desktop | 64 | 305 | 730 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| First name field | 05 Checkout · Desktop | 64 | 475 | 351 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Last name field | 05 Checkout · Desktop | 443 | 475 | 351 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Street address field | 05 Checkout · Desktop | 64 | 573 | 730 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Suburb / city field | 05 Checkout · Desktop | 64 | 671 | 351 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| State / postcode field | 05 Checkout · Desktop | 443 | 671 | 351 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Shipping selection | 05 Checkout · Desktop | 64 | 798 | 730 | 64 | `#FFFFFF` | — |
| Card selected | 05 Checkout · Desktop | 64 | 956 | 730 | 162 | `#FFFFFF` | `#243A31` / 1px |
| PayPal choice | 05 Checkout · Desktop | 64 | 1132 | 730 | 56 | `#FFFFFF` | — |
| Submit payment | 05 Checkout · Desktop | 64 | 1260 | 730 | 52 | `#243A31` | — |
| Order summary | 05 Checkout · Desktop | 900 | 280 | 476 | 450 | `#E9E8DF` | — |
| Discount code field | Order summary | 32 | 229 | 268 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Apply | Order summary | 316 | 229 | 128 | 52 | `#FFFFFF` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Brand | 05 Checkout · Desktop | 64 | 32 | 300 | Newsreader | 38 | 1.25 | `#243A31` |
| Secure label | 05 Checkout · Desktop | 1000 | 50 | 400 | Inter | 14 | 1.25 | `#243A31` |
| Heading | 05 Checkout · Desktop | 64 | 145 | 800 | Newsreader | 54 | 1.25 | `#243A31` |
| Guest note | 05 Checkout · Desktop | 64 | 219 | 800 | Inter | 15 | 1.25 | `#243A31` |
| Email address label | 05 Checkout · Desktop | 64 | 280 | 730 | Inter | 13 | 1.25 | `#243A31` |
| Email address value | Email address field | 14 | 16 | 706 | Inter | 15 | 1.25 | `#243A31` |
| Delivery | 05 Checkout · Desktop | 64 | 395 | 700 | Newsreader | 30 | 1.25 | `#243A31` |
| First name label | 05 Checkout · Desktop | 64 | 450 | 351 | Inter | 13 | 1.25 | `#243A31` |
| First name value | First name field | 14 | 16 | 327 | Inter | 15 | 1.25 | `#243A31` |
| Last name label | 05 Checkout · Desktop | 443 | 450 | 351 | Inter | 13 | 1.25 | `#243A31` |
| Last name value | Last name field | 14 | 16 | 327 | Inter | 15 | 1.25 | `#243A31` |
| Street address label | 05 Checkout · Desktop | 64 | 548 | 730 | Inter | 13 | 1.25 | `#243A31` |
| Street address value | Street address field | 14 | 16 | 706 | Inter | 15 | 1.25 | `#243A31` |
| Suburb / city label | 05 Checkout · Desktop | 64 | 646 | 351 | Inter | 13 | 1.25 | `#243A31` |
| Suburb / city value | Suburb / city field | 14 | 16 | 327 | Inter | 15 | 1.25 | `#243A31` |
| State / postcode label | 05 Checkout · Desktop | 443 | 646 | 351 | Inter | 13 | 1.25 | `#243A31` |
| State / postcode value | State / postcode field | 14 | 16 | 327 | Inter | 15 | 1.25 | `#243A31` |
| Country | 05 Checkout · Desktop | 64 | 750 | 730 | Inter | 15 | 1.25 | `#243A31` |
| Shipping | Shipping selection | 18 | 22 | 690 | Inter | 16 | 1.25 | `#243A31` |
| Payment | 05 Checkout · Desktop | 64 | 905 | 730 | Newsreader | 30 | 1.25 | `#243A31` |
| Card option | Card selected | 18 | 18 | 690 | Inter | 16 | 1.25 | `#243A31` |
| Stripe fields | Card selected | 18 | 66 | 690 | Inter | 15 | 1.25 | `#243A31` |
| Card placeholder | Card selected | 18 | 108 | 690 | Inter | 16 | 1.25 | `#243A31` |
| PayPal label | PayPal choice | 18 | 18 | 690 | Inter | 16 | 1.25 | `#243A31` |
| Privacy note | 05 Checkout · Desktop | 64 | 1210 | 730 | Inter | 14 | 1.25 | `#243A31` |
| Submit payment label | Submit payment | 20 | 16 | 698 | Inter | 15 | 1.25 | `#FFFFFF` |
| Summary heading | Order summary | 32 | 30 | 410 | Newsreader | 30 | 1.25 | `#243A31` |
| Item | Order summary | 32 | 94 | 410 | Inter | 17 | 1.25 | `#243A31` |
| Edit bag | Order summary | 32 | 158 | 410 | Inter | 14 | 1.25 | `#243A31` |
| Discount code label | Order summary | 32 | 204 | 268 | Inter | 13 | 1.25 | `#243A31` |
| Discount code value | Discount code field | 14 | 16 | 244 | Inter | 15 | 1.25 | `#243A31` |
| Apply label | Apply | 20 | 16 | 96 | Inter | 15 | 1.25 | `#243A31` |
| Totals | Order summary | 32 | 304 | 410 | Inter | 16 | 1.25 | `#243A31` |
| Total | Order summary | 32 | 390 | 410 | Inter | 22 | 1.25 | `#243A31` |

### 06 Home · Mobile 390

Artboard: **390 × 1580**. Background: `#F6F2EB`. Main gutter: **20px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Announcement | 06 Home · Mobile 390 | 0 | 0 | 390 | 30 | `#243A31` | — |
| Shop | 06 Home · Mobile 390 | 20 | 374 | 350 | 52 | `#243A31` | — |
| Mobile hero image | 06 Home · Mobile 390 | 0 | 458 | 390 | 330 | Image fill | — |
| Mobile mug photo | 06 Home · Mobile 390 | 20 | 931 | 168 | 210 | Image fill | — |
| Mobile cup photo | 06 Home · Mobile 390 | 202 | 931 | 168 | 210 | Image fill | — |
| Story panel | 06 Home · Mobile 390 | 0 | 1250 | 390 | 180 | `#DDE2D7` | — |
| Footer | 06 Home · Mobile 390 | 0 | 1430 | 390 | 110 | `#243A31` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Free shipping | 06 Home · Mobile 390 | 76 | 8 | 280 | Inter | 12 | 1.25 | `#FFFFFF` |
| Mobile menu | 06 Home · Mobile 390 | 20 | 52 | 48 | Inter | 24 | 1.25 | `#243A31` |
| Wordmark | 06 Home · Mobile 390 | 126 | 47 | 160 | Newsreader | 32 | 1.25 | `#243A31` |
| Bag | 06 Home · Mobile 390 | 318 | 57 | 65 | Inter | 13 | 1.25 | `#243A31` |
| Eyebrow | 06 Home · Mobile 390 | 20 | 128 | 350 | Inter | 11 | 1.25 | `#243A31` |
| Hero | 06 Home · Mobile 390 | 20 | 163 | 350 | Newsreader | 50 | 1.25 | `#243A31` |
| Copy | 06 Home · Mobile 390 | 20 | 306 | 350 | Inter | 16 | 1.25 | `#243A31` |
| Shop label | Shop | 20 | 16 | 318 | Inter | 15 | 1.25 | `#FFFFFF` |
| Featured heading | 06 Home · Mobile 390 | 20 | 834 | 350 | Newsreader | 33 | 1.25 | `#243A31` |
| Shop link | 06 Home · Mobile 390 | 20 | 885 | 350 | Inter | 14 | 1.25 | `#243A31` |
| First product | 06 Home · Mobile 390 | 20 | 1158 | 175 | Newsreader | 19 | 1.25 | `#243A31` |
| First price | 06 Home · Mobile 390 | 20 | 1189 | 160 | Inter | 14 | 1.25 | `#243A31` |
| Second product | 06 Home · Mobile 390 | 202 | 1158 | 175 | Newsreader | 19 | 1.25 | `#243A31` |
| Second price | 06 Home · Mobile 390 | 202 | 1189 | 160 | Inter | 14 | 1.25 | `#243A31` |
| Story | 06 Home · Mobile 390 | 20 | 1280 | 350 | Newsreader | 34 | 1.25 | `#243A31` |
| Story copy | 06 Home · Mobile 390 | 20 | 1337 | 350 | Inter | 16 | 1.25 | `#243A31` |
| Footer links | 06 Home · Mobile 390 | 20 | 1460 | 350 | Inter | 14 | 1.25 | `#FFFFFF` |

### 07 Product · Mobile 390

Artboard: **390 × 1340**. Background: `#F6F2EB`. Main gutter: **20px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Mobile product reference | 07 Product · Mobile 390 | 0 | 125 | 390 | 370 | Image fill | — |
| Sand selected | 07 Product · Mobile 390 | 20 | 768 | 40 | 40 | `#CBB89E` | `#243A31` / 3px |
| Olive | 07 Product · Mobile 390 | 78 | 768 | 40 | 40 | `#7F8D70` | `#CFCFC4` / 1px |
| Chalk | 07 Product · Mobile 390 | 136 | 768 | 40 | 40 | `#E5E0D7` | `#CFCFC4` / 1px |
| Capacity | 07 Product · Mobile 390 | 20 | 837 | 350 | 52 | `#FFFFFF` | — |
| Quantity | 07 Product · Mobile 390 | 20 | 959 | 116 | 52 | `#FFFFFF` | — |
| Add to bag | 07 Product · Mobile 390 | 148 | 959 | 222 | 52 | `#243A31` | — |
| Details                                  + rule | 07 Product · Mobile 390 | 20 | 1103 | 350 | 1 | `#CFCFC4` | — |
| Care                                      + rule | 07 Product · Mobile 390 | 20 | 1163 | 350 | 1 | `#CFCFC4` | — |
| Shipping & returns                 + rule | 07 Product · Mobile 390 | 20 | 1223 | 350 | 1 | `#CFCFC4` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Menu | 07 Product · Mobile 390 | 20 | 26 | 48 | Inter | 24 | 1.25 | `#243A31` |
| Brand | 07 Product · Mobile 390 | 126 | 22 | 160 | Newsreader | 32 | 1.25 | `#243A31` |
| Bag | 07 Product · Mobile 390 | 318 | 32 | 65 | Inter | 13 | 1.25 | `#243A31` |
| Breadcrumb | 07 Product · Mobile 390 | 20 | 90 | 350 | Inter | 12 | 1.25 | `#243A31` |
| Product name | 07 Product · Mobile 390 | 20 | 530 | 350 | Newsreader | 40 | 1.25 | `#243A31` |
| Price | 07 Product · Mobile 390 | 20 | 590 | 350 | Inter | 22 | 1.25 | `#243A31` |
| Description | 07 Product · Mobile 390 | 20 | 641 | 350 | Inter | 16 | 1.25 | `#243A31` |
| Colour | 07 Product · Mobile 390 | 20 | 731 | 350 | Inter | 15 | 1.25 | `#243A31` |
| Capacity label | Capacity | 20 | 16 | 318 | Inter | 15 | 1.25 | `#243A31` |
| Stock | 07 Product · Mobile 390 | 20 | 913 | 350 | Inter | 14 | 1.25 | `#243A31` |
| Quantity label | Quantity | 20 | 16 | 84 | Inter | 15 | 1.25 | `#243A31` |
| Add to bag label | Add to bag | 20 | 16 | 190 | Inter | 15 | 1.25 | `#FFFFFF` |
| Shipping | 07 Product · Mobile 390 | 20 | 1039 | 350 | Inter | 14 | 1.25 | `#243A31` |
| Details                                  + | 07 Product · Mobile 390 | 20 | 1120 | 350 | Newsreader | 18 | 1.25 | `#243A31` |
| Care                                      + | 07 Product · Mobile 390 | 20 | 1180 | 350 | Newsreader | 18 | 1.25 | `#243A31` |
| Shipping & returns                 + | 07 Product · Mobile 390 | 20 | 1240 | 350 | Newsreader | 18 | 1.25 | `#243A31` |

### 08 Checkout · Mobile 390

Artboard: **390 × 1780**. Background: `#F6F2EB`. Main gutter: **20px**; full-bleed elements use x = 0.

#### Layout elements and control widths

| Element | Parent | X | Y | Width | Height | Fill | Stroke |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Order summary mobile | 08 Checkout · Mobile 390 | 20 | 204 | 350 | 183 | `#E9E8DF` | — |
| Email address field | 08 Checkout · Mobile 390 | 20 | 448 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| First name field | 08 Checkout · Mobile 390 | 20 | 616 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Last name field | 08 Checkout · Mobile 390 | 20 | 714 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Street address field | 08 Checkout · Mobile 390 | 20 | 812 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Suburb / city field | 08 Checkout · Mobile 390 | 20 | 910 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| State field | 08 Checkout · Mobile 390 | 20 | 1008 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Postcode field | 08 Checkout · Mobile 390 | 20 | 1106 | 350 | 50 | `#FFFFFF` | `#CFCFC4` / 1px |
| Shipping | 08 Checkout · Mobile 390 | 20 | 1238 | 350 | 68 | `#FFFFFF` | — |
| Card choice | 08 Checkout · Mobile 390 | 20 | 1394 | 350 | 130 | `#FFFFFF` | `#243A31` / 1px |
| PayPal choice | 08 Checkout · Mobile 390 | 20 | 1538 | 350 | 52 | `#FFFFFF` | — |
| Pay | 08 Checkout · Mobile 390 | 20 | 1669 | 350 | 52 | `#243A31` | — |

#### Typography and text-box widths

| Text element | Parent | X | Y | Width | Family | Size | Line height | Colour |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Brand | 08 Checkout · Mobile 390 | 20 | 24 | 230 | Newsreader | 32 | 1.25 | `#243A31` |
| Secure | 08 Checkout · Mobile 390 | 245 | 36 | 130 | Inter | 12 | 1.25 | `#243A31` |
| Heading | 08 Checkout · Mobile 390 | 20 | 96 | 350 | Newsreader | 40 | 1.25 | `#243A31` |
| Guest | 08 Checkout · Mobile 390 | 20 | 155 | 350 | Inter | 14 | 1.25 | `#243A31` |
| Summary | Order summary mobile | 16 | 18 | 318 | Newsreader | 18 | 1.25 | `#243A31` |
| Item | Order summary mobile | 16 | 59 | 318 | Inter | 14 | 1.25 | `#243A31` |
| Totals | Order summary mobile | 16 | 93 | 318 | Inter | 14 | 1.25 | `#243A31` |
| Coupon link | Order summary mobile | 16 | 137 | 318 | Inter | 14 | 1.25 | `#243A31` |
| Email address label | 08 Checkout · Mobile 390 | 20 | 423 | 350 | Inter | 13 | 1.25 | `#243A31` |
| Email address value | Email address field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| Delivery | 08 Checkout · Mobile 390 | 20 | 532 | 350 | Newsreader | 28 | 1.25 | `#243A31` |
| First name label | 08 Checkout · Mobile 390 | 20 | 591 | 350 | Inter | 13 | 1.25 | `#243A31` |
| First name value | First name field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| Last name label | 08 Checkout · Mobile 390 | 20 | 689 | 350 | Inter | 13 | 1.25 | `#243A31` |
| Last name value | Last name field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| Street address label | 08 Checkout · Mobile 390 | 20 | 787 | 350 | Inter | 13 | 1.25 | `#243A31` |
| Street address value | Street address field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| Suburb / city label | 08 Checkout · Mobile 390 | 20 | 885 | 350 | Inter | 13 | 1.25 | `#243A31` |
| Suburb / city value | Suburb / city field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| State label | 08 Checkout · Mobile 390 | 20 | 983 | 350 | Inter | 13 | 1.25 | `#243A31` |
| State value | State field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| Postcode label | 08 Checkout · Mobile 390 | 20 | 1081 | 350 | Inter | 13 | 1.25 | `#243A31` |
| Postcode value | Postcode field | 14 | 16 | 326 | Inter | 15 | 1.25 | `#243A31` |
| Country | 08 Checkout · Mobile 390 | 20 | 1195 | 350 | Inter | 15 | 1.25 | `#243A31` |
| Shipping label | Shipping | 14 | 13 | 322 | Inter | 14 | 1.25 | `#243A31` |
| Payment heading | 08 Checkout · Mobile 390 | 20 | 1342 | 350 | Newsreader | 28 | 1.25 | `#243A31` |
| Card label | Card choice | 14 | 14 | 322 | Inter | 16 | 1.25 | `#243A31` |
| Card provider | Card choice | 14 | 52 | 322 | Inter | 14 | 1.25 | `#243A31` |
| Card fields | Card choice | 14 | 91 | 322 | Inter | 14 | 1.25 | `#243A31` |
| PayPal label | PayPal choice | 14 | 17 | 322 | Inter | 16 | 1.25 | `#243A31` |
| Privacy | 08 Checkout · Mobile 390 | 20 | 1621 | 350 | Inter | 13 | 1.25 | `#243A31` |
| Pay label | Pay | 20 | 16 | 318 | Inter | 15 | 1.25 | `#FFFFFF` |

## Responsive implementation rules from the handover

These are implementation instructions from the written handover, rather than additional dimensions extracted from Pencil:

- Desktop navigation and two-column product/checkout layouts start at 1024px where space permits; below that, switch to the mobile menu and stack complex layouts.
- Support widths down to 320px without horizontal overflow. Adapt gutters and columns rather than scaling the entire artboard.
- Mobile home places hero text before its image. Product previews use two columns where readable; the shop may reduce to one at narrow widths.
- Mobile bag stacks line-item content before totals. Mobile checkout summary precedes the contact form.
- Actual Stripe/PayPal controls follow the payment provider integration; the drawn fields are schematic.
- The handover recommends at least 16px for editable mobile input text, although the current Pencil input-value nodes are 15px. Preserve this distinction when implementing.

## Scope notes

- Extracted colours and font sizes take precedence over approximate values in the earlier brief when reproducing the existing canvas.
- Fonts and spacing are mostly literal node properties; the defined variable tokens are not consistently bound to nodes.
- A spacing-unit variable of 8px exists. Current coordinates also contain values outside that scale; use the tables for faithful reproduction.
- No reusable components are defined. Shared headers, buttons and fields should be consolidated during development.
- Stock photos are visual references and must be replaced by owner-approved product photography before launch.

