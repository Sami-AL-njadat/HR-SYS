<?php
session_start();
error_reporting(0);
include('includes/config.php');


if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['addes'])) {
    $rid = intval($_GET['addes']);

    $sql = "SELECT salary_id FROM additionals WHERE id = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $salary_id = $row['salary_id'];

    // Delete from the additionals table
    $sql = "DELETE FROM additionals WHERE id = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->execute();

    // Fetch and update net salary from the salary table
    updateNetSalary($dbh, $salary_id);

    echo "<script>alert('additionals Has Been Deleted');</script>";
    echo "<script>window.location.href = 'payroll-items.php'</script>";
} elseif (isset($_GET['deductions'])) {
    $rid = intval($_GET['deductions']);

    // Fetch salary_id from the deductions table
    $sql = "SELECT salary_id FROM deductions WHERE id = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $salary_id = $row['salary_id'];

    // Delete from the deductions table
    $sql = "DELETE FROM deductions WHERE id = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->execute();

    // Fetch and update net salary from the salary table
    updateNetSalary($dbh, $salary_id);

    echo "<script>alert('Deduction has been deleted');</script>";
    echo "<script>window.location.href = 'payroll-items.php'</script>";
} elseif (isset($_GET['delids'])) {
    $salary_id = intval($_GET['delids']);

    // Delete associated additions
    $sql = "DELETE FROM additionals WHERE salary_id = :salary_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':salary_id', $salary_id, PDO::PARAM_INT);
    $query->execute();

    // Delete associated deductions
    $sql = "DELETE FROM deductions WHERE salary_id = :salary_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':salary_id', $salary_id, PDO::PARAM_INT);
    $query->execute();

    // Delete the salary itself
    $sql = "DELETE FROM salary WHERE id = :salary_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':salary_id', $salary_id, PDO::PARAM_INT);
    $query->execute();

    echo "<script>alert('Salary has been deleted');</script>";
    echo "<script>window.location.href = 'payroll-items.php'</script>";
}
function updateNetSalary($dbh, $salary_id)
{
    // Fetch the employee's current salary details from the salary table
    $sql = "SELECT basic_salary, tax, net_salary FROM salary WHERE id = :salary_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':salary_id', $salary_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $basic_salary = $row['basic_salary'];
    $tax = $row['tax'];

    // Calculate the current salary after tax
    $current_salary = $basic_salary - ($basic_salary * ($tax / 100));

    // Fetch the total additions for the employee from the additionals table
    $sql = "SELECT SUM(addition_value) AS total_additional 
            FROM additionals 
            WHERE salary_id = :salary_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':salary_id', $salary_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($row);
    $total_additional = $row['total_additional'];

    // Fetch total deductions for the employee from the deductions table
    $sql = "SELECT SUM(deduction_value) AS total_deduction 
            FROM deductions 
            WHERE salary_id = :salary_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':salary_id', $salary_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_deduction = $row['total_deduction'];

    // Calculate net salary
    $net_salary = $current_salary + $total_additional - $total_deduction;

    // Update the net salary in the salary table
    $sql = "UPDATE salary 
            SET net_salary = :net_salary 
            WHERE id = :salary_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':net_salary', $net_salary);
    $stmt->bindParam(':salary_id', $salary_id);
    $stmt->execute();
}

