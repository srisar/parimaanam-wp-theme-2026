<?php
/**
 * Title: Homepage category pair
 * Slug: parimaanam-2026/home-category-pair
 * Categories: query
 * Inserter: no
 */

/*
 * Two categories side by side, four posts each. Slugs are resolved to the
 * environment's own term IDs rather than importing database-specific numbers,
 * and a category that does not exist is simply dropped, so the section still
 * renders on an installation that has only one of them.
 */
$parimaanam_pair = array();

foreach ( array( 'science', 'environment' ) as $parimaanam_slug ) {
	$parimaanam_term = get_category_by_slug( $parimaanam_slug );

	if ( ! $parimaanam_term instanceof WP_Term ) {
		continue;
	}

	$parimaanam_url = get_category_link( (int) $parimaanam_term->term_id );

	$parimaanam_pair[] = array(
		'id'   => (int) $parimaanam_term->term_id,
		'name' => $parimaanam_term->name,
		'url'  => is_wp_error( $parimaanam_url ) ? '' : $parimaanam_url,
	);
}

if ( ! $parimaanam_pair ) {
	return;
}
?>

<!-- wp:group {"align":"full","backgroundColor":"band","className":"home-category-pair","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","right":"var:preset|spacing|40","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull home-category-pair has-band-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:group {"align":"wide","className":"home-category-pair__layout","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide home-category-pair__layout">
		<?php foreach ( $parimaanam_pair as $parimaanam_category ) : ?>
		<!-- wp:group {"tagName":"section","className":"home-category-pair__column","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
		<section class="wp-block-group home-category-pair__column">
			<!-- wp:heading {"level":2,"className":"home-category-pair__heading","fontSize":"x-large"} -->
			<h2 class="wp-block-heading home-category-pair__heading has-x-large-font-size"><a href="<?php echo esc_url( $parimaanam_category['url'] ); ?>"><?php echo esc_html( $parimaanam_category['name'] ); ?></a></h2>
			<!-- /wp:heading -->

			<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo (int) $parimaanam_category['id']; ?>]}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
				<!-- wp:group {"tagName":"article","className":"home-category-pair__card","layout":{"type":"default"}} -->
				<article class="wp-block-group home-category-pair__card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","width":"100%","sizeSlug":"thumbnail"} /-->

					<!-- wp:post-date {"isLink":true,"fontSize":"small"} /-->

					<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /--></article>
				<!-- /wp:group -->
			<!-- /wp:post-template --></div>
			<!-- /wp:query -->
		</section>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
