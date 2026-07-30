<?php
/**
 * Title: Header navigation
 * Slug: parimaanam-2026/header-navigation
 * Inserter: no
 *
 * Page paths and their resolution live in inc/navigation.php so the footer can
 * link to the same approved destinations. Labels stay here because translation
 * calls must receive string literals to remain extractable.
 */
?>

<!-- wp:navigation {"overlayMenu":"mobile","overlayBackgroundColor":"paper","overlayTextColor":"ink","className":"site-navigation","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"fontSize":"small","layout":{"type":"flex","justifyContent":"center"}} -->
	<!-- wp:navigation-submenu {"label":"<?php echo esc_attr_x( 'அறிவியல் தொடர்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>"} -->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'அறிவியல் தொடர்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'science-series' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'கருந்துளைகள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'black-holes-series' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'செயற்கை நுண்ணறிவு', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'artificial-intelligence-series' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'வேற்றுக்கிரக நாகரீகங்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'extraterrestrial-civilizations' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'LHC என்னும் துகள்முடுக்கி', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'large-hardon-collider' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'ஹபிள் தொலைநோக்கியும் விண்ணியல் வளர்ச்சியும்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'hubble-space-telescope' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'மின்காந்த அலைகள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'electromagnetic-waves' ) ); ?>"} /-->
	<!-- /wp:navigation-submenu -->

	<!-- wp:navigation-submenu {"label":"<?php echo esc_attr_x( 'தரவிறக்கங்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>"} -->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'தரவிறக்கங்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'downloads' ) ); ?>"} /-->
		<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'இலவச மின்னூல்கள்', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'free-ebooks' ) ); ?>"} /-->
	<!-- /wp:navigation-submenu -->

	<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'தொடர்புகளுக்கு', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'contacts' ) ); ?>"} /-->
	<!-- wp:navigation-link {"label":"<?php echo esc_attr_x( 'பரிமாணம் பற்றி', 'Header navigation label', 'parimaanam-2026' ); ?>","url":"<?php echo esc_url( parimaanam_2026_navigation_url( 'about' ) ); ?>"} /-->
<!-- /wp:navigation -->