include_once('includes/modals/payroll/overtime/function_salary.php');

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
    <title>Payroll Items - HRMS admin template</title>

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
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php include_once("includes/header.php");


        ?>
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
                            <h3 class="page-title">Payroll Items</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Payroll Items</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Page Tab -->
                <div class="page-menu">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab_overtime">Salary</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-toggle="tab" href="#tab_additions">Additions</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab_deductions">Deductions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- Additions Tab -->
                    <div class="tab-pane show" id="tab_additions">
                        <!-- Add Addition Button -->
                        <div class="text-right mb-4 clearfix">
                            <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_addition"><i class="fa fa-plus"></i> Add Addition</button>
                        </div>
                        <!-- /Add Addition Button -->

                        <!-- Payroll Additions Table -->
                        <div class="payroll-table card">
                            <div class="table-responsive">
                                <table class="table table-hover table-radius">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Employee</th>
                                            <th>Value</th>
                                            <th>Reason</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT a.id, a.addition_name, a.addition_value, a.reason, e.FirstName, e.LastName
            FROM additionals a
            INNER JOIN salary s ON a.salary_id = s.id
            INNER JOIN employees e ON s.employee_id = e.id";
                                        $stmt = $dbh->prepare($sql);
                                        $stmt->execute();
                                        $additions_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($additions_data) {
                                            foreach ($additions_data as $addition) {
                                                // Fetched data successfully, now display it
                                                echo '<tr>';
                                                echo '<td>' . $addition['addition_name'] . '</td>';
                                                echo '<td>' . $addition['FirstName'] . ' ' . $addition['LastName'] . '</td>'; // Display employee's full name
                                                echo '<td>' . $addition['addition_value'] . '</td>';
                                                echo '<td>' . $addition['reason'] . '</td>';
                                                echo '<td class="text-right">';
                                                echo '<div class="dropdown dropdown-action">';
                                                echo '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>';
                                                echo '<div class="dropdown-menu dropdown-menu-right">';


                                                echo '<a class="dropdown-item edit-addition-btn" href="#" data-toggle="modal" data-target="#edit_addition" data-id="' . $addition['id'] . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                                                echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_addition"  onclick="setccToDelete(' . $addition['id'] . ')"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            // No data found
                                            echo '<tr>
                <td colspan="5">No data found</td>
            </tr>';
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>


                        <!-- /Payroll Additions Table -->
                    </div>

                    <!-- Additions Tab -->

                    <!-- Overtime Tab -->
                    <div class="tab-pane active" id="tab_overtime">

                        <!-- Add Overtime Button -->
                        <div class="text-right mb-4 clearfix">
                            <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Salary</button>
                        </div>
                        <!-- /Add Overtime Button -->

                        <!-- Payroll Overtime Table -->
                        <div class="payroll-table card">
                            <div class="table-responsive">
                                <table class="table table-hover table-radius">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Basic salary</th>
                                            <th>Tax %</th>
                                            <th>Current salary</th>
                                            <th>Net salary</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch data from the salary table
                                        $sql = "SELECT employees.FirstName, employees.LastName, salary.net_salary , salary.id,salary.basic_salary,salary.tax,salary.current_salary
            FROM salary 
            INNER JOIN employees ON salary.employee_id = employees.id";
                                        $query = $dbh->query($sql);
                                        $salaries = $query->fetchAll(PDO::FETCH_ASSOC);

                                        // Loop through the fetched data and populate the table rows
                                        foreach ($salaries as $salary) {
                                            echo "<tr>";
                                            echo "<td>" . $salary['FirstName'] . " " . $salary['LastName'] . "</td>";
                                            echo "<td>" . $salary['basic_salary'] . "</td>";
                                            echo "<td>" . $salary['tax'] . "</td>";
                                            echo "<td>" . $salary['current_salary'] . "</td>";

                                            echo "<td>" . $salary['net_salary'] . "</td>";
                                            echo "<td class='text-right'>
                <div class='dropdown dropdown-action'>
                    <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>
                        <i class='material-icons'>more_vert</i>
                    </a>
                    <div class='dropdown-menu dropdown-menu-right'>
                        <a class='dropdown-item edit-overtime-btn' href='#' data-toggle='modal' data-target='#edit_overtime' data-id='" . $salary['id'] . "'>
                            <i class='fa fa-pencil m-r-5'></i> Edit
                        </a>
                        <a class='dropdown-item' href='#' data-toggle='modal' data-target='#delete_overtime' onclick='setToDelete(" . $salary['id'] . ")'>
                            <i class='fa fa-trash-o m-r-5'></i> Delete
                        </a>
                    </div>
                </div>
            </td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <!-- /Payroll Overtime Table -->

                    </div>
                    <!-- /Overtime Tab -->

                    <!-- Deductions Tab -->
                    <div class="tab-pane" id="tab_deductions">

                        <!-- Add Deductions Button -->
                        <div class="text-right mb-4 clearfix">
                            <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_deduction"><i class="fa fa-plus"></i> Add Deduction</button>
                        </div>
                        <!-- /Add Deductions Button -->

                        <!-- Payroll Deduction Table -->
                        <div class="payroll-table card">
                            <div class="table-responsive">
                                <table class="table table-hover table-radius">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Employee</th>
                                            <th>Deduction Amount</th>
                                            <th>Reason</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        <?php
                                        // Fetch data for deductions
                                        $sql = "SELECT a.id, a.deduction_name, a.deduction_value, a.reason, e.FirstName, e.LastName
                                        FROM deductions a
                                        INNER JOIN salary s ON a.salary_id = s.id
                                        INNER JOIN employees e ON s.employee_id = e.id";
                                        $stmt = $dbh->prepare($sql);
                                        $stmt->execute();
                                        $deductions_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        if ($deductions_data) {
                                            foreach ($deductions_data as $deduction) {
                                                echo '<tr>';
                                                echo '<td>' . $deduction['deduction_name'] . '</td>';
                                                echo '<td>' . $deduction['FirstName'] . ' ' . $deduction['LastName'] . '</td>'; // Display employee's full name

                                                echo '<td>' . $deduction['deduction_value'] . '</td>';
                                                echo '<td>' . $deduction['reason'] . '</td>';
                                                echo '<td class="text-right">';
                                                echo '<div class="dropdown dropdown-action">';
                                                echo '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>';
                                                echo '<div class="dropdown-menu dropdown-menu-right">';

                                                echo '<a class="dropdown-item edit-deduction-btn" href="#" data-toggle="modal" data-target="#edit_deduction" data-id="' . $deduction['id'] . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                                                echo '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_deduction"  onclick="setToDelete(' . $deduction['id'] . ')"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';

                                                echo '</div>';
                                                echo '</div>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            // No data found
                                            echo '<tr><td colspan="3">No deductions found</td></tr>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /Payroll Deduction Table -->

                    </div>

                    <!-- /Deductions Tab -->

                </div>
                <!-- Tab Content -->

            </div>
            <!-- /Page Content -->

            <!-- Add Addition Modal -->
            <?php include_once("includes/modals/payroll/add_additions.php"); ?>
            <!-- /Add Addition Modal -->

            <!-- Edit Addition Modal -->
            <?php include_once("includes/modals/payroll/edit_additions.php"); ?>
            <!-- /Edit Addition Modal -->

            <!-- Delete Addition Modal -->
            <?php include_once("includes/modals/payroll/delete_additions.php"); ?>
            <!-- /Delete Addition Modal -->

            <!-- Add Overtime Modal -->
            <?php include_once("includes/modals/payroll/overtime/add.php"); ?>
            <!-- /Add Overtime Modal -->

            <!-- Edit Overtime Modal -->
            <?php include_once("includes/modals/payroll/overtime/edit.php"); ?>
            <!-- /Edit Overtime Modal -->

            <!-- Delete Overtime Modal -->
            <?php include_once("includes/modals/payroll/overtime/delete.php"); ?>
            <!-- /Delete Overtime Modal -->

            <!-- Add Deduction Modal -->
            <?php include_once("includes/modals/payroll/deduction/add.php"); ?>
            <!-- /Add Deduction Modal -->

            <!-- Edit Deduction Modal -->
            <?php include_once("includes/modals/payroll/deduction/edit.php"); ?>
            <!-- /Edit Addition Modal -->

            <!-- Delete Deduction Modal -->
            <?php include_once("includes/modals/payroll/deduction/delete.php"); ?>
            <!-- /Delete Deduction Modal -->

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

    <script>
        $(document).ready(function() {
            $('.edit-overtime-btn').click(function() {
                var salaryId = $(this).data('id');
                $.ajax({
                    url: 'http://localhost/HR-SYS/includes/modals/payroll/overtime/get_salary_data.php',
                    type: 'POST',
                    data: {
                        id: salaryId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#edit_overtime input[name="id"]').val(data.id);
                        $('#edit_overtime input[name="basic_salary"]').val(data.basic_salary);
                        $('#edit_overtime input[name="tax_rate"]').val(data.tax);
                        $('#edit_overtime input[name="month_year"]').val(data.month_year);

                        // Populate the select dropdown with the employee associated with the salary
                        $('#edit_overtime select[name="employee"]').val(data.employee_id);
                        console.log("ss", data);
                        $('#edit_overtime select[name="employee"]').val(data.employee_id);
                        $('#edit_overtime input[name="salaryid"]').val(data.salary_id);

                        console.log("ss", data);
                        console.log("ss", data.salary_id);

                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('.edit-addition-btn').click(function() {
                var slsId = $(this).data('id');
                $.ajax({
                    url: 'http://localhost/HR-SYS/includes/modals/payroll/get_sls_data.php',
                    type: 'POST',
                    data: {
                        id: slsId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#edit_addition select[name="employee"]').append('<option value="' +
                            data.employee_id + '" selected>' + data.FirstName + ' ' + data
                            .LastName + '</option>');
                        console.log(data.FirstName);
                        console.log("Data:", data);
                        console.log("FirstName:", data.FirstName);
                        console.log("LastName:", data.LastName);
                        console.log("Employee ID:", data.employee_id);
                        console.log("Employee ID:", data.salaryId);

                        $('#edit_addition input[name="addition_name"]').val(data.addition_name);
                        $('#edit_addition input[name="addition_value"]').val(data
                            .addition_value);
                        $('#edit_addition textarea[name="addition_reason"]').val(data.reason);
                        $('#edit_addition input[name="month_year"]').val(data.month_year);
                        $('#edit_addition input[name="id"]').val(data.id);
                        $('#edit_addition input[name="salaryid"]').val(data.salary_id);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.edit-deduction-btn').click(function() {
                var sldId = $(this).data('id');
                $.ajax({
                    url: 'http://localhost/HR-SYS/includes/modals/payroll/deduction/get_slsd_data.php',
                    type: 'POST',
                    data: {
                        id: sldId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#edit_deduction select[name="employee"]').append('<option value="' +
                            data.employee_id + '" selected>' + data.FirstName + ' ' + data
                            .LastName + '</option>');
                        console.log(data.FirstName);
                        console.log("Data:", data);
                        console.log("FirstName:", data.FirstName);
                        console.log("LastName:", data.LastName);
                        console.log("Employee ID:", data.employee_id);
                        $(document).ready(function() {
                            $('.edit-deduction-btn').click(function() {
                                var sldIds = $(this).data('id');
                                $.ajax({
                                    url: 'http://localhost/HR-SYS/includes/modals/payroll/deduction/get_slsd_data.php',
                                    type: 'POST',
                                    data: {
                                        id: sldIds

                                    },
                                    success: function(response) {
                                        var data = JSON.parse(response);
                                        $('#edit_deduction select[name="employee"]').append('<option value="' +
                                            data.employee_id + '" selected>' + data.FirstName + ' ' + data
                                            .LastName + '</option>');
                                        console.log(data.FirstName);
                                        console.log("Data:", data);
                                        console.log("FirstName:", data.FirstName);
                                        console.log("LastName:", data.LastName);
                                        console.log("Employee ID:", data.salaryId);

                                        $('#edit_deduction input[name="deduction_name"]').val(data
                                            .deduction_name);
                                        $('#edit_deduction input[name="deduction_value"]').val(data
                                            .deduction_value);
                                        $('#edit_deduction textarea[name="deduction_reason"]').val(data.reason);
                                        $('#edit_deduction input[name="month_year"]').val(data.month_year);
                                        $('#edit_deduction input[name="id"]').val(data.id);
                                    }
                                });
                            });
                        });
                        $('#edit_deduction input[name="deduction_name"]').val(data
                            .deduction_name);
                        $('#edit_deduction input[name="deduction_value"]').val(data
                            .deduction_value);
                        $('#edit_deduction textarea[name="deduction_reason"]').val(data.reason);
                        $('#edit_deduction input[name="month_year"]').val(data.month_year);
                        $('#edit_deduction input[name="id"]').val(data.id);
                        $('#edit_deduction input[name="salaryid"]').val(data.salary_id);

                        console.log("Employee ID:", data.salary_id);


                    }
                });
            });
        });
    </script>

</body>

</html>