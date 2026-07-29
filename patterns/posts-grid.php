<?php
/**
 * Title: Posts grid
 * Slug: parimaanam-2026/posts-grid
 * Categories: query
 * Block Types: core/query
 * Inserter: no
 */
?>

<!-- wp:query {"query":{"inherit":true},"displayLayout":{"type":"flex","columns":2},"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|60"}}} -->
	<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<article class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"100%","sizeSlug":"medium_large"} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
		<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category"} /-->

			<!-- wp:post-date {"isLink":true} /--></div>
		<!-- /wp:group -->

		<!-- wp:post-title {"isLink":true,"fontSize":"large"} /-->

		<!-- wp:post-excerpt {"excerptLength":32} /--></article>
	<!-- /wp:group -->
<!-- /wp:post-template -->

	<!-- wp:query-pagination {"paginationArrow":"arrow","align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"fontSize":"small","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
		<!-- wp:query-pagination-previous /-->

		<!-- wp:query-pagination-numbers /-->

		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p><?php echo esc_html_x( 'No results were found.', 'Message shown when a query returns no content', 'parimaanam-2026' ); ?></p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
