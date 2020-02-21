/**
 * Single Tribe Event JS.
 *
 * Single Tribe Event JS scripts.
 *
 * @since 1.0.0
 */

jQuery( document ).ready( function( $ ) {

	// Esri Map
	require([
		'esri/Map',
		'esri/views/MapView',
		'esri/widgets/Search',
		'esri/tasks/Locator',
		'esri/views/ui/UI',
		'dojo/domReady!'
	], function( Map, MapView, Search, Locator ) {
		var searchWidget = null;
		var address = $( '#venue-map' ).attr( 'data-address' );

		// Map
		var map = new Map({
			basemap: 'streets-navigation-vector'
		});

		var themeUrl = themeVariables.themeUrl;

		var view = new MapView({
			scale: 123456789,
			container: 'venue-map',
			map: map,
			center: [ -117.2898, 34.1083 ],
			zoom: 10
		});

		view.ui.move( 'zoom', 'bottom-right' );

		view.on( 'mouse-wheel', function( event ) {

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
							'//geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer'
					}),
					singleLineFieldName: 'SingleLine',
					outFields: [ 'Addr_type' ],
					name: 'ArcGIS World Geocoding Service',
					zoomScale: 150000,
					resultSymbol: {
						type: 'picture-marker', // autocasts as new PictureMarkerSymbol()
						url: themeUrl + '/images/icon_location.png',
						size: 24,
						width: 24,
						height: 34,
						xoffset: 0,
						yoffset: 0
					},
					popupTemplate: {
						title: 'Hello'
					}
				}
			]
		});

		searchWidget.search();
	});
});
