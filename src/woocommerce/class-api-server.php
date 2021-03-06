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
	 * Change the product weight unit description as the /wp-json/wc/ REST schema is being built.
	 *
	 * @hooked woocommerce_rest_product_schema
	 *
	 * @see WC_REST_Products_V2_Controller::get_item_schema()
	 * @see WC_REST_Controller::add_additional_fields_schema()
	 *
	 * @param array $schema_properties The schema array being returned by the wp-json REST API.
	 *
	 * @return array
	 */
	public function change_product_weight_option_in_wp_json_schema( $schema_properties ): array {

		$weight_unit = get_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID );

		/* translators: %s: weight unit */
		$schema_properties['weight']['description'] = sprintf( __( 'Product weight (%s).', 'bh-wc-rest-change-units' ), $weight_unit );

		return $schema_properties;

	}

	/**
	 * Change the product weight unit description as the legacy REST schema is being built.
	 *
	 * @hooked woocommerce_api_index
	 *
	 * @param array $available The schema array being returned by the legacy REST API.
	 *
	 * @return array
	 */
	public function change_product_weight_option_in_legacy_schema( $available ): array {

		$weight_unit = get_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID );

		$available['store']['meta']['weight_unit'] = $weight_unit;

		return $available;
	}
}
