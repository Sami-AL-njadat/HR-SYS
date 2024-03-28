<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    error_reporting(0);
    // DB credentials.
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'smarthr');
    // Establish database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }

    // Define variables and initialize with empty values
    $firstName = $email = $userName = "";
    $password = $hashed_password = "";
    $errors = array();

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate first name
        if (empty($_POST["firstName"])) {
            $errors['firstName'] = "First name is required";
        } else {
            $firstName = test_input($_POST["firstName"]);
        }

        // Validate password
        if (empty($_POST["password"])) {
            $errors['password'] = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        // Validate email
        if (empty($_POST["email"])) {
            $errors['email'] = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // Check if email address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format";
            }
        }

        // Validate username
        if (empty($_POST["userName"])) {
            $errors['userName'] = "Username is required";
        } else {
            $userName = test_input($_POST["userName"]);
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // If there are no errors, proceed to insert into database
        if (empty($errors)) {
            // Prepare INSERT statement
            $stmt = $dbh->prepare("INSERT INTO users (FirstName, Password, Email, UserName) VALUES (:firstName, :password, :email, :userName)");

            // Bind parameters
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':userName', $userName);

            // Execute statement
            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->errorCode();
            }
        }
    }

    // Close database connection
    $dbh = null;

    // Function to sanitize and validate input data
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Registration Form</h2>
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
        <span class="error"><?php echo $errors['firstName']; ?></span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $password; ?>">
        <span class="error"><?php echo $errors['password']; ?></span>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
        <span class="error"><?php echo $errors['email']; ?></span>

        <label for="userName">Username:</label>
        <input type="text" id="userName" name="userName" value="<?php echo $userName; ?>">
        <span class="error"><?php echo $errors['userName']; ?></span>

        <button type="submit">Register</button>
    </form>

</body>

</html>