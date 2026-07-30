<?php
/**
 * Theme asset loading.
 *
 * @package Parimaanam_2026
 */

require_once get_theme_file_path( 'inc/navigation.php' );

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
 * Load the theme stylesheets on the front end and in the block editor.
 *
 * style.css carries the single-article layout; assets/css/ carries the
 * masthead and homepage rules that block supports and theme.json cannot
 * express. Keeping them as files rather than a theme.json css string makes
 * them reviewable in a diff and lets the browser cache them between views.
 */
function parimaanam_2026_enqueue_block_styles() {
	$parimaanam_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'parimaanam-2026-style',
		get_stylesheet_uri(),
		array(),
		$parimaanam_version
	);

	foreach ( array( 'header', 'homepage', 'footer' ) as $parimaanam_stylesheet ) {
		wp_enqueue_style(
			'parimaanam-2026-' . $parimaanam_stylesheet,
			get_theme_file_uri( "assets/css/{$parimaanam_stylesheet}.css" ),
			array( 'parimaanam-2026-style' ),
			$parimaanam_version
		);
	}
}
add_action( 'enqueue_block_assets', 'parimaanam_2026_enqueue_block_styles' );
