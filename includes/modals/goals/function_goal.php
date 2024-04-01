<?php

if (isset($_POST['add_goals'])) {
    try {
        $types = htmlspecialchars($_POST['goal']);
        $subjects = htmlspecialchars($_POST['subject']);
        $targets = htmlspecialchars($_POST['target']);
        $starts = htmlspecialchars($_POST['start_date']);
        $ends = htmlspecialchars($_POST['end_date']);
        $descriptions = htmlspecialchars($_POST['description']);
        $statuss = htmlspecialchars($_POST['status']);
        $progress = htmlspecialchars($_POST['progress']);

        $sql = "INSERT INTO `goals` (`goal_typeId`, `Subject`, `Target`, `StartDate`, `EndDate`, `Description`, `Status`, `Progress`) 
            VALUES (:types, :subjects, :targets, :starts, :ends, :descriptions, :statuss, :progress)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':types', $types, PDO::PARAM_STR);
        $query->bindParam(':subjects', $subjects, PDO::PARAM_STR);
        $query->bindParam(':targets', $targets, PDO::PARAM_STR);
        $query->bindParam(':starts', $starts, PDO::PARAM_STR);
        $query->bindParam(':ends', $ends, PDO::PARAM_STR);
        $query->bindParam(':descriptions', $descriptions, PDO::PARAM_STR);
        $query->bindParam(':statuss', $statuss, PDO::PARAM_INT); // Assuming status is an integer
        $query->bindParam(':progress', $progress, PDO::PARAM_INT); // Assuming progress is an integer
        $query->execute();

        $lastinserted = $dbh->lastInsertId();
        if ($lastinserted > 0) {
            echo "<script>alert('Goal Has Been Added');</script>";
            echo "<script>window.location.href='goal-tracking.php';</script>";
        } else {
            echo "<script>alert('Failed to add goal');</script>";
            echo "<script>window.location.href='goal-tracking.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif (isset($_POST['edit_goal'])) {
    try {
        $id = $_POST['id']; // Assuming id is sent via POST
        $types = htmlspecialchars($_POST['goal']);
        $subjects = htmlspecialchars($_POST['subject']);
        $targets = htmlspecialchars($_POST['target']);
        $starts = htmlspecialchars($_POST['start_date']);
        $ends = htmlspecialchars($_POST['end_date']);
        $descriptions = htmlspecialchars($_POST['description']);
        $statuss = htmlspecialchars($_POST['status']);
        $progress = htmlspecialchars($_POST['progress']);

        $sql = "UPDATE `goals` SET 
                    `goal_typeId` = :types, 
                    `Subject` = :subjects, 
                    `Target` = :targets, 
                    `StartDate` = :starts, 
                    `EndDate` = :ends, 
                    `Description` = :descriptions, 
                    `Status` = :statuss, 
                    `Progress` = :progress 
                WHERE 
                    `id` = :id";

        $query = $dbh->prepare($sql);
        $query->bindParam(':types', $types, PDO::PARAM_STR);
        $query->bindParam(':subjects', $subjects, PDO::PARAM_STR);
        $query->bindParam(':targets', $targets, PDO::PARAM_STR);
        $query->bindParam(':starts', $starts, PDO::PARAM_STR);
        $query->bindParam(':ends', $ends, PDO::PARAM_STR);
        $query->bindParam(':descriptions', $descriptions, PDO::PARAM_STR);
        $query->bindParam(':statuss', $statuss, PDO::PARAM_INT); // Assuming status is an integer
        $query->bindParam(':progress', $progress, PDO::PARAM_INT); // Assuming progress is an integer
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $affected_rows = $query->rowCount();
        if ($affected_rows > 0) {
            echo "<script>alert('Goal has been updated');</script>";
            echo "<script>window.location.href='goal-tracking.php';</script>";
        } else {
            echo "<script>alert('Failed to update goal');</script>";
            echo "<script>window.location.href='goal-tracking.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
