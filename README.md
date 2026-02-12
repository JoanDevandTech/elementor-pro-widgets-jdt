# Elementor Pro Widgets JDT - WordPress Plugin

![Version](https://img.shields.io/badge/version-1.3.0-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-brightgreen.svg)
![PHP](https://img.shields.io/badge/PHP-7.3%2B-purple.svg)
![Elementor](https://img.shields.io/badge/Elementor-Compatible-orange.svg)

**Professional visual components for WordPress with Polaroid Tabs, Custom Zoom Gallery, and Elementor integration.**

---

## Features

- **Polaroid-Style Tabs**: Unique tabbed navigation with professional image display
- **Custom Zoom Gallery**: Scroll-driven zoom/fade gallery powered by GSAP ScrollTrigger
- **GSAP Animations**: Smooth 3-card carousel with rotation and scale effects
- **ScrollTrigger Integration**: Pin + scrub animations for immersive scroll experiences
- **Fully Responsive**: Optimized for desktop, tablet, and mobile
- **Accessibility First**: ARIA attributes, keyboard navigation, reduced motion support
- **Performance Optimized**: Assets registered on-demand, loaded only when needed
- **Elementor Integration**: Drag-and-drop widgets with full visual controls
- **Shortcode Support**: Use `[orbit_tabs]` and `[zoom_gallery]` outside of Elementor

---

## Installation

1. Download the plugin ZIP file
2. Go to **WordPress Admin > Plugins > Add New**
3. Click **Upload Plugin** and select the ZIP file
4. Click **Install Now** and then **Activate**

---

## Quick Start

### Polaroid Tabs

#### Method 1: Elementor Widget

1. Open a page with **Elementor**
2. Search for **"Polaroid Tabs"** in the widgets panel
3. Drag the widget to your desired location
4. Configure tabs in **Left Tabs** and **Right Tabs** sections
5. Upload images (1 image per tab, 1:1 ratio recommended)
6. Set CTA buttons and positions
7. Preview and publish!

#### Method 2: Shortcode

Use the shortcode `[orbit_tabs]` in any post, page, or text widget. Note: the shortcode uses default configuration. For full customization, use the Elementor widget.

### Custom Zoom Gallery

#### Method 1: Elementor Widget

1. Open a page with **Elementor**
2. Search for **"Custom Zoom Gallery"** in the widgets panel
3. Drag the widget to your desired location
4. Choose image source: **Gallery** (simple) or **Repeater** (with titles & CTAs)
5. Add your images (minimum 2 recommended)
6. Adjust animation settings (scale, fade, scrub, pin)
7. Preview and publish!

#### Method 2: Shortcode

Use `[zoom_gallery images="1,2,3"]` where the numbers are WordPress attachment IDs. Without IDs, demo placeholder images are shown.

---

## Widget Configuration

### Polaroid Tabs

#### Tab Structure

The widget uses **separate repeaters** for left and right columns:

##### Left Tabs (Left Column)
- **Tab Title**: Text displayed on the tab button
- **Tab Image**: Single image (1:1 ratio recommended)
- **CTA Text**: Call-to-action button label
- **CTA Link**: URL for the CTA button
- **CTA Position**: 9 positions available (see below)

##### Right Tabs (Right Column)
- Same fields as Left Tabs
- Text aligns to the right automatically

#### CTA Button Positions

| Position | Description |
|----------|-------------|
| `top-left` | Top left corner of the polaroid |
| `top-center` | Top center of the polaroid |
| `top-right` | Top right corner of the polaroid |
| `center-left` | Center left of the polaroid |
| `center-center` | Center of the polaroid |
| `center-right` | Center right of the polaroid (default) |
| `bottom-left` | Bottom left corner of the polaroid |
| `bottom-center` | Bottom center of the polaroid |
| `bottom-right` | Bottom right corner of the polaroid |

#### Text Alignment

- **Left Column Tabs**: Text aligns LEFT
- **Right Column Tabs**: Text aligns RIGHT
- **Mobile/Tablet**: All tabs center automatically

#### Image Display

- Each tab has **exactly 1 image** (1:1 ratio recommended)
- Images display centered with polaroid-style border
- Hover effect: slight zoom (5%)
- Full opacity (100% visible)

#### Style Controls (Elementor)

- **Tab Buttons**: Typography, colors (normal/hover/active), padding, border radius
- **CTA Buttons**: Typography, colors, padding, border radius
- **Polaroid Images**: Border color, width, shadows, image dimensions, aspect ratio, object-fit, object-position
- **Vignette Overlay**: Toggle on/off

### Custom Zoom Gallery

#### Image Sources

- **Gallery**: Use Elementor's native gallery picker for quick setup
- **Repeater**: Add images with optional title and CTA button per item

#### Animation Settings

| Setting | Description | Default |
|---------|-------------|---------|
| Scrub | Links animation progress to scroll position | Yes |
| Pin | Pins the container while scrolling through images | Yes |
| Scale Start | Initial scale of each image | 1.0 |
| Scale End | Final scale before image fades out | 2.5 |
| Fade Start | Fraction of scroll before fade begins | 0.6 |

#### Style Controls (Elementor)

- **Container**: Height, background color, padding
- **Image**: Border radius, box shadow, max width
- **Title**: Typography, color, background color, padding (repeater mode)
- **CTA Button**: Typography, colors, padding, border radius (repeater mode)

---

## Project Structure

```
epw-jdt/
├── orbit-customs.php                    # Main plugin file (singleton, widget registry)
├── README.md                            # This file
├── changelog.md                         # Version history
├── demo.html                            # Local testing demo
├── .gitignore                           # Git ignore rules
└── includes/
    └── widgets/                         # All custom widgets
        ├── orbit-tabs/                  # Polaroid Tabs widget
        │   ├── elementor-widget.php     # Elementor integration & controls
        │   ├── shortcode-handler.php    # Shortcode rendering
        │   └── assets/
        │       ├── orbit-tabs.css       # Widget styles
        │       └── orbit-tabs.js        # Tab navigation & GSAP animations
        └── zoom-gallery/               # Custom Zoom Gallery widget
            ├── elementor-widget.php     # Elementor integration & controls
            ├── shortcode-handler.php    # Shortcode rendering
            └── assets/
                ├── zoom-gallery.css     # Widget styles
                └── zoom-gallery.js      # ScrollTrigger animations
```

### Architecture

- **Singleton Pattern**: Single plugin instance via `EPW_JDT::get_instance()`
- **Widget Registry**: Internal `$widgets` array for modular widget management
- **Namespace**: `EPW_JDT` to prevent naming conflicts
- **Asset Registration**: CSS/JS registered (not enqueued) for performance; loaded only when widget is used
- **Per-Widget Dependencies**: Each widget declares its own JS deps via `js_deps` key

### Adding a New Widget

To add a new widget, create its folder under `includes/widgets/` and register it in `orbit-customs.php`:

```php
$this->widgets['new-widget-id'] = array(
    'name'              => 'New Widget Name',
    'class'             => 'Elementor_New_Widget_Class',
    'file'              => 'widgets/new-widget-id/elementor-widget.php',
    'shortcode'         => 'new_widget',
    'shortcode_handler' => 'widgets/new-widget-id/shortcode-handler.php',
    'assets' => array(
        'css' => 'widgets/new-widget-id/assets/new-widget.css',
        'js'  => 'widgets/new-widget-id/assets/new-widget.js',
    ),
    'js_deps' => array('jquery', 'gsap'),
);
```

---

## Technical Specifications

### Dependencies

| Dependency | Version | Source |
|------------|---------|--------|
| WordPress | 5.0+ | Required |
| PHP | 7.3+ | Required |
| Elementor | Any | Optional (for widget UI) |
| jQuery | WP bundled | Required by Polaroid Tabs JS |
| GSAP | 3.12.5 | CDN (cdnjs.cloudflare.com) |
| GSAP ScrollTrigger | 3.12.5 | CDN (cdnjs.cloudflare.com) |

### CSS Features
- CSS Grid layout (`auto | 1fr | auto`)
- Polaroid effect (asymmetric borders, soft shadows)
- Smooth transitions and hover effects
- Responsive breakpoints: 1280px, 1080px, 767px, 640px
- Backdrop-filter blur for zoom gallery CTA

### JavaScript Features
- ES6 class-based architecture (`EpwTabsController`, `EpwZoomGalleryController`)
- GSAP carousel animation (3-card: prev/active/next)
- GSAP ScrollTrigger pinning and scrub animations
- Rotation effects on side cards (rotationY, rotationZ)
- ARIA attribute management
- Keyboard navigation (Arrow keys, Home, End)
- Elementor preview compatibility
- Animation lock to prevent rapid-click issues

### Accessibility
- Full ARIA support (roles, states, properties)
- Keyboard navigation
- Focus management
- Screen reader friendly
- `prefers-reduced-motion` support

---

## Responsive Behavior

### Desktop (>1080px)
- 3-column layout: Left tabs | Center stage | Right tabs
- Left tabs align left, right tabs align right
- Full-size polaroid images with GSAP carousel

### Tablet (768px - 1080px)
- Single column layout
- Tabs in horizontal rows
- Centered text
- Reduced carousel size

### Mobile (<640px)
- Single column, vertical layout
- Tabs on top, carousel below
- Full-width carousel (80%, max 16rem)
- Centered buttons

---

## Requirements

- **WordPress**: 5.0 or higher (tested up to 6.8)
- **PHP**: 7.3 or higher
- **Elementor** (optional): For drag-and-drop widget functionality

---

## Troubleshooting

**Tabs not switching**
- Clear browser cache
- Ensure JavaScript is enabled
- Check browser console for errors

**Styles not loading**
- Verify the widget or shortcode is on the page
- Check if assets are enqueued (`wp_register_style`/`wp_register_script`)
- Clear WordPress cache

**Elementor widget not appearing**
- Ensure Elementor is installed and activated
- Refresh Elementor editor
- Check WordPress error logs

**Images not showing**
- Verify image URLs are correct
- Check file permissions
- Ensure images are uploaded to media library

**GSAP animations not working**
- Check browser console for CDN loading errors
- Verify GSAP script is registered (handle: `gsap`)
- Ensure jQuery is loaded before the widget script

**Zoom Gallery not pinning**
- Ensure ScrollTrigger CDN is loading (handle: `gsap-scrolltrigger`)
- Check that the container has sufficient height
- Verify at least 2 images are added

---

## Changelog

See [changelog.md](changelog.md) for full version history.

---

## Author

**Joan Dev & Tech**
- Website: [https://joandev.com](https://joandev.com)
- Location: Galiza, Spain

---

## License

This plugin is licensed under the GPLv2 or later.

```
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
```

---

## Support

For support, feature requests, or bug reports:
- Visit: [https://joandev.com/contacto/](https://joandev.com/contacto/)

---

**Made with care in Galiza, Spain**
