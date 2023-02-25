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
                                <!-- <a class="btn font-16 btn-md bg-blue text-bold" href="#"><i class="fa fa-clone"></i> All</a> -->
                                <select class="btn font-16 btn-md btn-default text-bold top-select" id="service_order" onchange="service_filters()">
                                    <option value="asc">Upcoming First</option>
                                    <option value="desc">Future First</option>
                                </select>

                                <select class="btn font-16 btn-md btn-default text-bold top-select" id="sel_company" onchange="service_filters()">
                                    <option value="0">Company</option>
                                    <?php
                                    $user_details = session_details();
                                    // $user_company = $user_details['company_id'];
                                    $tbl_companies_ = fetchtable('tbl_companies',"status > 0", "name", "asc", "0,10", "id ,name ");
                                    while($w = mysqli_fetch_array($tbl_companies_))
                                    {
                                        $id = $w['id'];
                                        $name = $w['name'];
                                        echo "<option value='$id'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </h3>

                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-success btn-sm float-right" href="?service-add-edit"><i class="fa fa-plus"></i> ADD NEW</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="card-body">
                    <table id="service-table" class="table table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Last Run</th>
                                <th>Next Run</th>
                                <th>Unit</th>
                                <th>Frequency</th>
                                <th>Repeated</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="service_list">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Last Run</th>
                                <th>Next Run</th>
                                <th>Unit</th>
                                <th>Frequency</th>
                                <th>Repeated</th>
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
echo "<div style='display: none;'>" . paging_values_hidden('id > 0', 0, 10, 'next_run_datetime', 'ASC', '', 'service_list', 1, 0) . "</div>";
?>