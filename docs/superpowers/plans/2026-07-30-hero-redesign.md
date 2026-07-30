# Hero redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the homepage hero with a three-slot featured composition
whose stories are chosen by sticky posts and whose empty slots fill from
recent posts.

**Architecture:** `patterns/home-hero.php` resolves the sticky posts in PHP
and emits four Core Query blocks — three featured slots and a recent row —
with offsets computed from live state. No JavaScript. Layout is CSS grid in
`assets/css/homepage.css`.

**Tech Stack:** WordPress 7.0.2 block theme, PHP, plain CSS.

## Global Constraints

- Spec: `docs/superpowers/specs/2026-07-30-hero-redesign-design.md`.
- Branch `theme/hero-redesign`; PR via `gh pr create`. No Claude Code footer.
- Commands are for Git Bash on Windows 11.
- Never restrict a Query block by post ID — Core does not support it. Use the
  computed offsets.
- Never verify this with `get_posts()`; it ignores `offset` when `include` is
  set. Use `WP_Query`.
- Reuse `.parimaanam-chip` for all metadata. No `letter-spacing` on Tamil.
- Text over a photograph uses `--parimaanam-on-media`, never `ink`.
- Bump `Version:` to `0.44.0` in the final task; patterns are cached against it.

## Verification method

Measured against `http://localhost:8080/`. Sticky state is changed with:

```bash
docker exec parimaanam-wp php -r 'require "/var/www/html/wp-load.php"; update_option("sticky_posts", array(/* ids */));'
```

Reset to none when finished.

---

### Task 1: Resolve the slots and rebuild the pattern

**Files:** Rewrite `patterns/home-hero.php`.

- [ ] **Step 1: Resolve sticky state at the top of the pattern**

```php
/*
 * Sticky posts choose what fronts the publication; anything the editor has
 * not chosen is filled from the most recent posts, so the hero never renders
 * a hole. Only the first three matter — the composition has three slots.
 */
$parimaanam_sticky   = array_slice( array_map( 'intval', (array) get_option( 'sticky_posts' ) ), 0, 3 );
$parimaanam_featured = count( $parimaanam_sticky );
$parimaanam_fillers  = max( 0, 3 - $parimaanam_featured );
```

- [ ] **Step 2: Add a helper that builds each slot's query attributes**

```php
/*
 * Core cannot restrict a Query block to given post IDs — the `include` key it
 * accepts belongs to taxQuery, and post__in is set only by sticky "only". So
 * each slot is addressed by position: the first $parimaanam_featured slots
 * take sticky posts in order, and the rest count forward through the
 * non-sticky posts.
 */
function parimaanam_2026_hero_slot_query( $index, $featured ) {
	$query = array(
		'perPage'  => 1,
		'pages'    => 0,
		'postType' => 'post',
		'order'    => 'desc',
		'orderBy'  => 'date',
		'inherit'  => false,
	);

	if ( $index < $featured ) {
		$query['sticky'] = 'only';
		$query['offset'] = $index;
	} else {
		$query['sticky'] = 'exclude';
		$query['offset'] = $index - $featured;
	}

	return wp_json_encode( $query );
}
```

- [ ] **Step 3: Emit slot A, the lead**

Two-thirds width, image with chips and title overlaid, plus an excerpt.
Classes: `home-hero__lead` on the query, `home-hero__lead-card` on the
article, `home-hero__lead-content` on the overlaid group — the last name is
kept because `assets/css/homepage.css` already scopes the over-media colour
rules to it.

- [ ] **Step 4: Emit slots B and C**

Wrapped in `<div class="home-hero__side">`. Each is its own query block with
`home-hero__side-card` on the article: featured image at `16/9`, then the chip
pair, then the title at `medium`. No excerpt.

- [ ] **Step 5: Emit the recent row**

```php
$parimaanam_recent = wp_json_encode( array(
	'perPage'  => 3,
	'pages'    => 0,
	'offset'   => $parimaanam_fillers,
	'postType' => 'post',
	'order'    => 'desc',
	'orderBy'  => 'date',
	'sticky'   => 'ignore',
	'exclude'  => $parimaanam_sticky,
	'inherit'  => false,
) );
```

