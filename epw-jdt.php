<?php
/**
 * Plugin Name: Elementor Pro Widgets JDT
 * Plugin URI: https://joandev.com/epw-jdt
 * Description: Custom visual components including Polaroid Tabs, Custom Zoom Gallery and Elementor integration
 * Author: Joan Dev & Tech
 * Version: 1.4.1
 * Author URI: https://joandev.com
 * Text Domain: epw-jdt
 * License: GPLv2 or later
 * Requires at least: 5.0
 * Tested up to: 6.8
 * Requires PHP: 7.3
 * Location: Galiza, Spain
 * Update URI: https://joandev.com/epw-jdt
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('EPW_JDT_VERSION', '1.3.0');
define('EPW_JDT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EPW_JDT_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main EPW_JDT Class
 */
class EPW_JDT
{
    /**
     * Instance of this class
     */
    private static $instance = null;

    /**
     * Array of registered widgets
     */
    private $widgets = array();

    /**
     * Get instance
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->init_hooks();
        $this->register_widgets();
    }

    /**
     * Initialize hooks
     */
    private function init_hooks()
    {
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'register_assets'));
        add_action('elementor/frontend/after_register_scripts', array($this, 'register_assets'));
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'register_assets'));
        add_action('elementor/widgets/register', array($this, 'register_elementor_widgets'));
    }

    /**
     * Register available widgets
     */
    private function register_widgets()
    {
        // Register Polaroid Tabs widget
        $this->widgets['jdt-tabs'] = array(
            'name' => 'Polaroid Tabs',
            'class' => 'Elementor_JDT_Tabs_Widget',
            'file' => 'widgets/jdt-tabs/elementor-widget.php',
            'shortcode' => 'jdt_tabs',
            'shortcode_handler' => 'widgets/jdt-tabs/shortcode-handler.php',
            'assets' => array(
                'css' => 'widgets/jdt-tabs/assets/jdt-tabs.css',
                'js' => 'widgets/jdt-tabs/assets/jdt-tabs.js',
            ),
            'js_deps' => array('jquery', 'gsap'),
        );

        // Register Custom Zoom Gallery widget
        $this->widgets['zoom-gallery'] = array(
            'name' => 'Custom Zoom Gallery',
            'class' => 'Elementor_Zoom_Gallery_Widget',
            'file' => 'widgets/zoom-gallery/elementor-widget.php',
            'shortcode' => 'zoom_gallery',
            'shortcode_handler' => 'widgets/zoom-gallery/shortcode-handler.php',
            'assets' => array(
                'css' => 'widgets/zoom-gallery/assets/zoom-gallery.css',
                'js' => 'widgets/zoom-gallery/assets/zoom-gallery.js',
            ),
            'js_deps' => array('gsap', 'gsap-scrolltrigger'),
        );

        // Register shortcodes for each widget
        foreach ($this->widgets as $widget_id => $widget_config) {
            if (isset($widget_config['shortcode']) && isset($widget_config['shortcode_handler'])) {
                $handler_file = EPW_JDT_PLUGIN_DIR . 'includes/' . $widget_config['shortcode_handler'];
                if (file_exists($handler_file)) {
                    require_once $handler_file;
                    $shortcode_function = 'epw_jdt_' . str_replace('-', '_', $widget_id) . '_shortcode';
                    add_shortcode($widget_config['shortcode'], $shortcode_function);
                }
            }
        }
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('epw-jdt', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Register assets for all widgets
     */
    public function register_assets()
    {
        // Register GSAP library (required for animations)
        wp_register_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
            array(),
            '3.12.5',
            true
        );

        // Register GSAP ScrollTrigger plugin
        wp_register_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
            array('gsap'),
            '3.12.5',
            true
        );

        foreach ($this->widgets as $widget_id => $widget_config) {
            if (isset($widget_config['assets'])) {
                // Register CSS
                if (isset($widget_config['assets']['css'])) {
                    wp_register_style(
                        $widget_id,
                        EPW_JDT_PLUGIN_URL . 'includes/' . $widget_config['assets']['css'],
                        array(),
                        EPW_JDT_VERSION
                    );
                }

                // Register JS with per-widget dependencies
                if (isset($widget_config['assets']['js'])) {
                    $js_deps = isset($widget_config['js_deps']) ? $widget_config['js_deps'] : array('jquery', 'gsap');
                    wp_register_script(
                        $widget_id,
                        EPW_JDT_PLUGIN_URL . 'includes/' . $widget_config['assets']['js'],
                        $js_deps,
                        EPW_JDT_VERSION,
                        true
                    );
                }
            }
        }
    }

    /**
     * Register Elementor widgets
     */
    public function register_elementor_widgets($widgets_manager)
    {
        if (!did_action('elementor/loaded')) {
            return;
        }

        foreach ($this->widgets as $widget_id => $widget_config) {
            $widget_file = EPW_JDT_PLUGIN_DIR . 'includes/' . $widget_config['file'];

            if (file_exists($widget_file)) {
                require_once $widget_file;

                $class_name = '\\EPW_JDT\\' . $widget_config['class'];
                if (class_exists($class_name)) {
                    $widgets_manager->register(new $class_name());
                }
            }
        }
    }

    /**
     * Get registered widgets
     */
    public function get_widgets()
    {
        return $this->widgets;
    }
}

/**
 * Initialize the plugin
 */
function epw_jdt_init()
{
    return EPW_JDT::get_instance();
}

// Start the plugin
epw_jdt_init();
