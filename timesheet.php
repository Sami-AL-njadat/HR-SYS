<?php
session_start();
error_reporting(0);
// include('includes/config.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
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
    <title>Timesheet - HRMS admin template</title>

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

</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Main Wrapper -->
        <div class="main-wrapper">

            <!-- Header -->
            <?php include_once("includes/header.php"); ?>
            <!-- /Header -->
            <?php
            if (isset($_GET['delid'])) {
                $rid = intval($_GET['delid']);
                $sql = "DELETE from timesheet where id=:rid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':rid', $rid, PDO::PARAM_STR);
                $query->execute();
                echo "<script>alert('Time Sheet deleted Successfully');</script>";

                echo "<script>window.location.href='/HR-SYS/timesheet.php';</script>";
            } ?>



            <!-- Sidebar -->
            <?php include_once("includes/sidebar.php"); ?>
            <!-- /Sidebar -->
            <!-- Sidebar -->
            <?php include_once("includes/sidebar.php"); ?>
            <!-- /Sidebar -->

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <!-- Page Wrapper -->
                <div class="page-wrapper">

                    <!-- Page Content -->
                    <div class="content container-fluid">
                        <!-- Page Content -->
                        <div class="content container-fluid">

                            <!-- Page Header -->
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Timesheet</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Timesheet</li>
                                        </ul>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <!-- <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_todaywork"><i class="fa fa-plus"></i> Add Today Work</a> -->
                                    </div>
                                </div>
                            </div>
                            <!-- /Page Header -->
                            <!-- Page Header -->
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Timesheet</h3>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Timesheet</li>
                                        </ul>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <!-- <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_todaywork"><i class="fa fa-plus"></i> Add Today Work</a> -->
                                    </div>
                                </div>
                            </div>
                            <!-- /Page Header -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped custom-table mb-0 datatable">
                                                                <thead>



                                                                    <tr>
                                                                        <th>Employee</th>
                                                                        <th>Date</th>
                                                                        <th>Projects</th>
                                                                        <th class="text-center">Assigned Hours</th>
                                                                        <!-- <th class="text-center">Hours</th> -->
                                                                        <th class="d-none d-sm-table-cell">Description</th>
                                                                        <th class="text-right">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th>Employee</th>
                                                                        <th>Date</th>

                                                                        <th>Projects</th>
                                                                        <th class="text-center">Assigned Hours</th>
                                                                        <!-- <th class="text-center">Hours</th> -->
                                                                        <th class="d-none d-sm-table-cell">Description</th>

                                                                        <?php

                                                                        if (($_SESSION['userlogin']) == 1) {

                                                                        ?>
                                                                            <th class="text-right">Actions</th>

                                                                        <?php
                                                                        } ?>
                                                                    </tr>

                                            </thead>
                                            <tbody>

                                                <?php
                                                $employeeid = $_SESSION['employeeid'];
                                                if ($_SESSION['userlogin'] == 1) {
                                                    $sql = "SELECT timesheet.*, employees.FirstName, employees.LastName, projects.ProjectName
                                            FROM timesheet 
                                            INNER JOIN employees ON timesheet.employeeId = employees.id
                                            INNER JOIN projects ON timesheet.projectId = projects.id";
                                                    $query = $dbh->prepare($sql);
                                                } else {

                                                    $sql = "SELECT timesheet.*, employees.FirstName, employees.LastName, projects.ProjectName
                                            FROM timesheet 
                                            INNER JOIN employees ON timesheet.employeeId = employees.id
                                            INNER JOIN projects ON timesheet.projectId = projects.id WHERE timesheet.employeeId = :employeeid ";
                                                    $query = $dbh->prepare($sql);
                                                    $query->bindParam(':employeeid', $employeeid);
                                                }

                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>

                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="profile.php" class="avatar"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a>
                                                                    <a href="profile.php"><?php echo $row->FirstName . " " . $row->LastName ?><span></span></a>

                                                                </h2>
                                                            </td>
                                                            <td><?php

                                                                $date = new DateTime($row->start);
                                                                $formattedDate = $date->format('j M Y');

                                                                echo $formattedDate;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <h2><?php echo $row->ProjectName ?></h2>
                                                            </td>
                                                            <td class="text-center"><?php

                                                                                    $endDateTime = new DateTime($row->end);
                                                                                    $startDateTime = new DateTime($row->start);

                                                                                    $diff = $endDateTime->diff($startDateTime);

                                                                                    $minutes = $diff->h;
                                                                                    $seconds = $diff->i;

                                                                                    if ($minutes > 0) {
                                                                                        echo "$minutes houre";
                                                                                        if ($minutes > 1) {
                                                                                            echo "s";
                                                                                        }
                                                                                        echo " ";
                                                                                    }

                                                                                    if ($seconds > 0) {
                                                                                        echo "$seconds minute";
                                                                                        if ($seconds > 1) {
                                                                                            echo "s";
                                                                                        }
                                                                                        echo " ";
                                                                                    }
                                                                                    ?></td>

                                                            <!-- <td class="text-center">7</td> -->
                                                            <td class="d-none d-sm-table-cell col-md-4"><?php echo $row->description ?></td>

                                                            <?php

                                                            if (($_SESSION['userlogin']) == 1) {

                                                            ?>
                                                                <td class="text-right">
                                                                    <div class="dropdown dropdown-action">
                                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item editButton" href="#" data-toggle="modal" data-id="<?php echo htmlentities($row->id); ?>" data-target="#edit_todaywork"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                            <a class="dropdown-item deleteButton" href="#" data-toggle="modal" data-id="<?php echo htmlentities($row->id); ?>" data-target="#delete_workdetail"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            <?php
                                                            }

                                                            ?>


                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Content -->
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Page Content -->

        <!-- Add Today Work Modal -->
        <?php include_once("includes/modals/timesheet/add_timesheet.php"); ?>
        <!-- /Add Today Work Modal -->
        <!-- Add Today Work Modal -->
        <?php include_once("includes/modals/timesheet/add_timesheet.php"); ?>
        <!-- /Add Today Work Modal -->

        <!-- Edit Today Work Modal -->
        <?php include_once("includes/modals/timesheet/edit_timesheet.php"); ?>
        <!-- /Edit Today Work Modal -->
        <!-- Edit Today Work Modal -->
        <?php include_once("includes/modals/timesheet/edit_timesheet.php"); ?>
        <!-- /Edit Today Work Modal -->

        <!-- Delete Today Work Modal -->
        <?php include_once("includes/modals/timesheet/delete_timesheet.php"); ?>
        <!-- Delete Today Work Modal -->
        <!-- Delete Today Work Modal -->
        <?php include_once("includes/modals/timesheet/delete_timesheet.php"); ?>
        <!-- Delete Today Work Modal -->

    </div>
    <!-- /Page Wrapper -->
    </div>
    <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.deleteButton').each(function() {
                $(this).on('click', function(e) {
                    var timesheetId = $(this).data('id');


                    event.preventDefault();

                    $.ajax({

                        url: "/HR-SYS/timesheet.php",

                        type: "POST",
                        data: {
                            deleteid: timesheetId
                        },
                        success: function(response) {
                            $(".deletetimesheet").attr('href', 'timesheet.php?delid=' + timesheetId);

                        }
                    })
                })
            })
            $('.editButton').each(function() {
                $(this).on('click', function(event) {
                    event.preventDefault();

                    var timesheetId = $(this).data('id');


                    $.ajax({
                        url: "/HR-SYS/includes/modals/timesheet/timesheetFunction.php",

                        type: 'POST',
                        data: {
                            editid: timesheetId
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#edit_todaywork').find('input[name="Start"]').val(response.start);

                            var startTime = new Date(response.start);
                            var endTime = new Date(response.end);
                            var timeDifference = endTime - startTime;
                            var hoursDifference = Math.floor(timeDifference / (1000 * 60 * 60));
                            var minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                            $('#edit_todaywork').find('input[name="Totalhoure"]').val(hoursDifference + ":" + minutesDifference);
                            $('#edit_todaywork').find('input[name="End"]').val(response.end);
                            $('#edit_todaywork').find('input[name="timesheetid"]').val(response.id);
                            $('#edit_todaywork').find('textarea[name="description"]').val(response.description);

                            $('#edit_todaywork').find('select[name="projectid"]').val(response.projectId);
                        },
                        error: function(xhr, status, error) {
                            console.error('Request failed with status ' + xhr.status);
                        }
                    });
                });
            });
        });
    </script>
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>
    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

</body>

</html>