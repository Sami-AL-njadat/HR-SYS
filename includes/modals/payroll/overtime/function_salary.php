<?php



if (isset($_POST['add_salary'])) {
    $basic_salary = $_POST['basic_salary'];
    $tax_rate = $_POST['tax_rate'];
    $month_year = $_POST['month_year'];

    $current_salary = $basic_salary - ($basic_salary * ($tax_rate / 100));

    // Check if all employees are selected
    if (isset($_POST['select_all']) && $_POST['select_all'] == 'on') {
        $employee_ids = array_column($employees, 'id');
    } else {
        $employee_ids = isset($_POST['employee']) ? $_POST['employee'] : [];
    }

    $additions = []; // Example additional amounts
    $deductions = []; // Example deduction amounts

    $total_additions = array_sum($additions);
    $total_deductions = array_sum($deductions);

    // Calculate net salary
    $net_salary = $current_salary + $total_additions - $total_deductions;

    // Insert salary records for each selected employee
    $successfulInserts = 0;

    foreach ($employee_ids as $employee_id) {
        $sql = "INSERT INTO salary (employee_id, basic_salary, tax, current_salary, net_salary, month_year) 
            VALUES (:employee_id, :basic_salary, :tax_rate, :current_salary, :net_salary, :month_year)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':basic_salary', $basic_salary);
        $stmt->bindParam(':tax_rate', $tax_rate);
        $stmt->bindParam(':current_salary', $current_salary);
        $stmt->bindParam(':net_salary', $net_salary);
        $stmt->bindParam(':month_year', $month_year);

        if ($stmt->execute()) {
            $successfulInserts++;
        }
    }

    if ($successfulInserts > 0) {
        echo "<script>alert('Successfully added salaries for " . $successfulInserts . " employees.');</script>";
    } else {
        echo "<script>alert('Error adding salaries.');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    }


    echo "<script>window.location.href='payroll-items.php';</script>";
}


// Check if the form is submitted
// Check if the form is submitted
elseif (isset($_POST['add_addition'])) {
    $employee_ids = $_POST['employees']; // Get selected employee IDs
    $addition_name = $_POST['addition_name'];
    $addition_value = $_POST['addition_value'];
    $addition_reason = $_POST['addition_reason'];
    $month_year = $_POST['month_year'];

    // Loop through selected employees
    foreach ($employee_ids as $employee_id) {
        // Insert addition for each employee into the database
        $sql = "INSERT INTO additionals (salary_id, addition_name, addition_value, reason, month_year) 
                VALUES (:salary_id, :addition_name, :addition_value, :addition_reason, :month_year)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id); // Assuming salary_id is equivalent to employee_id
        $stmt->bindParam(':addition_name', $addition_name);
        $stmt->bindParam(':addition_value', $addition_value);
        $stmt->bindParam(':addition_reason', $addition_reason);
        $stmt->bindParam(':month_year', $month_year);
        $stmt->execute();
        // Fetch the employee's current salary details from the salary table
        $sql = "SELECT basic_salary, tax, net_salary FROM salary WHERE id = :salary_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $basic_salary = $row['basic_salary'];
        $tax = $row['tax'];
        $current_net_salary = $row['net_salary']; // Get the current net salary

        // Calculate the current salary after tax
        $current_salary = $basic_salary - ($basic_salary * ($tax / 100));

        // Fetch the total additions for the employee from the additionals table
        // Fetch total deductions
        $sql = "SELECT SUM(deduction_value) AS total_deduction 
            FROM deductions 
            WHERE salary_id = :salary_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_deduction = $row['total_deduction'];

        // Fetch total additionals
        $sql = "SELECT SUM(addition_value) AS total_additional 
        FROM additionals 
        WHERE salary_id = :salary_id";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_additional = $row['total_additional'];

        // Calculate net salary
        $net_salary = $current_salary + $total_additional - $total_deduction;

        // Check if the net salary has changed
        if ($net_salary != $current_net_salary) {
            // Net salary has changed, update the net salary in the salary table
            $sql = "UPDATE salary 
            SET net_salary = :net_salary 
            WHERE id = :salary_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':net_salary', $net_salary);
            $stmt->bindParam(':salary_id', $employee_id);
            $stmt->execute();
            echo "<script>alert('Successfully dec salaries.');</script>";

            echo "<script>window.location.href='payroll-items.php';</script>";
        } else {
            echo "<script>alert('error dec salaries.');</script>";

            echo "<script>window.location.href='payroll-items.php';</script>";
        }
    }
    echo "<script>window.location.href='payroll-items.php';</script>";
} elseif (isset($_POST['add_deduction'])) {
    $employee_ids = $_POST['employees']; // Get selected employee IDs
    $deduction_name = $_POST['deduction_name'];
    $deduction_value = $_POST['deduction_value'];
    $deduction_reason = $_POST['deduction_reason'];
    $month_year = $_POST['month_year'];

    foreach ($employee_ids as $employee_id) {
        $sql = "INSERT INTO deductions (salary_id, deduction_name, deduction_value, reason, month_year) 
        VALUES (:salary_id, :deduction_name, :deduction_value, :deduction_reason, :month_year)";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->bindParam(':deduction_name', $deduction_name);
        $stmt->bindParam(':deduction_value', $deduction_value);
        $stmt->bindParam(':deduction_reason', $deduction_reason);
        $stmt->bindParam(':month_year', $month_year);
        $stmt->execute();
        $sql = "SELECT basic_salary, tax, net_salary FROM salary WHERE id = :salary_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $basic_salary = $row['basic_salary'];
        $tax = $row['tax'];
        $current_net_salary = $row['net_salary']; // Get the current net salary

        $current_salary = $basic_salary - ($basic_salary * ($tax / 100));

        // Fetch total deductions
        $sql = "SELECT SUM(deduction_value) AS total_deduction 
            FROM deductions 
            WHERE salary_id = :salary_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_deduction = $row['total_deduction'];

        // Fetch total additionals
        $sql = "SELECT SUM(addition_value) AS total_additional 
        FROM additionals 
        WHERE salary_id = :salary_id";

        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':salary_id', $employee_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_additional = $row['total_additional'];

        // Calculate net salary
        $net_salary = $current_salary + $total_additional - $total_deduction;

        // Check if net salary has changed
        if ($net_salary != $current_net_salary) {
            // Update net salary in the salary table
            $sql = "UPDATE salary 
                SET net_salary = :net_salary 
                WHERE id = :salary_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':net_salary', $net_salary);
            $stmt->bindParam(':salary_id', $employee_id);

            $stmt->execute();

            echo "<script>alert('Successfully dec salaries.');</script>";

            echo "<script>window.location.href='payroll-items.php';</script>";
        } else {
            echo "<script>alert('error dec salaries.');</script>";

            echo "<script>window.location.href='payroll-items.php';</script>";
        }
    }
    echo "<script>window.location.href='payroll-items.php';</script>";
}
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
/////////// here for edit 
////////// its is  edit  edit_overtime  = salary  
elseif (isset($_POST['edit_overtime'])) {
    $salary_id = $_POST['id']; // Assuming the ID is passed via the form

    $basic_salary = $_POST['basic_salary'];
    $tax_rate = $_POST['tax_rate'];
    $month_year = $_POST['month_year'];

    $current_salary = $basic_salary - ($basic_salary * ($tax_rate / 100));

    $sql = "SELECT employee_id FROM salary WHERE id = :employee_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':employee_id', $salary_id);
    $stmt->execute();
    $current_employee_id = $stmt->fetchColumn();

    $employee_id = isset($_POST['employee']) ? $_POST['employee'] : $current_employee_id;

    // Update salary record
    $sql = "UPDATE salary 
            SET employee_id = :employee_id,
                basic_salary = :basic_salary,
                tax = :tax_rate,
                current_salary = :current_salary,
                net_salary = :net_salary,
                month_year = :month_year
            WHERE id = :salary_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':basic_salary', $basic_salary);
    $stmt->bindParam(':tax_rate', $tax_rate);
    $stmt->bindParam(':current_salary', $current_salary);
    // Recalculate net salary based on updated values
    $net_salary = $current_salary + $total_additions - $total_deductions;
    $stmt->bindParam(':net_salary', $net_salary);
    $stmt->bindParam(':month_year', $month_year);
    $stmt->bindParam(':salary_id', $salary_id);
    $stmt->execute();


    if ($stmt->execute()) {
        updateNetSalary($dbh, $salary_id);

        echo "<script>alert('Successfully updated salary .');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    } else {
        echo "<script>alert('Error updating salary .');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    }
}


