<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php include viewPath('includes/header'); ?>

<script type="text/javascript" src="<?php echo $url->assets ?>js/pages/dashboard.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/plugins/visualization/echarts/echarts.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/charts/echarts/bars_tornados.js"></script>
<script type="text/javascript" src="<?php echo $url->assets ?>js/charts/echarts/pies_donuts.js"></script>
<?php 
$hour = date('G');

if ( $hour >= 5 && $hour <= 11 ) {
    $msg = "Good Morning";
} else if ( $hour >= 12 && $hour <= 18 ) {
    $msg =  "Good Afternoon";
} else if ( $hour >= 19 || $hour <= 4 ) {
    $msg =  "Good Evening";
}
?>
<!-- <div class="alert alert-success alert-bordered">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    <span class="text-semibold"><?php echo $msg; ?>!</span> We're glad to <a href="#" class="alert-link">see you
        again</a> and wish
    you a nice day.
</div> -->

<!-- Main charts -->
<!-- <div class="alert alert-danger alert-bordered">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    <span class="text-semibold">Alert!</span> Graphs below may display dummy data for demo purposes.
</div> -->

<!-- Dashboard content -->
<div class="row">
    <div class="col-lg-12">

        <!-- Marketing campaigns -->

        <!-- /marketing campaigns -->


        <!-- Quick stats boxes -->
        <div class="row top_counts" >
            <div class="col-lg-3">

                <!-- Members online -->
                <div class="panel bg-teal-400">
                    <div class="panel-body">
                        <div class="heading-elements">

                            <?php 
                        if(empty($subscribers_today_count)){
                            $subscribers_today_count = 0;
                        }
                        // percentage calculator
                        $old_subs = $subscribers_count - $subscribers_today_count;
                        if($subscribers_count>0){
                            $subsc_percent_increase = ($subscribers_today_count / $old_subs) * 100;
                        }else{
                            $subsc_percent_increase = 0;
                        }
                        ?>
                            <span
                                class="heading-text badge bg-teal-800">+<?php echo round($subsc_percent_increase, 2); ?>%</span>
                        </div>

                        <h3 class="no-margin">+<?php echo $subscribers_today_count; ?></h3>
                        New Subscribers Today

                        <!-- <div class="text-muted text-size-small">489 avg</div> -->
                    </div>

                    <div class="container-fluid">
                        <div id="members-online"></div>
                    </div>
                </div>
                <!-- /members online -->

            </div>


            <div class="col-lg-3">

                <!-- Current server data -->
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <?php 
                        
                        if(empty($subscribers_returning_today_count)){
                            $subscribers_returning_today_count = 0;
                        }
                        // percentage calculator
                        $old_subs_returning = $subscribers_count - $subscribers_today_count;
                        if($subscribers_count>0){
                            $subsc_percent_returned = ($subscribers_returning_today_count / $subscribers_count) * 100;
                        }else{
                            $subsc_percent_returned = 0;
                        }
                        ?>
                            <span
                                class="heading-text badge bg-pink-800"><?php echo round($subsc_percent_returned, 2); ?>%</span>
                        </div>

                        <h3 class="no-margin"><?php echo $subscribers_returning_today_count; ?></h3>
                        Returning subscribers today
                        <!-- <div class="text-muted text-size-small">34.6% avg</div> -->
                    </div>

                    <!-- <div id="server-load"></div> -->
                </div>
                <!-- /current server load -->

            </div>

            <div class="col-lg-3">

                <!-- Current server load -->
                <div class="panel bg-violet-400">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <?php 
                        if(empty($subscribers_returning_yesterday_count)){
                            $subscribers_returning_yesterday_count = 0;
                        }
                        // percentage calculator
                        
                        ?>
                            <span class="heading-text badge bg-violet-800">New + Returning</span>
                        </div>

                        <h3 class="no-margin"><?php echo $subscribers_new_yesterday_count; ?> +
                            <?php echo $subscribers_returning_yesterday_count; ?></h3>
                        Yesterday's subscribers
                        <!-- <div class="text-muted text-size-small">34.6% avg</div> -->
                    </div>

                    <!-- <div id="server-load"></div> -->
                </div>
                <!-- /current server load -->

            </div>

            <div class="col-lg-3">

                <!-- Today's revenue -->
                <div class="panel bg-blue-600">
                    <div class="panel-body">
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <!-- <li><a data-action="reload"></a></li> -->
                            </ul>
                        </div>

                        <h3 class="no-margin"><?php echo $subscribers_count; ?></h3>
                        Total Subscribers
                        <!-- <div class="text-muted text-size-small">$37,578 avg</div> -->
                    </div>

                    <!-- <div id="today-revenue"></div> -->
                </div>
                <!-- /today's revenue -->

            </div>
        </div>
        <!-- /quick stats boxes -->
    </div>


