# Card design language Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Give the theme's nine post-card treatments one shared vocabulary — a
four-token radius scale, a chip pair for metadata, and a reduced type scale —
with a filled card box on the archive listing grid only.

**Architecture:** Pure CSS and `theme.json` presets; no PHP logic and no new
JavaScript. Chips are built as a reusable `.parimaanam-chip` primitive in
`style.css` applied through classes the block patterns already emit, so block
markup barely changes. Radius values are declared once as custom properties on
`:root` and referenced everywhere, matching how `--parimaanam-icon-calendar`
was handled.

**Tech Stack:** WordPress 7.0.2 block theme, `theme.json` v3, plain CSS.

## Global Constraints

- Spec: `docs/superpowers/specs/2026-07-30-card-design-language-design.md`.
- Branch: `theme/card-design-language`. Never commit to `main`; open a PR at
  the end via `gh pr create`.
- No Claude Code footer in commit messages.
- Commands are for **Git Bash on Windows 11**.
- Never answer Core's `!important` with `!important`. Core's
  `has-*-font-size` classes carry `!important`; override them by redefining
  the preset custom property in scope. This technique is already used at
  `style.css:144` — follow it.
- **No `letter-spacing` on Tamil text**, ever. The only permitted use is
  `header.css:133`, which spaces Latin digits from a CSS counter.
- **15px is the floor for body copy.** Do not take excerpt text to 14px.
- CSS custom properties are invalid inside media query conditions. Breakpoints
  stay literal, per the BREAKPOINTS block at `style.css:20`.
- `settings.border.radius` stays `false` in `theme.json`. It only hides the
  editor control; theme CSS is unaffected.
- Bump `Version:` in `style.css` once, in the final task, to `0.42.0`. The
  pattern file list is cached against this value, so patterns will not
  reload in WordPress until it changes.

## Verification method

This theme has no test runner. Every task is verified by measuring the running
site at `http://localhost:8080/` through the browser tool and comparing
computed styles against exact expected values. Each task states the selector,
the property, and the number to expect. A task is not done until the
measurement matches.

Two pages carry most of the work:

- `http://localhost:8080/?s=%E0%AE%85` — search results, exercises `posts-grid`
- `http://localhost:8080/internet-addiction/` — single post, exercises
  `article-header` and `article-sidebar`

## File structure

| File | Responsibility in this change |
|---|---|
| `style.css` | radius tokens, `.parimaanam-chip` primitive, posts-grid + article-header meta, type scale, filled card box |
| `theme.json` | featured-image radius, control radius on button/quote/search/comment inputs |
| `assets/css/homepage.css` | media radius and chip adoption on homepage cards |
| `assets/css/search-overlay.css` | control radius on the overlay input |
| `patterns/posts-grid.php` | chip classes on the date |
| `patterns/home-category-pair.php` | chip class on the date |
| `CHANGELOG.md`, `README.md` | record the change and its rationale |

---

### Task 1: Radius scale tokens

**Files:**
- Modify: `style.css:53-55` (`:root` block)
- Modify: `theme.json:213` (button), `:350` (featured image), `:391` (quote), `:311` and `:408` (form input CSS strings)
- Modify: `assets/css/search-overlay.css:81`, `:103`
- Modify: `style.css:568` (sidebar archives select)

**Interfaces:**
- Consumes: nothing.
- Produces: four custom properties every later task references —
  `--parimaanam-radius-card` (`1rem`), `--parimaanam-radius-media`
  (`0.625rem`), `--parimaanam-radius-chip` (`0.375rem`),
  `--parimaanam-radius-control` (`0.5rem`).

- [ ] **Step 1: Add the tokens to the existing `:root` block**

Replace the `:root` block at `style.css:53` so it declares both the icon and
the radius scale. Keep the existing comment above it and add the scale
comment:

```css
:root {
	--parimaanam-icon-calendar: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M19 4h-1V2h-1.5v2h-9V2H6v2H5C3.9 4 3 4.9 3 6v13c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm.5 15c0 .3-.2.5-.5.5H5c-.3 0-.5-.2-.5-.5V9h15v10zm0-11.5h-15V6c0-.3.2-.5.5-.5h14c.3 0 .5.2.5.5v1.5z'/%3E%3C/svg%3E");

	/*
	 * Four radius steps, and no others. The scale is deliberately shallow:
	 * corners this size read as intentional, while a wider spread starts to
	 * look like several unrelated components sharing a page.
	 *
	 * `settings.border.radius` stays false in theme.json so the block editor
	 * offers no radius control, which keeps editors from introducing values
	 * outside this scale.
	 */
	--parimaanam-radius-card: 1rem;
	--parimaanam-radius-media: 0.625rem;
	--parimaanam-radius-chip: 0.375rem;
	--parimaanam-radius-control: 0.5rem;
}
```

