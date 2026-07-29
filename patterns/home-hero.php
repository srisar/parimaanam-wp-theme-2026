<?php
/**
 * Title: Homepage latest-posts hero
 * Slug: parimaanam-2026/home-hero
 * Categories: query
 * Inserter: no
 */
?>

<!-- wp:group {"align":"wide","className":"home-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide home-hero"><!-- wp:group {"align":"wide","className":"home-hero__layout","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide home-hero__layout"><!-- wp:group {"className":"home-hero__latest","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group home-hero__latest"><!-- wp:heading {"className":"home-hero__eyebrow","fontSize":"large"} -->
			<h2 class="wp-block-heading home-hero__eyebrow has-large-font-size"><?php echo esc_html_x( 'புதிய கட்டுரைகள்', 'Homepage heading for latest stories', 'parimaanam-2026' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:query {"query":{"perPage":5,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"layout":{"type":"constrained"}} -->
			<div class="wp-block-query"><!-- wp:post-template -->
				<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
				<article class="wp-block-group"><!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
					<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category"} /-->

						<!-- wp:post-date {"isLink":true} /--></div>
					<!-- /wp:group --></article>
				<!-- /wp:group -->
			<!-- /wp:post-template --></div>
			<!-- /wp:query --></div>
		<!-- /wp:group -->

		<!-- wp:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"home-hero__lead","layout":{"type":"constrained"}} -->
		<div class="wp-block-query home-hero__lead"><!-- wp:post-template -->
			<!-- wp:group {"tagName":"article","backgroundColor":"surface","layout":{"type":"constrained"}} -->
			<article class="wp-block-group has-surface-background-color has-background"><!-- wp:post-featured-image {"isLink":true,"width":"100%","sizeSlug":"large"} /-->

				<!-- wp:group {"className":"home-hero__lead-content","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group home-hero__lead-content"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
					<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category"} /-->

						<!-- wp:post-date {"isLink":true} /--></div>
					<!-- /wp:group -->

					<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"x-large"} /-->

					<!-- wp:post-excerpt {"excerptLength":26} /--></div>
				<!-- /wp:group --></article>
			<!-- /wp:group -->
		<!-- /wp:post-template --></div>
		<!-- /wp:query -->

		<!-- wp:query {"query":{"perPage":2,"pages":0,"offset":6,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"home-hero__support","layout":{"type":"constrained"}} -->
		<div class="wp-block-query home-hero__support"><!-- wp:post-template -->
			<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
			<article class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","width":"100%","sizeSlug":"medium_large"} /-->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
				<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category"} /-->

					<!-- wp:post-date {"isLink":true} /--></div>
				<!-- /wp:group -->

				<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"medium"} /--></article>
			<!-- /wp:group -->
		<!-- /wp:post-template --></div>
		<!-- /wp:query --></div>
	<!-- /wp:group --></div>
<!-- /wp:group -->
