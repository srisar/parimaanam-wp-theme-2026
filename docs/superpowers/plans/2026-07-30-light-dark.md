# Light and dark themes Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Give readers a light skin and a dark skin of equal quality, following
their operating system by default and remembering an explicit choice.

**Architecture:** `light-dark()` driven by `color-scheme`, redefining the nine
`--wp--preset--color--*` variables that every rule in the theme already reads.
No per-component work. The masthead and footer keep the dark palette by
re-pinning those same variables inside their subtrees. JavaScript is needed
only to record an explicit choice; the operating-system default is pure CSS.

**Tech Stack:** WordPress 7.0.2 block theme, `theme.json` v3, plain CSS, one
vanilla JS file plus a small inline head script.

## Global Constraints

- Spec: `docs/superpowers/specs/2026-07-30-light-dark-design.md`.
- Branch: `theme/light-dark`, cut from `main` **after** PR #16 merges. Never
  commit to `main`; open a PR via `gh pr create`.
- No Claude Code footer in commit messages.
- Commands are for **Git Bash on Windows 11**.
- The `@supports (color: light-dark(#fff, #000))` guard is mandatory around
  every `light-dark()` declaration. Custom properties validate at use, not at
  declaration, so an unguarded block makes the property guaranteed-invalid on
  unsupporting browsers rather than falling back.
- **Never** let `paper` or `ink` carry text that sits on an accent fill or on
  a photograph. Use `--parimaanam-on-accent` / `--parimaanam-on-media`.
- No `letter-spacing` on Tamil text.
- Breakpoints stay literal; custom properties are invalid in media conditions.
- Bump `Version:` in `style.css` once, in the final task, to `0.43.0`.

## Verification method

No test runner. Every task is verified by measuring computed styles against
`http://localhost:8080/` in **both** skins, forced with:

```js
document.documentElement.setAttribute('data-theme', 'light');   // or 'dark'
```

A helper used throughout — paste and call with a selector list:

```js
const probe = (pairs) => {
  const out = {};
  for (const [name, sel, prop] of pairs) {
    const el = document.querySelector(sel);
    out[name] = el ? getComputedStyle(el)[prop] : 'MISSING';
  }
  return JSON.stringify(out, null, 1);
};
```

Contrast is checked with this, which returns a WCAG ratio from two computed
`rgb()` strings:

```js
const ratio = (a, b) => {
  const lum = (s) => {
    const [r, g, bl] = s.match(/\d+(\.\d+)?/g).slice(0, 3).map(Number)
      .map(v => v / 255)
      .map(v => v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4));
    return 0.2126 * r + 0.7152 * g + 0.0722 * bl;
  };
  const [x, y] = [lum(a), lum(b)].sort((p, q) => q - p);
  return ((x + 0.05) / (y + 0.05)).toFixed(2);
};
```

## File structure

| File | Responsibility |
|---|---|
| `assets/css/color-scheme.css` | **new** — the two palettes, the fixed tokens, the dark island |
| `assets/js/theme-toggle.js` | **new** — click handling, persistence, button state |
| `patterns/theme-toggle.php` | **new** — the button markup |
| `functions.php` | enqueue the stylesheet and script; print the inline head script |
| `theme.json` | drop `color-scheme: dark`; repoint button text to the fixed token |
| `style.css` | repoint chip text to the fixed token |
| `assets/css/search-overlay.css` | repoint submit text to the fixed token |
| `assets/css/homepage.css` | rename the two scrims to the scrim token |
| `parts/header.html`, `patterns/header-navigation.php` | place the toggle |
| `CHANGELOG.md`, `README.md` | record the change |

---

### Task 1: The two palettes

**Files:**
- Create: `assets/css/color-scheme.css`
- Modify: `functions.php:63` (stylesheet loop), `theme.json` (`styles.css`)

**Interfaces:**
- Produces: `[data-theme]` on `<html>` as the switch; the nine
  `--wp--preset--color--*` variables resolving per skin.

- [ ] **Step 1: Create the stylesheet**

