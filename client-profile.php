<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['id'])) {
    $clientId = intval($_GET['id']);

    $sql = "SELECT * FROM clients WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $clientId, PDO::PARAM_INT);
    $query->execute();
    $clientData = $query->fetch(PDO::FETCH_ASSOC);

    if (!empty($clientData)) {
    } else {
        echo "<script>alert('Client not found.');</script>";
        echo "<script>window.location.href='clients.php';</script>";
    }
} else {
    echo "<script>alert('Client ID not provided.');</script>";
    echo "<script>window.location.href='clients.php';</script>";
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
    <title>Client Profile - HRMS admin template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

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
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Profile</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card mb-0">





                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-img-wrap">
                                        <div class="profile-img">
                                            <?php
                                            $profile_image_path = "clients/" . $clientData['Picture'];
                                            ?>
                                            <img src="<?php echo $profile_image_path; ?>" alt="Profile Picture">
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <h3 class="user-name m-t-0">
                                                        <?php echo $clientData['FirstName'] . ' ' . $clientData['LastName']; ?>

                                                    </h3>
                                                    <h5 class="company-role m-t-0 mb-0">Company:
                                                        <?php echo $clientData['Company']; ?></h5>
                                                    <h6 class="text-muted">Nickname:
                                                        <?php echo $clientData['UserName']; ?>
                                                    </h6>
                                                    <div class="staff-id"><?php echo $clientData['ClientId']; ?></div>

                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Phone:</span>
                                                        <span class="text"><a
                                                                href="tel:<?php echo $clientData['Phone']; ?>"><?php echo $clientData['Phone']; ?></a></span>
                                                    </li>
                                                    <li>
                                                        <span class="title">Email:</span>
                                                        <span class="text"><a
                                                                href="mailto:<?php echo $clientData['Email']; ?>"><?php echo $clientData['Email']; ?></a></span>
                                                    </li>

                                                    <li>
                                                        <span class="title">Address:</span>
                                                        <span class="text"><?php echo $clientData['Address']; ?></span>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item col-sm-3"><a class="nav-link active" data-toggle="tab"
                                        href="#myprojects">Projects</a></li>
                                <!-- <li class="nav-item col-sm-3"><a class="nav-link" data-toggle="tab" href="#tasks">Tasks</a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    if (isset($_GET['id'])) {
                        $clientId = intval($_GET['id']);
                        $sql = "SELECT * FROM projects WHERE ClientId = :id";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':id', $clientId, PDO::PARAM_INT);
                        $query->execute();
                        $projects = $query->fetchAll(PDO::FETCH_ASSOC);

                        if ($query->rowCount() > 0) {
                            foreach ($projects as $project) {
                                // Fetch project leader's information
                                $projectLeaderId = $project['ProjectLeaderId'];
                                $sqlLeader = "SELECT * FROM employees WHERE id = :leaderId";
                                $queryLeader = $dbh->prepare($sqlLeader);
                                $queryLeader->bindParam(':leaderId', $projectLeaderId, PDO::PARAM_INT);
                                $queryLeader->execute();
                                $projectLeader = $queryLeader->fetch(PDO::FETCH_ASSOC);

                                // Fetch team members' information
                                $projectId = $project['id'];
                                $sqlTeam = "SELECT * FROM teams JOIN employees ON teams.EmployeeId = employees.id WHERE teams.ProjectId = :projectId";
                                $queryTeam = $dbh->prepare($sqlTeam);
                                $queryTeam->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                                $queryTeam->execute();
                                $teamMembers = $queryTeam->fetchAll(PDO::FETCH_ASSOC);
                                $totalTeamMembers = count($teamMembers);
                    ?>
                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="project-title"><a
                                        href="project-view.php?id=<?php echo $project['id']; ?>"><?php echo $project['ProjectName']; ?></a>
                                </h4>

                                <p class="text-muted"><?php echo $project["Description"]; ?></p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Deadline:
                                    </div>
                                    <div class="text-muted">
                                        <?php echo $project['EndDate']; ?>
                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Project Leader :</div>
                                    <ul class="team-members">
                                        <li>
                                            <a data-toggle="tooltip"
                                                title="<?php echo $projectLeader['FirstName'] . ' ' . $projectLeader['LastName']; ?>">
                                                <img alt="" src="employees/<?php echo $projectLeader['Picture']; ?>">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <?php foreach ($teamMembers as $teamMember) : ?>
                                        <li>
                                            <a href="#" data-toggle="tooltip"
                                                title="<?php echo $teamMember['FirstName'] . ' ' . $teamMember['LastName']; ?>">
                                                <img alt="" src="employees/<?php echo $teamMember['Picture']; ?>">
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                        <?php if ($totalTeamMembers > 5) : ?>
                                        <li class="dropdown avatar-dropdown">
                                            <a href="#" class="all-users dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">+<?php echo ($totalTeamMembers - 5); ?></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <div class="avatar-group">
                                                    <!-- Display additional team members -->
                                                </div>
                                            </div>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <p class="m-b-5">Progress <span
                                        class="text-success float-right"><?php echo $project['CompletionPercentage']; ?>%</span>
                                </p>
                                <div class="progress progress-xs mb-0">
                                    <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip"
                                        title="<?php echo $project['CompletionPercentage']; ?>%"
                                        style="width: <?php echo $project['CompletionPercentage']; ?>%"></div>
                                </div>
                                <a href="project-view.php?id=<?php echo $project['id']; ?>"
                                    class="btn btn-white btn-sm m-t-10">View Project</a>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        } else {
                            // Display a message when there are no projects for the client
                            echo '<h2 class="col-md-12"><p>No projects yet for this client.</p></h2>';
                        }
                    }  ?>
                </div>

            </div>


            <!-- /Page Content -->

        </div>
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

    <!-- Task JS -->
    <script src="assets/js/task.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

</body>

</html>