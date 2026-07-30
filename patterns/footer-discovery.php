<?php
/**
 * Title: Footer discovery
 * Slug: parimaanam-2026/footer-discovery
 * Inserter: no
 */

?>

<!-- wp:group {"align":"wide","className":"site-footer__discovery","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide site-footer__discovery">
	<!-- wp:group {"tagName":"section","className":"site-footer__region site-footer__series","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<section class="wp-block-group site-footer__region site-footer__series">
		<!-- wp:heading {"level":2,"className":"site-footer__heading","fontSize":"medium"} -->
		<h2 class="wp-block-heading site-footer__heading has-medium-font-size"><?php echo esc_html_x( 'அறிவியல் தொடர்கள்', 'Footer heading for the science series', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:list {"className":"site-footer__series-list"} -->
		<ul class="wp-block-list site-footer__series-list">
			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( parimaanam_2026_navigation_url( 'black-holes-series' ) ); ?>"><?php echo esc_html_x( 'கருந்துளைகள்', 'Footer series link', 'parimaanam-2026' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( parimaanam_2026_navigation_url( 'artificial-intelligence-series' ) ); ?>"><?php echo esc_html_x( 'செயற்கை நுண்ணறிவு', 'Footer series link', 'parimaanam-2026' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( parimaanam_2026_navigation_url( 'extraterrestrial-civilizations' ) ); ?>"><?php echo esc_html_x( 'வேற்றுக்கிரக நாகரீகங்கள்', 'Footer series link', 'parimaanam-2026' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( parimaanam_2026_navigation_url( 'large-hardon-collider' ) ); ?>"><?php echo esc_html_x( 'LHC என்னும் துகள்முடுக்கி', 'Footer series link', 'parimaanam-2026' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( parimaanam_2026_navigation_url( 'hubble-space-telescope' ) ); ?>"><?php echo esc_html_x( 'ஹபிள் தொலைநோக்கியும் விண்ணியல் வளர்ச்சியும்', 'Footer series link', 'parimaanam-2026' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( parimaanam_2026_navigation_url( 'electromagnetic-waves' ) ); ?>"><?php echo esc_html_x( 'மின்காந்த அலைகள்', 'Footer series link', 'parimaanam-2026' ); ?></a></li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"section","className":"site-footer__region site-footer__categories","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
	<section class="wp-block-group site-footer__region site-footer__categories">
		<!-- wp:heading {"level":2,"className":"site-footer__heading","fontSize":"medium"} -->
		<h2 class="wp-block-heading site-footer__heading has-medium-font-size"><?php echo esc_html_x( 'பிரிவுகள்', 'Footer heading for the category list', 'parimaanam-2026' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:categories {"showPostCounts":true,"showHierarchy":false,"className":"site-footer__category-list"} /-->
	</section>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
