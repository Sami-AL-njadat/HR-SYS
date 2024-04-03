<?php
session_start();
error_reporting(0);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'smarthr');
// Establish database connection.
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
// include('includes/config.php');
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_POST['profile_info'])) {
    if (isset($_FILES['profile_picture'])) {
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_type = $_FILES['profile_picture']['type'];

        $upload_directory = "employees/";

        move_uploaded_file($file_tmp, $upload_directory . $file_name);

        $employee_id = $_POST['id'];
        $new_profile_picture_path = $file_name;

        $stmt = $dbh->prepare("UPDATE employees SET Picture = :Picture WHERE id = :id");
        $stmt->bindParam(':Picture', $new_profile_picture_path);
        $stmt->bindParam(':id', $employee_id);
        $stmt->execute();

        $_SESSION['Picture'] = $new_profile_picture_path;
    }
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
    <title>Employee Profile - HRMS admin template</title>

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

    <!-- Tagsinput CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

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
                            <h3 class="page-title">Profile</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <?php
                if (isset($_GET['id'])) {
                    $employeeid = $_GET['id'];
                } else {
                    $employeeid = $_SESSION['employeeid'];
                }
                $sql = "SELECT * from employees WHERE id = :employeeid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':employeeid', $employeeid, PDO::PARAM_INT);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                $Dep = $result->Department;
                $Des = $result->Designation;




                ?>
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-img-wrap">
                                        <div class="profile-img">
                                            <a href="#"><img alt="" src="employees/<?php echo ($result->Picture); ?>"></a>
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <h3 class="user-name m-t-0 mb-0"><?php
                                                                                        if (isset($_GET['id'])) {
                                                                                            echo $result->FirstName . " " . $result->LastName;
                                                                                        } else {
                                                                                            echo $_SESSION['FirstName'] . " " . $_SESSION['LastName'];
                                                                                        }

                                                                                        ?>
                                                    </h3>
                                                    <h6 class="text-muted">Department: <?php echo ($Dep) ?></h6>
                                                    <small class="text-muted">Designation: <?php echo ($Des) ?></small>
                                                    <div class="staff-id">Employee ID:
                                                        <?php echo $result->Employee_Id; ?></div>
                                                    <div class="small doj text-muted">Date of Join:
                                                        <?php echo $result->Joining_Date; ?></div>


                                                    <div class="staff-id">Phone: <?php echo $result->Phone; ?></div>



                                                    <div class="staff-id">Email: <?php echo $result->Email; ?></div>




                                                    <!-- <div class="staff-msg"><a class="btn btn-custom" href="chat.php">Send Message</a></div> -->
                                                </div>
                                            </div>
                                            <div class="col-md-7">

                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <h2>Check Your Salary</h2>
                                                            <form id="salaryForm">
                                                                <div class="form-group">
                                                                    <label for="year">Year:</label>
                                                                    <input placeholder="Enter The Year AS Number" type="text" class="form-control" id="year" name="year">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="month">Month:</label>
                                                                    <input placeholder="Enter The Month AS Number" type="text" class="form-control" id="month" name="month">
                                                                </div>
                                                                <input type="hidden" name="id" value="<?php echo $_SESSION['employeeid']; ?>">
                                                                <button type="button" class="btn btn-primary" id="fetchSalary">Your Net
                                                                    Salary</button>
                                                            </form>
                                                            <div id="salaryResult" class="mt-3"></div>
                                                        </div>
                                                        <div id="salaryResult"></div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card tab-box">
                    <div class="row user-tabs">
                        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                            <!-- <ul class="nav nav-tabs nav-tabs-bottom">
								<li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a></li>
								<li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
								<li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory <small class="text-danger">(Admin Only)</small></a></li>
							</ul> -->

                        </div>
                    </div>
                </div>

                <div class="tab-content">

                    <!-- Profile Info Tab -->

                    <!-- /Profile Info Tab -->

                    <!-- Projects Tab -->
                    <?php
                    // $employeeid = $_SESSION['employeeid'];
                    $sql = "SELECT teams.ProjectId, projects.* FROM teams 
					INNER JOIN projects ON teams.ProjectId = projects.id 
					WHERE teams.EmployeeId = :employeeid";;
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':employeeid', $employeeid, PDO::PARAM_INT);
                    $query->execute();
                    $resultofproject = $query->fetchAll(PDO::FETCH_ASSOC);;






                    ?>
                    <div class="row">
                        <?php
                        if ($query->rowCount() > 0) {
                            foreach ($resultofproject as $project) {
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
                                                <!-- <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>	 -->
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
                                                            <a href="#" data-toggle="tooltip" title="<?php echo $teamMember['FirstName'] . ' ' . $teamMember['LastName']; ?>">
                                                                <img alt="" src="employees/<?php echo $teamMember['Picture']; ?>">
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
                    <!-- /Projects Tab -->

                    <!-- Bank Statutory Tab -->

                    <!-- /Bank Statutory Tab -->

                </div>
            </div>



            <!-- /Page Content -->

            <!-- Profile sssssssssss Modal -->
            <div id="profile_info" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Profile picture</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="profile-img-wrap edit-img">
                                            <div class="fileupload btn">

                                                <label class="btn-picture">Edit </label>
                                                <input class="upload" type="file" name="profile_picture">


                                            </div>

                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $_SESSION['employeeid']; ?>">
                                        <div class="submit-section">
                                            <button class="btn btn-primary submit-btn" type="submit" name="profile_info">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /Profile Modal -->

            <!-- Personal Info Modal -->

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

    <!-- Tagsinput JS -->
    <script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            $('#fetchSalary').click(function() {
                var year = $('#year').val();
                var month = $('#month').val();

                // AJAX request
                $.ajax({
                    url: 'http://localhost/HR-SYS/includes/modals/get_www_data.php',
                    type: 'post',
                    data: {
                        year: year,
                        month: month
                    },
                    success: function(response) {
                        $('#salaryResult').html(response);
                    }
                });
            });
        });
    </script>

</body>

</html>