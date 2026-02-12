/**
 * Custom Zoom Gallery - GSAP ScrollTrigger
 * Images stacked front-to-back; scroll scales up + fades out the front image.
 */

(function () {
	'use strict';

	gsap.registerPlugin(ScrollTrigger);

	/**
	 * Zoom Gallery Controller
	 */
	class EpwZoomGalleryController {
		constructor(container) {
			this.container = container;
			this.inner = container.querySelector('.epw-zoom-inner');
			this.items = gsap.utils.toArray(container.querySelectorAll('.epw-zoom-item'));

			if (this.items.length < 2) {
				return;
			}

			// Read config from data attribute
			const configAttr = container.getAttribute('data-gallery-config');
			this.config = configAttr ? JSON.parse(configAttr) : {};
			this.config.scrub = this.config.scrub !== false;
			this.config.pin = this.config.pin !== false;
			this.config.scaleStart = this.config.scaleStart || 1;
			this.config.scaleEnd = this.config.scaleEnd || 2.5;
			this.config.fadeStart = this.config.fadeStart || 0.6;

			// Respect reduced motion
			if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
				this.setupReducedMotion();
				return;
			}

			this.init();
		}

		init() {
			const itemCount = this.items.length;
			const { scaleStart, scaleEnd, fadeStart, scrub, pin } = this.config;

			// Set initial state: all items stacked, first on top
			this.items.forEach((item, i) => {
				gsap.set(item, {
					scale: scaleStart,
					opacity: 1,
					zIndex: itemCount - i
				});
			});

			// Create ScrollTrigger timeline
			const scrollDistance = (itemCount - 1) * 100; // vh units

			const tl = gsap.timeline({
				scrollTrigger: {
					trigger: this.container,
					start: 'top top',
					end: '+=' + (scrollDistance * window.innerHeight / 100),
					scrub: scrub ? 1 : false,
					pin: pin ? this.inner : false,
					anticipatePin: 1,
					invalidateOnRefresh: true,
				}
			});

			// Animate each item except the last (it just stays visible)
			this.items.forEach((item, i) => {
				if (i === itemCount - 1) return; // Last item stays

				const position = i / (itemCount - 1);
				const duration = 1 / (itemCount - 1);

				// Scale up and fade out
				tl.to(item, {
					scale: scaleEnd,
					opacity: 0,
					duration: duration,
					ease: 'none',
				}, position);
			});
		}

		setupReducedMotion() {
			// Show only first image, hide others
			this.items.forEach((item, i) => {
				if (i > 0) {
					gsap.set(item, { opacity: 0 });
				}
			});
		}

		destroy() {
			ScrollTrigger.getAll().forEach(st => {
				if (st.trigger === this.container) {
					st.kill();
				}
			});
		}
	}

	/**
	 * Initialize all Zoom Gallery instances
	 */
	function initEpwZoomGalleries() {
		const containers = document.querySelectorAll('.epw-zoom-container');
		containers.forEach(container => {
			new EpwZoomGalleryController(container);
		});
	}

	// Initialize
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initEpwZoomGalleries);
	} else {
		initEpwZoomGalleries();
	}

	// Elementor support
	if (typeof window.elementorFrontend !== 'undefined' && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/zoom-gallery.default', function ($scope) {
			const container = $scope[0].querySelector('.epw-zoom-container');
			if (container) {
				new EpwZoomGalleryController(container);
			}
		});
	}

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction('frontend/element_ready/zoom-gallery.default', function ($scope) {
					const container = $scope[0].querySelector('.epw-zoom-container');
					if (container) {
						new EpwZoomGalleryController(container);
					}
				});
			}
		});
	}

})();
