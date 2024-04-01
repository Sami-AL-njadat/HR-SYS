<?php
include_once('../../../includes/config.php');

if (isset($_POST['timesheetedit'])) {
    $rid = intval($_POST['timesheetid']);
    $Start = htmlspecialchars($_POST['Start']);
    $End = htmlspecialchars($_POST['End']);
    $Description = htmlspecialchars($_POST['description']);
    $ProjectId = htmlspecialchars($_POST['projectid']);

    $sql = "UPDATE timesheet SET  	projectId = :ProjectId, description = :Description WHERE id = :rid";

    $query = $dbh->prepare($sql);

    $query->bindParam(':rid', $rid, PDO::PARAM_INT);
    $query->bindParam(':Description', $Description, PDO::PARAM_STR);
    $query->bindParam(':ProjectId', $ProjectId, PDO::PARAM_INT);

    $query->execute();

    if ($query) {
        echo "<script>alert('Time Sheet  Has Been Updated');</script>";
        echo "<script>window.location.href ='/HR-SYS/timesheet.php'</script>";
    } else {
        echo "<script>alert('Error updating timesheet');</script>";
    }
} elseif (isset($_POST['editid'])) {
    $Timesheetid = intval($_POST['editid']);

    $sql = "SELECT * FROM timesheet WHERE id = :Timesheetid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':Timesheetid', $Timesheetid, PDO::PARAM_INT);
    $query->execute();
    $TimesheetData = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode($TimesheetData);
}
