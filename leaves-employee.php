﻿<?php
session_start();

$current_datetime = date('Y-m-d H:i:s');

// print_r($updated_datetime = date('Y-m-d H:i:s', strtotime($current_datetime . ' +3 hours')));
error_reporting(0);
include_once('includes/config.php');
include_once("includes/functions.php");
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE from leaves where id=:rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('Employee Leave Has Been Deleted');</script>";
    echo "<script>window.location.href ='leaves-employee.php'</script>";
} elseif (isset($_POST['edit_leave'])) {
    $rid = intval($_POST['id']);
    $starting_at = htmlspecialchars($_POST['starting_at']);
    $ends_on = htmlspecialchars($_POST['ends_on']);
    $days_count = htmlspecialchars($_POST['days_count']);
    $reason = htmlspecialchars($_POST['reason']);

    $sql = "UPDATE leaves SET Starting_At = :starting_at, Ending_On = :ends_on, dayscount = :days_count, Reason = :reason WHERE id = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->bindParam(':starting_at', $starting_at, PDO::PARAM_STR);
    $query->bindParam(':ends_on', $ends_on, PDO::PARAM_STR);
    $query->bindParam(':days_count', $days_count, PDO::PARAM_STR);
    $query->bindParam(':reason', $reason, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Employee Leave Has Been Updated');</script>";
    echo "<script>window.location.href ='leaves-employee.php'</script>";
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
    <title>Leaves - HRMS admin template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">+

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


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
                            <h3 class="page-title">Leaves</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item Approved">Leaves</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
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
                                        <th>From</th>
                                        <th>To</th>
                                        <th>No of Days</th>
                                        <th>Reason</th>

                                        <th>status</th>


                                    </tr>
                                </thead>
                                <?php
                                if ($_SESSION['userlogin'] == 1) {
                                    $sql = "SELECT * FROM leaves";
                                    $query = $dbh->prepare($sql);
                                } else {
                                    $userName =  $_SESSION['FirstName'] . " " . $_SESSION['LastName'];
                                    $sql = "SELECT * FROM leaves WHERE Employee= :userName";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':userName', $userName, PDO::PARAM_STR);
                                }
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo htmlentities($row->Employee); ?></td>
                                                <td><?php echo htmlentities($row->Starting_At); ?></td>
                                                <td><?php echo htmlentities($row->Ending_On); ?></td>
                                                <td><?php echo htmlentities($row->dayscount); ?></td>

                                                <td><?php echo htmlentities($row->Reason); ?></td>
                                                <?php
                                                if ($_SESSION['userlogin'] == 1) {
                                                ?>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-id="<?php echo htmlentities($row->id); ?>" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                <?php
                                                                if ($row->status == 0) {
                                                                    echo '<i class="fa fa-dot-circle-o text-warning"></i> Pending';
                                                                } elseif ($row->status == 1) {
                                                                    echo '<i class="fa fa-dot-circle-o text-success"></i> Approved';
                                                                } else {
                                                                    echo '<i class="fa fa-dot-circle-o text-danger"></i> Reject';
                                                                }
                                                                ?>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="#" data-id="<?php echo htmlentities($row->id); ?>" onclick="changeStatus(this, 'Approved')"><i class="fa fa-dot-circle-o text-success"></i> Approved</a>
                                                                <a class="dropdown-item" href="#" data-id="<?php echo htmlentities($row->id); ?>" onclick="changeStatus(this, 'Pending')"><i class="fa fa-dot-circle-o text-warning"></i> Pending</a>
                                                                <a class="dropdown-item" href="#" data-id="<?php echo htmlentities($row->id); ?>" onclick="changeStatus(this, 'Reject')"><i class="fa fa-dot-circle-o text-danger"></i> Reject</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                <?php
                                                } else {
                                                ?>

                                                    <td>
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded " data-id="<?php echo htmlentities($row->id); ?>" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                <?php
                                                                if ($row->status == 2) {

                                                                    echo '<i class="fa fa-dot-circle-o text-danger"></i> Reject';
                                                                } elseif ($row->status == 0) {
                                                                    echo '<i class="fa fa-dot-circle-o text-warning"></i> Pending';
                                                                } else {
                                                                    echo '<i class="fa fa-dot-circle-o text-success"></i> Approved';
                                                                }
                                                                ?>
                                                            </a>

                                                        </div>
                                                    </td>
                                                <?php } ?>


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

            <!-- Add Leave Modal -->
            <?php include_once 'includes/modals/leave/add_leave.php'; ?>
            <!-- /Add Leave Modal -->

            <!-- Edit Leave Modal -->
            <?php include_once 'includes/modals/leave/edit_leave.php'; ?>
            <!-- /Edit Leave Modal -->

            <!-- Delete Leave Modal -->
            <?php include_once 'includes/modals/leave/delete_leave.php'; ?>
            <!-- /Delete Leave Modal -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <script>
        $('.editButton').each(function() {
            $(this).on('click', function(event) {
                event.preventDefault();

                var leaveId = $(this).data('id');
                console.log(leaveId);
                // Perform AJAX request to fetch data
                $.ajax({
                    url: '/HR-SYS/includes/modals/leave/get_data_to_edit_leave.php',
                    type: 'POST',
                    data: {
                        id: leaveId
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        // Populate the modal fields with the fetched data
                        $('#edit_leave').find('input[name="starting_at"]').val(response
                            .Starting_At);
                        $('#edit_leave').find('input[name="ends_on"]').val(response.Ending_On);
                        $('#edit_leave').find('textarea[name="reason"]').val(response.Reason);

                        $('#edit_leave').find('input[name="days_count"]').val(response
                            .dayscount);
                        $('#edit_leave').find('input[name="id"]').val(response.id);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error('Request failed with status ' + xhr.status);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-leave').each(function() {
                $(this).on('click', function(e) {
                    var LeaveId = $(this).data('id');


                    event.preventDefault();

                    $.ajax({

                        url: "/HR-SYS/leaves-employee.php",

                        type: "POST",
                        data: {
                            id: LeaveId
                        },
                        success: function(response) {
                            $("#aprovedelete").attr('href',
                                'leaves-employee.php?delid=' + LeaveId);

                        }
                    })
                })
            })
        })
    </script>

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
            if (status === 'Approved') {
                var newText = '<i class="fa fa-dot-circle-o text-success"></i> Approve';
            } else if (status === 'Reject') {
                var newText = '<i class="fa fa-dot-circle-o text-danger"></i> Reject';
            } else if (status === 'Pending') {
                var newText = '<i class= "fa fa-dot-circle-o text-warning"></i> Pending';

            }
            // var newText = status === 'Approved' ? '<i class="fa fa-dot-circle-o text-success"></i> Approved' : '<i class="fa fa-dot-circle-o text-danger"></i> Reject';
            dropdownToggle.html(newText);
            var leaveid = $(element).data('id')

            $.ajax({
                url: '/HR-SYS/includes/modals/leave/changestatusofleave.php',
                type: 'POST',
                data: {
                    status: status,
                    id: leaveid
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