```css
/*
 * The light and dark palettes.
 *
 * theme.json holds the dark values, so every consumer has a working default
 * and a browser that never reaches this file renders the theme as it shipped
 * before 0.43.0. This file redefines the same nine preset variables through
 * light-dark(), which resolves against the computed color-scheme.
 *
 * Every rule in the theme already reads these variables, including Core's own
 * has-*-background-color utilities, so nine declarations reskin the site.
 */

:root {
	color-scheme: light dark;
}

:root[data-theme="light"] {
	color-scheme: light;
}

:root[data-theme="dark"] {
	color-scheme: dark;
}

/*
 * The guard is not optional. Custom properties validate at use rather than at
 * declaration, so without it a browser lacking light-dark() would accept these
 * declarations and then fail when the value is consumed — leaving the property
 * guaranteed-invalid and the site unstyled. Inside the guard, such a browser
 * never sees them and keeps theme.json's dark values.
 */
@supports (color: light-dark(#fff, #000)) {
	:root {
		--wp--preset--color--paper: light-dark(#ffffff, #090909);
		--wp--preset--color--band: light-dark(#f7f7f7, #141414);
		--wp--preset--color--surface: light-dark(#f1f1f1, #1e1e1e);
		--wp--preset--color--ink: light-dark(#16181d, #f3efee);
		--wp--preset--color--muted: light-dark(#67696f, #b9aaa8);
		--wp--preset--color--crimson: light-dark(#c5f27e, #c5f27e);
		--wp--preset--color--crimson-hover: light-dark(#b2e963, #d9f7a6);
		--wp--preset--color--line: light-dark(#e3e4e6, #2e372a);
		--wp--preset--color--highlight: light-dark(#e4f7c4, #3d4f22);
	}
}
```

The accent is one value in both skins because it is only ever a fill. `muted`
is `#67696f`, not the sampled `#6e7076`, which measures 4.45:1 on the card
surface — under AA for the excerpt text it carries.

- [ ] **Step 2: Enqueue it**

`functions.php:63` — add `color-scheme` to the loop:

```php
	foreach ( array( 'color-scheme', 'header', 'homepage', 'footer', 'search-overlay' ) as $parimaanam_stylesheet ) {
```

It goes first so later files can override it if they ever need to.

- [ ] **Step 3: Remove the pinned scheme from theme.json**

`theme.json`'s `styles.css` string begins
`:root { color-scheme: dark; } ::selection {…`. Delete only the
`:root { color-scheme: dark; } ` portion, leaving `::selection` and the
`:focus-visible` rule intact. Leaving it would pin every reader to dark and
defeat the mechanism.

- [ ] **Step 4: Measure both skins**

Load `http://localhost:8080/` and run:

```js
(() => {
  const read = () => {
    const cs = getComputedStyle(document.documentElement);
    return ['paper','band','surface','ink','muted','crimson','line','highlight']
      .reduce((o, k) => (o[k] = cs.getPropertyValue('--wp--preset--color--' + k).trim(), o), {});
  };
  document.documentElement.setAttribute('data-theme', 'light');
  const light = read();
  document.documentElement.setAttribute('data-theme', 'dark');
  const dark = read();
  document.documentElement.removeAttribute('data-theme');
  return JSON.stringify({ light, dark }, null, 1);
})()
```

Expected: `light.paper` resolves to `#ffffff` (or `rgb(255, 255, 255)`),
`dark.paper` to `#090909`, and `crimson` identical in both.

- [ ] **Step 5: Commit**

```bash
git add assets/css/color-scheme.css functions.php theme.json
git commit -m "Add the light and dark palettes"
```

---

### Task 2: The three fixed tokens

**Files:**
- Modify: `assets/css/color-scheme.css` (declare the tokens)
- Modify: `style.css:132`, `:137`; `assets/css/search-overlay.css:109`; `theme.json:219`, `:236`
- Modify: `assets/css/homepage.css:105`, `:286`; `theme.json:308`

**Interfaces:**
- Consumes: nothing.
- Produces: `--parimaanam-on-accent`, `--parimaanam-on-media`,
  `--parimaanam-scrim-rgb`.

- [ ] **Step 1: Declare the tokens**

Append to the first `:root` block in `assets/css/color-scheme.css`:

```css
:root {
	color-scheme: light dark;

	/*
	 * Three colours that hold one value in both skins.
	 *
	 * Text on an accent fill and text over a photograph do not care which skin
	 * the page is in — the surface beneath them is the same either way. Using
	 * paper or ink for these is the mistake this file exists to prevent: paper
	 * as text on the lime fill measures 15.5:1 in dark and 1.3:1 in light.
	 */
	--parimaanam-on-accent: #0d0f0c;
	--parimaanam-on-media: #f3efee;
	--parimaanam-scrim-rgb: 9, 9, 9;
}
```

