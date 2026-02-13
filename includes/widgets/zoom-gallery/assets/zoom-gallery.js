/**
 * Custom Zoom Gallery – GSAP ScrollTrigger
 *
 * Stack effect: images are piled with random rotations/offsets.
 * On scroll each card straightens, scales up to a max size,
 * then fades out to reveal the next one.
 */

(function () {
	'use strict';

	gsap.registerPlugin(ScrollTrigger);

	/** Prevent double-init */
	const initialized = new WeakSet();

	/**
	 * Deterministic pseudo-random per index so the "messy" look
	 * is the same on every load but still looks organic.
	 */
	function seededRandom(index) {
		const x = Math.sin(index * 127.1 + 311.7) * 43758.5453;
		return x - Math.floor(x);            // 0 … 1
	}

	/**
	 * Build a rotation + offset preset for each card.
	 * Alternates left / center / right with slight Y nudges.
	 */
	function cardTransform(index) {
		const r = seededRandom(index);
		const rotation = (r - 0.5) * 24;        // –12 … +12 deg
		const xOffset  = (seededRandom(index + 50) - 0.5) * 40;  // –20 … +20 px
		const yOffset  = (seededRandom(index + 99) - 0.5) * 30;  // –15 … +15 px
		return { rotation, xOffset, yOffset };
	}

	/* ================================================
	   Controller
	   ================================================ */
	class EpwZoomGalleryController {
		constructor(container) {
			if (initialized.has(container)) return;
			initialized.add(container);

			this.container = container;
			this.inner     = container.querySelector('.epw-zoom-inner');
			this.items     = gsap.utils.toArray(container.querySelectorAll('.epw-zoom-item'));

			if (this.items.length < 2) return;

			/* Config from data-attribute (PHP / shortcode) */
			const raw = container.getAttribute('data-gallery-config');
			const cfg = raw ? JSON.parse(raw) : {};
			this.cfg = {
				scrub     : cfg.scrub !== false,
				pin       : cfg.pin   !== false,
				maxWidth  : parseFloat(cfg.maxWidth)  || 500,
				fadeStart : parseFloat(cfg.fadeStart)  || 0.5,
			};

			if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
				this.reducedMotion();
				return;
			}

			this.build();
		}

		/* ---------- animation ---------- */
		build() {
			const { items, cfg } = this;
			const n = items.length;

			/* 1. Set initial "messy stack" state */
			items.forEach((item, i) => {
				const t = cardTransform(i);
				gsap.set(item, {
					scale    : 1,
					opacity  : 1,
					rotation : t.rotation,
					x        : t.xOffset,
					y        : t.yOffset,
					zIndex   : n - i,          // first on top
				});
			});

			/* 2. ScrollTrigger timeline — each card gets 100 vh of scroll */
			const tl = gsap.timeline({
				scrollTrigger: {
					trigger            : this.container,
					start              : 'top top',
					end                : () => '+=' + ((n - 1) * window.innerHeight),
					scrub              : this.cfg.scrub ? 1 : false,
					pin                : this.cfg.pin ? this.inner : false,
					anticipatePin      : 1,
					invalidateOnRefresh: true,
				}
			});

			/* 3. Animate every card except the last (it stays visible) */
			items.forEach((item, i) => {
				if (i === n - 1) return;

				const img       = item.querySelector('img');
				const segStart  = i / (n - 1);
				const segDur    = 1 / (n - 1);

				/*
				 * Phase A (0 → fadeStart of segment):
				 *   straighten rotation, center x/y, scale img up to maxWidth
				 * Phase B (fadeStart → end of segment):
				 *   fade out + continue scaling slightly
				 */
				const phaseA = segDur * cfg.fadeStart;
				const phaseB = segDur * (1 - cfg.fadeStart);

				/* Scale ratio: from natural size to maxWidth */
				const naturalW  = img ? img.naturalWidth || img.offsetWidth || 260 : 260;
				const scaleGoal = Math.max(cfg.maxWidth / Math.max(naturalW, 1), 1);

				// Phase A — straighten & grow
				tl.to(item, {
					rotation : 0,
					x        : 0,
					y        : 0,
					scale    : scaleGoal,
					duration : phaseA,
					ease     : 'power2.out',
				}, segStart);

				// Phase B — fade out & grow a bit more
				tl.to(item, {
					opacity  : 0,
					scale    : scaleGoal * 1.15,
					duration : phaseB,
					ease     : 'power1.in',
				}, segStart + phaseA);
			});
		}

		/* ---------- a11y fallback ---------- */
		reducedMotion() {
			this.items.forEach((item, i) => {
				gsap.set(item, { opacity: i === 0 ? 1 : 0 });
			});
		}

		/* ---------- teardown ---------- */
		destroy() {
			ScrollTrigger.getAll().forEach(st => {
				if (st.trigger === this.container) st.kill();
			});
			initialized.delete(this.container);
		}
	}

	/* ================================================
	   Bootstrap
	   ================================================ */
	function initAll() {
		document.querySelectorAll('.epw-zoom-container').forEach(c => {
			new EpwZoomGalleryController(c);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}

	/* Elementor front-end (single registration) */
	function registerElementor() {
		if (window.elementorFrontend?.hooks) {
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/zoom-gallery.default',
				function ($scope) {
					const c = $scope[0].querySelector('.epw-zoom-container');
					if (c) {
						initialized.delete(c);          // allow re-init after edit
						new EpwZoomGalleryController(c);
					}
				}
			);
		}
	}

	registerElementor();

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', registerElementor);
	}
})();
