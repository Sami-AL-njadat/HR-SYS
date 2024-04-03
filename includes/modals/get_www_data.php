<?php
// Assuming you have already established a database connection
session_start();
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'smarthr');
try {
    $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

$employee_id = $_SESSION['employeeid'];

$year = $_POST['year'];
$month = $_POST['month'];

$stmt = $dbh->prepare("SELECT net_salary FROM salary WHERE employee_id = :employee_id AND YEAR(month_year) = :year AND MONTH(month_year) = :month");
$stmt->bindParam(':employee_id', $employee_id);
$stmt->bindParam(':year', $year);
$stmt->bindParam(':month', $month);
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_OBJ);

if ($result) {
    $net_salary = $result->net_salary;
    echo "Net salary for $month $year is: $net_salary JOD";
} else {
    $stmt = $dbh->prepare("SELECT COUNT(*) AS count FROM salary WHERE employee_id = :employee_id AND YEAR(month_year) = :year");
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $salary_count = $stmt->fetchColumn();

    if ($salary_count > 0) {
        echo "Your salary for $month $year is not available yet.";
    } else {
        echo "Your salary for $year has not been created yet.";
    }
}
