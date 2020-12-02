<?php
/**
 * Tests for BH_WC_REST_Change_Units main setup class. Tests the actions are correctly added.
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_REST_Change_Units\includes;

use BH_WC_REST_Change_Units\woocommerce\API_Product;
use BH_WC_REST_Change_Units\woocommerce\API_Server;
use BH_WC_REST_Change_Units\woocommerce\Settings_Products;

/**
 * Class Develop_Test
 */
class BH_WC_REST_Change_Units_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Verify action to call load textdomain is added.
	 */
	public function test_action_plugins_loaded_load_plugin_textdomain() {

		$action_name       = 'plugins_loaded';
		$expected_priority = 10;

		$class_type = I18n::class;
		$method_name = 'load_plugin_textdomain';

		$function_is_hooked = $this->is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority );

		$this->assertNotFalse( $function_is_hooked );
	}


	/**
	 *
	 */
	public function test_filter_woocommerce_api_product_response_update_weight_legacy_api() {

		$action_name       = 'woocommerce_api_product_response';
		$expected_priority = 10;

		$class_type = API_Product::class;
		$method_name = 'update_weight_legacy_api';

		$function_is_hooked = $this->is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority );

		$this->assertNotFalse( $function_is_hooked );
	}

	/**
	 * Add settings filter.
	 */
	public function test_filter_woocommerce_products_general_settings_add_rest_weight_unit_setting() {

		$action_name       = 'woocommerce_products_general_settings';
		$expected_priority = 10;

		$class_type = Settings_Products::class;
		$method_name = 'add_rest_weight_unit_setting';

		$function_is_hooked = $this->is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority );

		$this->assertNotFalse( $function_is_hooked );
	}


	/**
	 * Check the option filter is registered to display the correct weight unit on the REST API.
	 */
	public function test_filter_pre_option_woocommerce_weight_unit_display_correct_weight_unit() {

		$action_name       = 'pre_option_woocommerce_weight_unit';
		$expected_priority = 10;

		$class_type = API_Server::class;
		$method_name = 'display_correct_weight_unit';

		$function_is_hooked = $this->is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority );

		$this->assertNotFalse( $function_is_hooked );
	}

	/**
	 * Hook for v1 wp-json API.
	 */
	public function test_filter_pwoocommerce_rest_prepare_product_update_weight_wp_json_api() {

		$action_name       = 'woocommerce_rest_prepare_product';
		$expected_priority = 10;

		$class_type = API_Product::class;
		$method_name = 'update_weight_wp_json_api';

		$function_is_hooked = $this->is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority );

		$this->assertNotFalse( $function_is_hooked );
	}

	/**
	 * Hook for v2 wp-json API.
	 */
	public function test_filter_woocommerce_rest_prepare_product_object() {

		$action_name       = 'woocommerce_rest_prepare_product_object';
		$expected_priority = 10;

		$class_type = API_Product::class;
		$method_name = 'update_weight_wp_json_api';

		$function_is_hooked = $this->is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority );

		$this->assertNotFalse( $function_is_hooked );
	}




	protected function is_function_hooked_on_action( $class_type, $method_name, $action_name, $expected_priority = 10 ) {

		global $wp_filter;

		$this->assertArrayHasKey( $action_name, $wp_filter, "$method_name definitely not hooked to $action_name" );

		$actions_hooked = $wp_filter[ $action_name ];

		$this->assertArrayHasKey( $expected_priority, $actions_hooked, "$method_name definitely not hooked to $action_name priority $expected_priority" );

		$hooked_method = null;
		foreach ( $actions_hooked[ $expected_priority ] as $action ) {
			$action_function = $action['function'];
			if ( is_array( $action_function ) ) {
				if ( $action_function[0] instanceof $class_type ) {
					if( $method_name === $action_function[1] ) {
						$hooked_method = $action_function[1];
						break;
					}
				}
			}
		}

		$this->assertNotNull( $hooked_method, "No methods on an instance of $class_type hooked to $action_name" );

		$this->assertEquals( $method_name, $hooked_method, "Unexpected method name for $class_type class hooked to $action_name" );

		return true;
	}
}
