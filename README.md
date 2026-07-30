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
├── CHANGELOG.md         Version history and the pattern-cache version rule
├── functions.php        Text domain, font preload, and stylesheet enqueues
├── README.md            Architecture and local workflow
├── style.css            Theme metadata and the scoped article-sidebar layout
├── theme.json           Design tokens, global styles, and block compatibility
├── assets/
│   ├── css/
│   │   ├── footer.css   Footer regions, logo size, and secondary menu
│   │   ├── header.css   Masthead, logo, and Core Navigation presentation
│   │   └── homepage.css Hero, category sections, and category directory
│   ├── fonts/
│   │   └── google-sans/
│   │       ├── GoogleSans-Latin-Variable.woff2
│   │       ├── GoogleSans-Tamil-Variable.woff2
│   │       └── OFL.txt
│   └── images/
│       └── parimaanam-logo-web.svg Approved light-on-dark site logo
├── inc/
│   └── navigation.php   Approved page paths shared by header and footer
├── parts/
│   ├── footer.html      Shared discovery footer composition
│   └── header.html      Shared site identity, navigation, and Core search
├── patterns/
│   ├── category-science.php First category-led homepage section
│   ├── category-technology.php Image-led Technology showcase
│   ├── category-biology.php Editorial Biology feature and card section
│   ├── article-sidebar.php Native single-article discovery widgets
│   ├── error-404.php     Not-found copy, search, and recent articles
│   ├── footer-columns.php Logo, Science Series, and secondary menu
│   ├── footer-meta.php   Site title, copyright, and privacy link
│   ├── home-categories.php Dynamic category directory
│   ├── search-title.php  Tamil search-results heading with the query term
│   ├── home-hero.php     Eight latest posts in three editorial regions
│   ├── header-navigation.php Portable approved primary navigation
│   ├── posts-grid.php    Shared archive/search cards and empty state
│   └── site-logo.php     Core Site Logo when set, theme asset as fallback
└── templates/
    ├── 404.html         Designed response for URLs that match no content
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

`404.html` exists because that deliberate plainness is the wrong response to a missing URL. Without it WordPress falls back to `index.html`, so a reader following a stale link would land on an unstyled page with no route onward. The imported Science Series content still contains links to the site's earlier `parimaanam.wordpress.com` address, so missing URLs are an expected condition rather than a hypothetical one. The template pairs the shared header with `patterns/error-404.php`, which supplies a Core Search block and the three newest posts. Its copy lives in a pattern because block templates cannot contain PHP, and therefore cannot hold translatable strings.

`home.html` follows the WordPress posts-index hierarchy and works whether the posts index is the site's front page or is assigned to a separate page. There is no `front-page.html`: the current site setting displays the latest posts, and adding a front-page override would duplicate the posts-index responsibility without an approved static front-page requirement.

The homepage is being assembled section by section. Its first section is the non-inserter `patterns/home-hero.php` composition, made from three non-inherited Core Queries with non-overlapping offsets. The lead query renders the newest article as an image-led feature, the latest-stories query renders the next five articles as a compact headline list, and the supporting query renders the following two articles with images. On wide screens these occupy a three-column editorial layout; intermediate screens place the lead first with the two supporting regions beneath it, and narrow screens form one reading stream.

Each semantic `article` exposes the metadata appropriate to its role. The headline list shows title, categories, and date; the lead shows its image, categories, date, title, and a desktop excerpt; supporting stories show image, metadata, and title. The lead retains a raised dark surface if it lacks an image. The hero intentionally has no pagination: it is a latest-posts module, not the complete posts archive. Later homepage sections will provide category-led discovery after their five categories and ordering are approved. A true Popular region remains deferred because WordPress Core has no popularity signal; displaying recent posts under that label would be misleading, and analytics-driven ranking belongs in an approved plugin or companion plugin.

Section two is the existing Science category (`science`, displayed from WordPress as `அறிவியல்`). It is the second-largest imported category with substantial existing content and diversifies a hero currently dominated by astronomy. `patterns/category-science.php` resolves the category by stable slug rather than importing a database-specific term ID, then passes the environment's resolved ID to two Core Query blocks. The first query renders the newest Science article with image and excerpt; the second renders the next three as compact supporting headlines. Their offsets do not overlap, and the heading links to WordPress's generated category archive URL.

The category section is intentionally its own module beneath the hero. Its lead/support structure can guide later approved category sections, but each category remains explicit so its slug, ordering, post count, and editorial treatment are documented rather than hidden in generic PHP query logic.

Section three uses the existing Technology category (`technology`, displayed as `தொழில்நுட்பம்`). Its ten newest posts all have featured images, so `patterns/category-technology.php` adapts the approved showcase reference into four image-overlay feature cards followed by six compact image-and-headline cards. Two Core Query blocks use offsets `0` and `4`, preventing overlap within the section. Both use Core's Post Template grid layout with a minimum column width, so columns are chosen from the space actually available rather than from viewport breakpoints, and no custom grid implementation is needed.

