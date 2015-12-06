/*
 * Theme's Custom Javascript Main Files
 */
jQuery(document).ready(function () {

    // search toggle
    jQuery(".search-top").click(function () {
        jQuery("#masthead .search-form-top").slideToggle('slow');
    });

    // scroll up function
    jQuery("#scroll-up").hide();
    jQuery(function () {
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 1000) {
                jQuery('#scroll-up').fadeIn();
            } else {
                jQuery('#scroll-up').fadeOut();
            }
        });
        jQuery('a#scroll-up').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
    });

    // Setting for the responsive video using fitvids
    if (typeof jQuery.fn.fitVids !== 'undefined') {
        jQuery(".fitvids-video").fitVids();
    }

    // setting for the news ticker
    if (typeof jQuery.fn.newsTicker !== 'undefined') {
        jQuery('.newsticker').newsTicker({
            row_height: 20,
            max_rows: 1,
            speed: 1000,
            direction: 'up',
            duration: 3000,
            autostart: 1,
            pauseOnHover: 1,
            start: function () {
                jQuery(".newsticker").css("visibility", "visible");
            }
        });
    }
    
    // setting for the popup featured image
    if ( typeof jQuery.fn.magnificPopup !== 'undefined' ) {
        jQuery('.featured-image-popup').magnificPopup({type: 'image'});
    }
    
    // setting for the gallery slider
    if ( typeof jQuery.fn.carousel !== 'undefined' ) {
        jQuery('.carousel').carousel();
    }

});
