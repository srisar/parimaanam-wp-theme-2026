# Parimaanam 2026

Parimaanam 2026 is the custom native WordPress block theme for <https://parimaanam.net>. This repository contains the theme only. It does not include WordPress core, plugins, uploads, database content, or environment configuration.

The current state establishes the theme architecture, a restrained publication design system, Tamil-first typography, the native single-article reading experience, Core-based discovery, and compatibility for the existing Science Series page hierarchy. The visual direction is intentionally new rather than a reproduction of the production site's current design.

## Requirements

- WordPress 6.6 or newer (the first release supporting `theme.json` version 3)
- PHP 7.4 or newer
- A local copy or representative export of existing Parimaanam content for compatibility testing

No Node.js build, Composer install, CSS framework, JavaScript framework, or page builder is required.

## Architecture

```text
parimaanam_2026/
├── AGENTS.md            Project rules for contributors and coding agents
├── README.md            Architecture and local workflow
├── style.css            WordPress theme registration metadata only
├── theme.json           Design tokens, global styles, and block compatibility
├── assets/
│   └── fonts/
│       └── google-sans/
│           ├── GoogleSans-Latin-Variable.woff2
│           ├── GoogleSans-Tamil-Variable.woff2
│           └── OFL.txt
├── parts/
│   ├── footer.html      Minimal shared publication footer
│   └── header.html      Shared site identity and Core search control
├── patterns/
│   ├── home-magazine.php Homepage editorial hierarchy and pagination
│   └── posts-grid.php    Shared archive/search cards and empty state
└── templates/
    ├── archive.html     Generic taxonomy, author, date, and post-type archives
    ├── home.html        Magazine-style posts index with a native Query Loop
    ├── index.html       Required, unstyled template-hierarchy fallback
    ├── page.html        Semantic pages, including the Science Series hierarchy
    ├── search.html      Search form and inherited search results
    └── single.html      Semantic reading experience for individual posts
```

Directories are added only when they have real content. Expected extension points are `patterns/`, `assets/css/`, `assets/js/`, `assets/images/`, `assets/fonts/`, and `inc/`.

### Rendering model

WordPress resolves requests through its standard template hierarchy. Individual posts use `templates/single.html`, pages use `templates/page.html`, the posts index uses `templates/home.html`, archive requests use `templates/archive.html`, search requests use `templates/search.html`, and views without a more specific template continue to fall back to `templates/index.html`. Inherited Query Loops let WordPress supply the current query, posts, URLs, and pagination without custom logic.

`index.html` is required for a valid block theme; it is not a homepage implementation. The fallback uses native block markup, a `main` landmark, and an `article` for each result, but makes no layout or visual choices.

`home.html` follows the WordPress posts-index hierarchy and works whether the posts index is the site's front page or is assigned to a separate page. There is no `front-page.html`: the current site setting displays the latest posts, and adding a front-page override would duplicate the posts-index responsibility without an approved static front-page requirement.

The homepage uses the non-inserter `patterns/home-magazine.php` composition around one Core Query Loop inherited from the main WordPress query. The Reading setting therefore continues to determine the number of posts and existing pagination URLs remain native. On wide screens the newest article occupies a dominant eight-column area, the next article occupies the remaining four columns, and subsequent articles form a denser three-column grid. The layout becomes two columns at intermediate widths and a single reading stream on narrow screens. Only the lead article displays its excerpt, producing a clear editorial hierarchy without additional queries, duplicated posts, hand-picked content IDs, or invented section labels.

Each semantic `article` exposes the linked featured image when one exists, categories, date, H2 title, and—on the lead item—a shortened excerpt. Missing featured images collapse naturally rather than reserving an empty hero area. Core pagination provides access to older articles. The template adds no fixed heading, category selection, promotional copy, menu, or content IDs.