</div>
<div class="row">
    <div class="col-lg-6">

        <!-- Locations stats -->
        <div class="panel panel-flat">
            <div class="panel-heading" style="margin-bottom:20px;">
                <h6 class="panel-title">Locations stats <span style="font-size:11px;">(updates every 2 hours)</span>
                </h6>
                <div class="heading-elements">

                </div>
            </div>
            <div class="container-fluid">
                <div class="position-relative has-fixed-height " id="traffic-sources"></div>
            </div>

        </div>
        <!-- /Locations stats -->

    </div>

    <div class="col-lg-6">
        <!-- new vs returning chart -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">&nbsp;</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="hidden"  id="new_subs"><?php echo json_encode($all_new_subs);?></div>
                <div class="hidden"  id="returning_sub"><?php echo json_encode($all_returning_subs);?></div>
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="new_vs_returning"></div>
                </div>
            </div>
        </div>
        <!-- /new vs returning chart -->
    </div>
</div>
<!-- /main charts -->
<div class="row">
    <div class="col-lg-6">
        <!-- Basic bar chart -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Top returning subscribers</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <!-- <li><a data-action="reload"></a></li> -->
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <?php //print_r($top_returning);?>
                <div class="hidden" id="top_returning_data">
                    <?php 
                    echo json_encode($top_returning);
                    ?>
                </div>
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="basic_bars"></div>
                </div>
            </div>
        </div>
        <!-- /basic bar chart -->
    </div>
    <div class="col-lg-6">
        <!-- Infographic style -->
        <div class="panel panel-flat overflow-hidden">
            <div class="panel-heading">
                <h5 class="panel-title">&nbsp;</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <!-- <li><a data-action="reload"></a></li> -->
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="business_data hidden">
                    <div id="ap_data">
                        <?php
                        echo json_encode($access_points);
                        ?>
                    </div>
                    <div id="subs_total"><?php
                    $subscribers_count_per = ($subscribers_count/20000)*100;
                    echo json_encode(round($subscribers_count_per, 2)); ?></div>
                    <div id="remaining_sub"><?php echo json_encode(round(100-$subscribers_count_per, 2))?></div>
                    <div id="allowed_locations"><?php echo json_encode($locations_check)?></div>
                </div>
                <div class="chart-container has-minimum-width">
                    <!-- <div class="chart has-fixed-height" id="infographic_donut"></div> -->
                    <div class="chart has-fixed-height has-minimum-width" id="multiple_donuts"></div>
                </div>
            </div>
        </div>
        <!-- /infographic style -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">Recent subscribers</h5>
            </div>
            <div class="panel-body"> List of last 5 subscribers for your business
                <code>This includes all of your locations in case of multiple</code>
            </div>
            <div class="table-responsive">
                <table class="table table-xs">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Registered on</th>
                            <th>Login count</th>
                            <th>Last Visited</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                    if(isset($subscribers_list)){
                                        foreach ($subscribers_list as $row):
                                            
                                        ?>
                        <tr>
                            <td>
                                <?php echo $row->id ?>
                            </td>
                            <td>
                                <?php echo $row->name ?>
                            </td>
                            <td>
                                <?php echo $row->phone ?>
                            </td>
                            <td>
                                <?php echo $row->email ?>
                            </td>


                            <td>
                                <?php echo $row->registered_on ?>
                            </td>
                            <td>
                                <?php echo $row->login_count ?>
                            </td>
                            <td>
                                <?php 
                                  echo $row->last_login_time;            
                                                ?>
                            </td>

                        </tr>
                        <?php 
                            endforeach;
                            }else{ 
                            ?>
                        <tr class="text-center">
                            <td colspan="7">No records found</td>
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>
                <?php if(isset($subscribers_list)){ ?>
                <div class="datatable-footer">
                    <div class="dataTables_paginate paging_simple_numbers"><a
                            href="<?php echo url('panel/reports') ?>"><button type="button"
                                class="btn bg-teal-400 btn-labeled"><b><i class="icon-stats-growth"></i></b>
                                View all</button></a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include viewPath('includes/footer'); ?>