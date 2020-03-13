/**
 * Main JS.
 *
 * Main JS scripts.
 *
 * @since 1.0.0
 */

jQuery(document).ready(function($) {
	// Local Variables.
	var windowLoaded = false;

	function detectMac() {
		if (-1 != navigator.userAgent.indexOf("Mac OS X")) {
			$("body").addClass("mac");
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
				$("body").addClass("edge");
			} else {
				$("body").addClass("ie");
			}
			return true;
		}
	}

	function detectIOS() {
		var userAgent = navigator.userAgent || navigator.vendor || window.opera;
		if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
			$("body").addClass("ios");
			return "iOS";
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
		if (0 < $(".sizeContent").length) {
			headerHeight = $("#masthead").outerHeight();
			colophon = $("#colophon");
			minHeight =
				$(window).outerHeight() -
				headerHeight -
				colophon.outerHeight(true);
			if (0 < $("#wpadminbar:visible").length) {
				minHeight += -$("#wpadminbar").outerHeight();
			}
			$(".sizeContent").css("min-height", minHeight);
		}
	}

	/**
	 * Show alerts that have not been closed and stored in cookies.
	 */
	function alerts() {
		$(".xten-alert").each(function(index) {
			var alertID = $(this).data("alert-id");
			var alertCookie = Cookies.get("alert-" + alertID);

			if (!alertCookie) {
				$(this).show();
			}
		});

		$(".xten-alert .close").click(function(e) {
			var alertID = $(this)
				.closest(".xten-alert")
				.data("alert-id");
			var session = $(this)
				.closest(".xten-alert")
				.data("alert-persist-sessions");

			if (session) {
				Cookies.set("alert-" + alertID, "closed");
			} else {
				Cookies.set("alert-" + alertID, "closed", { expires: 365 });
			}
		});
	}

	function readyFuncs() {
		detectPlatform();
		sizeContent();
		alerts();
	}

	/**
	 * Fire Resize functions a second time to adjust for browser repaint.
	 */
	function redundantResize(func, time) {
		setTimeout(function() {
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
		}
		return (windowLoaded = true);
	}

	// Fire Load Functions if 10 seconds have passed from script load. (for slow connections).
	setTimeout(function() {
		loadFuncs();
	}, 10000);

	readyFuncs();
	$(window)
		.resize(function() {
			resizeFuncs();
		})
		.on("load", function() {
			loadFuncs();
		});
});

function handleFirstTab(e) {
	if (9 === e.keyCode) {
		document.body.classList.add("user-is-tabbing");

		window.removeEventListener("keydown", handleFirstTab);
		window.addEventListener("mousedown", handleMouseDownOnce);
	}
}

function handleMouseDownOnce() {
	document.body.classList.remove("user-is-tabbing");

	window.removeEventListener("mousedown", handleMouseDownOnce);
	window.addEventListener("keydown", handleFirstTab);
}

window.addEventListener("keydown", handleFirstTab);
