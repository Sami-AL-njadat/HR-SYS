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
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
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
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
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
								<?php
								$sql = "SELECT * FROM projects WHERE id = :projectId";
								$query = $dbh->prepare($sql);
								$query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
								$query->execute();
								$project = $query->fetch(PDO::FETCH_ASSOC);

								// Check if project exists
								if ($project) {
								?>
									<div class="project-title">
										<h5 class="card-title"><?php echo $project['ProjectName']; ?></h5>
									</div>
									<p><?php echo $project['Description']; ?></p>
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
													<span class="file-name text-ellipsis"><a href="<?php echo $file_path; ?>" target="_blank">Download File</a></span>
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

					</div>
					<div class="col-lg-4 col-xl-3">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title m-b-15">Project details</h6>
								<table class="table table-striped table-border">
									<tbody>
										<tr>
											<td>Cost:</td>
											<td class="text-right">$1200</td>
										</tr>


										<tr>
											<td>Deadline:</td>
											<td class="text-right">12 Jun, 2019</td>
										</tr>
										<tr>
											<td>Priority:</td>
											<td class="text-right">
												<div class="btn-group">
													<a href="#" class="badge badge-danger dropdown-toggle" data-toggle="dropdown">Highest </a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Highest
															priority</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> High
															priority</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-primary"></i> Normal
															priority</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Low
															priority</a>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td>Created by:</td>
											<td class="text-right"><a href="profile.php">Barry Cuda</a></td>
										</tr>
										<tr>
											<td>Status:</td>
											<td class="text-right">Working</td>
										</tr>
									</tbody>
								</table>
								<p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
								<div class="progress progress-xs mb-0">
									<div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: 40%"></div>
								</div>
							</div>
						</div>
						<div class="card project-user">
							<div class="card-body">
								<h6 class="card-title m-b-20">Assigned Leader </h6>
								<ul class="list-box">
									<li>
										<a href="profile.php">
											<div class="list-item">
												<div class="list-left">
													<span class="avatar"><img alt="" src="assets/img/profiles/avatar-11.jpg"></span>
												</div>
												<div class="list-body">
													<span class="message-author">Wilmer Deluna</span>
													<div class="clearfix"></div>
													<span class="message-content">Team Leader</span>
												</div>
											</div>
										</a>
									</li>
									<li>
										<a href="profile.php">
											<div class="list-item">
												<div class="list-left">
													<span class="avatar"><img alt="" src="assets/img/profiles/avatar-01.jpg"></span>
												</div>
												<div class="list-body">
													<span class="message-author">Lesley Grauer</span>
													<div class="clearfix"></div>
													<span class="message-content">Team Leader</span>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="card project-user">
							<div class="card-body">
								<h6 class="card-title m-b-20">
									Assigned users

								</h6>
								<ul class="list-box">
									<li>
										<a href="profile.php">
											<div class="list-item">
												<div class="list-left">
													<span class="avatar"><img alt="" src="assets/img/profiles/avatar-02.jpg"></span>
												</div>
												<div class="list-body">
													<span class="message-author">John Doe</span>
													<div class="clearfix"></div>
													<span class="message-content">Web Designer</span>
												</div>
											</div>
										</a>
									</li>
									<li>
										<a href="profile.php">
											<div class="list-item">
												<div class="list-left">
													<span class="avatar"><img alt="" src="assets/img/profiles/avatar-09.jpg"></span>
												</div>
												<div class="list-body">
													<span class="message-author">Richard Miles</span>
													<div class="clearfix"></div>
													<span class="message-content">Web Developer</span>
												</div>
											</div>
										</a>
									</li>
								</ul>
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

	<!-- Task JS -->
	<script src="assets/js/task.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>

</body>

</html>

</html>