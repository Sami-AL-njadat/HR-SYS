	<?php
	session_start();
	error_reporting(0);
	include_once('includes/config.php');
	include_once("includes/functions.php");
	if (strlen($_SESSION['userlogin']) == 0) {
		header('location:login.php');
	} elseif (isset($_GET['delid'])) {
		$rid = intval($_GET['delid']);
		$sql = "DELETE from employees where id=:rid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':rid', $rid, PDO::PARAM_STR);
		$query->execute();
		echo "<script>alert('Employee Has Been Deleted');</script>";
		echo "<script>window.location.href ='employees.php'</script>";
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
	    <title>Employees - HRMS admin template</title>

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
	                            <h3 class="page-title">Employee</h3>
	                            <ul class="breadcrumb">
	                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
	                                <li class="breadcrumb-item active">Employee</li>
	                            </ul>
	                        </div>
	                        <div class="col-auto float-right ml-auto">
	                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i
	                                    class="fa fa-plus"></i> Add Employee</a>
	                            <div class="view-icons">
	                                <a href="employees.php" title="Grid View" class="grid-view btn btn-link active"><i
	                                        class="fa fa-th"></i></a>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /Page Header -->
	                <!-- Search Filter -->
	                <div class="row filter-row">

	                    <div class="col-sm-6 col-md-3">
	                        <div class="form-group form-focus select-focus">
	                            <select class="select floating select_designation select">
	                                <option value="">All Employee</option>
	                                <?php
									$sql = "SELECT * FROM designations";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									if ($query->rowCount() > 0) {
										foreach ($results as $row) {
									?>
	                                <option class="designation_e" value="<?php echo $row->Designation ?>">
	                                    <?php echo $row->Designation ?></option>
	                                <?php
										}
									}
									?>
	                            </select>
	                            <label class="focus-label">Designation</label>
	                        </div>
	                    </div>

	                </div>


	                <div class="row staff-grid-row">
	                    <?php
						$sql = "SELECT * FROM employees";
						$query = $dbh->prepare($sql);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);
						$cnt = 1;
						if ($query->rowCount() > 0) {
							foreach ($results as $row) {

						?>
	                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
	                        <div class="profile-widget">
	                            <div class="profile-img">
	                                <a href="profile.php?id=<?php echo ($row->id); ?>" class="avatar"><img
	                                        style="width: 80px;height: 80px;"
	                                        src="employees/<?php echo htmlentities($row->Picture); ?>" alt="picture"></a>
	                            </div>
	                            <div class="dropdown profile-action">
	                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
	                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
	                                <div class="dropdown-menu dropdown-menu-right">
	                                    <a class="dropdown-item edit-employee" href="#" data-toggle="modal"
	                                        data-target="#edit_employee" data-employeeid="<?php echo $row->Employee_Id; ?>"
	                                        data-firstname="<?php echo htmlentities($row->FirstName); ?>"
	                                        data-lastname="<?php echo htmlentities($row->LastName); ?>" data-designation="<?php echo htmlentities($row->Designation); ?>
												" data-picture="<?php echo htmlentities($row->Picture); ?>"
	                                        data-email="<?php echo htmlentities($row->Email); ?>"
	                                        data-phone="<?php echo htmlentities($row->Phone); ?>"
	                                        data-department="<?php echo htmlentities($row->Department); ?>"
	                                        data-designation="<?php echo htmlentities($row->Designation); ?>"
	                                        data-Picture="<?php echo htmlentities($row->Picture); ?>"
	                                        data-DateTime="<?php echo htmlentities($row->DateTime); ?>"
	                                        data-username="<?php echo htmlentities($row->UserName); ?>"
	                                        data-role="<?php echo htmlentities($row->role); ?>"
	                                        data-joiningdate="<?php echo ($row->Joining_Date) ?>"
	                                        data-id="<?php echo ($row->id); ?>"><i class="fa fa-pencil m-r-5"></i> Edit

	                                    </a>

	                                    <a href="#" class="dropdown-item" data-toggle="modal"
	                                        data-target="#delete_employee"
	                                        onclick="setEmployeeIdToDelete(<?php echo $row->id; ?>)"><i
	                                            class="fa fa-trash-o m-r-5"></i>Delete</a>


	                                </div>
	                            </div>
	                            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a
	                                    href="profile.php"><?php echo htmlentities($row->FirstName) . " " . htmlentities($row->LastName); ?></a>
	                            </h4>
	                            <div class="small text-muted"><?php echo htmlentities($row->Designation); ?></div>
	                        </div>
	                    </div>
	                    <?php $cnt += 1;
							}
						} ?>
	                </div>

	            </div>

	            <!-- /Page Content -->

	            <!-- Add Employee Modal -->
	            <?php include_once("includes/modals/employee/add_employee.php"); ?>
	            <!-- /Add Employee Modal -->

	            <!-- Edit Employee Modal -->
	            <?php include_once("includes/modals/employee/edit_employee.php"); ?>
	            <!-- /Edit Employee Modal -->

	            <!-- Delete Employee Modal -->
	            <?php include_once("includes/modals/employee/delete_employee.php"); ?>
	            <!-- /Delete Employee Modal -->

	        </div>
	        <!-- /Page Wrapper -->

	    </div>
	    <!-- /Main Wrapper -->

	    <!-- jQuery -->
	    <script src="assets/js/jquery-3.2.1.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
	        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
	        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	    <script>
	    window.onload = function() {
	        $('.select_designation').change(function() {
	            var designation_Name = $(this).val();
	            console.log(designation_Name, 'designation_Name');
	            $.ajax({
	                type: 'POST',
	                url: 'includes/partial/employeePartial.php',
	                data: {
	                    designationName: designation_Name
	                },
	                success: function(response) {
	                    $('.staff-grid-row').html(response);
	                }
	            });
	        });
	    };
	    </script>
	    <script>
	    $(document).ready(function() {

	        $('.edit-employee').click(function() {
	            var Employee_Id = $(this).data('employeeid');
	            var id = $(this).data('id');
	            console.log("id", id);
	            var firstName = $(this).data('firstname');
	            var lastName = $(this).data('lastname');
	            var designation = $(this).data('designation');
	            var Email = $(this).data('email');
	            var UserName = $(this).data('username');

	            var Phone = $(this).data('phone');
	            var role = $(this).data('role');
	            var picture = $(this).data('picture');
	            var Department = $(this).data('department');
	            var Joining_Date = $(this).data('joiningdate');
	            console.log('Joining_Date', role);


	            $('#edit_employee #employee_id').val(Employee_Id);
	            $('#edit_employee #first_name').val(firstName);
	            $('#edit_employee #last_name').val(lastName);
	            $('#edit_employee select[name="designation"]').val(designation);
	            $('#edit_employee #email_em').val(Email);
	            $('#edit_employee #Phone_e').val(Phone);
	            $('#edit_employee select[name="Department_e"] ').val(Department);
	            // $('#edit_employee #Joining_Date').val(Joining_Date);
	            $('#edit_employee #username').val(UserName);
	            $('#edit_employee select[name="role"] ').val(role);

	            $('.form-group select[name="Department_e"]').val(Department);
	            $(' input[name="joining_date"]').val(Joining_Date);
	            $(' input[name="emp_id"]').val(id);
	            $('.designation_e').each(function() {

	                if ($(this).html().replace(/\s/g, '') == designation.replace(/\s/g, '')) {

	                    $(this).prop('selected', true);
	                }
	            });



	            $.ajax({
	                url: 'http://localhost/HR-SYS/includes/modals/employee/savedatatosesion.php',

	                type: 'POST',
	                data: {

	                    department_e: Department,
	                    designation_e: designation,

	                },
	                success: function(response) {
	                    console.log(response);
	                    console.log('Data saved successfully in session.');
	                    // Handle success response if needed
	                },
	                error: function(xhr, status, error) {
	                    console.error('Error occurred:', error);
	                    // Handle error if needed
	                }
	            });
	        });
	    });
	    </script>
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

	    <!-- Custom JS -->
	    <script src="assets/js/app.js"></script>

	</body>

	</html>