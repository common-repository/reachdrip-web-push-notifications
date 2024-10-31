<?php

if (!defined('REACHDRIP_URL')) {
    define('REACHDRIP_URL', plugin_dir_url(__FILE__));
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://reachdrip.com/
 * @since      2.0.1
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/admin
 * @author     Team ReachDrip <support@reachdrip.com>
 */
class Reachdrip_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    2.0.1
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    2.0.1
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since      2.0.1
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    //Init Function
    public function reachdrip_admin_init()
    {
		// custom code 
	}

    //Actions Function
    public static function reachdrip_add_actions()
    {
        if (is_admin()) {

            $reachdrip_settings = self::reachdrip_settings();

            if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_admin_menu'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_sent_notification_details'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'send_reachdrip_notifications'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_segment_details'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_segment'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_subscribers_details'));

                add_action('reachdrip_admin_init', array(__CLASS__, 'template_setting_rd'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_advance_setting'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_gcm_setting'));
                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_create_campaign'));

                /*    Auto Notification send BY POST      */
                add_action('add_meta_boxes_post', array(__CLASS__, 'reachdrip_publish_new_post'));
                add_action('add_meta_boxes_product', array(__CLASS__, 'reachdrip_publish_new_product'));
                add_action('add_meta_boxes', array(__CLASS__, 'reachdrip_note_text'), 10, 2);
                add_action('save_post', array(__CLASS__, 'save_reachdrip_post_meta_data'));

                add_action('wp_dashboard_setup', array(__CLASS__, 'reachdrip_dashboard_stats_widget'));

            } else {

                add_action('reachdrip_admin_init', array(__CLASS__, 'reachdrip_account_create'));
                add_action('reachdrip_appkey', array(__CLASS__, 'reachdrip_accept_keys'));
            }
        }

        add_action('transition_post_status', array(__CLASS__, 'send_reachdrip_post_notification'), 10, 3);
    }

    public static function reachdrip_dashboard_stats_widget()
    {
        wp_add_dashboard_widget(
            'reachdrip_dashboard_stats_widget',
            __('ReachDrip Stats', 'reachdrip-web-push-notifications'),
            array(__CLASS__, 'reachdrip_dashboard_display_widget'),
            'normal',
            'high'
        );
    }

    public static function reachdrip_dashboard_display_widget()
    {
        $reachdrip_settings = self::reachdrip_settings();

        $request_data = array("appKey" => trim($reachdrip_settings['appKey']),
            "appSecret" => trim($reachdrip_settings['appSecret']),
            "action" => 'dashboard/',
            "method" => "GET",
            "remoteContent" => ""
        );

        $dashboard_info = self::reachdrip_decode_request($request_data);

        ?>
        <ul class="rd_stat">
            <li class="total_active_users border_right">
                <a>
                    <?php printf(__("<strong>%s </strong> Active Subscribers", 'reachdrip-web-push-notifications'), number_format($dashboard_info['active'])); ?>
                </a>
            </li>
            <li class="total_unsubscribed_users">
                <a>
                    <?php printf(__("<strong>%s </strong> Unsubscribed", 'reachdrip-web-push-notifications'), number_format($dashboard_info['total_unsubscribed'])); ?>
                </a>
            </li>
            <li class="total_sent border_right">
                <a>
                    <?php printf(__("<strong>%s </strong> Total Delivered", 'reachdrip-web-push-notifications'), number_format($dashboard_info['stats_notification_sent'])); ?>
                </a>
            </li>
            <li class="total_clicks">
                <a>
                    <?php printf(__("<strong>%s </strong> Total Clicks", 'reachdrip-web-push-notifications'), number_format($dashboard_info['stats_clicks'])); ?>
                </a>
            </li>
            <li class="total_users border_right">
                <a>
                    <?php printf(__("<strong>%s </strong> Segments", 'reachdrip-web-push-notifications'), number_format($dashboard_info['segment_count'])); ?>
                </a>
            </li>
            <li class="total_campaigns">
                <a>
                    <?php printf(__("<strong>%s </strong> Campaigns", 'reachdrip-web-push-notifications'), number_format($dashboard_info['stats_campaigns'])); ?>
                </a>
            </li>
        </ul>

        <?php
    }	

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    2.0.1
     */
	 
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Reachdrip_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Reachdrip_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('reachdrip-admin', plugin_dir_url(__FILE__) . 'css/reachdrip-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('reachdrip-number-validate', plugin_dir_url(__FILE__) . 'css/intlTelInput.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    2.0.1
     */
	 
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Reachdrip_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Reachdrip_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('reachdrip-prism', plugin_dir_url(__FILE__) . 'js/prism.js', array('jquery'), $this->version, true);
        wp_enqueue_script('reachdrip-utils', plugin_dir_url(__FILE__) . 'js/utils.js', array('jquery'), $this->version, true);
        wp_enqueue_script('reachdrip-intltel', plugin_dir_url(__FILE__) . 'js/intlTelInput.js', array('jquery'), $this->version, true);
        wp_enqueue_script('reachdrip-isValidNumber', plugin_dir_url(__FILE__) . 'js/isValidNumber.js', array('jquery'), $this->version, true);
        wp_enqueue_script('reachdrip-admin', plugin_dir_url(__FILE__) . 'js/reachdrip-admin.js', array('jquery'), $this->version, true);
    }

    function reachdrip_admin_menu()
    {
        add_menu_page(
            'ReachDrip',
            'ReachDrip',
            'manage_options',
            'reachdrip-admin',
            array(__CLASS__, 'reachdrip_admin_dashboard'),
            plugin_dir_url(__FILE__) . 'images/reachdrip.png'
        );

        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            add_submenu_page('reachdrip-admin', __('Dashboard', 'reachdrip-web-push-notifications'), __('Dashboard', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-admin');
            add_submenu_page('reachdrip-admin', __('Notification History', 'reachdrip-web-push-notifications'), __('Notification History', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-notification-history', array(__CLASS__, 'reachdrip_sent_notification_details'));
            add_submenu_page('reachdrip-admin', __('New Notification', 'reachdrip-web-push-notifications'), __('New Notification', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-new-notification', array(__CLASS__, 'reachdrip_send_notifications'));
            add_submenu_page('reachdrip-admin', __('All Segments', 'reachdrip-web-push-notifications'), __('All Segments', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-all-segments', array(__CLASS__, 'reachdrip_segment_details'));
            add_submenu_page('reachdrip-admin', __('Create Segments', 'reachdrip-web-push-notifications'), __('Create Segments', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-create-segments', array(__CLASS__, 'reachdrip_create_segment'));
            add_submenu_page('reachdrip-admin', __('Subscribers', 'reachdrip-web-push-notifications'), __('Subscribers', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-subscribers-stats', array(__CLASS__, 'reachdrip_subscribers_details'));
            add_submenu_page('reachdrip-admin', __('Settings', 'reachdrip-web-push-notifications'), __('Settings', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-setting', array(__CLASS__, 'reachdrip_setting_details'));
            add_submenu_page('reachdrip-admin', __('Campaigns', 'reachdrip-web-push-notifications'), __('New Campaign', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-new-campaign', array(__CLASS__, 'reachdrip_campaigns'));

        } else {
            add_submenu_page('reachdrip-admin', __('Create Account', 'reachdrip-web-push-notifications'), __('Create Account', 'reachdrip-web-push-notifications'), 'manage_options', 'reachdrip-create-account', array(__CLASS__, 'reachdrip_create_account'));
        }
    }

    // Admin Dashboard
    public static function reachdrip_admin_dashboard()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $request_data = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'dashboard/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $dashboard_info = self::reachdrip_decode_request($request_data);

            $account_info = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::reachdrip_decode_request($account_info);

            require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-dashboard.php';

        } else {

            require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-create-account.php';
        }
    }

    public static function reachdrip_campaigns()
    {
        $timezones = array(
            'Hawaii' => 'Pacific/Honolulu',
            'Alaska' => 'US/Alaska',
            'Pacific Time (US & Canada)' => 'America/Los_Angeles',
            'Arizona' => 'US/Arizona',
            'Mountain Time (US & Canada)' => 'US/Mountain',
            'Central Time (US & Canada)' => 'US/Central',
            'Eastern Time (US & Canada)' => 'US/Eastern',
            'Indiana (East)' => 'US/East-Indiana',
            'Midway Island' => 'Pacific/Midway',
            'American Samoa' => 'US/Samoa',
            'Tijuana' => 'America/Tijuana',
            'Chihuahua' => 'America/Chihuahua',
            'Mazatlan' => 'America/Mazatlan',
            'Central America' => 'America/Managua',
            'Mexico City' => 'America/Mexico_City',
            'Monterrey' => 'America/Monterrey',
            'Saskatchewan' => 'Canada/Saskatchewan',
            'Bogota' => 'America/Bogota',
            'Lima' => 'America/Lima',
            'Quito' => 'America/Bogota',
            'Atlantic Time (Canada)' => 'Canada/Atlantic',
            'Caracas' => 'America/Caracas',
            'La Paz' => 'America/La_Paz',
            'Santiago' => 'America/Santiago',
            'Newfoundland' => 'Canada/Newfoundland',
            'Brasilia' => 'America/Sao_Paulo',
            'Buenos Aires' => 'America/Argentina/Buenos_Aires',
            'Greenland' => 'America/Godthab',
            'Mid-Atlantic' => 'America/Noronha',
            'Azores' => 'Atlantic/Azores',
            'Cape Verde Is.' => 'Atlantic/Cape_Verde',
            'Casablanca' => 'Africa/Casablanca',
            'Dublin' => 'Europe/Dublin',
            'Lisbon' => 'Europe/Lisbon',
            'London' => 'Europe/London',
            'Monrovia' => 'Africa/Monrovia',
            'UTC' => 'UTC',
            'Amsterdam' => 'Europe/Amsterdam',
            'Belgrade' => 'Europe/Belgrade',
            'Bern' => 'Europe/Berlin',
            'Bratislava' => 'Europe/Bratislava',
            'Brussels' => 'Europe/Brussels',
            'Budapest' => 'Europe/Budapest',
            'Copenhagen' => 'Europe/Copenhagen',
            'Ljubljana' => 'Europe/Ljubljana',
            'Madrid' => 'Europe/Madrid',
            'Paris' => 'Europe/Paris',
            'Prague' => 'Europe/Prague',
            'Rome' => 'Europe/Rome',
            'Sarajevo' => 'Europe/Sarajevo',
            'Skopje' => 'Europe/Skopje',
            'Stockholm' => 'Europe/Stockholm',
            'Vienna' => 'Europe/Vienna',
            'Warsaw' => 'Europe/Warsaw',
            'West Central Africa' => 'Africa/Lagos',
            'Zagreb' => 'Europe/Zagreb',
            'Athens' => 'Europe/Athens',
            'Bucharest' => 'Europe/Bucharest',
            'Cairo' => 'Africa/Cairo',
            'Harare' => 'Africa/Harare',
            'Helsinki' => 'Europe/Helsinki',
            'Istanbul' => 'Europe/Istanbul',
            'Jerusalem' => 'Asia/Jerusalem',
            'Kyiv' => 'Europe/Helsinki',
            'Pretoria' => 'Africa/Johannesburg',
            'Riga' => 'Europe/Riga',
            'Sofia' => 'Europe/Sofia',
            'Tallinn' => 'Europe/Tallinn',
            'Vilnius' => 'Europe/Vilnius',
            'Baghdad' => 'Asia/Baghdad',
            'Kuwait' => 'Asia/Kuwait',
            'Minsk' => 'Europe/Minsk',
            'Nairobi' => 'Africa/Nairobi',
            'Riyadh' => 'Asia/Riyadh',
            'Volgograd' => 'Europe/Volgograd',
            'Tehran' => 'Asia/Tehran',
            'Abu Dhabi' => 'Asia/Muscat',
            'Baku' => 'Asia/Baku',
            'Moscow' => 'Europe/Moscow',
            'Muscat' => 'Asia/Muscat',
            'Tbilisi' => 'Asia/Tbilisi',
            'Yerevan' => 'Asia/Yerevan',
            'Kabul' => 'Asia/Kabul',
            'Karachi' => 'Asia/Karachi',
            'Tashkent' => 'Asia/Tashkent',
            'Chennai' => 'Asia/Calcutta',
            'Kolkata' => 'Asia/Kolkata',
            'Kathmandu' => 'Asia/Katmandu',
            'Almaty' => 'Asia/Almaty',
            'Dhaka' => 'Asia/Dhaka',
            'Ekaterinburg' => 'Asia/Yekaterinburg',
            'Rangoon' => 'Asia/Rangoon',
            'Bangkok' => 'Asia/Bangkok',
            'Jakarta' => 'Asia/Jakarta',
            'Novosibirsk' => 'Asia/Novosibirsk',
            'Beijing' => 'Asia/Hong_Kong',
            'Chongqing' => 'Asia/Chongqing',
            'Krasnoyarsk' => 'Asia/Krasnoyarsk',
            'Kuala Lumpur' => 'Asia/Kuala_Lumpur',
            'Perth' => 'Australia/Perth',
            'Singapore' => 'Asia/Singapore',
            'Taipei' => 'Asia/Taipei',
            'Ulaan Bataar' => 'Asia/Ulan_Bator',
            'Urumqi' => 'Asia/Urumqi',
            'Irkutsk' => 'Asia/Irkutsk',
            'Seoul' => 'Asia/Seoul',
            'Tokyo' => 'Asia/Tokyo',
            'Adelaide' => 'Australia/Adelaide',
            'Darwin' => 'Australia/Darwin',
            'Brisbane' => 'Australia/Brisbane',
            'Canberra' => 'Australia/Canberra',
            'Guam' => 'Pacific/Guam',
            'Hobart' => 'Australia/Hobart',
            'Melbourne' => 'Australia/Melbourne',
            'Port Moresby' => 'Pacific/Port_Moresby',
            'Sydney' => 'Australia/Sydney',
            'Yakutsk' => 'Asia/Yakutsk',
            'Vladivostok' => 'Asia/Vladivostok',
            'Auckland' => 'Pacific/Auckland',
            'Fiji' => 'Pacific/Fiji',
            'International Date Line West' => 'Pacific/Kwajalein',
            'Kamchatka' => 'Asia/Kamchatka',
            'Magadan' => 'Asia/Magadan',
            'Marshall Is.' => 'Pacific/Fiji',
            'New Caledonia' => 'Asia/Magadan',
            'Wellington' => 'Pacific/Auckland',
            'Nuku\'alofa' => 'Pacific/Tongatapu'
        );

        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $segment_data = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'segments/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $segment_list = self::reachdrip_decode_request($segment_data);

            $account_info = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::reachdrip_decode_request($account_info);

            $account_details['timezone_list'] = $timezones;
        }

        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-campaign.php';
    }

    // account creation
    public static function reachdrip_create_account()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-create-account.php';
    }

    //  notification details ( History )
    public static function reachdrip_sent_notification_details()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $notification_data = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'notifications/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $notification_list = self::reachdrip_decode_request($notification_data);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-notification-history.php';
    }

    // send new notification
    public static function reachdrip_send_notifications()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $segment_data = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'segments/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $segment_list = self::reachdrip_decode_request($segment_data);

            $account_info = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::reachdrip_decode_request($account_info);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-new-notification.php';
    }

    // segment details
    public static function reachdrip_segment_details()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $segment_data = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'segments/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $segment_list = self::reachdrip_decode_request($segment_data);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-segment-list.php';
    }

    // segment create
    public static function reachdrip_create_segment()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-new-segments.php';
    }

    // Reachdrip Account subscriber list
    public static function reachdrip_subscribers_details()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $subscriber_info = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'subscribers/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $subscriber_details = self::reachdrip_decode_request($subscriber_info);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-subscribers-stats.php';
    }

    // Reachdrip Account Information Or setting
    public static function reachdrip_setting_details()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

            $account_info = array("appKey" => trim($reachdrip_settings['appKey']),
                "appSecret" => trim($reachdrip_settings['appSecret']),
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => ""
            );

            $account_details = self::reachdrip_decode_request($account_info);
        }

        require_once plugin_dir_path(__FILE__) . 'partials/reachdrip-setting.php';
    }

    public static function template_setting_rd()
    {
        $reachdrip_settings = self::reachdrip_settings();

        $response_message = '';

        if (isset($_POST['rd-save-settings'])) {

            $reachdrip_setting_post_message = __('We have just published an article, check it out!', 'reachdrip-web-push-notifications');

            $auto_push = false;
            $edit_push = false;
            $use_logoimage = false;			
            $use_bigimage = false;
            $auto_push_UTM = false;
            $rdJsRestrict = false;
            $rdNewPostChecked = false;
            $rdUpdatePostChecked = false;			
			$rdDisallowPostTypes = '';

            if (isset($_POST['reachdrip_auto_push'])) {
                $auto_push = true;
            }

            if (isset($_POST['reachdrip_edit_post_push'])) {
                $edit_push = true;
            }

            if (isset($_POST['reachdrip_logo_image'])) {
                $use_logoimage = true;
            }

            if (isset($_POST['reachdrip_big_image'])) {
                $use_bigimage = true;
            }

            if (isset($_POST['reachdrip_setting_post_message'])) {
                $reachdrip_setting_post_message = sanitize_text_field(trim($_POST['reachdrip_setting_post_message']));
            }

            if (isset($_POST['reachdrip_js_restrict'])) {
                $rdJsRestrict = true;
            }

            if (isset($_POST['reachdrip_new_post_checked'])) {
                $rdNewPostChecked = true;
            }

            if (isset($_POST['reachdrip_update_post_checked'])) {
                $rdUpdatePostChecked = true;
            }

            if (isset($_POST['reachdrip_setting_is_utm_show'])) {				
                $auto_push_UTM = true;
                $reachdrip_settings['rdUTMSource'] = sanitize_text_field(trim($_POST['reachdrip_setting_utm_source']));
                $reachdrip_settings['rdUTMMedium'] = sanitize_text_field(trim($_POST['reachdrip_setting_utm_medium']));
                $reachdrip_settings['rdUTMCampaign'] = sanitize_text_field(trim($_POST['reachdrip_setting_utm_campaign']));

            } else {
                $reachdrip_settings['rdUTMSource'] = 'reachdrip';
                $reachdrip_settings['rdUTMMedium'] = 'reachdrip_notification';
                $reachdrip_settings['rdUTMCampaign'] = 'reachdrip';
            }
			
			if (isset($_POST['reachdrip_post_types'])) {
				$rdDisallowPostTypes = implode(",", sanitize_text_field($_POST['reachdrip_post_types']));
			}

            $reachdrip_settings['rdAutoPush'] = $auto_push;
            $reachdrip_settings['rdEditPostPush'] = $edit_push;
            $reachdrip_settings['rdPostLogoImage'] = $use_logoimage;			
            $reachdrip_settings['rdPostBigImage'] = $use_bigimage;
            $reachdrip_settings['rdJsRestrict'] = $rdJsRestrict;
            $reachdrip_settings['rdNewPostChecked'] = $rdNewPostChecked;
            $reachdrip_settings['rdUpdatePostChecked'] = $rdUpdatePostChecked;
            $reachdrip_settings['rdIsAutoPushUTM'] = $auto_push_UTM;
            $reachdrip_settings['rdPostMessage'] = $reachdrip_setting_post_message;			
			$reachdrip_settings['rdDisallowPostTypes'] = $rdDisallowPostTypes;
			
            update_option('reachdrip_settings', $reachdrip_settings);

            $response_message = trim('Setting successfully save.');

            wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-setting') . '&response_message=' . $response_message));
        }
    }

    public static function reachdrip_advance_setting()
    {
        $reachdrip_settings = self::reachdrip_settings();

        $appKey = $reachdrip_settings['appKey'];

        $secretKey = $reachdrip_settings['appSecret'];

        if (isset($_POST['rd-advance-settings'])) {

            $reachdrip_timeinterval = sanitize_text_field($_POST['reachdrip_timeinterval']);
            $reachdrip_opt_in_title = sanitize_text_field($_POST['reachdrip_opt_in_title']);
            $reachdrip_opt_in_subtitle = sanitize_text_field($_POST['reachdrip_opt_in_subtitle']);
            $reachdrip_allow_button_text = sanitize_text_field($_POST['reachdrip_allow_button_text']);
            $reachdrip_disallow_button_text = sanitize_text_field($_POST['reachdrip_disallow_button_text']);
            $template = sanitize_text_field($_POST['template']);
            $location = sanitize_text_field($_POST['rd_template_location']);
            
			/*   image upload   */

			$image_name = '';
			$image_data = '';			
			$actual_uploaded_image_path = '';

			$tm = time();

			$upload_file_name = sanitize_file_name($_FILES['reachdrip_setting_fileupload']['name']);

			$upload_tem_file_name = sanitize_file_name($_FILES['reachdrip_setting_fileupload']['tmp_name']);

			if ($upload_file_name != '' && $upload_tem_file_name != '') {

				$wp_upload_dir = wp_upload_dir();

				$image_name = $tm . '-' . $upload_file_name;

				move_uploaded_file($upload_tem_file_name, $wp_upload_dir['basedir'] . '/' . $image_name);

				$actual_uploaded_image_path = $wp_upload_dir['baseurl'] . '/' . $tm . '-' . $upload_file_name;
			}

			/*   image upload  end  */

			$reachdrip_child_window_text = sanitize_text_field($_POST['reachdrip_child_window_text']);
			$reachdrip_child_window_title = sanitize_text_field($_POST['reachdrip_child_window_title']);
			$reachdrip_child_window_message = sanitize_text_field($_POST['reachdrip_child_window_message']);
			$reachdrip_setting_title = sanitize_text_field($_POST['reachdrip_setting_title']);
			$reachdrip_setting_message = sanitize_text_field($_POST['reachdrip_setting_message']);
			$reachdrip_redirect_url = sanitize_text_field($_POST['reachdrip_redirect_url']);

			if (isset($appKey) && isset($secretKey)) {

				$advance_settings = array("templatesetting" => array("interval_time" => $reachdrip_timeinterval,
					"opt_in_title" => trim($reachdrip_opt_in_title),
					"opt_in_subtitle" => trim($reachdrip_opt_in_subtitle),
					"allow_button_text" => trim($reachdrip_allow_button_text),
					"disallow_button_text" => trim($reachdrip_disallow_button_text),
					"template" => $template,
					"location" => $location,
					"image_name" => trim($image_name),
					"image_path" => trim($actual_uploaded_image_path),
					"child_window_text" => trim($reachdrip_child_window_text),
					"child_window_title" => trim($reachdrip_child_window_title),
					"child_window_message" => trim($reachdrip_child_window_message),
					"notification_title" => trim($reachdrip_setting_title),
					"notification_message" => trim($reachdrip_setting_message),
					"redirect_url" => trim($reachdrip_redirect_url))
				);

				$account_request_data = array("appKey" => $appKey,
					"appSecret" => $secretKey,
					"action" => "settings/",
					"method" => "POST",
					"remoteContent" => $advance_settings
				);

				$site_settings = self::reachdrip_decode_request($account_request_data);

				if ($site_settings['status'] == 'Success') {

					$response_message = $site_settings['response_message'];

				} else if ($site_settings['errors'] != '') {

					$response_message = $site_settings['errors'];

				} else if ($site_settings['error'] != '') {

					$response_message = $site_settings['error'];

				} else {

					$response_message = $site_settings['error_message'];
				}

				$response_message = trim($response_message);

				wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-setting') . '&response_message=' . $response_message));
			}
		}
    }

    public static function reachdrip_footer_promo()
    {
        echo <<<END_SCRIPT
<!-- Push Notifications for this site is powered by ReachDrip. Push Notifications for Chrome, Safari, FireFox, Opera. - Plugin version 2.0.1 - https://reachdrip.com/ -->
END_SCRIPT;

    }

    public static function reachdrip_gcm_setting()
    {
        $reachdrip_settings = self::reachdrip_settings();

        $appKey = $reachdrip_settings['appKey'];

        $secretKey = $reachdrip_settings['appSecret'];

        if (isset($_POST['rd-gcm-settings'])) {

            $reachdrip_gcm_project_no = sanitize_text_field($_POST['reachdrip_gcm_project_no']);

            $reachdrip_gcm_api_key = sanitize_text_field($_POST['reachdrip_gcm_api_key']);

            if (isset($appKey) && isset($secretKey)) {

                $gcm_settings = array("accountgcmsetting" => array("project_number" => $reachdrip_gcm_project_no,
                    "project_api_key" => trim($reachdrip_gcm_api_key))
                );

                $gcm_request_data = array("appKey" => $appKey,
                    "appSecret" => $secretKey,
                    "action" => "gcmsettings/",
                    "method" => "POST",
                    "remoteContent" => $gcm_settings
                );

                $gcm_settings = self::reachdrip_decode_request($gcm_request_data);

                if ($gcm_settings['status'] == 'Success') {

                    $response_message = $gcm_settings['response_message'];

                } else if ($gcm_settings['errors'] != '') {

                    $response_message = $gcm_settings['errors'];

                } else if ($gcm_settings['error'] != '') {

                    $response_message = $gcm_settings['error'];

                } else {

                    $response_message = $gcm_settings['error_message'];
                }

                $response_message = trim($response_message);

                wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-setting') . '&response_message=' . $response_message));
            }
        }
    }

    public static function reachdrip_create_campaign()
    {
        if (isset($_POST['reachdrip_campaign_title']) && isset($_POST['reachdrip_campaign_message']) && isset($_POST['reachdrip_campaign_date'])) {

            $response_message = '';
            $utm_source = '';
            $utm_medium = '';
            $utm_campaign = '';

            $campaign_date = sanitize_text_field($_POST['reachdrip_campaign_date']);
            $message = sanitize_text_field($_POST['reachdrip_campaign_message']);
            $title = sanitize_text_field($_POST['reachdrip_campaign_title']);
            $campaign_timezone = sanitize_text_field($_POST['reachdrip_campaign_timezone']);
            $utm_string_url = esc_url($_POST['reachdrip_campaign_url']);

            if (isset($_POST['reachdrip_campaign_segment'])) {
                $segments = sanitize_text_field($_POST['reachdrip_campaign_segment']);
            } else {
                $segments = array();
            }

            if ($title == '') {

                $response_message = 'Please provide title.';

            } else if ($message == '') {

                $response_message = 'Please provide message.';

            } else if ($campaign_date == '') {

                $response_message = 'Please provide campaign date.';

            } else if ($_POST['reachdrip_campaign_is_utm_show'] == 1 && $utm_string_url == '') {

                $response_message = 'Please provide campaign url.';

            } else if ($_POST['reachdrip_campaign_is_utm_show'] == 1 && $_POST['reachdrip_campaign_utm_source'] == '') {

                $response_message = 'Please provide UTM source.';

            } else if ($_POST['reachdrip_campaign_is_utm_show'] == 1 && $_POST['reachdrip_campaign_utm_medium'] == '') {

                $response_message = 'Please provide UTM medium.';

            } else if ($_POST['reachdrip_campaign_is_utm_show'] == 1 && $_POST['reachdrip_campaign_utm_campaign'] == '') {

                $response_message = 'Please provide UTM campaign.';

            } else if ($_FILES['reachdrip_campaign_fileupload']['size'] > 500000) {

                $response_message = 'Image size must be exactly 250x250px.';
            }

            if (!empty($response_message)) {

                $response_message = trim(trim($response_message));

                wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-new-campaign') . '&response_message=' . $response_message));

            } else {

                $reachdrip_settings = self::reachdrip_settings();

                $appKey = $reachdrip_settings['appKey'];

                $appSecret = $reachdrip_settings['appSecret'];

                /*   image upload   */
                $tm = time();

                $upload_file_name = $_FILES['reachdrip_campaign_fileupload']['name'];

                $upload_tem_file_name = $_FILES['reachdrip_campaign_fileupload']['tmp_name'];

                if ($upload_file_name != '' && $upload_tem_file_name != '') {

                    $wp_upload_dir = wp_upload_dir();

                    move_uploaded_file($upload_tem_file_name, $wp_upload_dir['basedir'] . '/' . $tm . '-' . $upload_file_name);

                    $actual_uploaded_image_path = $wp_upload_dir['baseurl'] . '/' . $tm . '-' . $upload_file_name;

                } else {

                    $actual_uploaded_image_path = '';
                }

                /*   image upload  end  */

                if (isset($_POST['reachdrip_campaign_utm_source']) && $_POST['reachdrip_campaign_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_source = sanitize_text_field($_POST['reachdrip_campaign_utm_source']);
                }

                if (isset($_POST['reachdrip_campaign_utm_medium']) && $_POST['reachdrip_campaign_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_medium = sanitize_text_field($_POST['reachdrip_campaign_utm_medium']);
                }

                if (isset($_POST['reachdrip_campaign_utm_campaign']) && $_POST['reachdrip_campaign_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_campaign = sanitize_text_field($_POST['reachdrip_campaign_utm_campaign']);
                }

                $campaign = array("campaign" => array("title" => $title,
                    "message" => $message,
                    "timezone" => $campaign_date,
                    "redirect_url" => $utm_string_url,
                    "image" => $actual_uploaded_image_path),
                    "utm_params" => array("utm_source" => $utm_source,
                        "utm_medium" => $utm_medium,
                        "utm_campaign" => $utm_campaign),
                    "segments" => $segments,
                    "campaign_timezone" => $campaign_timezone
                );

                $campaign_request_data = array("appKey" => trim($appKey),
                    "appSecret" => trim($appSecret),
                    "action" => "campaigns/",
                    "method" => "POST",
                    "remoteContent" => $campaign
                );

                $campaign_response = self::reachdrip_decode_request($campaign_request_data);

                if ($campaign_response['status'] == 'Success') {

                    $response_message = $campaign_response['response_message'];

                } else if ($campaign_response['errors'] != '') {

                    $response_message = $campaign_response['errors'];

                } else if ($campaign_response['error'] != '') {

                    $response_message = $campaign_response['error'];

                } else {

                    $response_message = $campaign_response['error_message'];
                }

                $response_message = trim(trim($response_message));

                if ($campaign_response['status'] == 'Success') {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-admin') . '&response_message=' . $response_message));
					
                } else {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-new-campaign') . '&response_message=' . $response_message));
                }
            }
        }
    }

    // Check Reachdrip Account valid or not
    public static function reachdrip_settings()
    {
        $reachdrip = get_option('reachdrip_settings');

        return $reachdrip;
    }

    // if already registered then accept API keys
    public static function reachdrip_accept_keys()
    {
        $response_message = '';

        if (isset($_POST['reachdrip_api_key']) || isset($_POST['reachdrip_secret_key'])) {

            $appKey = sanitize_text_field($_POST['reachdrip_api_key']);
            $secretKey = sanitize_text_field($_POST['reachdrip_secret_key']);

            $request_data = array("appKey" => $appKey,
                "appSecret" => $secretKey,
                "action" => 'accounts_info/',
                "method" => "GET",
                "remoteContent" => array()
            );

            $account_info = self::reachdrip_decode_request($request_data);

            if (isset($account_info['apiKey']) && isset($account_info['apiSecret'])) {

                $reachdrip_settings = array(

                    'appKey' => trim($account_info['apiKey']),
                    'appSecret' => trim($account_info['apiSecret']),
                    'jsPath' => trim($account_info['jsPath']),
                    'rdAutoPush' => false,
                    'rdEditPostPush' => false,
                    'rdIsAutoPushUTM' => false,
                    'rdJsRestrict' => false,
                    'rdNewPostChecked' => false,
                    'rdUpdatePostChecked' => false,
                    'rdPostLogoImage' => false,
                    'rdPostBigImage' => false,
                    'rdDisallowPostTypes' => '',
                    'rdUTMSource' => 'reachdrip',
                    'rdUTMMedium' => 'reachdrip_notification',
                    'rdUTMCampaign' => 'reachdrip',
                    'rdPostMessage' => 'We have just published an article, check it out!'
                );

                wp_enqueue_script('reachdrip-js', trim($account_info['jsPath']), array('jquery'), "", true);

                add_option('reachdrip_settings', $reachdrip_settings);

                $response_message = trim("ReachDrip is installed, no additional step is needed. Completely Purge Site Cache once to see it in action. Your Account Details have already been emailed to you. Also check under SPAM if you don't find it.");

                wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-admin') . '&response_message=' . $response_message));

            } else {

                if (isset($account_info['error'])) {

                    $response_message = trim($account_info['error']);
                }

                wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-create-account') . '&response_message=' . $response_message));
            }
        }
    }

    // function to create an new account
    public static function reachdrip_account_create()
    {
        if (isset($_POST['reachdrip_api_form']) && $_POST['reachdrip_api_form'] == 'reachdrip_account_creation') {

            if (isset($_POST['reachdrip_name']) || isset($_POST['reachdrip_email']) || isset($_POST['reachdrip_contact']) || isset($_POST['reachdrip_password']) || isset($_POST['reachdrip_protocol']) || isset($_POST['reachdrip_site_url']) || isset($_POST['reachdrip_sub_domain'])) {

                $response_message_error = '';

                $name = sanitize_text_field($_POST['reachdrip_name']);

                $company_name = sanitize_text_field($_POST['reachdrip_company_name']);

                $email = sanitize_email($_POST['reachdrip_email']);

                $contact = sanitize_text_field($_POST['reachdrip_contact']);

                $hidden_rd_error_msg = sanitize_text_field($_POST['hidden_rd_error_msg']);

                $password = sanitize_text_field($_POST['reachdrip_password']);

                $protocol = sanitize_text_field($_POST['reachdrip_protocol']);

                $site_url = sanitize_text_field($_POST['reachdrip_site_url']);

                $url = $protocol . $site_url;

                $sub_domain = sanitize_text_field($_POST['reachdrip_sub_domain']);

                if ($hidden_rd_error_msg == 0 && !empty($contact)) {

                    $response_message_error = trim('Please Provide valid contact no.');
                }

                $flag = self::urlValidator($url);

                if ($flag == 0) {

                    $response_message_error = trim('Please Provide valid site URL.');
                }

                if (!empty($response_message_error)) {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-create-account') . '&response_message=' . $response_message_error));

                } else {
                    /*   account creation   */
                    $remoteContent = array("account" => array("name" => trim($name),
                        "company_name" => trim($company_name),
                        "contact" => $contact,
                        "email" => trim($email),
                        "password" => trim($password),
                        "protocol" => trim($protocol),
                        "siteurl" => trim($site_url),
                        "subdomain" => trim($sub_domain),
                        "rd_source" => 'WordPress')
                    );

                    $account_request_data = array("action" => "accounts/",
                        "method" => "POST",
                        "remoteContent" => $remoteContent
                    );

                    $account_create = self::reachdrip_decode_request($account_request_data);

                    if ($account_create['status'] == 'Success') {

                        $dashboard_request_data = array("appKey" => $account_create['api_key'],
                            "appSecret" => $account_create['auth_secret'],
                            "action" => "accounts_info/",
                            "method" => "GET",
                            "remoteContent" => ""
                        );

                        $account_info = self::reachdrip_decode_request($dashboard_request_data);

                        if (isset($account_info['apiKey']) && isset($account_info['apiSecret'])) {

                            $reachdrip_settings = array(

                                'appKey' => trim($account_info['apiKey']),
                                'appSecret' => trim($account_info['apiSecret']),
                                'jsPath' => trim($account_info['jsPath']),
                                'rdAutoPush' => false,
                                'rdEditPostPush' => false,
                                'rdIsAutoPushUTM' => false,
                                'rdJsRestrict' => false,
                                'rdNewPostChecked' => false,
                                'rdUpdatePostChecked' => false,
								'rdPostLogoImage' => false,
								'rdPostBigImage' => false,
								'rdDisallowPostTypes' => '',
                                'rdUTMSource' => 'reachdrip',
                                'rdUTMMedium' => 'reachdrip_notification',
                                'rdUTMCampaign' => 'reachdrip',
                                'rdPostMessage' => 'We have just published an article, check it out!',
                            );

                            wp_enqueue_script('reachdrip-js', trim($account_info['jsPath']), array('jquery'), "", true);

                            add_option('reachdrip_settings', $reachdrip_settings);

                            if ($account_create['status'] == 'Success') {

                                $response_message = $account_create['response_message'];
                            }

                            $response_message = trim("ReachDrip is installed, no additional step is needed. Completely Purge Site Cache once to see it in action.  Your Account Details have already been emailed to you. Also check under SPAM if you don't find it.");

                            wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-admin') . '&response_message=' . $response_message));
                        }

                    } else {

                        if ($account_create['error'] != '') {

                            $response_message = $account_create['error'];

                        } else if ($account_create['errors'] != '') {

                            $response_message = $account_create['errors'];

                        } else {

                            $response_message = $account_create['error_message'];
                        }

                        $response_message = trim(trim($response_message));

                        wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-create-account') . '&response_message=' . $response_message));
                    }
                }
            }
        } else {

            self::reachdrip_accept_keys();
        }
    }

    /*   notification send    */

    public static function send_reachdrip_notifications()
    {
        if (isset($_POST['reachdrip_notification_title']) || isset($_POST['reachdrip_notification_message'])) {

            $utm_source = '';
            $utm_medium = '';
            $utm_campaign = '';
			$big_image_url = '';

            $message = sanitize_text_field($_POST['reachdrip_notification_message']);

            $title = sanitize_text_field($_POST['reachdrip_notification_title']);

            $utm_string_url = esc_url($_POST['reachdrip_notification_url']);
									
            if (isset($_POST['reachdrip_notification_segment'])) {
                $segment = sanitize_text_field($_POST['reachdrip_notification_segment']);
            } else {

                $segment = array();
            }

            if ($title == '') {

                $response_message = 'Please provide title.';

            } else if ($message == '') {

                $response_message = 'Please provide message.';

            } else if ($_POST['reachdrip_notification_is_utm_show'] == 1 && $utm_string_url == '') {

                $response_message = 'Please provide notification url.';

            } else if ($_POST['reachdrip_notification_is_utm_show'] == 1 && $_POST['reachdrip_notification_utm_source'] == '') {

                $response_message = 'Please provide UTM source.';

            } else if ($_POST['reachdrip_notification_is_utm_show'] == 1 && $_POST['reachdrip_notification_utm_medium'] == '') {

                $response_message = 'Please provide UTM medium.';

            } else if ($_POST['reachdrip_notification_is_utm_show'] == 1 && $_POST['reachdrip_notification_utm_campaign'] == '') {

                $response_message = 'Please provide UTM campaign.';

            } else if ($_FILES['reachdrip_notification_fileupload']['size'] > 500000) {

                $response_message = 'Image size must be exactly 256x256px.';
            }

            if (!empty($response_message)) {

                $response_message = trim(trim($response_message));

                wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-new-notification') . '&response_message=' . $response_message));

            } else {

                $reachdrip_settings = self::reachdrip_settings();

                $appKey = $reachdrip_settings['appKey'];

                $appSecret = $reachdrip_settings['appSecret'];

                /*   image upload   */

                $tm = time();

                //$upload_file = $_FILES['reachdrip_notification_fileupload'];

                $upload_file_name = $_FILES['reachdrip_notification_fileupload']['name'];

                $upload_tem_file_name = $_FILES['reachdrip_notification_fileupload']['tmp_name'];

                if ($upload_file_name != '' && $upload_tem_file_name != '') {

                    $wp_upload_dir = wp_upload_dir();

                    move_uploaded_file($upload_tem_file_name, $wp_upload_dir['basedir'] . '/' . $tm . '-' . $upload_file_name);

                    $actual_uploaded_image_path = $wp_upload_dir['baseurl'] . '/' . $tm . '-' . $upload_file_name;

                } else {

                    $actual_uploaded_image_path = '';
                }
				
				/*	Notification Large Image  */
				if(isset($_POST['reachdrip_is_big_image']) && $_POST['reachdrip_is_big_image'] == 1 && $actual_uploaded_image_path != ''){
				
					$big_image_url = $actual_uploaded_image_path;
					$actual_uploaded_image_path = '';
				}

                /*   image upload  end  */

                if (isset($_POST['reachdrip_notification_utm_source']) && $_POST['reachdrip_notification_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_source = sanitize_text_field($_POST['reachdrip_notification_utm_source']);
                }

                if (isset($_POST['reachdrip_notification_utm_medium']) && $_POST['reachdrip_notification_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_medium = sanitize_text_field($_POST['reachdrip_notification_utm_medium']);
                }

                if (isset($_POST['reachdrip_notification_utm_campaign']) && $_POST['reachdrip_notification_is_utm_show'] == 1 && $utm_string_url != '') {

                    $utm_campaign = sanitize_text_field($_POST['reachdrip_notification_utm_campaign']);
                }

                $notification = array("notification" => array("title" => $title,
                    "message" => $message,
                    "redirect_url" => $utm_string_url,
                    "image" => $actual_uploaded_image_path,
					"big_image" => $big_image_url),
                    "utm_params" => array("utm_source" => $utm_source,
                        "utm_medium" => $utm_medium,
                        "utm_campaign" => $utm_campaign),
                    "segments" => $segment
                );

                $notification_request_data = array("appKey" => trim($appKey),
                    "appSecret" => trim($appSecret),
                    "action" => "notifications/",
                    "method" => "POST",
                    "remoteContent" => $notification
                );
				
                $notification_response = self::reachdrip_decode_request($notification_request_data);

                if ($notification_response['status'] == 'Success') {

                    $response_message = $notification_response['response_message'];

                } else if ($notification_response['errors'] != '') {

                    $response_message = $notification_response['errors'];

                } else if ($notification_response['error'] != '') {

                    $response_message = $notification_response['error'];

                } else {

                    $response_message = $notification_response['error_message'];
                }

                $response_message = trim(trim($response_message));

                if ($notification_response['status'] == 'Success') {
                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-admin') . '&response_message=' . $response_message));
                } else {
                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-new-notification') . '&response_message=' . $response_message));
                }
            }
        }
    }

    /*   end notification   */

    /*   add segment   */

    public static function reachdrip_segment()
    {
        $reachdrip_settings = self::reachdrip_settings();

        if (isset($_POST['reachdrip_segment_name'])) {

            $pushassit_segmentname = sanitize_text_field($_POST['reachdrip_segment_name']);

            if ($pushassit_segmentname != '') {

                $pushassit_segmentname = str_replace(" ", "", $pushassit_segmentname);

                $remoteContent = array("segment" => array("segment_name" => $pushassit_segmentname));

                $segment_request_data = array("appKey" => trim($reachdrip_settings['appKey']),
                    "appSecret" => trim($reachdrip_settings['appSecret']),
                    "action" => "segments/",
                    "method" => "POST",
                    "remoteContent" => $remoteContent
                );

                $add_segment = self::reachdrip_decode_request($segment_request_data);

                if ($add_segment['status'] == 'Success') {
                    $response_message = $add_segment['response_message'];

                } else if ($add_segment['errors'] != '') {
                    $response_message = $add_segment['errors'];

                } else if ($add_segment['error'] != '') {
                    $response_message = $add_segment['error'];

                } else {

                    $response_message = $add_segment['error_message'];
                }

                if ($add_segment['status'] == 'Success') {

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-all-segments')));

                } else {

                    $response_message = trim(trim($response_message));

                    wp_redirect(esc_url_raw(admin_url('admin.php?page=reachdrip-create-segments') . '&response_message=' . $response_message));
                }
            }
        }
    }

    /*   segment end  */

    /*  New post publish notification  */

    public static function reachdrip_publish_new_post()
    {
		add_meta_box(
			'reachdrip_notify_on_post',
			'ReachDrip Push Notification',
			array( __CLASS__, 'reachdrip_post_sidebar_widget' ),
			'post',
			'side',
			'high'
		);
    }

    public static function reachdrip_publish_new_product()
    {
		add_meta_box(
			'reachdrip_notify_on_post',
			'ReachDrip Push Notification',
			array( __CLASS__, 'reachdrip_post_sidebar_widget' ),
			'product',
			'side',
			'high'
		);
    }

    public static function reachdrip_post_sidebar_widget()
    {
        $newpostChecked = '';

        $updatepostChecked = '';

        $reachdrip_settings = self::reachdrip_settings();

        $rdNewPostChecked = $reachdrip_settings['rdNewPostChecked'];

        if (isset($rdNewPostChecked) && (true === $rdNewPostChecked)) {
            $newpostChecked = 'checked="checked"';
        }

        $rdUpdatePostChecked = $reachdrip_settings['rdUpdatePostChecked'];

        if (isset($rdUpdatePostChecked) && (true === $rdUpdatePostChecked)) {
            $updatepostChecked = 'checked="checked"';
        }

        $rd_auto_push = $reachdrip_settings['rdAutoPush'];
		$rdEditPostPush = $reachdrip_settings['rdEditPostPush'];

        global $post;

        printf('<div id="reachdrip_segment_checkboxes" class="misc-pub-section">');
		
		if ('publish' === $post->post_status) {	//while updating post
			
			if($rdEditPostPush === false){

				printf('<label><input type="checkbox" ' . $updatepostChecked . ' value="1" id="reachdrip-forced-checkbox" name="reachdrip-checkbox" style="margin: -3px 9px 0 1px;" />');
				_e('Send Push Notification on Update', 'reachdrip-web-push-notifications');
				echo ' </label>';
			
			} else {
					
				printf('<label><input type="checkbox" value="1" id="reachdrip-forced-checkbox" name="reachdrip-donot-send-checkbox" style="margin: -3px 9px 0 1px;" />');
				_e('Don\'t Send Push Notification', 'reachdrip-web-push-notifications');
				echo ' </label>';
			}

		} else if ('auto-draft' === $post->post_status) {	//while creating new post
	
			if($rd_auto_push === false){
				
				$reachdrip_post_id = get_the_ID();				
				printf('<label><input type="checkbox" value="1"  ' . $newpostChecked . ' id="reachdrip-forced-checkbox" name="reachdrip-checkbox" style="margin: -3px 9px 0 1px;" %s />', checked(get_post_meta($reachdrip_post_id, '_reachdrip_force', true), 1, false));
				_e('Send Push Notification', 'reachdrip-web-push-notifications');
				echo ' </label>';
			
			} else {
				
				printf('<label><input type="checkbox" value="1" id="reachdrip-forced-checkbox" name="reachdrip-donot-send-checkbox" style="margin: -3px 9px 0 1px;" />');
				_e('Don\'t Send Push Notification', 'reachdrip-web-push-notifications');
				echo ' </label>';
			}
			
		} else if('draft' === $post->post_status) {	//while publishing draft post
			
			if($rd_auto_push === false){
				
				$reachdrip_post_id = get_the_ID();

				printf('<label><input type="checkbox" value="1"  ' . $newpostChecked . ' id="reachdrip-forced-checkbox" name="reachdrip-checkbox" style="margin: -3px 9px 0 1px;" %s />', checked(get_post_meta($reachdrip_post_id, '_reachdrip_force', true), 1, false));
				_e('Send Push Notification', 'reachdrip-web-push-notifications');
				echo ' </label>';
			
			} else {
				
				printf('<label><input type="checkbox" value="1" id="reachdrip-forced-checkbox" name="reachdrip-donot-send-checkbox" style="margin: -3px 9px 0 1px;" />');
				_e('Don\'t Send Push Notification', 'reachdrip-web-push-notifications');
				echo ' </label>';
			}
		}
		
        wp_nonce_field('reachdrip_save_post', 'hidden_pe');

        echo '</div>';

        if (($rd_auto_push === false && 'publish' !== $post->post_status) || ('publish' === $post->post_status && $rdEditPostPush === false) || ('draft' === $post->post_status && $rd_auto_push === false)) {

            if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret'])) {

                $segment_data = array("appKey" => trim($reachdrip_settings['appKey']),
                    "appSecret" => trim($reachdrip_settings['appSecret']),
                    "action" => 'segments/',
                    "method" => "GET",
                    "remoteContent" => ""
                );

                $reachdrip_segmets_data = self::reachdrip_decode_request($segment_data);

            } else {
                $reachdrip_segmets_data = '';
            }

            if (!empty($reachdrip_segmets_data)) {

                printf('<div style="padding-left:37px;padding-top:0px; line-height: 25px" id="reachdrip_post_categories"><span style="font-weight:bold;">');
                _e('Select ReachDrip Segments', 'reachdrip-web-push-notifications');
                printf('</span>');

                echo '<br><input type="checkbox" id="reachdrip_checkbox" onclick="reachdrip_check_all();"><span  style="margin-left:10px;">';
                _e('All', 'reachdrip-web-push-notifications');
                echo '</span>';

                foreach ($reachdrip_segmets_data as $segment_list) {

                    echo '<div style="margin:5px 10px 5px 0px !important;"><input type="checkbox" class="reachdrip-segments" name="reachdrip_segment_categories[]" value="' . $segment_list["id"] . '"><span style="margin-left:10px;">' . $segment_list["name"] . '</span></div>';
                }
                echo '</div>';

                echo '<script>
				function reachdrip_check_all()
				{
					var reachdrip_all_checkbox = document.getElementById("reachdrip_checkbox").checked;

					var reachdrip_segments = document.getElementsByClassName("reachdrip-segments");

					for (var key in reachdrip_segments)
					{
					  if (reachdrip_segments.hasOwnProperty(key))
					  {
						if(!reachdrip_all_checkbox)
						{
							reachdrip_segments[key].checked = false;
						}
						else
						{
							reachdrip_segments[key].checked = true;
						}
					  }
					}
				}
				</script>';
            }
        }
    }

    public static function reachdrip_note_text($post_type, $post)
    {
        if ('post' === $post_type || 'shop_coupon' === $post_type || 'product' === $post_type) {

            if ('attachment' !== $post_type && 'comment' !== $post_type && 'dashboard' !== $post_type && 'link' !== $post_type) {

                add_meta_box(
                    'reachdrip_meta',
                    __('ReachDrip Notification Message', 'reachdrip-web-push-notifications'),
                    array(__CLASS__, 'reachdrip_custom_message_widget'),
                    '',
                    'normal',
                    'high'
                );
            }
        }
    }

    public static function reachdrip_custom_message_widget($post)
    {
        $reachdrip_note_text = get_post_meta($post->ID, '_reachdrip_custom_text', true);

        ?>
        <div id="reachdrip_custom_note" class="form-field form-required">

            <input type="text" id="reachdrip_post_notification_message" maxlength="138"
                   placeholder="<?php _e('Notification Message', 'reachdrip-web-push-notifications'); ?>"
                   name="reachdrip_post_notification_message"
                   value="<?php echo !empty($reachdrip_note_text) ? esc_attr($reachdrip_note_text) : ''; ?>"/><br>
            <span
                id="reachdrip-post-description"><?php _e('Limit 138 Characters', 'reachdrip-web-push-notifications'); ?>
                <br/> <?php _e('When using a custom headline, this text will be used in place of the default blog post message for your push notification.', 'reachdrip-web-push-notifications'); ?></span>
        </div>
        <?php
    }

    public static function save_reachdrip_post_meta_data($post_id)
    {		
		$reachdrip_settings = self::reachdrip_settings();

		$rd_auto_push = $reachdrip_settings['rdAutoPush'];
		
        if ((!isset($_POST['reachdrip-checkbox']) || !current_user_can('edit_posts') || isset($_POST['reachdrip-donot-send-checkbox'])) && false === $rd_auto_push) {			
            return false;

        } else {
			
            $reachdrip_note = get_post_meta($post_id, '_reachdrip_checkbox_override', true);

            if ((isset($_POST['reachdrip-checkbox']) && !$reachdrip_note) || (true === $rd_auto_push && !$reachdrip_note)) {

				if ((isset($_POST['reachdrip-checkbox']))){
					
					$checkbox_setting = sanitize_text_field($_POST['reachdrip-checkbox']);
					add_post_meta($post_id, '_reachdrip_checkbox_override', $checkbox_setting, true);					
				}
				
            } elseif (!isset($_POST['reachdrip-checkbox']) && $reachdrip_note) {

                delete_post_meta($post_id, '_reachdrip_checkbox_override');
            }

            if (isset($_POST['reachdrip_post_notification_message']) || true === $rd_auto_push) {
			
				if ((isset($_POST['reachdrip_post_notification_message']))){					
					update_post_meta($post_id, '_reachdrip_custom_text', sanitize_text_field($_POST['reachdrip_post_notification_message']));
				}
            }
        }
    }

    public static function send_reachdrip_post_notification($new_status, $old_status, $post)
    {
        $reachdrip_settings = self::reachdrip_settings();

        $appKey = $reachdrip_settings['appKey'];
        $appSecret = $reachdrip_settings['appSecret'];
        $rd_auto_push = $reachdrip_settings['rdAutoPush'];
        $rd_edit_post_push = $reachdrip_settings['rdEditPostPush'];
        $rdIsAutoPushUTM = $reachdrip_settings['rdIsAutoPushUTM'];
        $rdPostLogoImage = $reachdrip_settings['rdPostLogoImage'];		
        $rdPostBigImage = $reachdrip_settings['rdPostBigImage'];

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
		$rd_post_list = array();
				
		if(isset($reachdrip_settings['rdDisallowPostTypes'])){
			$rd_post_list = explode(",", $reachdrip_settings['rdDisallowPostTypes']);
		}

        $post_type = get_post_type($post);
				
		if(in_array($post_type, $rd_post_list)){ return; }
		
        if (!isset($appKey) || !isset($appSecret)) { return; }

        if (empty($post) || (isset($_POST['reachdrip-donot-send-checkbox']))) {  return;  }

        $reachdrip_post_id = $post->ID;

        if ('publish' === $new_status && 'publish' === $old_status) {

            if (isset($_POST['reachdrip-checkbox']) || true === $rd_auto_push) {

                $reachdrip_note = true;
            }
        }

        if ($new_status !== $old_status || !empty($reachdrip_note) || true === $rd_edit_post_push) {

            if ('publish' === $new_status) {

                $segments = array();
                $image_url = null;
				$big_image_url = null;

                if (('publish' === $new_status && 'future' === $old_status)) {

                    $reachdrip_checkbox_array = get_post_meta($reachdrip_post_id, '_reachdrip_checkbox_override', true);

                    $reachdrip_post_notification_text = get_post_meta($reachdrip_post_id, '_reachdrip_custom_text', true);

                } else {

                    if (isset($_POST['reachdrip-checkbox'])) {

                        $reachdrip_checkbox_array = sanitize_text_field($_POST['reachdrip-checkbox']);
                    }

                    if (isset($_POST['reachdrip_post_notification_message']) && !empty($_POST['reachdrip_post_notification_message'])) {

                        $reachdrip_post_notification_text = sanitize_text_field($_POST['reachdrip_post_notification_message']);
                    }
                }

                if (!empty($reachdrip_checkbox_array) || true === $rd_auto_push || true === $rd_edit_post_push) {
					
                    if (isset($_POST['reachdrip_segment_categories']) and !empty($_POST['reachdrip_segment_categories'])) {

                        $segments = sanitize_text_field($_POST['reachdrip_segment_categories']);
                    }

                    if (!empty($reachdrip_post_notification_text)) {

                        $notification_title_text = sanitize_text_field(substr(get_the_title($reachdrip_post_id), 0, 100));

                        $notification_message_text = sanitize_text_field(substr(stripslashes($reachdrip_post_notification_text), 0, 138));

                    } else {

                        $notification_title_text = sanitize_text_field(substr(get_the_title($reachdrip_post_id), 0, 100));

                        if (isset($reachdrip_settings['rdPostMessage'])) {

                            $notification_message_text = sanitize_text_field(substr(stripslashes($reachdrip_settings['rdPostMessage']), 0, 138));

                        } else {

                            $notification_message_text = sanitize_text_field(substr(stripslashes(__('We have just published an article, check it out!', 'reachdrip-web-push-notifications')), 0, 138));
                        }
                    }

                    if (((isset($reachdrip_settings['rdPostBigImage']) && $rdPostBigImage == true) && (isset($reachdrip_settings['rdPostLogoImage']) && $rdPostLogoImage == true)) || $rdPostLogoImage == false) {

                        if (has_post_thumbnail($reachdrip_post_id)) {

                            $thumbnail_image = wp_get_attachment_image_src(get_post_thumbnail_id($reachdrip_post_id));

                            $image_url = $thumbnail_image[0];
                        }
                    }

                    if (isset($reachdrip_settings['rdPostBigImage']) && $rdPostBigImage == true && (isset($reachdrip_settings['rdPostLogoImage']) && $rdPostLogoImage == false)) {
						
						$big_image_url = $image_url;
						$image_url = null;
					}
					
					if ((isset($reachdrip_settings['rdPostBigImage']) && $rdPostBigImage == true) && (isset($reachdrip_settings['rdPostLogoImage']) && $rdPostLogoImage == true)) {
						
						$big_image_url = $image_url;
						$image_url = null;
					}
					
                    if (isset($reachdrip_settings['rdUTMSource']) && $rdIsAutoPushUTM == true) {

                        $utm_source = sanitize_text_field($reachdrip_settings['rdUTMSource']);
                    }

                    if (isset($reachdrip_settings['rdUTMMedium']) && $rdIsAutoPushUTM == true) {

                        $utm_medium = sanitize_text_field($reachdrip_settings['rdUTMMedium']);
                    }

                    if (isset($reachdrip_settings['rdUTMCampaign']) && $rdIsAutoPushUTM == true) {

                        $utm_campaign = sanitize_text_field($reachdrip_settings['rdUTMCampaign']);
                    }

                    $reachdrip_link = get_permalink($reachdrip_post_id);

                    $notification = array("notification" => array("title" => $notification_title_text,
                        "message" => $notification_message_text,
                        "redirect_url" => $reachdrip_link,
                        "image" => $image_url,
						"big_image" => $big_image_url),
                        "utm_params" => array("utm_source" => $utm_source,
                            "utm_medium" => $utm_medium,
                            "utm_campaign" => $utm_campaign),
                        "segments" => $segments
                    );

                    $segment_request_data = array("appKey" => trim($appKey),
                        "appSecret" => trim($appSecret),
                        "action" => "notifications/",
                        "method" => "POST",
                        "remoteContent" => $notification
                    );
					echo "<br>Notification Success => ";
                    $notification_response = self::reachdrip_decode_request($segment_request_data);
					
					exit;
                }
            }
        }
    }	

    /*  end post publish notification  */

    public static function reachdrip_removeSpecialCharacters($string)
    {
        return preg_replace('/[^A-Za-z0-9\- ]/', '', $string);
    }

    /*     API Functions start     */
    public static function reachdrip_remote_request($remote_data)
    {
        $remote_url = 'https://api2.reachdrip.com/' . $remote_data['action'];

        if ($remote_data['action'] == "accounts/") {

            $headers = array("Content-Type" => 'application/json');

        } else {

            $headers = array(
                'X-Auth-Token' => $remote_data['appKey'],
                'X-Auth-Secret' => $remote_data['appSecret'],
                "Content-Type" => 'application/json'
            );
        }

        if ($remote_data['method'] != 'GET') {

            $remote_array = array(
                'method' => $remote_data['method'],
                'headers' => $headers,
                'body' => json_encode($remote_data['remoteContent']),
            );

        } else {

            $remote_array = array(
                'method' => $remote_data['method'],
                'headers' => $headers
            );
        }

        $response = wp_remote_request(esc_url_raw($remote_url), $remote_array);

        return $response;
    }

    public static function reachdrip_decode_request($remote_data)
    {
        $remote_request_response = self::reachdrip_remote_request($remote_data);

        $retrieve_body_content = wp_remote_retrieve_body($remote_request_response);

        $response_array = json_decode($retrieve_body_content, true);

        return $response_array;
    }

    public static function urlValidator($url)
    {
        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,4})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

        if (preg_match("/^$regex$/", $url)) { return 1; } else { return 0; }
    }
    /*     API Functions end    */
}