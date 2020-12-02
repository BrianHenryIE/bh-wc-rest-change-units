<?php

namespace BH_WC_REST_Change_Units\woocommerce;

use WC_API_Products;
use WC_API_Server;
use WC_Product;
use WP_REST_Request;

class REST_Product_Integration_Test extends \Codeception\TestCase\WPRestApiTestCase {

	protected $product;

	function _before() {
		parent::_before();

		// WooCommerce is using ounces as its units.
		update_option( 'woocommerce_weight_unit', 'oz' );

		update_option( 'bh_wc_rest_change_units_weight_unit', 'g' );

		// We have a product whose weight is 123 oz.
		$this->product = $product = new WC_Product();
		$product->set_weight( 123 );
		$product->save();

		set_current_user(1);
	}

	protected function register_legacy_autoloader( int $version ) {
		$autoload_classmap = array(
			'WC_API_Products'     => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-products.php",
			'WC_API_Resource'     => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-resource.php",
			'WC_API_Server'        => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-server.php",
			'WC_API_JSON_Handler' => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-json-handler.php",
			'WC_API_Handler' => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/interface-wc-api-handler.php",
		);

		spl_autoload_register(
			function ( $classname ) use ( $autoload_classmap ) {
				if ( array_key_exists( $classname, $autoload_classmap ) && file_exists( $autoload_classmap[ $classname ] ) ) {
					require_once $autoload_classmap[ $classname ];
				}
			}
		);
	}

	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_legacy_v1() {

		$this->register_legacy_autoloader(1);


		$api_route = '/products/' . $this->product->get_id();
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$server = new WC_API_Server( $api_route );

		// Check we're running the tests against the correct API version.
		$reflector = new \ReflectionClass($server );
		$filename = $reflector->getFileName();
		assert( false !== stristr( $filename, 'v1' ) );

		// Need to instantiate this so it registers itself as a handler.
		$wc_api_products = new WC_API_Products( $server );

		$response = $server->dispatch();

		$rest_product = $response['product'];

		$this->assertEquals( 3487, $rest_product['weight'] );

		// Verify that we have not disturbed the internal product weight.

		$php_product = wc_get_product( $this->product->get_id() );
		$this->assertEquals( 123, $php_product->get_weight() );
	}


	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_legacy_v2() {

		$this->register_legacy_autoloader(2);

		$api_route = '/products/' . $this->product->get_id();
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$server = new WC_API_Server( $api_route );

		// Check we're running the tests against the correct API version.
		$reflector = new \ReflectionClass($server );
		$filename = $reflector->getFileName();
		assert( false !== stristr( $filename, 'v2' ) );


		// Need to instantiate this so it registers itself as a handler.
		$wc_api_products = new WC_API_Products( $server );

		$response = $server->dispatch();

		$rest_product = $response['product'];

		$this->assertEquals( 3487, $rest_product['weight'] );

		// Verify that we have not disturbed the internal product weight.

		$php_product = wc_get_product( $this->product->get_id() );
		$this->assertEquals( 123, $php_product->get_weight() );
	}




	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_legacy_v3() {

		$this->register_legacy_autoloader(3);


		$api_route = '/products/' . $this->product->get_id();
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$server = new WC_API_Server( $api_route );

		// Check we're running the tests against the correct API version.
		$reflector = new \ReflectionClass($server );
		$filename = $reflector->getFileName();
		assert( false !== stristr( $filename, 'v3' ) );

		// Need to instantiate this so it registers itself as a handler.
		$wc_api_products = new WC_API_Products( $server );

		$response = $server->dispatch();

		$rest_product = $response['product'];

		$this->assertEquals( 3487, $rest_product['weight'] );

		// Verify that we have not disturbed the internal product weight.

		$php_product = wc_get_product( $this->product->get_id() );
		$this->assertEquals( 123, $php_product->get_weight() );
	}


	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_wp_json_v3() {

		$rest_server = rest_get_server();

		$request = new WP_REST_Request( 'GET', '/wc/v3/products/' . $this->product->get_id() );

		$response = rest_do_request( $request );

		$rest_product = $rest_server->response_to_data( $response, false );

		$this->assertEquals( 3487, $rest_product['weight'] );

		// Verify that we have not disturbed the internal product weight.

		$php_product = wc_get_product( $this->product->get_id() );
		$this->assertEquals( 123, $php_product->get_weight() );
	}


	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_wp_json_v1() {

		$rest_server = rest_get_server();

		$request = new WP_REST_Request( 'GET', '/wc/v1/products/' . $this->product->get_id() );

		$response = rest_do_request( $request );

		$rest_product = $rest_server->response_to_data( $response, false );

		$this->assertEquals( 3487, $rest_product['weight'] );

		// Verify that we have not disturbed the internal product weight.

		$php_product = wc_get_product( $this->product->get_id() );
		$this->assertEquals( 123, $php_product->get_weight() );
	}


	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_wp_json_v2() {

		$rest_server = rest_get_server();

		$request = new WP_REST_Request( 'GET', '/wc/v2/products/' . $this->product->get_id() );

		$response = rest_do_request( $request );

		$rest_product = $rest_server->response_to_data( $response, false );

		$this->assertEquals( 3487, $rest_product['weight'] );

		// Verify that we have not disturbed the internal product weight.

		$php_product = wc_get_product( $this->product->get_id() );
		$this->assertEquals( 123, $php_product->get_weight() );
	}

}
