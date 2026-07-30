# Changelog

All notable changes to the Parimaanam 2026 theme.

WordPress caches the list of theme-owned pattern files against the `Version`
header in `style.css`. Increment that version when adding, removing, or
renaming files in `patterns/` so active installations discover the change
without database manipulation or cache-clearing hooks.

## 0.43.0

- The theme has a light skin and a dark skin. A first-time reader gets
  whichever their operating system prefers; an explicit choice, once made,
  overrides it permanently.
- The mechanism is `light-dark()` driven by `color-scheme`, redefining the
  nine `--wp--preset--color--*` variables in `assets/css/color-scheme.css`.
  Every rule in the theme already read those variables, so nine declarations
  reskin the site and `theme.json` keeps the dark values as the default.
- The selector is `html:root`, not `:root`. WordPress prints the same nine
  variables from `theme.json` in an inline `global-styles` block *after* this
  file, so at equal specificity `theme.json` won on source order and both
  skins rendered dark. `(0,1,1)` beats `(0,1,0)` wherever WordPress prints.
- Every `light-dark()` declaration sits inside
  `@supports (color: light-dark(#fff, #000))`. Custom properties validate at
  use rather than at declaration, so without the guard a browser lacking
  `light-dark()` would accept them and then fail when consumed, leaving the
  site unstyled instead of falling back. Guarded, it keeps the dark theme.
- The accent splits by role. `crimson` now carries
  `light-dark(#4e7a1e, #c5f27e)` — the readable value, 5.09:1 on paper — and
  a new `--parimaanam-accent-fill` carries the lime for the four places the
  accent is a fill. This is the way round it is because the theme draws the
  accent as a line, a numeral or a link about fifteen times and as a fill
  about four, so the common case is the default and every existing rule stayed
  correct untouched.
- Three tokens hold one value in both skins: `--parimaanam-on-accent` for text
  on an accent fill, `--parimaanam-on-media` for text over a photograph, and
  `--parimaanam-scrim-rgb` for the overlay-card scrims. Without them, `paper`
  as chip text would have measured 1.28:1 in the light skin.
- `muted` is `#67696f`, not the `#6e7076` originally sampled. That value gives
  4.45:1 against the card surface — under AA for the excerpt text it carries.
- The masthead and footer keep the dark palette in both skins, by re-pinning
  the palette variables on `.site-header` and `.site-footer`. The logo is a
  single `#e6e6e6` fill and Core's Site Logo block renders one image whatever
  the theme, so a light masthead would need an asset the publication does not
  have. The island also re-declares `color`: `theme.json` sets the body text
  colour, which resolves on `body` outside the island, and what reaches the
  masthead is an inherited computed value that re-pinning a variable cannot
  touch.
- The search overlay stays dark in both skins. Its `<dialog>` is a descendant
  of `.site-header`, so it inherits the island — correct for a modal takeover
  launched from a dark masthead, and recorded so it is not "fixed" later.
- The toggle is a button in the masthead beside the search trigger. It was
  meant to sit inside the navigation overlay on phones, but Core's Navigation
  block declares an `allowed_blocks` list that excludes `core/html`.
- Nothing is written to the document on load unless the reader has chosen.
  Pinning `data-theme` to whatever the system said would record a preference
  nobody expressed and stop the page following a system change made while it
  is open.
- A stored choice is restored by an inline `wp_head` script at priority 1,
  measured landing at head index 4 against the first stylesheet at index 14,
  so the wrong skin cannot flash. The button is hidden until that script runs,
  so a reader without JavaScript sees no control that cannot work — they still
  get their operating system's preference, which is pure CSS.
- Toggle labels are English. Core translates `Dark` as அடர்ந்த, meaning dense,
  and `Light` as ஒளி, meaning illumination, so reusing its Tamil would have
  put visibly wrong words in the masthead.
- Known limit: the block editor canvas always renders dark. It cannot follow a
  front-end toggle without a second editor stylesheet, deliberately not
  shipped.

## 0.42.0

- The accent moves from crimson `#d45656` to lime `#c5f27e`. Every colour in
  the theme resolves through `--wp--preset--color--*`, including Core's own
  `has-*-background-color` utilities, so four palette entries carried the
  change across all 62 references. `line` and `highlight` shift from warm
  red-greys to green-greys to match. The slugs stay `crimson` and
  `crimson-hover`: one post carries `has-crimson-color` and production
  template parts are database-customised, so renaming would silently drop the
  colour from content that cannot be inspected from here.
- A four-step radius scale — card `1rem`, media `0.625rem`, chip `0.375rem`,
  control `0.5rem` — declared once on `:root` and replacing every hardcoded
  radius. `settings.border.radius` stays `false`, so the editor offers no
  radius control and the scale cannot be widened by hand.
