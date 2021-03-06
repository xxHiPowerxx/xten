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
			loadSplash = $loadSplash[0];
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

		function detectMac() {
			if (-1 != navigator.userAgent.indexOf('Mac OS X')) {
				$body.addClass('browser-mac');
				return true;
			}
		}

		function detectIe() {
			if (
				/MSIE 10/i.test(navigator.userAgent) ||
				/MSIE 9/i.test(navigator.userAgent) ||
				/rv:11.0/i.test(navigator.userAgent) ||
				/Edge\/\d./i.test(navigator.userAgent)
			) {
				if (/Edge\/\d./i.test(navigator.userAgent)) {
					$body.addClass('browser-edge');
				} else {
					$body.addClass('browser-ie');
				}
				return true;
			}
		}

		function detectIOS() {
			var userAgent = navigator.userAgent || navigator.vendor || window.opera;
			if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
				$body.addClass('os-ios');
				return 'iOS';
			}
		}

		function detectPlatform() {
			detectMac();
			detectIe();
			detectIOS();
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

		function readyFuncs() {
			detectPlatform();
			sizeContent();
			alerts();
			hideLoadSplash();
			detectMouse();
			makeCollapseAccessible();
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
