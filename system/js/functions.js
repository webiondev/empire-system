

/* Show hide scrolltop button */
$(window).scroll(function () {
    /* Show hide scrolltop button */
    if ($(window).scrollTop() == 0) {
        $('.scroll_top').stop(false, true).fadeOut(600);
    } else {
        $('.scroll_top').stop(false, true).fadeIn(600);
    }
});

jQuery(document).on('click', '.scroll_top', function () {
    $('body,html').animate({scrollTop: 0}, 400);
    return false;
})
/*---- scroll top end-----*/

/*---- document start-----*/
jQuery(document).ready(function ($) {
/*---- navbar stcky start-----*/	
    var navbar = $('.main-navbar'),
            distance = navbar.offset().top + 10,
            $window = $(window);

    $window.scroll(function () {
        if ($window.scrollTop() >= distance) {
            navbar.removeClass('navbar-fixed-top').addClass('navbar-fixed-top');
        } else {
            navbar.removeClass('navbar-fixed-top');
        }
    });
/*---- navbar stcky end-----*/	

var isMulti = ($('.owl-slider .item').length > 1) ? true : false	
	
/*---- owl start-----*/		
$('.owl-slider').owlCarousel({
    loop:isMulti,
    margin:0,
    nav:true,
	autoplay:false,
	navText: ["<i class='fa  fa-angle-left'></i>","<i class='fa  fa-angle-right'></i>"],
	dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        },
        1200:{
            items:1
        }
    }
});

var isMulti = ($('.owl-prodetails .item').length > 1) ? true : false

$('.owl-prodetails').owlCarousel({
    loop:false,
    margin:30,
    nav:true,
	autoplay:false,
	navText: ["<i class='fa  fa-angle-left'></i>","<i class='fa  fa-angle-right'></i>"],
	dots:false,
    responsive:{
        0:{
            items:1
        },
		500:{
            items:2
        },
        769:{
            items:3
        },
        1000:{
            items:4
        },
        1200:{
            items:4
        }
    }
});

var isMulti = ($('.owl-testimonials .item').length > 1) ? true : false

$('.owl-testimonials').owlCarousel({
    loop:isMulti,
    margin:30,
    nav:true,
	autoplay:false,
	navText: ["<i class='fa  fa-angle-left'></i>","<i class='fa  fa-angle-right'></i>"],
	dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:3
        }
    }
});

/*---- owl end-----*/	

/*---- scrollToFixed-----
if ($(window).width() > 769) {
$('.panel-sidegray').scrollToFixed({
	marginTop: $('.main-navbar').outerHeight() - 20,
	limit: $('.section-testimonials').offset().top - $('.panel-sidegray').outerHeight() - 50,
	zIndex: 999,
});	
}
---- scrollToFixed end-----*/

});
/*---- document end-----*/


/* Flex */
/* JavaScript Fallback */
( function( $, window, document, undefined )
{
  'use strict';
  var s = document.body || document.documentElement, s = s.style;
  if( s.webkitFlexWrap == '' || s.msFlexWrap == '' || s.flexWrap == '' ) return true;

  var $list   = $( '.fx' ),
    $items    = $list.find( '.fxIn' ),
    setHeights  = function()
      {
      $items.css( 'height', 'auto' );

      var perRow = Math.floor( $list.width() / $items.width() );
      if( perRow == null || perRow < 2 ) return true;

      for( var i = 0, j = $items.length; i < j; i += perRow )
      {
        var maxHeight = 0,
          $row    = $items.slice( i, i + perRow );

        $row.each( function()
        {
          var itemHeight = parseInt( $( this ).outerHeight() );
          if ( itemHeight > maxHeight ) maxHeight = itemHeight;
        });
        $row.css( 'height', maxHeight );
      }
    };

  setHeights();
  $( window ).on( 'resize', setHeights );
  $list.find( 'img' ).on( 'load', setHeights );

})( jQuery, window, document );

