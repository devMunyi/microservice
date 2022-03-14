<section class="content-header">
    <?php
    $plt_id = $_GET['plt'];
    ?>

    <h1>
        Platform
        <small><span class="plt_name"><i>Loading...</i></span></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><span class="plt_name"><i>Loading...</i></span></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Nav tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item nav-100 active"><a href="#pltdetails" data-toggle="tab"><i class="fa fa-info"></i> Information</a></li>
                    <li class="nav-item nav-100"><a href="#pltupload" data-toggle="tab"><i class="fa fa-cloud-upload"></i> Icon Uploads</a></li>
                    <li class="nav-item nav-100"><a href="#pltlogs" data-toggle="tab"><i class="fa fa-tag"></i> Logs</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="pltdetails">
                        <i>Loading...</i>
                    </div>

                    <div class="tab-pane" id="pltupload">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="info-box-icon"><i class="fa fa-cloud-upload"></i></span>
                            </div>
                            <div class="col-md-10">
                                Upload Info
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="pltlogs">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="info-box-icon"><i class="fa fa-tag"></i></span>
                            </div>
                            <div class="col-md-10">
                                Logs Info
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" value="<?php echo $plt_id ?>" id="plt_" />
</section>