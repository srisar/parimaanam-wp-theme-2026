<?php
/**
 * Title: Header navigation
 * Slug: parimaanam-2026/header-navigation
 * Inserter: no
 */

$parimaanam_navigation_paths = array(
	'science-series'                       => 'science-series',
	'black-holes-series'                   => 'science-series/black-holes-series',
	'artificial-intelligence-series'       => 'science-series/artificial-intelligence-series',
	'extraterrestrial-civilizations'       => 'science-series/extraterrestrial-civilizations',
	'large-hardon-collider'                => 'science-series/large-hardon-collider',
	'hubble-space-telescope'               => 'science-series/hubble-space-telescope',
	'electromagnetic-waves'                => 'science-series/electromagnetic-waves',
	'downloads'                            => 'downloads',
	'free-ebooks'                          => 'downloads/free-ebooks',
	'contacts'                             => 'contacts',
	'about'                                => 'about',
);

$parimaanam_navigation_urls = array();

foreach ( $parimaanam_navigation_paths as $parimaanam_navigation_key => $parimaanam_navigation_path ) {
	$parimaanam_navigation_page = get_page_by_path( $parimaanam_navigation_path );
	$parimaanam_navigation_url  = $parimaanam_navigation_page instanceof WP_Post
		? get_permalink( $parimaanam_navigation_page )
		: home_url( trailingslashit( $parimaanam_navigation_path ) );

	$parimaanam_navigation_urls[ $parimaanam_navigation_key ] = $parimaanam_navigation_url;
}
?>

<!-- wp:navigation {"overlayMenu":"mobile","overlayBackgroundColor":"paper","overlayTextColor":"ink","className":"site-navigation","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small","layout":{"type":"flex","justifyContent":"center"}} -->
	<!-- wp:navigation-submenu {"label":"<?php echo esc_attr_x( 'அறிவியல் தொடர்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>"} -->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'அறிவியல் தொடர்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['science-series'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'கருந்துளைகள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['black-holes-series'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'செயற்கை நுண்ணறிவு', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['artificial-intelligence-series'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'வேற்றுக்கிரக நாகரீகங்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['extraterrestrial-civilizations'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'LHC என்னும் துகள்முடுக்கி', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['large-hardon-collider'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'ஹபிள் தொலைநோக்கியும் விண்ணியல் வளர்ச்சியும்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['hubble-space-telescope'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'மின்காந்த அலைகள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['electromagnetic-waves'] ); ?>"} /-->
	<!-- /wp:navigation-submenu -->

	<!-- wp:navigation-submenu {"label":"<?php echo esc_attr_x( 'தரவிறக்கங்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>"} -->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'தரவிறக்கங்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['downloads'] ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'இலவச மின்னூல்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['free-ebooks'] ); ?>"} /-->
	<!-- /wp:navigation-submenu -->

	<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'தொடர்புகளுக்கு', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['contacts'] ); ?>"} /-->
	<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'பரிமாணம் பற்றி', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( $parimaanam_navigation_urls['about'] ); ?>"} /-->
<!-- /wp:navigation -->