The homepage renders the dynamic Site Title directly as its H1. The shared article header intentionally renders the same block without a heading level because the post title is the H1 on single views. Keeping this small contextual difference in the template preserves one meaningful H1 on both views without PHP, a custom block, or duplicate template parts.

`archive.html` is the generic Core-convention fallback for category, tag, author, date, custom-taxonomy, and post-type archives. It deliberately avoids category-specific files because the imported taxonomy data does not establish a requirement for different structures. The dynamic Query Title is the page H1 with Core's generic archive prefix hidden, leaving the actual term, author, date, or post-type label intact. The Term Description block displays editor-managed taxonomy context when present and remains empty for non-taxonomy archives.

Archive results use the shared two-column post-card composition and inherited Query Loop.

`search.html` adds a Core Query Title and Search block above the same result composition. The Search block's label and icon-button accessible name come from WordPress Core at render time, so they follow the installed WordPress translation rather than embedding an English theme string. The field retains the current query, allowing readers to refine Tamil, Latin, or mixed-script searches without custom JavaScript.

Search and archives share the same result layout, so `patterns/posts-grid.php` owns their inherited Query Loop, semantic cards, pagination, and no-results state. The homepage has a separate composition because a posts index benefits from stronger editorial hierarchy, while search and archive results should remain predictable and uniform. Both native, non-inserter patterns remain represented as Core blocks in the Site Editor. Their only executable PHP is an escaped, context-aware translation call for the empty-state message under the `parimaanam-2026` text domain; there is no query logic or content rendering in PHP.

### Science Series content model

The imported Science Series is existing editorial content, not a custom post type or taxonomy. The published page with slug `science-series` is the parent of six normal child pages. Each child page acts as a curated series index: its stored content contains the introduction, media, ordered parts, descriptions, and links to the corresponding posts. The legacy category named for series is empty and is not treated as authoritative.

`page.html` preserves this established WordPress page hierarchy and its nested permalinks. It renders the dynamic page title as the H1, the complete stored content through the Core Post Content block, and Core comments where the individual page allows them. It omits author/date metadata because these are reference pages rather than chronological posts. It also omits a template-level featured image because most imported series pages already begin with the same lead image in their stored content.

The parent Science Series page currently stores only its approved introductory paragraph; its six child links are represented by the WordPress parent/child relationship but are not present in that content. Core's Page List block can list a selected page's children, but that selection is stored as a numeric page ID and a static theme template cannot bind it to the current page dynamically. The theme therefore does not hard-code imported ID `620`, invent links, or add a PHP query. An editor can add a Page List block filtered to the Science Series parent in the page content, or a future companion plugin can provide a portable dynamic-child-pages block if the same behavior is required more broadly.

Several series pages retain links to both `parimaanam.net` and the site's earlier `parimaanam.wordpress.com` address. The theme intentionally does not rewrite stored editorial URLs. Those links should be verified or migrated at the content layer so redirects and canonical history can be handled explicitly.

`single.html` is the first purpose-built front-end template. It follows WordPress's standard single-post hierarchy and is composed entirely of Core blocks. A linked Site Title provides a minimal route back to the site without assuming an approved logo, menu, or navigation structure. The article uses semantic `main`, `article`, and nested `header` elements; its category, title, author, publication date, content, tags, adjacent-post navigation, threaded comments, comment pagination, and comment form all come from the current WordPress query.

Single-post titles use the existing `x-large` token instead of the global display-scale H1 token. Representative imported Tamil titles can exceed 60 characters; the smaller fluid range preserves their H1 hierarchy without allowing a headline to consume most of a narrow viewport.

The imported archive commonly uses the featured image again inside the post content. The template therefore does not render the Post Featured Image block: doing so would duplicate the lead image on existing articles. It also omits the Post Excerpt because imported posts commonly begin their content with the same paragraph used as the excerpt. Both decisions preserve existing content without custom PHP detection. A future editorial migration may revisit them after content conventions are normalized.

