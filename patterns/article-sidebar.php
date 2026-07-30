<?php
/**
 * Title: Article discovery sidebar
 * Slug: parimaanam-2026/article-sidebar
 * Inserter: no
 */
?>

<!-- wp:group {"className":"article-sidebar__widgets","style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group article-sidebar__widgets">
	<!-- wp:group {"tagName":"section","className":"article-sidebar__widget","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<section class="wp-block-group article-sidebar__widget">
		<!-- wp:heading {"className":"article-sidebar__heading","fontSize":"medium"} -->
		<h2 class="wp-block-heading article-sidebar__heading has-medium-font-size"><?php echo esc_html_x( 'தேடல்', 'Article sidebar search heading', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:search {"label":"<?php echo esc_attr_x( 'தேடல்', 'Article sidebar search label', 'parimaanam-2026' ); ?>","showLabel":false,"buttonText":"<?php echo esc_attr_x( 'தேடல்', 'Article sidebar search button', 'parimaanam-2026' ); ?>","buttonUseIcon":true} /-->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"section","className":"article-sidebar__widget","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<section class="wp-block-group article-sidebar__widget">
		<!-- wp:heading {"className":"article-sidebar__heading","fontSize":"medium"} -->
		<h2 class="wp-block-heading article-sidebar__heading has-medium-font-size"><?php echo esc_html_x( 'பிரிவுகள்', 'Article sidebar categories heading', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:categories {"showPostCounts":true,"showHierarchy":false,"className":"article-sidebar__categories"} /-->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"section","className":"article-sidebar__widget","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<section class="wp-block-group article-sidebar__widget">
		<!-- wp:heading {"className":"article-sidebar__heading","fontSize":"medium"} -->
		<h2 class="wp-block-heading article-sidebar__heading has-medium-font-size"><?php echo esc_html_x( 'காப்பகம்', 'Article sidebar archives heading', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:archives {"displayAsDropdown":true,"showPostCounts":true,"type":"monthly","className":"article-sidebar__archives"} /-->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"section","className":"article-sidebar__widget","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<section class="wp-block-group article-sidebar__widget">
		<!-- wp:heading {"className":"article-sidebar__heading","fontSize":"medium"} -->
		<h2 class="wp-block-heading article-sidebar__heading has-medium-font-size"><?php echo esc_html_x( 'அண்மைய கட்டுரைகள்', 'Article sidebar latest posts heading', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:latest-posts {"postsToShow":5,"displayPostDate":true,"className":"article-sidebar__latest"} /-->
	</section>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
