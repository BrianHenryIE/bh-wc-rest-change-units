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
class API_Server_Integration_Test extends \Codeception\TestCase\WPTestCase {


	public function test_get_option_normal() {

		update_option( 'woocommerce_weight_unit', 'oz' );
		update_option( 'bh_wc_rest_change_units_weight_unit', 'kg' );

		$woocommerce_weight_unit = get_option( 'woocommerce_weight_unit' );

		$this->assertEquals( 'oz', $woocommerce_weight_unit );

	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_get_option_rest() {

		update_option( 'woocommerce_weight_unit', 'oz' );
		update_option( 'bh_wc_rest_change_units_weight_unit', 'kg' );

		define( 'REST_REQUEST', true );

		$woocommerce_weight_unit = get_option( 'woocommerce_weight_unit' );

		$this->assertEquals( 'kg', $woocommerce_weight_unit );

	}
}
