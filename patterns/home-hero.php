<?php
/**
 * Title: Homepage featured hero
 * Slug: parimaanam-2026/home-hero
 * Categories: query
 * Inserter: no
 *
 * Three featured slots and a row of recent posts. Sticky posts fill the slots
 * in order; any slot the editor has not chosen falls back to the most recent
 * unfeatured post, so the hero never renders a hole on an installation where
 * nobody has ticked anything.
 *
 * Slot resolution lives in inc/hero.php — see the note there on why Core
 * cannot simply be handed the post IDs.
 */

$parimaanam_featured_ids = parimaanam_2026_hero_featured_ids();
$parimaanam_featured     = count( $parimaanam_featured_ids );
?>

<!-- wp:group {"align":"wide","className":"home-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide home-hero"><!-- wp:group {"align":"wide","className":"home-hero__featured","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide home-hero__featured">

		<!-- wp:query {"query":<?php echo parimaanam_2026_hero_slot_query( 0, $parimaanam_featured ); ?>,"className":"home-hero__lead","layout":{"type":"constrained"}} -->
		<div class="wp-block-query home-hero__lead"><!-- wp:heading {"className":"screen-reader-text"} -->
			<h2 class="wp-block-heading screen-reader-text"><?php echo esc_html_x( 'முதன்மைக் கட்டுரை', 'Hidden heading naming the homepage lead story region', 'parimaanam-2026' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:post-template -->
			<!-- wp:group {"tagName":"article","className":"home-hero__lead-card","layout":{"type":"default"}} -->
			<article class="wp-block-group home-hero__lead-card"><!-- wp:post-featured-image {"isLink":true,"width":"100%","sizeSlug":"large"} /-->

				<!-- wp:group {"className":"home-hero__lead-content","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group home-hero__lead-content"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
					<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category","className":"parimaanam-chip parimaanam-chip--accent"} /-->

						<!-- wp:post-date {"isLink":true,"className":"parimaanam-chip parimaanam-chip--outline"} /--></div>
					<!-- /wp:group -->

					<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"x-large"} /-->

					<!-- wp:post-excerpt {"excerptLength":24} /--></div>
				<!-- /wp:group --></article>
			<!-- /wp:group -->
		<!-- /wp:post-template --></div>
		<!-- /wp:query -->

		<!-- wp:group {"className":"home-hero__side","layout":{"type":"default"}} -->
		<div class="wp-block-group home-hero__side">
			<?php for ( $parimaanam_slot = 1; $parimaanam_slot < 3; $parimaanam_slot++ ) : ?>

			<!-- wp:query {"query":<?php echo parimaanam_2026_hero_slot_query( $parimaanam_slot, $parimaanam_featured ); ?>,"layout":{"type":"constrained"}} -->
			<div class="wp-block-query"><!-- wp:post-template -->
				<!-- wp:group {"tagName":"article","className":"home-hero__side-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
				<article class="wp-block-group home-hero__side-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","width":"100%","sizeSlug":"medium_large"} /-->

					<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
					<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category","className":"parimaanam-chip parimaanam-chip--accent"} /-->

						<!-- wp:post-date {"isLink":true,"className":"parimaanam-chip parimaanam-chip--outline"} /--></div>
					<!-- /wp:group -->

					<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /--></article>
				<!-- /wp:group -->
			<!-- /wp:post-template --></div>
			<!-- /wp:query -->
			<?php endfor; ?>
		</div>
		<!-- /wp:group --></div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"home-hero__recent","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide home-hero__recent" style="margin-top:var(--wp--preset--spacing--60)"><!-- wp:heading {"className":"home-hero__eyebrow","fontSize":"large"} -->
		<h2 class="wp-block-heading home-hero__eyebrow has-large-font-size"><?php echo esc_html_x( 'புதிய கட்டுரைகள்', 'Homepage heading for latest stories', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:query {"query":<?php echo parimaanam_2026_hero_recent_query( $parimaanam_featured_ids ); ?>,"align":"wide","layout":{"type":"constrained"}} -->
		<div class="wp-block-query alignwide"><!-- wp:post-template {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"18rem"}} -->
			<!-- wp:group {"tagName":"article","className":"home-hero__recent-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
			<article class="wp-block-group home-hero__recent-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"100%","sizeSlug":"medium_large"} /-->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
				<div class="wp-block-group has-small-font-size"><!-- wp:post-terms {"term":"category","className":"parimaanam-chip parimaanam-chip--accent"} /-->

					<!-- wp:post-date {"isLink":true,"className":"parimaanam-chip parimaanam-chip--outline"} /--></div>
				<!-- /wp:group -->

				<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /--></article>
			<!-- /wp:group -->
		<!-- /wp:post-template --></div>
		<!-- /wp:query --></div>
	<!-- /wp:group --></div>
<!-- /wp:group -->
