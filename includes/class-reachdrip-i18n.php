<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://reachdrip.com/
 * @since      2.0.1
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.1
 * @package    Reachdrip
 * @subpackage Reachdrip/includes
 * @author     Team ReachDrip <support@reachdrip.com>
 */
class Reachdrip_i18n {

	public $domain;
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.1
	 */

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ). '/languages/'
		);

	}

	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}

