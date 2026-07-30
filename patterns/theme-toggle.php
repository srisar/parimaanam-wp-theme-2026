<?php
/**
 * Title: Theme toggle
 * Slug: parimaanam-2026/theme-toggle
 * Inserter: no
 */

/*
 * The control is hidden until the inline head script marks the document
 * script-capable, so a reader without JavaScript is never shown a switch that
 * cannot do anything. They still get their operating system's preference,
 * because that half is expressed in CSS and needs no script at all.
 *
 * The labels are English by editorial decision. Core translates "Dark" as
 * அடர்ந்த, meaning dense, and "Light" as ஒளி, meaning illumination — both the
 * wrong sense for a theme switch — so unlike the navigation and 404 strings
 * these could not reuse Core's Tamil. English is the source language, so they
 * render correctly untranslated, and the _x() wrapper leaves the door open.
 *
 * Both labels are carried as data attributes because the script swaps between
 * them, and a string built in JavaScript could not be translated at all.
 */
$parimaanam_to_light = esc_attr_x( 'Switch to light theme', 'Theme toggle button label', 'parimaanam-2026' );
$parimaanam_to_dark  = esc_attr_x( 'Switch to dark theme', 'Theme toggle button label', 'parimaanam-2026' );
?>

<!-- wp:html -->
<button class="theme-toggle" type="button"
	data-label-light="<?php echo $parimaanam_to_light; ?>"
	data-label-dark="<?php echo $parimaanam_to_dark; ?>"
	aria-label="<?php echo $parimaanam_to_light; ?>">
	<span class="theme-toggle__icon" aria-hidden="true"></span>
</button>
<!-- /wp:html -->
