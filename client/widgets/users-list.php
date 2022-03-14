<section class="content-header">
      <h1>
        Users
        <small>List</small>
    </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
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

                            <a class="btn btn-success float-right" href="?user-add-edit"><i class="fa fa-plus"></i> ADD NEW</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="users_table" class="table table-bordered table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="users_list">


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Country</th>
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
function paging_values_hidden($status, $offset, $rpp, $orderby, $dir, $search, $func, $page_no = 1){
    $vals = '';
    $vals.= "<input type='text' title='status' id='_status_' value='$status'>";
    $vals.= "<input type='text' title='offset' id='_offset_' value='$offset'>";
    $vals.= "<input type='text' title='rpp' id='_rpp_' value='$rpp'>";
    $vals.= "<input type='text' title='page_no' id='_page_no_' value='$page_no'>";
    $vals.= "<input type='text' title='orderby' id='_orderby_' value='$orderby'>";
    $vals.= "<input type='text' title='dir' id='_dir_' value='$dir'>";
    $vals.= "<input type='text' title='search' id='_search_' value='$search'>";
    $vals.= "<input type='text' title='func' id='_func_' value='$func()'>";

    return $vals;
}
echo "<div style='display: none;'>".paging_values_hidden(1,0,10,'username','ASC','', 'apiUsersLoad', 1)."</div>";
?>

<script>
    $('#users_table').DataTable();
    //loadUserById() //Load Platform details
    //addEditUser()  //Add or edit Platform deta
</script>