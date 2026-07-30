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
