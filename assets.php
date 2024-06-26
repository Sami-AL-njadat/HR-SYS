﻿<?php
session_start();
error_reporting(0);
include('includes/config.php');
include_once('includes/functions.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE from assets where id=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Asset Has Been Deleted');</script>";
    echo "<script>window.location.href ='assets.php'</script>";
}
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
    <title>Assets - HRMS admin template</title>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                            <h3 class="page-title">Assets</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Assets</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_asset"><i class="fa fa-plus"></i> Add Asset</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <!-- #region -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Asset User</th>
                                        <th>Asset Name</th>
                                        <th>Asset Id</th>
                                        <th>Purchase Date</th>
                                        <th>Warranty</th>
                                        <th>Amount</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-right"></th>
                                    </tr>
                                </thead>
                                <?php
                                $sql = "SELECT a.*, e.FirstName, e.LastName FROM assets a JOIN employees e ON a.AssetUser = e.id";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo htmlentities($row->FirstName . ' ' . $row->LastName); ?></td>
                                                <td>
                                                    <strong><?php echo htmlentities($row->assetName); ?></strong>
                                                </td>
                                                <td><?php echo htmlentities($row->assetId); ?></td>
                                                <td><?php echo htmlentities($row->PurchaseDate); ?></td>
                                                <td><?php echo htmlentities($row->Warranty); ?></td>
                                                <td><?php echo "$" . htmlentities($row->Price); ?></td>
                                                <td class="text-center">
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded " href="#" data-toggle="dropdown" aria-expanded="false">
                                                            <?php
                                                            $status = '';
                                                            switch ($row->Status) {
                                                                case 0:
                                                                    $status = 'New';
                                                                    break;
                                                                case 1:
                                                                    $status = 'Used';
                                                                    break;
                                                                case 2:
                                                                    $status = 'Maintenance';
                                                                    break;
                                                                case 3:
                                                                    $status = 'Damaged';
                                                                    break;
                                                            }
                                                            echo '<i class="fa fa-dot-circle-o ';
                                                            switch ($row->Status) {
                                                                case 0:
                                                                    echo 'text-danger';
                                                                    break;
                                                                case 1:
                                                                    echo 'text-success';
                                                                    break;
                                                                case 2:
                                                                    echo 'text-info';
                                                                    break;
                                                                case 3:
                                                                    echo 'text-secondary';
                                                                    break;
                                                            }
                                                            echo '"></i> ' . $status;
                                                            ?>
                                                        </a>

                                                    </div>
                                                </td>

                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item edit-asset-btn" href="#" data-toggle="modal" data-target="#edit_asset" data-id="<?php echo $row->id; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>



                                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete_asset" onclick="setAssetToDelete
                                            (<?php echo $row->id; ?>)"><i class="fa fa-trash-o m-r-5"></i>Delete</a>

                                                        </div>



                                                    </div>
                                                </td>
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

            <!-- Add Asset Modal -->
            <?php include_once("includes/modals/assets/add.php"); ?>
            <!-- /Add Asset Modal -->

            <!-- Edit Asset Modal -->
            <?php include_once("includes/modals/assets/edit.php"); ?>
            <!-- Edit Asset Modal -->

            <!-- Delete Asset Modal -->
            <?php include_once("includes/modals/assets/delete.php"); ?>
            <!-- /Delete Asset Modal -->

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

    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            $('.edit-asset-btn').click(function() {
                var assetId = $(this).data('id');
                $.ajax({
                    url: 'http://localhost/HR-SYS/includes/modals/assets/get_asset_data.php',
                    type: 'POST',
                    data: {
                        id: assetId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);

                        $('#edit_asset input[name="asset_name"]').val(data.assetName);
                        $('#edit_asset input[name="purchase_from"]').val(data.PurchaseFrom);
                        $('#edit_asset input[name="purchase_date"]').val(data.PurchaseDate);
                        console.log(data.PurchaseDate, "sss");


                        $('#edit_asset input[name="manufacturer"]').val(data.Manufacturer);
                        $('#edit_asset input[name="model"]').val(data.Model);
                        $('#edit_asset input[name="supplier"]').val(data.Supplier);
                        $('#edit_asset select[name="status"]').val(data.Status);
                        $('#edit_asset input[name="condition"]').val(data.AssetCondition);
                        $('#edit_asset input[name="warranty"]').val(data.Warranty);
                        $('#edit_asset input[name="value"]').val(data.Price);
                        $('#edit_asset select[name="asset_user"]').val(data.AssetUser);
                        $('#edit_asset textarea[name="descriptiones"]').val(data.Description);

                        $('#edit_asset input[name="id"]').val(assetId);

                        console.log(data, "all data ");

                    }
                });
            });
        });
    </script>

</body>

</html>