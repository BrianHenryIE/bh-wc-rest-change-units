<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/BrianHenryIE/bh-wc-rest-change-units
 * @since             1.0.0
 * @package           BH_WC_REST_Change_Units
 *
 * @wordpress-plugin
 * Plugin Name:       REST Change Units
 * Plugin URI:        http://github.com/BrianHenryIE/bh-wc-rest-change-units/
 * Description:       Converts orders' weight units for compatibility with external services. e.g. oz on the website, g over REST API.
 * Version:           1.0.3
 * Author:            Brian Henry
 * Author URI:        https://github.com/BrianHenryIE/bh-wc-rest-change-units/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-wc-rest-change-units
 * Domain Path:       /languages
 */

namespace BH_WC_REST_Change_Units;

use BH_WC_REST_Change_Units\includes\BH_WC_REST_Change_Units;
use BH_WC_REST_Change_Units\BrianHenryIE\WPPB\WPPB_Loader;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Current plugin version (semver).
 */
define( 'BH_WC_REST_CHANGE_UNITS_VERSION', '1.0.3' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function instantiate_bh_wc_rest_change_units() {

	$loader = new WPPB_Loader();
	$plugin = new BH_WC_REST_Change_Units( $loader );

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization and hooks.
 */
$GLOBALS['bh_wc_rest_change_units'] = $bh_wc_rest_change_units = instantiate_bh_wc_rest_change_units();
$bh_wc_rest_change_units->run();
