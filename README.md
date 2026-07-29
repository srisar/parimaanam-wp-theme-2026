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
│   ├── fonts/
│   │   └── google-sans/
│   │       ├── GoogleSans-Latin-Variable.woff2
│   │       ├── GoogleSans-Tamil-Variable.woff2
│   │       └── OFL.txt
│   └── images/
│       └── parimaanam-logo-web.svg Approved light-on-dark site logo
├── parts/
│   ├── footer.html      Minimal shared publication footer
│   └── header.html      Shared site identity, navigation, and Core search
├── patterns/
│   ├── category-science.php First category-led homepage section
│   ├── category-technology.php Image-led Technology showcase
│   ├── category-biology.php Editorial Biology feature and card section
│   ├── home-categories.php Dynamic category directory
│   ├── home-hero.php     Eight latest posts in three editorial regions
│   ├── header-navigation.php Portable approved primary navigation
│   ├── posts-grid.php    Shared archive/search cards and empty state
│   └── site-logo.php     Portable theme-owned logo linked to the site root
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

The homepage is being assembled section by section. Its first section is the non-inserter `patterns/home-hero.php` composition, made from three non-inherited Core Queries with non-overlapping offsets. The lead query renders the newest article as an image-led feature, the latest-stories query renders the next five articles as a compact headline list, and the supporting query renders the following two articles with images. On wide screens these occupy a three-column editorial layout; intermediate screens place the lead first with the two supporting regions beneath it, and narrow screens form one reading stream.

Each semantic `article` exposes the metadata appropriate to its role. The headline list shows title, categories, and date; the lead shows its image, categories, date, title, and a desktop excerpt; supporting stories show image, metadata, and title. The lead retains a raised dark surface if it lacks an image. The hero intentionally has no pagination: it is a latest-posts module, not the complete posts archive. Later homepage sections will provide category-led discovery after their five categories and ordering are approved. A true Popular region remains deferred because WordPress Core has no popularity signal; displaying recent posts under that label would be misleading, and analytics-driven ranking belongs in an approved plugin or companion plugin.

Section two is the existing Science category (`science`, displayed from WordPress as `அறிவியல்`). It is the second-largest imported category with substantial existing content and diversifies a hero currently dominated by astronomy. `patterns/category-science.php` resolves the category by stable slug rather than importing a database-specific term ID, then passes the environment's resolved ID to two Core Query blocks. The first query renders the newest Science article with image and excerpt; the second renders the next three as compact supporting headlines. Their offsets do not overlap, and the heading links to WordPress's generated category archive URL.

The category section is intentionally its own module beneath the hero. Its lead/support structure can guide later approved category sections, but each category remains explicit so its slug, ordering, post count, and editorial treatment are documented rather than hidden in generic PHP query logic.

Section three uses the existing Technology category (`technology`, displayed as `தொழில்நுட்பம்`). Its ten newest posts all have featured images, so `patterns/category-technology.php` adapts the approved showcase reference into four image-overlay feature cards followed by six compact image-and-headline cards. Two Core Query blocks use offsets `0` and `4`, preventing overlap within the section. Core's four- and three-column Post Template layouts provide responsive collapse without a custom grid implementation.

The Technology heading uses the dark crimson-and-black identity instead of the reference's generic Breaking label. This avoids presenting evergreen archive content as time-sensitive news. As with Science, the pattern resolves the stable category slug to the current environment's term ID and links its database-managed name to the generated Core archive URL.

Section four uses the existing Biology category (`biology`, displayed as `உயிரியல்`). Two wide image-and-text features are followed by four visual cards, using Core Query, Post Template, Columns, and post blocks. The first query starts at offset `1` because the newest Biology article is already shown in the homepage hero; the second begins at offset `3`, keeping all six stories distinct both within the section and from that known hero placement. Its dynamic taxonomy heading follows the same restrained crimson-rule treatment as the other category sections.

