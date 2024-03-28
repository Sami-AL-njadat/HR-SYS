<?php
if (isset($_POST['add_project'])) {
    $projectName = htmlspecialchars($_POST['projectName']);
    $clientId = htmlspecialchars($_POST['clientId']);
    $departmentId = htmlspecialchars($_POST['deparId']);
    $designationId = htmlspecialchars($_POST['desiId']);
    $projectLeaderId = htmlspecialchars($_POST['projectled']);
    $price = htmlspecialchars($_POST['price']);
    $status = htmlspecialchars($_POST['status']);
    $priority = htmlspecialchars($_POST['priority']);
    $completionPercentage = htmlspecialchars($_POST['percentage']);
    $startDate = htmlspecialchars($_POST['start_date']);
    $endDate = htmlspecialchars($_POST['end_date']);
    $description = htmlspecialchars($_POST['description']);

    try {
        // Handle file upload
        $filess = $_FILES['filess'];
        $file_name = $filess['name'];
        $file_tmp = $filess['tmp_name'];
        $file_error = $filess['error'];

        if ($file_error === 0) {
            $file_destination = 'files/' . $file_name;
            move_uploaded_file($file_tmp, $file_destination);
        } else {
            echo "<script>alert('Error uploading file.');</script>";
        }

        $sql = "INSERT INTO projects (ProjectName, ClientId, Status, ProjectLeaderId, designation_id, department_id, Priority, Price, CompletionPercentage, Description, StartDate, EndDate, Filees) 
                VALUES (:projectName, :clientId, :status, :projectLeaderId, :designationId, :departmentId, :priority, :price, :completionPercentage, :description, :startDate, :endDate, :filess)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':projectName', $projectName, PDO::PARAM_STR);
        $query->bindParam(':clientId', $clientId, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':projectLeaderId', $projectLeaderId, PDO::PARAM_INT);
        $query->bindParam(':designationId', $designationId, PDO::PARAM_INT);
        $query->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $query->bindParam(':priority', $priority, PDO::PARAM_INT);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':completionPercentage', $completionPercentage, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $query->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $query->bindParam(':filess', $file_destination, PDO::PARAM_STR);

        $query->execute();
        $lastInsertedProjectId = $dbh->lastInsertId();

        if ($lastInsertedProjectId) {
            $teamMembers = $_POST['teamMem'];
            foreach ($teamMembers as $employeeId) {
                $sql = "INSERT INTO teams (ProjectId, EmployeeId) VALUES (:projectId, :employeeId)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':projectId', $lastInsertedProjectId, PDO::PARAM_INT);
                $query->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
                $query->execute();
            }

            echo
            "<script>alert('project add successfully .');</script>";
            echo "<script>window.location.href='projects.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to add project.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif (isset($_POST['edit_project'])) {
    // Retrieve updated project details from form fields
    $projectId = $_POST['id'];
    $projectName = htmlspecialchars($_POST['projectName']);
    $clientId = htmlspecialchars($_POST['clientId']);
    $departmentId = htmlspecialchars($_POST['deparId']);
    $designationId = htmlspecialchars($_POST['desiId']);
    $projectLeaderId = htmlspecialchars($_POST['projectled']);
    $price = htmlspecialchars($_POST['price']);
    $status = htmlspecialchars($_POST['status']);
    $priority = htmlspecialchars($_POST['priority']);
    $completionPercentage = htmlspecialchars($_POST['percentage']);
    $startDate = htmlspecialchars($_POST['start_date']);
    $endDate = htmlspecialchars($_POST['end_date']);
    $description = htmlspecialchars($_POST['description']);

    // Retrieve updated team members from the form
    $updatedTeamMembers = isset($_POST['teamMem']) ? $_POST['teamMem'] : array();

    try {
        // Handle file upload if a new file is selected
        if (!empty($_FILES['filess']['name'])) {
            $filess = $_FILES['filess'];
            $file_name = $filess['name'];
            $file_tmp = $filess['tmp_name'];
            $file_error = $filess['error'];

            if ($file_error === 0) {
                $file_destination = 'files/' . $file_name;
                move_uploaded_file($file_tmp, $file_destination);
            } else {
                echo "<script>alert('File didn't upload.');</script>";
            }
        } else {
            // If no new file is selected, keep the existing file path in the database
            $file_destination = null; // Or retrieve the existing file path from the database
        }

        // Update project details in the database
        $sql = "UPDATE projects SET ProjectName = :projectName, ClientId = :clientId, Status = :status, ProjectLeaderId = :projectLeaderId, designation_id = :designationId, department_id = :departmentId, Priority = :priority, Price = :price, CompletionPercentage = :completionPercentage, Description = :description, StartDate = :startDate, EndDate = :endDate";

        // Add condition to update file path only if a new file is selected
        if (!empty($file_destination)) {
            $sql .= ", Filees = :filess";
        }

        $sql .= " WHERE id = :projectId";

        $query = $dbh->prepare($sql);
        $query->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $query->bindParam(':projectName', $projectName, PDO::PARAM_STR);
        $query->bindParam(':clientId', $clientId, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':projectLeaderId', $projectLeaderId, PDO::PARAM_INT);
        $query->bindParam(':designationId', $designationId, PDO::PARAM_INT);
        $query->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
        $query->bindParam(':priority', $priority, PDO::PARAM_INT);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':completionPercentage', $completionPercentage, PDO::PARAM_INT);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $query->bindParam(':endDate', $endDate, PDO::PARAM_STR);

        // Bind file parameter only if a new file is selected
        if (!empty($file_destination)) {
            $query->bindParam(':filess', $file_destination, PDO::PARAM_STR);
        }

        $query->execute();

        // Remove existing team members associated with the project
        $sqlDeleteTeam = "DELETE FROM teams WHERE ProjectId = :projectId";
        $queryDeleteTeam = $dbh->prepare($sqlDeleteTeam);
        $queryDeleteTeam->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $queryDeleteTeam->execute();

        // Add updated team members to the project
        foreach ($updatedTeamMembers as $employeeId) {
            $sqlAddTeamMember = "INSERT INTO teams (ProjectId, EmployeeId) VALUES (:projectId, :employeeId)";
            $queryAddTeamMember = $dbh->prepare($sqlAddTeamMember);
            $queryAddTeamMember->bindParam(':projectId', $projectId, PDO::PARAM_INT);
            $queryAddTeamMember->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
            $queryAddTeamMember->execute();
        }

        // Redirect user after successful update
        echo "<script>alert('Project updated successfully.');</script>";
        echo "<script>window.location.href='projects.php';</script>";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
