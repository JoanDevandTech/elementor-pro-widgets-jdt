---

## Changelog

### Version 1.3.0 (2026-02-12)

**BREAKING: Plugin Rename**
- Plugin renamed from "Orbit Customs" to "Elementor Pro Widgets JDT"
- Class: `Orbit_Customs` → `EPW_JDT`
- Namespace: `Orbit_Customs` → `EPW_JDT`
- Constants: `ORBIT_CUSTOMS_*` → `EPW_JDT_*`
- Text domain: `orbit-customs` → `epw-jdt`
- Functions: `orbit_customs_*` → `epw_jdt_*`
- CSS classes: `.orbit-*` → `.epw-*`
- CSS variables: `--orbit-*` → `--epw-*`
- Widget title: "Orbit Polaroid Tabs" → "Polaroid Tabs"
- Note: `get_name()` still returns `'orbit-tabs'` and shortcode `[orbit_tabs]` is preserved for backward compatibility

**NEW: Custom Zoom Gallery Widget**
- Scroll-driven zoom/fade gallery powered by GSAP ScrollTrigger
- Images stacked front-to-back with scale-up and fade-out animation
- Two image sources: native Elementor gallery or repeater with titles & CTAs
- Animation controls: scrub, pin, scale start/end, fade start
- Style controls: container, image, title, CTA button
- Shortcode support: `[zoom_gallery images="1,2,3"]`
- Reduced motion support: shows only first image
- Responsive design with mobile adjustments

**NEW: GSAP ScrollTrigger CDN Registration**
- ScrollTrigger 3.12.5 registered as `gsap-scrolltrigger` handle
- Per-widget JS dependency system via `js_deps` config key

### Version 1.2.7 (2026-01-20)
- FIXED: Mobile layout now vertical - tabs on top, carousel below
- FIXED: Mobile carousel now has full width space (80% with max 16rem)
- IMPROVED: Grid order system for mobile (left tabs → right tabs → stage)
- IMPROVED: Buttons centered horizontally in mobile view
- IMPROVED: Mobile carousel height increased to 21rem for better visibility

### Version 1.2.6 (2026-01-20)
- FIXED: Mobile carousel now visible - increased from 9rem to 13rem
- FIXED: Mobile stage height increased from 400px to 450px
- FIXED: Removed max-height restriction on mobile images
- IMPROVED: Mobile CTA button sizing optimized

### Version 1.2.5 (2026-01-20)
- FIXED: Images now visible - changed opacity from 0 to 1
- FIXED: Vertical centering on tablet - added flexbox to .epw-tab-content
- FIXED: Button spacing increased from 1rem to 1.25rem
- FIXED: Image height changed to auto for proper crop
- FIXED: Removed max-height restriction on images
- IMPROVED: Images now use full polaroid space with object-fit: cover

### Version 1.2.4 (2026-01-20)
- FIXED: Carousel sizes optimized for specific container widths
- FIXED: Carousel properly centered with margin: 0 auto
- FIXED: Desktop (1650px): 16rem carousel
- FIXED: Small laptop (1100px): 14rem carousel
- FIXED: Tablet (800px): 12rem carousel
- FIXED: Mobile (400px): 9rem carousel
- IMPROVED: Removed percentage widths in favor of fixed rem for predictable sizing

### Version 1.2.3 (2026-01-20)
- FIXED: Carousel properly centered on mobile/tablet (removed extra padding)
- FIXED: iPad carousel now larger (18rem instead of 12rem) - uses more screen space
- IMPROVED: 3 responsive breakpoints for better sizing across devices
- IMPROVED: iPad (768-1080px): 18rem carousel
- IMPROVED: Small tablets (640-767px): 14rem carousel
- IMPROVED: Mobile (<640px): 12rem carousel with reduced padding
- IMPROVED: Side cards closer (70% offset) and smaller (75% scale) for better hierarchy

### Version 1.2.2 (2026-01-20)
- FIXED: Center/active image now always visible with opacity 1
- FIXED: All tabs (left and right) now show their images correctly in center
- IMPROVED: Removed complex seamless loop - replaced with simple 3-card carousel
- IMPROVED: Direct GSAP animations for prev/active/next positions
- IMPROVED: Smooth transitions with power2.out easing (0.6s)
- NEW: Rotation effects on side cards (rotationY ±15deg, rotationZ ±5deg)

### Version 1.2.1 (2026-01-20)
- FIXED: Simplified carousel structure - removed overflow issues
- FIXED: Carousel now properly centered in stage area
- IMPROVED: CSS completely rewritten to match CodePen demo structure
- IMPROVED: JavaScript simplified - direct copy of working demo
- NEW: Added demo.html for local testing

### Version 1.2.0 (2026-01-20)
- NEW: GSAP seamless loop carousel (based on official GSAP demos)
- NEW: Smooth xPercent animations (400 → -400) with rotation
- NEW: Cards enter from right, exit left with scale/opacity effects
- NEW: First left tab activates by default (always shows an image)
- IMPROVED: Professional GSAP animations (power1.in, power3 easing)
- IMPROVED: Seamless infinite looping with overlap calculations
- IMPROVED: GSAP CDN integration (v3.12.5)
- DEPENDENCY: Added GSAP library as required dependency

### Version 1.1.3 (2026-01-20)
- NEW: Smooth carousel flow - cards enter from right, exit left (inspired by GSAP demos)
- NEW: Enhanced rotation angles - left: rotateY(25deg) rotateZ(-8deg), right: rotateY(-25deg) rotateZ(8deg)
- IMPROVED: Smoother transitions (0.6s cubic-bezier)
- IMPROVED: Better perspective (1200px) for more depth
- IMPROVED: Scale effect on side cards (0.85) and hidden cards (0.7)
- IMPROVED: Animation lock prevents rapid clicking issues
- IMPROVED: Better z-index management for layering

### Version 1.1.2 (2026-01-20)
- NEW: Cylindrical carousel effect - shows 3 tabs simultaneously (prev, active, next)
- NEW: JavaScript manages tab positions dynamically
- IMPROVED: Smooth transitions between tab positions (0.5s cubic-bezier)
- IMPROVED: Previous tab: left side with rotateY(15deg) and rotateX(-10deg)
- IMPROVED: Active tab: center, flat, 100% opacity
- IMPROVED: Next tab: right side with rotateY(-15deg) and rotateX(-10deg)
- IMPROVED: Hidden tabs: behind center, opacity 0, not clickable

### Version 1.1.1 (2026-01-20)
- FIXED: Removed unwanted opacity on polaroid images (now 100% visible)
- FIXED: Removed cylindrical carousel effect (each tab has single image)
- FIXED: Simplified image display - centered, clear, no rotations
- IMPROVED: Added clear CSS comments with line numbers for easy customization
- IMPROVED: Better hover effect (5% zoom instead of complex transforms)

### Version 1.1.0 (2026-01-20)
- NEW: Separate left/right tab repeaters
- NEW: Text alignment based on column (left/right)
- NEW: Simplified 1:1 image-to-tab ratio
- IMPROVED: Responsive mobile/tablet layout
- IMPROVED: Modular plugin architecture
- IMPROVED: CSS organization with clear comments
- FIXED: Removed opacity issues on images
- FIXED: Centered tab layout on mobile

### Version 1.0.5
- Previous stable version

### Version 1.0.0 (2026-01-15)
- Initial release
- Polaroid Tabs component
- Elementor widget integration
- Shortcode support
- Full accessibility features

---