The final homepage module is a category directory headed `பிரிவுகள்`. It uses the Core Categories block rather than a hand-maintained menu or hard-coded term IDs, so it lists the current installation's non-empty categories, archive links, and post counts. The wide five-column desktop grid reduces to four columns at tablet width and one column on narrow screens, preserving a comfortable measure for long Tamil category names. Category ordering and visibility remain standard WordPress behavior and can evolve with the publication taxonomy without theme changes.

The homepage header renders the approved theme-owned logo, primary navigation, and search control while retaining the dynamic Site Title as a screen-reader-only H1. Shared inner templates render the same header composition while their post, page, archive, or search title remains the visible H1. The logo pattern derives its asset URL, homepage URL, and alternative text through WordPress APIs, so it remains portable across domains and installation paths.

`archive.html` is the generic Core-convention fallback for category, tag, author, date, custom-taxonomy, and post-type archives. It deliberately avoids category-specific files because the imported taxonomy data does not establish a requirement for different structures. The dynamic Query Title is the page H1 with Core's generic archive prefix hidden, leaving the actual term, author, date, or post-type label intact. The Term Description block displays editor-managed taxonomy context when present and remains empty for non-taxonomy archives.

Archive results use the shared two-column post-card composition and inherited Query Loop.

`search.html` adds a Core Query Title and Search block above the same result composition. The Search block's label and icon-button accessible name come from WordPress Core at render time, so they follow the installed WordPress translation rather than embedding an English theme string. The field retains the current query, allowing readers to refine Tamil, Latin, or mixed-script searches without custom JavaScript.

Search and archives share the same result layout, so `patterns/posts-grid.php` owns their inherited Query Loop, semantic cards, pagination, and no-results state. The homepage has separate compositions because a posts index benefits from stronger editorial hierarchy, while search and archive results should remain predictable and uniform. These native, non-inserter patterns remain represented as Core blocks in the Site Editor. PHP is limited to escaped output, portable URL resolution for the logo and approved navigation pages, and resolving an approved category slug to its environment-specific term ID; WordPress Core Query blocks still perform all post retrieval and rendering.

### Science Series content model

The imported Science Series is existing editorial content, not a custom post type or taxonomy. The published page with slug `science-series` is the parent of six normal child pages. Each child page acts as a curated series index: its stored content contains the introduction, media, ordered parts, descriptions, and links to the corresponding posts. The legacy category named for series is empty and is not treated as authoritative.

`page.html` preserves this established WordPress page hierarchy and its nested permalinks. It renders the dynamic page title as the H1, the complete stored content through the Core Post Content block, and Core comments where the individual page allows them. It omits author/date metadata because these are reference pages rather than chronological posts. It also omits a template-level featured image because most imported series pages already begin with the same lead image in their stored content.

The parent Science Series page currently stores only its approved introductory paragraph; its six child links are represented by the WordPress parent/child relationship but are not present in that content. Core's Page List block can list a selected page's children, but that selection is stored as a numeric page ID and a static theme template cannot bind it to the current page dynamically. The theme therefore does not hard-code imported ID `620`, invent links, or add a PHP query. An editor can add a Page List block filtered to the Science Series parent in the page content, or a future companion plugin can provide a portable dynamic-child-pages block if the same behavior is required more broadly.

Several series pages retain links to both `parimaanam.net` and the site's earlier `parimaanam.wordpress.com` address. The theme intentionally does not rewrite stored editorial URLs. Those links should be verified or migrated at the content layer so redirects and canonical history can be handled explicitly.

`single.html` is the first purpose-built front-end template. It follows WordPress's standard single-post hierarchy and is composed entirely of Core blocks. The shared header supplies the approved site identity, primary navigation, search, and a route home. The article uses semantic `main`, `article`, and nested `header` elements; its category, title, author, publication date, content, tags, adjacent-post navigation, threaded comments, comment pagination, and comment form all come from the current WordPress query.

Single-post titles use the existing `x-large` token instead of the global display-scale H1 token. Representative imported Tamil titles can exceed 60 characters; the smaller fluid range preserves their H1 hierarchy without allowing a headline to consume most of a narrow viewport.

