<?php
/**
 * Tests for the conversions.
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_REST_Change_Units\WooCommerce;

use WC_API_Server;
use WC_Product;

/**
 * @coversDefaultClass \BrianHenryIE\WC_REST_Change_Units\WooCommerce\API_Product
 */
class API_Product_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}


	public function test_oz_to_lbs(): void {

		$product = $this->makeEmpty( WC_Product::class );
		$server  = $this->makeEmpty( WC_API_Server::class );

		$from = 'oz';
		$to   = 'lbs';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from,
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to,
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123,
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, $product, null, $server );

		$this->assertEquals( 7.688, $updated_product_data_array['weight'] );

	}


	public function test_lbs_to_oz(): void {

		$product = $this->makeEmpty( WC_Product::class );
		$server  = $this->makeEmpty( WC_API_Server::class );

		$from = 'lbs';
		$to   = 'oz';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from,
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to,
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123,
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, $product, null, $server );

		$this->assertEquals( 1968, $updated_product_data_array['weight'] );

	}



	public function test_oz_to_g(): void {

		$product = $this->makeEmpty( WC_Product::class );
		$server  = $this->makeEmpty( WC_API_Server::class );

		$from = 'oz';
		$to   = 'g';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from,
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to,
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123,
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, $product, null, $server );

		$this->assertEquals( 3487, $updated_product_data_array['weight'] );

	}


	public function test_lbs_to_g(): void {

		$product = $this->makeEmpty( WC_Product::class );
		$server  = $this->makeEmpty( WC_API_Server::class );

		$from = 'lbs';
		$to   = 'g';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from,
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to,
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123,
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, $product, null, $server );

		$this->assertEquals( 55792, $updated_product_data_array['weight'] );

	}



	public function test_g_to_lbs(): void {

		$product = $this->makeEmpty( WC_Product::class );
		$server  = $this->makeEmpty( WC_API_Server::class );

		$from = 'g';
		$to   = 'lbs';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from,
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to,
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123,
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, $product, null, $server );

		$this->assertEquals( 0.271, $updated_product_data_array['weight'] );

	}


	public function test_g_to_oz(): void {

		$product = $this->makeEmpty( WC_Product::class );
		$server  = $this->makeEmpty( WC_API_Server::class );

		$from = 'g';
		$to   = 'oz';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'woocommerce_weight_unit',
				'return' => $from,
			)
		);

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $to,
			)
		);

		$sut = new API_Product();

		$product_data_array = array(
			'weight' => 123,
		);

		$updated_product_data_array = $sut->update_weight_legacy_api( $product_data_array, $product, null, $server );

		$this->assertEquals( 4.339, $updated_product_data_array['weight'] );

	}

}
