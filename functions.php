<?php
/**
 * Theme asset loading.
 *
 * @package Parimaanam_2026
 */

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
