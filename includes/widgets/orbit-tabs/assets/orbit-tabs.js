/**
 * Orbit Polaroid Tabs - JavaScript Controller
 * Handles tab navigation, ARIA attributes, and smooth transitions
 */

(function () {
	'use strict';

	/**
	 * Initialize all Orbit Tabs instances on the page
	 */
	function initOrbitTabs() {
		const containers = document.querySelectorAll('.orbit-tabs-container');

		containers.forEach(container => {
			new OrbitTabsController(container);
		});
	}

	/**
	 * Orbit Tabs Controller Class
	 */
	class OrbitTabsController {
		constructor(container) {
			this.container = container;
			this.buttons = container.querySelectorAll('.orbit-tab-button');
			this.panels = container.querySelectorAll('.orbit-tab-content');

			if (this.buttons.length === 0 || this.panels.length === 0) {
				return;
			}

			this.init();
		}

		/**
		 * Initialize the controller
		 */
		init() {
			// Set up click handlers
			this.buttons.forEach((button, index) => {
				button.addEventListener('click', () => this.switchTab(index));
			});

			// Set up keyboard navigation
			this.setupKeyboardNavigation();

			// Activate first tab by default
			this.switchTab(0);
		}

		/**
		 * Switch to a specific tab
		 */
		switchTab(index) {
			// Deactivate all tabs
			this.buttons.forEach(btn => {
				btn.setAttribute('aria-selected', 'false');
				btn.setAttribute('tabindex', '-1');
			});

			this.panels.forEach(panel => {
				panel.setAttribute('aria-hidden', 'true');
			});

			// Activate selected tab
			if (this.buttons[index] && this.panels[index]) {
				this.buttons[index].setAttribute('aria-selected', 'true');
				this.buttons[index].setAttribute('tabindex', '0');
				this.panels[index].setAttribute('aria-hidden', 'false');

				// Focus the activated button for accessibility
				this.buttons[index].focus();
			}
		}

		/**
		 * Set up keyboard navigation (Arrow keys)
		 */
		setupKeyboardNavigation() {
			this.buttons.forEach((button, index) => {
				button.addEventListener('keydown', (e) => {
					let newIndex = index;

					switch (e.key) {
						case 'ArrowRight':
						case 'ArrowDown':
							e.preventDefault();
							newIndex = (index + 1) % this.buttons.length;
							this.switchTab(newIndex);
							break;

						case 'ArrowLeft':
						case 'ArrowUp':
							e.preventDefault();
							newIndex = (index - 1 + this.buttons.length) % this.buttons.length;
							this.switchTab(newIndex);
							break;

						case 'Home':
							e.preventDefault();
							this.switchTab(0);
							break;

						case 'End':
							e.preventDefault();
							this.switchTab(this.buttons.length - 1);
							break;
					}
				});
			});
		}
	}

	/**
	 * Initialize on DOM ready
	 */
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initOrbitTabs);
	} else {
		initOrbitTabs();
	}

	/**
	 * Re-initialize when Elementor preview updates
	 */
	if (typeof window.elementorFrontend !== 'undefined' && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/orbit-tabs.default', function ($scope) {
			const container = $scope[0].querySelector('.orbit-tabs-container');
			if (container) {
				new OrbitTabsController(container);
			}
		});
	}

	// Also initialize on Elementor preview load
	jQuery(window).on('elementor/frontend/init', function () {
		if (typeof elementorFrontend !== 'undefined') {
			elementorFrontend.hooks.addAction('frontend/element_ready/orbit-tabs.default', function ($scope) {
				const container = $scope[0].querySelector('.orbit-tabs-container');
				if (container) {
					new OrbitTabsController(container);
				}
			});
		}
	});

})();
