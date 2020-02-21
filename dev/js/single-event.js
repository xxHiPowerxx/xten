/**
 * Single Tribe Event JS.
 *
 * Single Tribe Event JS scripts.
 *
 * @since 1.0.0
 */

jQuery(document).ready(function($) {
	// Esri Map
	require([
		"esri/Map",
		"esri/views/MapView",
		"esri/widgets/Search",
		"esri/tasks/Locator",
		"esri/views/ui/UI",
		"dojo/domReady!"
	], function(Map, MapView, Search, Locator) {
		var searchWidget = null;
		var address = $("#single-event-map").attr("data-address");

		// Map
		var map = new Map({
			basemap: "streets-navigation-vector"
		});

		var themeUrl = themeVariables.themeUrl;

		var view = new MapView({
			scale: 123456789,
			container: "single-event-map",
			map: map,
			center: [-117.2898, 34.1083],
			zoom: 10
		});

		view.ui.move("zoom", "bottom-right");

		view.on("mouse-wheel", function(event) {
			// prevents zooming with the mouse-wheel event
			event.stopPropagation();
		});

		searchWidget = new Search({
			view: view,
			searchTerm: address,
			autoSelect: true,
			popupEnabled: false,
			includeDefaultSources: false,
			sources: [
				{
					locator: new Locator({
						url:
							"//geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer"
					}),
					singleLineFieldName: "SingleLine",
					outFields: ["Addr_type"],
					name: "ArcGIS World Geocoding Service",
					zoomScale: 150000,
					resultSymbol: {
						type: "picture-marker", // autocasts as new PictureMarkerSymbol()
						url: themeUrl + "/images/icon_location.png",
						size: 24,
						width: 24,
						height: 34,
						xoffset: 0,
						yoffset: 0
					},
					popupTemplate: {
						title: "Hello"
					}
				}
			]
		});

		searchWidget.search();
	});

	// Slider
	$(".single-event-upcoming-slider").slick({
		dots: false,
		arrows: true,
		infinite: true,
		speed: 300,
		slidesToShow: 4,
		slidesToScroll: 4,
		prevArrow:
			"<i class='fas fa-chevron-left xten-slick-prev' aria-label='Previous'></i>",
		nextArrow:
			"<i class='fas fa-chevron-right xten-slick-next' aria-label='Next'></i>",
		responsive: [
			{
				breakpoint: 1680,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3
				}
			},
			{
				breakpoint: 1000,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			},
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}

			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		]
	});
});
