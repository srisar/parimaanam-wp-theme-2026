<?php
/**
 * Theme asset loading.
 *
 * @package Parimaanam_2026
 */

/**
 * Register the theme text domain so pattern strings can be translated.
 *
 * Block themes inherit most theme supports from WordPress, but a theme that
 * ships its own translations must still load them explicitly.
 */
function parimaanam_2026_setup() {
	load_theme_textdomain( 'parimaanam-2026', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'parimaanam_2026_setup' );

/**
 * Preload the Tamil font subset.
 *
 * WordPress emits the @font-face rules from theme.json but does not preload
 * them, so the browser only discovers the file after parsing the stylesheet.
 * Tamil carries the headline text on every view, making it the subset worth
 * the extra connection; Latin stays lazily fetched. The crossorigin attribute
 * is required even same-origin because fonts are fetched in CORS mode.
 *
 * @param array $preload_resources Resources to preload.
 * @return array Filtered resources.
 */
function parimaanam_2026_preload_fonts( $preload_resources ) {
	$preload_resources[] = array(
		'href'        => get_theme_file_uri( 'assets/fonts/google-sans/GoogleSans-Tamil-Variable.woff2' ),
		'as'          => 'font',
		'type'        => 'font/woff2',
		'crossorigin' => 'anonymous',
	);

	return $preload_resources;
}
add_filter( 'wp_preload_resources', 'parimaanam_2026_preload_fonts' );

/**
 * Load the theme stylesheet on the front end and in the block editor.
 */
function parimaanam_2026_enqueue_block_styles() {
	wp_enqueue_style(
		'parimaanam-2026-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'enqueue_block_assets', 'parimaanam_2026_enqueue_block_styles' );
