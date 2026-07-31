<?php
/**
 * Title: Adjacent post navigation
 * Slug: parimaanam-2026/post-navigation
 * Inserter: no
 */

/*
 * Rendered here rather than with Core's Post Navigation Link block, which
 * prints a title and nothing else — it has no featured-image support, so a
 * thumbnail is not expressible through it. The adjacent posts were already
 * being resolved in this file to decide whether to emit a label at all, so
 * rendering from those objects costs nothing extra and returns the image.
 *
 * Core's own "Previous:" / "Next:" prefixes are untranslated in the Tamil
 * pack, which is why the labels come from `Previous Post` and `Next Post` —
 * those two are translated, so no copy is invented here.
 */
$parimaanam_adjacent = array(
	'previous' => get_previous_post(),
	'next'     => get_next_post(),
);

if ( ! $parimaanam_adjacent['previous'] && ! $parimaanam_adjacent['next'] ) {
	return;
}

$parimaanam_labels = array(
	'previous' => __( 'Previous Post' ),
	'next'     => __( 'Next Post' ),
);
?>

<!-- wp:group {"tagName":"nav","align":"wide","className":"post-navigation","style":{"spacing":{"margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"default"}} -->
<nav class="wp-block-group alignwide post-navigation" style="margin-top:var(--wp--preset--spacing--70);margin-bottom:var(--wp--preset--spacing--70)">
	<?php foreach ( $parimaanam_adjacent as $parimaanam_key => $parimaanam_post ) : ?>
		<?php if ( ! $parimaanam_post ) { continue; } ?>

	<!-- wp:html -->
	<div class="post-navigation__item post-navigation__item--<?php echo esc_attr( $parimaanam_key ); ?>">
		<p class="post-navigation__label"><?php echo esc_html( $parimaanam_labels[ $parimaanam_key ] ); ?></p>

		<a class="post-navigation__link" href="<?php echo esc_url( get_permalink( $parimaanam_post ) ); ?>">
			<?php if ( has_post_thumbnail( $parimaanam_post ) ) : ?>
			<span class="post-navigation__thumb">
				<?php
				/*
				 * Decorative: the destination's own title sits beside it and
				 * carries the meaning, so an alt text here would repeat it to a
				 * screen reader rather than add anything.
				 */
				echo get_the_post_thumbnail( $parimaanam_post, 'thumbnail', array( 'alt' => '', 'loading' => 'lazy' ) );
				?>
			</span>
			<?php endif; ?>

			<span class="post-navigation__title"><?php echo esc_html( get_the_title( $parimaanam_post ) ); ?></span>
		</a>
	</div>
	<!-- /wp:html -->
	<?php endforeach; ?>
</nav>
<!-- /wp:group -->
