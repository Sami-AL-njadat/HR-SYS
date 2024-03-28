<?php
session_start();

include("includes/config.php");

if (isset($_POST['logoutandsave'])) {
    $Projectid = $_POST['project'];
    $Description = $_POST['description'];
    $current_datetime = date('Y-m-d H:i:s');
    $end_datetime = date('Y-m-d H:i:s', strtotime($current_datetime . ' +2 hours'));
    $userid = $_SESSION['userid'];

    $sql = "UPDATE timesheet 
    SET end = :end_datetime, 
        projectId = :project, 
        description = :Description 
    WHERE id = (SELECT MAX(id) FROM timesheet WHERE employeeId = :userid)";


    $query = $dbh->prepare($sql);
    $query->bindParam(':end_datetime', $end_datetime, PDO::PARAM_STR);
    $query->bindParam(':project', $Projectid, PDO::PARAM_STR);
    $query->bindParam(':Description', $Description, PDO::PARAM_STR);
    $query->bindParam(':userid', $userid, PDO::PARAM_STR);

    $query->execute();

    session_destroy();

    header("location: login.php");
    exit();
}
