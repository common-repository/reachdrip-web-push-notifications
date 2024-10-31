<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://reachdrip.com/
 * @since      2.0.1
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.1
 * @package    Reachdrip
 * @subpackage Reachdrip/includes
 * @author     Team ReachDrip <support@reachdrip.com>
 */
class Reachdrip {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    2.0.1
	 * @access   protected
	 * @var      Reachdrip_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    2.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    2.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    2.0.1
	 */
	public function __construct() {

		$this->plugin_name = 'reachdrip';
		$this->version = '2.1.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Reachdrip_Loader. Orchestrates the hooks of the plugin.
	 * - Reachdrip_i18n. Defines internationalization functionality.
	 * - Reachdrip_Admin. Defines all hooks for the admin area.
	 * - Reachdrip_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    2.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reachdrip-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-reachdrip-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-reachdrip-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-reachdrip-public.php';

		$this->loader = new Reachdrip_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Reachdrip_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Reachdrip_i18n();

		$plugin_i18n->set_domain('reachdrip-web-push-notifications');

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    2.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Reachdrip_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );				
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'reachdrip_add_actions');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'reachdrip_admin_menu');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'send_reachdrip_notifications');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'reachdrip_segment');

		$this->loader->add_action('admin_menu', $plugin_admin, 'template_setting_rd');
		$this->loader->add_action('admin_menu', $plugin_admin, 'reachdrip_advance_setting');
		$this->loader->add_action('admin_menu', $plugin_admin, 'reachdrip_gcm_setting');
		$this->loader->add_action('admin_menu', $plugin_admin, 'reachdrip_create_campaign');
		$this->loader->add_action('wp_footer', $plugin_admin, 'reachdrip_footer_promo');

		/*	To create New account or Provide API keys if already have an account	*/

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'reachdrip_account_create');
		$this->loader->add_action( 'admin_init', $plugin_admin, 'reachdrip_accept_keys');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    2.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Reachdrip_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
	
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_action( 'transition_post_status', $plugin_public, 'call_reachdrip_schedule_notification', 10, 3);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    2.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.1
	 * @return    Reachdrip_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     2.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
