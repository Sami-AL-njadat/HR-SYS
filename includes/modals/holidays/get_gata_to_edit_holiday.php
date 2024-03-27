<?php

include_once('../../../includes/config.php');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if (isset($_POST['id'])) {
        $holidayId = intval($_POST['id']);

        $sql = "SELECT * FROM holidays WHERE id = :holidayId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':holidayId', $holidayId, PDO::PARAM_INT);
        $query->execute();
        $holidayData = $query->fetch(PDO::FETCH_ASSOC);

        echo json_encode($holidayData);
    }
}
