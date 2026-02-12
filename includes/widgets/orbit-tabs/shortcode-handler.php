<?php
/**
 * Polaroid Tabs Shortcode Handler
 * Renders the HTML structure for the Polaroid Tabs component
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Polaroid Tabs component via shortcode
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function epw_jdt_orbit_tabs_shortcode($atts)
{
    // Enqueue assets
    wp_enqueue_style('orbit-tabs');
    wp_enqueue_script('orbit-tabs');

    // Parse attributes with defaults
    $atts = shortcode_atts(
        array(
            'id' => 'epw-tabs-' . uniqid(),
        ),
        $atts,
        'orbit_tabs'
    );

    // Generate unique ID for this instance
    $container_id = sanitize_html_class($atts['id']);

    // Default demo content
    $left_tabs = epw_jdt_get_default_left_tabs();
    $right_tabs = epw_jdt_get_default_right_tabs();

    // Start output buffering
    ob_start();
    ?>

    <div class="epw-tabs-container" id="<?php echo esc_attr($container_id); ?>">
        <div class="epw-tabs-wrapper">

            <!-- Left Column -->
            <div class="epw-tabs-left" role="tablist"
                aria-label="<?php esc_attr_e('Tabs Navigation', 'epw-jdt'); ?>">
                <?php
                foreach ($left_tabs as $index => $tab) {
                    epw_jdt_render_tab_button($tab, $index, $container_id);
                }
                ?>
            </div>

            <!-- Central Stage -->
            <div class="epw-tabs-stage">
                <?php
                $all_tabs = array_merge($left_tabs, $right_tabs);
                foreach ($all_tabs as $index => $tab) {
                    epw_jdt_render_tab_content($tab, $index, $container_id);
                }
                ?>
            </div>

            <!-- Right Column -->
            <div class="epw-tabs-right" role="tablist"
                aria-label="<?php esc_attr_e('Tabs Navigation', 'epw-jdt'); ?>">
                <?php
                $right_offset = count($left_tabs);
                foreach ($right_tabs as $index => $tab) {
                    epw_jdt_render_tab_button($tab, $right_offset + $index, $container_id);
                }
                ?>
            </div>

        </div>
    </div>

    <?php
    return ob_get_clean();
}

/**
 * Render a single tab button
 *
 * @param array  $tab Tab data
 * @param int    $index Tab index
 * @param string $container_id Container ID
 */
function epw_jdt_render_tab_button($tab, $index, $container_id)
{
    $button_id = $container_id . '-tab-' . $index;
    $panel_id = $container_id . '-panel-' . $index;
    ?>
    <button id="<?php echo esc_attr($button_id); ?>" class="epw-tab-button" role="tab" aria-selected="false"
        aria-controls="<?php echo esc_attr($panel_id); ?>" tabindex="-1">
        <?php echo esc_html($tab['title']); ?>
    </button>
    <?php
}

/**
 * Render a single tab content panel
 *
 * @param array  $tab Tab data
 * @param int    $index Tab index
 * @param string $container_id Container ID
 */
function epw_jdt_render_tab_content($tab, $index, $container_id)
{
    $button_id = $container_id . '-tab-' . $index;
    $panel_id = $container_id . '-panel-' . $index;
    ?>
    <div id="<?php echo esc_attr($panel_id); ?>" class="epw-tab-content" role="tabpanel"
        aria-labelledby="<?php echo esc_attr($button_id); ?>" aria-hidden="true">
        <div class="epw-polaroid-stack">
            <?php
            if (!empty($tab['image'])) {
                epw_jdt_render_polaroid($tab);
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Render a single Polaroid image
 *
 * @param array $tab Tab data with image
 */
function epw_jdt_render_polaroid($tab)
{
    $cta_position = !empty($tab['cta_position']) ? $tab['cta_position'] : 'center-right';
    $polaroid_class = 'epw-polaroid cta-position-' . esc_attr($cta_position);
    ?>
    <div class="<?php echo esc_attr($polaroid_class); ?>">
        <img src="<?php echo esc_url($tab['image']['url']); ?>" alt="<?php echo esc_attr($tab['image']['alt']); ?>"
            loading="lazy" decoding="async">
        <?php if (!empty($tab['cta_text']) && !empty($tab['cta_link'])): ?>
            <a href="<?php echo esc_url($tab['cta_link']); ?>" class="epw-polaroid-cta" target="_blank"
                rel="noopener noreferrer">
                <?php echo esc_html($tab['cta_text']); ?>
            </a>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Get default demo tabs for left column
 *
 * @return array Default left tabs configuration
 */
function epw_jdt_get_default_left_tabs()
{
    $placeholder_base = 'https://via.placeholder.com/';

    return array(
        array(
            'title' => __('Creative Design', 'epw-jdt'),
            'image' => array(
                'url' => $placeholder_base . '400x500/2196F3/FFFFFF?text=Design',
                'alt' => __('Creative Design', 'epw-jdt'),
            ),
            'cta_text' => __('View Project', 'epw-jdt'),
            'cta_link' => '#',
            'cta_position' => 'center-right',
        ),
        array(
            'title' => __('Development', 'epw-jdt'),
            'image' => array(
                'url' => $placeholder_base . '400x500/4CAF50/FFFFFF?text=Code',
                'alt' => __('Development', 'epw-jdt'),
            ),
            'cta_text' => __('Learn More', 'epw-jdt'),
            'cta_link' => '#',
            'cta_position' => 'center-right',
        ),
    );
}

/**
 * Get default demo tabs for right column
 *
 * @return array Default right tabs configuration
 */
function epw_jdt_get_default_right_tabs()
{
    $placeholder_base = 'https://via.placeholder.com/';

    return array(
        array(
            'title' => __('Marketing', 'epw-jdt'),
            'image' => array(
                'url' => $placeholder_base . '400x500/FF9800/FFFFFF?text=Marketing',
                'alt' => __('Marketing', 'epw-jdt'),
            ),
            'cta_text' => __('Explore', 'epw-jdt'),
            'cta_link' => '#',
            'cta_position' => 'center-right',
        ),
        array(
            'title' => __('Photography', 'epw-jdt'),
            'image' => array(
                'url' => $placeholder_base . '400x500/9C27B0/FFFFFF?text=Photo',
                'alt' => __('Photography', 'epw-jdt'),
            ),
            'cta_text' => __('Gallery', 'epw-jdt'),
            'cta_link' => '#',
            'cta_position' => 'center-right',
        ),
    );
}
