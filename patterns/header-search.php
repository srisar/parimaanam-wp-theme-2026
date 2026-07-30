<?php
/**
 * Title: Header search
 * Slug: parimaanam-2026/header-search
 * Inserter: no
 */

/*
 * The trigger is a real link to the search results page, so the control still
 * works when the script does not run or the browser has no dialog support. The
 * script upgrades it into an overlay; nothing here depends on it.
 */
$parimaanam_search_label = esc_attr_x( 'தேடல்', 'Header search label', 'parimaanam-2026' );

// Core's own translation, so the close control needs no invented Tamil.
$parimaanam_close_label = esc_attr__( 'Close' );
?>

<!-- wp:html -->
<div class="site-search">
	<a class="site-search__trigger" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php echo $parimaanam_search_label; ?>">
		<svg class="site-search__icon" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M13 5c-3.3 0-6 2.7-6 6 0 1.4.5 2.7 1.3 3.7l-3.8 3.8 1.1 1.1 3.8-3.8c1 .8 2.3 1.3 3.7 1.3 3.3 0 6-2.7 6-6S16.3 5 13 5zm0 10.5c-2.5 0-4.5-2-4.5-4.5s2-4.5 4.5-4.5 4.5 2 4.5 4.5-2 4.5-4.5 4.5z"></path></svg>
	</a>

	<dialog class="site-search__overlay" aria-label="<?php echo $parimaanam_search_label; ?>">
		<button class="site-search__close" type="button" aria-label="<?php echo $parimaanam_close_label; ?>">
			<svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"></path></svg>
		</button>

		<form class="site-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="site-search-field"><?php echo esc_html_x( 'தேடல்', 'Header search label', 'parimaanam-2026' ); ?></label>
			<input class="site-search__field" id="site-search-field" type="search" name="s" autocomplete="off" placeholder="<?php echo $parimaanam_search_label; ?>" />
			<button class="site-search__submit" type="submit"><?php echo esc_html_x( 'தேடல்', 'Header search label', 'parimaanam-2026' ); ?></button>
		</form>
	</dialog>
</div>
<!-- /wp:html -->
