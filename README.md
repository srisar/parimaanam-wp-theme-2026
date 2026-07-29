# Parimaanam 2026

Parimaanam 2026 is the custom native WordPress block theme for <https://parimaanam.net>. This repository contains the theme only. It does not include WordPress core, plugins, uploads, database content, or environment configuration.

The current state establishes the theme architecture, non-branded design-system foundation, Tamil-first typography, and the native single-article reading experience. Branding, colors, the homepage, and later publication templates remain deliberately undefined.

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
│   └── header.html      Minimal site identity for article navigation
└── templates/
    ├── index.html       Required, unstyled template-hierarchy fallback
    └── single.html      Semantic reading experience for individual posts
```

Directories are added only when they have real content. Expected extension points are `patterns/`, `assets/css/`, `assets/js/`, `assets/images/`, `assets/fonts/`, and `inc/`.

### Rendering model

WordPress resolves requests through its standard template hierarchy. Individual posts use `templates/single.html`; views without a more specific template continue to fall back to `templates/index.html`. The fallback's inherited Query Loop lets WordPress supply the current query, posts, URLs, and pagination without custom logic.

`index.html` is required for a valid block theme; it is not a homepage implementation. The theme intentionally has no `home.html` or `front-page.html`. The fallback uses native block markup, a `main` landmark, and an `article` for each result, but makes no layout or visual choices.

`single.html` is the first purpose-built front-end template. It follows WordPress's standard single-post hierarchy and is composed entirely of Core blocks. A linked Site Title provides a minimal route back to the site without assuming an approved logo, menu, or navigation structure. The article uses semantic `main`, `article`, and nested `header` elements; its category, title, author, publication date, content, tags, adjacent-post navigation, threaded comments, comment pagination, and comment form all come from the current WordPress query.

Single-post titles use the existing `x-large` token instead of the global display-scale H1 token. Representative imported Tamil titles can exceed 60 characters; the smaller fluid range preserves their H1 hierarchy without allowing a headline to consume most of a narrow viewport.

The imported archive commonly uses the featured image again inside the post content. The template therefore does not render the Post Featured Image block: doing so would duplicate the lead image on existing articles. It also omits the Post Excerpt because imported posts commonly begin their content with the same paragraph used as the excerpt. Both decisions preserve existing content without custom PHP detection. A future editorial migration may revisit them after content conventions are normalized.

The reusable `parts/header.html` contains only the dynamic Site Title. It intentionally has no logo, menu, search control, or invented labels. Its header area is registered in `theme.json` so WordPress exposes it correctly in the Site Editor. A site footer remains deferred until its information architecture and content are approved.

### Styling model

`theme.json` uses version 3 and pins its schema reference to the minimum supported WordPress release. The initial design-system layer defines a `44rem` reading measure, an `80rem` wide alignment, and a seven-step multiplicative spacing scale based on WordPress Core's default scale. The Core spacing presets are disabled so these theme-owned values remain authoritative even when their slugs overlap. Editors may use the generated spacing presets for block gaps, margins, and padding, but arbitrary spacing values are disabled to keep layouts consistent. `rem` and `%` are the only exposed spacing units because they cover scalable fixed spacing and container-relative spacing without encouraging viewport- or pixel-specific values.

The reading measure prioritizes long-form Tamil content while retaining room for mixed Tamil and Latin text. The wide measure provides a controlled area for media, galleries, and future article-adjacent content. Both values are global defaults rather than template-specific widths and were verified against representative imported articles while building the single template.

No palette or global page padding is defined yet. The single template applies its own one-step horizontal gutter so the fallback and future templates remain visually unopinionated. Root-padding-aware alignments remain deferred until page padding and full-width behavior are designed across the whole site. The only block-level custom CSS handles demonstrated legacy Post Content compatibility issues described below.

### Typography

The theme locally hosts Google Sans under the SIL Open Font License 1.1. Two optimized WOFF2 subsets cover Tamil and Latin while sharing one variable family and a weight range of 400 through 700. WordPress emits both `@font-face` declarations directly from `theme.json`; their `unicodeRange` descriptors let the browser fetch only the subset required by the text on a page. This avoids a Google Fonts runtime dependency and is substantially smaller than shipping the full multi-script TTF package. System UI and generic sans-serif fonts remain fallbacks for characters outside the bundled ranges.

The files are the unmodified variable subsets served by the official Google Fonts CSS API for Google Sans. The Tamil range is `U+0964-0965, U+0B82-0BFA, U+200C-200D, U+20B9, U+25CC`; the Latin range is the API's standard Latin subset. Their SIL Open Font License is stored beside them. One family keeps mixed-script scientific writing visually coherent, while the semantic `primary` preset decouples templates and styles from the font's product name.

The global reading size scales from `1.0625rem` to `1.125rem` with a `1.8` line height. Headings use the same family at weight 700, a `1.35` line height, and a five-step fluid scale. Core's default font-size presets are disabled so the theme can intentionally redefine the existing `small`, `medium`, `large`, `x-large`, and `xx-large` slugs. Imported content using those Core-compatible classes therefore continues to resolve predictably without inheriting Core's smaller defaults.

Figure captions use the small preset with a `1.5` line height. This is the only article-specific global typography addition: it improves the dense scientific image credits and descriptions present in imported posts while remaining available to future templates through Core's caption element.

The imported archive also contains a small number of legacy tables and unclassed preformatted blocks, older responsive embeds whose rendered iframes retain fixed HTML dimensions, and fixed-width classic caption wrappers. Narrowly scoped custom-CSS declarations live under the Core Post Content block in `theme.json`: tables and preformatted lines scroll within the reading column, embed iframes scale to their container while preserving their intrinsic aspect ratio, and legacy captions cannot exceed the reading column. Scoping them to Post Content is necessary because this markup predates the wrappers expected by current Core blocks. These compatibility rules prevent horizontal page overflow without rewriting stored post content or adding a stylesheet, PHP asset loader, or JavaScript.

The template does not rewrite stored heading levels. A content audit found eight legacy posts containing an H1 inside the article body; those headings should be reviewed and normalized editorially rather than silently changed during rendering.

Arbitrary font sizes, synthetic font styles, letter spacing, line-height overrides, text transforms, vertical writing, and drop caps are unavailable in the editor. These controls are unnecessary for the current editorial model or are unsafe without Tamil-specific testing. Font weight remains available within the bundled family's supported 400–700 range.

Typography is registered and applied through `theme.json`, allowing WordPress to produce matching editor and front-end styles without a stylesheet or PHP enqueue logic. The font files and license are kept together in `assets/fonts/google-sans/`.

Future approved global tokens and block styles should go into `theme.json`. CSS in `assets/css/` is an exception for requirements the WordPress style system cannot express. This keeps Site Editor controls and front-end output aligned.

### Code model

There is no `functions.php` because the current architecture requires no PHP; WordPress recognizes the block theme from `style.css` and `templates/index.html`, while `theme.json` establishes the versioned configuration foundation. A minimal `functions.php` may be introduced only when a necessary hook or asset registration exists, with larger concerns split into `inc/`.

`style.css` exists because WordPress reads its header to register the theme. It contains metadata only and is not the starting point for the visual system.

There is no JavaScript or build pipeline. Progressive enhancement can be added under `assets/js/` only for a confirmed interaction that core blocks cannot provide. Tailwind, Bootstrap, jQuery-by-default, front-end frameworks, and page builders are excluded.

## Local development

1. Install a local WordPress 6.6+ environment using the team's preferred tool.
2. Place or clone this repository at `wp-content/themes/parimaanam_2026`.
3. Activate **Parimaanam 2026** in **Appearance → Themes**.
4. Open **Appearance → Editor** to inspect block templates and global settings.
5. Set permalinks to match production and test existing URLs against representative production content.
6. After changes, verify the public site and Site Editor, including Tamil and mixed-script content, keyboard navigation, narrow/wide layouts, archives, pagination, and long titles.

Because there is currently no compilation step, changes to HTML templates and `theme.json` are loaded directly by WordPress. Note that Site Editor customizations stored in the database can override theme files; use a clean test database when verifying file changes.

## Architectural decisions

1. **Native block theme:** maximizes compatibility with current WordPress editing and template APIs and avoids a parallel rendering system.
2. **Required fallback only:** `index.html` exists to satisfy the block-theme contract and WordPress template hierarchy. It is deliberately not a homepage design.
3. **Minimal shared header:** the single article establishes a need for linked site identity, so the header part contains only the dynamic Site Title. Navigation, logo treatment, search, and the footer remain deferred until their requirements are approved.
4. **Dynamic core blocks:** article metadata, content, taxonomies, adjacent posts, comments, query results, excerpts, and pagination come from WordPress data, avoiding hard-coded production assumptions.
5. **Constrained design-system foundation:** `theme.json` defines global layout widths, a predictable Core-compatible spacing scale, Tamil-first typography, the header template-part area, and readable captions. It does not choose colors or component branding.
6. **No PHP by default:** no server-side customization is currently needed, so an empty compatibility layer would add maintenance without behavior.
7. **No build toolchain:** the scaffold has nothing to compile. Tooling should be introduced only with a concrete, documented need.
8. **Compatibility-first evolution:** future templates should follow WordPress's hierarchy and use existing queries, URLs, and taxonomy data rather than replacing content structures.

## Future extension points

- Use the established single-article hierarchy to inform the homepage, then build archives, search, Science Series, and polish in that order.
- Expand the minimal header and introduce a footer only when their navigation and information-architecture requirements are approved.
- Add reusable editorial compositions to `patterns/`; use synced patterns or database content when editors must manage the copy.
- Add an approved palette to `theme.json`; add block variations only when a demonstrated editorial requirement needs them.
- Add style variations under `styles/` only if the design calls for intentional alternate visual systems.
- Add `functions.php` and `inc/` modules for narrowly scoped hooks, registrations, or compatibility behavior.
- Add CSS or dependency-free JavaScript assets only for gaps in native block capabilities, documenting each exception here.
- Add automated linting, visual regression checks, and accessibility checks when the development toolchain is selected.

## Scope guard

This is not the final theme. It contains no finalized branding, homepage, archive or search design, specialized publication templates, custom editorial patterns, or production integration logic. The current phase establishes the native single-article reading structure; visual branding and later templates remain deliberately out of scope.
