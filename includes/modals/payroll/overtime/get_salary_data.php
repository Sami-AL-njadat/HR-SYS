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
    $salaryId = intval($_POST['id']);

    $sql = "SELECT * FROM salary WHERE id = :id"; // corrected the variable name here
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $salaryId, PDO::PARAM_INT); // corrected the variable name here
    $query->execute();
    $salaryData = $query->fetch(PDO::FETCH_ASSOC);

    if ($salaryData) {
        echo json_encode($salaryData);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}
