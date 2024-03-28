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
    $clientId = intval($_POST['id']);

    $sql = "SELECT * FROM clients WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $clientId, PDO::PARAM_INT);
    $query->execute();
    $clientData = $query->fetch(PDO::FETCH_ASSOC);

    if ($clientData) {
        echo json_encode($clientData);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}