The Technology heading uses the dark crimson-and-black identity instead of the reference's generic Breaking label. This avoids presenting evergreen archive content as time-sensitive news. As with Science, the pattern resolves the stable category slug to the current environment's term ID and links its database-managed name to the generated Core archive URL.

Section four uses the existing Biology category (`biology`, displayed as `உயிரியல்`). Two wide image-and-text features are followed by four visual cards, using Core Query, Post Template, Columns, and post blocks. The first query starts at offset `1` because the newest Biology article is already shown in the homepage hero; the second begins at offset `3`, keeping all six stories distinct both within the section and from that known hero placement. Its dynamic taxonomy heading follows the same restrained crimson-rule treatment as the other category sections.

The final homepage module is a category directory headed `பிரிவுகள்`. It uses the Core Categories block rather than a hand-maintained menu or hard-coded term IDs, so it lists the current installation's non-empty categories, archive links, and post counts. The wide five-column desktop grid reduces to four columns at tablet width and one column on narrow screens, preserving a comfortable measure for long Tamil category names. Category ordering and visibility remain standard WordPress behavior and can evolve with the publication taxonomy without theme changes.

Every public template, including the homepage, renders the same `parts/header.html` template part with the approved theme-owned logo, primary navigation, and search control. The homepage places the dynamic Site Title immediately after that part as a screen-reader-only H1, while post, page, archive, and search titles remain their templates' visible H1. The logo follows the same portable-default-then-database-managed model as the navigation. When an editor has set a logo in WordPress, `patterns/site-logo.php` emits Core's Site Logo block, so the image, its responsive `srcset`, its link, and its alternative text all become WordPress-managed and editable in the Site Editor. Until then the pattern falls back to the bundled theme asset, deriving its URL, homepage URL, and alternative text through WordPress APIs so a fresh installation is never left without site identity. Both branches carry the `parimaanam-site-logo` class, so the responsive cap in `assets/css/header.css` applies either way.

`archive.html` is the generic Core-convention fallback for category, tag, author, date, custom-taxonomy, and post-type archives. It deliberately avoids category-specific files because the imported taxonomy data does not establish a requirement for different structures. The dynamic Query Title is the page H1 with Core's generic archive prefix hidden, leaving the actual term, author, date, or post-type label intact. The Term Description block displays editor-managed taxonomy context when present and remains empty for non-taxonomy archives.

Archive results use the shared two-column post-card composition and inherited Query Loop.

`search.html` adds a results heading and a Core Search block above the same result composition. The Search block's label and icon-button accessible name come from WordPress Core at render time, so they follow the installed WordPress translation rather than embedding an English theme string. The field retains the current query, allowing readers to refine Tamil, Latin, or mixed-script searches without custom JavaScript.

The heading comes from `patterns/search-title.php` rather than the Core Query Title block. Core uses two different source strings for this view: `wp_get_document_title()` renders the browser tab through a string the Tamil translation pack covers, while the Query Title block uses a separate string it does not. On a `ta-IN` installation that produced a Tamil browser tab above an English `Search results for:` heading on the same page. The pattern reuses the phrasing Core's own Tamil translation already applies to the document title, so heading and tab now match. The search term is read unescaped through `get_search_query( false )` and escaped once for HTML output, which was verified against markup-bearing input.

Search and archives share the same result layout, so `patterns/posts-grid.php` owns their inherited Query Loop, semantic cards, pagination, and no-results state. The homepage has separate compositions because a posts index benefits from stronger editorial hierarchy, while search and archive results should remain predictable and uniform. These native, non-inserter patterns remain represented as Core blocks in the Site Editor. PHP is limited to escaped output, portable URL resolution for the logo and approved navigation pages, and resolving an approved category slug to its environment-specific term ID; WordPress Core Query blocks still perform all post retrieval and rendering.

### Science Series content model

The imported Science Series is existing editorial content, not a custom post type or taxonomy. The published page with slug `science-series` is the parent of six normal child pages. Each child page acts as a curated series index: its stored content contains the introduction, media, ordered parts, descriptions, and links to the corresponding posts. The legacy category named for series is empty and is not treated as authoritative.

`page.html` preserves this established WordPress page hierarchy and its nested permalinks. It renders the dynamic page title as the H1, the complete stored content through the Core Post Content block, and Core comments where the individual page allows them. It omits author/date metadata because these are reference pages rather than chronological posts. It also omits a template-level featured image because most imported series pages already begin with the same lead image in their stored content.

The parent Science Series page currently stores only its approved introductory paragraph; its six child links are represented by the WordPress parent/child relationship but are not present in that content. Core's Page List block can list a selected page's children, but that selection is stored as a numeric page ID and a static theme template cannot bind it to the current page dynamically. The theme therefore does not hard-code imported ID `620`, invent links, or add a PHP query. An editor can add a Page List block filtered to the Science Series parent in the page content, or a future companion plugin can provide a portable dynamic-child-pages block if the same behavior is required more broadly.

Several series pages retain links to both `parimaanam.net` and the site's earlier `parimaanam.wordpress.com` address. The theme intentionally does not rewrite stored editorial URLs. Those links should be verified or migrated at the content layer so redirects and canonical history can be handled explicitly.

