# Changelog

All notable changes to the Parimaanam 2026 theme.

WordPress caches the list of theme-owned pattern files against the `Version`
header in `style.css`. Increment that version when adding, removing, or
renaming files in `patterns/` so active installations discover the change
without database manipulation or cache-clearing hooks.

## 0.27.2

- Made the footer menu a single centred column with hairline dividers on
  phones. Wrapping the links centred each row independently, so the rows began
  at different x positions and the block read as scattered words rather than a
  menu.
- A two-by-two grid would also have aligned them, but the menu is
  editor-managed and a fifth link would strand on a row of its own. One column
  stays tidy at any number of links.

## 0.27.1

- Centred the footer on phones: the logo, the menu, and the copyright now sit
  in a centred stack rather than flush left, and the logo grows from `9rem` to
  `11rem` since it is the focal point there. From tablet up the previous row
  layout is unchanged.
- Gave the footer links vertical padding. As bare text their tap targets were
  about twenty pixels tall; they are now forty-six, above the forty-four pixel
  guideline.
- Fixed the meta strip's justification, which Core prints as an inline style
  after the theme's stylesheet at equal specificity and so was winning on
  order. Left unfixed it would have split the copyright and the privacy link
  apart once that link appears.

## 0.26.1

- Gave the Technology feature row and the Biology card row explicit column
  counts: two at tablet, four at desktop. Both hold exactly four posts, and an
  intrinsic column count stranded the fourth on a row of its own wherever three
  tracks happened to fit — visible from roughly 850px to 1150px.
- No minimum column width can avoid this. Four tracks at the narrow end need
  241px or less, while stopping a fifth track at the 80rem maximum needs more
  than 243px, so the two requirements do not overlap.
- Verified 375 / 900 / 1059 / 1400: one column of four, two by two, one row of
  four, and still four rather than a phantom fifth track above the 80rem cap.

## 0.26.0

- Moved the tablet breakpoint from `48rem` to `40rem`. At 768px every tablet
  in portrait fell into the phone tier — an iPad mini is 744px and small
  Android tablets are around 600px — so 744px of screen rendered a single
  column with the hero excerpt hidden. Those devices now get the tablet
  layout.
- Verified at the boundary: 639px mobile, 640px tablet. At 640px the hero is
  two columns, the category directory three, the narrowest text column 181px,
  and nothing overflows. The navigation correctly keeps its overlay until
  1024px.

## 0.25.2

- Documented the theme's three breakpoints — `48rem`, `64rem`, `72rem` — as a
  canonical scale at the top of `style.css`, with each stylesheet naming the
  ones it uses and pointing there. Comments only; every media query is
  unchanged.
- Recorded why they cannot be variables (custom properties are invalid in
  media query conditions), why `63.99rem` keeps the compatible `max-width`
  form rather than range syntax, and why intrinsic sizing is preferred over
  adding a fourth.

## 0.25.1

- Replaced the red-tinted section backgrounds with two neutral graphite
  gradient presets that alternate, so every seam meets on the same value. The
  accent and the grounds previously shared a hue, which left crimson looking
  muddy rather than sharp.
- Removed the eighty-one pixel bands of bare page background between sections.
  They came from Core's default block gap on the main container, not from the
  sections themselves; `home.html` now sets `blockGap` to zero and each section
  carries its own padding instead.
- Deleted the `surface-crimson` and `surface-cool` tokens, which no section
  used any more, and raised `surface` to `#1e1e1e`. At its old value a filled
  card became indistinguishable from the gradient behind its lower edge.
- Category directory: the post count now sits on the label's baseline instead
  of riding above it, and its crimson rule is centred on the label's first line
  rather than offset by a fixed margin that only held at one font size.
- Category directory is now two columns on mobile with a smaller label, three
  at tablet, and five at desktop.

## 0.24.1

- Removed the Science Series column from the footer; the series are already one
  click away in the header dropdown.
- The secondary menu is now horizontal, sitting opposite the logo on one row.
  Its own alignment is left to the parent's `space-between`, so the links sit
  right at wide widths and fall flush with the logo once they wrap on narrow
  ones.
- Footer height is now 189px at desktop and 320px on a phone, against 1340px
  when it still carried a category list.

## 0.23.1

