<?php

add_action('rest_api_init', function () {
    // Route to get all RAM products
    register_rest_route('wp/v2', '/products/ram', array(
        'methods'  => 'GET',
        'callback' => 'get_ram_products',
    ));

    // Route to get a specific RAM product by ID
    register_rest_route('wp/v2', '/products/ram/(?P<id>\d+)', array(
        'methods'  => 'GET',
        'callback' => 'get_ram_product_by_id',
    ));
});

// Function to get all RAM products
function get_ram_products($request) {
    if (!class_exists('WooCommerce')) {
        return new WP_Error('woocommerce_not_found', 'WooCommerce plugin not active.', array('status' => 404));
    }

    $speed = $request->get_param('speed');
    $ram_type = $request->get_param('ram_type');

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'ram',
            ),
        ),
        'meta_query'     => array(),
    );

    if ($speed) {
        $args['meta_query'][] = array(
            'key'     => 'speed',
            'value'   => $speed,
            'compare' => '=',
        );
    }

    if ($ram_type) {
        $args['meta_query'][] = array(
            'key'     => 'ram_type',
            'value'   => $ram_type,
            'compare' => '=',
        );
    }

    $query = new WP_Query($args);
    $products = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());

            $products[] = array(
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
        wp_reset_postdata();
    }

    return new WP_REST_Response($products, 200);
}

// Function to get a specific RAM product by ID
function get_ram_product_by_id($request) {
    if (!class_exists('WooCommerce')) {
        return new WP_Error('woocommerce_not_found', 'WooCommerce plugin not active.', array('status' => 404));
    }

    $product_id = (int) $request['id'];
    $product = wc_get_product($product_id);

    if (!$product || $product->get_type() !== 'simple' || !has_term('ram', 'product_cat', $product_id)) {
        return new WP_Error('product_not_found', 'RAM product not found.', array('status' => 404));
    }

    $product_data = array(
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

    return new WP_REST_Response($product_data, 200);
}
?>
