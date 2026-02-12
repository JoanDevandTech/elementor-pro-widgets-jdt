<?php
/**
 * Zoom Gallery Shortcode Handler
 * Renders the HTML structure for the Custom Zoom Gallery component
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Zoom Gallery component via shortcode
 *
 * @param array $atts Shortcode attributes
 * @return string HTML output
 */
function epw_jdt_zoom_gallery_shortcode($atts)
{
    // Enqueue assets
    wp_enqueue_style('zoom-gallery');
    wp_enqueue_script('zoom-gallery');

    // Parse attributes with defaults
    $atts = shortcode_atts(
        array(
            'images' => '',
        ),
        $atts,
        'zoom_gallery'
    );

    // Build items from attachment IDs or use demo placeholders
    $items = array();

    if (!empty($atts['images'])) {
        $image_ids = array_map('intval', explode(',', $atts['images']));
        foreach ($image_ids as $id) {
            $url = wp_get_attachment_image_url($id, 'large');
            $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
            if ($url) {
                $items[] = array(
                    'image_url' => $url,
                    'image_alt' => $alt ?: '',
                );
            }
        }
    }

    // Default demo items if no images provided
    if (empty($items)) {
        $placeholder_base = 'https://via.placeholder.com/';
        $items = array(
            array(
                'image_url' => $placeholder_base . '800x600/2196F3/FFFFFF?text=Image+1',
                'image_alt' => __('Demo Image 1', 'epw-jdt'),
            ),
            array(
                'image_url' => $placeholder_base . '800x600/4CAF50/FFFFFF?text=Image+2',
                'image_alt' => __('Demo Image 2', 'epw-jdt'),
            ),
            array(
                'image_url' => $placeholder_base . '800x600/FF9800/FFFFFF?text=Image+3',
                'image_alt' => __('Demo Image 3', 'epw-jdt'),
            ),
        );
    }

    $total_items = count($items);

    // Gallery config
    $gallery_config = array(
        'scrub' => true,
        'pin' => true,
        'scaleStart' => 1,
        'scaleEnd' => 2.5,
        'fadeStart' => 0.6,
    );

    // Start output buffering
    ob_start();
    ?>
    <div class="epw-zoom-container" data-gallery-config="<?php echo esc_attr(wp_json_encode($gallery_config)); ?>">
        <div class="epw-zoom-inner">
            <?php foreach ($items as $index => $item) :
                $z_index = $total_items - $index;
            ?>
                <div class="epw-zoom-item" style="z-index: <?php echo esc_attr($z_index); ?>;" data-index="<?php echo esc_attr($index); ?>">
                    <img src="<?php echo esc_url($item['image_url']); ?>"
                         alt="<?php echo esc_attr($item['image_alt']); ?>"
                         loading="lazy" decoding="async">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
