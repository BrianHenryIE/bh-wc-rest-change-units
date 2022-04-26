<?php
/**
 * When the weight_unit is being displayed by the REST API server, ensure the correct unit is displayed.
 *
 * @link       https://github.com/BrianHenryIE/bh-wc-rest-change-units
 * @since      1.0.0
 *
 * @package    brianhenryie/bh-wc-rest-change-units
 */

namespace BrianHenryIE\WC_REST_Change_Units\WooCommerce;

/**
 * Filter the wp_option call for the weight unit. Note: this could cause an infinite loop.
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
	 * @param array<string, array<string|mixed>> $schema_properties The schema array being returned by the wp-json REST API.
	 *
	 * @return array<string, array<string|mixed>>
	 */
	public function change_product_weight_option_in_wp_json_schema( array $schema_properties ): array {

		$weight_unit = get_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID );

		if ( in_array( $weight_unit, array( 'kg', 'g', 'lbs', 'oz' ), true ) ) {
			/* translators: %s: weight unit */
			$schema_properties['weight']['description'] = sprintf( __( 'Product weight (%s).', 'bh-wc-rest-change-units' ), $weight_unit );
		}

		return $schema_properties;

	}

	/**
	 * Change the product weight unit description as the legacy REST schema is being built.
	 *
	 * @hooked woocommerce_api_index
	 *
	 * @param array{store: array<string, mixed>} $available The schema array being returned by the legacy REST API.
	 *
	 * @return array{store: array<string, mixed>}
	 */
	public function change_product_weight_option_in_legacy_schema( array $available ): array {

		$weight_unit = get_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID );

		if ( in_array( $weight_unit, array( 'kg', 'g', 'lbs', 'oz' ), true ) ) {
			$available['store']['meta']['weight_unit'] = $weight_unit;
		}

		return $available;
	}
}
