<?php
/**
 * Add "REST API weight unit" setting to WooCommerce.
 *
 * @link       https://github.com/BrianHenryIE/bh-wc-rest-change-units
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-rest-change-units
 */

namespace BrianHenryIE\WC_REST_Change_Units\WooCommerce;

/**
 * Filter the WooCommerce settings and add the option at the end of the "Measurements" section.
 */
class Settings_Products {

	const REST_WEIGHT_UNIT_OPTION_ID = 'bh_wc_rest_change_units_weight_unit';

	/**
	 * Add a select drop-down with kg/g/lbs/oz options after the woocommerce_dimension_unit option.
	 *
	 * @hooked woocommerce_products_general_settings
	 * @see WC_Settings_Products::get_settings()
	 *
	 * @param array<int|string, array<string,int|string|array>> $general_settings The existing general settings from the WooCommerce settings product page.
	 *
	 * @return array<int|string, array<string,int|string|array>>
	 */
	public function add_rest_weight_unit_setting( array $general_settings ): array {

		$rest_weight_unit_setting = array(
			'title'    => __( 'REST API weight unit', 'bh-wc-rest-change-units' ),
			'desc'     => __( 'Product weights will be converted to this unit when served via the REST API.', 'bh-wc-rest-change-units' ),
			'id'       => self::REST_WEIGHT_UNIT_OPTION_ID,
			'class'    => 'wc-enhanced-select',
			'css'      => 'min-width:300px;',
			'default'  => get_option( 'woocommerce_weight_unit' ),
			'type'     => 'select',
			'options'  => array(
				'kg'  => __( 'kg', 'bh-wc-rest-change-units' ),
				'g'   => __( 'g', 'bh-wc-rest-change-units' ),
				'lbs' => __( 'lbs', 'bh-wc-rest-change-units' ),
				'oz'  => __( 'oz', 'bh-wc-rest-change-units' ),
			),
			'desc_tip' => true,
		);

		$updated_general_settings = array();

		// Place the new setting in the array after the existing units settings.
		foreach ( $general_settings as $setting ) {
			$updated_general_settings[] = $setting;
			if ( 'woocommerce_dimension_unit' === $setting['id'] ) {
				$updated_general_settings[] = $rest_weight_unit_setting;
			}
		}

		return $updated_general_settings;
	}
}
