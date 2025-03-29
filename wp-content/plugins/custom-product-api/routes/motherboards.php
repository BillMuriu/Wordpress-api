<?php

add_action('rest_api_init', function () {
    // Get all motherboards
    register_rest_route('wp/v2', '/products/motherboards', array(
        'methods'  => 'GET',
        'callback' => 'get_motherboard_products',
    ));

    // Get a specific motherboard by ID
    register_rest_route('wp/v2', '/products/motherboards/(?P<id>\d+)', array(
        'methods'  => 'GET',
        'callback' => 'get_motherboard_product_by_id',
        'args'     => array(
            'id' => array(
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                }
            ),
        ),
    ));
});

function get_motherboard_products($request) {
    if (!class_exists('WooCommerce')) {
        return new WP_Error('woocommerce_not_found', 'WooCommerce plugin not active.', array('status' => 404));
    }

    // Get query parameters for filtering
    $chipsets = $request->get_param('chipsets');
    $ram_type = $request->get_param('ram_type');
    $socket = $request->get_param('socket');

    // Prepare WP_Query arguments
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'motherboards',
            ),
        ),
        'meta_query'     => array(),
    );

    // Filter by chipsets
    if ($chipsets) {
        $chipset_array = explode(',', $chipsets);
        $chipset_meta_query = array('relation' => 'OR');
        foreach ($chipset_array as $chipset) {
            $chipset_meta_query[] = array(
                'key'     => 'chipset',
                'value'   => $chipset,
                'compare' => 'LIKE',
            );
        }
        $args['meta_query'][] = $chipset_meta_query;
    }

    // Filter by RAM type
    if ($ram_type) {
        $args['meta_query'][] = array(
            'key'     => 'ram_type',
            'value'   => $ram_type,
            'compare' => '=',
        );
    }

    // Filter by socket
    if ($socket) {
        $args['meta_query'][] = array(
            'key'     => 'socket',
            'value'   => $socket,
            'compare' => '=',
        );
    }

    // Query the products
    $query = new WP_Query($args);
    $products = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());

            $products[] = format_motherboard_product($product);
        }
        wp_reset_postdata();
    }

    return new WP_REST_Response($products, 200);
}

// Function to get a specific motherboard by ID
function get_motherboard_product_by_id($request) {
    $id = $request['id'];

    if (!class_exists('WooCommerce')) {
        return new WP_Error('woocommerce_not_found', 'WooCommerce plugin not active.', array('status' => 404));
    }

    $product = wc_get_product($id);

    if (!$product || $product->get_type() !== 'simple') {
        return new WP_Error('product_not_found', 'Motherboard not found.', array('status' => 404));
    }

    return new WP_REST_Response(format_motherboard_product($product), 200);
}

// Helper function to format the product data
function format_motherboard_product($product) {
    return array(
        'id'          => $product->get_id(),
        'name'        => $product->get_name(),
        'price'       => $product->get_price(),
        'description' => $product->get_description(),
        'sku'         => $product->get_sku(),
        'image'       => wp_get_attachment_url($product->get_image_id()),
        'permalink'   => get_permalink($product->get_id()),
        'stock_status'=> $product->get_stock_status(),
        'is_in_stock' => $product->is_in_stock(),
        'categories'  => wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'names')),
        'acf_fields'  => get_fields($product->get_id()),
    );
}
?>
