<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['id'])) {
    $projectId = $_GET['id'];
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
    <title>Project View - HRMS admin template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

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



                            <?php
                            $sql = "SELECT * FROM projects WHERE id = :projectId";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                            $query->execute();
                            $project = $query->fetch(PDO::FETCH_ASSOC);

                            if ($project) {
                            ?>
                            <div class="project-title">
                                <h3 class="page-title"><?php echo $project['ProjectName']; ?></h3>
                            </div>
                            <?php
                            } else {
                                echo "Project not found.";
                            }
                            ?>
                            <ul class="breadcrumb">
                                <?php
                                if ($_SESSION['userlogin'] == 2) {
                                    echo '<li class="breadcrumb-item"><a href="allProject.php">Dashboard</a></li>';
                                } else {
                                    echo '<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>';
                                }
                                ?>

                                <li class="breadcrumb-item active">Project</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">


                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-lg-8 col-xl-9">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title m-b-25"> Client Details </h2>

                                <?php
                                $sql2 = "SELECT projects.*, clients.FirstName,clients.Email,clients.Phone, clients.LastName, clients.Company FROM projects 
        INNER JOIN clients ON projects.ClientId = clients.id
        WHERE projects.id = :projectId";

                                $query2 = $dbh->prepare($sql2);
                                $query2->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                                $query2->execute();
                                $project2 = $query2->fetch(PDO::FETCH_ASSOC);

                                $sql = "SELECT * FROM projects WHERE id = :projectId";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                                $query->execute();
                                $project = $query->fetch(PDO::FETCH_ASSOC);

                                // Check if project exists
                                if ($project && $project2) {
                                ?>



                                <div class="project-title m-b-10">
                                    <h6 class="card-text">Client Name:
                                        <?php echo $project2['FirstName'] . " " . $project2['LastName']; ?>
                                    </h6>

                                </div>

                                <div class="project-title  m-b-10">
                                    <h6 class="card-card-text">Company: <?php echo $project2['Company']; ?>
                                    </h6>

                                </div>

                                <div class="project-title  m-b-10">
                                    <h6 class="card-card-text">Phone: <?php echo $project2['Phone']; ?>
                                    </h6>

                                </div>
                                <div class="project-title m-b-10">
                                    <h6 class="card-text ">Email: <?php echo $project2['Email']; ?></h6>


                                </div>

                                <h6 class="card-title m-b-20"> Project Description </h6>
                                <div class="project-title m-b-10">

                                    <?php echo $project['Description']; ?>
                                </div>
                                <?php
                                } else {
                                    echo "Project not found.";
                                }
                                ?>

                            </div>

                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title m-b-20"> Project File </h5>
                                <ul class="files-list">
                                    <?php
                                    // Retrieve project ID from the URL
                                    if (isset($_GET['id'])) {
                                        $projectId = $_GET['id'];

                                        // Fetch file information from the database based on the project ID
                                        $sql = "SELECT Filees FROM projects WHERE id = :projectId";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                                        $query->execute();
                                        $fileInfo = $query->fetch(PDO::FETCH_ASSOC);

                                        // Check if file information exists
                                        if ($fileInfo) {
                                            $file_path = $fileInfo['Filees'];

                                            // Display file information
                                    ?>
                                    <div class="files-cont">
                                        <small
                                            class="form-text text-muted"><?php echo isset($project['Filees']) ? htmlentities($project['Filees']) : ''; ?></small>

                                        <div class="file-type">
                                            <?php
                                                    // Display file icon based on file type
                                                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                                                    switch ($file_extension) {

                                                        case 'pdf':
                                                            echo '<span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>';
                                                            break;
                                                        case 'doc':
                                                        case 'docx':
                                                            echo '<span class="files-icon"><i class="fa fa-file-word-o"></i></span>';
                                                            break;
                                                        case 'xls':
                                                        case 'xlsx':
                                                            echo '<span class="files-icon"><i class="fa fa-file-excel-o"></i></span>';
                                                            break;
                                                        case 'ppt':
                                                        case 'pptx':
                                                            echo '<span class="files-icon"><i class="fa fa-file-powerpoint-o"></i></span>';
                                                            break;
                                                            // Add cases for other file types as needed
                                                        default:
                                                            echo '<span class="files-icon"><i class="fa fa-file-o"></i></span>';
                                                            break;
                                                    }
                                                    ?>
                                        </div>
                                        <div class="files-info">
                                            <span class="file-name text-ellipsis"><a href="<?php echo $file_path; ?>"
                                                    target="_blank">Download
                                                    File</a></span>
                                        </div>
                                    </div>
                                    <?php
                                        } else {
                                            // Handle case where file information is not found
                                            echo "File not found for this project.";
                                        }
                                    } else {
                                        // Handle case where project ID is not provided in the URL
                                        echo "Project ID not provided.";
                                    }
                                    ?>


                                </ul>
                            </div>
                        </div>


                        <!-- Display assigned leader -->
                        <div class="card project-user">
                            <div class="card-body">
                                <h6 class="card-title m-b-20">Team Leader</h6>
                                <ul class="list-box">
                                    <?php
                                    // Fetch assigned leader
                                    $sql = "SELECT * FROM employees WHERE id = :leaderId";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':leaderId', $project['ProjectLeaderId'], PDO::PARAM_INT);
                                    $query->execute();
                                    $leader = $query->fetch(PDO::FETCH_ASSOC);

                                    if ($leader) {
                                    ?>
                                    <li>
                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar"><img style="width: 38px;height:38px;" alt=""
                                                        src="employees/<?php echo $leader['Picture']; ?>"></span>
                                            </div>
                                            <div class="list-body">
                                                <span
                                                    class="message-author"><?php echo $leader['FirstName'] . ' ' . $leader['LastName']; ?></span>
                                                <div class="clearfix"></div>
                                                <span class="message-content">Team Leader</span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    } else {
                                        echo "Assigned leader not found.";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <!-- Display assigned users -->
                        <div class="card project-user">
                            <div class="card-body">
                                <h6 class="card-title m-b-20">Team Member


                                </h6>
                                <ul class="list-box">
                                    <?php
                                    // Fetch assigned users
                                    $sql = "SELECT * FROM teams JOIN employees ON teams.EmployeeId = employees.id WHERE teams.ProjectId = :projectId";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                                    $query->execute();
                                    $users = $query->fetchAll(PDO::FETCH_ASSOC);

                                    if ($users) {
                                        foreach ($users as $user) {
                                    ?>
                                    <li>

                                        <div class="list-item">
                                            <div class="list-left">
                                                <span class="avatar"><img alt="" style="width: 38px;height:38px;"
                                                        src="employees/<?php echo $user['Picture']; ?>"></span>
                                            </div>
                                            <div class="list-body">
                                                <span
                                                    class="message-author"><?php echo $user['FirstName'] . ' ' . $user['LastName']; ?></span>
                                                <div class="clearfix"></div>

                                            </div>
                                        </div>

                                    </li>
                                    <?php
                                        }
                                    } else {
                                        echo "No assigned users found.";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title m-b-15">Project details</h6>
                                <table class="table table-striped table-border">
                                    <tbody>
                                        <?php
                                        // Fetch project details
                                        $sql = "SELECT * FROM projects WHERE id = :projectId";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
                                        $query->execute();
                                        $project = $query->fetch(PDO::FETCH_ASSOC);

                                        if ($project) {
                                            // Display project details
                                        ?>
                                        <tr>
                                            <td>Project Name:</td>
                                            <td class="text-right"><?php echo $project['ProjectName']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Price:</td>
                                            <td class="text-right">$<?php echo $project['Price']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Start Date:</td>
                                            <td class="text-right"><a><?php echo $project['StartDate']; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td>Deadline:</td>
                                            <td class="text-right"><?php echo $project['EndDate']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Priority:</td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <?php
                                                        $priorityClass = ['badge-danger', 'badge-primary', 'badge-success'];
                                                        $priorityLabels = ['High', 'Medium', 'Low'];
                                                        $priorityValues = [0, 1, 2]; // Change these values based on your requirement
                                                        for ($i = 0; $i < count($priorityLabels); $i++) {
                                                            // Use lowercase $i instead of $I in the condition
                                                            if ($project['Priority'] == $priorityValues[$i]) {
                                                                $isSelected = $project['Priority'] == $priorityValues[$i] ? 'active' : '';
                                                                echo '<a href="#" class="badge badge ' . $priorityClass[$i] . ' ' . $isSelected . '">' . $priorityLabels[$i] . '</a>';
                                                            }
                                                        }
                                                        ?>
                                                </div>
                                            </td>


                                        </tr>

                                        <tr>
                                            <td>Status:</td>

                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <?php
                                                        $priorityClass = ['badge-danger', 'badge-primary', 'badge-success', 'badge-info'];
                                                        $priorityLabels = ['Pending', 'In process', 'Finished', 'Start soon'];
                                                        $priorityValues = [0, 1, 2]; // Change these values based on your requirement
                                                        for ($i = 0; $i < count($priorityLabels); $i++) {
                                                            // Use lowercase $i instead of $I in the condition
                                                            if ($project['Status'] == $priorityValues[$i]) {
                                                                $isSelected = $project['Status	'] == $priorityValues[$i] ? 'active' : '';
                                                                echo '<a href="#" class="badge badge ' . $priorityClass[$i] . ' ' . $isSelected . '">' . $priorityLabels[$i] . '</a>';
                                                            }
                                                        }
                                                        ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        } else {
                                            echo "Project not found.";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <p class="m-b-5">Progress <span
                                        class="text-success float-right"><?php echo $project['CompletionPercentage']; ?>%</span>
                                </p>
                                <div class="progress progress-xs mb-0">
                                    <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip"
                                        title="<?php echo $project['CompletionPercentage']; ?>%"
                                        style="width: <?php echo $project['CompletionPercentage']; ?>%"></div>
                                </div>
                            </div>
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

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

</body>

</html>