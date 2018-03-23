/**
 * Theme's Custom Javascript Main Files
 */
jQuery( document ).ready( function () {

	// Search toggle
	jQuery( '.search-top' ).click( function () {
		jQuery( '#masthead .search-form-top' ).slideToggle( 'slow' );
	} );

	// Scroll up function
	jQuery( '#scroll-up' ).hide();
	jQuery( function () {
		jQuery( window ).scroll( function () {
			if ( jQuery( this ).scrollTop() > 1000 ) {
				jQuery( '#scroll-up' ).fadeIn();
			} else {
				jQuery( '#scroll-up' ).fadeOut();
			}
		} );
		jQuery( 'a#scroll-up' ).click( function () {
			jQuery( 'body,html' ).animate( {
				scrollTop : 0
			}, 1000 );
			return false;
		} );
	} );

	// Setting for the responsive video using fitvids
	if ( typeof jQuery.fn.fitVids !== 'undefined' ) {
		jQuery( '.fitvids-video' ).fitVids();
	}

	// Setting for the news ticker
	if ( typeof jQuery.fn.newsTicker !== 'undefined' ) {
		jQuery( '.newsticker' ).newsTicker( {
			row_height   : 20,
			max_rows     : 1,
			speed        : 1000,
			direction    : 'up',
			duration     : 3000,
			autostart    : 1,
			pauseOnHover : 1,
			start        : function () {
				jQuery( '.newsticker' ).css( 'visibility', 'visible' );
				jQuery( '.newsticker' ).css( 'display', 'inline-block' );
			}
		} );
	}

	// Setting for the popup featured image
	if ( typeof jQuery.fn.magnificPopup !== 'undefined' ) {
		jQuery( '.featured-image-popup' ).magnificPopup( { type : 'image' } );
	}

	// Setting for the gallery slider
	if ( typeof jQuery.fn.carousel !== 'undefined' ) {
		jQuery( '.carousel' ).carousel();
	}

	// Setting for the sticky menu
	if ( typeof jQuery.fn.sticky !== 'undefined' ) {
		var wpAdminBar = jQuery( '#wpadminbar' );
		if ( wpAdminBar.length ) {
			jQuery( '#site-navigation' ).sticky( {
				topSpacing : wpAdminBar.height(),
				zIndex     : 9999
			} );
		} else {
			jQuery( '#site-navigation' ).sticky( {
				topSpacing : 0,
				zIndex     : 9999
			} );
		}
	}

	// Setting for sticky sidebar and content area
	if ( (typeof jQuery.fn.theiaStickySidebar !== 'undefined') && (typeof ResizeSensor !== 'undefined') ) {
		// Calculate the whole height of sticky menu
		var height = jQuery( '#site-navigation-sticky-wrapper' ).outerHeight();

		// Assign height value to 0 if it returns null
		if ( height === null ) {
			height = 0;
		}

		jQuery( '#primary, #secondary' ).theiaStickySidebar( {
			additionalMarginTop : 40 + height
		} );
	}

} );
