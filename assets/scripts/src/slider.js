jQuery(function ($) {
	'use strict';

	// no slider animations for < ie8
    if (!$('body').is('.lt-ie8 .post-template-cambodia-signature-story')) {
        if ($('body').is('.post-template-cambodia-signature-story')) {
            $('.big-element.element-slider_gallery').royalSlider({
                loop: true,
                autoScaleSlider: true,
                imageScaleMode: 'fill',
                controlNavigation: 'thumbnails',
                arrowsNav: true,
                transitionType: 'fade',
                controlsInside: false,
                arrowsNavAutoHide: false,
                block: {
                    fadeEffect: true
                }
            });
            $('.element.element-').royalSlider({
                loop: true,
                autoScaleSlider: true,
                autoScaleSliderWidth: 1347,
                autoScaleSliderHeight: 1216,
                imageScaleMode: 'fill',
                height: 300,
                width: 750,
                controlNavigation: 'bullets',
                arrowsNav: true,
                transitionType: 'fade',
                controlsInside: false,
                arrowsNavAutoHide: false,
                block: {
                    fadeEffect: true
                }
            });
            
            function sliderGallery( slider ) {
                //set up nav links
                var $container = $('article'),
                    $rsContainer = $container.find(slider),
                    $features = $container.find('.rsSlide'),
                    $nav = $('<div></div>'),
                    offsetTop,
                    rsInstance,
                    navOutput;
                rsInstance = $rsContainer.data('royalSlider');
                
                navOutput = '<ul>';

                $nav.addClass('features-nav');

                for (var i = 0, len = rsInstance.numSlides; i < len; i++ ) {
                    navOutput += '<li><a href="#"><span>' + ( i + 1 ) + '</span></a></li>';
                }

                navOutput += '</ul>';

                $nav.append( $(navOutput) );
                $nav.appendTo( $rsContainer );
                console.log(rsInstance.currSlideId);
                $nav.find('a').eq( rsInstance.currSlideId ).addClass( 'active' );

                $nav.find('a').on( 'click', function (e) {
                    e.preventDefault();
                    $rsContainer.royalSlider( 'goTo', $(this).parent().index() );
                    $nav.find('a').removeClass( 'active' );
                    $(this).addClass( 'active' );
                } );

                //update nav on slide change
                rsInstance.ev.on( 'rsAfterSlideChange', function () {
                    $nav.find('a').removeClass( 'active' );
                    $nav.find('a').eq( rsInstance.currSlideId ).addClass( 'active' );
                });
            };
            
            sliderGallery('.element-slider_gallery1');
            sliderGallery('.element-slider_gallery3');
            sliderGallery('.element-slider_gallery5');
        }
    }
});