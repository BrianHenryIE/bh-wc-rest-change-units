<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package BH_WC_REST_Change_Units
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_REST_Change_Units;

use BrianHenryIE\WC_REST_Change_Units\Includes\BH_WC_REST_Change_Units;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_wc_rest_change_units', $GLOBALS );

		$this->assertInstanceOf( BH_WC_REST_Change_Units::class, $GLOBALS['bh_wc_rest_change_units'] );
	}

}