- [ ] **Step 2: Repoint the five accent-text sites**

`style.css:132` and `:137`, inside `.parimaanam-chip--accent a` and its
`:hover` — change `color: var(--wp--preset--color--paper);` to
`color: var(--parimaanam-on-accent);`

`assets/css/search-overlay.css:109`, inside `.site-search__submit` — the same
change.

`theme.json` `elements.button.color.text` and
`elements.button[":hover"].color.text` — change
`"var:preset|color|paper"` to `"var(--parimaanam-on-accent)"`.

- [ ] **Step 3: Repoint the scrims**

`assets/css/homepage.css:105`:

```css
	background: linear-gradient(180deg, rgba(var(--parimaanam-scrim-rgb), 0.02) 15%, rgba(var(--parimaanam-scrim-rgb), 0.2) 42%, rgba(var(--parimaanam-scrim-rgb), 0.97) 100%);
```

`assets/css/homepage.css:286`:

```css
	background: linear-gradient(180deg, transparent 18%, rgba(var(--parimaanam-scrim-rgb), 0.92) 100%) !important;
```

`theme.json:308`, inside the `core/group` css string, the
`home-category-showcase__feature-card::after` gradient — the same substitution
for its `rgba(9, 9, 9, 0.94)`.

These stay dark in both skins. The rename exists so the next reader can see
the value is deliberate rather than a stale copy of `paper`.

- [ ] **Step 4: Pin text over media**

In `assets/css/homepage.css`, the hero lead content and the showcase feature
content set text colour from `ink`. Change those to
`var(--parimaanam-on-media)`. Search for them with:

```bash
grep -n "lead-content\|feature-content\|feature-card .wp-block-post-date" assets/css/homepage.css theme.json
```

- [ ] **Step 5: Measure contrast in both skins**

```js
(() => {
  const set = t => document.documentElement.setAttribute('data-theme', t);
  const chip = () => {
    const a = document.querySelector('.parimaanam-chip--accent a');
    return [getComputedStyle(a).color, getComputedStyle(a).backgroundColor];
  };
  const out = {};
  for (const t of ['light', 'dark']) { set(t); const [c, b] = chip(); out[t] = ratio(c, b); }
  document.documentElement.removeAttribute('data-theme');
  return JSON.stringify(out);
})()
```

Run on `/?s=%E0%AE%85`. Expected: both skins **≥ 15**, and near-identical.
Anything near 1.3 means a `paper` reference was missed.

- [ ] **Step 6: Commit**

```bash
git add -A
git commit -m "Pin the three colours that must not flip"
```

---

### Task 3: The dark island

**Files:**
- Modify: `assets/css/color-scheme.css`

- [ ] **Step 1: Re-pin the palette on the masthead and footer**

```css
/*
 * The masthead and footer keep the dark palette in both skins.
 *
 * Re-pinning the variables is what makes this free: has-band-background-color
 * and every colour reference in footer.css resolve to dark values with no
 * markup change and no per-rule overrides. header.css needs nothing at all —
 * the masthead's gradient is literal hex and was already dark in both.
 *
 * The logo is a single #e6e6e6 fill and Core's Site Logo block renders one
 * image whatever the theme, so a light masthead would need a second asset the
 * publication does not have. Keeping it dark also keeps the identity in
 * daylight rather than turning the site into a generic white blog.
 *
 * color-scheme is set too, so the search field and any other native control
 * inside these regions renders dark to match.
 */
.site-header,
.site-footer {
	color-scheme: dark;
	--wp--preset--color--paper: #090909;
	--wp--preset--color--band: #141414;
	--wp--preset--color--surface: #1e1e1e;
	--wp--preset--color--ink: #f3efee;
	--wp--preset--color--muted: #b9aaa8;
	--wp--preset--color--crimson: #c5f27e;
	--wp--preset--color--crimson-hover: #d9f7a6;
	--wp--preset--color--line: #2e372a;
	--wp--preset--color--highlight: #3d4f22;
}
```

- [ ] **Step 2: Measure that they do not move**

```js
(() => {
  const grab = () => JSON.stringify([
    getComputedStyle(document.querySelector('.site-header')).backgroundColor,
    getComputedStyle(document.querySelector('.site-footer')).backgroundColor,
    getComputedStyle(document.querySelector('.site-footer a')).color
  ]);
  const set = t => document.documentElement.setAttribute('data-theme', t);
  set('light'); const l = grab();
  set('dark');  const d = grab();
  document.documentElement.removeAttribute('data-theme');
  return JSON.stringify({ light: l, dark: d, identical: l === d });
})()
```

