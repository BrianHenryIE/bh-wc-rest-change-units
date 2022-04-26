<?php
/**
 * PHPUnit bootstrap file for WP_Mock.
 *
 * @package    brianhenryie/bh-wc-rest-change-units
 */

WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

global $plugin_root_dir;
require_once $plugin_root_dir . '/autoload.php';

global $project_root_dir;
define( 'WC_ABSPATH', $project_root_dir . '/wp-content/plugins/woocommerce/' );
require_once $project_root_dir . '/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-data.php';
require_once $project_root_dir . '/wp-content/plugins/woocommerce/includes/legacy/abstract-wc-legacy-product.php';
require_once $project_root_dir . '/wp-content/plugins/woocommerce/includes/abstracts/abstract-wc-product.php';
require_once $project_root_dir . '/wp-content/plugins/woocommerce/includes/legacy/api/v2/class-wc-api-server.php';
