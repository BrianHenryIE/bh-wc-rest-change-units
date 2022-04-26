<?php
/**
 *
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_REST_Change_Units\WooCommerce;

use WC_Product;
use WP_REST_Request;
use WP_REST_Response;

/**
 *
 */
class API_Product_WP_Unit_Test extends \Codeception\TestCase\WPTestCase {

	public function test_happy_path() {

		update_option( 'woocommerce_weight_unit', 'lb' );
		update_option( 'bh_wc_rest_change_units_weight_unit', 'oz' );

		$api_product = new API_Product();

		$response = $this->make( WP_REST_Response::class,
			[
				'data' => array(
					'weight' => 123
				)
			]
		);
		$product = $this->make( WC_Product::class );
		$request = $this->make( WP_REST_Request::class );

		$updated_response = $api_product->update_weight_wp_json_api( $response, $product, $request );

		$this->assertEquals( 123*16, $updated_response->data['weight'] );

	}

}
