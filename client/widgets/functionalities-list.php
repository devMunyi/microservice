<div class="content-header pb-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="">Functionalities&nbsp;<small class="text-muted xsm">List</small></h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index" class="aco">Home</a></li>
                    <li class="breadcrumb-item active">Functionalities</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <!-- /.box -->

                <div class="card" ">
                    <div class="card-header pt-2">
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="card-title font-16">
                                    <a class="btn font-16 btn-md bg-blue text-bold" href="#"><i class="fa fa-clone"></i> All</a>
                                </h3>
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-success float-right" href="?functionality-add-edit"><i class="fa fa-plus"></i> ADD NEW</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="card-body">
                        <table id="fun_table" class="table table-bordered table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="functionality_list">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Icon</th>
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
    </div>

</section>

<?php
//echo "<div style='display: none ;'>".paging_values_hidden('uid > 0',0,10,'uid','desc','', 'functionality_list', 1)."</div>";
?>

<?php
echo "<div style='display: ;'>".paging_values_hidden('uid > 0',0,5,'uid','desc','', 'apiFunLoad', 1)."</div>"
?>
