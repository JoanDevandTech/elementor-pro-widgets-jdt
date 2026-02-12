/**
 * Polaroid Tabs - Simplified GSAP Carousel
 * 3-card carousel: previous, active, next
 */

(function () {
	'use strict';

	/**
	 * Initialize all Polaroid Tabs instances
	 */
	function initEpwTabs() {
		const containers = document.querySelectorAll('.epw-tabs-container');
		containers.forEach(container => {
			new EpwTabsController(container);
		});
	}

	/**
	 * EPW Tabs Controller
	 */
	class EpwTabsController {
		constructor(container) {
			this.container = container;
			this.buttons = container.querySelectorAll('.epw-tab-button');
			this.cards = gsap.utils.toArray(container.querySelectorAll('.epw-polaroid'));
			this.currentIndex = 0;

			if (this.cards.length === 0) {
				return;
			}

			this.init();
		}

		init() {
			// Set initial state - all cards hidden
			gsap.set(this.cards, {
				xPercent: 300,
				opacity: 0,
				scale: 0.7,
				zIndex: 0
			});

			// Tab buttons control carousel
			this.buttons.forEach((button, index) => {
				button.addEventListener('click', () => {
					this.switchToTab(index);
				});
			});

			// Keyboard navigation
			this.buttons.forEach((button, index) => {
				button.addEventListener('keydown', (e) => {
					let newIndex = index;

					switch (e.key) {
						case 'ArrowRight':
						case 'ArrowDown':
							e.preventDefault();
							newIndex = (index + 1) % this.buttons.length;
							break;
						case 'ArrowLeft':
						case 'ArrowUp':
							e.preventDefault();
							newIndex = (index - 1 + this.buttons.length) % this.buttons.length;
							break;
						case 'Home':
							e.preventDefault();
							newIndex = 0;
							break;
						case 'End':
							e.preventDefault();
							newIndex = this.buttons.length - 1;
							break;
						default:
							return;
					}

					this.switchToTab(newIndex);
				});
			});

			// Show first tab
			this.switchToTab(0);
		}

		/**
		 * Switch to specific tab - shows 3 cards: prev, active, next
		 */
		switchToTab(index) {
			this.currentIndex = index;
			const totalCards = this.cards.length;

			// Update button states
			this.buttons.forEach((btn, i) => {
				if (i === index) {
					btn.setAttribute('aria-selected', 'true');
					btn.setAttribute('tabindex', '0');
				} else {
					btn.setAttribute('aria-selected', 'false');
					btn.setAttribute('tabindex', '-1');
				}
			});

			// Animate all cards to their positions
			this.cards.forEach((card, i) => {
				const relativePos = i - index;

				if (relativePos === -1 || (index === 0 && i === totalCards - 1)) {
					// Previous card - left position (closer and smaller)
					gsap.to(card, {
						xPercent: -70,
						opacity: 0.4,
						scale: 0.75,
						rotationY: 20,
						rotationZ: -6,
						zIndex: 1,
						duration: 0.6,
						ease: 'power2.out'
					});
				} else if (relativePos === 0) {
					// Active card - center position (largest and prominent)
					gsap.to(card, {
						xPercent: 0,
						opacity: 1,
						scale: 1,
						rotationY: 0,
						rotationZ: 0,
						zIndex: 3,
						duration: 0.6,
						ease: 'power2.out'
					});
				} else if (relativePos === 1 || (index === totalCards - 1 && i === 0)) {
					// Next card - right position (closer and smaller)
					gsap.to(card, {
						xPercent: 70,
						opacity: 0.4,
						scale: 0.75,
						rotationY: -20,
						rotationZ: 6,
						zIndex: 1,
						duration: 0.6,
						ease: 'power2.out'
					});
				} else {
					// Hidden cards
					const direction = i < index ? -1 : 1;
					gsap.to(card, {
						xPercent: direction * 300,
						opacity: 0,
						scale: 0.7,
						rotationY: direction * 30,
						rotationZ: direction * -10,
						zIndex: 0,
						duration: 0.6,
						ease: 'power2.out'
					});
				}
			});
		}
	}

	// Initialize
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initEpwTabs);
	} else {
		initEpwTabs();
	}

	// Elementor support
	if (typeof window.elementorFrontend !== 'undefined' && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/jdt-tabs.default', function ($scope) {
			const container = $scope[0].querySelector('.epw-tabs-container');
			if (container) {
				new EpwTabsController(container);
			}
		});
	}

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', function () {
			if (typeof elementorFrontend !== 'undefined') {
				elementorFrontend.hooks.addAction('frontend/element_ready/jdt-tabs.default', function ($scope) {
					const container = $scope[0].querySelector('.epw-tabs-container');
					if (container) {
						new EpwTabsController(container);
					}
				});
			}
		});
	}

})();
