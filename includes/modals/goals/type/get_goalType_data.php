<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'smarthr');

try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

if (isset($_POST['id'])) {
    $goaltyId = intval($_POST['id']);

    $sql = "SELECT * FROM goal_type WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $goaltyId, PDO::PARAM_INT);
    $query->execute();
    $gtData = $query->fetch(PDO::FETCH_ASSOC);

    if ($gtData) {
        echo json_encode($gtData);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}
