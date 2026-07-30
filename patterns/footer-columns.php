<?php
/**
 * Title: Footer columns
 * Slug: parimaanam-2026/footer-columns
 * Inserter: no
 */

?>

<!-- wp:group {"align":"wide","className":"site-footer__columns","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide site-footer__columns">
	<!-- wp:group {"className":"site-footer__region site-footer__identity","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group site-footer__region site-footer__identity">
		<!-- wp:pattern {"slug":"parimaanam-2026/site-logo"} /-->
	</div>
	<!-- /wp:group -->

	<!--
		The secondary links are a Core Navigation block so an editor can add,
		rename, reorder, or remove them in the Site Editor. Saving there makes
		WordPress own the menu, exactly as it already does for the header. The
		links below are only the portable first-activation default.
	-->
	<!-- wp:group {"tagName":"nav","className":"site-footer__region site-footer__secondary","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<nav class="wp-block-group site-footer__region site-footer__secondary">
		<!-- wp:navigation {"overlayMenu":"never","className":"site-footer__nav","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"fontSize":"small","layout":{"type":"flex","flexWrap":"wrap"}} -->
			<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'பரிமாணம் பற்றி', 'Footer navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'about' ) ); ?>"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'தொடர்புகளுக்கு', 'Footer navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'contacts' ) ); ?>"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'தரவிறக்கங்கள்', 'Footer navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'downloads' ) ); ?>"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'இலவச மின்னூல்கள்', 'Footer navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'free-ebooks' ) ); ?>"} /-->
		<!-- /wp:navigation -->
	</nav>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
