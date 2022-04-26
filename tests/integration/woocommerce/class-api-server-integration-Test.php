<?php
/**
 *
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_REST_Change_Units\WooCommerce;

use WC_API_Server;
use WP_REST_Request;

/**
 *
 */
class API_Server_Integration_Test extends \Codeception\TestCase\WPTestCase {

	public function test_get_option_normal(): void {

		update_option( 'woocommerce_weight_unit', 'oz' );
		update_option( 'bh_wc_rest_change_units_weight_unit', 'kg' );

		$woocommerce_weight_unit = get_option( 'woocommerce_weight_unit' );

		$this->assertEquals( 'oz', $woocommerce_weight_unit );

	}

	protected function register_legacy_autoloader( int $version ): void {
		$autoload_classmap = array(
			'WC_API_Products'     => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-products.php",
			'WC_API_Resource'     => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-resource.php",
			'WC_API_Server'       => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-server.php",
			'WC_API_JSON_Handler' => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/class-wc-api-json-handler.php",
			'WC_API_Handler'      => WP_CONTENT_DIR . "/plugins/woocommerce/includes/legacy/api/v{$version}/interface-wc-api-handler.php",
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
	 *
	 */
	public function test_legacy_v1_schema(): void {

		update_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID, 'lbs-v1-legacy' );

		$this->register_legacy_autoloader( 1 );

		$api_route                 = '/';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$server = new WC_API_Server( $api_route );

		// Check we're running the tests against the correct API version.
		$reflector = new \ReflectionClass( $server );
		$filename  = $reflector->getFileName();
		assert( false !== stristr( $filename, 'v1' ) );

		$response = $server->dispatch();

		$this->assertEquals( 'lbs-v1-legacy', $response['store']['meta']['weight_unit'] );
	}


	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_legacy_v2_schema() {

		update_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID, 'lbs-v2-legacy' );

		$this->register_legacy_autoloader( 2 );

		$api_route                 = '/';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$server = new WC_API_Server( $api_route );

		// Check we're running the tests against the correct API version.
		$reflector = new \ReflectionClass( $server );
		$filename  = $reflector->getFileName();
		assert( false !== stristr( $filename, 'v2' ) );

		$response = $server->dispatch();

		$this->assertEquals( 'lbs-v2-legacy', $response['store']['meta']['weight_unit'] );
	}



	/**
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_legacy_v3_schema() {

		update_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID, 'lbs-v3-legacy' );

		$this->register_legacy_autoloader( 3 );

		$api_route                 = '/';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$server = new WC_API_Server( $api_route );

		// Check we're running the tests against the correct API version.
		$reflector = new \ReflectionClass( $server );
		$filename  = $reflector->getFileName();
		assert( false !== stristr( $filename, 'v3' ) );

		$response = $server->dispatch();

		$this->assertEquals( 'lbs-v3-legacy', $response['store']['meta']['weight_unit'] );
	}


	/**
	 * /wp-json/wc/v1/
	 *
	 * [1] is POST
	 * routes.wc/v1/products.endpoints[1].weight.description  "Product weight (lbs-v1)."
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_wp_json_v1_schema() {

		update_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID, 'lbs-v1' );

		$rest_server = rest_get_server();

		$request      = new WP_REST_Request( 'GET', '/wc/v1' );
		$response     = rest_do_request( $request );
		$http_options = $rest_server->response_to_data( $response, false );

		$this->assertEquals( 'Product weight (lbs-v1).', $http_options['routes']['/wc/v1/products']['endpoints'][1]['args']['weight']['description'] );

	}

	/**
	 * /wp-json/wc/v2/
	 *
	 * [1] is POST
	 * routes.wc/v2/products.endpoints[1].weight.description  "Product weight (lbs-v2)."
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_wp_json_v2_schema() {

		update_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID, 'lbs-v2' );

		$rest_server = rest_get_server();

		$request      = new WP_REST_Request( 'GET', '/wc/v2' );
		$response     = rest_do_request( $request );
		$http_options = $rest_server->response_to_data( $response, false );

		$this->assertEquals( 'Product weight (lbs-v2).', $http_options['routes']['/wc/v2/products']['endpoints'][1]['args']['weight']['description'] );

	}

	/**
	 * /wp-json/wc/v3/
	 *
	 * [1] is POST
	 * routes.wc/v1/products.endpoints[1].weight.description  "Product weight (lbs-v3)."
	 *
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_wp_json_v3_schema() {

		update_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID, 'lbs-v3' );

		$rest_server = rest_get_server();

		$request      = new WP_REST_Request( 'GET', '/wc/v3' );
		$response     = rest_do_request( $request );
		$http_options = $rest_server->response_to_data( $response, false );

		$this->assertEquals( 'Product weight (lbs-v3).', $http_options['routes']['/wc/v3/products']['endpoints'][1]['args']['weight']['description'] );

	}

}
