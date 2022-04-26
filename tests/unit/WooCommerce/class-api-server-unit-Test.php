<?php
/**
 * Tests for the API schema.
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_REST_Change_Units\WooCommerce;

class API_Server_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}

	public function test_change_weight_option_in_product_schema() {

		$weight_unit = 'oz';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $weight_unit
			)
		);

		$sut = new API_Server();

		$schema_properties = array(
			'weight' => array(
				'description' => 'Product weight (real people use SI).'
			)
		);

		$updated_properties = $sut->change_product_weight_option_in_wp_json_schema( $schema_properties );

		$this->assertEquals( 'Product weight (oz).', $updated_properties['weight']['description'] );

	}


	public function test_change_weight_option_in_legacy_schema() {

		$weight_unit = 'oz';

		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => 'bh_wc_rest_change_units_weight_unit',
				'return' => $weight_unit
			)
		);

		$sut = new API_Server();

		$available = array(
			'store' => array(
				'meta' => array(
					'weight_unit' => 'Product weight (real people use SI).'
				)
			)
		);

		$updated_properties = $sut->change_product_weight_option_in_legacy_schema( $available );

		$this->assertEquals( 'oz', $updated_properties['store']['meta']['weight_unit'] );
	}
}
