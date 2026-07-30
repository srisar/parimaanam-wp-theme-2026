# Card design language

Date: 2026-07-30
Status: approved, not yet implemented

## Problem

The theme grew nine distinct post-card treatments, each styled where it was
built:

```
posts-grid              archive / search listing grid
home-hero__lead         big feature
home-hero__latest       numbered 01/02/03 index
showcase__feature-card  text overlaid on image
showcase__compact-card  text + small thumbnail
editorial__card         editorial row
category-pair__card     Science | Environment 50/50
sidebar__latest         recent posts with thumbnails
post-navigation__item   previous / next
```

The variety is deliberate — it is how the homepage signals rank — but the
treatments share no vocabulary. Corner radius, metadata presentation and type
size were each decided locally, so nine cards look like nine authors.

The editor supplied a reference design and asked for its card treatment: small
type, restrained rounded corners, and a chip-style category label.

## Approved inputs

The reference is a portfolio grid. Its card has five separable ingredients:

1. Filled surface with padding and a large radius
2. Inner image with its own smaller radius
3. A chip pair — filled primary chip, outlined secondary chip
4. Small type
5. An action link (`View project →`)

## Decisions

1. **Ingredients 2–4 become site-wide primitives.** All nine treatments adopt
   the radius scale, the chip pair and the type scale. This is what makes them
   one family.

2. **Ingredient 1 — the filled box — applies only to listing cards.** Applying
   it everywhere flattens the homepage: the lead story, the numbered index and
   the photo-overlay cards would become the same object, leaving nothing to
   signal what to read first. The hierarchy the homepage builds is worth more
   than uniformity.

3. **Ingredient 5 is dropped.** On this theme's cards the image and the title
   already link to the post. A third link to the same destination makes screen
   reader users traverse it three times for no gain, and needs a new Tamil
   string that has no editorial source. If the arrow is wanted later, the
   correct form is a fully clickable card with the arrow as decoration — a
   larger change, deliberately deferred.

## Radius scale

Four tokens, declared once on `:root` in `style.css`:

| Token | Value | Applies to |
|---|---|---|
| `--parimaanam-radius-card` | `1rem` | filled card boxes |
| `--parimaanam-radius-media` | `0.625rem` | images inside cards |
| `--parimaanam-radius-chip` | `0.375rem` | meta chips |
| `--parimaanam-radius-control` | `0.5rem` | inputs, buttons, search field |

`settings.border.radius` stays `false` in `theme.json`. That setting only hides
the radius control from the block editor; theme CSS is unaffected. Leaving it
off keeps editors from introducing values outside the scale.

`styles.blocks.core/post-featured-image.border.radius` is currently pinned to
`0` and moves to the media token.

## Chip pair

Replaces the current category rule and date glyph in card metadata.

**Category chip** — `accent` fill, near-black text, `0.8125rem`, weight 600,
`0.125rem 0.5rem` padding, chip radius.

**Date chip** — transparent fill, `1px` `line` border, `muted` text, otherwise
identical.

The lime reads at 15.5:1 against `paper` and 16.4:1 behind near-black text, so
the chip is legible as a fill in either direction.

The chip pair applies to card metadata **and** to the single-post article
header, which presents the same two facts in the same order.

### Superseded work

This removes four rules shipped in `0.40.0`:

- `.posts-grid__category::before` and `.article-header__category::before`, the
  2px accent rules the chip fill replaces
- the calendar glyph on `.posts-grid__date`, replaced by the outlined chip

`--parimaanam-icon-calendar` stays. `style.css:286` is a shared rule serving
both `.article-header__meta .wp-block-post-date::before` and
`.posts-grid__date::before`; only the second selector is removed, so the glyph
survives on the article header where no chip replaces it.

### Letter-spacing must go

Both `.posts-grid__category a` (`style.css:102`) and
`.article-header__category a` (`style.css:266`) carry `letter-spacing:
0.04em`. This is a Latin typography habit and it is harmful in Tamil: it
visually detaches combining vowel signs (ெ, ா, ி) from the consonant they
attach to, breaking the grapheme cluster the reader scans for. Both are
removed.

The theme's one remaining `letter-spacing` — `header.css:133`, at `0.08em` —
is correct and stays. It applies to a CSS counter rendering Latin digits
(`01`, `02`), not to Tamil text.

## Type scale

| | Current (desktop) | Target |
|---|---|---|
| Card title | 24px | 18px |
| Excerpt | 18px | 15px |
| Chip | 14px | 13px |

Mobile is already close after `0.40.1` (16px title, 15px excerpt) and changes
little.

**15px is the floor for body copy.** The reference runs body text at ~14px.
Tamil is not Latin at the same size — its glyphs carry more internal structure
and more combining marks, so the size at which strokes start to merge is
higher. The requested reduction is honoured everywhere else; excerpt text stops
at 15px.

## Filled box scope

Applies to `posts-grid` and `category-pair__card`: `surface` fill, `1.25rem`
padding, card radius, media radius on the image within.

`sidebar__latest` is excluded. Those are thumbnail rows in a narrow column;
filled boxes stacked there read as clutter rather than structure. It takes the
radius, chips and type scale like everything else, without the fill.

In dark mode the fill is `surface` `#1e1e1e` against `paper` `#090909` — a
quiet but visible step.

## Out of scope

- Light/dark theme switching. Specified separately; see below.
- Renaming the `crimson` colour slug to something the value no longer
  contradicts.
- Fully clickable cards.

## Appendix: light palette, captured for the follow-on project

The editor supplied a light colour scheme while scoping this work. Recorded
here so it is not lost; it belongs to the light/dark project, not this one.

| Slot | Dark | Light |
|---|---|---|
| `paper` | `#090909` | `#ffffff` |
| `band` | `#141414` | `#f7f7f7` |
| `surface` | `#1e1e1e` | `#f1f1f1` |
| `ink` | `#f3efee` | `#16181d` |
| `muted` | `#b9aaa8` | `#6e7076` |
| `accent` | `#c5f27e` | `#c5f27e` |
| `accent-hover` | `#d9f7a6` | `#b2e963` |
| `line` | `#2e372a` | `#e3e4e6` |
| `highlight` | `#3d4f22` | `#e4f7c4` |

Two findings from that reference worth carrying forward:

- **The masthead stays dark in both modes.** This removes the light-mode logo
  problem entirely — the logo is a single `#e6e6e6` fill and would be invisible
  on white, and Core's Site Logo block renders one image regardless of theme.
- **The accent is identical in both modes** because it is only ever a fill.
  Lime as *text* on white is 1.3:1 and unusable. The chip treatment specified
  above is what makes a single accent value viable across both skins, which is
  why this project is sequenced first.

Five values bypass the preset variables and will need attention in that
project: the `graphite-ascend` gradient, four hardcoded `rgba(9, 9, 9, …)`
image scrims in `homepage.css` and `search-overlay.css`, a black `box-shadow`
in `header.css`, `color-scheme: dark` in `theme.json`, and the block editor
canvas, which cannot follow a front-end toggle.
