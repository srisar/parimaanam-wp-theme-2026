<?php
/**
 * Title: Posts grid
 * Slug: parimaanam-2026/posts-grid
 * Categories: query
 * Block Types: core/query
 * Inserter: no
 */
?>

<!-- wp:query {"query":{"inherit":true},"align":"wide","className":"posts-grid","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide posts-grid"><!-- wp:post-template {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"20rem"}} -->
	<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<article class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"100%","sizeSlug":"medium_large"} /-->

		<!-- wp:group {"className":"posts-grid__meta","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
		<div class="wp-block-group posts-grid__meta has-small-font-size"><!-- wp:post-terms {"term":"category","className":"parimaanam-chip parimaanam-chip--accent"} /-->

			<!-- wp:post-date {"isLink":true,"className":"parimaanam-chip parimaanam-chip--outline"} /--></div>
		<!-- /wp:group -->

		<!-- wp:post-title {"isLink":true,"fontSize":"large"} /-->

		<!-- wp:post-excerpt {"excerptLength":32} /--></article>
	<!-- /wp:group -->
<!-- /wp:post-template -->

	<!--
		Layout is `default` with a zero block gap because style.css lays this out
		as a grid. Core's flex layout would justify the children with
		space-between, which throws the numbers to the far left on page one where
		there is no previous link; and its flow layout would add a block-gap
		margin the grid does not want. Declaring both here means Core emits
		neither, rather than the theme out-specifying it later.
	-->
	<!-- wp:query-pagination {"paginationArrow":"arrow","align":"wide","className":"posts-pagination","style":{"spacing":{"blockGap":"0","margin":{"top":"var:preset|spacing|70"}}},"fontSize":"small","layout":{"type":"default"}} -->
		<!-- wp:query-pagination-previous /-->

		<!-- wp:query-pagination-numbers /-->

		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p><?php echo esc_html_x( 'முடிவுகள் எதுவும் கிடைக்கவில்லை.', 'Message shown when a query returns no content', 'parimaanam-2026' ); ?></p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
