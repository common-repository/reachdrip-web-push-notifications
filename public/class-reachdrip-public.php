<?php

if (!defined('REACHDRIP_JS_URL')) {
	define('REACHDRIP_JS_URL', 'https://cdn.reachdrip.com/account/assets/');
}

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://reachdrip.com/
 * @since      2.0.1
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/public
 * @author     Team ReachDrip <support@reachdrip.com>
 */
class Reachdrip_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    2.0.1
	 */
	public function enqueue_styles() {

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

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/reachdrip-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.0.1
	 */
	public function enqueue_scripts() {

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
		$reachdrip_settings = get_option('reachdrip_settings');

		if (isset($reachdrip_settings['appKey']) && isset($reachdrip_settings['appSecret']) && isset($reachdrip_settings['jsPath']) && (isset($reachdrip_settings['rdJsRestrict']) && (false == $reachdrip_settings['rdJsRestrict']))) {
					
			add_action( 'wp_enqueue_scripts', 'load_jquery_check' );
			
			$switch_cdn = explode('assets/', $reachdrip_settings['jsPath']);

			echo '<script type="text/javascript" src="'.trim(REACHDRIP_JS_URL.$switch_cdn[1]).'" async></script>';
		}
	}
	
	public	function load_jquery_check() {
				
		if ( ! wp_script_is( 'jquery', 'enqueued' )) {

			//Enqueue
			wp_enqueue_script( 'jquery' );
		}
	}
	
	public function call_reachdrip_schedule_notification($new_status, $old_status, $post){

		$reachdrip_settings = get_option('reachdrip_settings');

		$appKey = $reachdrip_settings['appKey'];

		$appSecret = $reachdrip_settings['appSecret'];

		$rd_auto_push = $reachdrip_settings['rdAutoPush'];

		$rdIsAutoPushUTM = $reachdrip_settings['rdIsAutoPushUTM'];

		$rdPostLogoImage = $reachdrip_settings['rdPostLogoImage'];

		$utm_source = '';
		$utm_medium = '';
		$utm_campaign = '';

		if (!isset($appKey) || !isset($appSecret)) {

			return;
		}

		if (empty($post)) {

			return;
		}

		$reachdrip_note = false;

		$reachdrip_post_id = $post->ID;

		if ('publish' === $new_status && 'future' === $old_status) {

			$reachdrip_checkbox_array = get_post_meta($reachdrip_post_id, '_reachdrip_checkbox_override', true);

			if (!empty($reachdrip_checkbox_array)) {

				$reachdrip_note = true;
			}
		}

		if ((true === $reachdrip_note) || (true === $rd_auto_push && 'future' === $old_status)) {

			if ('publish' === $new_status) {

				$segments = array();
				$image_url = null;

				if (('publish' === $new_status && 'future' === $old_status)) {

					$reachdrip_checkbox_array = get_post_meta($reachdrip_post_id, '_reachdrip_checkbox_override', true);

					$reachdrip_post_notification_text = get_post_meta($reachdrip_post_id, '_reachdrip_custom_text', true);

				}

				if (!empty($reachdrip_checkbox_array) || (true === $rd_auto_push && 'future' === $old_status)) {

					if (isset($_POST['reachdrip_segment_categories']) and !empty($_POST['reachdrip_segment_categories'])) {

						$segments = sanitize_text_field($_POST['reachdrip_segment_categories']);
					}

					if (!empty($reachdrip_post_notification_text)) {

						$notification_title_text = sanitize_text_field(substr(get_the_title($reachdrip_post_id), 0, 100));

						$notification_message_text = sanitize_text_field(substr(stripslashes($reachdrip_post_notification_text), 0, 138));

					} else {

						$notification_title_text = sanitize_text_field(substr(get_the_title($reachdrip_post_id), 0, 100));

						if(isset($reachdrip_settings['rdPostMessage'])){

							$notification_message_text = sanitize_text_field(substr(stripslashes($reachdrip_settings['rdPostMessage']), 0, 138));

						} else {

							$notification_message_text = sanitize_text_field(substr(stripslashes(__('We have just published an article, check it out!', 'reachdrip-web-push-notifications')), 0, 138));
						}
					}

					if($rdPostLogoImage == false) {

						if (has_post_thumbnail($reachdrip_post_id)) {

							$thumbnail_image = wp_get_attachment_image_src(get_post_thumbnail_id($reachdrip_post_id));

							$image_url = $thumbnail_image[0];
						}
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
						"image" => $image_url),
						"utm_params" => array("utm_source" => $utm_source,
							"utm_medium" => $utm_medium,
							"utm_campaign" => $utm_campaign),
						"segments" => $segments
					);

					$notification_request_data = array("appKey" => trim($appKey),
						"appSecret" => trim($appSecret),
						"action" => "notifications/",
						"method" => "POST",
						"remoteContent" => $notification
					);

					$notification_response = self::reachdrip_decode_request($notification_request_data);
				}
			}
		}
	}

	public function reachdrip_remote_request($remote_data)
	{
		$remote_url = 'https://api2.reachdrip.com/' . $remote_data['action'];

		$headers = array(
			'X-Auth-Token' => $remote_data['appKey'],
			'X-Auth-Secret' => $remote_data['appSecret'],
			"Content-Type" => 'application/json'
		);

		$remote_array = array(
			'method' => $remote_data['method'],
			'headers' => $headers,
			'body' => json_encode($remote_data['remoteContent']),
		);

		$response = wp_remote_request(esc_url_raw($remote_url), $remote_array);

		return $response;
	}

	public function reachdrip_decode_request($remote_data)
	{	
		$remote_request_response = self::reachdrip_remote_request($remote_data);

		$retrieve_body_content = wp_remote_retrieve_body($remote_request_response);

		$response_array = json_decode($retrieve_body_content, true);

		return $response_array;
	}
}
