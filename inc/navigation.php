<?php
/**
 * Shared resolution of approved page paths to URLs.
 *
 * The header and the footer both link to the same approved pages. Keeping one
 * path list here prevents the two from drifting apart.
 *
 * @package Parimaanam_2026
 */

/**
 * The approved hierarchical page paths used by site navigation.
 *
 * @return array<string, string> Stable key => page path.
 */
function parimaanam_2026_navigation_paths() {
	return array(
		'science-series'                 => 'science-series',
		'black-holes-series'             => 'science-series/black-holes-series',
		'artificial-intelligence-series' => 'science-series/artificial-intelligence-series',
		'extraterrestrial-civilizations' => 'science-series/extraterrestrial-civilizations',
		'large-hardon-collider'          => 'science-series/large-hardon-collider',
		'hubble-space-telescope'         => 'science-series/hubble-space-telescope',
		'electromagnetic-waves'          => 'science-series/electromagnetic-waves',
		'downloads'                      => 'downloads',
		'free-ebooks'                    => 'downloads/free-ebooks',
		'contacts'                       => 'contacts',
		'about'                          => 'about',
	);
}

/**
 * Resolve an approved page key to a URL.
 *
 * Falls back to an installation-relative URL when the page is absent, so the
 * theme stays portable across environments and installation paths.
 *
 * @param string $key Key from parimaanam_2026_navigation_paths().
 * @return string Resolved URL, or an empty string for an unknown key.
 */
function parimaanam_2026_navigation_url( $key ) {
	$parimaanam_paths = parimaanam_2026_navigation_paths();

	if ( ! isset( $parimaanam_paths[ $key ] ) ) {
		return '';
	}

	$parimaanam_page = get_page_by_path( $parimaanam_paths[ $key ] );

	if ( $parimaanam_page instanceof WP_Post ) {
		return (string) get_permalink( $parimaanam_page );
	}

	return home_url( trailingslashit( $parimaanam_paths[ $key ] ) );
}
