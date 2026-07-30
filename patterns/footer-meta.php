<?php
/**
 * Title: Footer meta
 * Slug: parimaanam-2026/footer-meta
 * Inserter: no
 */

/*
 * Core returns an empty string unless a privacy page is both designated and
 * published, and supplies its own escaped anchor using that page's title. The
 * conditional behaviour and the link text therefore need no theme-side copy.
 */
$parimaanam_privacy_link = get_the_privacy_policy_link();
?>

<!-- wp:group {"className":"site-footer__meta","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group site-footer__meta">
	<!-- wp:site-title {"level":0,"isLink":true,"fontSize":"small"} /-->

	<!-- wp:paragraph {"className":"site-footer__copyright","fontSize":"small"} -->
	<p class="site-footer__copyright has-small-font-size"><?php
		printf(
			/* translators: 1: four-digit year, 2: site name. */
			esc_html_x( '© %1$s %2$s', 'Footer copyright line', 'parimaanam-2026' ),
			esc_html( wp_date( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	?></p>
	<!-- /wp:paragraph -->

	<?php if ( '' !== $parimaanam_privacy_link ) : ?>
	<!-- wp:paragraph {"className":"site-footer__privacy","fontSize":"small"} -->
	<p class="site-footer__privacy has-small-font-size"><?php echo wp_kses_post( $parimaanam_privacy_link ); ?></p>
	<!-- /wp:paragraph -->
	<?php endif; ?>
</div>
<!-- /wp:group -->
