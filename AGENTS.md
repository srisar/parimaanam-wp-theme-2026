# Parimaanam 2026: agent guidelines

## Project boundary

This repository contains only the custom `parimaanam_2026` WordPress theme. Do not add or modify WordPress core, plugins, uploads, database content, server configuration, or deployment infrastructure here.

The production site is <https://parimaanam.net>. Preserve compatibility with its existing content, permalinks, archives, taxonomies, and standard WordPress behavior. Never hard-code production URLs or content IDs.

## Architecture rules

- Build a native WordPress block theme using HTML block templates, template parts, patterns, and `theme.json` version 3.
- Prefer WordPress core blocks and APIs. Add custom blocks only when a documented content or editorial requirement cannot be met with core blocks.
- Keep PHP limited to necessary hooks, filters, registrations, and compatibility code. Do not render template layouts in PHP.
- Use semantic elements through block attributes (`header`, `nav`, `main`, `article`, `aside`, and `footer`) where their meaning is correct.
- Keep JavaScript optional, small, dependency-free, and progressively enhanced. Do not use jQuery unless a documented WordPress dependency makes it unavoidable.
- Do not use Tailwind, Bootstrap, page builders, or a front-end framework.
- Put global tokens and styles in `theme.json`. Add CSS only where block supports and `theme.json` cannot express the requirement.
- Do not invent branding, colors, typefaces, editorial copy, categories, navigation labels, or marketing content. Obtain or derive these from approved project inputs.
- Make all public text translatable under the `parimaanam-2026` text domain. Account for Tamil text, long titles, and mixed Tamil/Latin content in later design and testing.
- Follow WordPress coding standards and escape, sanitize, and validate data at the appropriate boundary.
- Preserve accessibility: logical headings, keyboard operation, visible focus, sufficient contrast, meaningful landmarks, and reduced-motion preferences.
- Preserve responsive behavior without assuming a particular device or viewport.

## Repository organization

- `templates/`: site-level block templates and the WordPress template hierarchy.
- `parts/`: reusable block template parts.
- `patterns/`: registered block-pattern PHP files when approved patterns are introduced.
- `assets/css/`: narrowly scoped CSS that cannot live in `theme.json`.
- `assets/js/`: small progressive enhancements, only when required.
- `assets/images/`: theme-owned presentation assets, not editorial uploads.
- `assets/fonts/`: approved, locally hosted font files and their licenses.
- `inc/`: modular PHP loaded from `functions.php`, only when PHP becomes necessary.

Do not create empty implementation files merely to populate these directories. Add a directory when its first real asset is introduced.

## Implementation order

Build in this order unless the user explicitly changes the sequence:

1. Theme architecture.
2. Design system in `theme.json`.
3. Typography.
4. Single article template.
5. Homepage.
6. Archives.
7. Search.
8. Science Series.
9. Polish.

Treat the single article template as the primary publication experience. Do not create `home.html` or `front-page.html`, or otherwise design the homepage, before the single article template is established. The required `templates/index.html` is only the WordPress template-hierarchy fallback and must remain visually unopinionated.

## Change workflow

1. Inspect existing files and working-tree changes before editing; preserve unrelated user work.
2. Implement the smallest native solution that satisfies the stated requirement.
3. Document architectural decisions in `README.md`, including why custom PHP, CSS, JavaScript, or a custom block is necessary.
4. Validate JSON and PHP syntax as applicable.
5. Test in a supported WordPress installation with representative existing Parimaanam content.
6. Check front-end and Site Editor behavior at narrow and wide viewports, with keyboard navigation and Tamil content.

Do not proceed from scaffolding into visual design or production feature work without explicit instruction.

## Design philosophy

Parimaanam is a publication, not a marketing website.

Every technical and design decision should prioritize:

1. Reading comfort.
2. Long-term maintainability.
3. Performance.
4. Discoverability of older articles.
5. Native WordPress capabilities before custom code.

When trade-offs exist, prefer simplicity over novelty.

## Performance goals

The theme should remain lightweight.

Prefer:

- minimal CSS
- minimal JavaScript
- native browser capabilities
- local assets
- responsive images

Avoid:

- animation libraries
- icon libraries
- unnecessary fonts
- render-blocking resources

Do not introduce caching,
build pipelines,
code splitting,
or optimization tooling
until there is demonstrated need.


## Git

Prefer small commits.

Each commit should represent one logical change.

Avoid mixing architecture,
styling,
bug fixes,
and new features
in a single commit.

If functionality belongs in a plugin rather than the theme,
recommend creating a companion plugin instead of placing business logic in the theme.


When multiple valid WordPress implementations exist,
prefer the one that follows current WordPress Core recommendations.