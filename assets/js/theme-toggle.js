/*
 * Records an explicit theme choice.
 *
 * The operating system default needs no JavaScript — color-scheme and
 * light-dark() express it in CSS — so this file exists only for the reader who
 * wants something other than what their device says. Writing data-theme is
 * what overrides that default.
 *
 * On load it deliberately does *not* write the attribute. Pinning it to
 * whatever the system happens to say at that moment would stop the page
 * following a system change made while it is open, and would record a choice
 * the reader never made. Only the button's label is brought into line.
 */
( function () {
	var buttons = document.querySelectorAll( '.theme-toggle' );

	if ( ! buttons.length ) {
		return;
	}

	var STORAGE_KEY = 'parimaanam-theme';

	// What the reader is looking at now, chosen or inherited from the system.
	function current() {
		var chosen = document.documentElement.getAttribute( 'data-theme' );

		if ( chosen === 'light' || chosen === 'dark' ) {
			return chosen;
		}

		return window.matchMedia( '(prefers-color-scheme: light)' ).matches ? 'light' : 'dark';
	}

	/*
	 * The label names the destination, not the current state — a button
	 * reading "Switch to light theme" tells the reader what pressing it does,
	 * where one reading "Dark theme" leaves them to guess.
	 */
	function label( theme ) {
		var next = theme === 'light' ? 'dark' : 'light';

		Array.prototype.forEach.call( buttons, function ( button ) {
			button.setAttribute( 'aria-label', button.getAttribute( 'data-label-' + next ) );
		} );
	}

	label( current() );

	Array.prototype.forEach.call( buttons, function ( button ) {
		button.addEventListener( 'click', function () {
			var next = current() === 'light' ? 'dark' : 'light';

			document.documentElement.setAttribute( 'data-theme', next );
			label( next );

			try {
				localStorage.setItem( STORAGE_KEY, next );
			} catch ( e ) {}
		} );
	} );

	/*
	 * Follow the system if it changes and the reader has never chosen. Without
	 * this the label would go stale against a palette that had already moved.
	 */
	window.matchMedia( '(prefers-color-scheme: light)' ).addEventListener( 'change', function () {
		if ( ! document.documentElement.hasAttribute( 'data-theme' ) ) {
			label( current() );
		}
	} );
}() );
