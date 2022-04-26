<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       https://github.com/BrianHenryIE/bh-wc-rest-change-units
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-rest-change-units
 */

namespace BrianHenryIE\WC_REST_Change_Units\WP_Includes;

use BrianHenryIE\WC_REST_Change_Units\WooCommerce\API_Product;
use BrianHenryIE\WC_REST_Change_Units\WooCommerce\API_Server;
use BrianHenryIE\WC_REST_Change_Units\WooCommerce\Settings_Products;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class BH_WC_REST_Change_Units {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_locale();

		$this->define_rest_hooks();
		$this->define_ui_hooks();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	protected function set_locale(): void {

		$plugin_i18n = new I18n();

		add_action( 'init', array( $plugin_i18n, 'load_plugin_textdomain' ) );
	}

	/**
	 * Add filters to REST API responses and WooCommerce product settings page.
	 */
	protected function define_rest_hooks(): void {

		// Convert product weight units.
		$api_product = new API_Product();
		// For legacy API.
		add_filter( 'woocommerce_api_product_response', array( $api_product, 'update_weight_legacy_api' ), 10, 4 );
		// For wp-json/wc/v1.
		add_filter( 'woocommerce_rest_prepare_product', array( $api_product, 'update_weight_wp_json_api' ), 10, 3 );
		// For wp-json/wc/v2.
		add_filter( 'woocommerce_rest_prepare_product_object', array( $api_product, 'update_weight_wp_json_api' ), 10, 3 );

		// Return the corresponding weight unit.
		$api_server = new API_Server();
		// For legacy API.
		add_filter( 'woocommerce_api_index', array( $api_server, 'change_product_weight_option_in_legacy_schema' ), 10, 1 );
		// For wp-json API.
		add_filter( 'woocommerce_rest_product_schema', array( $api_server, 'change_product_weight_option_in_wp_json_schema' ), 10, 1 );
	}

	protected function define_ui_hooks(): void {

		// Add configuration option in WooCommerce.
		$settings = new Settings_Products();
		add_filter( 'woocommerce_products_general_settings', array( $settings, 'add_rest_weight_unit_setting' ), 10, 1 );

	}

}