`single.html` is the first purpose-built front-end template. It follows WordPress's standard single-post hierarchy and is composed entirely of Core blocks. The shared header supplies the approved site identity, primary navigation, search, and a route home. The article uses semantic `main`, `article`, and nested `header` elements; its category, title, publication date, content, tags, adjacent-post navigation, threaded comments, comment pagination, and comment form all come from the current WordPress query. Author attribution is intentionally omitted from this publication-level template.

On wide screens, the article expands into the available space beside the fixed discovery sidebar, and both regions occupy the shared `80rem` container used by the masthead. This gives long-form article media and text the complete remaining column rather than leaving unused space between article and sidebar. Below the wide breakpoint, Core's narrower `44rem` reading measure remains in effect and the sidebar follows the article in the normal document flow. The sidebar uses only Core Search, Categories, Archives, and Latest Posts blocks, so WordPress owns the search behavior, taxonomy links and counts, monthly archive options, dates, and recent-post selection. Adjacent-post navigation and comments remain below both regions.

Single-post titles use the existing `x-large` token instead of the global display-scale H1 token. Representative imported Tamil titles can exceed 60 characters; the smaller fluid range preserves their H1 hierarchy without allowing a headline to consume most of a narrow viewport.

The imported archive commonly uses the featured image again inside the post content. The template therefore does not render the Post Featured Image block: doing so would duplicate the lead image on existing articles. It also omits the Post Excerpt because imported posts commonly begin their content with the same paragraph used as the excerpt. Both decisions preserve existing content without custom PHP detection. A future editorial migration may revisit them after content conventions are normalized.

The reusable `parts/header.html` is the single header source for every template. It contains the linked logo, the `header-navigation` default pattern, and a button-only Core Search block. The homepage's screen-reader-only Site Title H1 lives directly in `home.html`, keeping that document outline correct without duplicating the header. Core Navigation supplies keyboard-accessible dropdowns and the responsive overlay menu; Core Search supplies its accessible label and expandable field. Primary labels use the compact `small` type token. Expandable group labels are controls rather than destinations: their Core submenu button covers the complete visible row, and the associated landing page remains available as the first child link. At desktop width, submenus use a deep red-black surface, square crimson edge, numbered rows, separators, and a restrained shadow to distinguish the hierarchy without rounded cards. At compact widths, the overlay becomes a left-aligned, scrollable list with full-width tap targets; child pages stay collapsed until readers activate the corresponding Core submenu button. The theme extends Core's visual menu breakpoint to `64rem` because four Tamil labels cannot remain readable across the intermediate header width. The interaction itself remains Core-owned, and the theme ships no JavaScript for either control.

The navigation uses the four labels and destinations approved from the existing site: Science Series, Downloads, Contact, and About. Science Series and Downloads expose their existing child pages as native Navigation submenus. The pattern resolves published pages by stable hierarchical path and falls back to the corresponding installation-relative URL, avoiding imported page IDs, a database-specific Navigation post reference, and production-domain URLs. This is the portable first-activation default. When an editor changes and saves the Navigation block, WordPress Core creates or updates its `wp_navigation` entity and stores the resulting reference in the customized shared Header template part. Subsequent menu changes are database-managed through the Site Editor and apply to every template; the theme never hard-codes that environment-specific entity ID.

`parts/footer.html` is deliberately quiet: the site logo and a horizontal secondary menu on one row, over a thin strip carrying the copyright line and a privacy link.

It reached that shape by subtraction. A category list was built first and removed because it restated the homepage directory and pushed the mobile footer to 1340px. A Science Series column followed and was also removed: the series are already one click away in the header dropdown, and a publication footer that repeats navigation earns less than one that simply closes the page. Search, categories, monthly archives, and latest posts all remain available in the article sidebar, so none of them belong here either. The footer is now 189px at desktop and 320px on a phone.

The secondary links are a Core Navigation block, so an editor can add, rename, reorder, or remove them in the Site Editor exactly as they already can for the header. Saving there makes WordPress own that menu; the four links in the pattern are only the portable first-activation default. Its overlay menu is disabled so it never collapses into a hamburger inside a footer column.

The logo reuses `patterns/site-logo.php`, so it is the Core Site Logo block wherever an editor has set one and the bundled asset otherwise. Only its maximum width is overridden, since the masthead and the footer want different weights from the same mark. The linked Site Title is gone from the strip because the logo already links home.

Nothing in the footer is invented copy. Every secondary link label already existed in the header pattern. The privacy link is produced by `get_the_privacy_policy_link()`, which returns nothing at all unless an editor has designated a privacy page and published it; its link text is that page's own title.

The copyright line is the one piece of supplied editorial copy: `© %1$s %2$s. அனைத்து உரிமைகளும் பாதுகாக்கப்பட்டவை.` Its wording was given by the publication rather than drafted here, because a rights assertion is an editorial and legal statement rather than boilerplate. The year comes from `wp_date()` and the name from settings, so neither can go stale and neither is hard-coded — an installation whose Site Title is not yet Tamil will render its own name in the same sentence.

