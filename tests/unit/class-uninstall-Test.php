<?php
/**
 * Tests for the root plugin file.
 *
 * @package BH_WC_REST_Change_Units
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_REST_Change_Units;

use BrianHenryIE\WC_REST_Change_Units\WooCommerce\Settings_Products;

/**
 * Class Plugin_WP_Mock_Test
 */
class Uninstall_Unit_Test extends \Codeception\Test\Unit {

	/**
	 * Verify uninstall deletes the option.
	 *
	 */
	public function test_uninstall_delete() {

		global $plugin_root_dir;

		define('WP_UNINSTALL_PLUGIN',true);

		\WP_Mock::userFunction(
			'delete_option',
			array(
				'args'   => Settings_Products::REST_WEIGHT_UNIT_OPTION_ID,
			)
		);

		require_once $plugin_root_dir . '/uninstall.php';

	}


}
