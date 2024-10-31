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
<div id="reachdrip" class="content dashboard clearfix">
    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title"><?php _e('Subscribers Stats', 'reachdrip-web-push-notifications');?></h1>
    </div>
    <!-- End Page Header -->

    <!-- Container Start -->
    <div class="container-widget clearfix">

        <!-- Project Stats Start -->
        <div class="col-md-12 col-lg-12">
            <div class="panel panel-widget">

                <div class="panel-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td><?php _e('Site Url', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Chrome', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Firefox', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Safari', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Total', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Active Subscribers', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Unsubscribed', 'reachdrip-web-push-notifications');?></td>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (count($subscriber_details) > 0) {

                            $no =  1;

                            foreach ($subscriber_details as $row) {
                                ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['siteurl'];?></td>
                                    <td><?php echo number_format($row['Chrome']);?></td>
                                    <td><?php echo number_format($row['Firefox']);?></td>
                                    <td><?php echo number_format($row['Safari']);?></td>
                                    <td><?php echo number_format($row['total']);?></td>
                                    <td><?php echo number_format($row['active']);?></td>
                                    <td><?php echo number_format($row['unsubscribed']);?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                <?php
                                if($subscriber_details['error'] != ''){

                                    echo $subscriber_details['error'];
                                } else { ?>
                                    <?php _e('No record found.', 'reachdrip-web-push-notifications');?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Project Stats End -->
    </div>
    <!-- Container End -->

</div>
<!-- Content End -->