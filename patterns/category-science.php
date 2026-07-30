<?php
/**
 * Title: Homepage Science category
 * Slug: parimaanam-2026/category-science
 * Categories: query
 * Inserter: no
 */

$parimaanam_science_term = get_category_by_slug( 'science' );

if ( $parimaanam_science_term instanceof WP_Term ) :
	$parimaanam_science_term_id = (int) $parimaanam_science_term->term_id;
	$parimaanam_science_url     = get_category_link( $parimaanam_science_term_id );

	if ( is_wp_error( $parimaanam_science_url ) ) {
		$parimaanam_science_url = '';
	}
	?>

<!-- wp:group {"align":"full","gradient":"graphite-descend","className":"home-category-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","right":"var:preset|spacing|40","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull home-category-section has-graphite-descend-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"align":"wide","className":"home-category-section__heading","fontSize":"x-large"} -->
	<h2 class="wp-block-heading alignwide home-category-section__heading has-x-large-font-size"><a href="<?php echo esc_url( $parimaanam_science_url ); ?>"><?php echo esc_html( $parimaanam_science_term->name ); ?></a></h2>
	<!-- /wp:heading -->

	<!-- wp:group {"align":"wide","className":"home-category-section__layout","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide home-category-section__layout"><!-- wp:query {"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo $parimaanam_science_term_id; ?>]}},"className":"home-category-section__lead","layout":{"type":"constrained"}} -->
		<div class="wp-block-query home-category-section__lead"><!-- wp:post-template -->
			<!-- wp:group {"tagName":"article","className":"home-category-section__lead-card","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
			<article class="wp-block-group home-category-section__lead-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","width":"100%","sizeSlug":"large"} /-->

				<!-- wp:group {"className":"home-category-section__lead-content","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group home-category-section__lead-content"><!-- wp:post-date {"isLink":true,"fontSize":"small"} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"large"} /-->

				<!-- wp:post-excerpt {"excerptLength":30} /--></div>
				<!-- /wp:group --></article>
			<!-- /wp:group -->
		<!-- /wp:post-template --></div>
		<!-- /wp:query -->

		<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo $parimaanam_science_term_id; ?>]}},"className":"home-category-section__support","layout":{"type":"constrained"}} -->
		<div class="wp-block-query home-category-section__support"><!-- wp:post-template -->
			<!-- wp:group {"tagName":"article","className":"home-category-section__support-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
			<article class="wp-block-group home-category-section__support-card"><!-- wp:post-date {"isLink":true,"fontSize":"small"} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /--></article>
			<!-- /wp:group -->
		<!-- /wp:post-template --></div>
		<!-- /wp:query --></div>
	<!-- /wp:group --></div>
<!-- /wp:group -->

<?php endif; ?>
