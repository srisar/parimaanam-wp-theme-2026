<?php
/**
 * Title: Homepage Biology editorial section
 * Slug: parimaanam-2026/category-biology
 * Categories: query
 * Inserter: no
 */

$parimaanam_biology_term = get_category_by_slug( 'biology' );

if ( $parimaanam_biology_term instanceof WP_Term ) :
	$parimaanam_biology_term_id = (int) $parimaanam_biology_term->term_id;
	$parimaanam_biology_url     = get_category_link( $parimaanam_biology_term_id );

	if ( is_wp_error( $parimaanam_biology_url ) ) {
		$parimaanam_biology_url = '';
	}
	?>

<!-- wp:group {"align":"wide","className":"home-category-editorial","style":{"spacing":{"margin":{"top":"var:preset|spacing|80"},"padding":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide home-category-editorial" style="margin-top:var(--wp--preset--spacing--80);padding-top:var(--wp--preset--spacing--60)"><!-- wp:heading {"textAlign":"center","align":"wide","className":"home-category-editorial__heading","fontSize":"x-large"} -->
	<h2 class="wp-block-heading alignwide has-text-align-center home-category-editorial__heading has-x-large-font-size"><span aria-hidden="true"><?php echo esc_html( $parimaanam_biology_term->name ); ?></span><a href="<?php echo esc_url( $parimaanam_biology_url ); ?>"><?php echo esc_html( $parimaanam_biology_term->name ); ?></a></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":2,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo $parimaanam_biology_term_id; ?>]}},"displayLayout":{"type":"flex","columns":2},"align":"wide","className":"home-category-editorial__features","layout":{"type":"constrained"}} -->
	<div class="wp-block-query alignwide home-category-editorial__features"><!-- wp:post-template {"align":"wide"} -->
		<!-- wp:group {"tagName":"article","className":"home-category-editorial__feature-card","layout":{"type":"constrained"}} -->
		<article class="wp-block-group home-category-editorial__feature-card"><!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
		<div class="wp-block-columns"><!-- wp:column -->
		<div class="wp-block-column"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","width":"100%","sizeSlug":"medium_large"} /--></div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group"><!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

		<!-- wp:post-date {"isLink":true,"textColor":"muted","fontSize":"small"} /--></div>
		<!-- /wp:group --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns --></article>
		<!-- /wp:group -->
	<!-- /wp:post-template --></div>
	<!-- /wp:query -->

	<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":3,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo $parimaanam_biology_term_id; ?>]}},"displayLayout":{"type":"flex","columns":4},"align":"wide","className":"home-category-editorial__cards","layout":{"type":"constrained"}} -->
	<div class="wp-block-query alignwide home-category-editorial__cards"><!-- wp:post-template {"align":"wide"} -->
		<!-- wp:group {"tagName":"article","className":"home-category-editorial__card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
		<article class="wp-block-group home-category-editorial__card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","width":"100%","sizeSlug":"medium_large"} /-->

		<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

		<!-- wp:post-date {"isLink":true,"textColor":"muted","fontSize":"small"} /--></article>
		<!-- /wp:group -->
	<!-- /wp:post-template --></div>
	<!-- /wp:query --></div>
<!-- /wp:group -->

<?php endif; ?>
