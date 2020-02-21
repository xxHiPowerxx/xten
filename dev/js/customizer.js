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
})(jQuery);
