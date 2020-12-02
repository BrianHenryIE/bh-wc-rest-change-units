<?php 

class WooCommerceSettingsProductPageCest
{

	/**
	 * Login and navigate to plugins.php.
	 *
	 * @param AcceptanceTester $I
	 */
	public function _before( AcceptanceTester $I ) {
		$I->loginAsAdmin();

		$I->amOnAdminPage('admin.php?page=wc-settings&tab=products');
	}

	/**
	 * Verify the settings has been added to the page.
	 *
	 * @param AcceptanceTester $I
	 */
	public function testSettingIsPresent( AcceptanceTester $I ) {

		$I->canSee( 'REST API weight unit' );
	}


	/**
	 * Verify the settings select dropdown has four options (the four units).
	 *
	 * @param AcceptanceTester $I
	 */
	public function testSettingOptionsArePresent( AcceptanceTester $I ) {

		$I->seeNumberOfElements( '#bh_wc_rest_change_units_weight_unit > option',4);

	}

}
