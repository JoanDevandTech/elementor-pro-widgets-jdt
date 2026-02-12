<?php
/**
 * Elementor Polaroid Tabs Widget
 * Custom widget for Elementor integration with full style controls
 */

namespace EPW_JDT;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Elementor Polaroid Tabs Widget Class
 */
class Elementor_JDT_Tabs_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name
     */
    public function get_name()
    {
        return 'jdt-tabs';
    }

    /**
     * Get widget title
     */
    public function get_title()
    {
        return __('Polaroid Tabs', 'epw-jdt');
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
        return array('tabs', 'polaroid', 'gallery', 'images');
    }

    /**
     * Get script dependencies
     */
    public function get_script_depends()
    {
        return array('jdt-tabs');
    }

    /**
     * Get style dependencies
     */
    public function get_style_depends()
    {
        return array('jdt-tabs');
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
                'label' => __('Tabs', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        // Left Tabs Repeater
        $left_tabs_repeater = new \Elementor\Repeater();

        $left_tabs_repeater->add_control(
            'tab_title',
            array(
                'label' => __('Tab Title', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tab Title', 'epw-jdt'),
                'label_block' => true,
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $left_tabs_repeater->add_control(
            'tab_image',
            array(
                'label' => __('Image', 'epw-jdt'),
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
                'label' => __('CTA Button Text', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View More', 'epw-jdt'),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $left_tabs_repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Button Link', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'epw-jdt'),
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
                'label' => __('CTA Button Position', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'top-left' => __('Top Left', 'epw-jdt'),
                    'top-center' => __('Top Center', 'epw-jdt'),
                    'top-right' => __('Top Right', 'epw-jdt'),
                    'center-left' => __('Center Left', 'epw-jdt'),
                    'center-center' => __('Center Center', 'epw-jdt'),
                    'center-right' => __('Center Right', 'epw-jdt'),
                    'bottom-left' => __('Bottom Left', 'epw-jdt'),
                    'bottom-center' => __('Bottom Center', 'epw-jdt'),
                    'bottom-right' => __('Bottom Right', 'epw-jdt'),
                ),
                'default' => 'center-right',
            )
        );

        $this->add_control(
            'left_tabs',
            array(
                'label' => __('Left Column Tabs', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $left_tabs_repeater->get_controls(),
                'default' => array(
                    array(
                        'tab_title' => __('Creative Design', 'epw-jdt'),
                        'cta_text' => __('View More', 'epw-jdt'),
                    ),
                    array(
                        'tab_title' => __('Development', 'epw-jdt'),
                        'cta_text' => __('View More', 'epw-jdt'),
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
                'label' => __('Tab Title', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tab Title', 'epw-jdt'),
                'label_block' => true,
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $right_tabs_repeater->add_control(
            'tab_image',
            array(
                'label' => __('Image', 'epw-jdt'),
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
                'label' => __('CTA Button Text', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View More', 'epw-jdt'),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $right_tabs_repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Button Link', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'epw-jdt'),
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
                'label' => __('CTA Button Position', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'top-left' => __('Top Left', 'epw-jdt'),
                    'top-center' => __('Top Center', 'epw-jdt'),
                    'top-right' => __('Top Right', 'epw-jdt'),
                    'center-left' => __('Center Left', 'epw-jdt'),
                    'center-center' => __('Center Center', 'epw-jdt'),
                    'center-right' => __('Center Right', 'epw-jdt'),
                    'bottom-left' => __('Bottom Left', 'epw-jdt'),
                    'bottom-center' => __('Bottom Center', 'epw-jdt'),
                    'bottom-right' => __('Bottom Right', 'epw-jdt'),
                ),
                'default' => 'center-right',
            )
        );

        $this->add_control(
            'right_tabs',
            array(
                'label' => __('Right Column Tabs', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $right_tabs_repeater->get_controls(),
                'default' => array(
                    array(
                        'tab_title' => __('Marketing', 'epw-jdt'),
                        'cta_text' => __('View More', 'epw-jdt'),
                    ),
                    array(
                        'tab_title' => __('Photography', 'epw-jdt'),
                        'cta_text' => __('View More', 'epw-jdt'),
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
                'label' => __('Settings', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'enable_overlay',
            array(
                'label' => __('Enable Vignette Overlay', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'epw-jdt'),
                'label_off' => __('No', 'epw-jdt'),
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
                'label' => __('Tab Buttons', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .epw-tab-button',
            )
        );

        $this->start_controls_tabs('button_style_tabs');

        // Normal State
        $this->start_controls_tab(
            'button_normal',
            array(
                'label' => __('Normal', 'epw-jdt'),
            )
        );

        $this->add_control(
            'button_text_color',
            array(
                'label' => __('Text Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_border_color',
            array(
                'label' => __('Border Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        // Hover State
        $this->start_controls_tab(
            'button_hover',
            array(
                'label' => __('Hover', 'epw-jdt'),
            )
        );

        $this->add_control(
            'button_hover_text_color',
            array(
                'label' => __('Text Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button:hover' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_hover_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button:hover' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_hover_border_color',
            array(
                'label' => __('Border Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button:hover' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        // Active State
        $this->start_controls_tab(
            'button_active',
            array(
                'label' => __('Active', 'epw-jdt'),
            )
        );

        $this->add_control(
            'button_active_text_color',
            array(
                'label' => __('Text Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button[aria-selected="true"]' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_active_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button[aria-selected="true"]' => 'background: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_active_border_color',
            array(
                'label' => __('Border Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button[aria-selected="true"]' => 'border-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            array(
                'label' => __('Padding', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'button_border_radius',
            array(
                'label' => __('Border Radius', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-tab-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label' => __('CTA Buttons', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name' => 'cta_typography',
                'selector' => '{{WRAPPER}} .epw-polaroid-cta',
            )
        );

        $this->add_control(
            'cta_text_color',
            array(
                'label' => __('Text Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid-cta' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'cta_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid-cta' => 'background: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'cta_padding',
            array(
                'label' => __('Padding', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'cta_border_radius',
            array(
                'label' => __('Border Radius', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', '%'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid-cta' => 'border-radius: {{SIZE}}{{UNIT}};',
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
                'label' => __('Polaroid Images', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'polaroid_bg_color',
            array(
                'label' => __('Border Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid' => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'polaroid_border_width',
            array(
                'label' => __('Border Width', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px'),
                'range' => array(
                    'px' => array(
                        'min' => 5,
                        'max' => 30,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid' => 'padding: {{SIZE}}{{UNIT}}; padding-bottom: calc({{SIZE}}{{UNIT}} * 2.5);',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'polaroid_shadow',
                'selector' => '{{WRAPPER}} .epw-polaroid',
            )
        );

        $this->add_responsive_control(
            'image_width',
            array(
                'label' => __('Image Width', 'epw-jdt'),
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
                    '{{WRAPPER}} .epw-polaroid' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'image_height',
            array(
                'label' => __('Image Height', 'epw-jdt'),
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
                    '{{WRAPPER}} .epw-polaroid img' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'image_aspect_ratio',
            array(
                'label' => __('Aspect Ratio', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => __('Default (Auto)', 'epw-jdt'),
                    '1/1' => __('1:1 (Square)', 'epw-jdt'),
                    '4/3' => __('4:3 (Standard)', 'epw-jdt'),
                    '3/2' => __('3:2 (Classic)', 'epw-jdt'),
                    '16/9' => __('16:9 (Widescreen)', 'epw-jdt'),
                    '9/16' => __('9:16 (Portrait)', 'epw-jdt'),
                    '21/9' => __('21:9 (Ultrawide)', 'epw-jdt'),
                    '3/4' => __('3:4 (Portrait)', 'epw-jdt'),
                ),
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid img' => 'aspect-ratio: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'image_object_fit',
            array(
                'label' => __('Object Fit', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => __('Default', 'epw-jdt'),
                    'cover' => __('Cover', 'epw-jdt'),
                    'contain' => __('Contain', 'epw-jdt'),
                    'fill' => __('Fill', 'epw-jdt'),
                    'none' => __('None', 'epw-jdt'),
                ),
                'default' => 'cover',
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid img' => 'object-fit: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'image_object_position',
            array(
                'label' => __('Object Position', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'center center' => __('Center Center', 'epw-jdt'),
                    'center top' => __('Center Top', 'epw-jdt'),
                    'center bottom' => __('Center Bottom', 'epw-jdt'),
                    'left center' => __('Left Center', 'epw-jdt'),
                    'left top' => __('Left Top', 'epw-jdt'),
                    'left bottom' => __('Left Bottom', 'epw-jdt'),
                    'right center' => __('Right Center', 'epw-jdt'),
                    'right top' => __('Right Top', 'epw-jdt'),
                    'right bottom' => __('Right Bottom', 'epw-jdt'),
                ),
                'default' => 'center center',
                'selectors' => array(
                    '{{WRAPPER}} .epw-polaroid img' => 'object-position: {{VALUE}};',
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
                'label' => __('Choose Image', 'epw-jdt'),
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
                'label' => __('CTA Button Text', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('View More', 'epw-jdt'),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $image_repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Button Link', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'epw-jdt'),
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
                'label' => __('CTA Button Position', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'top-left' => __('Top Left', 'epw-jdt'),
                    'top-center' => __('Top Center', 'epw-jdt'),
                    'top-right' => __('Top Right', 'epw-jdt'),
                    'center-left' => __('Center Left', 'epw-jdt'),
                    'center-center' => __('Center Center', 'epw-jdt'),
                    'center-right' => __('Center Right', 'epw-jdt'),
                    'bottom-left' => __('Bottom Left', 'epw-jdt'),
                    'bottom-center' => __('Bottom Center', 'epw-jdt'),
                    'bottom-right' => __('Bottom Right', 'epw-jdt'),
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
        $container_id = 'epw-tabs-' . $this->get_id();

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
        <div class="epw-tabs-container" id="<?php echo esc_attr($container_id); ?>">
            <div class="epw-tabs-wrapper">

                <!-- Left Column -->
                <div class="epw-tabs-left" role="tablist"
                    aria-label="<?php esc_attr_e('Tabs Navigation', 'epw-jdt'); ?>">
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
                <div class="epw-tabs-stage <?php echo esc_attr($overlay_class); ?>">
                    <?php
                    foreach ($all_tabs as $tab_info) {
                        $this->render_tab_content($tab_info['data'], $tab_info['index'], $container_id);
                    }
                    ?>
                </div>

                <!-- Right Column -->
                <div class="epw-tabs-right" role="tablist"
                    aria-label="<?php esc_attr_e('Tabs Navigation', 'epw-jdt'); ?>">
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
        <button id="<?php echo esc_attr($button_id); ?>" class="epw-tab-button" role="tab" aria-selected="false"
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
        <div id="<?php echo esc_attr($panel_id); ?>" class="epw-tab-content" role="tabpanel"
            aria-labelledby="<?php echo esc_attr($button_id); ?>" aria-hidden="true">
            <div class="epw-polaroid-stack">
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
        $polaroid_class = 'epw-polaroid cta-position-' . esc_attr($cta_position);
        ?>
        <div class="<?php echo esc_attr($polaroid_class); ?>">
            <img decoding="async" src="<?php echo esc_url($tab['tab_image']['url']); ?>"
                alt="<?php echo esc_attr($tab['tab_image']['alt'] ?? ''); ?>" loading="lazy">
            <?php if (!empty($tab['cta_text']) && !empty($tab['cta_link']['url'])): ?>
                <?php
                $target = !empty($tab['cta_link']['is_external']) ? 'target="_blank"' : '';
                $nofollow = !empty($tab['cta_link']['nofollow']) ? 'rel="nofollow"' : '';
                ?>
                <a href="<?php echo esc_url($tab['cta_link']['url']); ?>" class="epw-polaroid-cta" <?php echo $target; ?>
                    <?php echo $nofollow; ?>>
                    <?php echo esc_html($tab['cta_text']); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }
}
