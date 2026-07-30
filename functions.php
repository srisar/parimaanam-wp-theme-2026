<?php
/**
 * Theme asset loading.
 *
 * @package Parimaanam_2026
 */

require_once get_theme_file_path( 'inc/navigation.php' );
require_once get_theme_file_path( 'inc/hero.php' );

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
 * Restore the reader's theme choice before the first paint.
 *
 * This is inline and unminified on purpose. An external file is fetched after
 * the document begins rendering, so a reader who chose the light theme would
 * watch the dark one flash first. It does one thing and is small enough to
 * cost less than the request it avoids.
 *
 * Only an explicit choice is written. A reader who has never touched the
 * toggle gets no attribute at all, which leaves the CSS free to follow their
 * operating system — and to keep following it if they change it while the
 * page is open.
 *
 * Storage access is wrapped because Safari's private mode throws on it, and a
 * theme preference is not worth a broken page.
 *
 * @return void
 */
function parimaanam_2026_theme_boot() {
	?>
<script>
(function(){try{var t=localStorage.getItem('parimaanam-theme');if(t==='light'||t==='dark'){document.documentElement.setAttribute('data-theme',t);}}catch(e){}document.documentElement.className+=' has-theme-toggle';})();
</script>
	<?php
}
add_action( 'wp_head', 'parimaanam_2026_theme_boot', 1 );

/**
 * Show nine posts per page on archive and search listings.
 *
 * The listing grid packs three columns in the wide container, and the site
 * default of ten leaves a single card alone on the last row of every page.
 * Nine is the nearest multiple of three, so each page fills its rows exactly.
 *
 * This lives in the theme rather than in Settings → Reading because the count
 * is a property of the layout, not of the site: change the grid to two or four
 * columns and this number is wrong. Keeping them together means the archive
 * cannot be left mismatched by an install that never visited the setting.
 *
 * The homepage is unaffected. Its sections run their own queries with explicit
 * per-page counts and `inherit` false, so they never consult this value.
 *
 * @param WP_Query $query The query about to run.
 * @return void
 */
function parimaanam_2026_listing_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_archive() || $query->is_search() || $query->is_home() ) {
		$query->set( 'posts_per_page', 9 );
	}
}
add_action( 'pre_get_posts', 'parimaanam_2026_listing_posts_per_page' );

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

	foreach ( array( 'color-scheme', 'header', 'homepage', 'footer', 'search-overlay' ) as $parimaanam_stylesheet ) {
		wp_enqueue_style(
			'parimaanam-2026-' . $parimaanam_stylesheet,
			get_theme_file_uri( "assets/css/{$parimaanam_stylesheet}.css" ),
			array( 'parimaanam-2026-style' ),
			$parimaanam_version
		);
	}
}
add_action( 'enqueue_block_assets', 'parimaanam_2026_enqueue_block_styles' );

/**
 * Load the two scripts the theme ships.
 *
 * Both are progressive enhancements, and both are deferred because neither is
 * needed before the page renders.
 *
 * Core's Search block can expand its field in place but cannot present a
 * full-focus overlay, so that interaction is not available from a block. Its
 * markup works without the script — the trigger is a real link to the search
 * results page.
 *
 * The theme toggle only records an explicit choice; the operating-system
 * default is expressed in CSS and needs nothing here. Restoring a stored
 * choice happens in an inline head script instead, because a deferred file
 * would run after the first paint and the reader would see the wrong theme
 * flash.
 *
 * Both are left out of the editor, where neither has anything to act on.
 */
function parimaanam_2026_enqueue_scripts() {
	$parimaanam_version = wp_get_theme()->get( 'Version' );

	foreach ( array( 'search-overlay', 'theme-toggle' ) as $parimaanam_script ) {
		wp_enqueue_script(
			'parimaanam-2026-' . $parimaanam_script,
			get_theme_file_uri( "assets/js/{$parimaanam_script}.js" ),
			array(),
			$parimaanam_version,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'parimaanam_2026_enqueue_scripts' );