//edit_addition
//edit_addition
//edit_addition
//edit_addition
elseif (isset($_POST['edit_addition'])) {

    $addition_id = $_POST['id'];

    $employee_id = $_POST['employee'];
    $addition_name = $_POST['addition_name'];
    $addition_value = $_POST['addition_value'];
    $addition_reason = $_POST['addition_reason'];
    $month_year = $_POST['month_year'];
    $salary_id = $_POST['salaryid'];

    // Update addition in the database
    $sql = "UPDATE additionals 
            SET addition_name = :addition_name,
                addition_value = :addition_value,
                reason = :addition_reason,
                month_year = :month_year
            WHERE id = :addition_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':addition_name', $addition_name);
    $stmt->bindParam(':addition_value', $addition_value);
    $stmt->bindParam(':addition_reason', $addition_reason);
    $stmt->bindParam(':month_year', $month_year);
    $stmt->bindParam(':addition_id', $addition_id);
    $stmt->execute();

    // Update employee_id in the salary table
    $sql = "UPDATE salary 
            SET employee_id = :employee_id
            WHERE id = (SELECT salary_id FROM additionals WHERE id = :addition_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':addition_id', $addition_id);
    $stmt->execute();

    // Redirect to the page after updating
    if ($stmt->execute()) {
        updateNetSalary($dbh, $salary_id);

        echo "<script>alert('Successfully updated addition  .');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    } else {
        echo "<script>alert('Error updating addition .');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    }
} elseif (isset($_POST['edit_deduction'])) {

    $deduction_id = $_POST['id'];
    $employee_id = $_POST['employee'];
    $deduction_name = $_POST['deduction_name'];
    $deduction_value = $_POST['deduction_value'];
    $deduction_reason = $_POST['deduction_reason'];
    $month_year = $_POST['month_year'];
    $salary_id = $_POST['salaryid'];


    $sql = "UPDATE deductions 
            SET deduction_name = :deduction_name,
                deduction_value = :deduction_value,
                reason = :deduction_reason,
                month_year = :month_year
            WHERE id = :deduction_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':deduction_name', $deduction_name);
    $stmt->bindParam(':deduction_value', $deduction_value);
    $stmt->bindParam(':deduction_reason', $deduction_reason);
    $stmt->bindParam(':month_year', $month_year);
    $stmt->bindParam(':deduction_id', $deduction_id);
    $stmt->execute();

    $sql = "UPDATE salary 
            SET employee_id = :employee_id
            WHERE id = (SELECT salary_id FROM deductions WHERE id = :deduction_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':deduction_id', $deduction_id);
    $stmt->execute();
    if ($stmt->execute()) {
        updateNetSalary($dbh, $salary_id);

        echo "<script>alert('Successfully updated deduction .');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    } else {
        echo "<script>alert('Error updating deduction .');</script>";
        echo "<script>window.location.href='payroll-items.php';</script>";
    }
}