- [ ] **Step 2: Point the featured image at the media token**

`theme.json:348-353` currently pins featured images to radius `0`. Change the
value:

```json
      "core/post-featured-image": {
        "border": {
          "radius": "var(--parimaanam-radius-media)"
        },
        "css": "& { overflow: hidden; }"
      },
```

- [ ] **Step 3: Point the controls at the control token**

Three places in `theme.json` use `0.25rem`. Change each to
`var(--parimaanam-radius-control)`:

- `elements.button.border.radius` (line ~213)
- `styles.blocks.core/quote.border.radius` (line ~391)
- inside the `core/post-comments-form` css string (line ~311), change
  `border-radius: 0.25rem;` to
  `border-radius: var(--parimaanam-radius-control);`
- inside the `core/search` css string (line ~408), the same change

- [ ] **Step 4: Update the two remaining hardcoded radii**

`assets/css/search-overlay.css:81` — change `border-radius: 0;` to
`border-radius: var(--parimaanam-radius-control);`

`assets/css/search-overlay.css:103` — change `border-radius: 0.25rem;` to
`border-radius: var(--parimaanam-radius-control);`

`style.css:568` — change `border-radius: 0;` to
`border-radius: var(--parimaanam-radius-control);`

- [ ] **Step 5: Measure**

Load `http://localhost:8080/?s=%E0%AE%85` and evaluate:

```js
JSON.stringify({
  media: getComputedStyle(document.querySelector('.posts-grid .wp-block-post-featured-image img')).borderRadius,
  token: getComputedStyle(document.documentElement).getPropertyValue('--parimaanam-radius-card').trim()
})
```

Expected: `media` is `10px`, `token` is `1rem`.

If `media` is `0px`, WordPress is serving a cached `theme.json`. Bump nothing —
instead reload once; `theme.json` is not pattern-cached and should apply
immediately.

- [ ] **Step 6: Commit**

```bash
git add style.css theme.json assets/css/search-overlay.css
git commit -m "Declare a four-step radius scale

Corner radius had been decided locally at each site that needed one, which
left the theme with 0, 0.25rem and nothing in between. Four tokens on :root
replace every hardcoded value.

The scale is deliberately shallow. settings.border.radius stays false in
theme.json so the editor offers no radius control, which is what keeps the
scale a scale rather than a suggestion."
```

---

### Task 2: The chip primitive

**Files:**
- Modify: `style.css` — insert after the `.page-title` rules (~line 80), before the posts-grid meta section

**Interfaces:**
- Consumes: `--parimaanam-radius-chip` from Task 1.
- Produces: `.parimaanam-chip` (base), `.parimaanam-chip--accent` (lime fill),
  `.parimaanam-chip--outline` (bordered). Tasks 3 and 6 apply these.

- [ ] **Step 1: Add the primitive**

```css
/*
 * Metadata chips. Two variants carry every category and date label in the
 * theme: a filled lime chip for the category, an outlined chip for the date.
 *
 * The category is a fill rather than coloured text on purpose. The accent
 * reads at 15.5:1 on paper but only 1.3:1 on white, so it cannot survive as
 * a text colour in a light theme — as a fill with near-black text on top it
 * is legible against either background at one value. The light/dark work
 * that follows depends on this.
 *
 * No letter-spacing. These labels are Tamil, and spacing the glyphs detaches
 * combining vowel signs from the consonant they belong to.
 */
.parimaanam-chip,
.parimaanam-chip a {
	border-radius: var(--parimaanam-radius-chip);
	display: inline-block;
	font-size: 0.8125rem;
	font-weight: 600;
	letter-spacing: normal;
	line-height: 1.4;
	padding: 0.125rem 0.5rem;
	text-decoration: none;
}

.parimaanam-chip {
	padding: 0;
}

.parimaanam-chip--accent a {
	background: var(--wp--preset--color--crimson);
	color: var(--wp--preset--color--paper);
}

.parimaanam-chip--accent a:hover {
	background: var(--wp--preset--color--crimson-hover);
	color: var(--wp--preset--color--paper);
	text-decoration: none;
}

.parimaanam-chip--outline,
.parimaanam-chip--outline a {
	border: 1px solid var(--wp--preset--color--line);
	color: var(--wp--preset--color--muted);
}

.parimaanam-chip--outline {
	border: 0;
	padding: 0;
}

.parimaanam-chip--outline a:hover {
	border-color: var(--wp--preset--color--crimson);
	color: var(--wp--preset--color--ink);
	text-decoration: none;
}
```

