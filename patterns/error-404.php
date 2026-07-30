<?php
/**
 * Title: Not found content
 * Slug: parimaanam-2026/error-404
 * Inserter: no
 */
?>

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--70);margin-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:heading {"level":1,"fontSize":"x-large"} -->
	<h1 class="wp-block-heading has-x-large-font-size"><?php echo esc_html_x( 'பக்கம் காணப்படவில்லை', 'Heading shown when a URL matches no content', 'parimaanam-2026' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"muted"} -->
	<p class="has-muted-color has-text-color"><?php echo esc_html_x( 'நீங்கள் தேடிய பக்கம் இங்கு இல்லை. கீழே தேடலாம், அல்லது அண்மைய கட்டுரைகளைப் பார்க்கலாம்.', 'Body text shown when a URL matches no content', 'parimaanam-2026' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:search {"label":"<?php echo esc_attr_x( 'தேடல்', 'Not found search label', 'parimaanam-2026' ); ?>","showLabel":false,"width":100,"widthUnit":"%","buttonText":"<?php echo esc_attr_x( 'தேடல்', 'Not found search button', 'parimaanam-2026' ); ?>","buttonUseIcon":true} /-->
</div>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--70)">
	<!-- wp:heading {"fontSize":"large"} -->
	<h2 class="wp-block-heading has-large-font-size"><?php echo esc_html_x( 'அண்மைய கட்டுரைகள்', 'Not found recent articles heading', 'parimaanam-2026' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","layout":{"type":"constrained"}} -->
	<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"22rem"}} -->
		<!-- wp:group {"tagName":"article","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
		<article class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"100%","sizeSlug":"medium_large"} /-->

			<!-- wp:post-date {"isLink":true,"fontSize":"small"} /-->

			<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /--></article>
		<!-- /wp:group -->
	<!-- /wp:post-template --></div>
	<!-- /wp:query -->
</section>
<!-- /wp:group -->