- Category and date labels become chips: a filled accent chip and an outlined
  chip, on listing cards, the article header and the homepage category pair.
  The category is a fill rather than coloured text because the accent reads
  15.5:1 on paper but 1.3:1 on white — as a fill with near-black text it works
  against either ground, which is what will let the light theme reuse one
  accent value.
- The 2px accent rule, the calendar glyph and `--parimaanam-icon-calendar` are
  all removed. They existed to make bare metadata read as designed; the chips
  do that for both facts at once, and keeping either would put a border and an
  icon around the same four words.
- `letter-spacing: 0.04em` is dropped from both category rules. It is a Latin
  habit and it is wrong in Tamil, where it detaches combining vowel signs from
  the consonant they attach to. The remaining instance in `header.css` is
  correct — it spaces Latin digits from a CSS counter.
- Listing type drops to 18px titles and 15px excerpts on desktop. The
  reference design runs body copy at 14px, but that was measured on Latin;
  Tamil glyphs carry more internal structure, so 15px is the floor at every
  width. The phone block's excerpt rule became an exact duplicate and is gone.
- Listing cards gain a filled box: `surface` fill, 16px corners, 24px padding.
  Scope is orientation, not page — a box traces an image stacked above its
  text. The category pair and sidebar recent posts put their image beside
  their text, so they stay rows separated by rules.
- The listing grid fits three columns, down from 26rem minimum tracks to
  20rem. Measured rather than guessed: a third column needs tracks of 395px or
  less and a fourth appears at 290px, and `wideSize` caps the container so a
  fourth can never fit. Tablets at 768px recover a second column they had been
  wasting. The gap tightens to 24px, matching the card's own padding.
- Archives and search show nine posts per page, set by a `pre_get_posts`
  filter in the theme. Ten left one card alone on the last row of every page.
  This lives with the layout rather than in Settings → Reading because the
  count is a property of the grid: change the columns and nine is wrong.
- The two full-bleed overlay cards take their radius on the card rather than
  the image. Core applies the featured-image radius to the inner `img`, which
  curved the photograph while leaving the scrim above it square — and that
  scrim reaches 0.97 opacity, so its corners stood proud. Both cards already
  carry `overflow: hidden`, so rounding the card clips image and scrim
  together.
- The search overlay's field keeps radius `0`. It is an underline rather than
  a box, so a radius would bow its 2px rule upward at both ends.

## 0.40.1

- Archive and search page titles are now centred between two crimson rules,
  matching the accent language used elsewhere. The rules shorten from six rem
  to two on phones, where they were otherwise pushing a two-word Tamil category
  onto a second line.
- Archive and search cards gained the article header's meta treatment: a short
  crimson rule before the category, a calendar glyph before the date. The glyph
  is now declared once as a custom property and shared by both.
- Reduced listing type on phones — card titles 18.3px to 16px, excerpts 16.1px
  to 15px, page titles 24.7px to 22px. Desktop is unchanged at 24, 18 and 36.
- Core's `has-*-font-size` classes carry `!important`, so the sizes are set by
  redefining the preset variable in scope rather than answering with more
  `!important`.

## 0.38.1

- Homepage sections now alternate two flat grounds, `paper` and a new `band`
  (`#141414`), so each is distinct from its neighbour. The seamless gradient
  scheme is gone: it worked exactly as designed, but the sections dissolved
  into one another and stopped reading as separate modules.
- The footer takes `band` too, or it merged into the directory above it. Every
  adjacent pair on the page is now verified distinct.
- Technology's feature cards moved from `paper` to `surface`, since that
  section's ground became `paper` and the cards would have vanished into it.
- Three gradient presets are removed as unused. `graphite-ascend` remains, used
  only by the masthead.

## 0.37.0

- Replaced the Science section with a fifty-fifty pair: Science and Environment
  side by side, four posts each, every card a square thumbnail beside its date
  and title. The columns stack on phones.
- The section takes a deeper background than its neighbours, `#090909` to
  `#1c1c1c`. Two gradient presets were added rather than one, because
  Technology needs the matching ascent to keep every seam meeting on the same
  value — verified still zero across all four boundaries.
- `patterns/category-science.php` and its CSS are removed, since the pair
  supersedes them. Both categories are resolved by slug, and one that does not
  exist is dropped rather than breaking the section.

## 0.36.4

- Image captions now sit below the image on every template and in all three
  shapes the archive contains: modern `figcaption`, the legacy `[caption]`
  shortcode's `.wp-caption-text` used by 201 posts, and a handful still
  carrying `blocks-gallery-item__caption`. All read the same — quiet, below the
  image, with a crimson rule marking them as commentary.
- That last class is styled by Core's gallery CSS to overlay the image, which
  on a standalone figure simply covered the photograph. Undoing it needed three
  separate fixes, each measured against the live page: the overlay resolves at
  three classes, the figure is a flex row that stretched image and caption to a
  shared height, and the image carries `height: 100%` with `!important`.
