<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://reachdrip.com/
 * @since      2.0.1
 *
 * @package    Reachdrip
 * @subpackage Reachdrip/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- Content Start -->
<div id="reachdrip" class="content clearfix">
    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title"><?php _e('Settings / Account Information', 'reachdrip-web-push-notifications'); ?></h1>
    </div>
    <!-- End Page Header -->

    <?php if (isset($_REQUEST['response_message']) && $_REQUEST['response_message'] != '') { ?>
        <div class="margin-l-0 margin-b-20 updated notice notice-success is-dismissible">
            <p><?php echo $_REQUEST['response_message']; ?> </p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'reachdrip-web-push-notifications');?></span>
            </button>
        </div>
    <?php } ?>

    <!-- Container Start -->
    <div class="container-widget clearfix">
        <div class="col-md-6">
            <div class="panel panel-default">

                <div class="panel-body">

                    <form class="form-horizontal" autocomplete="off" id="reachdrip_template_setting_form"
                          name="reachdrip_template_setting_form" enctype="multipart/form-data"
                          action="admin.php?page=reachdrip-setting" method="post">

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label margin-r-5 padding-t-10"><?php _e('Ask for permission after', 'reachdrip-web-push-notifications'); ?></label>

                            <input type="number" id="reachdrip_timeinterval" name="reachdrip_timeinterval"
                                   placeholder="<?php _e('Interval', 'reachdrip-web-push-notifications'); ?>"
                                   min="0" style="width: 10%" max="30"
                                   maxlength="2" value="<?php echo $account_details['notification_interval']; ?>"/>
                            <label
                                class="control-label form-label margin-l-10 padding-t-0"> <?php _e('seconds on your website.', 'reachdrip-web-push-notifications'); ?></label>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Box Title', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_opt_in_title"
                                       id="reachdrip_opt_in_title" value="<?php _e(stripslashes_deep($account_details['opt_in_title']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Opt-In Box Title', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="80" required>
                                <span
                                    class="float-r"><?php _e('Limit 80 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Box Subtitle', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_opt_in_subtitle"
                                       id="reachdrip_opt_in_subtitle" value="<?php _e(stripslashes_deep($account_details['opt_in_subtitle']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Opt-In Box Subtitle', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="105" required>
                                <span
                                    class="float-r"><?php _e('Limit 105 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Allow Button Text', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_allow_button_text"
                                       id="reachdrip_allow_button_text" value="<?php _e(stripslashes_deep($account_details['allow_button']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Allow Button Text', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="25" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Don\'t Allow Button', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_disallow_button_text"
                                       id="reachdrip_disallow_button_text" value="<?php _e(stripslashes_deep($account_details['disallow_button']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Don\'t Allow Button', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="25" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label padding-l-0"><?php _e('Notification Template', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <select class="form-control col-sm-12" id="template" name="template">
                                    <?php

                                    $template = array('1' => 'Default', '2' => 'Template 1', '3' => 'Template 2', '4' => 'Template 3', '5' => 'Template 4', '6' => 'Template 5', '7' => 'Template 6', '8' => 'Template 7', '9' => 'Template 8'); //

                                    while (list($key, $val) = each($template)) {

                                    if ($key == $account_details['template']) {
                                         ?>
                                            <option value="<?php echo $key;  ?>" data-title="<?php echo $key; ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                             ?>
                                    <option data-title="<?php echo $key; ?>" value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label"><?php _e('Location', 'reachdrip-web-push-notifications'); ?></label>

                            <?php
                            $location = array('1' => 'Top Left', '2' => 'Top Right', '3' => 'Top Center', '4' => 'Bottom Left', '5' => 'Bottom Right', '6' => 'Bottom Center');
                            $location_2 = array('1' => 'Top Left', '2' => 'Top Right', '4' => 'Bottom Left', '5' => 'Bottom Right');
                            $location_3 = array('7' => 'Top', '8' => 'Bottom');
                            ?>

                            <input type="hidden" name="rd_template_location" id="rd_template_location" value="<?php if(isset($account_details['opt_in_location'])){ echo $account_details['opt_in_location']; } else { echo 1; } ?>">

                            <div class="col-sm-9" id="rd_list_1" style="display: <?php if($account_details['template'] < 7 ||  $account_details['template'] == 9 ||  $account_details['template'] == '1') { echo 'block'; } else { echo 'none'; }?>;">
                                <select class="form-control col-sm-12" id="location" name="location">

                                    <?php

                                    while (list($key, $val) = each($location)) {

                                        if ($key == $account_details['opt_in_location']) {
                                            ?>
                                            <option value="<?php echo $key;  ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-9" id="rd_list_2" style="display: <?php if($account_details['template'] == 7) { echo 'block'; } else { echo 'none'; }?>;">
                                <select class="selectpicker col-sm-12" id="location_1" name="location_1">

                                    <?php

                                    while (list($key, $val) = each($location_2)) {

                                        if ($key == $account_details['opt_in_location']) {
                                            ?>
                                            <option value="<?php echo $key;  ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-9" id="rd_list_3" style="display: <?php if($account_details['template'] == 8) { echo 'block'; } else { echo 'none'; }?>;">
                                <select class="selectpicker col-sm-12" id="location_2" name="location_2">

                                    <?php

                                    while (list($key, $val) = each($location_3)) {

                                        if ($key == $account_details['opt_in_location']) {
                                            ?>
                                            <option value="<?php echo $key;  ?>"
                                                    selected> <?php echo $val;  ?></option>
                                        <?php } else {
                                            ?>
                                            <option value="<?php echo $key; ?>"> <?php echo $val; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-group margin-b-0">
                            <label for="focusedinput"
                                   class="col-sm-2 control-label form-label"><?php _e('Site Logo', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <span class="btn btn-success fileinput-button margin-b-10">
                                    <span><?php _e('Site Logo', 'reachdrip-web-push-notifications'); ?></span>
                                    <input id="fileupload" type="file" name="reachdrip_setting_fileupload"/>
                                </span>
                                <br/>
                                <span><?php _e('Image size must be exactly 256x256px.', 'reachdrip-web-push-notifications'); ?> </span>
                            </div>
                        </div>

                        <hr>

                        <h5 class="col-sm-offset-2 title margin-t-0 margin-b-20"><?php _e('Notification Subscription Setting', 'reachdrip-web-push-notifications'); ?></h5>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Text', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_child_window_text"
                                       id="reachdrip_child_window_text" value="<?php echo stripslashes_deep($account_details['child_text']); ?>"
                                       placeholder="<?php _e('Opt-In Text', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="100" required>
                                <span
                                    class="float-r"><?php _e('Limit 100 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Title', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_child_window_title"
                                       id="reachdrip_child_window_title" value="<?php _e(stripslashes_deep($account_details['child_title']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Opt-In Title', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="45" required>
                                <span
                                    class="float-r"><?php _e('Limit 45 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Opt-In Message', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_child_window_message"
                                       id="reachdrip_child_window_message" value="<?php _e(stripslashes_deep($account_details['child_message']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Opt-In Message', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="73" required>
                                <span
                                    class="float-r"><?php _e('Limit 73 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <hr>

                        <h5 class="col-sm-offset-2 title margin-t-0 margin-b-20"><?php _e('Welcome Message for first time subscribers', 'reachdrip-web-push-notifications'); ?></h5>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Notification Title', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_setting_title"
                                       id="reachdrip_setting_title" value="<?php _e(stripslashes_deep($account_details['title']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Notification Title', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="45">
                                <span
                                    class="float-r"><?php _e('Limit 45 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Notification Message', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_setting_message"
                                       id="reachdrip_setting_message" value="<?php _e(stripslashes_deep($account_details['message']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Notification Message', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="73">
                                <span
                                    class="float-r"><?php _e('Limit 73 Characters', 'reachdrip-web-push-notifications'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('Redirect URL', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_redirect_url"
                                       id="reachdrip_redirect_url" value="<?php _e(stripslashes_deep($account_details['redirect_url']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('Redirect URL', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="250">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-default"
                                       value="<?php _e('Save Settings', 'reachdrip-web-push-notifications'); ?>"
                                       name="rd-advance-settings">
                            </div>
                        </div>

                    </form>

                    <hr>

                    <form class="form-horizontal" autocomplete="off" id="reachdrip_setting_form"
                          name="reachdrip_setting_form" enctype="multipart/form-data"
                          action="admin.php?page=reachdrip-setting" method="post">

                        <div class="form-group">
                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-10">
                                <label class="form-label">
                                    <strong><?php _e('Auto Send Push Notifications', 'reachdrip-web-push-notifications'); ?> </strong></<label
                                    class="form-label">
                                    <br/>
                                    <input type="checkbox" value="1" name="reachdrip_auto_push"
                                           id="reachdrip_auto_push" <?php checked(stripslashes_deep($reachdrip_settings['rdAutoPush']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('When a Post is Published', 'reachdrip-web-push-notifications'); ?> </label>
                                    <br/>
                                    <input type="checkbox" value="1" name="reachdrip_edit_post_push"
                                           id="reachdrip_edit_post_push" <?php checked(stripslashes_deep($reachdrip_settings['rdEditPostPush']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('When a Post is Updated', 'reachdrip-web-push-notifications'); ?> </label>
                                    <br/>
									<input type="checkbox" value="1" name="reachdrip_logo_image"
                                           id="reachdrip_logo_image" <?php checked(stripslashes_deep($reachdrip_settings['rdPostLogoImage']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Use Logo Image as Post Image', 'reachdrip-web-push-notifications'); ?> </label>
                                    <br/>
									<input type="checkbox" value="1" name="reachdrip_big_image"
                                           id="reachdrip_big_image" <?php checked(stripslashes_deep($reachdrip_settings['rdPostBigImage']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Use Large Image', 'reachdrip-web-push-notifications'); ?> </label>
                                    <br/>
									<input type="checkbox" value="1" name="reachdrip_js_restrict"
                                           id="reachdrip_js_restrict" <?php checked(stripslashes_deep($reachdrip_settings['rdJsRestrict']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Stop Automatic Script Inclusion. In That Case You Have to Manually Install our Script.', 'reachdrip-web-push-notifications'); ?> </label>
                                    <br/>
                                    <input type="checkbox" value="1" name="reachdrip_setting_is_utm_show"
                                           id="reachdrip_setting_is_utm_show" <?php checked(stripslashes_deep($reachdrip_settings['rdIsAutoPushUTM']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Auto Push UTM Parameters', 'reachdrip-web-push-notifications'); ?></label>

                            </div>

                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-9">
                                <span><?php _e('Notification Message When a Post is Published', 'reachdrip-web-push-notifications'); ?></span>
                                <input type="text" value="<?php echo stripslashes_deep($reachdrip_settings['rdPostMessage']); ?>" name="reachdrip_setting_post_message" placeholder="<?php _e('Notification Message When a Post is Published', 'reachdrip-web-push-notifications'); ?>" maxlength="138"
                                       id="reachdrip_setting_post_message" class="form-control margin-t-10 clearfix" required/>
                            </div>

                        </div>

                        <div class="form-group" id="reachdrip_setting_utm_parameter_div"
                             style="display: <?php if ($reachdrip_settings['rdIsAutoPushUTM']) {
                                 echo 'block';
                             } else {
                                 echo 'none';
                             } ?>;">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('UTM Source', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" id="reachdrip_setting_utm_source"
                                       name="reachdrip_setting_utm_source"
                                       value="<?php echo stripslashes_deep($reachdrip_settings['rdUTMSource']); ?>"
                                       placeholder="<?php _e('Enter UTM Source', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="45"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 45 Characters', 'reachdrip-web-push-notifications'); ?></p>
                            </div>

                            <label
                                class="col-sm-2 control-label form-label"><?php _e('UTM Medium', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" name="reachdrip_setting_utm_medium"
                                       id="reachdrip_setting_utm_medium"
                                       value="<?php echo stripslashes_deep($reachdrip_settings['rdUTMMedium']); ?>"
                                       placeholder="<?php _e('Enter UTM Medium', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="73"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 73 Characters', 'reachdrip-web-push-notifications'); ?></p>
                            </div>

                            <label
                                class="col-sm-2 control-label form-label"><?php _e('UTM Campaign', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9 margin-b-5">
                                <input type="text" class="form-control" name="reachdrip_setting_utm_campaign"
                                       id="reachdrip_setting_utm_campaign"
                                       value="<?php echo stripslashes_deep($reachdrip_settings['rdUTMCampaign']); ?>"
                                       placeholder="<?php _e('Enter UTM Campaign', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="500"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 500 Characters', 'reachdrip-web-push-notifications'); ?></p>
                            </div>
                        </div>
						
						<div class="form-group margin-b-0">
                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-10">
                                <label class="form-label">
                                    <strong><?php _e('Other Settings', 'reachdrip-web-push-notifications'); ?> </strong></<label
                                    class="form-label">
                                    <br/>

                                    <input type="checkbox" value="1" name="reachdrip_new_post_checked"
                                           id="reachdrip_new_post_checked" <?php checked(stripslashes_deep($reachdrip_settings['rdNewPostChecked']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Autocheck Notification for New Posts', 'reachdrip-web-push-notifications'); ?> </label>
                                    <br/>

                                    <input type="checkbox" value="1" name="reachdrip_update_post_checked"
                                           id="reachdrip_update_post_checked" <?php checked(stripslashes_deep($reachdrip_settings['rdUpdatePostChecked']), 1); ?>/>
                                    <label
                                        class="form-label checkbox_title margin-l-10 margin-t-5"> <?php _e('Autocheck Notification for Post Updates', 'reachdrip-web-push-notifications'); ?> </label>

                            </div>
                        </div>
						
						<div class="form-group margin-b-0">
                            <label class="col-sm-2 control-label form-label"></label>
                            <div class="col-sm-10">
                                <label class="form-label col-sm-8">
                                    <strong><?php _e('Don\'t Send Push Notification for following Post Types ', 'reachdrip-web-push-notifications'); ?> </strong></<label
                                    class="form-label">
                                    <select class="col-sm-12 form-control margin-t-10" id="reachdrip_post_types" name="reachdrip_post_types[]" multiple>
                                        <?php
										$rd_post_list = array();
										if(isset($reachdrip_settings['rdDisallowPostTypes'])){
											$rd_post_list = explode(",", $reachdrip_settings['rdDisallowPostTypes']);
										}
										
                                        foreach ( get_post_types( '', 'names' ) as $post_type ) {
											
											if(in_array($post_type, $rd_post_list)){
                                            ?>
                                            <option selected
                                                value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
                                            <?php
											} else {
											?>
												<option
                                                value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
											<?php	
											}
                                        }
                                        ?>
                                    </select>

                            </div>
                        </div>
						
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-default"
                                       value="<?php _e('Save Settings', 'reachdrip-web-push-notifications'); ?>"
                                       name="rd-save-settings">
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">

                    <p><strong><?php _e('What is a GCM Key? How do I get export my subscribers, What if I want to switch to other vendor.', 'reachdrip-web-push-notifications'); ?></strong></p>
                    <p class="margin-b-15 margin-t-15"><?php _e('At the time of installation, you have to provide your GCM (Google Cloud Messaging) API Key for Chrome and Certificate Details for Safari that is used.', 'reachdrip-web-push-notifications'); ?></p>
                    <p><?php _e('We need this information to export your subscriber’s ID’s. Please note that only premium accounts can export the subscribers.', 'reachdrip-web-push-notifications'); ?></p>
                    
                    <form class="form-horizontal margin-t-40" autocomplete="off" id="reachdrip_gcm_setting_form"
                          name="reachdrip_gcm_setting_form" enctype="multipart/form-data"
                          action="admin.php?page=reachdrip-setting" method="post">

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('GCM Project No.', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_gcm_project_no"
                                       id="reachdrip_gcm_project_no" value="<?php _e(stripslashes_deep($account_details['gcm_project_number']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('GCM Project No.', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="20" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label form-label"><?php _e('GCM API Key', 'reachdrip-web-push-notifications'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="reachdrip_gcm_api_key"
                                       id="reachdrip_gcm_api_key" value="<?php _e(stripslashes_deep($account_details['gcm_api_key']), 'reachdrip-web-push-notifications'); ?>"
                                       placeholder="<?php _e('GCM API Key', 'reachdrip-web-push-notifications'); ?>"
                                       maxlength="250" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-default"
                                       value="<?php _e('Save Settings', 'reachdrip-web-push-notifications'); ?>"
                                       name="rd-gcm-settings">
                            </div>
                        </div>

                    </form>

                    <hr>

                    <p><?php _e('Screenshot of advance configurations that are possible with your ReachDrip account.', 'reachdrip-web-push-notifications'); ?>
                        &nbsp;&nbsp;&nbsp;
                        <a href="https://<?php echo $account_details['account_name']; ?>.reachdrip.com/domains/site-setting/<?php echo $account_details['account_name']; ?>/"
                           class="btn btn-default margin-t-0"
                           target="_blank"><?php _e('Customize Now', 'reachdrip-web-push-notifications'); ?></a>
                    </p>
                    
                </div>
            </div>
        </div>

    </div>
    <!-- Container End -->
</div>
<!-- Content End -->
<script language="javascript">

    jQuery("#reachdrip_setting_is_utm_show").on('click', function () {

        if (jQuery('#reachdrip_setting_is_utm_show').is(':checked')) {

            jQuery('#reachdrip_setting_utm_parameter_div').show('slow');

        } else {

            jQuery('#reachdrip_setting_utm_parameter_div').hide('slow');

        }
    });

    jQuery("#template").on("change", function () {

        if(jQuery(this).val() == 8){

            jQuery('#rd_list_3').show();
            jQuery('#rd_list_2').hide();
            jQuery('#rd_list_1').hide();

            jQuery('#rd_template_location').val(jQuery('#location_2').val());

        }

        if(jQuery(this).val() == 7){

            jQuery('#rd_list_3').hide();
            jQuery('#rd_list_2').show();
            jQuery('#rd_list_1').hide();

            jQuery('#rd_template_location').val(jQuery('#location_1').val());

        }

        if(jQuery(this).val() < 7 || jQuery(this).val() == 9){

            jQuery('#rd_list_3').hide();
            jQuery('#rd_list_2').hide();
            jQuery('#rd_list_1').show();

            jQuery('#rd_template_location').val(jQuery('#location').val());
        }
    });

    jQuery("#location").on("change", function () {

        var template_location = jQuery(this).val();

        jQuery('#rd_template_location').val(template_location);
    });

    jQuery("#location_1").on("change", function () {

        var template_location = jQuery(this).val();

        jQuery('#rd_template_location').val(template_location);
    });

    jQuery("#location_2").on("change", function () {

        var template_location = jQuery(this).val();

        jQuery('#rd_template_location').val(template_location);
    });

</script>