Expected: `identical` is `true`.

- [ ] **Step 3: Confirm the search overlay follows**

Open the overlay in light mode and confirm the field and submit button are
still the dark treatment. The `<dialog>` is inside `.site-header`, so this
should happen with no extra rule; if it does not, the island is not applying
and Step 1 needs revisiting rather than a new override being added.

- [ ] **Step 4: Commit**

```bash
git add assets/css/color-scheme.css
git commit -m "Keep the masthead and footer dark in both skins"
```

---

### Task 4: The toggle control

**Files:**
- Create: `patterns/theme-toggle.php`
- Modify: `parts/header.html`, `patterns/header-navigation.php`
- Modify: `assets/css/header.css`

**⚠ Blocked on editorial sign-off.** The two Tamil labels below are proposals,
not approved copy. Core translates `Dark` as அடர்ந்த (*dense*) and `Light` as
ஒளி (*illumination*) — both the wrong sense for a theme switch, so unlike the
404 and navigation strings these cannot reuse Core's translations. Implement
with the strings below and record them in the README's
"Awaiting editorial approval" section; swapping them later is a one-line
change in this file.

- [ ] **Step 1: Create the pattern**

```php
<?php
/**
 * Title: Theme toggle
 * Slug: parimaanam-2026/theme-toggle
 * Inserter: no
 */

/*
 * Hidden until the inline head script marks the document script-capable, so a
 * reader without JavaScript is never shown a control that cannot work. They
 * still get their operating system's preference, which is expressed in CSS.
 */
$parimaanam_to_light = esc_attr_x( 'ஒளிர் தோற்றத்திற்கு மாற்று', 'Theme toggle: switch to the light theme', 'parimaanam-2026' );
$parimaanam_to_dark  = esc_attr_x( 'இருண்ட தோற்றத்திற்கு மாற்று', 'Theme toggle: switch to the dark theme', 'parimaanam-2026' );
?>

<!-- wp:html -->
<button class="theme-toggle" type="button" aria-pressed="false"
	data-label-light="<?php echo $parimaanam_to_light; ?>"
	data-label-dark="<?php echo $parimaanam_to_dark; ?>"
	aria-label="<?php echo $parimaanam_to_light; ?>">
	<span class="theme-toggle__icon" aria-hidden="true"></span>
</button>
<!-- /wp:html -->
```

- [ ] **Step 2: Place it**

In `parts/header.html`, add the pattern after the header-search pattern
reference:

```html
		<!-- wp:pattern {"slug":"parimaanam-2026/theme-toggle"} /-->
```

In `patterns/header-navigation.php`, add the same reference inside the
navigation overlay so phones get it there. Read that file first to find the
overlay's inner container.

- [ ] **Step 3: Style it**

Append to `assets/css/header.css`:

```css
/*
 * The control is revealed only once the inline head script has run, so no
 * reader is shown a switch that cannot do anything.
 */
.theme-toggle {
	display: none;
}

.has-theme-toggle .theme-toggle {
	align-items: center;
	background: transparent;
	border: 0;
	border-radius: var(--parimaanam-radius-control);
	color: var(--wp--preset--color--ink);
	cursor: pointer;
	display: flex;
	justify-content: center;
	padding: 0.5rem;
}

.has-theme-toggle .theme-toggle:hover {
	color: var(--wp--preset--color--crimson);
}

/*
 * The glyph is a mask so it inherits the surrounding colour, matching how the
 * theme draws its other decorative icons. It is aria-hidden; the button's
 * label carries the meaning.
 */
.theme-toggle__icon {
	background: currentColor;
	display: block;
	height: 1.5rem;
	mask-image: var(--parimaanam-icon-sun);
	mask-repeat: no-repeat;
	mask-size: contain;
	width: 1.5rem;
}

:root[data-theme="light"] .theme-toggle__icon {
	mask-image: var(--parimaanam-icon-moon);
}
```

Declare the two icons in `assets/css/color-scheme.css`'s `:root` block, as
data-URI masks, following the technique the theme used for the calendar glyph
before `0.42.0` retired it. Use Core's own Dashicon-style sun and moon paths
or any 24×24 outline pair.

