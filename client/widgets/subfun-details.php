<div class="content-header">
    <?php
    $subfun_ = $_GET['subfun'];
    ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>
                    Subfunctionality
                    &nbsp;<small><span class="subfun_name sm"><i>Loading...</i></span></small>
                </h3>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index" class="aco text-muted">Home</a></li>
                    <li class="breadcrumb-item">Subfunctionality</li>
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
                        <a class="nav-link aco" id="nav-uploads-tab" data-toggle="tab" href="#nav-uploads" role="tab" aria-controls="nav-uploads" aria-selected="false"><i class="fa fa-cloud-upload"></i>&nbsp;Icon Uploads</a>
                        <a class="nav-link aco" id="nav-logs-tab" data-toggle="tab" href="#nav-logs" role="tab" aria-controls="nav-logs" aria-selected="false"><i class="fa fa-tag"></i>&nbsp;Logs</a>
                    </div>
                </nav>
                <!-- Tab panes -->
                <div class="tab-content pt-3 pl-2" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-details" role="tabpanel" aria-labelledby="nav-details-tab">...</div>
                    <div class="tab-pane fade" id="nav-uploads" role="tabpanel" aria-labelledby="nav-uploads-tab">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="info-box">
                                    <span class="info-box-icon bg-secondary"><i class="fa fa-cloud-upload"></i></span>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                Upload Icon
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-logs" role="tabpanel" aria-labelledby="nav-logs-tab">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="info-box">
                                    <span class="info-box-icon bg-secondary"><i class="fa fa-tag"></i></span>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                Logs info
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" value="<?php echo $subfun_ ?>" id="subfun_" />
</section>