The imported archive commonly uses the featured image again inside the post content. The template therefore does not render the Post Featured Image block: doing so would duplicate the lead image on existing articles. It also omits the Post Excerpt because imported posts commonly begin their content with the same paragraph used as the excerpt. Both decisions preserve existing content without custom PHP detection. A future editorial migration may revisit them after content conventions are normalized.

The reusable `parts/header.html` contains the linked logo, the `header-navigation` pattern, and a button-only Core Search block. The homepage keeps an equivalent inline header because it additionally carries the screen-reader-only Site Title H1, while post and page titles remain the H1 in shared-template views. Core Navigation supplies keyboard-accessible dropdowns and the responsive overlay menu; Core Search supplies its accessible label and expandable field. Primary labels use the compact `small` type token. Expandable group labels are controls rather than destinations: their Core submenu button covers the complete visible row, and the associated landing page remains available as the first child link. At desktop width, submenus use a deep red-black surface, square crimson edge, numbered rows, separators, and a restrained shadow to distinguish the hierarchy without rounded cards. At compact widths, the overlay becomes a left-aligned, scrollable list with full-width tap targets; child pages stay collapsed until readers activate the corresponding Core submenu button. The theme extends Core's visual menu breakpoint to `64rem` because four Tamil labels cannot remain readable across the intermediate header width. The interaction itself remains Core-owned, and the theme ships no JavaScript for either control.

The navigation uses the four labels and destinations approved from the existing site: Science Series, Downloads, Contact, and About. Science Series and Downloads expose their existing child pages as native Navigation submenus. The pattern resolves published pages by stable hierarchical path and falls back to the corresponding installation-relative URL, avoiding imported page IDs, a database-specific Navigation post reference, and production-domain URLs. This gives a clean default on activation while remaining editable as blocks in the Site Editor.

`parts/footer.html` contains only the dynamic linked Site Title. This provides a consistent semantic footer without inventing a copyright statement, slogan, menu, or editorial copy.

### Styling model

`theme.json` uses version 3 and pins its schema reference to the minimum supported WordPress release. The initial design-system layer defines a `44rem` reading measure, an `80rem` wide alignment, and a seven-step multiplicative spacing scale based on WordPress Core's default scale. The Core spacing presets are disabled so these theme-owned values remain authoritative even when their slugs overlap. Editors may use the generated spacing presets for block gaps, margins, and padding, but arbitrary spacing values are disabled to keep layouts consistent. `rem` and `%` are the only exposed spacing units because they cover scalable fixed spacing and container-relative spacing without encouraging viewport- or pixel-specific values.

The reading measure prioritizes long-form Tamil content while retaining room for mixed Tamil and Latin text. The wide measure provides a controlled area for media, galleries, and future article-adjacent content. Both values are global defaults rather than template-specific widths and were verified against representative imported articles while building the single template.

The theme defines a dark red-and-black semantic palette: black `paper` (`#090909`), a subtly warm raised `surface` (`#151112`), deep red `surface-crimson` (`#130c0e`), cool charcoal `surface-cool` (`#0d1215`), off-white `ink` (`#f3efee`), warm-gray `muted` text, restrained `crimson` (`#d45656`), a lighter crimson hover state, a quiet warm `line`, and a deep red `highlight`. The three surface tokens create quiet full-width shifts between homepage sections without turning stories into framed cards. This is a new publication identity, not a recreation of the current production site's color treatment. The palette remains deliberately near-black so long-form Tamil text and scientific imagery stay primary. WordPress's default palette, gradients, and arbitrary custom colors are disabled so editor choices remain coherent.

Global text uses ink on paper. Links remain visibly underlined, while linked headings and site identity use their surrounding typography and gain lighter crimson on hover. Buttons use black paper text on crimson, and `color-scheme: dark` aligns native browser controls with the theme. Intended text combinations range from 8.37:1 to 17.44:1; crimson on black is 4.99:1 and its hover state is 6.18:1. A three-pixel crimson `:focus-visible` outline supports keyboard navigation, and selection colors maintain readable contrast. Featured images remain square-edged; the system avoids decorative effects that would compete with editorial media.

