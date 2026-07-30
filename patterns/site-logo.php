<?php
/**
 * Title: Parimaanam site logo
 * Slug: parimaanam-2026/site-logo
 * Inserter: no
 */

/*
 * Once an editor sets a logo in WordPress, Core's Site Logo block owns it and
 * the image becomes database-managed like the primary navigation. The bundled
 * theme asset below is only the portable first-activation default, so a fresh
 * installation is never left without site identity.
 */
if ( has_custom_logo() ) :
	?>

<!-- wp:site-logo {"width":240,"className":"parimaanam-site-logo"} /-->

	<?php
else :

	$parimaanam_logo_url  = get_theme_file_uri( 'assets/images/parimaanam-logo-web.svg' );
	$parimaanam_home_url  = home_url( '/' );
	$parimaanam_site_name = get_bloginfo( 'name' );
	?>

<!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"parimaanam-site-logo"} -->
<figure class="wp-block-image size-full parimaanam-site-logo"><a href="<?php echo esc_url( $parimaanam_home_url ); ?>"><img src="<?php echo esc_url( $parimaanam_logo_url ); ?>" alt="<?php echo esc_attr( $parimaanam_site_name ); ?>" width="240" height="80"/></a></figure>
<!-- /wp:image -->

	<?php
endif;