The doubled selectors exist because Core renders `core/post-terms` and
`core/post-date` as a wrapper element containing an `<a>`. Padding and
background must land on the `<a>` so the whole chip is the click target;
the wrapper is reset to zero so it does not add a second box.

- [ ] **Step 2: Commit**

```bash
git add style.css
git commit -m "Add the metadata chip primitive

Two variants, filled and outlined, to carry every category and date label.

The category is a fill rather than coloured text because the accent cannot
be text in both themes: lime reads 15.5:1 on paper and 1.3:1 on white. As a
fill with near-black text on top, one accent value works against either
background, which is what lets the light theme reuse it unchanged.

Padding and background sit on the inner anchor rather than Core's wrapper so
the whole chip is clickable, and the wrapper is zeroed so it contributes no
second box."
```

---

### Task 3: Chips on the listing grid and article header

**Files:**
- Modify: `style.css:85-134` (posts-grid meta), `style.css:250-300` (article header meta), `style.css:53-55` (remove the icon property)
- Modify: `patterns/posts-grid.php:17-19`

**Interfaces:**
- Consumes: `.parimaanam-chip*` from Task 2.
- Produces: nothing new.

- [ ] **Step 1: Replace the posts-grid meta rules**

Delete `.posts-grid__category`, `.posts-grid__category::before`,
`.posts-grid__category a`, `.posts-grid__category a:hover` and the
`.posts-grid__date` rules. Replace with:

```css
/*
 * Listing card metadata: a filled category chip beside an outlined date chip.
 * This replaces the accent rule and calendar glyph used before 0.42.0 — the
 * chips mark both facts as metadata without decorating each one separately.
 */
.posts-grid__meta {
	align-items: center;
	row-gap: var(--wp--preset--spacing--30);
}
```

- [ ] **Step 2: Add the chip classes to the pattern**

In `patterns/posts-grid.php`, replace lines 17-19 with:

```php
		<div class="wp-block-group posts-grid__meta has-small-font-size"><!-- wp:post-terms {"term":"category","className":"posts-grid__category parimaanam-chip parimaanam-chip--accent"} /-->

			<!-- wp:post-date {"isLink":true,"className":"posts-grid__date parimaanam-chip parimaanam-chip--outline"} /--></div>
```

- [ ] **Step 3: Replace the article header meta rules**

Delete `.article-header__category::before`, `.article-header__category a`,
`.article-header__category a:hover`, and the shared
`.article-header__meta .wp-block-post-date::before, .posts-grid__date::before`
rule at `style.css:286`. Keep `.article-header__category`'s flex layout and
`.article-header__meta`. The date rules become:

```css
.article-header__meta .wp-block-post-date {
	align-items: center;
	display: flex;
}
```

Then in `templates/single.html`, add the chip classes to the article header's
post-terms and post-date blocks, matching the pattern used in Step 2:
`"className":"article-header__category parimaanam-chip parimaanam-chip--accent"`
and
`"className":"parimaanam-chip parimaanam-chip--outline"`.

- [ ] **Step 4: Delete the now-unused icon property**

Remove the `--parimaanam-icon-calendar` declaration and its comment from the
`:root` block at `style.css:53`. Confirm nothing still references it:

```bash
grep -rn "parimaanam-icon-calendar" . --include=*.css --include=*.json --include=*.php --include=*.html
```

Expected: no output.

- [ ] **Step 5: Measure**

Load `http://localhost:8080/?s=%E0%AE%85` and evaluate:

```js
const a = document.querySelector('.posts-grid__category a');
const d = document.querySelector('.posts-grid__date a');
JSON.stringify({
  chipBg: getComputedStyle(a).backgroundColor,
  chipColor: getComputedStyle(a).color,
  chipRadius: getComputedStyle(a).borderRadius,
  chipSpacing: getComputedStyle(a).letterSpacing,
  dateBorder: getComputedStyle(d).borderTopWidth,
  dateBg: getComputedStyle(d).backgroundColor
})
```

