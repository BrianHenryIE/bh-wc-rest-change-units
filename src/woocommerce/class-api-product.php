<?php
/**
 * Filters REST API responses to convert products' weight values to new units.
 *
 * @link       https://github.com/BrianHenryIE/bh-wc-rest-change-units
 * @since      1.0.0
 *
 * @package    BH_WC_REST_Change_Units
 * @subpackage BH_WC_REST_Change_Units/woocommerce
 */

namespace BH_WC_REST_Change_Units\woocommerce;

use BH_WC_REST_Change_Units\PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Exception;
use WC_API_Server;
use WC_Product;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Determines if a conversion is necessary.
 * Filters legacy API.
 * Filters wp-json/wc API.
 * Performs conversion using PhpUnitsOfMeasure library and rounds the number.
 *
 * Class API_Product
 *
 * @package BH_WC_REST_Change_Units\woocommerce
 */
class API_Product {

	/**
	 * Cache the result of the null checks on the conversion.
	 * TODO: Add filters before each conversion.
	 *
	 * @var null|false|array {'from' string,'to' string}
	 */
	protected $should_convert;

	/**
	 * Filters legacy WooCommerce API, i.e. `/wc-api/v1/products/9` / `?wc-api-version=3&wc-api-route=/products/9`.
	 *
	 * @hooked woocommerce_api_product_response
	 * @see WC_API_Products::get_product()
	 *
	 * @param array         $product_data The key value pairs that will be returned by the API.
	 * @param WC_Product    $product The product being queried.
	 * @param string        $fields Fields query in the API request `/wc-api/v1/products/9?fields=...`.
	 * @param WC_API_Server $server The API server instance (could be v1/v2/v3).
	 *
	 * @return array
	 */
	public function update_weight_legacy_api( $product_data, $product, $fields, $server ) {

		$should_convert = $this->should_convert ?? $this->should_convert();
		if ( ! is_array( $should_convert ) ) {
			return $product_data;
		}

		$product_weight = $product_data['weight'];

		if ( ! is_numeric( $product_weight ) ) {

			return $product_data;
		}

		$converted_weight = $this->convert( $product_weight, $should_convert['from'], $should_convert['to'] );

		$product_data['weight'] = "{$converted_weight}";

		return $product_data;

	}

	/**
	 * Filters wp-json/wc API.
	 *
	 * @hooked woocommerce_rest_prepare_product
	 * @see WC_REST_Products_V1_Controller::prepare_object_for_response()
	 *
	 * @hooked woocommerce_rest_prepare_product_object
	 * @see WC_REST_Products_V2_Controller::prepare_object_for_response()
	 *
	 * @param WP_REST_Response $response The response object.
	 * @param WC_Product       $product Object data.
	 * @param WP_REST_Request  $request Request object.
	 *
	 * @return WP_REST_Response
	 */
	public function update_weight_wp_json_api( $response, $product, $request ) {

		if ( ! isset( $response->data['weight'] ) ) {
			return $response;
		}

		if ( ! is_numeric( $response->data['weight'] ) ) {
			return $response;
		}

		$should_convert = $this->should_convert ?? $this->should_convert();
		if ( ! is_array( $should_convert ) ) {
			return $response;
		}

		$converted_weight = $this->convert( $response->data['weight'], $should_convert['from'], $should_convert['to'] );

		$response->data['weight'] = "{$converted_weight}";

		return $response;
	}

	/**
	 * Convert the weight and round the result.
	 *
	 * @see https://github.com/PhpUnitsOfMeasure/php-units-of-measure
	 * @see https://www.nist.gov/pml/weights-and-measures/metric-si/unit-conversion
	 *
	 * @param float|int $product_weight Number to convert.
	 * @param string    $from_unit  Unit to convert from.
	 * @param string    $to_unit    Unit to convert to.
	 *
	 * @return float|int Converted number.
	 */
	protected function convert( $product_weight, string $from_unit, string $to_unit ) {

		try {
			$weight           = new Mass( $product_weight, $from_unit );
			$converted_weight = $weight->toUnit( $to_unit );
		} catch ( Exception $e ) {
			return $product_weight;
		}

		// We never need more than 3 decimals places.
		if ( $converted_weight / 1000 > 1 ) {
			$converted_weight = (int) round( $converted_weight, 0 );
		} elseif ( $converted_weight / 100 > 1 ) {
			$converted_weight = round( $converted_weight, 1 );
		} elseif ( $converted_weight / 10 > 1 ) {
			$converted_weight = round( $converted_weight, 2 );
		} else {
			$converted_weight = round( $converted_weight, 3 );
		}

		return $converted_weight;
	}


	/**
	 * Check settings have been configured and differ from the WooCommerce internal setting.
	 *
	 * Stores the result in $this->should_convert.
	 *
	 * @return false|array
	 */
	protected function should_convert() {

		$woocommerce_weight_unit = get_option( 'woocommerce_weight_unit' );

		// Unlikely scenario.
		if ( false === $woocommerce_weight_unit ) {
			$this->should_convert = false;
			return $this->should_convert;
		}

		$rest_weight_unit = get_option( Settings_Products::REST_WEIGHT_UNIT_OPTION_ID );

		// This could happen before the settings page is visited and saved.
		if ( false === $rest_weight_unit ) {
			$this->should_convert = false;
			return $this->should_convert;
		}

		// No conversion necessary.
		if ( $woocommerce_weight_unit === $rest_weight_unit ) {
			$this->should_convert = false;
			return $this->should_convert;
		}

		$this->should_convert = array(
			'from' => $woocommerce_weight_unit,
			'to'   => $rest_weight_unit,
		);

		return $this->should_convert;
	}

}
