<?php



//adding of goal types stats here
if (isset($_POST['add_goal_type'])) {
    $type = htmlspecialchars($_POST['type']);
    $description = htmlspecialchars($_POST['description']);
    $status = htmlspecialchars($_POST['status']);
    $sql = "INSERT INTO `goal_type` ( `Type`, `Description`, `Status`) 
		VALUES (:type, :description, :status)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':type', $type, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    $lastinserted = $dbh->lastInsertId();
    if ($lastinserted > 0) {
        echo "<script>alert('Goal Type Has Been Added');</script>";
        echo "<script>window.location.href='goal-type.php';</script>";
    } else {
        echo "<script>alert('Something Went Wrong.Re-check goal type may already exist');</script>";
    }
}
//goal type adding code ends here.


//editing of goal types stats here

elseif (isset($_POST['edit_type'])) {
    $type = htmlspecialchars($_POST['type']);
    $description = htmlspecialchars($_POST['description']);
    $status = htmlspecialchars($_POST['status']);
    $id = htmlspecialchars($_POST['id']); // Get the ID of the goal type

    $sql = "UPDATE `goal_type` SET `Type` = :type, `Description` = :description, `Status` = :status WHERE `id` = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':type', $type, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_INT); // Bind the ID parameter
    $query->execute();

    if ($query->rowCount() > 0) {
        echo "<script>alert('Goal Type Has Been Updated');</script>";
        echo "<script>window.location.href='goal-type.php';</script>";
    } else {
        echo "<script>alert('Failed to Update Goal Type');</script>";
    }
}


//editing type adding code ends here.