Expected exactly: `chipBg` `rgb(197, 242, 126)`, `chipColor` `rgb(9, 9, 9)`,
`chipRadius` `6px`, `chipSpacing` `normal`, `dateBorder` `1px`, `dateBg`
`rgba(0, 0, 0, 0)`.

Then load `http://localhost:8080/internet-addiction/` and confirm the article
header shows the same two chips and no calendar glyph.

- [ ] **Step 6: Commit**

```bash
git add style.css patterns/posts-grid.php templates/single.html
git commit -m "Replace card meta decoration with chips

The category's 2px accent rule and the date's calendar glyph both existed to
make bare metadata read as designed. The chips do that job for both facts at
once, so keeping either would put a border and an icon around the same four
words. --parimaanam-icon-calendar loses its last consumer and goes with them.

Also drops letter-spacing: 0.04em from both category rules. It is a Latin
typography habit and it is wrong here — in Tamil it detaches combining vowel
signs from the consonant they attach to, breaking the grapheme cluster a
reader scans for. The theme's one remaining letter-spacing, in header.css,
is correct: it spaces Latin digits from a CSS counter."
```

---

### Task 4: Type scale

**Files:**
- Modify: `style.css` — add a desktop-scoped block near the posts-grid rules

**Interfaces:**
- Consumes: nothing.
- Produces: nothing.

- [ ] **Step 1: Reduce the listing card type**

Card titles use `has-large-font-size`, which carries `!important`. Redefine
the preset variable in scope instead — the same technique as `style.css:144`:

```css
/*
 * Listing cards run smaller than the preset scale. Core's has-*-font-size
 * classes carry !important, so the preset variable is redefined in scope and
 * Core's own rule resolves to the smaller value.
 *
 * The excerpt stops at 15px and goes no lower. The reference design this
 * scale came from runs body copy at 14px, but that is a Latin measurement:
 * Tamil glyphs carry more internal structure and more combining marks, so
 * strokes start to merge at a larger size than they do in Latin.
 */
.posts-grid {
	--wp--preset--font-size--large: 1.125rem;
}

.posts-grid .wp-block-post-excerpt {
	font-size: 0.9375rem;
}
```

The existing `@media (max-width: 39.99rem)` block already sets
`--wp--preset--font-size--large: 1rem` and the excerpt to `0.9375rem` for
phones. Leave both; the mobile block still wins by source order, and the
excerpt values now match, which is correct — 15px is the floor at every width.

- [ ] **Step 2: Measure at desktop**

Resize the viewport to 1280 wide, load
`http://localhost:8080/?s=%E0%AE%85`, and evaluate:

```js
JSON.stringify({
  title: getComputedStyle(document.querySelector('.posts-grid .wp-block-post-title')).fontSize,
  excerpt: getComputedStyle(document.querySelector('.posts-grid .wp-block-post-excerpt')).fontSize,
  chip: getComputedStyle(document.querySelector('.posts-grid__category a')).fontSize
})
```

Expected: `title` `18px`, `excerpt` `15px`, `chip` `13px`.

- [ ] **Step 3: Measure at mobile**

Resize to 375 wide, reload the same URL, evaluate the same expression.

Expected: `title` `16px`, `excerpt` `15px`, `chip` `13px`.

If `excerpt` reads `14.4px` at either width, a `has-*-font-size` class is
winning; check whether the excerpt block gained a `fontSize` attribute.

- [ ] **Step 4: Commit**

```bash
git add style.css
git commit -m "Take listing card type down to 18/15

Card titles drop from 24px to 18px and excerpts from 18px to 15px, bringing
the grid closer to the reference design's density.

The excerpt stops at 15px rather than the reference's 14px. That figure was
measured on Latin text, and it does not transfer: Tamil glyphs carry more
internal structure and more combining marks, so strokes begin to merge at a
larger size. 15px is the floor at every width.

Titles are reduced by redefining the preset variable in scope rather than by
declaring a size, because Core's has-large-font-size carries !important and
the alternative is answering !important with !important."
```

---

### Task 5: The filled card box

**Files:**
- Modify: `style.css` — add after the Task 4 block

**Interfaces:**
- Consumes: `--parimaanam-radius-card`, `--parimaanam-radius-media`.
- Produces: nothing.

- [ ] **Step 1: Add the box**

