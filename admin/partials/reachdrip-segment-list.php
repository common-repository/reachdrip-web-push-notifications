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
        <h1 class="title"><?php _e('Segment Details', 'reachdrip-web-push-notifications');?></h1>
        <div class="sub_count">
            <a href="admin.php?page=reachdrip-create-segments"><?php _e('Add New Segment', 'reachdrip-web-push-notifications');?></a>
        </div>
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
                            <td><?php _e('Segment Name', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Subscribers Count', 'reachdrip-web-push-notifications');?></td>
                            <td><?php _e('Created Date', 'reachdrip-web-push-notifications');?></td>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (count($segment_list) > 0) {

                            $no =  1;

                            foreach ($segment_list as $row) {
                                ?>

                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['subscriber_count']; ?></td>
                                    <td><?php echo date('M d, Y ', strtotime($row['created_at'])); ?></td>
                                </tr>
                            <?php
                                $no++;
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                <?php
                                if($segment_list['error'] != ''){

                                    echo $segment_list['error'];
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