<?php

add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/products/ram', array(
        'methods'  => 'GET',
        'callback' => 'get_ram_products',
    ));
});

function get_ram_products($request) {
    if (!class_exists('WooCommerce')) {
        return new WP_Error('woocommerce_not_found', 'WooCommerce plugin not active.', array('status' => 404));
    }

    // Get query parameters for filtering
    $speed = $request->get_param('speed');
    $ram_type = $request->get_param('ram_type');

    // Prepare arguments for WP_Query
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

    // Apply filters if parameters are set
    if ($speed) {
        $args['meta_query'][] = array(
            'key'     => 'speed',
            'value'   => $speed,
            'compare' => '=', // Adjust the comparison if necessary
        );
    }

    if ($ram_type) {
        $args['meta_query'][] = array(
            'key'     => 'ram_type',
            'value'   => $ram_type,
            'compare' => '=', // Adjust the comparison if necessary
        );
    }

    // Query the products
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
                'acf_fields'  => get_fields($product->get_id()), // Get ACF fields
            );
        }
        wp_reset_postdata();
    }

    return new WP_REST_Response($products, 200);
}
?>
