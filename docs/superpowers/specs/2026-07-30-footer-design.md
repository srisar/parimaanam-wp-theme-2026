# Footer design

Date: 2026-07-30
Status: implemented, then revised after review — see "Revision" at the end

> **Revised.** Sections below describe the design as first approved. After
> seeing it rendered, the category list was dropped, the logo was added, and
> the second region became an editor-managed menu. The Revision section at the
> end records what changed and why; the body is kept for the reasoning behind
> the decisions that still stand.

## Problem

`parts/footer.html` contains only a linked Site Title. That was a deliberate
choice while footer content had no approved source, but it leaves every article
ending in a dead end. Discoverability of older articles is one of the
publication's stated priorities, and the footer is the natural place to serve it
for a reader who has just finished reading.

## Approved inputs

Confirmed against the running installation before designing:

- Site tagline is **empty**, so there is no approved slogan to display.
- No widget areas hold content, so the previous theme's footer supplies nothing
  to inherit.
- A curated classic menu (`பிரிவுகள்`) exists but contains `#` placeholder
  entries, points at `/blog/`, and lives only in this database. It is therefore
  not a portable source.
- The Privacy Policy page is designated (`wp_page_for_privacy_policy` = 3) but
  is currently a **draft**, so `get_privacy_policy_url()` returns an empty
  string.

## Decisions

1. **Discovery first.** The footer's job is onward routes into the archive, with
   identity and legal details reduced to a thin strip beneath.
2. **Categories come from the Core Categories block.** Dynamic, no stored IDs,
   correct on a fresh install, and consistent with how the rest of the theme
   sources data.
3. **Science Series is the second region.** It is the only major content group
   not already surfaced outside a header dropdown. Links point at the six child
   pages, not the grouping parent, which exists to group the dropdown rather
   than to be read.
4. **Search and recent posts are excluded.** Both already appear in the article
   sidebar; repeating them would put the same links in three places.
5. **The six series paths move to `inc/navigation.php`** so the header and the
   footer resolve from one list rather than two copies that can drift.

## Structure

`parts/footer.html` keeps the outer full-width group — `paper` background, a
`line` top border — wrapping the shared `80rem` container, and composes two
patterns:

```
footer
├── discovery band
│   ├── அறிவியல் தொடர்கள்   → six series links
│   └── பிரிவுகள்            → Core Categories block, multi-column
└── meta strip
    └── site title · © <year> <site name> · Privacy Policy
```

## Components

| File | Responsibility |
| --- | --- |
| `inc/navigation.php` | Owns the approved page-path map and resolves paths to URLs via `get_page_by_path()`, falling back to an installation-relative URL. Loaded from `functions.php`. |
| `patterns/header-navigation.php` | Consumes the shared resolver instead of holding its own path list. Labels stay here. |
| `patterns/footer-discovery.php` | The two discovery regions and their headings. |
| `patterns/footer-meta.php` | Site title, copyright line, conditional privacy link. |
| `assets/css/footer.css` | Footer layout, enqueued beside `header.css` and `homepage.css`. |
| `parts/footer.html` | Outer structure and pattern composition. |

### Why labels stay in the patterns

Translation calls must receive string literals; `esc_html_x( $variable )` cannot
be extracted by tooling. `inc/navigation.php` therefore owns paths and URL
resolution only. Labels remain in the pattern that outputs them. This is a
technical boundary, not an oversight.

## Copy

No new editorial copy is introduced. Both region headings reuse strings the
theme already ships:

- `அறிவியல் தொடர்கள்` — from `header-navigation.php`
- `பிரிவுகள்` — from `article-sidebar.php` and `home-categories.php`

The single new string is the copyright format `© %1$s %2$s`, which is
boilerplate rather than editorial content, and was explicitly approved.

## Data flow

Everything resolves at render time, with nothing stored or hard-coded:

- Categories and their counts — Core Categories block
- Series URLs — `get_page_by_path()` through the shared resolver
- Copyright year — `wp_date( 'Y' )`, so it cannot go stale
- Site name — `get_bloginfo( 'name' )`
- Privacy URL — `get_privacy_policy_url()`, rendered only when non-empty

## Styling

Series and categories sit side by side at wide widths, because the Core
Categories block renders a flat `<ul>` that CSS must arrange. Concretely:

- Wide: two regions side by side, series taking roughly a third; the category
  list runs in three columns within its region.
- Tablet: regions still side by side, category list drops to two columns.
- Narrow: regions stack, category list becomes a single column.

Column counts are expressed with a minimum column width rather than fixed
counts, matching the approach now used across the homepage sections, so long
Tamil category names keep a usable measure. Region headings are `h2` so the
document outline remains correct on every template.

## Out of scope

- Listing a parent page's children by query. The README parks this as belonging
  in content or a companion plugin, and that decision stands.
- Social links, a newsletter signup, or an about blurb. No approved source
  exists for any of them.
- Changing the header navigation's structure. Only its path list moves.

## Acceptance criteria

1. Footer renders on every template: home, single, page, archive, search, 404.
2. Six series links resolve to the correct child pages.
3. Categories list reflects current non-empty categories with counts.
4. Copyright shows the current year and the site name from settings.
5. Privacy link is **absent** while the page is a draft. The present case is
   verified by simulating a published privacy page in memory during a render
   check, not by publishing the page — that is a content decision for an
   editor, not something implementation should change.
6. No horizontal overflow at 375px, 768px, and desktop widths.
7. Heading levels produce a valid outline; no `h1` in the footer.
8. `header-navigation.php` still renders identical URLs after its path list
   moves to `inc/`.

## Risks

- The local Header template part is customized in the database, so footer
  changes made in theme files will not appear on installs where the Footer part
  has also been customized. The local Footer **is** customized, so this must be
  reverted locally to verify, or verified on a clean install.
- Moving paths out of `header-navigation.php` touches working navigation.
  Acceptance criterion 8 exists to catch a regression.

## Revision — after seeing it rendered

Three changes were made once the footer was on screen:

1. **The category list was removed.** It restated the homepage category
   directory, and on a 375px viewport it pushed the footer to 1340px — about
   1.6 screens. Without it the footer is 753px. Decision 2 above therefore no
   longer applies; categories remain served by the sidebar and the homepage.
2. **The site logo was added**, reusing `patterns/site-logo.php` so it stays
   the Core Site Logo block wherever one is set. Only its maximum width is
   overridden, to `min(9rem, 40vw)` against the masthead's `min(15rem, 48vw)`.
   The linked Site Title was dropped from the meta strip, since the logo
   already links home.
3. **A secondary link group was added** as a Core Navigation block with its
   overlay disabled, so an editor manages it in the Site Editor rather than
   through a theme commit. Its four default labels already existed in the
   header pattern, so no new copy was introduced.

`patterns/footer-discovery.php` became `patterns/footer-columns.php`, since the
band is no longer only discovery.

The layout is now three regions rather than two: identity, series, and
secondary links, at `1fr / 1.4fr / 1fr` above `48rem` and stacked below it.

### Correction to the approved-inputs section

The Risks section stated the local Footer template part held only a site title.
That was an unverified assumption and it was wrong. It actually contained
About, Privacy, Social, and "Designed with WordPress" links, and it was hard
deleted during implementation before the content was examined. The text was
captured, but the markup was not recoverable. Its About and Social links are
evidence worth weighing in any future footer decision — the secondary menu now
covers the About case.
