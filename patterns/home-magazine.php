<?php
/**
 * Title: Homepage magazine
 * Slug: parimaanam-2026/home-magazine
 * Categories: query
 * Block Types: core/query
 * Inserter: no
 */
?>

<!-- wp:query {"query":{"inherit":true},"align":"wide","className":"home-magazine","layout":{"type":"constrained"}} -->
<div class="wp-block-query alignwide home-magazine"><!-- wp:post-template {"align":"wide"} -->
	<!-- wp:group {"tagName":"article","style":{"border":{"bottom":{"color":"var:preset|color|line","style":"solid","width":"1px"}},"spacing":{"blockGap":"var:preset|spacing|40","padding":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
	<article class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--line);border-bottom-style:solid;border-bottom-width:1px;padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/10","width":"100%","sizeSlug":"large"} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
		<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category"} /-->

			<!-- wp:post-date {"isLink":true} /--></div>
		<!-- /wp:group -->

		<!-- wp:post-title {"isLink":true,"fontSize":"large"} /-->

		<!-- wp:post-excerpt {"excerptLength":36} /--></article>
	<!-- /wp:group -->
<!-- /wp:post-template -->

	<!-- wp:query-pagination {"paginationArrow":"arrow","align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"fontSize":"small","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
		<!-- wp:query-pagination-previous /-->

		<!-- wp:query-pagination-numbers /-->

		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p><?php echo esc_html_x( 'No results were found.', 'Message shown when the homepage query returns no content', 'parimaanam-2026' ); ?></p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
