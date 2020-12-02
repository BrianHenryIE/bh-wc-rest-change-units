<?php
/**
 * Tests for the root plugin file.
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_REST_Change_Units;

use BH_WC_REST_Change_Units\includes\BH_WC_REST_Change_Units;

/**
 * Class Plugin_WP_Mock_Test
 */
class Plugin_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}

	/**
	 * Verifies the plugin initialization.
	 */
	public function test_plugin_include() {

		$plugin_root_dir = dirname( __DIR__, 2 ) . '/src';

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		require_once $plugin_root_dir . '/bh-wc-rest-change-units.php';

		$this->assertArrayHasKey( 'bh_wc_rest_change_units', $GLOBALS );

		$this->assertInstanceOf( BH_WC_REST_Change_Units::class, $GLOBALS['bh_wc_rest_change_units'] );

	}


	/**
	 * Verifies the plugin does not output anything to screen.
	 */
	public function test_plugin_include_no_output() {

		$plugin_root_dir = dirname( __DIR__, 2 ) . '/src';

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		ob_start();

		require_once $plugin_root_dir . '/bh-wc-rest-change-units.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
