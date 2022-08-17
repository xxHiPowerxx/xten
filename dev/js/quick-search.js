/**
* Xten Quick-Search script file.
*
* @package xten
* @author Ricky Adams
*/
/* global jQuery */
(function($, window, document) {

 "use strict";

	 // Theme vars.
	 var $window     = $(window),
		$body          = $('body'),
		$headerOuterEl = $('.header-wrapper');




	/**
	 * Throttle
	 *
	 */
	function throttle(callback, limit) {
		var waiting = false;
		return function() {
			if (!waiting) {
					callback.call();
					waiting = true;
					setTimeout(function () {
							waiting = false;
					}, limit);
			}
		}
	}

/**
	* Cursor position.
	*
	*/
	jQuery.fn.setCursorPosition = function (position) {

		if (this.length == 0) {
			return this;
		}
		return $(this).setSelection(position, position);
	};


	/**
	 * Modern quick search.
	 *
	 */
	function XTenQuickSearch() {

		this.$el        = $('#search-outer input[name="s"]');
		this.$container = '';
		this.$parent    = '';
		this.$searchEl  = $('#search-outer');
		this.$docBody   = $('body');
		this.request    = '';
		this.timeout    = '';
		this.setup();
		this.events();

		this.state = {
			requesting: false,
			open: false,
			prevResults: ''
		}

		this.minChars = 2;

	}


	XTenQuickSearch.prototype.setup = function() {
		this.$container = $('<div class="xten-ajax-search-results"></div>');
		this.$parent = $('#search-outer');
		this.$parent.append(this.$container);
	};

	XTenQuickSearch.prototype.events = function() {

		var that = this;

		this.throttled = throttle(this.getResults.bind(this),350);
		this.$el.on('keyup', this.keyHandle.bind(this) );

		$window.on('resize', this.resize.bind(this));
		$window.on('xten.search-close', function() {
			that.resetHeight();
			that.requestCheck();
		});

	};

	XTenQuickSearch.prototype.keyHandle = function(e) {

		// Verify Key.
		var keysToSkip = [16,91,32,37,39,17];

		if( keysToSkip.indexOf(e.keyCode) != -1 ) {
			return;
		}

		this.throttled();
		this.debouncedSearch();

	};

	XTenQuickSearch.prototype.debouncedSearch = function() {

		var that = this;

		clearTimeout(this.timeout);
		this.timeout = setTimeout(function(){
			if(that.state.requesting) {
				return;
			}
			that.getResults();
		},400);

	};


	XTenQuickSearch.prototype.resize = function() {
		this.$container.css({
			'max-height': ''
		});

		if( this.state.open === true ) {
			var maxHeight = window.innerHeight - parseFloat( this.$container[0].getBoundingClientRect().top, 2 ) + 'px';
			this.$container.css({
				'max-height': maxHeight,
			});
		}

	};

	XTenQuickSearch.prototype.resetHeight = function() {

		var that = this;

		this.$container.css({
			'max-height': ''
		});

		setTimeout(function(){
			$headerOuterEl.removeClass('results-shown');
		},400);

		this.state.prevResults = '';
		this.state.open = false;
	};


	XTenQuickSearch.prototype.requestCheck = function() {

		if( this.state.requesting === true ) {
			this.request.abort();
			this.state.requesting = false;
		}

	};

	XTenQuickSearch.prototype.getResults = function() {
		var that = this;
		var val = this.$el.val();

		// Deleted all chars / too few chars.
		if( val.length == 0 || val.length < this.minChars ) {
			$headerOuterEl.removeClass('results-shown');
			this.requestCheck();
			this.resetHeight();
			return;
		}

		this.request = $.ajax({
				type: 'POST',
				url: window.xtenMagic.ajaxurl,
				data: {
					action: "xten_ajax_ext_search_results",
					// action: "wp_ajax_xten_ajax_ext_search_results",
					search: val
				},
				cache: false,
				success: function (response) {
					that.state.requesting = false;

					// No results.
					if( !response ) {
						that.resetHeight();
					}
					if(
						response &&
						response.content &&
						response.content !== that.state.prevResults &&
						that.$docBody.hasClass('search-open')
					) {

						that.$container.html(response.content);

						// that.$parent.css({
						// 	'max-height': parseInt(that.$container.outerHeight()) + 'px'
						// });

						setTimeout(function(){
							$headerOuterEl.addClass('results-shown');
						},200);

						// Desktop animation
						if( window.innerWidth >= 1000 && !$headerOuterEl.hasClass('results-shown') ) {

							that.$container.find('.product, .listed-search-result').css({
								'opacity': '0',
								'transform': 'translateY(25px)',
								'transition': 'none'
							});

							setTimeout(function(){
								var transitionSpeed = 'cubic-bezier(0.2, 0.6, 0.4, 1)';
								that.$container.find('.product, .listed-search-result').css({
									'transition': 'box-shadow 0.25s ease, opacity 0.55s ' + transitionSpeed + ', transform 0.55s ' + transitionSpeed
								});
							},50);

							var $items = that.$container.find('.product, .listed-search-result'),
								totalItems = $items.length;
							$items.each(function(i) {
								var $that = $(this);
								setTimeout(function(){
									$that.css({
										'opacity': '1',
										'transform': 'translateY(0)'
									})
									if (i === totalItems - 1) {
										that.resize();
									}
								}, 50 + (i*60));
							});

						}
						that.state.open = true;
						that.state.prevResults = response.content;

					}

				}

		});

		this.state.requesting = true;

	};




	/**
	 * Search in navigation functionality.
	 *
	 */

	function navigationSearchInit() {

		// Init quick search.
		var quickSearch = new XTenQuickSearch();

		// Called to hide the search bar.
		// TODO: Make sure closeSearch can be targetted to a single search when there are multiple searches on page.
		function closeSearch() {
			var closeTimeoutDur = ($headerOuterEl.hasClass('results-shown')) ? 800 : 400;
			$window.trigger('xten.search-close');
			setTimeout(function(){
				$('#search-outer input[name="s"]').val('');
			},closeTimeoutDur);
		}

		// Close search btn event.
		function closeSearchOnCloseSearchClick() {
			$('.close-search').on('click', function () {
				closeSearch();
				return false;
			});
		}
		closeSearchOnCloseSearchClick();

		function closeSearchOnEscape() {
			$(document).on('keyup', function (e) {
				if (e.keyCode == 27) {
					closeSearch();
				}
			});
		}
		closeSearchOnEscape();
	}


	// Document ready event - starting everything up.
	jQuery(document).ready(function ($) {
		navigationSearchInit();
	});

}(window.jQuery, window, document));