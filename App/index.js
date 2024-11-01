import WidgetOwlCarousel from './Carousel/index.js';
(function ($) {

	
	//elementor front start
	jQuery(window).on('elementor/frontend/init', function () {
	    if (elementorFrontend.isEditMode()) {
			elementorFrontend.hooks.addAction('frontend/element_ready/Visualize-Carousel.default', WidgetOwlCarousel);
	    } else {
			elementorFrontend.hooks.addAction('frontend/element_ready/Visualize-Carousel.default', WidgetOwlCarousel);
		}
	});

})(jQuery); 