/**
 * Main JS.
 *
 * Main JS scripts.
 *
 * @since 1.0.0
 */
(function hideSplash() {
	setTimeout(function () {
		var loadSplash = document.getElementById('load-splash'),
			keyDownHandler = function () {
				loadSplash.classList.add('hiding');
				this.removeEventListener('keydown', keyDownHandler, false);
			};
		if (loadSplash) {
			loadSplash.addEventListener('click', function () {
				this.classList.add('hiding');
			});
			window.addEventListener('keydown', keyDownHandler, false);
		}
	});
}());
(function ($) {
	$(document).ready(function () {

		// Local Variables.
		var windowLoaded = false,
			$body = $('body'),
			transitionEndEvent = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',
			$loadSplash = $('#load-splash'),
			loadSplash = $loadSplash[0] || null;
			window.mouseDetected = window.mouseDetected || false;

		function detectMouse() {
			function checkPointer(mediaQueryItem) {
				if (mediaQueryItem.matches) {
					window.mouseDetected = true;
					$body.addClass('mouse-detected');
					$(window).trigger('mouseDetected');
				} else {
					window.mouseDetected = false;
					$body.removeClass('mouse-detected');
					$(window).trigger('mouseUndetected');
				}
				return mediaQueryItem;
			}
			var mediaRule = window.matchMedia('(pointer:fine)');
			checkPointer(mediaRule);
			mediaRule.addEventListener('change', function(){
				checkPointer(this);
			});
		};

		function detectBrowser() {
			function detectBrowserCore() {
				"use strict";
		
				var module = {
					options: [],
					header: [
						navigator.platform,
						navigator.userAgent,
						navigator.appVersion,
						navigator.vendor,
						window.opera,
					],
					dataos: [
						{ name: "Windows Phone", value: "Windows Phone", version: "OS" },
						{ name: "Windows", value: "Win", version: "NT" },
						{ name: "iPhone", value: "iPhone", version: "OS" },
						{ name: "iPad", value: "iPad", version: "OS" },
						{ name: "Kindle", value: "Silk", version: "Silk" },
						{ name: "Android", value: "Android", version: "Android" },
						{ name: "PlayBook", value: "PlayBook", version: "OS" },
						{ name: "BlackBerry", value: "BlackBerry", version: "/" },
						{ name: "Macintosh", value: "Mac", version: "OS X" },
						{ name: "Linux", value: "Linux", version: "rv" },
						{ name: "Palm", value: "Palm", version: "PalmOS" },
					],
					databrowser: [
						{ name: "Chrome", value: "Chrome", version: "Chrome" },
						{ name: "Firefox", value: "Firefox", version: "Firefox" },
						{ name: "Safari", value: "Safari", version: "Version" },
						{ name: "Internet Explorer", value: "MSIE", version: "MSIE" },
						{ name: "Opera", value: "Opera", version: "Opera" },
						{ name: "BlackBerry", value: "CLDC", version: "CLDC" },
						{ name: "Mozilla", value: "Mozilla", version: "Mozilla" },
					],
					init: function () {
						var agent = this.header.join(" "),
							os = this.matchItem(agent, this.dataos),
							browser = this.matchItem(agent, this.databrowser);

						return { os: os, browser: browser };
					},
					matchItem: function (string, data) {
						var i = 0,
							j = 0,
							html = "",
							regex,
							regexv,
							match,
							matches,
							version;

						for (i = 0; i < data.length; i += 1) {
							regex = new RegExp(data[i].value, "i");
							match = regex.test(string);
							if (match) {
								regexv = new RegExp(data[i].version + "[- /:;]([\\d._]+)", "i");
								matches = string.match(regexv);
								version = "";
								if (matches) {
									if (matches[1]) {
										matches = matches[1];
									}
								}
								if (matches) {
									matches = matches.split(/[._]+/);
									for (j = 0; j < matches.length; j += 1) {
										if (j === 0) {
											version += matches[j] + ".";
										} else {
											version += matches[j];
										}
									}
								} else {
									version = "0";
								}
								return {
									name: data[i].name,
									version: parseFloat(version),
								};
							}
						}
						return { name: "unknown", version: 0 };
					},
				};

				var e = module.init(),
					debug = "";
/*
				debug += "os.name = " + e.os.name + "\n";
				debug += "os.version = " + e.os.version + "\n";
				debug += "browser.name = " + e.browser.name + "\n";
				debug += "browser.version = " + e.browser.version + "\n";
		
				debug += "\n";
				debug += "navigator.userAgent = " + navigator.userAgent + "\n";
				debug += "navigator.appVersion = " + navigator.appVersion + "\n";
				debug += "navigator.platform = " + navigator.platform + "\n";
				debug += "navigator.vendor = " + navigator.vendor + "\n";

				// console.log("debug", debug);
*/
				return e;
			}

			/**
			 * detect IEEdge
			 * returns version of IE/Edge or false, if browser is not a Microsoft browser
			 */
			function detectIEEdge() {
				var ua = window.navigator.userAgent,
					msie = ua.indexOf("MSIE "),
					trident = ua.indexOf("Trident/");
				if (msie > 0 || trident > 0) {
					// IE 10 or older => return version number ||
					// IE 11 => return version number
					return true;
				}
				// other browser
				return false;
			}

			var html = $("html"),
				machine = detectBrowserCore(),
				browserOsClass = "browser-os-" + machine.os.name.replace(/\s+/g, "-").toLowerCase(),
				browserNameClass;
			if (detectIEEdge()) {
				browserNameClass = "browser-name-ie";
			} else {
				browserNameClass = "browser-name-" + machine.browser.name.replace(/\s+/g, "-").toLowerCase();
			}
			html.addClass(browserNameClass).addClass(browserOsClass);

			return machine;
		}

		/**
		 * Set min-height on .content-wrapper so that at minimum the Footer stretches to the bottom.
		 */
		function sizeContent() {
			var minHeight;
			var headerHeight;
			var colophon;
			if (0 < $('.sizeContent').length) {
				headerHeight = $('#masthead').outerHeight();
				colophon = $('#colophon');
				minHeight =
					$(window).outerHeight() -
					headerHeight -
					colophon.outerHeight(true);
				if (0 < $('#wpadminbar:visible').length) {
					minHeight += -$('#wpadminbar').outerHeight();
				}
				$('.sizeContent').css('min-height', minHeight);
			}
		}

		/**
		 * Show alerts that have not been closed and stored in cookies.
		 */
		function alerts() {
			$('.xten-alert').each(function (index) {
				var alertID = $(this).data('alert-id');
				var alertCookie = Cookies.get('alert-' + alertID);

				if (!alertCookie) {
					$(this).show();
				}
			});

			$('.xten-alert .close').click(function (e) {
				var alertID = $(this)
					.closest('.xten-alert')
					.data('alert-id');
				var session = $(this)
					.closest('.xten-alert')
					.data('alert-persist-sessions');

				if (session) {
					Cookies.set('alert-' + alertID, 'closed');
				} else {
					Cookies.set('alert-' + alertID, 'closed', { expires: 365 });
				}
			});
		}

		function hideLoadSplash() {
			function addHiding(elem) {
				elem.classList.add('hiding');
			}
			$(loadSplash).on(transitionEndEvent, function () {
				this.classList.remove('loading');
			});
			window.addEventListener('finishWork', function () {
				var workStarted = window.workStarted || {},
					workFinished = 0 === Object.keys(workStarted).length &&
						workStarted.constructor === Object;
				if (loadSplash && workFinished) {
					addHiding(loadSplash);
				}
			});
			// Remove Load Splash after 3s regardless of whether work is finished or not.
			setTimeout(addHiding(loadSplash), 3000);
		}
		function showLoadSplash() {
			$loadSplash.addClass('unloading');
			setTimeout(function () {
				$loadSplash.removeClass('hiding');
			});
		}
		function makeCollapseAccessible() {
			$('[data-toggle="collapse"]').on('keyup', function (e) {
				if (e.which === 13 || e.which === 32) {
					$(this).trigger('click');
				}
			});
		}

		// TODO: create a naming convention for this instead of (or in addition to)
		// finding SPECIFIC Link tags.
		// EG: var $linkTags = $('[id*="before-child"]')
		function movePreloadedLinkToPreloadLocation() {
			var $preloadTags = $('link[rel="preload"]');
			$preloadTags.each(function(){
				var thisId = $(this).attr('id'),
					styleSheetId = thisId.replace('preload', 'css'),
					$styleSheetTag = $('[id="' + styleSheetId + '"]');
				if ( $styleSheetTag.length ) {
					$styleSheetTag.detach().insertAfter($(this));
				}
			});
		}

		function readyFuncs() {
			detectBrowser();
			sizeContent();
			alerts();
			hideLoadSplash();
			detectMouse();
			makeCollapseAccessible();
			movePreloadedLinkToPreloadLocation();
		}

		/**
		 * Fire Resize functions a second time to adjust for browser repaint.
		 */
		function redundantResize(func, time) {
			setTimeout(function () {
				func;
			}, time);
		}

		function resizeFuncs() {
			sizeContent();
			redundantResize(sizeContent(), 1000);
		}

		function loadFuncs() {
			if (false === windowLoaded) {
				sizeContent();
				window.dispatchEvent(new CustomEvent('finishWork'));
			}
			return (windowLoaded = true);
		}

		// Fire Load Functions if 10 seconds have passed from script load. (for slow connections).
		setTimeout(function () {
			loadFuncs();
		}, 10000);

		readyFuncs();
		$(window)
			.resize(function () {
				resizeFuncs();
			})
			.on('load', function () {
				loadFuncs();
			})
			.on('beforeunload', function (event) {
				showLoadSplash(event);
			})
			.on('focus', function () {
				hideLoadSplash();
			});
	});

	function handleFirstTab(e) {
		if (9 === e.keyCode) {
			document.body.classList.add('user-is-tabbing');

			window.removeEventListener('keydown', handleFirstTab);
			window.addEventListener('mousedown', handleMouseDownOnce);
		}
	}

	function handleMouseDownOnce() {
		document.body.classList.remove('user-is-tabbing');

		window.removeEventListener('mousedown', handleMouseDownOnce);
		window.addEventListener('keydown', handleFirstTab);
	}

	window.addEventListener('keydown', handleFirstTab);

	// Polyfill for custom events.
	(function () {

		if ('function' === typeof window.CustomEvent) {
			return false;
		}

		function CustomEvent(event, params) {
			var evt = document.createEvent('CustomEvent');
			params = params || { bubbles: false, cancelable: false, detail: undefined };
			evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
			return evt;
		}

		CustomEvent.prototype = window.Event.prototype;

		window.CustomEvent = CustomEvent;
	}());
}(jQuery));
