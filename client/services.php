<?php
session_start();
include_once("../configs/conn.inc");
include_once("../php_functions/functions.php");
?>

<!DOCTYPE html>
<html>

<head>
    <?php
    include_once("includes/header-includes.php")
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed bg-light">
    <div class="wrapper">
        <!--Preloader -->
        <?php
        include_once("includes/preloader.php");
        ?>
        <!-- Navbar -->
        <?php
        include_once("includes/navbar.php");
        $details = "";
        $btn = "";
        $datetimepicker = "";
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        include_once("includes/sidebar.php");
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_GET['service'])) {
                    $display = "service";
                ?>
                    <div class="_details">
                        <?php
                        include_once("widgets/service-details.php");
                        ?>
                    </div>
                <?php
                } elseif (isset($_GET['service-add-edit'])) {
                    $display = "service-add-edit";
                ?>
                    <div class="_form">
                        <?php
                        include_once("forms/service-add-edit.php");
                        ?>
                    </div>
                <?php
                } else {
                    $display = "service-list";
                ?>

                    <div class="_list">
                        <?php
                        include_once("widgets/service-list.php");
                        ?>
                    </div>
                <?php } ?>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!--Footer-->
        <?php
        include_once("includes/footer.php");
        ?>
    </div>
    <!-- ./wrapper -->

    <!-- scripts/footer-includes -->
    <?php
    include_once("includes/footer-includes.php");
    ?>
    <script>
        //Date and time picker
        $('#datetimepicker2').datetimepicker({
            local: 'en',
            format: 'YYYY-MM-DD hh:mmA'
        });
    </script>
    <script>
        $(document).ready(function() {
            const display = "<?php echo $display; ?>";
            footer_date();

            if (display === "service-list") {
                service_list(); /////Load services
                pager('#service-table');
            }

            if(display === 'service-add-edit'){
                submitBtn('save_service()')
            }

            if (display === "service") {
                getServiceById();
                getLogsByServiceId();
            }
        })
    </script>
</body>

</html>