- [ ] **Step 4: Verify presence and keyboard access**

```js
(() => {
  const b = document.querySelectorAll('.theme-toggle');
  return JSON.stringify({
    count: b.length,
    tag: b[0] && b[0].tagName,
    label: b[0] && b[0].getAttribute('aria-label'),
    focusable: b[0] && b[0].tabIndex > -1
  });
})()
```

Expected: `count` 2 (masthead and nav overlay), `tag` `BUTTON`, a non-empty
label, `focusable` true.

- [ ] **Step 5: Commit**

```bash
git add -A
git commit -m "Add the theme toggle control"
```

---

### Task 5: Persistence and no flash

**Files:**
- Create: `assets/js/theme-toggle.js`
- Modify: `functions.php`

- [ ] **Step 1: Print the inline head script**

Add to `functions.php`, hooked early on `wp_head` so it runs before paint:

```php
/**
 * Restore the reader's theme choice before first paint.
 *
 * This is inline and unminified on purpose: an external file would be fetched
 * after the document starts rendering, so the reader would see the default
 * skin flash before their choice applied. It is deliberately tiny, does one
 * thing, and swallows storage errors — Safari's private mode throws on
 * localStorage access, and a theme preference is not worth a broken page.
 *
 * The class it adds is what reveals the toggle button, so a reader without
 * JavaScript is never shown a control that cannot work.
 */
function parimaanam_2026_theme_boot() {
	?>
<script>
(function(){try{var t=localStorage.getItem('parimaanam-theme');if(t==='light'||t==='dark'){document.documentElement.setAttribute('data-theme',t);}}catch(e){}document.documentElement.className+=' has-theme-toggle';})();
</script>
	<?php
}
add_action( 'wp_head', 'parimaanam_2026_theme_boot', 1 );
```

- [ ] **Step 2: Write the toggle script**

```js
/*
 * Records an explicit theme choice.
 *
 * The operating system default needs no JavaScript — color-scheme and
 * light-dark() express it in CSS — so this file only runs when the reader
 * actively chooses, and writing data-theme is what overrides that default.
 *
 * Both buttons (masthead and navigation overlay) stay in sync, because a
 * reader can open the overlay after toggling in the masthead and would
 * otherwise see a stale label.
 */
( function () {
	var buttons = document.querySelectorAll( '.theme-toggle' );

	if ( ! buttons.length ) {
		return;
	}

	function current() {
		var set = document.documentElement.getAttribute( 'data-theme' );

		if ( set === 'light' || set === 'dark' ) {
			return set;
		}

		return window.matchMedia( '(prefers-color-scheme: light)' ).matches ? 'light' : 'dark';
	}

	function paint( theme ) {
		document.documentElement.setAttribute( 'data-theme', theme );

		Array.prototype.forEach.call( buttons, function ( button ) {
			var next = theme === 'light' ? 'dark' : 'light';
			button.setAttribute( 'aria-pressed', theme === 'dark' ? 'true' : 'false' );
			button.setAttribute( 'aria-label', button.getAttribute( 'data-label-' + next ) );
		} );
	}

	paint( current() );

	Array.prototype.forEach.call( buttons, function ( button ) {
		button.addEventListener( 'click', function () {
			var next = current() === 'light' ? 'dark' : 'light';
			paint( next );

			try {
				localStorage.setItem( 'parimaanam-theme', next );
			} catch ( e ) {}
		} );
	} );
}() );
```

- [ ] **Step 3: Enqueue it**

In `parimaanam_2026_enqueue_scripts`, register `theme-toggle.js` alongside the
search overlay script, with the same deferred strategy.

- [ ] **Step 4: Verify persistence and no flash**

```js
(() => {
  localStorage.removeItem('parimaanam-theme');
  document.querySelector('.theme-toggle').click();
  return JSON.stringify({
    stored: localStorage.getItem('parimaanam-theme'),
    attr: document.documentElement.getAttribute('data-theme'),
    pressed: document.querySelector('.theme-toggle').getAttribute('aria-pressed'),
    label: document.querySelector('.theme-toggle').getAttribute('aria-label')
  });
})()
```

Expected: `stored` and `attr` agree, `pressed` matches the new state, and
`label` describes the *next* action rather than the current one.

Then reload and confirm the attribute is present on the very first paint:

