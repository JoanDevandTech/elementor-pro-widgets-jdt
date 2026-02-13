/**
 * Custom Zoom Gallery – GSAP ScrollTrigger
 *
 * Stack effect: images piled with random rotations / offsets.
 * On scroll each card straightens, scales up to a configured
 * max-width, then fades out to reveal the next card.
 */

(function () {
	'use strict';

	gsap.registerPlugin(ScrollTrigger);

	/** Prevent double-init */
	const initialized = new WeakSet();

	/* --------------------------------------------------
	   Deterministic pseudo-random per index
	   -------------------------------------------------- */
	function seeded(i) {
		const x = Math.sin(i * 127.1 + 311.7) * 43758.5453;
		return x - Math.floor(x); // 0 … 1
	}

	function cardPose(index) {
		return {
			rotation: (seeded(index) - 0.5) * 24,           // –12 … +12 deg
			x:        (seeded(index + 50) - 0.5) * 40,      // –20 … +20 px
			y:        (seeded(index + 99) - 0.5) * 30,      // –15 … +15 px
		};
	}

	/* ==================================================
	   Controller
	   ================================================== */
	class ZoomGallery {
		constructor(container) {
			if (initialized.has(container)) return;
			initialized.add(container);

			this.container = container;
			this.inner     = container.querySelector('.epw-zoom-inner');
			this.items     = gsap.utils.toArray(
				container.querySelectorAll('.epw-zoom-item')
			);

			if (this.items.length < 2) return;

			/* ---- config ---- */
			const raw = container.getAttribute('data-gallery-config');
			const c   = raw ? JSON.parse(raw) : {};

			this.cfg = {
				scrub    : c.scrub !== false,
				pin      : c.pin   !== false,
				maxWidth : parseFloat(c.maxWidth)  || 500,
				fadeStart: parseFloat(c.fadeStart)  || 0.5,
			};

			/* ---- a11y ---- */
			if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
				this.items.forEach((el, i) =>
					gsap.set(el, { opacity: i === 0 ? 1 : 0 })
				);
				return;
			}

			this.build();
		}

		/* ---------- main animation ---------- */
		build() {
			const { items, cfg, inner } = this;
			const n = items.length;

			/*
			 * 1. Initial "messy stack" — small images with random
			 *    rotations + slight x / y offsets, first on top.
			 */
			items.forEach((el, i) => {
				const pose = cardPose(i);
				gsap.set(el, {
					scale   : 1,
					opacity : 1,
					rotation: pose.rotation,
					x       : pose.x,
					y       : pose.y,
					zIndex  : n - i,
				});
			});

			/*
			 * 2. ScrollTrigger.
			 *
			 *    Scroll distance = (n-1) * height of the inner panel.
			 *    This way each image gets exactly one "panel-height"
			 *    worth of scroll regardless of the container size
			 *    (300 px, 100 vh, whatever Elementor sets).
			 */
			const tl = gsap.timeline({
				scrollTrigger: {
					trigger            : this.container,
					start              : 'top top',
					end                : () => {
						const h = inner.offsetHeight || window.innerHeight;
						return '+=' + (h * (n - 1));
					},
					scrub              : cfg.scrub ? 1 : false,
					pin                : cfg.pin ? inner : false,
					anticipatePin      : 1,
					invalidateOnRefresh: true,
				},
			});

			/*
			 * 3. Per-card animation (all except the last).
			 *
			 *    Phase A  →  straighten, center, scale up to maxWidth
			 *    Phase B  →  fade out + overshoot scale slightly
			 */
			items.forEach((el, i) => {
				if (i === n - 1) return;          // last stays

				const img = el.querySelector('img');

				const segStart = i / (n - 1);
				const segDur   = 1 / (n - 1);
				const phaseA   = segDur * cfg.fadeStart;
				const phaseB   = segDur * (1 - cfg.fadeStart);

				/*
				 * Scale ratio: from current (natural) size to maxWidth.
				 * Use the rendered width so it works even before
				 * naturalWidth is available (lazy-loaded images).
				 */
				const baseW     = (img && img.offsetWidth) || 260;
				const scaleGoal = Math.max(cfg.maxWidth / baseW, 1.2);

				// Phase A — straighten & grow
				tl.to(el, {
					rotation: 0,
					x       : 0,
					y       : 0,
					scale   : scaleGoal,
					duration: phaseA,
					ease    : 'power2.out',
				}, segStart);

				// Phase B — fade out + slight extra zoom
				tl.to(el, {
					opacity : 0,
					scale   : scaleGoal * 1.15,
					duration: phaseB,
					ease    : 'power1.in',
				}, segStart + phaseA);
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

	/* ==================================================
	   Bootstrap
	   ================================================== */
	function initAll() {
		document.querySelectorAll('.epw-zoom-container').forEach(c => {
			new ZoomGallery(c);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}

	/* ---- Elementor front-end (single registration) ---- */
	function registerElementor() {
		if (!window.elementorFrontend?.hooks) return;
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/zoom-gallery.default',
			function ($scope) {
				const c = $scope[0].querySelector('.epw-zoom-container');
				if (c) {
					initialized.delete(c);      // allow re-init after edit
					new ZoomGallery(c);
				}
			}
		);
	}

	registerElementor();

	if (typeof jQuery !== 'undefined') {
		jQuery(window).on('elementor/frontend/init', registerElementor);
	}
})();
