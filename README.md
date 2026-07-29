# Parimaanam 2026

Parimaanam 2026 is the custom native WordPress block theme for <https://parimaanam.net>. This repository contains the theme only. It does not include WordPress core, plugins, uploads, database content, or environment configuration.

The current state establishes the theme architecture, non-branded design-system foundation, and Tamil-first typography. Branding, colors, editorial structures, and marketing content remain deliberately undefined.

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
├── theme.json           Layout and spacing foundation for the design system
├── assets/
│   └── fonts/
│       └── google-sans/
│           ├── GoogleSans-Latin-Variable.woff2
│           ├── GoogleSans-Tamil-Variable.woff2
│           └── OFL.txt
└── templates/
    └── index.html       Required, unstyled template-hierarchy fallback
```

Directories are added only when they have real content. Expected extension points are `patterns/`, `assets/css/`, `assets/js/`, `assets/images/`, `assets/fonts/`, and `inc/`.

### Rendering model

WordPress resolves requests through its standard template hierarchy. At this stage every view falls back to `templates/index.html`. Its inherited Query Loop lets WordPress supply the current query, posts, URLs, and pagination without custom logic.

`index.html` is required for a valid block theme; it is not a homepage implementation. The theme intentionally has no `home.html` or `front-page.html`. The fallback uses native block markup, a `main` landmark, and an `article` for each result, but makes no layout or visual choices.

### Styling model

`theme.json` uses version 3 and pins its schema reference to the minimum supported WordPress release. The initial design-system layer defines a `44rem` reading measure, an `80rem` wide alignment, and a seven-step multiplicative spacing scale based on WordPress Core's default scale. The Core spacing presets are disabled so these theme-owned values remain authoritative even when their slugs overlap. Editors may use the generated spacing presets for block gaps, margins, and padding, but arbitrary spacing values are disabled to keep layouts consistent. `rem` and `%` are the only exposed spacing units because they cover scalable fixed spacing and container-relative spacing without encouraging viewport- or pixel-specific values.

The reading measure prioritizes long-form Tamil content while retaining room for mixed Tamil and Latin text. The wide measure provides a controlled area for media, galleries, and future article-adjacent content. Both values are global defaults rather than template-specific widths and should be reassessed alongside real typography before the single article template is finalized.

No palette, page padding, or per-block component styles are defined yet. Root-padding-aware alignments are also deferred until page padding and full-width behavior are designed together.

### Typography

The theme locally hosts Google Sans under the SIL Open Font License 1.1. Two optimized WOFF2 subsets cover Tamil and Latin while sharing one variable family and a weight range of 400 through 700. WordPress emits both `@font-face` declarations directly from `theme.json`; their `unicodeRange` descriptors let the browser fetch only the subset required by the text on a page. This avoids a Google Fonts runtime dependency and is substantially smaller than shipping the full multi-script TTF package. System UI and generic sans-serif fonts remain fallbacks for characters outside the bundled ranges.

The files are the unmodified variable subsets served by the official Google Fonts CSS API for Google Sans. The Tamil range is `U+0964-0965, U+0B82-0BFA, U+200C-200D, U+20B9, U+25CC`; the Latin range is the API's standard Latin subset. Their SIL Open Font License is stored beside them. One family keeps mixed-script scientific writing visually coherent, while the semantic `primary` preset decouples templates and styles from the font's product name.

The global reading size scales from `1.0625rem` to `1.125rem` with a `1.8` line height. Headings use the same family at weight 700, a `1.35` line height, and a five-step fluid scale. Core's default font-size presets are disabled so the theme can intentionally redefine the existing `small`, `medium`, `large`, `x-large`, and `xx-large` slugs. Imported content using those Core-compatible classes therefore continues to resolve predictably without inheriting Core's smaller defaults.

Arbitrary font sizes, synthetic font styles, letter spacing, line-height overrides, text transforms, vertical writing, and drop caps are unavailable in the editor. These controls are unnecessary for the current editorial model or are unsafe without Tamil-specific testing. Font weight remains available within the bundled family's supported 400–700 range.

Typography is registered and applied through `theme.json`, allowing WordPress to produce matching editor and front-end styles without a stylesheet or PHP enqueue logic. The font files and license are kept together in `assets/fonts/google-sans/`.

Future approved global tokens and block styles should go into `theme.json`. CSS in `assets/css/` is an exception for requirements the WordPress style system cannot express. This keeps Site Editor controls and front-end output aligned.

### Code model

There is no `functions.php` because the scaffold requires no PHP; WordPress recognizes the block theme from `style.css` and `templates/index.html`, while `theme.json` establishes the versioned configuration foundation. A minimal `functions.php` may be introduced only when a necessary hook or asset registration exists, with larger concerns split into `inc/`.

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
3. **No speculative template parts:** a header and footer are site-wide design and information-architecture decisions. They will be introduced when the single article template establishes their requirements.
4. **Dynamic core blocks:** query results, excerpts, and pagination come from WordPress data, avoiding hard-coded production assumptions.
5. **Constrained design-system foundation:** `theme.json` defines global layout widths, a predictable Core-compatible spacing scale, and Tamil-first typography. It does not choose colors, page padding, or component styles.
6. **No PHP by default:** no server-side customization is currently needed, so an empty compatibility layer would add maintenance without behavior.
7. **No build toolchain:** the scaffold has nothing to compile. Tooling should be introduced only with a concrete, documented need.
8. **Compatibility-first evolution:** future templates should follow WordPress's hierarchy and use existing queries, URLs, and taxonomy data rather than replacing content structures.

## Future extension points

- Complete the remaining design-system decisions, then build `single.html`, homepage, archives, search, Science Series, and polish in that order.
- Introduce header and footer template parts when their role in the single article experience is defined.
- Add reusable editorial compositions to `patterns/`; use synced patterns or database content when editors must manage the copy.
- Add an approved palette to `theme.json`; add block variations only when a demonstrated editorial requirement needs them.
- Add style variations under `styles/` only if the design calls for intentional alternate visual systems.
- Add `functions.php` and `inc/` modules for narrowly scoped hooks, registrations, or compatibility behavior.
- Add CSS or dependency-free JavaScript assets only for gaps in native block capabilities, documenting each exception here.
- Add automated linting, visual regression checks, and accessibility checks when the development toolchain is selected.

## Scope guard

This scaffold is not the final theme. It contains no finalized branding, homepage, single article design, specialized publication templates, custom editorial patterns, or production integration logic. The next phase completes the remaining design-system decisions before work begins on the single article template.