```js
JSON.stringify({
  onLoad: document.documentElement.getAttribute('data-theme'),
  cssApplied: getComputedStyle(document.body).backgroundColor
})
```

- [ ] **Step 5: Verify the operating-system default with storage empty**

Clear `localStorage`, then use the browser tool's `colorScheme` parameter to
render at `light` and at `dark`, confirming the page follows without any
`data-theme` attribute present.

- [ ] **Step 6: Commit**

```bash
git add -A
git commit -m "Persist the reader's theme choice without a flash"
```

---

### Task 6: Light-skin sweep

**Files:** whichever the sweep implicates.

- [ ] **Step 1: Walk every page type in light**

At 1280 and 375, in light mode, screenshot and inspect:

- `/` homepage — every section, especially the overlay cards
- `/?s=%E0%AE%85` search results
- `/category/astronomy/` archive
- `/internet-addiction/` single post — article header, captions, sidebar,
  post navigation, comments
- a 404 URL

- [ ] **Step 2: Audit contrast**

```js
(() => {
  document.documentElement.setAttribute('data-theme', 'light');
  const pairs = [
    ['ink/paper', 'body', 'color', 'backgroundColor'],
    ['muted/surface', '.posts-grid .wp-block-post-excerpt', 'color', null],
  ];
  const body = getComputedStyle(document.body);
  const ex = document.querySelector('.posts-grid .wp-block-post-excerpt');
  const card = document.querySelector('.posts-grid .wp-block-post');
  return JSON.stringify({
    inkOnPaper: ratio(body.color, body.backgroundColor),
    mutedOnSurface: ex ? ratio(getComputedStyle(ex).color, getComputedStyle(card).backgroundColor) : 'n/a'
  });
})()
```

Expected: both **≥ 4.5**. `mutedOnSurface` is the one the spec corrected; if
it reads 4.45 the old `#6e7076` is still in place.

- [ ] **Step 3: Fix what the sweep finds, then re-measure**

Anything found here is a rule that hardcoded a colour instead of reading a
preset. Fix it by reading the preset, not by adding a light-mode override.

- [ ] **Step 4: Commit**

```bash
git add -A
git commit -m "Correct what the light skin exposed"
```

---

### Task 7: Document and open the PR

- [ ] **Step 1: Bump the version** in `style.css:6` to `0.43.0`.

- [ ] **Step 2: Changelog** — add a `0.43.0` section in house style covering
the mechanism, the `@supports` guard and why it is load-bearing, the three
fixed tokens and the bug they prevent, the `muted` correction, the dark
island, and the toggle's placement.

- [ ] **Step 3: README** — add a "Colour schemes" subsection under Styling
model. Record the `light-dark()` mechanism, the rule that `paper`/`ink` must
never carry text on an accent or a photograph, and the editor-canvas
limitation. Add the two toggle strings to "Awaiting editorial approval".

- [ ] **Step 4: Regression pass** — all five page types, both skins, 1280 and
375. Confirm the search overlay opens, the mobile navigation opens, and no
page scrolls horizontally.

- [ ] **Step 5: Commit and open the PR**

```bash
git add -A
git commit -m "Document the colour schemes at 0.43.0"
git push -u origin theme/light-dark
gh pr create --title "Light and dark themes" --body "…"
```

---

## Self-review

**Spec coverage.** Palette and mechanism → Task 1. `@supports` guard → Task 1.
`color-scheme: dark` removal → Task 1. Fixed tokens and the five `paper`-as-text
sites → Task 2. Scrims → Task 2. Dark island → Task 3. Search overlay
inheritance → Task 3 Step 3. Toggle markup, placement, no-JS hiding → Task 4.
Persistence, no flash, OS default → Task 5. Contrast verification → Tasks 2, 6.
Editor-canvas limitation → Task 7 Step 3. No gaps.

**Type consistency.** `--parimaanam-on-accent`, `--parimaanam-on-media`,
`--parimaanam-scrim-rgb`, `--parimaanam-icon-sun`, `--parimaanam-icon-moon`,
`data-theme`, `has-theme-toggle`, `parimaanam-theme` and the
`data-label-light` / `data-label-dark` attributes are each spelled the same in
every task that uses them. The `probe` and `ratio` helpers are defined once at
the top and referenced by name.

**One open risk, carried deliberately.** Task 4's Tamil labels are unapproved.
They are isolated to one file so the eventual copy is a one-line swap, and the
plan says so at the point of use rather than only here.
