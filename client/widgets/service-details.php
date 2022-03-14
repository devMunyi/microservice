<div class="content-header">
    <?php
    $service_ = $_GET['service'];
    ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>
                    Service
                    &nbsp;<small><span class="service_name sm"><i>Loading...</i></span></small>
                </h3>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index" class="aco text-muted">Home</a></li>
                    <li class="breadcrumb-item">Service</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card mr-3 ml-3">
                <!-- Nav tabs -->
                <nav>
                    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                        <a class="nav-link active aco" id="nav-details-tab" data-toggle="tab" href="#nav-details" role="tab" aria-controls="nav-details" aria-selected="true"><i class="fa fa-info"></i>&nbsp;Information</a>
                        <a class="nav-link aco" id="nav-logs-tab" data-toggle="tab" href="#nav-logs" role="tab" aria-controls="nav-logs" aria-selected="false"><i class="fa fa-clock"></i>&nbsp;Events</a>
                    </div>
                </nav>
                <!-- Tab panes -->
                <div class="tab-content pt-3 pl-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">...</div>

                    <div class="tab-pane fade" id="nav-logs" role="tabpanel" aria-labelledby="nav-logs-tab">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="info-box">
                                    <span class="info-box-icon bg-secondary"><i class="fa fa-clock"></i></span>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                <table class="table-bordered font-14 table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $events_ = fetchtable('tbl_logs', "service_id='$service_'", "id", "desc", "0,20", "id ,log,logged_date");
                                        $events_total = countotal("tbl_logs", "status > 0 AND service_id = '$service_'");
                                        if ($events_total > 0) {
                                            while ($d = mysqli_fetch_array($events_)) {
                                                $id = $d['id'];
                                                $log_ = $d['log'];
                                                $log = '<span class="text-danger font-bold">'.$log_.'</span>';
                                                if($log_ == "Success"){
                                                    $log = '<span class="text-green font-bold">'.$log_.'</span>';
                                                }
                                                

                                                $logged_date = $d['logged_date'];
                                                echo " <tr><td>$log</td><td>$logged_date</td> </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2'><i>No Events Found</i></td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" value="<?php echo $service_ ?>" id="service_" />
</section>