const WidgetJsController = function ($scope, $) {

	var CarouselScope = $scope.find(".visualize-carousel").eq(0);
	var items = CarouselScope.data('items')
	var spacebetween = CarouselScope.data('spacebetween')



	CarouselScope.owlCarousel({
		loop:true,
		margin:spacebetween,
		nav:true,
		responsive:{
		    0:{
		        items:1
		    },
		    600:{
		        items:2
		    },
		    1000:{
		        items: items
		    }
		}
	});
}
export default WidgetJsController;