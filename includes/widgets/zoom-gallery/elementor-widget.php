<?php
/**
 * Elementor Custom Zoom Gallery Widget
 * Scroll-driven zoom/fade gallery with GSAP ScrollTrigger
 */

namespace EPW_JDT;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Elementor Zoom Gallery Widget Class
 */
class Elementor_Zoom_Gallery_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name
     */
    public function get_name()
    {
        return 'zoom-gallery';
    }

    /**
     * Get widget title
     */
    public function get_title()
    {
        return __('Custom Zoom Gallery', 'epw-jdt');
    }

    /**
     * Get widget icon
     */
    public function get_icon()
    {
        return 'eicon-zoom-in';
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
        return array('zoom', 'gallery', 'scroll', 'fade', 'images', 'scrolltrigger');
    }

    /**
     * Get script dependencies
     */
    public function get_script_depends()
    {
        return array('zoom-gallery');
    }

    /**
     * Get style dependencies
     */
    public function get_style_depends()
    {
        return array('zoom-gallery');
    }

    /**
     * Register widget controls
     */
    protected function register_controls()
    {

        // ========================================
        // CONTENT TAB - Image Source
        // ========================================
        $this->start_controls_section(
            'content_section',
            array(
                'label' => __('Images', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'image_source',
            array(
                'label' => __('Image Source', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'gallery' => __('Gallery', 'epw-jdt'),
                    'repeater' => __('Repeater (with titles & CTAs)', 'epw-jdt'),
                ),
                'default' => 'gallery',
            )
        );

        // Gallery control
        $this->add_control(
            'gallery_images',
            array(
                'label' => __('Add Images', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => array(),
                'condition' => array(
                    'image_source' => 'gallery',
                ),
            )
        );

        // Repeater control
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
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

        $repeater->add_control(
            'title',
            array(
                'label' => __('Title', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $repeater->add_control(
            'cta_text',
            array(
                'label' => __('CTA Text', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $repeater->add_control(
            'cta_link',
            array(
                'label' => __('CTA Link', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'epw-jdt'),
                'default' => array(
                    'url' => '',
                ),
                'dynamic' => array(
                    'active' => true,
                ),
            )
        );

        $this->add_control(
            'items',
            array(
                'label' => __('Gallery Items', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => array(),
                'title_field' => '{{{ title || "Image" }}}',
                'condition' => array(
                    'image_source' => 'repeater',
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // CONTENT TAB - Animation Settings
        // ========================================
        $this->start_controls_section(
            'animation_section',
            array(
                'label' => __('Animation', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'enable_scrub',
            array(
                'label' => __('Scrub Animation', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'epw-jdt'),
                'label_off' => __('No', 'epw-jdt'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'enable_pin',
            array(
                'label' => __('Pin Container', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'epw-jdt'),
                'label_off' => __('No', 'epw-jdt'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'scale_start',
            array(
                'label' => __('Scale Start', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 3,
                        'step' => 0.1,
                    ),
                ),
                'default' => array(
                    'size' => 1,
                ),
            )
        );

        $this->add_control(
            'scale_end',
            array(
                'label' => __('Scale End', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 5,
                        'step' => 0.1,
                    ),
                ),
                'default' => array(
                    'size' => 2.5,
                ),
            )
        );

        $this->add_control(
            'fade_start',
            array(
                'label' => __('Fade Start (fraction of scroll)', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.05,
                    ),
                ),
                'default' => array(
                    'size' => 0.6,
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Container
        // ========================================
        $this->start_controls_section(
            'style_container',
            array(
                'label' => __('Container', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'container_height',
            array(
                'label' => __('Height', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('vh', 'px'),
                'range' => array(
                    'vh' => array(
                        'min' => 50,
                        'max' => 150,
                    ),
                    'px' => array(
                        'min' => 300,
                        'max' => 1200,
                    ),
                ),
                'default' => array(
                    'unit' => 'vh',
                    'size' => 100,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-inner' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'container_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-container' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'container_padding',
            array(
                'label' => __('Padding', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Image
        // ========================================
        $this->start_controls_section(
            'style_image',
            array(
                'label' => __('Image', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'image_border_radius',
            array(
                'label' => __('Border Radius', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'image_shadow',
                'selector' => '{{WRAPPER}} .epw-zoom-item img',
            )
        );

        $this->add_responsive_control(
            'image_max_width',
            array(
                'label' => __('Max Width', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array('px', '%', 'vw'),
                'range' => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 1600,
                        'step' => 10,
                    ),
                    '%' => array(
                        'min' => 20,
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'unit' => 'px',
                    'size' => 800,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-item img' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - Title
        // ========================================
        $this->start_controls_section(
            'style_title',
            array(
                'label' => __('Title', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'image_source' => 'repeater',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .epw-zoom-title',
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label' => __('Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'title_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-title' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'title_padding',
            array(
                'label' => __('Padding', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ========================================
        // STYLE TAB - CTA Button
        // ========================================
        $this->start_controls_section(
            'style_cta',
            array(
                'label' => __('CTA Button', 'epw-jdt'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'image_source' => 'repeater',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name' => 'cta_typography',
                'selector' => '{{WRAPPER}} .epw-zoom-cta',
            )
        );

        $this->add_control(
            'cta_text_color',
            array(
                'label' => __('Text Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-cta' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'cta_bg_color',
            array(
                'label' => __('Background Color', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.15)',
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-cta' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'cta_padding',
            array(
                'label' => __('Padding', 'epw-jdt'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em'),
                'selectors' => array(
                    '{{WRAPPER}} .epw-zoom-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .epw-zoom-cta' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Build items array from either source
        $items = array();

        if ('gallery' === $settings['image_source'] && !empty($settings['gallery_images'])) {
            foreach ($settings['gallery_images'] as $image) {
                $items[] = array(
                    'image_url' => $image['url'],
                    'image_alt' => '',
                    'title' => '',
                    'cta_text' => '',
                    'cta_url' => '',
                );
            }
        } elseif ('repeater' === $settings['image_source'] && !empty($settings['items'])) {
            foreach ($settings['items'] as $item) {
                $items[] = array(
                    'image_url' => !empty($item['image']['url']) ? $item['image']['url'] : '',
                    'image_alt' => !empty($item['image']['alt']) ? $item['image']['alt'] : '',
                    'title' => !empty($item['title']) ? $item['title'] : '',
                    'cta_text' => !empty($item['cta_text']) ? $item['cta_text'] : '',
                    'cta_url' => !empty($item['cta_link']['url']) ? $item['cta_link']['url'] : '',
                    'cta_external' => !empty($item['cta_link']['is_external']),
                    'cta_nofollow' => !empty($item['cta_link']['nofollow']),
                );
            }
        }

        if (empty($items)) {
            return;
        }

        // Gallery config for JS
        $gallery_config = array(
            'scrub' => 'yes' === $settings['enable_scrub'],
            'pin' => 'yes' === $settings['enable_pin'],
            'scaleStart' => !empty($settings['scale_start']['size']) ? (float) $settings['scale_start']['size'] : 1,
            'scaleEnd' => !empty($settings['scale_end']['size']) ? (float) $settings['scale_end']['size'] : 2.5,
            'fadeStart' => !empty($settings['fade_start']['size']) ? (float) $settings['fade_start']['size'] : 0.6,
        );

        $total_items = count($items);
        ?>
        <div class="epw-zoom-container" data-gallery-config="<?php echo esc_attr(wp_json_encode($gallery_config)); ?>">
            <div class="epw-zoom-inner">
                <?php foreach ($items as $index => $item) :
                    if (empty($item['image_url'])) continue;
                    $z_index = $total_items - $index;
                ?>
                    <div class="epw-zoom-item" style="z-index: <?php echo esc_attr($z_index); ?>;" data-index="<?php echo esc_attr($index); ?>">
                        <img src="<?php echo esc_url($item['image_url']); ?>"
                             alt="<?php echo esc_attr($item['image_alt']); ?>"
                             loading="lazy" decoding="async">
                        <?php if (!empty($item['title'])) : ?>
                            <div class="epw-zoom-title"><?php echo esc_html($item['title']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($item['cta_text']) && !empty($item['cta_url'])) :
                            $target = !empty($item['cta_external']) ? 'target="_blank"' : '';
                            $nofollow = !empty($item['cta_nofollow']) ? 'rel="nofollow noopener"' : 'rel="noopener"';
                        ?>
                            <a href="<?php echo esc_url($item['cta_url']); ?>" class="epw-zoom-cta" <?php echo $target; ?> <?php echo $nofollow; ?>>
                                <?php echo esc_html($item['cta_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