### Styling model

`theme.json` uses version 3 and pins its schema reference to the minimum supported WordPress release. The initial design-system layer defines a `44rem` reading measure, an `80rem` wide alignment, and a seven-step multiplicative spacing scale based on WordPress Core's default scale. The Core spacing presets are disabled so these theme-owned values remain authoritative even when their slugs overlap. Editors may use the generated spacing presets for block gaps, margins, and padding, but arbitrary spacing values are disabled to keep layouts consistent. `rem` and `%` are the only exposed spacing units because they cover scalable fixed spacing and container-relative spacing without encouraging viewport- or pixel-specific values.

The reading measure prioritizes long-form Tamil content while retaining room for mixed Tamil and Latin text. The wide measure provides a controlled area for media, galleries, and future article-adjacent content. Both values are global defaults rather than template-specific widths and were verified against representative imported articles while building the single template.

The theme defines a neutral near-black palette: black `paper` (`#090909`), a raised `surface` (`#1e1e1e`), off-white `ink` (`#f3efee`), warm-gray `muted` text, restrained `crimson` (`#d45656`), a lighter crimson hover state, a quiet `line`, and a deep red `highlight`. This is a new publication identity, not a recreation of the current production site's color treatment. The palette remains deliberately near-black so long-form Tamil text and scientific imagery stay primary. WordPress's default palette, default gradients, and arbitrary custom colors are disabled so editor choices remain coherent.

The palette was originally red-tinted, with three separate surface tokens shading warm, red-black, and cool charcoal. That was replaced because the accent and the grounds shared a hue: crimson sitting on red-tinted black never separated from it, and the accent read muddy rather than sharp. Removing the tint from the surfaces is what makes crimson land. Two tokens became unnecessary in the process and were deleted, taking the palette from ten colors to eight.

Section backgrounds are now two `theme.json` gradient presets rather than flat fills. `graphite-descend` runs `#090909` to `#151515` and `graphite-ascend` returns; sections alternate between them, so every seam meets on the same value and the page reads as one continuous surface. Because they are presets, sections apply them through Core's native Group `gradient` attribute and no custom CSS is involved. Alternating two presets also means the sequence stays seamless however many sections are added or removed.

`surface` sits at `#1e1e1e`, deliberately above the gradient's `#151515` peak. At the previous value a filled card in the Science section became indistinguishable from the gradient behind its lower edge — a one-value difference. Raising it keeps cards, form controls, quotes, and the navigation dropdown legible against every point of the gradient.

Global text uses ink on paper. Links remain visibly underlined, while linked headings and site identity use their surrounding typography and gain lighter crimson on hover. Buttons use black paper text on crimson, and `color-scheme: dark` aligns native browser controls with the theme. Intended text combinations range from 8.37:1 to 17.44:1; crimson on black is 4.99:1 and its hover state is 6.18:1. A three-pixel crimson `:focus-visible` outline supports keyboard navigation, and selection colors maintain readable contrast. Featured images remain square-edged; the system avoids decorative effects that would compete with editorial media.

Template gutters continue to use the theme's spacing presets rather than root-aware global padding. This keeps full-width template-part borders and backgrounds predictable while constrained inner groups provide the readable page edge. The shared header uses a native Core Group bottom border as a strong five-pixel crimson rule, while the locally owned logo is capped at `15rem` so it does not dominate the masthead. The same border is declared on `.site-header` in global theme CSS so file-based and Site Editor-customized copies retain one consistent treatment. Block-level custom CSS remains limited to interaction states, form controls, demonstrated legacy-content compatibility issues, the responsive logo size, Core Navigation presentation, homepage editorial treatments, and the article/sidebar responsive grid. The sidebar rules live in `style.css` because Core block attributes and `theme.json` cannot express this class-scoped two-region breakpoint; they add no new tokens and continue to consume the global spacing, color, and type presets. The hero's named responsive grid areas and lead-image overlay are scoped under `.home-hero`. Technology overlay and compact-card rules are scoped through the Core Group blocks that own those cards; the surrounding Core Query blocks own responsive column behavior. These text-over-image and media-object arrangements cannot be expressed entirely through block attributes.

The homepage's revised visual system keeps each module structurally native while giving the sections one editorial language. The hero stays on black paper, then Science, Technology, Biology, and the category directory alternate the two graphite gradients so the page descends and returns without a visible join. `home.html` sets the main container's `blockGap` to zero and drops its bottom padding; otherwise Core's default block gap left an eighty-one pixel band of bare page background between every section, which broke the continuity the backgrounds were there to create. Each section's own padding now provides that breathing room from the inside. These full-width Core Group backgrounds create section rhythm while their children remain on the shared `80rem` editorial grid. Numbered lists improve scanning in the latest-post and Science support regions, while typography, whitespace, image scale, square-edged imagery, and short crimson rules establish hierarchy without outlined cards, pill labels, decorative frames, or rounded image treatments. Technology intentionally remains denser than Science and Biology. Its four feature stories still reduce to two columns at tablet width so Tamil headlines retain a usable measure, but that now falls out of the grid's minimum column width rather than a media query overriding Core's inline widths. Motion is limited to small image hover feedback and is disabled by `prefers-reduced-motion`.

