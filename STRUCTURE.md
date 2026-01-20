# Orbit Customs - Plugin Structure

## Directory Structure

```
orbit-custom/
├── orbit-customs.php           # Main plugin file with widget registration
├── README.md                   # Plugin documentation
├── includes/
│   └── widgets/               # All custom widgets
│       └── orbit-tabs/        # Orbit Tabs widget
│           ├── elementor-widget.php    # Elementor widget class
│           ├── shortcode-handler.php   # Shortcode implementation
│           └── assets/
│               ├── orbit-tabs.css      # Widget styles
│               └── orbit-tabs.js       # Widget scripts
└── languages/                 # Translation files
```

## How to Add a New Widget

### Step 1: Create Widget Directory

Create a new directory under `includes/widgets/` for your widget:

```
includes/widgets/your-widget-name/
├── elementor-widget.php
├── shortcode-handler.php
└── assets/
    ├── your-widget.css
    └── your-widget.js
```

### Step 2: Register Widget in Main File

Edit `orbit-customs.php` and add your widget to the `register_widgets()` method:

```php
private function register_widgets()
{
    // ... existing widgets ...

    // Register your new widget
    $this->widgets['your-widget-id'] = array(
        'name' => 'Your Widget Name',
        'class' => 'Elementor_Your_Widget_Class',
        'file' => 'widgets/your-widget-name/elementor-widget.php',
        'shortcode' => 'your_widget',
        'shortcode_handler' => 'widgets/your-widget-name/shortcode-handler.php',
        'assets' => array(
            'css' => 'widgets/your-widget-name/assets/your-widget.css',
            'js' => 'widgets/your-widget-name/assets/your-widget.js',
        ),
    );
}
```

### Step 3: Create Elementor Widget Class

Create `elementor-widget.php` with the following structure:

```php
<?php
namespace Orbit_Customs;

if (!defined('ABSPATH')) {
    exit;
}

class Elementor_Your_Widget_Class extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'your-widget-id';
    }

    public function get_title()
    {
        return __('Your Widget Name', 'orbit-customs');
    }

    public function get_icon()
    {
        return 'eicon-your-icon';
    }

    public function get_categories()
    {
        return array('general');
    }

    public function get_script_depends()
    {
        return array('your-widget-id');
    }

    public function get_style_depends()
    {
        return array('your-widget-id');
    }

    protected function register_controls()
    {
        // Add your widget controls here
    }

    protected function render()
    {
        // Add your widget render logic here
    }
}
```

### Step 4: Create Shortcode Handler

Create `shortcode-handler.php`:

```php
<?php
if (!defined('ABSPATH')) {
    exit;
}

function orbit_customs_your_widget_shortcode($atts)
{
    // Enqueue assets
    wp_enqueue_style('your-widget-id');
    wp_enqueue_script('your-widget-id');

    // Your shortcode logic here
    
    return $output;
}
```

### Step 5: Create Assets

- **CSS**: Create `assets/your-widget.css` with your widget styles
- **JS**: Create `assets/your-widget.js` with your widget scripts

## Widget Configuration Array

Each widget in the `$this->widgets` array supports:

| Key | Required | Description |
|-----|----------|-------------|
| `name` | Yes | Human-readable widget name |
| `class` | Yes | Elementor widget class name |
| `file` | Yes | Path to Elementor widget file (relative to `includes/`) |
| `shortcode` | No | Shortcode name (without brackets) |
| `shortcode_handler` | No | Path to shortcode handler file |
| `assets.css` | No | Path to CSS file (relative to `includes/`) |
| `assets.js` | No | Path to JS file (relative to `includes/`) |

## Best Practices

1. **Naming Convention**:
   - Widget ID: `your-widget-name` (kebab-case)
   - Class Name: `Elementor_Your_Widget_Class` (PascalCase)
   - Shortcode: `your_widget` (snake_case)
   - Functions: `orbit_customs_your_widget_*` (prefixed)

2. **File Organization**:
   - Keep all widget files in its own directory
   - Separate concerns: Elementor widget, shortcode, and assets
   - Use the `Orbit_Customs` namespace for Elementor widgets

3. **Asset Management**:
   - Register assets in the main plugin file
   - Enqueue only when widget is used
   - Use plugin version for cache busting

4. **Security**:
   - Always check `ABSPATH` at the beginning of files
   - Escape output with `esc_html()`, `esc_attr()`, `esc_url()`
   - Sanitize input data

5. **Internationalization**:
   - Use `__()` for translatable strings
   - Text domain: `'orbit-customs'`

## Example: Orbit Tabs Widget

See `includes/widgets/orbit-tabs/` for a complete working example with:
- Separate left/right tab repeaters
- Single image per tab
- CTA button positioning
- Cylindrical carousel effect
- Responsive design
- Full Elementor integration

## Version Control

When adding new features:
1. Update `ORBIT_CUSTOMS_VERSION` in `orbit-customs.php`
2. Follow semantic versioning (MAJOR.MINOR.PATCH)
3. Document changes in plugin header comments
