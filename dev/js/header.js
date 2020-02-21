/* eslint-disable vars-on-top */
/**
 * Mobile Nav JS.
 *
 * Mobile Nav JS scripts.
 *
 * @since 1.0.0
 */

jQuery(document).ready(function($) {
	$("nav#nav-mega-menu").accessibleMegaMenu({
		// update with desktop nav
		/* prefix for generated unique id attributes, which are required
		   to indicate aria-owns, aria-controls and aria-labelledby */
		uuidPrefix: "accessible-megamenu",

		/* css class used to define the megamenu styling */
		menuClass: "nav-menu",

		/* css class for a top-level navigation item in the megamenu */
		topNavItemClass: "top-nav-item",

		/* css class for a megamenu panel */
		panelClass: "sub-nav",

		/* css class for a group of items within a megamenu panel */
		panelGroupClass: "sub-nav-group",

		/* css class for the hover state */
		hoverClass: "hover",

		/* css class for the focus state */
		focusClass: "focus",

		/* css class for the open state */
		openClass: "open",
		openOnMouseover: true
	});

	// Redirects to Top Level Mega Menu Link on Dektop.
	$("body.desktop .top-nav-item a").click(function() {
		if ($(this).attr("href")) {
			window.location.href = $(this).attr("href");
		}
	});

	$(".xten-header-translate .ctnr-translate").on("click", function() {
		$("#google_translate_element .goog-te-gadget-simple").trigger("click");
	});

	$(".main-navigation ul ul li").hover(function() {
		$("ul.overflowing").removeClass("overflowing");
	});

	$(".main-navigation li").hover(function() {
		$(".main-navigation .sub-menu").each(function() {
			var bound = HorizontallyBound($("#page-wrapper"), $(this));
			if (!bound) {
				$(this).addClass("overflowing");
			}
		});
	});

	function HorizontallyBound($parentDiv, $childDiv) {
		var parentRect = $parentDiv[0].getBoundingClientRect();
		var childRect = $childDiv[0].getBoundingClientRect();
		return parentRect.right >= childRect.right;
	}

	// Prevent Hash update on Menu Item Dead Links
	$('.menu-item > a[href="#"], .page-item > a[href="#"]').on(
		"click",
		function(e) {
			e.preventDefault();
			$(this).blur();
		}
	);

	// Search Toggler
	$(".header-search-toggle").on("click", function() {
		if ("false" === $(this).attr("aria-expanded")) {
			setTimeout(function() {
				$(".header-search-toggle .fas").addClass("fa-times");
				$("body").addClass("search-open");
			});
			setTimeout(function() {
				$(".header-search-wrapper .search-field").focus();
			}, 100);
		} else {
			$(".header-search-toggle .fas").removeClass("fa-times");
			$("body").removeClass("search-open");
		}
	});

	// Sub Menu Open Animation sub-menu-toggler
	$("#mobile-menu .menu-item .sub-menu").on("show.bs.collapse", function() {
		var parent = $(this).parentsUntil("a");
		$(parent).addClass("isShowing");
	});

	$("#mobile-menu .menu-item .sub-menu").on("hide.bs.collapse", function() {
		var parent = $(this).parentsUntil("a");
		$(parent).removeClass("isShowing");
	});

	// Close Search Toggler
	$("body").on("click", function(e) {
		if (0 === $(e.target).closest(".header-search").length) {
			$(".header-search-toggle").attr("aria-expanded", "false");
			$(".header-search-toggle .fas").removeClass("fa-times");
			$(".header-search").collapse("hide");
			$(this).removeClass("search-open");
		}
	});

	$(".close-layer").on("click", function(e) {
		if (
			0 === $(e.target).closest(".mobile-sidebar").length &&
			$("html").is(".nav-open")
		) {
			$(".mobile-toggler")
				.removeClass("open")
				.attr("aria-expanded", "false");
			$("html").removeClass("nav-open");
		}
	});

	$(".mobile-toggler").on("click", function() {
		if ($(".mobile-toggler").hasClass("open")) {
			$(".mobile-toggler")
				.removeClass("open")
				.attr("aria-expanded", "false");
			$("html").removeClass("nav-open");
			return;
		}
		$(this)
			.addClass("open")
			.attr("aria-expanded", "true");
		$("html").addClass("nav-open");
		$(".mobile-sidebar").removeClass("mobile-sidebar-closed");
		$("#mobile-nav-close").focus();
	});

	$(".mobile-sidebar").on(
		"webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
		function() {
			if (!$("html").is(".nav-open")) {
				$(this).addClass("mobile-sidebar-closed");
			}
		}
	);

	function activateMobileMenu() {
		var wrapper = $("#menu-wrapper");
		var breakPoint = wrapper.attr("data-mobile-nav-breakpoint");
		var windowWidth = window.innerWidth;
		var activeClassName = "xten-mobile-menu-active";
		var inactiveClassName = "xten-mobile-menu-inactive";

		if (windowWidth <= breakPoint) {
			wrapper.addClass(activeClassName);
			wrapper.removeClass(inactiveClassName);
			$("#google_translate_element")
				.detach()
				.appendTo(".mobile-translate");
		} else {
			wrapper.removeClass(activeClassName);
			wrapper.addClass(inactiveClassName);
			$("#google_translate_element")
				.detach()
				.appendTo(".desktop-translate");
		}
	}

	function readyFuncs() {
		activateMobileMenu();
	}

	function resizeFuncs() {
		activateMobileMenu();
	}

	readyFuncs();
	$(window).resize(function() {
		resizeFuncs();
	});
});
