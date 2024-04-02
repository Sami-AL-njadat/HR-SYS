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
    $deductionsIdId = intval($_POST['id']);

    $sql = "SELECT a.*, s.employee_id, e.FirstName, e.LastName
            FROM deductions a
            INNER JOIN salary s ON a.salary_id = s.id
            INNER JOIN employees e ON s.employee_id = e.id
            WHERE a.id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $deductionsIdId, PDO::PARAM_INT);
    $query->execute();
    $deductionsIdData = $query->fetch(PDO::FETCH_ASSOC);

    if ($deductionsIdData) {
        echo json_encode($deductionsIdData);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}