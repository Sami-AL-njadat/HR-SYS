<?php

include_once('../../../includes/config.php');
if (isset($_POST['status'])) {
    $rid = intval($_POST['id']);
    if ($_POST['status'] == 'Active') {
        $sql = "UPDATE employees SET role = 2 WHERE id = :rid";
    } else {
        $sql = "UPDATE employees SET role = 1 WHERE id = :rid";
    }
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
}