- That last one is the only `!important` the theme answers in kind, scoped
  through `:has()` to the affected figures so real galleries and every other
  image are untouched.
- These rules moved out of `theme.json`, whose `css` property silently dropped
  one half of a comma-separated `&` selector and wrapped what it did emit in
  `:where()`, too weak to reach the overlay.

## 0.35.0

- Designed the article header. The category now carries the same short crimson
  rule the section headings use, set bold with a little letter spacing, and the
  date is preceded by a calendar glyph. A hairline closes the header off from
  the article body.
- The glyph is a CSS mask rather than markup: it is decorative, since the date
  text already carries the meaning, and a mask inherits the surrounding colour
  instead of hard-coding a fill. No icon library is introduced for one glyph.

## 0.34.0

- Lowered the fluid type minimums so phone typography is smaller across every
  element that uses a preset, which is all of them. Measured at 375px: body
  17.1px to 16.1px, article H1 28.5px to 24.7px, post navigation title 20.2px
  to 18.3px.
- Maximums are unchanged, so desktop renders exactly as before — verified at
  1280px: body 18px, H1 36px, navigation title 24px.
- The body floor stops at `1rem`. Sixteen pixels is the conventional limit for
  sustained reading and this is long-form Tamil prose, so the headings took
  most of the reduction instead.

## 0.33.0

- Moved the adjacent-post navigation and the comments inside the single-post
  grid. Both previously sat outside it and spanned the full wide measure while
  the sidebar stopped at the end of the article; they now match the content
  column and the sidebar runs alongside all of it.
- Rows are placed explicitly, because the navigation renders nothing on a first
  or last post and auto-placement would have reflowed the sidebar. Below the
  wide breakpoint the sidebar is ordered up behind the article rather than left
  trailing a long comment thread.

## 0.32.0

- Rebuilt the adjacent-post navigation as two panels sharing a hairline, each
  with a quiet label above the destination title and a whole-panel click
  target. It was previously two underlined links.
- Core's Post Navigation Link prints `Previous:` and `Next:`, and those exact
  strings are untranslated in the Tamil pack, so a `ta_IN` site showed English
  labels beside Tamil titles. `Previous Post` and `Next Post` are translated,
  so the labels now come from Core's own Tamil and the block's prefix is off.
- The pattern resolves whether an adjacent post exists, so a label is never
  rendered above a link Core is going to omit. Verified on the newest and
  oldest posts, which correctly show one panel each.
- Arrows are supplied in CSS, keeping them out of the link's accessible name.

## 0.31.0

- Removed the search widget from the article sidebar; the masthead overlay now
  covers that need on every template.
- Reduced the sidebar category list to the small type size.
- Hid Core's Archives dropdown label, which sat directly beneath the widget's
  own heading and named the same thing twice. It remains in the accessibility
  tree as the select's label.
- Recent posts now show a 64px thumbnail beside the title and date.

## 0.30.1

- Scaled the header search icon from 24px to 32px at desktop, where a 240px
  logo sits beside it. The tap target stays 44px at every size; only the glyph
  grows, and mobile is unchanged.

## 0.30.0

- Gave the masthead its own background: the `graphite-ascend` gradient rather
  than flat `paper`, so it reads as a distinct band instead of sharing the
  page's colour exactly. Reuses an existing preset, adding no token.
- Reworked the header below `64rem`. The logo drops from 180px to 144px, the
  two controls group together at the right instead of all three children being
  spread evenly, and the header is 95px tall rather than 107px.
- The navigation's open control was a bare 24px icon — half the size of the
  search trigger beside it and well under a usable tap target. It is now 44px,
  matching search.

## 0.29.1

- Replaced the header's Core Search block with a full-focus overlay. The block
  only expands its field in place, which pushed the navigation sideways as the
  field grew; the navigation now does not move at all.
- This adds the theme's first JavaScript: `assets/js/search-overlay.js`, around
  forty lines, no dependencies, deferred, front end only. Native `<dialog>`
  supplies the focus trap, Escape handling, backdrop, and focus return, so none
  of that is reimplemented.
- The trigger is a real link to the search results page, so the control still
  works without the script or without `<dialog>` support.
- No new Tamil copy: the trigger, label, placeholder and submit reuse the
  existing `தேடல்` string, and the close control uses Core's own translation,
  which renders as `மூடுக`.

## 0.28.1

- Made the four category section headings consistent. Science was missing the
  crimson rule the others carry, though its flex row and gap were already set
  up for one; Technology rendered at 24px against the others' 36px, and a
  `width: fit-content` rule combined with Core's alignwide auto margins to
  centre it while every other heading sat flush left.
- Gave each rule an explicit flex basis. As a bare width it could be shrunk
  away by a long Tamil heading.

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
