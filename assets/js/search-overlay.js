/*
 * Upgrades the header search link into a full-focus overlay.
 *
 * The markup works without this file: the trigger is a real link to the search
 * results page. This only intercepts it where a native dialog is available, so
 * there is no behaviour to restore if the script fails to load.
 *
 * <dialog>.showModal() supplies the focus trap, Escape handling, and return of
 * focus to the trigger, so none of that is reimplemented here.
 */
( function () {
	var root = document.querySelector( '.site-search' );

	if ( ! root ) {
		return;
	}

	var trigger = root.querySelector( '.site-search__trigger' );
	var overlay = root.querySelector( '.site-search__overlay' );
	var field = root.querySelector( '.site-search__field' );
	var close = root.querySelector( '.site-search__close' );

	if ( ! trigger || ! overlay || typeof overlay.showModal !== 'function' ) {
		return;
	}

	trigger.addEventListener( 'click', function ( event ) {
		event.preventDefault();
		overlay.showModal();

		if ( field ) {
			field.focus();
		}
	} );

	if ( close ) {
		close.addEventListener( 'click', function () {
			overlay.close();
		} );
	}

	// The dialog fills the viewport, so a click landing on it rather than on
	// its contents is a click on the backdrop.
	overlay.addEventListener( 'click', function ( event ) {
		if ( event.target === overlay ) {
			overlay.close();
		}
	} );
}() );