### Typography

The theme locally hosts Google Sans under the SIL Open Font License 1.1. Two optimized WOFF2 subsets cover Tamil and Latin while sharing one variable family and a weight range of 400 through 700. WordPress emits both `@font-face` declarations directly from `theme.json`; their `unicodeRange` descriptors let the browser fetch only the subset required by the text on a page. This avoids a Google Fonts runtime dependency and is substantially smaller than shipping the full multi-script TTF package. System UI and generic sans-serif fonts remain fallbacks for characters outside the bundled ranges.

The files are the unmodified variable subsets served by the official Google Fonts CSS API for Google Sans. The Tamil range is `U+0964-0965, U+0B82-0BFA, U+200C-200D, U+20B9, U+25CC`; the Latin range is the API's standard Latin subset. Their SIL Open Font License is stored beside them. One family keeps mixed-script scientific writing visually coherent, while the semantic `primary` preset decouples templates and styles from the font's product name.

The global reading size scales from `1rem` to `1.125rem` with a `1.8` line height.

Every fluid preset is pinned at its minimum below roughly 768px, so those minima are exactly what a phone renders and are the single lever for phone typography. They were lowered once the templates were built: headings in particular were set for desktop and carried too much weight on a narrow screen, where a 36px `xx-large` and a 28px `x-large` crowded out the text beneath them. Maximums were left alone, so desktop is untouched.

The body minimum stops at `1rem` rather than going further. Sixteen pixels is the conventional floor for sustained reading, and this is long-form Tamil prose; the headings absorbed most of the reduction instead. Headings use the same family at weight 700, a `1.35` line height, and a five-step fluid scale. Core's default font-size presets are disabled so the theme can intentionally redefine the existing `small`, `medium`, `large`, `x-large`, and `xx-large` slugs. Imported content using those Core-compatible classes therefore continues to resolve predictably without inheriting Core's smaller defaults.

Figure captions use the small preset with a `1.5` line height. This is the only article-specific global typography addition: it improves the dense scientific image credits and descriptions present in imported posts while remaining available to future templates through Core's caption element.

The imported archive also contains a small number of legacy tables and unclassed preformatted blocks, older responsive embeds whose rendered iframes retain fixed HTML dimensions, fixed-width classic caption wrappers, and an obsolete page-builder shortcode that can surface as one unbroken token in a search excerpt. Narrowly scoped custom-CSS declarations live under the affected Core blocks in `theme.json`: tables and preformatted lines scroll within the reading column, embed iframes scale to their container while preserving their intrinsic aspect ratio, legacy captions cannot exceed the reading column, and excerpts may wrap an otherwise unbreakable token. Scoping these rules to Post Content and Post Excerpt is necessary because the stored content predates the wrappers expected by current Core blocks. These compatibility rules prevent horizontal page overflow without rewriting stored content or adding a stylesheet, PHP asset loader, or JavaScript.

The template does not rewrite stored heading levels. A content audit found eight legacy posts containing an H1 inside the article body; those headings should be reviewed and normalized editorially rather than silently changed during rendering.

Arbitrary font sizes, synthetic font styles, letter spacing, line-height overrides, text transforms, vertical writing, and drop caps are unavailable in the editor. These controls are unnecessary for the current editorial model or are unsafe without Tamil-specific testing. Font weight remains available within the bundled family's supported 400–700 range.

Typography is registered and applied through `theme.json`, allowing WordPress to produce matching editor and front-end styles without a stylesheet or PHP enqueue logic. The font files and license are kept together in `assets/fonts/google-sans/`.

The masthead and homepage rules now live in `assets/css/header.css` and `assets/css/homepage.css` rather than in a `theme.json` `styles.css` string. That string had grown to roughly eleven kilobytes on a single line, which made any change to navigation or homepage styling impossible to review in a diff and easy to break silently. Only genuinely global declarations remain in `theme.json`: `color-scheme`, the selection colours, and the `:focus-visible` outline. Block-scoped `css` entries stay in `theme.json` because their `&` prefix gets block scoping that a plain stylesheet cannot reproduce.

The split changes no rendered styling. It was verified by flattening the original string and the new files into normalised selector-and-declaration triples and diffing them; the only intended difference is the `prefers-reduced-motion` rule, whose selector list is divided so each half sits beside the component it styles. Because these rules are now an external file rather than inline global styles, browsers can also cache them between views instead of re-downloading them inside every HTML response.

The theme uses three responsive breakpoints, and only three:

| Value | Pixels | Tier | What changes |
| --- | --- | --- | --- |
| `40rem` | 640px | tablet | single column becomes multi-column |
| `64rem` | 1024px | desktop | navigation leaves the overlay; widest grids |
| `72rem` | 1152px | wide | the article gains its sidebar |