Template gutters continue to use the theme's spacing presets rather than root-aware global padding. This keeps full-width template-part borders and backgrounds predictable while constrained inner groups provide the readable page edge. The header uses a native Core Group bottom border as a strong five-pixel crimson rule, while the locally owned logo is capped at `15rem` so it does not dominate the masthead. The same border is declared on `.site-header` in global theme CSS so the shared template part and homepage's equivalent inline header receive one consistent treatment. Block-level custom CSS remains limited to interaction states, form controls, demonstrated legacy-content compatibility issues, the responsive logo size, Core Navigation presentation, and homepage editorial treatments. The hero's named responsive grid areas and lead-image overlay are scoped under `.home-hero`. Technology overlay and compact-card rules are scoped through the Core Group blocks that own those cards; the surrounding Core Query blocks own responsive column behavior. These text-over-image and media-object arrangements cannot be expressed entirely through block attributes.

The homepage's revised visual system keeps each module structurally native while giving the sections one editorial language. The hero stays on black paper; Science uses the warm surface, Technology uses the red-black surface, Biology uses the cool charcoal surface, and the category directory returns to the warm surface. These full-width Core Group backgrounds create section rhythm while their children remain on the shared `80rem` editorial grid. Numbered lists improve scanning in the latest-post and Science support regions, while typography, whitespace, image scale, square-edged imagery, and short crimson rules establish hierarchy without outlined cards, pill labels, decorative frames, or rounded image treatments. Technology intentionally remains denser than Science and Biology, but its four feature stories reduce to two columns at the intermediate breakpoint so Tamil headlines retain a usable measure. Motion is limited to small image hover feedback and is disabled by `prefers-reduced-motion`.

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

There is no `functions.php` because the current architecture requires no hooks or registrations; WordPress recognizes the block theme from `style.css` and `templates/index.html`, discovers the patterns automatically, and uses `theme.json` for versioned configuration. Pattern PHP is limited to escaped translations, portable theme/home/page URLs, the dynamic site-name alternative text, and category patterns' `get_category_by_slug()`/`get_category_link()` boundary. The navigation pattern uses `get_page_by_path()` and `get_permalink()` only to preserve existing hierarchical page URLs without content IDs. A minimal `functions.php` may be introduced only when a necessary hook or asset registration exists, with larger concerns split into `inc/`.

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

WordPress caches the list of theme-owned pattern files against the `Version` header in `style.css`. Increment that version when adding, removing, or renaming files in `patterns/` so active installations discover the change without database manipulation or cache-clearing hooks. Version `0.2.0` introduced the first theme-owned pattern, version `0.3.0` recorded the shared visual-system polish, version `0.4.0` introduced the first magazine homepage composition, version `0.5.0` narrowed that composition to the latest-posts hero, version `0.6.0` introduced the three-region hero and approved logo pattern, version `0.7.0` added the first category-led section, version `0.8.0` added the Technology showcase, version `0.9.0` added the Biology editorial section, version `0.10.0` unified the homepage's editorial visual system, version `0.11.0` flattened that system and added the dynamic category directory, version `0.12.0` established square-edged imagery, and version `0.13.0` adds the approved portable header navigation pattern.

## Architectural decisions

