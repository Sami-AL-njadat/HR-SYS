<?php

include_once('../../../includes/config.php');
if (isset($_POST['add_overtime'])) {
    $employee = htmlspecialchars($_POST['employee']);
    $ovtime_date = htmlspecialchars($_POST['ov_date']);
    $overtime_hours = htmlspecialchars($_POST['ov_hours']);
    $overtime_type = htmlspecialchars($_POST['ov_type']);
    $description = htmlspecialchars($_POST['description']);
    $sql = "INSERT INTO `overtime` ( `Employee`, `OverTime_Date`, `Hours`, `Type`, `Description`) 
		VALUES ( :name, :date, :hours,:type, :description)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $employee, PDO::PARAM_STR);
    $query->bindParam(':date', $ovtime_date, PDO::PARAM_STR);
    $query->bindParam(':hours', $overtime_hours, PDO::PARAM_STR);
    $query->bindParam(':type', $overtime_type, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->execute();
    $lastInsert = $dbh->lastInsertId();
    if ($lastInsert > 0) {
        echo "<script>alert('Employee Overtime Has Been Added');</script>";
        echo "<script>window.location.href='/HR-SYS/overtime.php';</script>";
    } else {
        echo "<script>alert('Somthing Went Wrong');</script>";
    }
} elseif (isset($_POST['EDITovertime'])) {
    $employee = htmlspecialchars($_POST['employee']);
    $rid = htmlspecialchars($_POST['overtimeid']);
    $ovtime_date = htmlspecialchars($_POST['ov_date']);
    $overtime_hours = htmlspecialchars($_POST['ov_hours']);
    $overtime_type = htmlspecialchars($_POST['ov_type']);
    $description = htmlspecialchars($_POST['description']);
    $sql = "UPDATE overtime  
    SET Employee=:employee, 
        OverTime_Date=:ovtime_date, 
        Hours=:overtime_hours, 
        Description=:description,
        Type=:overtime_type
    WHERE id=:rid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->bindParam(':employee', $employee, PDO::PARAM_STR);
    $query->bindParam(':ovtime_date', $ovtime_date, PDO::PARAM_STR);
    $query->bindParam(':overtime_hours', $overtime_hours, PDO::PARAM_STR);
    $query->bindParam(':overtime_type', $overtime_type, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->execute();


    echo "<script>alert('Employee Overtime Has Been Update');</script>";
    echo "<script>window.location.href='/HR-SYS/overtime.php';</script>";
} elseif (isset($_POST['editid'])) {
    $overtimeid = intval($_POST['editid']);

    $sql = "SELECT * FROM overtime WHERE id = :overtimeid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':overtimeid', $overtimeid, PDO::PARAM_INT);
    $query->execute();
    $overtimedata = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode($overtimedata);
}
