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
        <h1 class="title"><?php _e('Create Account', 'reachdrip-web-push-notifications');?></h1>
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

            <h4><?php _e('Create an Account', 'reachdrip-web-push-notifications');?></h4>

            <div class="panel panel-default">
                <div class="panel-body">

                    <form name="registration_form" id="registration_form" class="space-top"
                          action="admin.php?page=reachdrip-create-account"
                          method="post">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control" name="reachdrip_name" id="reachdrip_name"
                                       placeholder="<?php _e('Full Name', 'reachdrip-web-push-notifications');?>" type="text" maxlength="100"
                                       required="required">								
                            </div>
                        </div>

                        <input type="hidden" name="reachdrip_api_form" id="reachdrip_api_form" value="reachdrip_account_creation">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control" name="reachdrip_company_name" id="reachdrip_company_name"
                                       placeholder="<?php _e('Company Name', 'reachdrip-web-push-notifications');?>" type="text" maxlength="200">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group" id="result">
                                <input class="form-control" name="reachdrip_contact" id="reachdrip_contact" type="tel">
							   <input type="hidden" name="hidden_rd_error_msg" id="hidden_rd_error_msg" value="0">							   
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control" name="reachdrip_email" id="reachdrip_email" placeholder="<?php _e('Email', 'reachdrip-web-push-notifications');?>"
                                       type="email" maxlength="150" required="required">
                            </div>
                        </div>
                        <div class="col-sm-12 margin-b-20">
                            <div class="form-group">
                                <input class="cont_form_password col-sm-12" name="reachdrip_password" id="reachdrip_password"
                                       placeholder="<?php _e('Password', 'reachdrip-web-push-notifications');?>" type="password" maxlength="50"
                                       required="required">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <select name="reachdrip_protocol" id="reachdrip_protocol" class="selectpicker dropdown-toggle" required>
                                <option value="http://"><?php _e('http://', 'reachdrip-web-push-notifications');?></option>
                                <option value="https://"><?php _e('https://', 'reachdrip-web-push-notifications');?></option>
                            </select>
                        </div>
                        <div class="col-sm-10 margin-b-20">
                            <input class="form-control" name="reachdrip_site_url" id="reachdrip_site_url"
                                   placeholder="<?php _e('Site Url', 'reachdrip-web-push-notifications');?>" type="text" maxlength="200"
                                   required="required">
                        </div>

                        <span class="subdomain_protocol bg-color">
							https://
						</span>
                        <div class="col-sm-9 subdomain-title tooltip">
                            <input class="form-control text-r" name="reachdrip_sub_domain" id="reachdrip_sub_domain"
                                   placeholder="<?php _e('Your domain, brand, sitename', 'reachdrip-web-push-notifications');?>" type="text" maxlength="80"
                                   required="required">
							<span class="tooltip__text">Browsers permit subscriptions on https sites only. We require a SSL subdomain to manage subscriptions and deliver push notifications. This subdomain is displayed in the notification you deliver and from where you gather subscription data. It can only contain a-z, 0-9 characters. Doesn't apply for SSL sites.</span>
                        </div>
                        <div class="form-group col-sm-3 subdomain bg-color">
                            <?php _e('.reachdrip.com', 'reachdrip-web-push-notifications');?>
                        </div>

                        <input type="submit" class="btn btn-ghost btn-default margin-b-20 margin-t-20 margin-l-5"
                               value="<?php _e('Create Account', 'reachdrip-web-push-notifications');?>">
                        <!-- Validation Response -->
                        <div class="response-holder"></div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">

            <h4><?php _e('Provide API Key And Secret Key.', 'reachdrip-web-push-notifications');?></h4>

            <div class="panel panel-default">
                <div class="panel-body">

                    <form name="key_form" id="key_form" class="space-top"
                          action="admin.php?page=reachdrip-create-account"
                          method="post">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control" name="reachdrip_api_key" id="reachdrip_api_key"
                                       placeholder="<?php _e('API Key', 'reachdrip-web-push-notifications');?>" type="text" maxlength="250"
                                       required="required">
                            </div>
                        </div>

                        <input type="hidden" name="reachdrip_api_form" id="reachdrip_api_form" value="reachdrip_appKey">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control" name="reachdrip_secret_key" id="reachdrip_secret_key"
                                       placeholder="<?php _e('Secret Key', 'reachdrip-web-push-notifications');?>" type="text" maxlength="250">
                            </div>
                        </div>

                        <input type="submit" class="btn btn-ghost btn-default margin-b-20 margin-t-20 margin-l-5" value="<?php _e('Submit', 'reachdrip-web-push-notifications');?>">
                        <!-- Validation Response -->
                        <div class="response-holder"></div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-6">

            <h4><?php _e('How to get API Keys', 'reachdrip-web-push-notifications');?></h4>

            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        <?php _e("If you are an existing user of ReachDrip you can find your api keys under your ReachDrip control panel. To get your API and Secret Keys login to your", 'reachdrip-web-push-notifications');?>
                        <strong><?php _e('ReachDrip Admin Control Panel', 'reachdrip-web-push-notifications');?></strong> <?php _e('and click', 'reachdrip-web-push-notifications');?>
                        <strong><?php _e('Sites', 'reachdrip-web-push-notifications');?></strong>
                        <?php _e(". Copy the API Key and Secret Keys from your control Panel and paste above. Your account login details were sent to you at the time of signup. In case you have missed your account credentials please send us an email at", 'reachdrip-web-push-notifications');?>
                        <a href='mailto:support@reachdrip.com'><?php _e("support@reachdrip.com", 'reachdrip-web-push-notifications');?> </a>
                        <?php _e("containing your site url and we will send you your account credentials.", 'reachdrip-web-push-notifications');?>
                    </p>
                    <p> <?php _e('Please do not share your API and Secret keys with anyone.', 'reachdrip-web-push-notifications');?> </p>
                </div>
            </div>
        </div>

    </div>
</div>