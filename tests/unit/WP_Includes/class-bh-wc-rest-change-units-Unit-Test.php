<?php

namespace BrianHenryIE\WC_REST_Change_Units\WP_Includes;

use BrianHenryIE\WC_REST_Change_Units\WooCommerce\API_Product;
use BrianHenryIE\WC_REST_Change_Units\WooCommerce\API_Server;
use BrianHenryIE\WC_REST_Change_Units\WooCommerce\Settings_Products;
use WP_Mock\Matcher\AnyInstance;

/**
 * @coversDefaultClass \BrianHenryIE\WC_REST_Change_Units\WP_Includes\BH_WC_REST_Change_Units
 */
class BH_WC_REST_Change_Units_Unit_Test extends \Codeception\Test\Unit {

	protected function setup(): void {
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::_tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::set_locale
	 * @covers ::__construct
	 */
	public function test_set_locale_hooked(): void {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		new BH_WC_REST_Change_Units();
	}

	/**
	 * @covers ::define_rest_hooks
	 */
	public function test_define_rest_hooks(): void {

		\WP_Mock::expectFilterAdded(
			'woocommerce_api_product_response',
			array( new AnyInstance( API_Product::class ), 'update_weight_legacy_api' ),
			10,
			4
		);

		\WP_Mock::expectFilterAdded(
			'woocommerce_rest_prepare_product',
			array( new AnyInstance( API_Product::class ), 'update_weight_wp_json_api' ),
			10,
			3
		);

		\WP_Mock::expectFilterAdded(
			'woocommerce_rest_prepare_product_object',
			array( new AnyInstance( API_Product::class ), 'update_weight_wp_json_api' ),
			10,
			3
		);

		\WP_Mock::expectFilterAdded(
			'woocommerce_api_index',
			array( new AnyInstance( API_Server::class ), 'change_product_weight_option_in_legacy_schema' ),
			10,
			1
		);

		\WP_Mock::expectFilterAdded(
			'woocommerce_rest_product_schema',
			array( new AnyInstance( API_Server::class ), 'change_product_weight_option_in_wp_json_schema' ),
			10,
			1
		);

		new BH_WC_REST_Change_Units();

	}

	/**
	 * @covers ::define_ui_hooks
	 */
	public function test_define_ui_hooks(): void {

		\WP_Mock::expectFilterAdded(
			'woocommerce_products_general_settings',
			array( new AnyInstance( Settings_Products::class ), 'add_rest_weight_unit_setting' ),
			10,
			1
		);

		new BH_WC_REST_Change_Units();

	}
}
