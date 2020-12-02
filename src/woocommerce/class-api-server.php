<?php
/**
 * When the weight_unit is being displayed by the REST API server, ensure the correct unit is displayed.
 *
 * @link       https://github.com/BrianHenryIE/bh-wc-rest-change-units
 * @since      1.0.0
 *
 * @package    BH_WC_REST_Change_Units
 * @subpackage BH_WC_REST_Change_Units/woocommerce
 */

namespace BH_WC_REST_Change_Units\woocommerce;

/**
 * Filter the wp_option call for the weight unit. Note: this could cause an infinite loop.
 *
 * Class API_Server
 *
 * @package BH_WC_REST_Change_Units\woocommerce
 */
class API_Server {

	/**
	 * Short circuit `get_option( 'woocommerce_weight_unit' )` with the value of the REST weight option.
	 *
	 * @hooked pre_option_woocommerce_weight_unit
	 * @see get_option()
	 *
	 * @param mixed  $pre_option The value to return instead of the option value. This differs
	 *                            from `$default`, which is used as the fallback value in the event
	 *                            the option doesn't exist elsewhere in get_option().
	 *                            Default false (to skip past the short-circuit).
	 * @param string $option Option name.
	 * @param mixed  $default The fallback value to return if the option does not exist.
	 *                            Default false.
	 *
	 * @return false|mixed|void
	 */
	public function display_correct_weight_unit( $pre_option, $option, $default ) {

		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {

			return get_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID );
		}

		return $pre_option;
	}

}
