<?php
session_start();

// session_unset("department_e");
// session_unset("designation_e");
// Check if department_e is set in the POST data
if (isset($_POST['department_e'])) {
    $department = $_POST['department_e'];
    $_SESSION['department_e'] = $department;
    $designation = $_POST['designation_e'];
    $_SESSION['designation_e'] = $designation;
    echo  $_SESSION['department_e'];
    echo  $_SESSION['designation_e'];
    echo "Data saved successfully in session.";
} else {
    echo "Error: department_e not received in POST data.";
}
