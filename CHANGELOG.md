# Changelog

All notable changes to the Parimaanam 2026 theme.

WordPress caches the list of theme-owned pattern files against the `Version`
header in `style.css`. Increment that version when adding, removing, or
renaming files in `patterns/` so active installations discover the change
without database manipulation or cache-clearing hooks.

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
