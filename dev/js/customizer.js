/* eslint-disable vars-on-top */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
	var rootDir = wpScriptVars.themeDirectory;

	// Utility function to convert Hex to rgb.
	function hexToRgb(hex) {
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ?
			parseInt(result[1], 16) +
				',' +
				parseInt(result[2], 16) +
				',' +
				parseInt(result[3], 16)
			: null;
	}
	// Utitliy Function to Give Correct rgb or rgba string.
	function convertHextToRgba(hex, a) {
		var rgb = hexToRgb(hex),
		rgbA = 'rgb',
		rgbVal = rgb,
		a = a * .01;
		if ( a < 1 ) {
			rgbA += 'a';
			rgbVal += ',' + a;
		}
		return rgbA + '(' + rgbVal + ')';
	}
	// Utility function to handle color update on Color Value Update or Opacity Value Update
	function handleColorUpdate(that, unprovidedValHandle) {
		var providedVal = that._value,
		hex,
		opacity;
		if (parseInt(that._value)) {
			hex = wp.customize(unprovidedValHandle)._value;
			opacity = providedVal;
		} else {
			hex = providedVal;
			opacity = wp.customize(unprovidedValHandle)._value;
		}
		return convertHextToRgba(hex, opacity);
	}

	// Site title and description.
	wp.customize("blogname", function(value) {
		value.bind(function(to) {
			$(".site-title a").text(to);
		});
	});
	wp.customize("blogdescription", function(value) {
		value.bind(function(to) {
			$(".site-description").text(to);
		});
	});

	// Header Background Color.
	var headerSelector = '.site-header, .mobile-sidebar-top';
	wp.customize("xten_header_bg_color", function(value) {
		value.bind(function(to) {
			var color = 'transparent';
			if ("blank" !== to) {
				 color = handleColorUpdate(this, "xten_header_bg_color_opacity");
			}
			$(headerSelector).css({
				"background-color": color
			});
		});
	});
	// /Header Background Color.

	// Header Background Color Opacity.
	wp.customize("xten_header_bg_color_opacity", function(value) {
		value.bind(function(to) {
			var color = 'transparent';
			if ("blank" !== to) {
				 color = handleColorUpdate(this, "xten_header_bg_color_opacity");
			}
			$(headerSelector).css({
				"background-color": color
			});
		});
	});
	// /Header Background Color Opacity.

	// Header Menu Item Color.
	var headerMenuItemSelector = '.header-search-toggle i, .main-navigation>ul>li>a, .main-navigation>ul>li>span.dropdown,.mobile-toggler';
	wp.customize("xten_header_menu_item_color", function(value) {
		value.bind(function(to) {
			var color = 'transparent';
			if ("blank" !== to) {
				 color = handleColorUpdate(this, "xten_header_menu_item_color");
			}
			$(headerMenuItemSelector).css({
				"color": color
			});
		});
	});
	// /Header Menu Item Color.

	// // Header Sub-Menu Background Color.
	var headerSubMenuSelector = '.main-navigation .sub-menu a';
	wp.customize("xten_header_sub_menu_bg_color", function(value) {
		value.bind(function(to) {
			var color = 'transparent';
			if ("blank" !== to) {
				 color = handleColorUpdate(this, "xten_header_sub_menu_bg_color_opacity");
			}
			$(headerSubMenuSelector).css({
				"background-color": color
			});
		});
	});
	// /Header Sub-Menu Background Color.

	//  Header Sub-Menu Background Color Opacity
	wp.customize("xten_header_bg_color_opacity", function(value) {
		value.bind(function(to) {
			var color = 'transparent';
			if ("blank" !== to) {
				 color = handleColorUpdate(this, "xten_header_bg_color_opacity");
			}
			$(headerSubMenuSelector).css({
				"background-color": color
			});
		});
	});
	//  Header Sub-Menu Background Color Opacity.

	// Header Sub-Menu Item Color.
	var headerSubMenuItemSelector = '.main-navigation .sub-menu a';
	wp.customize("xten_header_sub_menu_item_color", function(value) {
		value.bind(function(to) {
			var color = 'transparent';
			if ("blank" !== to) {
				 color = handleColorUpdate(this, "xten_header_sub_menu_item_color");
			}
			$(headerSubMenuItemSelector).css({
				"color": color
			});
		});
	});
	// Header Sub-Menu Item Color.

	// Header text color.
	wp.customize("header_textcolor", function(value) {
		value.bind(function(to) {
			if ("blank" === to) {
				$(".site-title, .site-description").css({
					clip: "rect(1px, 1px, 1px, 1px)",
					position: "absolute"
				});
			} else {
				$(".site-title, .site-description").css({
					clip: "auto",
					position: "relative"
				});
				$(".site-title a, .site-description").css({
					color: to
				});
			}
		});
	});

	// Footer color.
	wp.customize("footer_background_color", function(value) {
		value.bind(function(to) {
			if ("blank" !== to) {
				$(".main-footer-wrapper").css({
					"background-color": to
				});
			}
		});
	});

	// Fonts
	// Font Pairings
	var themeFontPairing = "font_pairings";
	wp.customize(themeFontPairing, function(value) {
		value.bind(function(to) {
			var fontPairings = JSON.parse(to);
			var headingPath = fontPairings.heading;
			var bodyPath = fontPairings.body;
			var styleTagId = $("#" + themeFontPairing);
			if (0 === styleTagId.length) {
				var styleTag =
					'<style type="text/css" id="' + themeFontPairing + '">';
				$("head").append(styleTag);
			}

			if (
				"playfairdisplay" == headingPath ||
				("merriweather" == headingPath && "sourcesanspro" == bodyPath)
			) {
				var fontWeight = "-black.ttf";
			} else {
				var fontWeight = "-bold.tff";
			}

			var style =
				"@font-face {" +
				"font-family:" +
				headingPath +
				";" +
				"src:url(" +
				rootDir +
				"/assets/fonts/" +
				headingPath +
				"/" +
				headingPath +
				fontWeight +
				");" +
				"}";
			style +=
				"@font-face {" +
				"font-family:" +
				bodyPath +
				";" +
				"src:url(" +
				rootDir +
				"/assets/fonts/" +
				bodyPath +
				"/" +
				bodyPath +
				".ttf);" +
				"}";

			styleTagId.html(style);

			$("h1,h2,h3,.xten-highlight-font").css({
				"font-family": headingPath,
				"font-weight": "bold"
			});

			$("h4, h5, h6, body, p").css({
				"font-family": bodyPath
			});
		});
	});
})(jQuery );
