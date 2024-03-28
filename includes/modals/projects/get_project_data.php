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
    $projects_id = intval($_POST['id']);

    // Fetch project data
    $sql = "SELECT * FROM projects WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $projects_id, PDO::PARAM_INT);
    $query->execute();
    $projectsData = $query->fetch(PDO::FETCH_ASSOC);

    if ($projectsData) {
        // Fetch team members associated with the project
        $sql2 = "SELECT EmployeeId FROM teams WHERE ProjectId = :projectId";
        $query2 = $dbh->prepare($sql2);
        $query2->bindParam(':projectId', $projects_id, PDO::PARAM_INT);
        $query2->execute();
        $teamMembers = $query2->fetchAll(PDO::FETCH_COLUMN);

        // Add team members to the project data
        $projectsData['TeamMembers'] = $teamMembers;

        echo json_encode($projectsData);
    } else {
        echo json_encode(array());
    }
} else {
    echo json_encode(array());
}
