/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery

-----------------------------------------------------------------------------------*/

;(function($) {
	"use strict";

	$(document).ready(function($) {

		/* --------------------------------------- */
		/* Nav
		/* --------------------------------------- */
		var $window = $(window),
		  $siteHeader = $('.site-header'),
		  $siteContent = $('.site-content');

		positionHeader();

		$window.scroll(function() {
		  var $this = $(this),
		  pos = $this.scrollTop();
		  if(pos > 20){
		    $siteHeader.addClass('shrinkit');
		  } else {
		    $siteHeader.removeClass('shrinkit');
		  }
		  positionHeader();
		});

		$window.on('resize', function() {
		  positionHeader();
		});

		function positionHeader() {
		  if( $window.width() > 992 ) {
		    $siteHeader.css({position : 'fixed'});
		  } else {
		    $siteHeader.css({position : 'relative'});
		  }
		}

		/* --------------------------------------- */
		/* Custom header
		/* --------------------------------------- */
		function sizeMedia(media) {
			var mh = $(media).height();
			$(media).imagesLoaded( function() {
				if( mh > $window.height() - $siteHeader.outerHeight() ) {
					$(media).css({
						height: $window.height() - $siteHeader.outerHeight(),
						overflow: 'hidden'
					}).find('img').addClass('center-image');
				}
			});
			$window.resize(function () {
				if( mh > $window.height() - $siteHeader.outerHeight() ) {
					$(media).css({
						height: $window.height() - $siteHeader.outerHeight(),
					});
				}
			});
		}

		sizeMedia('.portfolio-media-feature, .single-post .format-standard .entry-thumbnail, .page .site-main > article .entry-thumbnail');


		/* --------------------------------------- */
		/* ZillaMobileMenu & Superfish
		/* --------------------------------------- */
		$('#primary-menu')
			.zillaMobileMenu({
				breakPoint: 992,
				hideNavParent: true,
				onInit: function( menu ) {
					$(menu).removeClass('zilla-sf-menu primary-menu');
				}
			})
			.superfish({
		    		delay: 0,
		    		animation: {opacity:'show'},
		    		animationOut:  {opacity:'hide'},
		    		speed: 100,
		    		cssArrows: false,
		    		disableHI: true
			});

		/* --------------------------------------- */
		/* Cycle - Slideshow media
		/* --------------------------------------- */
		function initSlideshows() {
			if( $().cycle ) {
				var $sliders = $('.slideshow');
				$sliders.each(function() {
					var $this = $(this);

					$this.cycle({
						autoHeight: 0,
						slides: '> .slide',
						swipe: true,
						timeout: 0,
						updateView: 1
					});

					if( $('body').hasClass('single-post') ) {
						$this.on('cycle-update-view', function(e,o,sh,cs) {
							var $cs = $(cs);

							$(this).animate({
								height: $cs.height()
							}, 300);
						});
					}
				});
			}
		}
		initSlideshows();
		
		$('.zilla-gallery-container').each(function () {
			var $gallery = $(this);
			$gallery.imagesLoaded( function() {
				$gallery.find('.slideshow').addClass('show');
			});
		});

		/* --------------------------------------- */
		/* Isotope
		/* --------------------------------------- */
		if( $().isotope ) {
			var $container = $('.isotope-container.layout-masonry');
			if($container.length) {
				$container.imagesLoaded( function() {
					$container.isotope({
						itemSelector: '.post',
						layoutMode: 'masonry',
						stamp: '.archive-header'
					});
				});
				
				// When using Jetpack Infinite Scroll, add new elements to isotope masonry grid
				var infiniteCount = 0;
				$( document.body ).on( 'post-load', function () {
		
					// Identify the new posts as all elements between the two bottom-most .infinite-loader elements
					var $allElems = $('.isotope-container').find('.post');
					var $firstLoader = $('.infinite-loader:eq(' + infiniteCount + ')');
					infiniteCount++;
					var $secondLoader = $('.infinite-loader:eq(' + infiniteCount + ')');
					var $newElems = $firstLoader.nextUntil($secondLoader);
		
					// Prevent showing the new posts before slideshows are initialized and elements are added to isotope
					$newElems.css({ display : 'none'});
		
					initSlideshows();
		
					// Once all images are loaded, add the new elements to isotope
					$allElems.imagesLoaded( function() {
						$container.isotope( 'insert', $newElems );
					});
		 
				});
			}

			var $portfolioContainer = $('.portfolio-feed');
			if($portfolioContainer.length) {
				$portfolioContainer.imagesLoaded( function() {
					$portfolioContainer.isotope({
						itemSelector: '.type-portfolio',
						layoutMode: 'fitRows',
						stamp: '.portfolio-hr',
						hiddenStyle: {
							opacity: 0
						},
						visibleStyle: {
							opacity: 1
						}
					});
				});

				$('.portfolio-type-nav a').on('click', function(e) {
					e.preventDefault();
					$portfolioContainer.isotope({
						filter: $(this).attr('data-filter')
					});
					$('.portfolio-type-nav a').removeClass('active');
					$(this).addClass('active');
				});
			}
		}
		
		/* --------------------------------------- */
		/* Standard Layout Featured IMGs
		/* --------------------------------------- */
		$(document).on('click', '.layout-standard .format-standard .entry-thumbnail, .layout-standard .format-image .entry-thumbnail', function () {
			var imgHeight = $(this).find('img').height();
			if (! $(this).hasClass('mask')) {
				$(this).css({
					height: imgHeight + 'px'
				}).addClass('mask');
			} else {
				$(this).css({
					height: '460px'
				}).removeClass('mask');
			}
		});
		
		$window.resize(function () {
			$('.entry-thumbnail.mask').each(function () {
				var imgHeight = $(this).find('img').height();
				$(this).css({
					height: imgHeight + 'px'
				});
			});
		});

		/* --------------------------------------- */
		/* Responsive media - FitVids
		/* --------------------------------------- */
		if( $().fitVids ) {
			$('#content').fitVids();
		} /* FitVids --- */

		/* --------------------------------------- */
		/* Comment Form
		/* --------------------------------------- */
		var $commentform = $('#commentform');
		if ( $commentform.length ) {
			var commentformHeight = $commentform.height(),
				$cancelComment = $('#cancel-comment');

			$commentform.css({
				height : 55,
				overflow : 'hidden'
			}).on('click', function() {
				var $this = $(this);
				$this.animate({
					height : commentformHeight,
					overflow : 'visible'
				}, 500);

				$cancelComment.on('click', function(e) {
					e.preventDefault();

					$this.animate({
						height : 55,
						overflow : 'hidden'
					}, 500);

					return false;
				});
			});
		}

	});

})(window.jQuery);