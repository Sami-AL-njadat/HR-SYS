<?php
session_start();
error_reporting(0);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'smarthr');
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
include_once('includes/modals/projects/porject_function.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    // Check if the project ID is valid
    if ($rid > 0) {
        $sql = "DELETE FROM projects WHERE id=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_INT);
        if ($query->execute()) {
            echo "<script>alert('Project has been deleted');</script>";
        } else {
            echo "<script>alert('Failed to delete project');</script>";
        }
    } else {
        echo "<script>alert('Invalid project ID');</script>";
    }
    echo "<script>window.location.href ='projects.php'</script>";
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
    <title>Projects - HRMS admin template</title>

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

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="assets/plugins/summernote/dist/summernote-bs4.css">

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
                            <h3 class="page-title">Projects</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Projects</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_project"><i class="fa fa-plus"></i> Create Project</a>
                            <div class="view-icons">
                                <a href="projects.php" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->



                <div class="row">
                    <?php
                    $sql = "SELECT * FROM projects";
                    $query = $dbh->prepare($sql);
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

                            $open_tasks = 0; // Placeholder
                            $completed_tasks = 0; // Placeholder
                    ?>
                            <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">


                                                <a class="dropdown-item edit-project-btn" href="#" data-toggle="modal" data-target="#edit_project" data-id="<?php echo $project["id"]; ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>



                                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete_project" onclick="setProjToDelete(<?php echo $project['id']; ?>)"><i class="fa fa-trash-o m-r-5"></i>Delete</a>

                                            </div>
                                        </div>
                                        <h4 class="project-title"><a href="project-view.php?id=<?php echo $project['id']; ?>"><?php echo $project['ProjectName']; ?></a>
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
                                                    <a data-toggle="tooltip" title="<?php echo $projectLeader['FirstName'] . ' ' . $projectLeader['LastName']; ?>">
                                                        <img style="height: 100%;" alt="" src="employees/<?php echo $projectLeader['Picture']; ?>">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="project-members m-b-15">
                                            <div>Team :</div>
                                            <ul class="team-members">
                                                <?php foreach ($teamMembers as $teamMember) : ?>
                                                    <li>
                                                        <a href="#" data-toggle="tooltip" title="<?php echo $teamMember['FirstName'] . ' ' . $teamMember['LastName']; ?>">
                                                            <img style="height: 100%;" alt="" src="employees/<?php echo $teamMember['Picture']; ?>">
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                                <?php if ($totalTeamMembers > 5) : ?>
                                                    <li class="dropdown avatar-dropdown">
                                                        <a href="#" class="all-users dropdown-toggle" data-toggle="dropdown" aria-expanded="false">+<?php echo ($totalTeamMembers - 5); ?></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <div class="avatar-group">
                                                                <!-- Display additional team members -->
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <p class="m-b-5">Progress <span class="text-success float-right"><?php echo $project['CompletionPercentage']; ?>%</span>
                                        </p>
                                        <div class="progress progress-xs mb-0">
                                            <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="<?php echo $project['CompletionPercentage']; ?>%" style="width: <?php echo $project['CompletionPercentage']; ?>%"></div>
                                        </div>
                                        <a href="project-view.php?id=<?php echo $project['id']; ?>" class="btn btn-white btn-sm m-t-10">View Project</a>
                                    </div>
                                </div>

                            </div>
                    <?php
                        }
                    } ?>
                </div>


            </div>
            <!-- /Page Content -->

            <!-- Create Project Modal -->
            <?php include_once("includes/modals/projects/add.php"); ?>
            <!-- /Create Project Modal -->

            <!-- Edit Project Modal -->
            <?php include_once("includes/modals/projects/edit.php"); ?>
            <!-- /Edit Project Modal -->

            <!-- Delete Project Modal -->
            <?php include_once("includes/modals/projects/delete.php"); ?>
            <!-- /Delete Project Modal -->

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

    <!-- Summernote JS -->
    <script src="assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>


    <script>
        $(document).ready(function() {
            $('.edit-project-btn').click(function() {
                var projectId = $(this).data('id');
                $.ajax({
                    url: 'http://localhost/HR-SYS/includes/modals/projects/get_project_data.php',
                    type: 'POST',
                    data: {
                        id: projectId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#edit_project input[name="projectName"]').val(data.ProjectName);
                        $('#edit_project select[name="clientId"]').val(data.ClientId);
                        $('#edit_project select[name="deparId"]').val(data.department_id);
                        $('#edit_project select[name="desiId"]').val(data.designation_id);
                        $('#edit_project select[name="projectled"]').val(data.ProjectLeaderId);
                        $('#edit_project select[name="teamMem[]"]').val(data.TeamMembers);
                        $('#edit_project input[name="price"]').val(data.Price);
                        $('#edit_project select[name="status"]').val(data.Status);
                        $('#edit_project select[name="priority"]').val(data.Priority);
                        $('#edit_project input[name="percentage"]').val(data
                            .CompletionPercentage);
                        $('#edit_project input[name="start_date"]').val(data.StartDate);
                        $('#edit_project input[name="end_date"]').val(data.EndDate);
                        $('#edit_project textarea[name="description"]').val(data.Description);
                        $('#filess').change(function() {
                            var fileInput = $(this)[0]; // Get the file input element
                            if (fileInput.files.length > 0) {
                                var fileName = fileInput.files[0]
                                    .name; // Get the file name
                                $('#fileNameDisplay').text("Current File : " +
                                    fileName);
                            } else {
                                $('#fileNameDisplay').text("No file selected");
                            }
                        });
                        $('#edit_project input[name="id"]').val(projectId);


                        console.log(data, "all data ");
                    }
                });
            });
        });
    </script>

</body>

</html>