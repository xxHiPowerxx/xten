var placeHolderImg,
	customLogo,
	nodeStyles = {},
	initalLoad = false,
	fixedHeader = document.getElementsByClassName("fixed-header"),
	siteHeader = document.getElementById("masthead"),
	docBody = document.body,
	hasScrolledPastHeader = false,
	hasScrolledPastAdminBar = false;

// Modify Custom Logo
function createPlaceHolderImg(elem) {
	var imgWidth = elem.getAttribute("width");
	var imgHeight = elem.getAttribute("height");

	var maxWidth = parseFloat(
		window
			.getComputedStyle(document.getElementsByClassName("custom-logo")[0])
			.getPropertyValue("max-width")
	);
	var maxHeight = parseFloat(
		window
			.getComputedStyle(document.getElementsByClassName("custom-logo")[0])
			.getPropertyValue("max-height")
	);
	var paddingBottom;
	// paddingBottom = (imgHeight / imgWidth) * 100 + "%";

	placeHolderImg = document.createElement("DIV");

	nodeStyles = {
		elemNode: {
			position: elem.style.position ? elem.style.position : ""
		},
		parentNode: {
			position: elem.parentElement.style.position
				? elem.parentElement.style.position
				: "",
			width: elem.parentElement.style.position
				? elem.parentElement.style.position
				: ""
		}
	};

	// placeHolderImg.style.paddingBottom = paddingBottom;
	placeHolderImg.style.width = imgWidth + "px";
	placeHolderImg.style.height = imgHeight + "px";
	placeHolderImg.style.position = "relative";
	placeHolderImg.style.display = "block";

	placeHolderImg.setAttribute(
		"class",
		"logo-placeholder " + elem.getAttribute("class")
	);
	elem.style.position = "absolute";

	elem.parentElement.style.position = "relative";
	elem.parentElement.style.maxHeight = maxHeight + "px";
	elem.parentElement.style.width = "100%";
	elem.parentElement.appendChild(placeHolderImg);
}

function sizeHeaderPad() {
	var sizeHeaderRef;
	var sizeHeaderPad;
	var sizeHeaderRefClone;
	var sizeHeaderRefCloneShrink;
	var navShrink;
	var parentElem;
	sizeHeaderRef = document.getElementsByClassName("sizeHeaderRef")[0];
	sizeHeaderPad = document.getElementsByClassName("sizeHeaderPad");

	if (0 < sizeHeaderPad.length) {
		sizeHeaderRefClone = sizeHeaderRef.cloneNode(true);
		sizeHeaderRefClone.style.visibility = "hidden";
		sizeHeaderRefClone.style.position = "absolute";

		customLogo = sizeHeaderRefClone.getElementsByClassName("custom-logo");

		if (0 < customLogo.length) {
			createPlaceHolderImg(customLogo[0]);
		}

		sizeHeaderRefClone.classList.add("sizeHeaderRefClone");
		docBody.appendChild(sizeHeaderRefClone);

		window.siteHeaderHeight =
			(734 >= window.innerWidth
				? sizeHeaderRefClone.getBoundingClientRect().height.toFixed(3)
				: sizeHeaderRefClone
						.getBoundingClientRect()
						.height.toFixed(3)) + "px";

		sizeHeaderPad[0].style.paddingTop = window.siteHeaderHeight;
		parentElem = sizeHeaderRefClone.parentElement;
		if (parentElem !== undefined) {
			// parentElem.removeChild(sizeHeaderRefClone);
		}
	}
}

function compensateForAdminBar() {
	var adminBar = document.getElementById("wpadminbar");
	if (adminBar) {
		// eslint-disable-next-line vars-on-top
		var adminBarRect = adminBar.getBoundingClientRect(),
			siteHeadOffSetTop = adminBarRect.top,
			adminBarHeight = adminBarRect.height + siteHeadOffSetTop,
			html = document.documentElement,
			headerWrapper = document.getElementsByClassName(
				"header-wrapper"
			)[0],
			pageWrapper = document.getElementsByClassName("page-wrapper")[0],
			adminBarPosition = getComputedStyle(adminBar).position,
			mobileMenu = document.getElementsByClassName("mobile-sidebar")[0];
		if (fixedHeader[0]) {
			if (
				true === hasScrolledPastAdminBar &&
				"absolute" === adminBarPosition
			) {
				fixedHeader[0].style.top = "";
			} else {
				fixedHeader[0].style.top = adminBarHeight + "px";
			}
		}
		html.setAttribute("style", "margin-top: 0px !important;");

		// Only siteHeader is not .new-site-header
		// When Admin Bar is not fixed, we need to push the header-wrapper and page-wrapper down.
		// eslint-disable-next-line vars-on-top
		var optimalStyleTop = 0 < adminBarHeight ? adminBarHeight : 0;
		headerWrapper.style.top = optimalStyleTop + "px";
		pageWrapper.style.top = optimalStyleTop + "px";
		siteHeader.style.top = "";

		// Ensure that mobile menu compensates for Admin Bar
		// when position is absolute and not scrolled past Admin Bar
		if (mobileMenu) {
			if (
				"absolute" === adminBarPosition &&
				false === hasScrolledPastAdminBar
			) {
				mobileMenu.style.top = optimalStyleTop + "px";
			} else {
				mobileMenu.style.top = "";
			}
		}
	}
}

// AdminBar is created AFTER this file runs.
function listenForAdminBar() {
	// select the target node
	// var target = document.getElementById( 'wpadminbar' );
	var target = docBody,
		hasAdminBar = target.classList.contains("admin-bar");

	if (hasAdminBar) {
		// create an observer instance
		// eslint-disable-next-line vars-on-top
		var observer = new MutationObserver(function(mutations) {
			// eslint-disable-next-line vars-on-top
			for (var i = 0; i < mutations.length; i++) {
				// eslint-disable-next-line vars-on-top
				var mutation = mutations[i];
				// eslint-disable-next-line vars-on-top
				var addedNodes = mutation.addedNodes;
				// eslint-disable-next-line vars-on-top
				for (var n = 0; n < addedNodes.length; n++) {
					// eslint-disable-next-line vars-on-top
					var addedNode = addedNodes[n];
					if ("wpadminbar" === addedNode.id) {
						// remove observer when wpadminbar is found.
						this.disconnect();
						compensateForAdminBar();
					}
				}
			}
		});

		// configuration of the observer:
		// eslint-disable-next-line vars-on-top
		var config = {
			attributes: true,
			childList: true,
			characterData: true
		};

		// Start the Observer.
		observer.observe(target, config);
	}
}

function readyFuncs() {
	sizeHeaderPad();
	listenForAdminBar();
}
readyFuncs();

function resizeFuncs() {
	compensateForAdminBar();
	sizeHeaderPad();
}

function onReady(func) {
	if ("ready" === document.readyState || "complete" === document.readyState) {
		func();
	} else {
		document.onreadystatechange = function() {
			if ("complete" == document.readyState) {
				func();
			}
		};
	}
}
onReady(readyFuncs);

window.addEventListener("resize", resizeFuncs);
