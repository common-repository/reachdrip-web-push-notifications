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
        <h1 class="title"><?php _e('New Notification', 'reachdrip-web-push-notifications');?></h1>
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
                    <form class="form-horizontal" autocomplete="off" id="send_notification_form"
                          name="send_notification_form" enctype="multipart/form-data"
                          action="admin.php?page=reachdrip-new-notification" method="post">

                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Notification Title', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="reachdrip_notification_title" name="reachdrip_notification_title"
                                       placeholder="<?php _e('Notification Title', 'reachdrip-web-push-notifications');?>" maxlength="77" required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 77 Characters', 'reachdrip-web-push-notifications');?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Notification Message', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="2" name="reachdrip_notification_message" id="reachdrip_notification_message"
                                          placeholder="<?php _e('Notification Message', 'reachdrip-web-push-notifications');?>" maxlength="138" required="required"
                                          style="resize: none"></textarea>
                                <p class="margin-b-0 align-right"><?php _e('Limit 138 Characters', 'reachdrip-web-push-notifications');?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Notification URL', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9">
                                <input type="url" class="form-control" id="reachdrip_notification_url" name="reachdrip_notification_url"
                                       placeholder="<?php _e('Enter a URL to push your subscribers to (yoursite.com)', 'reachdrip-web-push-notifications');?>"
                                       maxlength="250"/>
                            </div>
                        </div>

                        <div class="form-group margin-b-0">
                            <label for="focusedinput" class="col-sm-3 control-label form-label"><?php _e('Notification Logo', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9">
                                <span class="btn btn-success fileinput-button margin-b-10">
                                    <span><?php _e('Notification Logo', 'reachdrip-web-push-notifications');?></span>
                                    <input id="fileupload" type="file" name="reachdrip_notification_fileupload"/>
                                </span>
                                <span class="clearfix"><?php _e('Image size must be exactly 256x256px.', 'reachdrip-web-push-notifications');?></span>
                            </div>
                        </div>
						<div class="form-group margin-b-0">
                            <label class="col-sm-offset-3 control-label form-label">
                                <input type="checkbox" value="1" name="reachdrip_is_big_image" id="reachdrip_is_big_image"/>
                                <label class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Use Large Image', 'reachdrip-web-push-notifications');?></label>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-offset-3 control-label form-label">
                                <input type="checkbox" value="0" name="reachdrip_notification_is_utm_show" id="reachdrip_notification_is_utm_show"/>
                                <label class="form-label checkbox_title margin-l-10 margin-t-10"><?php _e('Add UTM Parameters', 'reachdrip-web-push-notifications');?></label>
                            </label>
                        </div>
                        <div class="form-group" id="reachdrip_notification_utm_parameter_div" style="display: none;">
                            <label class="col-sm-3 control-label form-label"><?php _e('UTM Source', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" id="reachdrip_notification_utm_source" name="reachdrip_notification_utm_source"
                                       value="reachdrip" placeholder="<?php _e('Enter UTM Source', 'reachdrip-web-push-notifications');?>" maxlength="45"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 45 Characters', 'reachdrip-web-push-notifications');?></p>
                            </div>

                            <label class="col-sm-3 control-label form-label"><?php _e('UTM Medium', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9 margin-b-15">
                                <input type="text" class="form-control" name="reachdrip_notification_utm_medium" id="reachdrip_notification_utm_medium"
                                       value="reachdrip_notification" placeholder="<?php _e('Enter UTM Medium', 'reachdrip-web-push-notifications');?>" maxlength="73"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 73 Characters', 'reachdrip-web-push-notifications');?></p>
                            </div>

                            <label class="col-sm-3 control-label form-label"><?php _e('UTM Campaign', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9 margin-b-5">
                                <input type="text" class="form-control" name="reachdrip_notification_utm_campaign" id="reachdrip_notification_utm_campaign"
                                       value="reachdrip" placeholder="<?php _e('Enter UTM Campaign', 'reachdrip-web-push-notifications');?>" maxlength="500"
                                       required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 500 Characters', 'reachdrip-web-push-notifications');?></p>
                            </div>
                        </div>

                        <?php if (count($segment_list) > 0) { ?>

                            <div class="form-group">
                                <label class="col-sm-3 control-label form-label"><?php _e('Segment', 'reachdrip-web-push-notifications');?></label>
                                <div class="col-sm-9">
                                    <select class="col-sm-12 form-control" id="reachdrip_notification_segment" name="reachdrip_notification_segment[]"
                                            multiple>
                                        <?php
                                        foreach ($segment_list as $row) {
                                            ?>
                                            <option
                                                value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-1">
                                <input type="submit" class="btn btn-default" value="<?php _e('Send', 'reachdrip-web-push-notifications');?>">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 dummy-notification shadow panel panel-default">
            <p class="h4 pb15"><?php _e('Preview', 'reachdrip-web-push-notifications');?></p>

            <div class="widget shadow dummy-notification-inner-wrapper">
                <div class="wrapper">

                    <div class="img_wrapper pull-left">
                        <img id="reachdrip_preview_logo" src="<?php echo $account_details['site_image'];?>"
                             class="img-responsive">
                    </div>

                    <div class="text_wrapper pull-left">
                        <div class="title">
                            <div class="title_txt pull-left" id="reachdrip_preview_notification_title">
                                <?php _e('Notification Title', 'reachdrip-web-push-notifications');?>
                            </div>
                            <div class="closer pull-right">
                                x
                            </div>
                        </div>
                        <div class="message" id="reachdrip_preview_notification_message">
                            <?php _e('Notification Message', 'reachdrip-web-push-notifications');?>
                        </div>

                        <div class="domain">
                            <div class="domain">
                                <?php echo $account_details['account_name'];?><?php _e('.reachdrip.com', 'reachdrip-web-push-notifications');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="redirect_url">
                <p id="reachdrip_notification_redirect_url" class="h5"><?php _e('URL to open when user clicks the notification:', 'reachdrip-web-push-notifications');?></p>
            </div>
        </div>

    </div>
    <!-- Container End -->
</div>
<!-- Content End -->

<script language="javascript">

    var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val(), url = "", title = "", message = "";

    jQuery("#reachdrip_notification_is_utm_show").on('click', function () {

        if (jQuery('#reachdrip_notification_is_utm_show').is(':checked')) {

            jQuery('#reachdrip_notification_is_utm_show').val(1);

            jQuery('#reachdrip_notification_utm_parameter_div').show('slow');

            if (url == "") {

                jQuery('#reachdrip_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'reachdrip-web-push-notifications');?>');
            } else {

                jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
            }

        } else {

            jQuery('#reachdrip_notification_is_utm_show').val(0);

            jQuery('#reachdrip_notification_utm_parameter_div').hide('slow');

            if (url == "") {

                jQuery('#reachdrip_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'reachdrip-web-push-notifications');?>');
            } else {

                jQuery('#reachdrip_notification_redirect_url').text(url);
            }
        }
    });

    jQuery("#reachdrip_notification_title").keyup(function () {

        title = jQuery('#reachdrip_notification_title').val();

        if (title != "") {

            jQuery('#reachdrip_preview_notification_title').text(title);
        }
        else {
            jQuery('#reachdrip_preview_notification_title').text('<?php _e('Notification Title', 'reachdrip-web-push-notifications');?>');
        }
    });

    jQuery("#reachdrip_notification_message").keyup(function () {

        message = jQuery('#reachdrip_notification_message').val();

        if (message != "") {

            jQuery('#reachdrip_preview_notification_message').text(message);
        }
        else {

            jQuery('#reachdrip_preview_notification_message').text('<?php _e('Notification Message', 'reachdrip-web-push-notifications');?>');
        }
    });

    jQuery('#reachdrip_notification_utm_source').keyup(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        if(url !== '') {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#reachdrip_notification_utm_source').blur(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        if(url !== '') {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#reachdrip_notification_utm_medium').keyup(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        if(url !== '') {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#reachdrip_notification_utm_medium').blur(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        if(url !== '') {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#reachdrip_notification_utm_campaign').keyup(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        if(url !== '') {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery('#reachdrip_notification_utm_campaign').blur(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        if(url !== '') {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
    });

    jQuery("#reachdrip_notification_title").blur(function () {

        title = jQuery('#reachdrip_notification_title').val();

        if (title != "") {

            jQuery('#reachdrip_preview_notification_title').text(title);
        }
        else {
            jQuery('#reachdrip_preview_notification_title').text('<?php _e('Notification Title', 'reachdrip-web-push-notifications');?>');
        }
    });

    jQuery("#reachdrip_notification_message").blur(function () {

        message = jQuery('#reachdrip_notification_message').val();

        if (message != "") {

            jQuery('#reachdrip_preview_notification_message').text(message);
        }
        else {

            jQuery('#reachdrip_preview_notification_message').text('<?php _e('Notification Message', 'reachdrip-web-push-notifications');?>');
        }
    });

    jQuery('#reachdrip_notification_url').keyup(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        var url = jQuery('#reachdrip_notification_url').val();

        is_utm_show = jQuery('#reachdrip_notification_is_utm_show').val();

        if (url != "" && is_utm_show == 0) {

            jQuery('#reachdrip_notification_redirect_url').text(url);

        } else if (url != "" && is_utm_show == 1) {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
        else {
            jQuery('#reachdrip_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'reachdrip-web-push-notifications');?>');
        }
    });

    jQuery("#reachdrip_notification_url").blur(function () {

        var  utm_source = jQuery('#reachdrip_notification_utm_source').val(), utm_medium = jQuery('#reachdrip_notification_utm_medium').val(), utm_campaign = jQuery('#reachdrip_notification_utm_campaign').val();

        url = jQuery('#reachdrip_notification_url').val();

        is_utm_show = jQuery('#reachdrip_notification_is_utm_show').val();

        if (url != "" && is_utm_show == 0) {

            jQuery('#reachdrip_notification_redirect_url').text(url);

        } else if (url != "" && is_utm_show == 1) {

            jQuery('#reachdrip_notification_redirect_url').text(url + "?utm_source=" + utm_source + "&utm_medium=" + utm_medium + "&utm_campaign=" + utm_campaign);
        }
        else {
            jQuery('#reachdrip_notification_redirect_url').text('<?php _e('URL to open when user clicks the notification:', 'reachdrip-web-push-notifications');?>');
        }
    });

</script>