- Extended the footer copyright to the publication's supplied wording:
  `© <year> <site name>. அனைத்து உரிமைகளும் பாதுகாக்கப்பட்டவை.` The year and the
  site name remain dynamic, so the sentence is not hard-coded to one install.

## 0.23.0

- Reworked the footer after review: the category list is gone, the site logo
  appears at a smaller size, and a Core Navigation block supplies secondary
  links an editor can manage in the Site Editor.
- The category list restated the homepage directory and made the mobile footer
  1340px tall; without it the footer is 753px.
- `patterns/footer-discovery.php` is now `patterns/footer-columns.php`, since
  the band is no longer only discovery.
- Dropped the linked Site Title from the meta strip; the logo already links
  home.

## 0.22.1

- Replaced the site-title-only footer with a discovery footer: the six Science
  Series pages beside the Core Categories block, over a strip carrying the site
  title, a copyright line, and a privacy link that appears only once a privacy
  page is designated and published.
- Moved the approved page paths into `inc/navigation.php` so the header and the
  footer resolve the same destinations from one list. Header output verified
  unchanged by diffing its resolved URLs before and after.
- Added `assets/css/footer.css` for the region layout and the category column
  grid, which the Core Categories block's flat list cannot express itself.

## 0.18.0

- Converted the four remaining deprecated `displayLayout` attributes in the
  Technology and Biology sections to the Post Template's own grid `layout`.
  Only `posts-grid.php` was migrated in 0.16.0; these were missed.
- Removed the `48rem`–`63.99rem` media query that forced the Technology
  features into two columns with `!important`. It existed only to override the
  inline widths Core's flex layout sets on each post, which the grid layout
  does not set at all.

## 0.17.0

- `patterns/site-logo.php` now emits Core's Site Logo block when an editor has
  set a logo in WordPress, so the image becomes database-managed and editable
  in the Site Editor like the primary navigation. The bundled theme asset
  remains the portable first-activation fallback. Both branches keep the
  `parimaanam-site-logo` class, so the responsive cap still applies.

## 0.16.0

- Replaced the Core Query Title block on `search.html` with
  `patterns/search-title.php`. Core translates the search view's browser tab
  through a string the Tamil pack covers, but the Query Title block uses a
  separate string it does not, so a `ta-IN` site showed an English
  `Search results for:` heading above a Tamil tab. The pattern reuses Core's
  own Tamil phrasing for the same condition.

## 0.15.0

- Added `templates/404.html` and `patterns/error-404.php` so missing URLs get a
  designed response instead of the intentionally unstyled `index.html`
  fallback.
- Registered the theme text domain with `load_theme_textdomain()`. Pattern
  strings were marked for translation but nothing loaded the domain, so none of
  them could be translated.
- Made the no-results message Tamil, so every source string is Tamil.
- Replaced the deprecated `core/query` `displayLayout` attribute with the Post
  Template's own grid `layout`, superseded in WordPress 6.3.
- Gave the site logo its real `240x80` dimensions and removed the inline
  `320px` width, which never applied because `theme.json` caps the image.
- Preloaded the Tamil font subset through the `wp_preload_resources` filter.
- Gave the homepage hero's lead and support regions screen-reader headings;
  their post titles moved to `h3` so the outline nests.
- Moved the masthead and homepage CSS out of the `theme.json` `styles.css`
  string into `assets/css/header.css` and `assets/css/homepage.css`.
- Split this version history out of `README.md`.
- Added a `.gitignore` for editor and OS artifacts.

## 0.14.2

- Expanded the single-article wide-screen column into the available space
  beside the discovery sidebar.

## 0.14.0

- Added the native single-article discovery sidebar.

## 0.13.0

- Added the approved portable header navigation pattern.

## 0.12.0

- Established square-edged imagery.

## 0.11.0

- Flattened the homepage visual system and added the dynamic category
  directory.

## 0.10.0

- Unified the homepage's editorial visual system.

## 0.9.0

- Added the Biology editorial section.

## 0.8.0

- Added the Technology showcase.

## 0.7.0

- Added the first category-led section.

## 0.6.0

- Introduced the three-region hero and the approved logo pattern.

## 0.5.0

- Narrowed the homepage composition to the latest-posts hero.

## 0.4.0

- Introduced the first magazine homepage composition.

## 0.3.0

- Recorded the shared visual-system polish.

## 0.2.0

- Introduced the first theme-owned pattern.
