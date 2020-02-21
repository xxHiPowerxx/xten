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
	// Main Nav Font Family
	var mainNavFF = "main_nav_font_family";
	wp.customize(mainNavFF, function(value) {
		value.bind(function(to) {
			if ("blank" !== to) {
				var fontFamily = JSON.parse(to),
					fontFamilyType = fontFamily.type,
					fontFamilyVal = fontFamily.value;
				if ("google" === fontFamilyType) {
					var path = fontFamilyVal,
						styleTagId = $("#" + mainNavFF);
					if (0 === styleTagId.length) {
						var styleTag =
							'<style type="text/css" id="' + mainNavFF + '">';
						$("head").append(styleTag);
					}
					var style =
						"@font-face {" +
						"font-family:" +
						fontFamilyVal +
						";" +
						"font-weight: 400;" +
						"src:url(" +
						rootDir +
						"/assets/fonts/" +
						path +
						"/" +
						path +
						".ttf);" +
						"}";
					styleTagId.html(style);
				}

				$(".main-navigation a").css({
					"font-family": fontFamilyVal
				});
			}
		});
	});

	// Mobile Nav Font Family
	var mobileNavFF = "mobile_nav_font_family";
	wp.customize(mobileNavFF, function(value) {
		value.bind(function(to) {
			if ("blank" !== to) {
				var fontFamily = JSON.parse(to),
					fontFamilyType = fontFamily.type,
					fontFamilyVal = fontFamily.value;
				if ("google" === fontFamilyType) {
					var path = fontFamilyVal,
						styleTagId = $("#" + mobileNavFF);
					if (0 === styleTagId.length) {
						var styleTag =
							'<style type="text/css" id="' + mobileNavFF + '">';
						$("head").append(styleTag);
					}
					var style =
						"@font-face {" +
						"font-family:" +
						fontFamilyVal +
						";" +
						"font-weight: 400;" +
						"src:url(" +
						rootDir +
						"/assets/fonts/" +
						path +
						"/" +
						path +
						".ttf);" +
						"}";
					styleTagId.html(style);
				}

				$("html .mobile-sidebar .menu li").css({
					"font-family": fontFamilyVal
				});
			}
		});
	});

	// Theme Font Family
	var themeFF = "theme_font_family";
	wp.customize(themeFF, function(value) {
		value.bind(function(to) {
			if ("blank" !== to) {
				var fontFamily = JSON.parse(to),
					fontFamilyType = fontFamily.type,
					fontFamilyVal = fontFamily.value;
				if ("google" === fontFamilyType) {
					var path = fontFamilyVal,
						styleTagId = $("#" + themeFF);
					if (0 === styleTagId.length) {
						var styleTag =
							'<style type="text/css" id="' + themeFF + '">';
						$("head").append(styleTag);
					}
					var style =
						"@font-face {" +
						"font-family:" +
						fontFamilyVal +
						";" +
						"font-weight: 400;" +
						"src:url(" +
						rootDir +
						"/assets/fonts/" +
						path +
						"/" +
						path +
						".ttf);" +
						"}" +
						"@font-face {" +
						"font-family:" +
						fontFamilyVal +
						";" +
						"font-weight: 700;" +
						"src:url(" +
						rootDir +
						"/assets/fonts/" +
						path +
						"/" +
						path +
						"-bold.ttf);" +
						"}";
					styleTagId.html(style);
				}

				$("body,button,input,optgroup,select,textarea").css({
					"font-family": fontFamilyVal
				});
			}
		});
	});

	// Theme Heading Font Family
	var themeHeadFF = "theme_heading_font_family";
	wp.customize(themeHeadFF, function(value) {
		value.bind(function(to) {
			console.log(to);
			if ("blank" !== to) {
				var fontFamily = JSON.parse(to),
					fontFamilyType = fontFamily.type,
					fontFamilyVal = fontFamily.value;
				if ("google" === fontFamilyType) {
					var path = fontFamilyVal,
						styleTagId = $("#" + themeHeadFF);
					if (0 === styleTagId.length) {
						var styleTag =
							'<style type="text/css" id="' + themeHeadFF + '">';
						$("head").append(styleTag);
					}
					var style =
						"@font-face {" +
						"font-family:" +
						fontFamilyVal +
						";" +
						"font-weight: 700;" +
						"src:url(" +
						rootDir +
						"/assets/fonts/" +
						path +
						"/" +
						path +
						"-bold.ttf);" +
						"}";
					styleTagId.html(style);
				}

				$("h1,h2,h3,h4,h5,h6,.xten-highlight-font").css({
					"font-family": fontFamilyVal
				});
			}
		});
	});

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
