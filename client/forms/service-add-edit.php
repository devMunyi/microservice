<?php
    $user_details = session_details();
    if($user_details == null){
        echo "<meta http-equiv=\"refresh\" content= \"0, URL=login\" />";
        die("Your session is invalid");
        // exit(json_encode(array("success" => false, "message" => "Your session is invalid. Please re-login")));
    }
?>

<div class="content-header pb-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>
                    <?php
                    $service_id = $_GET['service-add-edit'];
                    if ($service_id > 0) {
                        $service_id = $_GET['service-add-edit'];
                        $service = fetchonerow('tbl_services', "id='" . $service_id . "'", "id, company_id, service_title, service_address, next_run_datetime, unit, frequency, repeated, is_executed");
                        $act = "<span class='text-orange'><i class='fa fa-edit'></i>Edit</span>";
                        echo "Service <small class='xsm'>Edit</small> <span class='text-green text-bold sm'>address</span> <a title='View details' class='font-16' href=\"services?service=$service_id\"><i class='fa fa-arrow-circle-up'></i></a>";
                    } else {
                        $service = array();
                        $service_id = "";
                        $act = "<span class='text-green'><i class='fa fa-edit'></i>Add</span>";
                        echo "Service <small class='xsm text-muted'>Add</small>";
                    }
                    ?>
                </h3>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index" class="aco">Home</a></li>
                    <li class="breadcrumb-item active">Service</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <!-- /.box -->

            <div class="card mr-3 ml-3 pb-5 pt-5" style="border-top: 4px solid silver;">

                <!-- /.box-header -->
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 justify-content-center align-items-center">
                        <div id="feedback">

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">

                            </div>
                            <div class="col-sm-9">
                                <h3 class="pb-2"><?php echo $act; ?> Service Details</h3>
                            </div>
                        </div>
                        <form onsubmit="return false;" class="form-horizontal" method="post">
                            <div class="box-body">
                            <div class="form-group row">
                                    <label for="Company" class="col-sm-3 control-label pr-0">Company Name</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="company_id">
                                            <option value="0">--Select One</option>
                                            <?php
                                            $recs = fetchtable('tbl_companies', "status > 0", "id", "asc", "25", "id ,name");
                                            while ($r = mysqli_fetch_array($recs)) {
                                                $id = $r['id'];
                                                $company = $r['name'];
                                                if ($id ==  $service['company_id']) {
                                                    $g_selected = 'SELECTED';
                                                } else {
                                                    $g_selected = "";
                                                }
                                                echo "<option $g_selected value=\"$id\">$company</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 control-label pr-0">Service Title</label>

                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="service_title" id="service_title" value="<?php echo $service['service_title']; ?> ">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 control-label pr-0">Service Address</label>

                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="service_address" id="service_address" value="<?php echo $service['service_address']; ?> ">
                                    </div>
                                </div>
                                
                                <?php if ($service_id > 0) { ?>
                                    <div class="form-group row">
                                        <label for="is_executed" class="col-sm-3 control-label pr-0">Is Executed</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="is_executed">
                                                <option value="0">--Select One</option>
                                                <?php
                                                $recs = array("Yes", "No");
                                                $count = count($recs);

                                                $i = 0;
                                                while($i < $count) {                                                                                
                                                    $value = $recs[$i];

                                                    if ($value == $service['is_executed']) {
                                                        
                                                        $s_selected = 'SELECTED';
                                                    } else {
                                                        $s_selected = "";
                                                    }
                                                    echo "<option $s_selected value=\"$value\">$value</option>";

                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group row">
                                    <label for="next_run" class="col-sm-3 control-label pr-0">Next Run</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                            <input id="next_run" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" value="<?php echo $service['next_run_datetime'] ?>" />
                                            <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="unit" class="col-sm-3 control-label pr-0">Unit</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="unit">
                                            <option value="0">--Select One</option>
                                            <?php
                                            $recs = fetchtable('tbl_units', "id > 0 AND status > 0", "id", "asc", "10", "id ,name");
                                            while ($r = mysqli_fetch_array($recs)) {
                                                $id = $r['id'];
                                                $name = $r['name'];
                                                if ($id ==  $service['unit']) {
                                                    $g_selected = 'SELECTED';
                                                } else {
                                                    $g_selected = "";
                                                }
                                                echo "<option $g_selected value=\"$id\">$name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="frequency" class="col-sm-3 control-label pr-0">Frequency</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="frequency">
                                            <option value="0">--Select One</option>
                                            <?php
                                            $recs = fetchtable('tbl_frequencies', "status > 0", "id", "asc", "62", "id ,value");
                                            while ($r = mysqli_fetch_array($recs)) {
                                                $id = $r['id'];
                                                $frequency = $r['value'];
                                                if ($frequency ==  $service['frequency']) {
                                                    $g_selected = 'SELECTED';
                                                } else {
                                                    $g_selected = "";
                                                }
                                                echo "<option $g_selected value=\"$id\">$frequency</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="repeated" class="col-sm-3 control-label pr-0">Repeated</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="repeated">
                                            <option value="0">--Select One</option>
                                            <?php
                                            $recs = array("Yes", "No");
                                            $count = count($recs);

                                            $i = 0;
                                            while($i < $count) {                                                                                
                                                $value = $recs[$i];

                                                if ($value == $service['repeated']) {
                                                    
                                                    $s_selected = 'SELECTED';
                                                } else {
                                                    $s_selected = "";
                                                }
                                                echo "<option $s_selected value=\"$value\">$value</option>";

                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <div class="submitbtn box-footer d-flex flex-start">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <div class="col-sm-2 box-body">
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>
<input type="hidden" name="" id="service_edit_id" value="<?php echo $service_id; ?>">