Tablet sits at 640px rather than the more usual 768px because most tablets in portrait are narrower than 768px. An iPad mini is 744px and small Android tablets are around 600px, so at the conventional value every one of them received the phone layout: 744px of screen rendering a single column with a hidden excerpt. Below 640px is genuinely phone territory, since the widest common phone is 430px. Verified at the boundary — 639px takes the mobile layout, 640px the tablet one — and at 640px the narrowest resulting text column is 181px with no element overflowing.

They cannot be centralized into variables: CSS custom properties are invalid inside media query conditions, and the only alternatives are a build step or duplication. The theme has no build step, so the values are literals and the canonical list lives in a comment block at the top of `style.css`. Every stylesheet that uses a breakpoint names which ones it uses and points there. Changing the look at a given width therefore means a deliberate edit across at most three files.

`63.99rem` appears once, as the deliberate complement of `64rem` where a pair must not overlap. The newer media range syntax would express that more cleanly, but the mobile navigation overlay lives inside that query: a browser that cannot parse the condition discards the entire block, and losing the overlay is a worse failure than an untidy rule. The compatible form is kept for that reason.

`72rem` exists because the article cannot share `64rem` with its sidebar. A twenty-rem sidebar plus its gap would leave the article around forty-one rem, below the forty-four rem reading measure the whole type system is built on.

New work should reach for intrinsic sizing before a fourth breakpoint. The homepage category sections and the entire footer carry no width queries at all: their columns come from grid minimum column widths and flex wrapping, so they respond to the space they actually have rather than to the viewport. That is why converting the sections to grid layouts allowed a media query to be deleted rather than added.

Future approved global tokens and block styles should go into `theme.json`. CSS in `assets/css/` is an exception for requirements the WordPress style system cannot express. This keeps Site Editor controls and front-end output aligned.

### Code model

`functions.php` contains three narrowly scoped Core hooks and renders no markup. An `enqueue_block_assets` hook loads `style.css` and the two `assets/css/` files on both the front end and in the block editor, keeping editor and front-end presentation aligned. An `after_setup_theme` hook calls `load_theme_textdomain()`: the pattern strings were already marked for translation, but without this nothing loaded the domain, so none of them could actually be translated. A `wp_preload_resources` filter preloads the Tamil font subset, because WordPress emits the `@font-face` rules from `theme.json` but does not preload them, leaving the browser to discover the file only after parsing the stylesheet. Tamil carries the headline text on every view, so it is the subset worth an early connection; Latin stays lazily fetched.

`inc/` now exists and holds one module. `inc/navigation.php` owns the approved page-path map and resolves paths to URLs, because the header and the footer link to the same destinations and two copies of that list would eventually drift apart. `functions.php` requires it. Labels deliberately stay in the patterns that output them: translation calls must receive string literals, so `esc_html_x( $variable )` would not be extractable by tooling. `inc/` therefore owns paths and resolution only.

Source strings are Tamil throughout rather than English. The publication is Tamil-only, so an English source layer would add a translation catalogue that nobody would ever translate away from. The one English string that had survived in `patterns/posts-grid.php` was an inconsistency rather than a convention. Pattern PHP is limited to escaped translations, portable theme/home/page URLs, the dynamic site-name alternative text, translated article-sidebar headings, and category patterns' `get_category_by_slug()`/`get_category_link()` boundary. The navigation pattern uses `get_page_by_path()` and `get_permalink()` only to preserve existing hierarchical page URLs without content IDs. Larger PHP concerns should be added only for a necessary hook or registration and split into `inc/`.

`style.css` begins with the metadata WordPress uses to register the theme. Its only presentation rules are the responsive single-article grid and sidebar details that cannot be represented with block attributes or `theme.json`; design tokens and global block styles remain in `theme.json`.

There is no build pipeline, and the theme ships exactly one script: `assets/js/search-overlay.js`, around forty lines with no dependencies.

It exists because the header search is the one interaction Core cannot provide. The Core Search block only expands its field in place, which on a masthead holding a logo, four Tamil navigation labels, and a search control pushes the navigation sideways as the field grows. A full-focus overlay is not among the block's options, so this qualifies under the rule that theme JavaScript is added only for a confirmed interaction Core blocks cannot supply.

The script is a genuine enhancement rather than a requirement. `patterns/header-search.php` renders the trigger as a real link to the search results page, so the control works with the script absent, blocked, or still loading, and on any browser without `<dialog>` support — the script returns early in that case rather than degrading. It is loaded with `defer` on the front end only, since an overlay would merely obstruct the editor.

Native `<dialog>` supplies the focus trap, Escape handling, the backdrop, and returning focus to the trigger on close, so none of that is reimplemented. The script only opens the dialog, moves focus to the field, and closes on the close control or a backdrop click. Tailwind, Bootstrap, jQuery-by-default, front-end frameworks, and page builders remain excluded.

## Local development

