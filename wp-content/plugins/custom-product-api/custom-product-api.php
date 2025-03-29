<?php
/**
 * Plugin Name: Custom WooCommerce Product API
 * Description: Exposes WooCommerce products through the WordPress REST API with custom filtering options.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include helper functions
// require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';

// Register product routes
require_once plugin_dir_path(__FILE__) . 'routes/products.php';

// Register category-specific routes
require_once plugin_dir_path(__FILE__) . 'routes/cpu.php';
require_once plugin_dir_path(__FILE__) . 'routes/motherboards.php';
require_once plugin_dir_path(__FILE__) . 'routes/ram.php';
?>