```css
/*
 * The listing grid is the theme's one filled card, and the rule is
 * orientation rather than page: a box traces the outline of an image stacked
 * above its text. Cards whose image sits beside their text — the homepage
 * category pair, the sidebar's recent posts — are rows, and rows are
 * separated by rules. Eight boxes stacked in a half-width column read as
 * clutter rather than structure.
 */
.posts-grid .wp-block-post {
	background: var(--wp--preset--color--surface);
	border-radius: var(--parimaanam-radius-card);
	overflow: hidden;
	padding: var(--wp--preset--spacing--40);
}

.posts-grid .wp-block-post-featured-image img {
	border-radius: var(--parimaanam-radius-media);
}
```

- [ ] **Step 2: Measure**

Load `http://localhost:8080/?s=%E0%AE%85` at 1280 wide:

```js
const c = document.querySelector('.posts-grid .wp-block-post');
JSON.stringify({
  bg: getComputedStyle(c).backgroundColor,
  radius: getComputedStyle(c).borderRadius,
  pad: getComputedStyle(c).paddingTop,
  img: getComputedStyle(document.querySelector('.posts-grid .wp-block-post-featured-image img')).borderRadius,
  overflowX: document.documentElement.scrollWidth > document.documentElement.clientWidth
})
```

Expected: `bg` `rgb(30, 30, 30)`, `radius` `16px`, `pad` `24px`, `img` `10px`,
`overflowX` `false`.

The padding is `spacing|40`, which resolves to `24px`, not the `1.25rem` the
spec estimated. Use the spacing preset rather than a literal — the theme has
a spacing scale and this should sit on it.

- [ ] **Step 3: Check the grid still fits**

The cards gained 48px of horizontal padding each, which changes how
`minimumColumnWidth: 26rem` packs them. At 1280 confirm the grid still shows
the intended number of columns and no card is orphaned on its own row. Resize
through 1024, 900 and 768 and confirm the same.

If a column count regresses, adjust `minimumColumnWidth` in
`patterns/posts-grid.php:12` — not the padding.

- [ ] **Step 4: Commit**

```bash
git add style.css patterns/posts-grid.php
git commit -m "Give listing cards a filled box

Surface fill, 16px corners, 24px padding, 10px on the image within.

Scope is orientation, not page. A box traces the outline of an image stacked
above its text, which describes the listing grid and nothing else. The
homepage category pair and the sidebar's recent posts put their image beside
their text; those are rows, and rows are separated by rules. The homepage's
feature and overlay cards are art-directed and keep their own treatment.

All of them still take the radius scale, the chips and the type scale, which
is what makes them one family without making them one shape."
```

---

### Task 6: Propagate to the homepage and sidebar cards

**Files:**
- Modify: `assets/css/homepage.css` — category-pair, showcase, editorial, hero card media radius
- Modify: `patterns/home-category-pair.php:54`
- Modify: `style.css` — sidebar latest media radius

**Interfaces:**
- Consumes: `.parimaanam-chip*`, radius tokens.
- Produces: nothing.

- [ ] **Step 1: Round the homepage card media**

In `assets/css/homepage.css`, the featured images inside
`.home-category-pair__card`, `.home-category-showcase__compact-card` and
`.home-category-editorial__card` each already set `overflow: hidden`. Add
`border-radius: var(--parimaanam-radius-media);` to each of those existing
rules.

Leave `.home-category-showcase__feature-card` and `.home-hero__lead` alone —
those are full-bleed images with text overlaid, and rounding them would leave
the overlay gradient's corners exposed.

- [ ] **Step 2: Chip the category-pair date**

In `patterns/home-category-pair.php`, replace line 54:

```php
					<!-- wp:post-date {"isLink":true,"className":"parimaanam-chip parimaanam-chip--outline","fontSize":"small"} /-->
```

- [ ] **Step 3: Round the sidebar thumbnails**

In `style.css`, add to the `.article-sidebar__latest .wp-block-latest-posts__featured-image` rule:

```css
	border-radius: var(--parimaanam-radius-media);
	overflow: hidden;
```

- [ ] **Step 4: Measure**

Load `http://localhost:8080/` at 1280 wide:

```js
JSON.stringify({
  pairImg: getComputedStyle(document.querySelector('.home-category-pair__card .wp-block-post-featured-image')).borderRadius,
  pairDate: getComputedStyle(document.querySelector('.home-category-pair__card .wp-block-post-date a')).borderTopWidth,
  featureImg: getComputedStyle(document.querySelector('.home-category-showcase__feature-card .wp-block-post-featured-image')).borderRadius
})
```

Expected: `pairImg` `10px`, `pairDate` `1px`, `featureImg` `0px`.

