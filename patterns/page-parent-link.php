<?php
/**
 * Title: Parent page link
 * Slug: parimaanam-2026/page-parent-link
 * Inserter: no
 */

/*
 * The Science Series stores six curated index pages as children of one parent
 * page. Without an upward link a reader inside a series can only return through
 * the primary menu. This resolves the parent from the current query rather than
 * a stored page ID, so it stays portable and applies to any hierarchical page.
 */
$parimaanam_current_page = get_queried_object();

if ( $parimaanam_current_page instanceof WP_Post && $parimaanam_current_page->post_parent ) :
	$parimaanam_parent_page = get_post( $parimaanam_current_page->post_parent );

	if ( $parimaanam_parent_page instanceof WP_Post && 'publish' === $parimaanam_parent_page->post_status ) :
		?>

<!-- wp:paragraph {"className":"page-parent-link","fontSize":"small"} -->
<p class="page-parent-link has-small-font-size"><a href="<?php echo esc_url( (string) get_permalink( $parimaanam_parent_page ) ); ?>"><?php echo esc_html( get_the_title( $parimaanam_parent_page ) ); ?></a></p>
<!-- /wp:paragraph -->

		<?php
	endif;
endif;
