<?php

include_once('../../../includes/config.php');
if (isset($_POST['status'])) {
    $rid = intval($_POST['id']);
    if ($_POST['status'] == 'Approved') {
        $sql = "UPDATE leaves SET status = 1 WHERE id = :rid";
    } else if ($_POST['status'] == 'Reject') {
        $sql = "UPDATE leaves SET status =2  WHERE id = :rid";
    } else {
        $sql = "UPDATE leaves SET status =0  WHERE id = :rid";
    }
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
}
