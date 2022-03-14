<section class="content-header">
      <h1>
        implementations
        <small>List</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">implementations</li>
      </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
                <div class="box-header bg-info">
                    <div class="row">
                        <div class="col-md-10">
                            <h3 class="box-title font-16">
                                <a class="btn font-16 btn-md bg-blue text-bold" href="#"><i class="fa fa-clone"></i> All</a>
                            </h3>
                        </div>
                        <div class="col-md-2">

                            <a class="btn btn-success float-right" href="?impl-add-edit"><i class="fa fa-plus"></i> ADD NEW</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Upvoters</th>
                            <th>Downvoters</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="impl_list">


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Upvoters</th>
                            <th>Downvoters</th>
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
//echo "<div style='display: none ;'>".paging_values_hidden('uid > 0',0,10,'uid','desc','', 'functionality_list', 1)."</div>";
?>