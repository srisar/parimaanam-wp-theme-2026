<?php
/**
 * Title: Parimaanam site logo
 * Slug: parimaanam-2026/site-logo
 * Inserter: no
 */

$parimaanam_logo_url = get_theme_file_uri( 'assets/images/parimaanam-logo-web.svg' );
$parimaanam_home_url = home_url( '/' );
$parimaanam_site_name = get_bloginfo( 'name' );
?>

<!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"parimaanam-site-logo"} -->
<figure class="wp-block-image size-full parimaanam-site-logo"><a href="<?php echo esc_url( $parimaanam_home_url ); ?>"><img src="<?php echo esc_url( $parimaanam_logo_url ); ?>" alt="<?php echo esc_attr( $parimaanam_site_name ); ?>" width="240" height="80"/></a></figure>
<!-- /wp:image -->
