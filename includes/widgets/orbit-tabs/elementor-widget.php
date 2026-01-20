<?php
/**
 * Elementor Orbit Tabs Widget
 * Custom widget for Elementor integration with full style controls
 */

namespace Orbit_Customs;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Elementor Orbit Tabs Widget Class
 */
class Elementor_Orbit_Tabs_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name
     */
    public function get_name()
    {
        return 'orbit-tabs';
    }

    /**
     * Get widget title
     */
    public function get_title()
    {
        return __('Orbit Polaroid Tabs', 'orbit-customs');
    }

    /**
     * Get widget icon
     */
    public function get_icon()
    {
        return 'eicon-tabs';
    }

    /**
     * Get widget categories
     */
    public function get_categories()
    {
        return array('general');
    }

    /**
     * Get widget keywords
     */
    public function get_keywords()
    {
        return array('tabs', 'polaroid', 'gallery', 'orbit', 'images');
    }

    /**
     * Get script dependencies
     */
    public function get_script_depends()
    {
        return array('orbit-tabs');
    }

    /**
     * Get style dependencies
     */
    public function get_style_depends()
    {
        return array('orbit-tabs');
    }

    /**
     * Register widget controls
     */
    protected function register_controls()
    {

        // ========================================
        // CONTENT TAB - Tabs Configuration
        // ========================================
        $this->start_controls_section(
            'content_section',
            array(
                'label' => __('Tabs', 'orbit-customs'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        // Left Tabs Repeater
        $left_tabs_repeater = new \Elementor\Repeater();

        $left_tabs_repeater->add_control(
            'tab_title',
            array(
                'label' => __('Tab Title', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tab Title', 'orbit-customs'),
                'label_block' => true,
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $left_tabs_repeater->add_control(
            'tab_image',
            array(
                'label' => __('Image', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $left_tabs_repeater->add_control(
            'cta_text',
            array(
                'label' => __('CTA Button Text', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View More', 'orbit-customs'),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $left_tabs_repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Button Link', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'orbit-customs'),
                'default' => array(
                    'url' => '#',
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $left_tabs_repeater->add_control(
            'cta_position',
            array(
                'label' => __('CTA Button Position', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'top-left' => __('Top Left', 'orbit-customs'),
                    'top-center' => __('Top Center', 'orbit-customs'),
                    'top-right' => __('Top Right', 'orbit-customs'),
                    'center-left' => __('Center Left', 'orbit-customs'),
                    'center-center' => __('Center Center', 'orbit-customs'),
                    'center-right' => __('Center Right', 'orbit-customs'),
                    'bottom-left' => __('Bottom Left', 'orbit-customs'),
                    'bottom-center' => __('Bottom Center', 'orbit-customs'),
                    'bottom-right' => __('Bottom Right', 'orbit-customs'),
                ),
                'default' => 'center-right',
            )
        );

        $this->add_control(
            'left_tabs',
            array(
                'label' => __('Left Column Tabs', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $left_tabs_repeater->get_controls(),
                'default' => array(
                    array(
                        'tab_title' => __('Creative Design', 'orbit-customs'),
                        'cta_text' => __('View More', 'orbit-customs'),
                    ),
                    array(
                        'tab_title' => __('Development', 'orbit-customs'),
                        'cta_text' => __('View More', 'orbit-customs'),
                    ),
                ),
                'title_field' => '{{{ tab_title }}}',
            )
        );

        // Right Tabs Repeater
        $right_tabs_repeater = new \Elementor\Repeater();

        $right_tabs_repeater->add_control(
            'tab_title',
            array(
                'label' => __('Tab Title', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tab Title', 'orbit-customs'),
                'label_block' => true,
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $right_tabs_repeater->add_control(
            'tab_image',
            array(
                'label' => __('Image', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $right_tabs_repeater->add_control(
            'cta_text',
            array(
                'label' => __('CTA Button Text', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View More', 'orbit-customs'),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $right_tabs_repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Button Link', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'orbit-customs'),
                'default' => array(
                    'url' => '#',
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $right_tabs_repeater->add_control(
            'cta_position',
            array(
                'label' => __('CTA Button Position', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'top-left' => __('Top Left', 'orbit-customs'),
                    'top-center' => __('Top Center', 'orbit-customs'),
                    'top-right' => __('Top Right', 'orbit-customs'),
                    'center-left' => __('Center Left', 'orbit-customs'),
                    'center-center' => __('Center Center', 'orbit-customs'),
                    'center-right' => __('Center Right', 'orbit-customs'),
                    'bottom-left' => __('Bottom Left', 'orbit-customs'),
                    'bottom-center' => __('Bottom Center', 'orbit-customs'),
                    'bottom-right' => __('Bottom Right', 'orbit-customs'),
                ),
                'default' => 'center-right',
            )
        );

        $this->add_control(
            'right_tabs',
            array(
                'label' => __('Right Column Tabs', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $right_tabs_repeater->get_controls(),
                'default' => array(
                    array(
                        'tab_title' => __('Marketing', 'orbit-customs'),
                        'cta_text' => __('View More', 'orbit-customs'),
                    ),
                    array(
                        'tab_title' => __('Photography', 'orbit-customs'),
                        'cta_text' => __('View More', 'orbit-customs'),
                    ),
                ),
                'title_field' => '{{{ tab_title }}}',
            )
        );

        $this->end_controls_section();

        // ========================================
        // CONTENT TAB - Settings
        // ========================================
        $this->start_controls_section(
            'settings_section',
            array(
                'label' => __('Settings', 'orbit-customs'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'enable_overlay',
            array(
                'label' => __('Enable Vignette Overlay', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'orbit-customs'),
                'label_off' => __('No', 'orbit-customs'),
                'return_value' => 'yes',
                'default' => 'no',
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Tab Buttons
        // ========================================
        $this->start_controls_section(
            'style_buttons',
            array(
                'label' => __('Tab Buttons', 'orbit-customs'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .orbit-tab-button',
            )
        );

        $this->start_controls_tabs('button_style_tabs');

        // Normal State
        $this->start_controls_tab(
            'button_normal',
            array(
                'label' => __('Normal', 'orbit-customs'),
            )
        );

        $this->add_control(
            'button_text_color',
            array(
                'label' => __('Text Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_bg_color',
            array(
                'label' => __('Background Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_border_color',
            array(
                'label' => __('Border Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        // Hover State
        $this->start_controls_tab(
            'button_hover',
            array(
                'label' => __('Hover', 'orbit-customs'),
            )
        );

        $this->add_control(
            'button_hover_text_color',
            array(
                'label' => __('Text Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button:hover' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_hover_bg_color',
            array(
                'label' => __('Background Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button:hover' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_hover_border_color',
            array(
                'label' => __('Border Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button:hover' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        // Active State
        $this->start_controls_tab(
            'button_active',
            array(
                'label' => __('Active', 'orbit-customs'),
            )
        );

        $this->add_control(
            'button_active_text_color',
            array(
                'label' => __('Text Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button[aria-selected="true"]' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_active_bg_color',
            array(
                'label' => __('Background Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button[aria-selected="true"]' => 'background: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_active_border_color',
            array(
                'label' => __('Border Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button[aria-selected="true"]' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            array(
                'label' => __('Padding', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'button_border_radius',
            array(
                'label' => __('Border Radius', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-tab-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - CTA Buttons
        // ========================================
        $this->start_controls_section(
            'style_cta',
            array(
                'label' => __('CTA Buttons', 'orbit-customs'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name' => 'cta_typography',
                'selector' => '{{WRAPPER}} .orbit-polaroid-cta',
            )
        );

        $this->add_control(
            'cta_text_color',
            array(
                'label' => __('Text Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid-cta' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'cta_bg_color',
            array(
                'label' => __('Background Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid-cta' => 'background: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'cta_padding',
            array(
                'label' => __('Padding', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'cta_border_radius',
            array(
                'label' => __('Border Radius', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', '%'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid-cta' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Polaroid Images
        // ========================================
        $this->start_controls_section(
            'style_polaroid',
            array(
                'label' => __('Polaroid Images', 'orbit-customs'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'polaroid_bg_color',
            array(
                'label' => __('Border Color', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'polaroid_border_width',
            array(
                'label' => __('Border Width', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px'),
                'range' => array(
                    'px' => array(
                        'min' => 5,
                        'max' => 30,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid' => 'padding: {{SIZE}}{{UNIT}}; padding-bottom: calc({{SIZE}}{{UNIT}} * 2.5);',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'polaroid_shadow',
                'selector' => '{{WRAPPER}} .orbit-polaroid',
            )
        );

        $this->add_responsive_control(
            'image_width',
            array(
                'label' => __('Image Width', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'vw'),
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 800,
                        'step' => 10,
                    ),
                    '%' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => 'px',
                    'size' => 320,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'image_height',
            array(
                'label' => __('Image Height', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', 'vh'),
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 800,
                        'step' => 10,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid img' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'image_aspect_ratio',
            array(
                'label' => __('Aspect Ratio', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => __('Default (Auto)', 'orbit-customs'),
                    '1/1' => __('1:1 (Square)', 'orbit-customs'),
                    '4/3' => __('4:3 (Standard)', 'orbit-customs'),
                    '3/2' => __('3:2 (Classic)', 'orbit-customs'),
                    '16/9' => __('16:9 (Widescreen)', 'orbit-customs'),
                    '9/16' => __('9:16 (Portrait)', 'orbit-customs'),
                    '21/9' => __('21:9 (Ultrawide)', 'orbit-customs'),
                    '3/4' => __('3:4 (Portrait)', 'orbit-customs'),
                ),
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid img' => 'aspect-ratio: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'image_object_fit',
            array(
                'label' => __('Object Fit', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => __('Default', 'orbit-customs'),
                    'cover' => __('Cover', 'orbit-customs'),
                    'contain' => __('Contain', 'orbit-customs'),
                    'fill' => __('Fill', 'orbit-customs'),
                    'none' => __('None', 'orbit-customs'),
                ),
                'default' => 'cover',
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid img' => 'object-fit: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'image_object_position',
            array(
                'label' => __('Object Position', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'center center' => __('Center Center', 'orbit-customs'),
                    'center top' => __('Center Top', 'orbit-customs'),
                    'center bottom' => __('Center Bottom', 'orbit-customs'),
                    'left center' => __('Left Center', 'orbit-customs'),
                    'left top' => __('Left Top', 'orbit-customs'),
                    'left bottom' => __('Left Bottom', 'orbit-customs'),
                    'right center' => __('Right Center', 'orbit-customs'),
                    'right top' => __('Right Top', 'orbit-customs'),
                    'right bottom' => __('Right Bottom', 'orbit-customs'),
                ),
                'default' => 'center center',
                'selectors' => array(
                    '{{WRAPPER}} .orbit-polaroid img' => 'object-position: {{VALUE}};',
                ),
                'condition' => array(
                    'image_object_fit!' => '',
                ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Get image repeater controls
     */
    private function get_image_repeater_controls()
    {
        $image_repeater = new \Elementor\Repeater();

        $image_repeater->add_control(
            'image',
            array(
                'label' => __('Choose Image', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $image_repeater->add_control(
            'cta_text',
            array(
                'label' => __('CTA Button Text', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View More', 'orbit-customs'),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $image_repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Button Link', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'orbit-customs'),
                'default' => array(
                    'url' => '#',
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $image_repeater->add_control(
            'cta_position',
            array(
                'label' => __('CTA Button Position', 'orbit-customs'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'top-left' => __('Top Left', 'orbit-customs'),
                    'top-center' => __('Top Center', 'orbit-customs'),
                    'top-right' => __('Top Right', 'orbit-customs'),
                    'center-left' => __('Center Left', 'orbit-customs'),
                    'center-center' => __('Center Center', 'orbit-customs'),
                    'center-right' => __('Center Right', 'orbit-customs'),
                    'bottom-left' => __('Bottom Left', 'orbit-customs'),
                    'bottom-center' => __('Bottom Center', 'orbit-customs'),
                    'bottom-right' => __('Bottom Right', 'orbit-customs'),
                ),
                'default' => 'center-right',
            )
        );

        return $image_repeater->get_controls();
    }

    /**
     * Render widget output
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $container_id = 'orbit-tabs-' . $this->get_id();

        // Check if we have any tabs
        $has_left_tabs = !empty($settings['left_tabs']);
        $has_right_tabs = !empty($settings['right_tabs']);

        if (!$has_left_tabs && !$has_right_tabs) {
            return;
        }

        $overlay_class = ('yes' === $settings['enable_overlay']) ? 'has-overlay' : '';

        // Merge all tabs for central stage rendering
        $all_tabs = array();
        $tab_index = 0;

        if ($has_left_tabs) {
            foreach ($settings['left_tabs'] as $tab) {
                $all_tabs[] = array(
                    'data' => $tab,
                    'side' => 'left',
                    'index' => $tab_index++
                );
            }
        }

        if ($has_right_tabs) {
            foreach ($settings['right_tabs'] as $tab) {
                $all_tabs[] = array(
                    'data' => $tab,
                    'side' => 'right',
                    'index' => $tab_index++
                );
            }
        }
        ?>
        <div class="orbit-tabs-container" id="<?php echo esc_attr($container_id); ?>">
            <div class="orbit-tabs-wrapper">

                <!-- Left Column -->
                <div class="orbit-tabs-left" role="tablist"
                    aria-label="<?php esc_attr_e('Orbit Tabs Navigation', 'orbit-customs'); ?>">
                    <?php
                    if ($has_left_tabs) {
                        foreach ($all_tabs as $tab_info) {
                            if ($tab_info['side'] === 'left') {
                                $this->render_tab_button($tab_info['data'], $tab_info['index'], $container_id);
                            }
                        }
                    }
                    ?>
                </div>

                <!-- Central Stage -->
                <div class="orbit-tabs-stage <?php echo esc_attr($overlay_class); ?>">
                    <?php
                    foreach ($all_tabs as $tab_info) {
                        $this->render_tab_content($tab_info['data'], $tab_info['index'], $container_id);
                    }
                    ?>
                </div>

                <!-- Right Column -->
                <div class="orbit-tabs-right" role="tablist"
                    aria-label="<?php esc_attr_e('Orbit Tabs Navigation', 'orbit-customs'); ?>">
                    <?php
                    if ($has_right_tabs) {
                        foreach ($all_tabs as $tab_info) {
                            if ($tab_info['side'] === 'right') {
                                $this->render_tab_button($tab_info['data'], $tab_info['index'], $container_id);
                            }
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
        <?php
    }

    /**
     * Render tab button
     */
    private function render_tab_button($tab, $index, $container_id)
    {
        $button_id = $container_id . '-tab-' . $index;
        $panel_id = $container_id . '-panel-' . $index;
        ?>
        <button id="<?php echo esc_attr($button_id); ?>" class="orbit-tab-button" role="tab" aria-selected="false"
            aria-controls="<?php echo esc_attr($panel_id); ?>" tabindex="-1">
            <?php echo esc_html($tab['tab_title']); ?>
        </button>
        <?php
    }

    /**
     * Render tab content
     */
    private function render_tab_content($tab, $index, $container_id)
    {
        $button_id = $container_id . '-tab-' . $index;
        $panel_id = $container_id . '-panel-' . $index;
        ?>
        <div id="<?php echo esc_attr($panel_id); ?>" class="orbit-tab-content" role="tabpanel"
            aria-labelledby="<?php echo esc_attr($button_id); ?>" aria-hidden="true">
            <div class="orbit-polaroid-stack">
                <?php
                // Render single image for this tab
                if (!empty($tab['tab_image']['url'])) {
                    $this->render_polaroid($tab);
                }
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render polaroid image
     */
    private function render_polaroid($tab)
    {
        if (empty($tab['tab_image']['url'])) {
            return;
        }

        $cta_position = !empty($tab['cta_position']) ? $tab['cta_position'] : 'center-right';
        $polaroid_class = 'orbit-polaroid cta-position-' . esc_attr($cta_position);
        ?>
        <div class="<?php echo esc_attr($polaroid_class); ?>">
            <img decoding="async" src="<?php echo esc_url($tab['tab_image']['url']); ?>"
                alt="<?php echo esc_attr($tab['tab_image']['alt'] ?? ''); ?>" loading="lazy">
            <?php if (!empty($tab['cta_text']) && !empty($tab['cta_link']['url'])): ?>
                <?php
                $target = !empty($tab['cta_link']['is_external']) ? 'target="_blank"' : '';
                $nofollow = !empty($tab['cta_link']['nofollow']) ? 'rel="nofollow"' : '';
                ?>
                <a href="<?php echo esc_url($tab['cta_link']['url']); ?>" class="orbit-polaroid-cta" <?php echo $target; ?>
                    <?php echo $nofollow; ?>>
                    <?php echo esc_html($tab['cta_text']); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }
}
