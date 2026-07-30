<?php
/**
 * Title: Homepage Technology showcase
 * Slug: parimaanam-2026/category-technology
 * Categories: query
 * Inserter: no
 */

$parimaanam_technology_term = get_category_by_slug( 'technology' );

if ( $parimaanam_technology_term instanceof WP_Term ) :
	$parimaanam_technology_term_id = (int) $parimaanam_technology_term->term_id;
	$parimaanam_technology_url     = get_category_link( $parimaanam_technology_term_id );

	if ( is_wp_error( $parimaanam_technology_url ) ) {
		$parimaanam_technology_url = '';
	}
	?>

<!-- wp:group {"align":"full","gradient":"graphite-ascend","className":"home-category-showcase","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","right":"var:preset|spacing|40","bottom":"var:preset|spacing|70","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull home-category-showcase has-graphite-ascend-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"align":"wide","className":"home-category-showcase__heading","fontSize":"x-large"} -->
	<h2 class="wp-block-heading alignwide home-category-showcase__heading has-x-large-font-size"><a href="<?php echo esc_url( $parimaanam_technology_url ); ?>"><?php echo esc_html( $parimaanam_technology_term->name ); ?></a></h2>
	<!-- /wp:heading -->

	<!-- wp:query {"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo $parimaanam_technology_term_id; ?>]}},"align":"wide","className":"home-category-showcase__features","layout":{"type":"constrained"}} -->
	<div class="wp-block-query alignwide home-category-showcase__features"><!-- wp:post-template {"align":"wide","layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"16rem"}} -->
		<!-- wp:group {"tagName":"article","backgroundColor":"paper","className":"home-category-showcase__feature-card","layout":{"type":"constrained"}} -->
		<article class="wp-block-group home-category-showcase__feature-card has-paper-background-color has-background"><!-- wp:post-featured-image {"isLink":true,"width":"100%","sizeSlug":"medium_large"} /-->

			<!-- wp:group {"className":"home-category-showcase__feature-content","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group home-category-showcase__feature-content"><!-- wp:post-date {"isLink":true,"fontSize":"small"} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /--></div>
			<!-- /wp:group --></article>
		<!-- /wp:group -->
	<!-- /wp:post-template --></div>
	<!-- /wp:query -->

	<!-- wp:separator {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"}}}} -->
	<hr class="wp-block-separator alignwide has-alpha-channel-opacity" style="margin-top:var(--wp--preset--spacing--60);margin-bottom:var(--wp--preset--spacing--40)"/>
	<!-- /wp:separator -->

	<!-- wp:query {"query":{"perPage":6,"pages":0,"offset":4,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo $parimaanam_technology_term_id; ?>]}},"align":"wide","className":"home-category-showcase__compact","layout":{"type":"constrained"}} -->
	<div class="wp-block-query alignwide home-category-showcase__compact"><!-- wp:post-template {"align":"wide","layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"22rem"}} -->
		<!-- wp:group {"tagName":"article","className":"home-category-showcase__compact-card","layout":{"type":"default"}} -->
		<article class="wp-block-group home-category-showcase__compact-card"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group"><!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

				<!-- wp:post-date {"isLink":true,"fontSize":"small"} /--></div>
			<!-- /wp:group -->

			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","width":"96px","height":"96px","sizeSlug":"thumbnail"} /--></article>
		<!-- /wp:group -->
	<!-- /wp:post-template --></div>
	<!-- /wp:query --></div>
<!-- /wp:group -->

<?php endif; ?>
