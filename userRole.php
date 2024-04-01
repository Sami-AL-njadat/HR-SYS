<?php

$current_datetime = date('Y-m-d H:i:s');

session_start();
error_reporting(0);
include_once('includes/config.php');
include_once("includes/functions.php");
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
}

?>
<?php
if ($_SESSION['userlogin'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>User Role - HRMS admin template</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!-- Lineawesome CSS -->
        <link rel="stylesheet" href="assets/css/line-awesome.min.css">

        <!-- Datatable CSS -->
        <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="assets/css/select2.min.css">

        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

        <!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
    </head>

    <body>
        <!-- Main Wrapper -->
        <div class="main-wrapper">

            <!-- Header -->
            <?php include_once("includes/header.php"); ?>
            <!-- /Header -->

            <!-- Sidebar -->
            <?php include_once("includes/sidebar.php"); ?>
            <!-- /Sidebar -->

            <!-- Page Wrapper -->
            <div class="page-wrapper">

                <!-- Page Content -->
                <div class="content container-fluid">

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">User Role</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">User Role</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <!-- /Page Header -->



                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>

                                            <?php
                                            if ($_SESSION['userlogin'] == 1) {
                                            ?>
                                                <th>Role</th>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($_SESSION['userlogin'] == 1) {
                                        $sql = "SELECT * FROM employees";
                                        $query = $dbh->prepare($sql);
                                    }
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                    ?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo htmlentities($row->FirstName) . ' ' . $row->LastName; ?></td>

                                                    <?php
                                                    if ($_SESSION['userlogin'] == 1) {
                                                    ?>
                                                        <td>
                                                            <div class="dropdown action-label">
                                                                <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-id="<?php echo htmlentities($row->id); ?>" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                    <?php
                                                                    if ($row->role == 2) {

                                                                        echo '<i class="fa fa-dot-circle-o "></i> Employee';
                                                                    } else {
                                                                        echo '<i class="fa fa-dot-circle-o "></i> Sub Admin';
                                                                    }
                                                                    ?>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" href="#" data-id="<?php echo htmlentities($row->id); ?>" onclick="changeStatus(this, 'Active')"><i class="fa fa-dot-circle-o text-"></i> Employee</a>
                                                                    <a class="dropdown-item" href="#" data-id="<?php echo htmlentities($row->id); ?>" onclick="changeStatus(this, 'Inactive')"><i class="fa fa-dot-circle-o text-"></i> Sub Admin</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>



                                                </tr>

                                            </tbody>
                                    <?php $cnt += 1;
                                        }
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /Page Content -->


            </div>
            <!-- /Page Wrapper -->

        </div>
        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>



        <!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- Slimscroll JS -->
        <script src="assets/js/jquery.slimscroll.min.js"></script>

        <!-- Select2 JS -->
        <script src="assets/js/select2.min.js"></script>

        <!-- Datatable JS -->
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/dataTables.bootstrap4.min.js"></script>

        <!-- Datetimepicker JS -->
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

        <!-- Custom JS -->
        <script src="assets/js/app.js"></script>
        <script>
            function changeStatus(element, status) {
                var dropdownToggle = $(element).closest('.dropdown').find('.dropdown-toggle');
                var newText = status === 'Active' ? '<i class="fa fa-dot-circle-o text-">Employee</i> ' : '<i class="fa fa-dot-circle-o text-"></i> Sub Admin ';
                dropdownToggle.html(newText);
                var role = $(element).data('id')

                $.ajax({
                    url: '/HR-SYS/includes/modals/role/changeRole.php',
                    type: 'POST',
                    data: {
                        status: status,
                        id: role
                    },
                    success: function(response) {
                        console.log('Status changed successfully:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error changing status:', error);
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
}
?>