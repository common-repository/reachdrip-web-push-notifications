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
<div id="reachdrip" class="content clearfix">
    <!-- Start Page Header -->

    <div class="page-header">
        <h1 class="title"><?php _e('Create Segment', 'reachdrip-web-push-notifications');?></h1>
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
                    <form class="form-horizontal" autocomplete="off" id="segment_form"
                          name="segment_form" action="admin.php?page=reachdrip-create-segments" method="post">

                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"><?php _e('Segment Name', 'reachdrip-web-push-notifications');?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="reachdrip_segment_name"
                                       name="reachdrip_segment_name"
                                       placeholder="<?php _e('Segment Name', 'reachdrip-web-push-notifications');?>" maxlength="40" required="required"/>
                                <p class="margin-b-0 align-right"><?php _e('Limit 40 Characters. E.g. Google', 'reachdrip-web-push-notifications');?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label form-label"></label>
                            <div class="">
                                <input type="submit" class="margin-l-5 btn btn-default" value="<?php _e('Create Segment', 'reachdrip-web-push-notifications');?>">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 dummy-notification shadow panel panel-default">

            <p class="h5 pb15"><strong><?php _e('How to Implement Segments for your Push Notification Subscribers', 'reachdrip-web-push-notifications');?></strong></p>

            <div class="widget shadow dummy-notification-inner-wrapper pb15">
                <p><strong><?php _e('Step 1 ', 'reachdrip-web-push-notifications');?> : </strong> <?php _e('Create a new segment. Go to Create Segments', 'reachdrip-web-push-notifications');?></p>

                <p><strong><?php _e('Step 2', 'reachdrip-web-push-notifications');?> :</strong> <?php _e('Copy the following JavaScript code and paste it on your site page(s).', 'reachdrip-web-push-notifications');?> </p>

                <p class="margin-t-20"><strong> <?php _e('Subscribe for Single Segment', 'reachdrip-web-push-notifications');?> </strong></p>
                <p>
                    &lt;script&gt;
                    <br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; var _rd = [];<br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; _rd.push('segmentname');
                    <br/>
                    &lt;/script&gt;
                </p>

                <p class="margin-t-20"><strong><?php _e('Subscribe for Multiple Segments', 'reachdrip-web-push-notifications');?></strong></p>
                <p>
                    &lt;script&gt;
                    <br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; var _rd = [];<br/>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; _rd.push('segmentname1', 'segmentname2');
                    <br/>
                    &lt;/script&gt;
                </p>
            </div>
        </div>
    </div>
</div>
