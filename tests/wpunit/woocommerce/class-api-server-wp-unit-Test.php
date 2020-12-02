<?php
/**
 *
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_REST_Change_Units\woocommerce;

/**
 *
 */
class API_Server_WP_Unit_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * The method should not change anything when it is not a REST request.
	 */
	public function test_get_option_normal() {

		update_option( 'woocommerce_weight_unit', 'oz' );
		update_option( 'bh_wc_rest_change_units_weight_unit', 'kg' );

		$api_server = new API_Server();

		$woocommerce_weight_unit = $api_server->display_correct_weight_unit( null, null, null );

		$this->assertEquals( null, $woocommerce_weight_unit );

	}


	/**
	 * When it is a REST  request, return the configured value.
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_get_option_rest() {

		update_option( 'woocommerce_weight_unit', 'oz' );
		update_option( 'bh_wc_rest_change_units_weight_unit', 'kg' );

		define( 'REST_REQUEST', true );

		$api_server = new API_Server();

		$woocommerce_weight_unit = $api_server->display_correct_weight_unit( null, null, null );

		$this->assertEquals( 'kg', $woocommerce_weight_unit );

	}
}
