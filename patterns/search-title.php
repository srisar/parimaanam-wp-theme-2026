<?php
/**
 * Title: Search results title
 * Slug: parimaanam-2026/search-title
 * Inserter: no
 */

// Unescaped, because the value is escaped for HTML output below.
$parimaanam_search_query = get_search_query( false );
?>

<!-- wp:heading {"level":1,"fontSize":"x-large"} -->
<h1 class="wp-block-heading has-x-large-font-size"><?php
	printf(
		/* translators: %s: the submitted search term. */
		esc_html_x( '“%s” க்கான தேடல் முடிவுகள்', 'Search results page heading', 'parimaanam-2026' ),
		esc_html( $parimaanam_search_query )
	);
?></h1>
<!-- /wp:heading -->