1. **Native block theme:** maximizes compatibility with current WordPress editing and template APIs and avoids a parallel rendering system.
2. **Required fallback only:** `index.html` exists to satisfy the block-theme contract and WordPress template hierarchy. It is deliberately not a homepage design.
3. **Approved site identity:** the shared header uses the supplied Parimaanam logo and approved primary navigation through portable theme patterns. The homepage retains a screen-reader-only dynamic Site Title H1 while article and page titles remain their templates' visible H1. Core owns the Navigation and Search interactions, and the minimal footer avoids invented copy.
4. **Dynamic core blocks:** article metadata, content, taxonomies, adjacent posts, comments, query results, excerpts, and pagination come from WordPress data, avoiding hard-coded production assumptions.
5. **Constrained publication design system:** `theme.json` defines semantic colors, global layout widths, a predictable Core-compatible spacing scale, Tamil-first typography, shared template-part areas, form controls, focus treatment, and readable captions. The system is intentionally distinct from the old site and avoids decorative branding that has not been approved.
6. **Minimal PHP at output boundaries:** no server-side customization is needed, so there is no `functions.php`. Patterns use PHP only for escaped translations and portable theme, home, page, category, and taxonomy URLs.
7. **No build toolchain:** the scaffold has nothing to compile. Tooling should be introduced only with a concrete, documented need.
8. **Compatibility-first evolution:** templates follow WordPress's hierarchy and use inherited queries, URLs, taxonomy data, and search terms rather than replacing content structures. Homepage, archive, and search discovery use Core Query and pagination blocks and therefore require no PHP query, content IDs, or hard-coded category assumptions.
9. **Portable navigation:** the approved Core Navigation composition resolves existing pages by stable hierarchical paths and contains no imported Navigation post, menu, or page IDs. Core provides dropdown, keyboard, and mobile-overlay behavior without theme JavaScript; editors can still customize the blocks in the Site Editor.
10. **Section-based magazine homepage:** the homepage begins with an eight-post hero powered by three small, non-overlapping Core queries: headline list, lead feature, and visual support. Separating these roles from future category modules keeps each query and editorial purpose explicit. It does not copy a third-party theme's branding, proprietary components, subscription features, sliders, or popularity logic, and it does not introduce Tailwind or a build toolchain for one layout requirement.
11. **Explicit category modules:** the first category section uses the real `science` slug and resolves its local term ID at pattern-registration time. The stable slug and Core category archive URL preserve portability without hard-coding imported ID `3`, while two non-overlapping Core queries provide a lead/support hierarchy.
12. **Image-led Technology showcase:** the real `technology` slug supplies four overlay features and six compact stories through two non-overlapping Core queries. Core Post Template columns handle responsive reflow; custom CSS is limited to the image overlay and compact media-object presentation. The section uses its taxonomy name rather than making an unsupported Breaking-news claim.
13. **Editorial Biology section:** the real `biology` slug supplies two paired features and four smaller visual stories. Core Columns handle each feature's responsive image-and-text arrangement, while Core Post Template columns handle the outer layouts. Its deliberate first-post offset avoids repeating the Biology article already present in the hero, and its category heading remains database-driven.
14. **Unified editorial presentation:** the existing queries and content hierarchy remain unchanged while scoped `theme.json` CSS supplies the modern presentation layer. Each section retains a distinct reading cadence, but shared typography, spacing, restrained accents, focus treatment, responsive image behavior, and reduced-motion support make the homepage feel like one publication rather than unrelated modules.
15. **Core-powered category discovery:** the category directory uses Core's Categories block to expose the site's current non-empty taxonomy with generated archive URLs and counts. It introduces no menu ID, category ID, custom query, or PHP rendering logic, and its responsive grid is presentation-only.

## Future extension points

- If automatic child-page discovery is approved, add it to Science Series content with Core's Page List block or define a companion-plugin requirement; do not hard-code its imported page ID in the theme.
- Extend or reorder the approved primary navigation only when the publication information architecture changes; keep destinations portable and avoid database-specific menu or page IDs.
- Add an approved site icon if the identity requires one; the supplied header logo is already theme-owned.
- Add reusable editorial compositions to `patterns/`; use synced patterns or database content when editors must manage the copy.
- Add block variations only when a demonstrated editorial requirement needs them.
- Add style variations under `styles/` only if the design calls for intentional alternate visual systems.
- Add `functions.php` and `inc/` modules for narrowly scoped hooks, registrations, or compatibility behavior.
- Add CSS or dependency-free JavaScript assets only for gaps in native block capabilities, documenting each exception here.
- Add automated linting, visual regression checks, and accessibility checks when the development toolchain is selected.

## Scope guard

This remains an evolving theme rather than a production-complete release. It now contains the polished visual foundation and approved primary navigation for the established publication templates, but no database-specific menu reference, custom editorial content, automatic child-page query logic, analytics, deployment integration, or content migration logic. Those concerns require approved information architecture, editorial decisions, or companion-plugin/infrastructure work and are intentionally outside this theme change.