1. Install a local WordPress 6.6+ environment using the team's preferred tool.
2. Place or clone this repository at `wp-content/themes/parimaanam_2026`.
3. Activate **Parimaanam 2026** in **Appearance → Themes**.
4. Open **Appearance → Editor** to inspect block templates and global settings.
5. Set permalinks to match production and test existing URLs against representative production content.
6. After changes, verify the public site and Site Editor, including Tamil and mixed-script content, keyboard navigation, narrow/wide layouts, archives, pagination, and long titles.

Because there is currently no compilation step, changes to HTML templates and `theme.json` are loaded directly by WordPress. Note that Site Editor customizations stored in the database can override theme files; use a clean test database when verifying file changes.

To manage the primary menu, open **Appearance → Editor**, select the shared **Header**, select its Navigation block, and add, remove, rename, reorder, or nest links. Saving stores the result in the shared Header customization, and may also create a WordPress-managed Navigation entity. Because every template references the same Header part, one saved menu applies site-wide. Reverting the Header customization restores the portable menu supplied by `patterns/header-navigation.php`.

To set the logo, open the same **Header** and use Core's Site Logo block, or **Settings → General**. Once a logo is set, `patterns/site-logo.php` stops emitting the bundled theme asset and defers to WordPress.

Two consequences of Site Editor customization are worth knowing before deploying. First, once the Header is saved, its patterns are **expanded into stored block markup**; the template part no longer re-reads `parts/header.html` or its patterns, so later theme-side changes to the header, logo, or menu will not appear until that customization is reverted. Second, saved navigation links are stored as **absolute URLs for the environment they were saved in**. Content captured on a local install will therefore carry `localhost` links, which must be rewritten or re-saved rather than copied to production as-is. Neither is a theme defect; both are standard WordPress behaviour that this theme's portable defaults are designed to survive.

WordPress caches the list of theme-owned pattern files against the `Version` header in `style.css`. Increment that version when adding, removing, or renaming files in `patterns/` so active installations discover the change without database manipulation or cache-clearing hooks. See `CHANGELOG.md` for the version history.

## Architectural decisions

1. **Native block theme:** maximizes compatibility with current WordPress editing and template APIs and avoids a parallel rendering system.
2. **Required fallback only:** `index.html` exists to satisfy the block-theme contract and WordPress template hierarchy. It is deliberately not a homepage design.
3. **Approved site identity:** every template uses one shared header with the Parimaanam logo, approved primary navigation, and search. Both the logo and the menu are portable theme defaults that become WordPress-managed once an editor sets them, so neither requires a theme change to maintain. The homepage retains a separate screen-reader-only dynamic Site Title H1 while article and page titles remain their templates' visible H1. Core owns the Navigation, Site Logo, and Search interactions, and the minimal footer avoids invented copy.
4. **Dynamic core blocks:** article metadata, content, taxonomies, adjacent posts, comments, query results, excerpts, and pagination come from WordPress data, avoiding hard-coded production assumptions.
5. **Constrained publication design system:** `theme.json` defines semantic colors, global layout widths, a predictable Core-compatible spacing scale, Tamil-first typography, shared template-part areas, form controls, focus treatment, and readable captions. The system is intentionally distinct from the old site and avoids decorative branding that has not been approved.
6. **Minimal PHP at defined boundaries:** patterns use PHP only for escaped translations and portable theme, home, page, category, and taxonomy URLs. The sole theme hook enqueues the responsive sidebar stylesheet in both the front end and block editor; templates remain native block markup.
7. **No build toolchain:** the scaffold has nothing to compile. Tooling should be introduced only with a concrete, documented need.
8. **Compatibility-first evolution:** templates follow WordPress's hierarchy and use inherited queries, URLs, taxonomy data, and search terms rather than replacing content structures. Homepage, archive, and search discovery use Core Query and pagination blocks and therefore require no PHP query, content IDs, or hard-coded category assumptions.
9. **Portable default, WordPress-managed navigation:** the approved theme pattern resolves existing pages by stable hierarchical paths and contains no imported Navigation post, menu, or page IDs. Once saved in the Site Editor, Core owns the environment-specific Navigation entity and its reference from the shared Header. Core also provides dropdown, keyboard, and mobile-overlay behavior without theme JavaScript.
10. **Section-based magazine homepage:** the homepage begins with an eight-post hero powered by three small, non-overlapping Core queries: headline list, lead feature, and visual support. Separating these roles from future category modules keeps each query and editorial purpose explicit. It does not copy a third-party theme's branding, proprietary components, subscription features, sliders, or popularity logic, and it does not introduce Tailwind or a build toolchain for one layout requirement.
11. **Explicit category modules:** the first category section uses the real `science` slug and resolves its local term ID at pattern-registration time. The stable slug and Core category archive URL preserve portability without hard-coding imported ID `3`, while two non-overlapping Core queries provide a lead/support hierarchy.
12. **Image-led Technology showcase:** the real `technology` slug supplies four overlay features and six compact stories through two non-overlapping Core queries. Core Post Template grid layouts handle responsive reflow from available width; custom CSS is limited to the image overlay and compact media-object presentation. The section uses its taxonomy name rather than making an unsupported Breaking-news claim.
13. **Editorial Biology section:** the real `biology` slug supplies two paired features and four smaller visual stories. Core Columns handle each feature's responsive image-and-text arrangement, while Core Post Template columns handle the outer layouts. Its deliberate first-post offset avoids repeating the Biology article already present in the hero, and its category heading remains database-driven.
14. **Unified editorial presentation:** the existing queries and content hierarchy remain unchanged while scoped `theme.json` CSS supplies the modern presentation layer. Each section retains a distinct reading cadence, but shared typography, spacing, restrained accents, focus treatment, responsive image behavior, and reduced-motion support make the homepage feel like one publication rather than unrelated modules.
15. **Core-powered category discovery:** the category directory uses Core's Categories block to expose the site's current non-empty taxonomy with generated archive URLs and counts. It introduces no menu ID, category ID, custom query, or PHP rendering logic, and its responsive grid is presentation-only.
16. **Article discovery without custom data logic:** wide single posts use the available column beside a semantic sidebar, while smaller screens retain the established `44rem` maximum measure and place discovery below the article. Core Search, Categories, Archives, and Latest Posts blocks provide meaningful onward routes without custom queries, IDs, JavaScript, advertising, or invented editorial copy.
17. **A designed not-found response:** `404.html` replaces the unstyled `index.html` fallback for missing URLs, which are an expected condition given the stored links to the site's earlier address. Its copy lives in a pattern because block templates cannot hold translatable strings.
18. **Reviewable CSS:** presentation that cannot be expressed through `theme.json` lives in `assets/css/` as ordinary files rather than a single-line `styles.css` string, so it can be diffed and reviewed. Global declarations and block-scoped `&` entries stay in `theme.json`, where their scoping is meaningful.
19. **Translation wired, not merely marked:** the theme registers its own text domain instead of relying on the just-in-time loading that only applies to themes distributed through WordPress.org, and keeps one source language rather than mixing Tamil and English sources.
20. **No English in a Tamil publication:** where a Core block emits an untranslated English string on a `ta-IN` installation, the theme supplies the phrasing Core's own Tamil translation already uses elsewhere for the same condition, rather than inventing a term. This currently applies to the search-results heading and the not-found heading. Prefer this over filtering Core's translations, which would be fragile and invisible to editors.
21. **A footer that closes the page rather than repeating it:** the footer is the logo and one editor-managed horizontal menu. A category list and a Science Series column were each built and then removed — the first restated the homepage directory and made the mobile footer 1340px tall, the second duplicated the header dropdown. Search, categories, archives, and recent posts stay in the article sidebar where they already live. The approved page paths moved to `inc/navigation.php` so the header and footer resolve the same destinations from one list rather than two copies that can drift.

