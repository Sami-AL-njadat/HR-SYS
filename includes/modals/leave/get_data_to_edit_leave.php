<?php

include_once('../../../includes/config.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (isset($_POST['id'])) {
        $leaveId = intval($_POST['id']);

        $sql = "SELECT * FROM leaves WHERE id = :leaveId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
        $query->execute();
        $leaveData = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode($leaveData);
    }
}
