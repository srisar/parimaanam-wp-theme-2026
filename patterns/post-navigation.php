<?php
/**
 * Title: Adjacent post navigation
 * Slug: parimaanam-2026/post-navigation
 * Inserter: no
 */

/*
 * Core's Post Navigation Link can print its own "Previous:" / "Next:" prefix,
 * but those exact strings are untranslated in the Tamil pack, so a ta_IN site
 * showed English labels beside Tamil titles. "Previous Post" and "Next Post"
 * are translated, so the labels are emitted here from Core's own translation
 * and the block's prefix is turned off.
 *
 * Whether an adjacent post exists is resolved here too, so the label is never
 * rendered above a link Core is going to omit.
 */
$parimaanam_previous = get_previous_post();
$parimaanam_next     = get_next_post();

if ( ! $parimaanam_previous && ! $parimaanam_next ) {
	return;
}
?>

<!-- wp:group {"tagName":"nav","align":"wide","className":"post-navigation","style":{"spacing":{"margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"default"}} -->
<nav class="wp-block-group alignwide post-navigation" style="margin-top:var(--wp--preset--spacing--70);margin-bottom:var(--wp--preset--spacing--70)">
	<?php if ( $parimaanam_previous ) : ?>
	<!-- wp:group {"className":"post-navigation__item post-navigation__item--previous","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group post-navigation__item post-navigation__item--previous">
		<!-- wp:paragraph {"className":"post-navigation__label","fontSize":"small"} -->
		<p class="post-navigation__label has-small-font-size"><?php echo esc_html__( 'Previous Post' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:post-navigation-link {"type":"previous","showTitle":true,"linkLabel":false,"arrow":"none"} /-->
	</div>
	<!-- /wp:group -->
	<?php endif; ?>

	<?php if ( $parimaanam_next ) : ?>
	<!-- wp:group {"className":"post-navigation__item post-navigation__item--next","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group post-navigation__item post-navigation__item--next">
		<!-- wp:paragraph {"className":"post-navigation__label","fontSize":"small"} -->
		<p class="post-navigation__label has-small-font-size"><?php echo esc_html__( 'Next Post' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:post-navigation-link {"showTitle":true,"linkLabel":false,"arrow":"none"} /-->
	</div>
	<!-- /wp:group -->
	<?php endif; ?>
</nav>
<!-- /wp:group -->