## Future extension points

- If automatic child-page discovery is approved, add it to Science Series content with Core's Page List block or define a companion-plugin requirement; do not hard-code its imported page ID in the theme.
- Extend, remove, or reorder primary navigation links through the shared Header's Navigation block in the Site Editor; do not copy its environment-specific entity ID into theme source.
- Add an approved site icon if the identity requires one; the supplied header logo is already theme-owned.
- Add reusable editorial compositions to `patterns/`; use synced patterns or database content when editors must manage the copy.
- Add block variations only when a demonstrated editorial requirement needs them.
- Add style variations under `styles/` only if the design calls for intentional alternate visual systems.
- Add `functions.php` and `inc/` modules for narrowly scoped hooks, registrations, or compatibility behavior.
- Add CSS or dependency-free JavaScript assets only for gaps in native block capabilities, documenting each exception here.
- Add automated linting, visual regression checks, and accessibility checks when the development toolchain is selected.
- Generate `languages/parimaanam-2026.pot` once a WP-CLI-capable toolchain exists. The text domain is registered, but no catalogue is shipped, because a hand-maintained POT would drift without tooling to regenerate it.

## Awaiting editorial approval

The footer copyright sentence is no longer on this list: its wording was supplied by the publication and is therefore approved.

`patterns/error-404.php` introduces Tamil copy that was not derived from the existing site: a one-sentence explanation of the missing page, plus the hidden region headings added to `patterns/home-hero.php` for screen readers. A not-found page cannot exist without some text, and the hidden headings cannot name a region without one, so these were written to be plain and factual rather than left blank. They should still be reviewed by an editor before release.

The not-found heading itself deliberately reuses `பக்கம் காணப்படவில்லை`, the phrasing WordPress Core's Tamil translation already applies to the document title on this view. Matching it keeps the heading and the browser tab consistent and avoids inventing a second term for the same condition. The search-results heading in `patterns/search-title.php` follows the same rule and is likewise not invented copy. Every other public string in the theme continues to come from approved project inputs or from WordPress Core.

## Scope guard

This remains an evolving theme rather than a production-complete release. It now contains the polished visual foundation and approved primary navigation for the established publication templates, but no database-specific menu reference, custom editorial content, automatic child-page query logic, analytics, deployment integration, or content migration logic. Those concerns require approved information architecture, editorial decisions, or companion-plugin/infrastructure work and are intentionally outside this theme change.