The reusable `parts/header.html` contains the dynamic linked Site Title and a button-only Core Search block. The Search block supplies its own accessible label and expands through WordPress Core's Interactivity API; the theme ships no JavaScript. Its header area is registered in `theme.json` so WordPress exposes it correctly in the Site Editor. The homepage keeps an equivalent inline header because its Site Title must be the page H1, while post and page titles remain the H1 in shared-template views.

The header deliberately does not ship a Navigation block. A Navigation block without an explicit reference resolves to database content selected by WordPress, which in the imported local site is a generic Page List containing obsolete utility and plugin pages. Hard-coding the imported main-menu post ID would make the theme non-portable. An editor should add or select the approved navigation in the Site Editor when the information architecture is reviewed.

`parts/footer.html` contains only the dynamic linked Site Title. This provides a consistent semantic footer without inventing a copyright statement, slogan, menu, or editorial copy.

### Styling model

`theme.json` uses version 3 and pins its schema reference to the minimum supported WordPress release. The initial design-system layer defines a `44rem` reading measure, an `80rem` wide alignment, and a seven-step multiplicative spacing scale based on WordPress Core's default scale. The Core spacing presets are disabled so these theme-owned values remain authoritative even when their slugs overlap. Editors may use the generated spacing presets for block gaps, margins, and padding, but arbitrary spacing values are disabled to keep layouts consistent. `rem` and `%` are the only exposed spacing units because they cover scalable fixed spacing and container-relative spacing without encouraging viewport- or pixel-specific values.

The reading measure prioritizes long-form Tamil content while retaining room for mixed Tamil and Latin text. The wide measure provides a controlled area for media, galleries, and future article-adjacent content. Both values are global defaults rather than template-specific widths and were verified against representative imported articles while building the single template.

The theme defines a small semantic palette: warm `paper` (`#f7f6f1`), white `surface`, deep blue-black `ink`, `muted` text, `observatory` teal and its darker interaction state, a quiet `line`, and a pale `highlight`. This is a new text-led publication identity, not a recreation of the current production site's image-logo, type, or color treatment. The palette is intentionally restrained so long-form Tamil text remains primary; teal is an editorial accent rather than a literal space-themed decoration. WordPress's default palette, gradients, and arbitrary custom colors are disabled so editor choices remain coherent.

Global text uses ink on paper. Links remain visibly underlined, while linked headings and site identity use their surrounding typography and gain teal on hover. Buttons use white on observatory teal. The lowest normal-text contrast among the intended foreground/background pairs is 5.32:1. A three-pixel teal `:focus-visible` outline supports keyboard navigation, and selection colors maintain readable contrast. Featured images receive only a small corner radius; the system avoids decorative effects that would compete with editorial media.

Template gutters continue to use the theme's spacing presets rather than root-aware global padding. This keeps full-width template-part borders and backgrounds predictable while constrained inner groups provide the readable page edge. Block-level custom CSS remains limited to interaction states, form controls, demonstrated legacy-content compatibility issues, and the homepage's asymmetric responsive grid. The homepage grid is scoped under `.home-magazine`; Core supports uniform columns but cannot express a first query item spanning a different number of grid tracks. It uses no content-dependent selectors beyond post position and falls back to one normal column without media-query support.

### Typography

The theme locally hosts Google Sans under the SIL Open Font License 1.1. Two optimized WOFF2 subsets cover Tamil and Latin while sharing one variable family and a weight range of 400 through 700. WordPress emits both `@font-face` declarations directly from `theme.json`; their `unicodeRange` descriptors let the browser fetch only the subset required by the text on a page. This avoids a Google Fonts runtime dependency and is substantially smaller than shipping the full multi-script TTF package. System UI and generic sans-serif fonts remain fallbacks for characters outside the bundled ranges.

The files are the unmodified variable subsets served by the official Google Fonts CSS API for Google Sans. The Tamil range is `U+0964-0965, U+0B82-0BFA, U+200C-200D, U+20B9, U+25CC`; the Latin range is the API's standard Latin subset. Their SIL Open Font License is stored beside them. One family keeps mixed-script scientific writing visually coherent, while the semantic `primary` preset decouples templates and styles from the font's product name.

