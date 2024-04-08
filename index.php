<?php
session_start();
// error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');

    echo ($_SESSION['userlogin']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard - HRMS admin template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

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
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Welcome
                                <span><?php echo htmlentities(ucfirst($_SESSION['FirstName'] . " " . $_SESSION['LastName'])); ?></span>

                            </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <?php
                    $sql = "SELECT id from projects";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $totprojects = $query->rowCount();
                    ?>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $totprojects; ?></h3>
                                    <span>Projects</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT id from clients";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $totalcount = $query->rowCount();
                    ?>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $totalcount; ?></h3>
                                    <span>Clients</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT id from assets";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $totassets = $query->rowCount();
                    ?>

                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $totassets ?></h3>
                                    <span>Assets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT id from employees";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    $totaemployees = $query->rowCount();
                    ?>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $totaemployees; ?></h3>
                                    <span>Employees</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>








                <?php

                if ($_SESSION['userlogin'] == 1) {

                ?>
                <div class="row">
                    <div class="col-md-12 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Recent Projects</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table custom-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Project Name </th>
                                                <th>Progress</th>
                                                <th class="text-center">Deadline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // Fetch the last three projects
                                                $sql = "SELECT * FROM projects ORDER BY id DESC LIMIT 3";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $projects = $query->fetchAll(PDO::FETCH_ASSOC);

                                                // Check if there are any projects
                                                if ($projects) {
                                                    // Loop through each project
                                                    foreach ($projects as $project) {
                                                ?>
                                            <tr>
                                                <td>
                                                    <h2><a
                                                            href="project-view.php?id=<?php echo $project['id']; ?>"><?php echo $project['ProjectName']; ?></a>
                                                    </h2>
                                                </td>
                                                <td>

                                                    <p class="m-b-5">Progress <span
                                                            class="text-info float-right"><?php echo $project['CompletionPercentage']; ?>%</span>

                                                    <div class="progress progress-xs progress-striped">

                                                        <div class="progress-bar" role="progressbar"
                                                            data-toggle="tooltip"
                                                            title="<?php echo $project['CompletionPercentage']; ?>%"
                                                            style="width: <?php echo $project['CompletionPercentage']; ?>%">
                                                        </div>

                                                    </div>

                                                </td>
                                                <td class="text-center">
                                                    <div class="dropdown dropdown-action">
                                                        <h2><a
                                                                href="project-view.php?id=<?php echo $project['id']; ?>"><?php echo $project['EndDate']; ?></a>
                                                        </h2>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                } else {
                                                    // Display message when there are no projects
                                                    echo '<tr><td colspan="3">We don\'t have any projects yet.</td></tr>';
                                                }
                                                ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="projects.php">View all projects</a>
                            </div>
                        </div>
                    </div>
                </div>



                <?php
                } else {

                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Goal Type</th>
                                        <th>Subject</th>
                                        <th>Target Achievement</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Description </th>
                                        <th>Progress </th>
                                    </tr>
                                </thead>
                                <?php
                                    $sql = "SELECT g.*, gt.Type AS goal_type FROM goals g
            INNER JOIN goal_type gt ON g.goal_typeId = gt.id";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                    ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo htmlentities($row->goal_type); ?></td>
                                        <td><?php echo htmlentities($row->Subject); ?></td>
                                        <td><?php echo htmlentities($row->Target); ?></td>
                                        <td><?php echo htmlentities($row->StartDate); ?></td>
                                        <td><?php echo htmlentities($row->EndDate); ?></td>
                                        <td><?php echo htmlentities($row->Description); ?></td>

                                        <td>




                                            <p style="height:20px" class="m-b-5"><span style="display:inline-block;"
                                                    class="text-success float-right"><?php echo $row->Progress; ?>%</span>
                                            </p>
                                            <div class="progress" style="height:7px">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    data-toggle="tooltip" title="<?php echo $row->Progress; ?>%"
                                                    style="width: <?php echo $row->Progress; ?>%"></div>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                                <?php $cnt += 1;
                                        }
                                    }
                                    ?>
                            </table>

                        </div>
                    </div>
                </div>



                <?php


                } ?>


            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- javascript links starts here -->
    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/js/chart.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <!-- javascript links ends here  -->
</body>

</html>