`ignore` rather than `exclude` so a fourth or fifth sticky post is not barred
from the homepage; `exclude` removes the three that are already featured.

Keep the existing heading string `புதிய கட்டுரைகள்` above it. It becomes
accurate here — this row genuinely is the newest posts, where the old index it
labelled began at article two.

- [ ] **Step 6: Verify every sticky state**

For each of 0, 1, 2, 3 and 5 sticky posts, set the option and confirm the
rendered homepage shows the featured posts in their slots and repeats nothing:

```js
(() => {
  const ids = [...document.querySelectorAll('.home-hero article')]
    .map(a => (a.className.match(/post-(\d+)/) || [])[1]).filter(Boolean);
  return JSON.stringify({ ids, duplicates: ids.filter((v,i) => ids.indexOf(v) !== i) });
})()
```

Expected: six ids, `duplicates` empty, in every state.

- [ ] **Step 7: Commit**

---

### Task 2: The layout

**Files:** `assets/css/homepage.css` — replace the `.home-hero__layout`,
`.home-hero__latest`, `.home-hero__support` and `.home-hero__eyebrow` rules.

- [ ] **Step 1: Remove the old hero rules**

Delete every `.home-hero__latest`, `.home-hero__support`,
`.home-hero__layout` and `.home-hero__eyebrow` rule, including the counter
numbering and the two media-query blocks that reposition them. Keep
`.home-hero__lead-content` and the over-media colour rules.

- [ ] **Step 2: Add the grid**

```css
.home-hero__featured {
	display: grid;
	gap: var(--wp--preset--spacing--50);
	grid-template-columns: minmax(0, 1fr);
}

.home-hero__side {
	display: grid;
	gap: var(--wp--preset--spacing--50);
	grid-template-columns: minmax(0, 1fr);
}

@media (min-width: 40rem) {
	.home-hero__side {
		grid-template-columns: repeat(2, minmax(0, 1fr));
	}
}

@media (min-width: 64rem) {
	.home-hero__featured {
		grid-template-columns: 2fr 1fr;
	}

	.home-hero__side {
		grid-template-columns: minmax(0, 1fr);
	}
}
```

Breakpoints are the canonical 40rem and 64rem from `style.css`.

- [ ] **Step 3: Style the lead and side cards**

The lead card keeps the existing overlay treatment — `position: relative`,
`overflow: hidden`, card radius, absolutely positioned image, the scrim as
`::after`, content absolutely positioned at the bottom. The side cards take
the media radius on their image and sit on page ground.

- [ ] **Step 4: Verify at three widths**

At 1280 confirm two columns with the side cards stacked; at 768 confirm the
lead full width with the side cards paired; at 375 confirm all stacked. No
horizontal overflow at any width, in both colour schemes.

- [ ] **Step 5: Commit**

---

### Task 3: Document and open the PR

- [ ] **Step 1:** Bump `Version:` to `0.44.0`.
- [ ] **Step 2:** CHANGELOG entry covering the composition, sticky control,
  the removal of the hardcoded offsets, and the two Core constraints found.
- [ ] **Step 3:** README — replace the hero paragraph under the homepage
  section, and document the sticky-post workflow so an editor knows the
  feature exists.
- [ ] **Step 4:** Full regression at 1280 and 375 in both skins, sticky option
  reset to empty.
- [ ] **Step 5:** Commit, push, `gh pr create`.

---

## Self-review

**Spec coverage.** Composition → Task 2. Slot filling and the query table →
Task 1. Sticky control → Task 1. Removal of the index and the offsets → Tasks
1 and 2. Verification across sticky counts → Task 1 Step 6. Docs → Task 3.

**Type consistency.** `home-hero__featured`, `home-hero__side`,
`home-hero__side-card`, `home-hero__lead`, `home-hero__lead-card`,
`home-hero__lead-content`, `home-hero__recent` are spelled identically in both
tasks. `parimaanam_2026_hero_slot_query()` is defined in Task 1 Step 2 and
used in Steps 3 and 4.

**One risk.** The pattern declares a function, and patterns are included on
every render. It must be guarded with `function_exists()` or moved to
`inc/`; a bare declaration fatals if the pattern is rendered twice on one
request.