- [ ] **Step 5: Visual check at three widths**

Screenshot the homepage at 1280, 768 and 375. Confirm the hero, the numbered
index, the category pair and the showcase all read as one family, and that
the lead story still reads as the lead.

- [ ] **Step 6: Commit**

```bash
git add assets/css/homepage.css patterns/home-category-pair.php style.css
git commit -m "Bring the homepage and sidebar cards into the scale

Thumbnails in the category pair, the compact showcase cards, the editorial
row and the sidebar's recent posts all take the media radius, and the
category pair's date becomes an outlined chip.

The hero lead and the showcase feature card keep square corners. Those are
full-bleed images with text overlaid on a gradient that runs to the edge;
rounding the image would leave the gradient's corners standing proud of it."
```

---

### Task 7: Document and open the PR

**Files:**
- Modify: `CHANGELOG.md`, `README.md`, `style.css:6`

- [ ] **Step 1: Bump the version**

`style.css:6` — `Version: 0.41.0` becomes `Version: 0.42.0`. WordPress caches
the pattern file list against this value, so the pattern changes in Tasks 3
and 6 will not appear until it moves.

- [ ] **Step 2: Write the changelog entry**

Add a `0.42.0` section to `CHANGELOG.md` in the existing house style,
covering: the radius scale, the chip primitive and what it replaced, the type
scale and the 15px Tamil floor, the filled box and its orientation rule, and
the letter-spacing removal.

- [ ] **Step 3: Update the README**

The README documents the theme's conventions. Add the radius scale to it
alongside the existing breakpoint and spacing documentation, and note the
no-letter-spacing-on-Tamil rule.

- [ ] **Step 4: Full-site regression pass**

Walk these at 1280 and 375, confirming nothing is broken:

- `/` homepage
- `/?s=%E0%AE%85` search results
- `/category/astronomy/` archive
- `/internet-addiction/` single post
- a 404 URL

Check specifically that the search overlay still opens, that the mobile
navigation still opens, and that no page scrolls horizontally.

- [ ] **Step 5: Commit and open the PR**

```bash
git add CHANGELOG.md README.md style.css
git commit -m "Document the card design language at 0.42.0"
git push -u origin theme/card-design-language
gh pr create --title "Card design language: radius scale, meta chips, tighter type" --body "Implements docs/superpowers/specs/2026-07-30-card-design-language-design.md.

Gives the theme's nine post-card treatments one shared vocabulary: a four-token radius scale, a filled/outlined chip pair for metadata, and a listing type scale of 18/15.

The filled card box is scoped by orientation rather than by page — it goes on the archive grid, whose image sits above its text, and not on the row-shaped cards in the homepage category pair or the sidebar. All nine treatments take the radius, chips and type scale, so they read as one family without becoming one shape.

Two things worth a reviewer's attention:

- The accent is now a chip fill rather than coloured text. This is what makes the follow-on light theme possible at a single accent value: lime reads 15.5:1 on paper but 1.3:1 on white, so it cannot be text in both.
- letter-spacing: 0.04em is removed from both category rules. It detaches Tamil combining vowel signs from their base consonant. The remaining instance in header.css is correct and stays — it spaces Latin digits from a CSS counter.

Also carries the crimson-to-lime accent swap and the design spec."
```

---

## Self-review

**Spec coverage.** Radius scale → Task 1. Chip pair → Tasks 2, 3, 6. Article
header chips → Task 3. Superseded rules and the icon property → Task 3.
Letter-spacing → Task 3. Type scale and the 15px floor → Task 4. Filled box
and its orientation rule → Task 5. Homepage and sidebar propagation → Task 6.
Docs → Task 7. No gaps.

**Two corrections applied to the spec during planning**, both from reading the
code rather than the prose:

1. `home-category-pair__card` is a `5rem`-thumbnail row separated by `1px`
   borders — structurally identical to `sidebar__latest`, which the spec had
   already excluded from the filled box for exactly that reason. Including one
   and excluding the other was incoherent. The rule is now orientation-based
   and the box lands only on `posts-grid`.
2. The spec said the chip pair applies to the article header *and* that the
   calendar glyph survives there. Both cannot be true — the glyph and the
   outlined date chip mark the same words. The glyph is retired and
   `--parimaanam-icon-calendar` is deleted.

**One estimate corrected.** The spec's `1.25rem` card padding is replaced by
`spacing|40` (`24px`), so the box sits on the theme's spacing scale instead of
introducing a literal beside it.
