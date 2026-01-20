<?php
/**
 * Plugin Name: Orbit Customs
 * Plugin URI: https://joandev.com/orbit-customs
 * Description: Custom visual components including Polaroid Tabs with stunning animations and Elementor integration
 * Author: Joan Dev & Tech
 * Version: 1.1.0
 * Author URI: https://joandev.com
 * Text Domain: orbit-customs
 * License: GPLv2 or later
 * Requires at least: 5.0
 * Tested up to: 6.8
 * Requires PHP: 7.3
 * Location: Galiza, Spain
 * Update URI: https://joandev.com/orbit-customs
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ORBIT_CUSTOMS_VERSION', '1.1.0');
define('ORBIT_CUSTOMS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ORBIT_CUSTOMS_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Orbit Customs Class
 */
class Orbit_Customs
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
        // Register Orbit Tabs widget
        $this->widgets['orbit-tabs'] = array(
            'name' => 'Orbit Tabs',
            'class' => 'Elementor_Orbit_Tabs_Widget',
            'file' => 'widgets/orbit-tabs/elementor-widget.php',
            'shortcode' => 'orbit_tabs',
            'shortcode_handler' => 'widgets/orbit-tabs/shortcode-handler.php',
            'assets' => array(
                'css' => 'widgets/orbit-tabs/assets/orbit-tabs.css',
                'js' => 'widgets/orbit-tabs/assets/orbit-tabs.js',
            ),
        );

        // Register shortcodes for each widget
        foreach ($this->widgets as $widget_id => $widget_config) {
            if (isset($widget_config['shortcode']) && isset($widget_config['shortcode_handler'])) {
                $handler_file = ORBIT_CUSTOMS_PLUGIN_DIR . 'includes/' . $widget_config['shortcode_handler'];
                if (file_exists($handler_file)) {
                    require_once $handler_file;
                    add_shortcode($widget_config['shortcode'], 'orbit_customs_' . str_replace('-', '_', $widget_id) . '_shortcode');
                }
            }
        }
    }

    /**
     * Load plugin textdomain
     */
    public function load_textdomain()
    {
        load_plugin_textdomain('orbit-customs', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /**
     * Register assets for all widgets
     */
    public function register_assets()
    {
        foreach ($this->widgets as $widget_id => $widget_config) {
            if (isset($widget_config['assets'])) {
                // Register CSS
                if (isset($widget_config['assets']['css'])) {
                    wp_register_style(
                        $widget_id,
                        ORBIT_CUSTOMS_PLUGIN_URL . 'includes/' . $widget_config['assets']['css'],
                        array(),
                        ORBIT_CUSTOMS_VERSION
                    );
                }

                // Register JS
                if (isset($widget_config['assets']['js'])) {
                    wp_register_script(
                        $widget_id,
                        ORBIT_CUSTOMS_PLUGIN_URL . 'includes/' . $widget_config['assets']['js'],
                        array('jquery'),
                        ORBIT_CUSTOMS_VERSION,
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
            $widget_file = ORBIT_CUSTOMS_PLUGIN_DIR . 'includes/' . $widget_config['file'];

            if (file_exists($widget_file)) {
                require_once $widget_file;

                $class_name = '\\Orbit_Customs\\' . $widget_config['class'];
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
function orbit_customs_init()
{
    return Orbit_Customs::get_instance();
}

// Start the plugin
orbit_customs_init();
