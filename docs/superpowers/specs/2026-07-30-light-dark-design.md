# Light and dark themes

Date: 2026-07-30
Status: approved, not yet implemented
Depends on: `2026-07-30-card-design-language-design.md`, shipped as `0.42.0`

## Problem

The theme is dark only. A reader on a bright screen in daylight has no
alternative, and the site ignores the colour scheme their device already
expresses.

This is the second half of a change begun in `0.42.0`. That work moved the
accent from coloured text to a chip fill, which is the precondition for this
one: lime reads 15.5:1 on `paper` but 1.3:1 on white, so it cannot be a text
colour in both skins. As a fill carrying near-black text it works against
either ground at a single value.

## Approved decisions

1. **Two equally designed skins**, not a dark theme with a light fallback.
2. **First visit follows the operating system.** An explicit choice, once
   made, overrides it permanently.
3. **The masthead and footer stay dark in both skins.**
4. Editor supplied the light palette; one value is corrected below.

## Palette

`theme.json` keeps the dark values, so every consumer has a working default.

| Slot | Dark | Light |
|---|---|---|
| `paper` | `#090909` | `#ffffff` |
| `band` | `#141414` | `#f7f7f7` |
| `surface` | `#1e1e1e` | `#f1f1f1` |
| `ink` | `#f3efee` | `#16181d` |
| `muted` | `#b9aaa8` | `#67696f` |
| `crimson` (accent) | `#c5f27e` | `#c5f27e` |
| `crimson-hover` | `#d9f7a6` | `#b2e963` |
| `line` | `#2e372a` | `#e3e4e6` |
| `highlight` | `#3d4f22` | `#e4f7c4` |

`muted` is `#67696f`, not the sampled `#6e7076`. That value gives **4.45:1**
against the `surface` card fill — under the 4.5:1 AA threshold, and it carries
excerpt body text. `#67696f` gives 4.93:1 on cards and 5.57:1 on white with no
visible change in character.

The accent is identical in both skins because it is only ever a fill.

## Mechanism

`light-dark()` driven by `color-scheme`:

```css
:root                     { color-scheme: light dark; }
:root[data-theme="light"] { color-scheme: light; }
:root[data-theme="dark"]  { color-scheme: dark; }

:root {
  --wp--preset--color--paper: light-dark(#ffffff, #090909);
  /* … one line per slot … */
}
```

`theme.json`'s `styles.css` string currently opens with
`:root { color-scheme: dark; }`. That declaration is replaced by the three
above; leaving it would pin every reader to the dark skin and silently defeat
the whole mechanism.

One declaration per colour instead of a palette written twice, and
`color-scheme` corrects native scrollbars, form controls and spellcheck
underlines as a side effect. Every rule in the theme already reads these
variables, including Core's `has-*-background-color` utilities, so nine
declarations reskin the whole site.

### The `@supports` guard is not optional

The entire block sits inside:

```css
@supports (color: light-dark(#fff, #000)) { … }
```

Custom properties validate at *use*, not at declaration. Without the guard, a
browser lacking `light-dark()` would accept
`--wp--preset--color--paper: light-dark(…)` happily and then fail when the
value is consumed, making the property guaranteed-invalid — transparent or
inherited backgrounds across the site. With the guard those browsers never see
the declaration and keep `theme.json`'s dark values, which is the theme as it
ships today.

### No flash, and no JavaScript required

The operating-system default is expressed in CSS, so nothing needs to run
before first paint. JavaScript writes `data-theme` only when the reader has
made an explicit choice, and an inline `<head>` script restores that choice
from `localStorage` before paint.

## Three tokens that must not flip

Five sites use `paper` as a *text* colour on an accent fill:

```
style.css:132, :137       .parimaanam-chip--accent a and its hover
search-overlay.css:109    .site-search__submit
theme.json:219, :236      elements.button text and its hover
```

If `paper` becomes white, each of those turns white-on-lime at 1.3:1. The
mirror problem applies to text over photographs, which uses `ink` and would
become near-black on a dark image.

Three tokens therefore hold one value in both skins:

| Token | Value | Job |
|---|---|---|
| `--parimaanam-on-accent` | `#0d0f0c` | text on an accent fill |
| `--parimaanam-on-media` | `#f3efee` | text over a photograph |
| `--parimaanam-scrim-rgb` | `9, 9, 9` | the overlay-card scrims |

The scrims at `homepage.css:105`, `homepage.css:286`, `theme.json:308` and the
search overlay backdrop read `rgba(9, 9, 9, …)`. All four stay dark, and none
needs theming — only renaming, so the next reader can see the value is
deliberate rather than a stale copy of `paper`.

For the three card scrims the reason is that white text sits on them, which is
as true in daylight as at night. The search overlay's backdrop is dark for a
different reason: its `<dialog>` sits inside `.site-header`, so it inherits
the dark island below and would be dark whatever this document said. That is
the right outcome anyway — the overlay is a modal takeover launched from the
dark masthead, and matching it is more coherent than flashing white. Stating
it here stops a later reader from "fixing" it.

## The dark island

The masthead and footer keep the dark palette in both skins. Rather than
rewriting their markup or overriding each rule, a single class re-pins the
palette variables within those subtrees:

```css
.site-header,
.site-footer {
  --wp--preset--color--paper: #090909;
  --wp--preset--color--band: #141414;
  /* … the dark value of every slot … */
}
```

`has-band-background-color` and all seven colour references in `footer.css`
then resolve to dark values with no markup change. `header.css` needs no
changes at all — the masthead's `graphite-ascend` gradient is literal hex and
was already dark in both.

This earns its keep three ways: the logo is a single `#e6e6e6` fill that would
be invisible on white, Core's Site Logo block renders one image regardless of
theme, and it keeps the publication's identity in daylight rather than
becoming a generic white blog.

## The toggle

A `wp:html` pattern following `header-search.php`: a real `<button>` with
`aria-pressed` reflecting state, and a sun/moon icon drawn as a CSS mask, the
technique the theme already uses for decorative glyphs.

- **Desktop:** beside the search trigger in the masthead.
- **Phones:** inside the navigation overlay, not the masthead. That header
  already carries logo, hamburger and search at 375px, and the open nav panel
  has a screen of unused space below its four links.

The button is hidden until the inline script marks the document
script-capable, so a reader without JavaScript sees no dead control and still
gets their operating-system preference.

Transitions respect `prefers-reduced-motion`.

## Out of scope

- **The block editor canvas.** It cannot follow a front-end toggle and will
  always render dark. Fixing it needs a second editor stylesheet, deliberately
  not shipped.
- Renaming the `crimson` colour slug.
- Any change to the masthead's gradient or the logo asset.

## Verification

No test harness; every claim is checked by measuring computed styles against
the running site in both skins.

- Each of the nine slots resolves to its stated value under
  `data-theme="light"` and `data-theme="dark"`.
- The five fixed-token sites stay near-black on lime in both.
- Masthead and footer measure identical in both.
- Contrast: `ink`/`paper`, `muted`/`surface`, `muted`/`paper` and
  `on-accent`/`accent` all meet 4.5:1 in both skins.
- With `localStorage` empty, the skin follows an emulated
  `prefers-color-scheme`.
- No flash of the wrong theme on reload with a stored preference.
