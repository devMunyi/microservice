<div class="content-header pb-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="">Services&nbsp;<small class="text-muted xsm">List</small></h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index" class="aco">Home</a></li>
                    <li class="breadcrumb-item active">Services</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="row">
        <div class="col-sm-12">

            <!-- /.box -->
            <div class="card ml-3 mr-3">
                <div class="card-header pt-2">
                    <div class="row pr-2">
                        <div class="col-md-10">
                            <h3 class="card-title font-16 pl-2">
                                <a class="btn font-16 btn-md bg-blue text-bold" href="#"><i class="fa fa-clone"></i> All</a>
                            </h3>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-success float-right" href="?service-add-edit"><i class="fa fa-plus"></i> ADD NEW</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <table id="service-table" class="table table-bordered table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th style="width: 100px;">Address</th>
                            <th>Run Time</th>
                            <th>Unit</th>
                            <th>Frequency</th>
                            <th>Processed</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="service_list">

                        </tbody>
                        <tfoot>
                        <tr>
                            <th>No.</th>
                            <th style="width: 100px;">Address</th>
                            <th>Run Time</th>
                            <th>Unit</th>
                            <th>Frequency</th>
                            <th>Processed</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</section>

<?php
    echo "<div style='display: none;'>".paging_values_hidden('id > 0',0,10,'r_timestamp','DESC','', 'service_list', 1)."</div>";
?>