The global reading size scales from `1.0625rem` to `1.125rem` with a `1.8` line height. Headings use the same family at weight 700, a `1.35` line height, and a five-step fluid scale. Core's default font-size presets are disabled so the theme can intentionally redefine the existing `small`, `medium`, `large`, `x-large`, and `xx-large` slugs. Imported content using those Core-compatible classes therefore continues to resolve predictably without inheriting Core's smaller defaults.

Figure captions use the small preset with a `1.5` line height. This is the only article-specific global typography addition: it improves the dense scientific image credits and descriptions present in imported posts while remaining available to future templates through Core's caption element.

The imported archive also contains a small number of legacy tables and unclassed preformatted blocks, older responsive embeds whose rendered iframes retain fixed HTML dimensions, fixed-width classic caption wrappers, and an obsolete page-builder shortcode that can surface as one unbroken token in a search excerpt. Narrowly scoped custom-CSS declarations live under the affected Core blocks in `theme.json`: tables and preformatted lines scroll within the reading column, embed iframes scale to their container while preserving their intrinsic aspect ratio, legacy captions cannot exceed the reading column, and excerpts may wrap an otherwise unbreakable token. Scoping these rules to Post Content and Post Excerpt is necessary because the stored content predates the wrappers expected by current Core blocks. These compatibility rules prevent horizontal page overflow without rewriting stored content or adding a stylesheet, PHP asset loader, or JavaScript.

The template does not rewrite stored heading levels. A content audit found eight legacy posts containing an H1 inside the article body; those headings should be reviewed and normalized editorially rather than silently changed during rendering.

Arbitrary font sizes, synthetic font styles, letter spacing, line-height overrides, text transforms, vertical writing, and drop caps are unavailable in the editor. These controls are unnecessary for the current editorial model or are unsafe without Tamil-specific testing. Font weight remains available within the bundled family's supported 400–700 range.

Typography is registered and applied through `theme.json`, allowing WordPress to produce matching editor and front-end styles without a stylesheet or PHP enqueue logic. The font files and license are kept together in `assets/fonts/google-sans/`.

Future approved global tokens and block styles should go into `theme.json`. CSS in `assets/css/` is an exception for requirements the WordPress style system cannot express. This keeps Site Editor controls and front-end output aligned.

### Code model

There is no `functions.php` because the current architecture requires no hooks or registrations; WordPress recognizes the block theme from `style.css` and `templates/index.html`, discovers the patterns automatically, and uses `theme.json` for versioned configuration. The patterns' escaped translation calls are the theme's only PHP execution. A minimal `functions.php` may be introduced only when a necessary hook or asset registration exists, with larger concerns split into `inc/`.

`style.css` exists because WordPress reads its header to register the theme. It contains metadata only and is not the starting point for the visual system.

There is no custom JavaScript or build pipeline. The Core Search block conditionally loads WordPress's own Interactivity API module for its expandable field; that behavior is owned and maintained by Core. Theme JavaScript can be added under `assets/js/` only for a confirmed interaction that Core blocks cannot provide. Tailwind, Bootstrap, jQuery-by-default, front-end frameworks, and page builders are excluded.

## Local development

1. Install a local WordPress 6.6+ environment using the team's preferred tool.
2. Place or clone this repository at `wp-content/themes/parimaanam_2026`.
3. Activate **Parimaanam 2026** in **Appearance → Themes**.
4. Open **Appearance → Editor** to inspect block templates and global settings.
5. Set permalinks to match production and test existing URLs against representative production content.
6. After changes, verify the public site and Site Editor, including Tamil and mixed-script content, keyboard navigation, narrow/wide layouts, archives, pagination, and long titles.

