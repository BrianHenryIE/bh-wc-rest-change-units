<?php
/**
 * Tests for the conversions.
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_REST_Change_Units\woocommerce;

class API_Product_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}


	public function test_oz_to_lbs() {

		$from = 'oz';
		$to = 'lbs';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, null, null, null );

		$this->assertEquals( 7.688, $updated_product_data_array['weight'] );

	}


	public function test_lbs_to_oz() {

		$from = 'lbs';
		$to = 'oz';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, null, null, null );

		$this->assertEquals( 1968, $updated_product_data_array['weight'] );

	}



	public function test_oz_to_g() {

		$from = 'oz';
		$to = 'g';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, null, null, null );

		$this->assertEquals( 3487, $updated_product_data_array['weight'] );

	}


	public function test_lbs_to_g() {

		$from = 'lbs';
		$to = 'g';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, null, null, null );

		$this->assertEquals( 55792, $updated_product_data_array['weight'] );

	}




	public function test_g_to_lbs() {

		$from = 'g';
		$to = 'lbs';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, null, null, null );

		$this->assertEquals( 0.271, $updated_product_data_array['weight'] );

	}


	public function test_g_to_oz() {

		$from = 'g';
		$to = 'oz';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, null, null, null );

		$this->assertEquals( 4.339, $updated_product_data_array['weight'] );

	}

}