Because there is currently no compilation step, changes to HTML templates and `theme.json` are loaded directly by WordPress. Note that Site Editor customizations stored in the database can override theme files; use a clean test database when verifying file changes.

WordPress caches the list of theme-owned pattern files against the `Version` header in `style.css`. Increment that version when adding, removing, or renaming files in `patterns/` so active installations discover the change without database manipulation or cache-clearing hooks. Version `0.2.0` introduced the first theme-owned pattern, version `0.3.0` recorded the shared visual-system polish, and version `0.4.0` introduces the magazine homepage pattern.

## Architectural decisions

1. **Native block theme:** maximizes compatibility with current WordPress editing and template APIs and avoids a parallel rendering system.
2. **Required fallback only:** `index.html` exists to satisfy the block-theme contract and WordPress template hierarchy. It is deliberately not a homepage design.
3. **Text-led site identity:** the shared header uses the dynamic Site Title rather than reproducing the production site's current image-logo treatment. The homepage renders the same dynamic block directly so it can be the page H1 while article and page titles remain their templates' H1. Core Search supplies the only header interaction, and the minimal footer avoids invented copy.
4. **Dynamic core blocks:** article metadata, content, taxonomies, adjacent posts, comments, query results, excerpts, and pagination come from WordPress data, avoiding hard-coded production assumptions.
5. **Constrained publication design system:** `theme.json` defines semantic colors, global layout widths, a predictable Core-compatible spacing scale, Tamil-first typography, shared template-part areas, form controls, focus treatment, and readable captions. The system is intentionally distinct from the old site and avoids decorative branding that has not been approved.
6. **Minimal PHP at the translation boundary:** no server-side customization is needed, so there is no `functions.php`. Query patterns use PHP only to translate and escape their public empty-state messages.
7. **No build toolchain:** the scaffold has nothing to compile. Tooling should be introduced only with a concrete, documented need.
8. **Compatibility-first evolution:** templates follow WordPress's hierarchy and use inherited queries, URLs, taxonomy data, and search terms rather than replacing content structures. Homepage, archive, and search discovery use Core Query and pagination blocks and therefore require no PHP query, content IDs, or hard-coded category assumptions.
9. **Portable navigation:** the theme does not hard-code an imported Navigation post or menu ID. Navigation remains an editor-owned Site Editor assignment so environments with different database IDs and content histories behave safely.
10. **Magazine hierarchy without a framework:** the homepage adapts the editorial hierarchy of a modern news magazine using one inherited Core query and a narrowly scoped CSS grid. It does not copy a third-party theme's branding, proprietary components, subscription features, sliders, or popularity logic, and it does not introduce Tailwind or a build toolchain for one layout requirement.

## Future extension points

- If automatic child-page discovery is approved, add it to Science Series content with Core's Page List block or define a companion-plugin requirement; do not hard-code its imported page ID in the theme.
- Assign approved navigation to the shared header in the Site Editor after obsolete imported menu items and the information architecture have been reviewed.
- Add an approved site icon or logo only if a future identity requires one; the current text-led identity does not depend on an image asset.
- Add reusable editorial compositions to `patterns/`; use synced patterns or database content when editors must manage the copy.
- Add block variations only when a demonstrated editorial requirement needs them.
- Add style variations under `styles/` only if the design calls for intentional alternate visual systems.
- Add `functions.php` and `inc/` modules for narrowly scoped hooks, registrations, or compatibility behavior.
- Add CSS or dependency-free JavaScript assets only for gaps in native block capabilities, documenting each exception here.
- Add automated linting, visual regression checks, and accessibility checks when the development toolchain is selected.

## Scope guard

This remains an evolving theme rather than a production-complete release. It now contains the polished visual foundation for the established publication templates, but no hard-coded navigation, custom editorial content, automatic child-page query logic, analytics, deployment integration, or content migration logic. Those concerns require approved information architecture, editorial decisions, or companion-plugin/infrastructure work and are intentionally outside this theme change.
