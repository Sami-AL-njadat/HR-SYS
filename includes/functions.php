<?php
//calling the config file

include_once("../includes/config.php");
// adding new users code begins here
if (isset($_POST['add_user'])) {
	$fname = htmlspecialchars($_POST['firstname']);
	$lname = htmlspecialchars($_POST['lastname']);
	$username = htmlspecialchars($_POST['username']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$confirm_password = htmlspecialchars($_POST['confirm_pass']);
	$phone = htmlspecialchars($_POST['phone']);
	$address = htmlspecialchars($_POST['address']);
	//grabing user profile picture
	$file = $_FILES['image']['name'];
	$file_loc = $_FILES['image']['tmp_name'];
	$folder = "profiles/";
	$new_file_name = strtolower($file);
	$final_file = str_replace(' ', '-', $new_file_name);
	if ($password != $confirm_password) {
		echo "<script>alert('Your passwords do not match');</script>";
	} else {
		//moving the picture into new location and set file name to be $image.
		if (move_uploaded_file($file_loc, $folder . $final_file)) {
			$image = $final_file;
		}
		$password = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO users(FirstName,LastName,UserName,Email,Password,Phone,Address,Picture)
			values(:fname,:lname,:username,:email,:password,:phone,:address,:pic)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':fname', $fname, PDO::PARAM_STR);
		$query->bindParam(':lname', $lname, PDO::PARAM_STR);
		$query->bindParam(':username', $username, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':password', $password, PDO::PARAM_STR);
		$query->bindParam(':phone', $phone, PDO::PARAM_STR);
		$query->bindParam(':address', $address, PDO::PARAM_STR);
		$query->bindParam(':pic', $image, PDO::PARAM_STR);
		$query->execute();
		$lastInsert = $dbh->lastInsertId();
		if ($lastInsert > 0) {
			move_uploaded_file($file_loc, $folder . $final_file);
			echo "<script>alert('New User Has Been Added');</script>";
			echo "<script>window.location.href='users.php';</script>";
		} else {
			echo "<script>alert('Something went wrong.');</script>";
		}
	}
}
//adding  users ends here 

//adding assets begins here
elseif (isset($_POST['add_asset'])) {
	$asset = htmlspecialchars($_POST['asset_name']);
	$asset_id = htmlspecialchars($_POST['asset_id']);
	$purchase_date = htmlspecialchars($_POST['purchase_date']);
	$purchase_from = htmlspecialchars($_POST['purchase_from']);
	$manufacturer = htmlspecialchars($_POST['manufacturer']);
	$model = htmlspecialchars($_POST['model']);
	$status = htmlspecialchars($_POST['status']);
	$supplier = htmlspecialchars($_POST['supplier']);
	$condition = htmlspecialchars($_POST['condition']);
	$warrant = htmlspecialchars($_POST['warranty']);
	$price = htmlspecialchars($_POST['value']);
	$asset_user = htmlspecialchars($_POST['asset_user']); // Corrected variable name

	$descriptiones = htmlspecialchars($_POST['descriptiones']);
	$sql = "INSERT INTO `assets` ( `assetName`, `assetId`, `PurchaseDate`, `PurchaseFrom`, `Manufacturer`, `Model`, `Status`, `Supplier`, `AssetCondition`, `Warranty`, `Price`, `AssetUser`, `Description`)
		 VALUES (:name, :id, :purchaseDate, :purchasefrom, :manufacturer, :model, :stats, :supplier, :condition, :warranty, :price, :asset_user, :descriptiones)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':name', $asset, PDO::PARAM_STR);
	$query->bindParam(':id', $asset_id, PDO::PARAM_STR);
	$query->bindParam(':purchaseDate', $purchase_date, PDO::PARAM_STR);
	$query->bindParam(':purchasefrom', $purchase_from, PDO::PARAM_STR);
	$query->bindParam(':manufacturer', $manufacturer, PDO::PARAM_STR);
	$query->bindParam(':model', $model, PDO::PARAM_STR);
	$query->bindParam(':stats', $status, PDO::PARAM_INT);
	$query->bindParam(':supplier', $supplier, PDO::PARAM_STR);
	$query->bindParam(':condition', $condition, PDO::PARAM_STR);
	$query->bindParam(':warranty', $warrant, PDO::PARAM_STR);
	$query->bindParam(':price', $price, PDO::PARAM_INT);
	$query->bindParam(':asset_user', $asset_user, PDO::PARAM_STR);
	$query->bindParam(':descriptiones', $descriptiones, PDO::PARAM_STR);
	$query->execute();
	$lastinserted = $dbh->lastInsertId();
	if ($lastinserted > 0) {
		echo "<script>alert('Asset Has Been Added');</script>";
		echo "<script>window.location.href='assets.php';</script>";
	} else {
		echo "<script>alert('Something Went Wrong Please Again.');</script>";
	}
}
//adding assets code ends here.


//editing assets begins here

elseif (isset($_POST['edit_asset'])) {
	// Retrieve form data

	$asset_name = htmlspecialchars($_POST['asset_name']);
	$purchase_date = htmlspecialchars($_POST['purchase_date']);
	$purchase_from = htmlspecialchars($_POST['purchase_from']);
	$manufacturer = htmlspecialchars($_POST['manufacturer']);
	$model = htmlspecialchars($_POST['model']);
	$status = htmlspecialchars($_POST['status']);
	$supplier = htmlspecialchars($_POST['supplier']);
	$condition = htmlspecialchars($_POST['condition']);
	$warranty = htmlspecialchars($_POST['warranty']); // Corrected variable name
	$value = htmlspecialchars($_POST['value']); // Corrected variable name
	$asset_user = htmlspecialchars($_POST['asset_user']); // Corrected variable name
	$descriptiones = htmlspecialchars($_POST['descriptiones']); // Corrected variable name
	$rid = htmlspecialchars($_POST['id']);
	$_SESSION['id'] = $rid;
	// Update the asset in the database
	$sql = "UPDATE assets SET ";
	$params = array();

	// Build the update query dynamically based on changed fields
	if (!empty($asset_name)) {
		$sql .= "assetName = :asset_name, ";
		$params[':asset_name'] = $asset_name;
	}
	if (!empty($purchase_date)) {
		$sql .= "PurchaseDate = :purchase_date, ";
		$params[':purchase_date'] = $purchase_date;
	}
	if (!empty($purchase_from)) {
		$sql .= "PurchaseFrom = :purchase_from, ";
		$params[':purchase_from'] = $purchase_from;
	}
	if (!empty($manufacturer)) {
		$sql .= "Manufacturer = :manufacturer, ";
		$params[':manufacturer'] = $manufacturer;
	}
	if (!empty($model)) {
		$sql .= "Model = :model, ";
		$params[':model'] = $model;
	}
	if ($status > -1) {
		$sql .= "Status = :status, ";
		$params[':status'] = $status;
	}
	if (!empty($supplier)) {
		$sql .= "Supplier = :supplier, ";
		$params[':supplier'] = $supplier;
	}
	if (!empty($condition)) {
		$sql .= "AssetCondition = :condition, ";
		$params[':condition'] = $condition;
	}

	if (!empty($warranty)) {
		$sql .= "Warranty = :warranty, ";
		$params[':warranty'] = $warranty;
	}

	if (!empty($value)) {
		$sql .= "Price = :value, ";
		$params[':value'] = $value;
	}

	if (!empty($asset_user)) {
		$sql .= "AssetUser = :asset_user, ";
		$params[':asset_user'] = $asset_user;
	}

	if (!empty($descriptiones)) {
		$sql .= "Description = :descriptiones, ";
		$params[':descriptiones'] = $descriptiones;
	}

	// Remove the trailing comma and space
	$sql = rtrim($sql, ", ");

	$sql .= " WHERE id = :rid";

	// Prepare and execute the query
	$query = $dbh->prepare($sql);
	$query->bindParam(':rid', $rid, PDO::PARAM_STR);

	foreach ($params as $key => &$value) {
		$query->bindParam($key, $value);
	}

	$query->execute();

	// Check if the update was successful
	$updated_rows = $query->rowCount();
	if ($updated_rows > 0) {
		echo "<script>alert('Asset has been updated successfully');</script>";
	} else {
		echo "<script>alert('Failed to update asset');</script>";
	}

	echo "<script>window.location.href ='assets.php'</script>";
}


//editing assets code ends here.





elseif (isset($_POST['edit_employee'])) {
	// Retrieve form data

	$first_name = htmlspecialchars($_POST['first_name']);
	$last_name = htmlspecialchars($_POST['last_name']);
	$username = htmlspecialchars($_POST['username']);
	$email_em = htmlspecialchars($_POST['email_em']);
	$password = htmlspecialchars($_POST['password']);
	$confirmPassword = htmlspecialchars($_POST['confirmpassword']);
	$joining_date = htmlspecialchars($_POST['joining_date']);
	$Phone_e = htmlspecialchars($_POST['phone_e']);
	$Department_e = htmlspecialchars($_POST['Department_e']);
	$designation = htmlspecialchars($_POST['designation']);

	$rid = ($_POST['emp_id']);
	$_SESSION['id'] = $rid;
	$sql = "UPDATE employees SET ";
	$params = array();

	if (!empty($first_name)) {
		$sql .= "FirstName  = :first_name, ";
		$params[':first_name'] = $first_name;
	}


	if (!empty($last_name)) {
		$sql .= "LastName = :last_name, ";
		$params[':last_name'] = $last_name;
	}
	if (!empty($username)) {
		$sql .= "UserName = :username, ";
		$params[':username'] = $username;
	}
	if (!empty($email_em)) {
		$sql .= "Email = :email_em, ";
		$params[':email_em'] = $email_em;
	}
	if (!empty($password)) {
		$sql .= "Password = :password, ";
		$params[':password'] = $password;
	}
	// if ($status > -1) {
	// 	$sql .= "Status = :status, ";
	// 	$params[':status'] = $status;
	// }
	if (!empty($Phone_e)) {
		$sql .= "Phone = :Phone_e, ";
		$params[':Phone_e'] = $Phone_e;
	}
	if (!empty($Department_e)) {
		$sql .= "Department  = :Department_e, ";
		$params[':Department_e'] = $Department_e;
	}

	if (!empty($warranty)) {
		$sql .= "Designation  = :designation, ";
		$params[':designation'] = $designation;
	}

	if (!empty($value)) {
		$sql .= "Price = :value, ";
		$params[':value'] = $value;
	}

	if (!empty($joining_date)) {
		$sql .= "Joining_Date  = :joining_date, ";
		$params[':joining_date'] = $joining_date;
	}



	// Remove the trailing comma and space
	$sql = rtrim($sql, ", ");

	$sql .= " WHERE id = :rid";

	// Prepare and execute the query
	$query = $dbh->prepare($sql);
	$query->bindParam(':rid', $rid, PDO::PARAM_STR);

	foreach ($params as $key => &$value) {
		$query->bindParam($key, $value);
	}

	$query->execute();

	// Check if the update was successful
	$updated_rows = $query->rowCount();
	if ($updated_rows > 0) {
		echo "<script>alert('Employee has been updated successfully');</script>";
	} else {
		echo "<script>alert('Failed to update Employee');</script>";
	}

	echo "<script>window.location.href ='/	HR-SYS/employees.php'</script>";
}


//editing assets code ends here.









//client adding code starts here
// Check if the form is submitted
elseif (isset($_POST['add_client'])) {
	// Retrieve form data
	// Sanitize user inputs
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$username = htmlspecialchars($_POST['username']);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email
	$client_id = htmlspecialchars($_POST['clientid']);
	$phone = preg_replace('/[^0-9]/', '', $_POST['phone']); // Extract only digits from phone number
	$company = htmlspecialchars($_POST['company']);
	$address = htmlspecialchars($_POST['address']);
	// Grab user profile picture
	$propic = $_FILES["propic"];

	// Validate email format
	if (!filter_var(
		$email,
		FILTER_VALIDATE_EMAIL
	)) {
		echo "<script>alert('Error: Invalid email format.');</script>";
		echo "<script>window.location.href ='clients.php'</script>";
		exit;
	}

	// Validate phone number
	if (
		strlen($phone) !== 10 || !ctype_digit($phone)
	) {
		echo "<script>alert('Error: Phone number must be 10 digits long and contain only numbers.');</script>";
		echo "<script>window.location.href ='clients.php'</script>";
		exit;
	}

	// Check if the email already exists in the database
	$sql_check_email = "SELECT COUNT(*) AS email_count FROM clients WHERE Email = :email";
	$query_check_email = $dbh->prepare($sql_check_email);
	$query_check_email->bindParam(':email', $email, PDO::PARAM_STR);
	$query_check_email->execute();
	$row = $query_check_email->fetch(PDO::FETCH_ASSOC);
	if ($row['email_count'] > 0) {
		echo "<script>alert('Error: Email already exists. Please use a different email.');</script>";
		echo "<script>window.location.href ='clients.php'</script>";
		exit;
	}

	// Check if a file is selected and validate file type
	if ($propic['error'] === UPLOAD_ERR_OK) {
		// Generate a unique filename
		$extension = pathinfo($propic["name"], PATHINFO_EXTENSION);
		$propic_filename = md5($propic["name"] . time()) . '.' . $extension;

		// Move the uploaded file to the desired location
		if (move_uploaded_file($propic["tmp_name"], "clients/" . $propic_filename)) {
			// Prepare SQL statement
			$sql = "INSERT INTO `clients` (`FirstName`, `LastName`, `UserName`, `Email`, `ClientId`, `Phone`, `Company`, `Address`, `Status`, `Picture`) 
                    VALUES (:fname, :lname, :username, :email, :id, :phone, :company, :address, '1', :pic)";
			$query = $dbh->prepare($sql);
			// Bind parameters
			$query->bindParam(':fname', $firstname, PDO::PARAM_STR);
			$query->bindParam(':lname', $lastname, PDO::PARAM_STR);
			$query->bindParam(':username', $username, PDO::PARAM_STR);
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->bindParam(':id', $client_id, PDO::PARAM_STR);
			$query->bindParam(':phone', $phone, PDO::PARAM_STR);
			$query->bindParam(':company', $company, PDO::PARAM_STR);
			$query->bindParam(':address', $address, PDO::PARAM_STR);
			$query->bindParam(':pic', $propic_filename, PDO::PARAM_STR);
			// Execute query
			if ($query->execute()) {
				echo "<script>alert('Client has been added.');</script>";
				echo "<script>window.location.href='clients.php';</script>";
			} else {
				echo "<script>alert('Error: Failed to add client.');</script>";
			}
		} else {
			echo "<script>alert('Error: Failed to move uploaded file.');</script>";
			echo "<script>window.location.href ='clients.php'</script>";
		}
	} else {
		echo "<script>alert('Error: File upload error.');</script>";
		echo "<script>window.location.href ='clients.php'</script>";
	}
}






//adding client code ends here


//editing client here start 

elseif (isset($_POST['edit_client'])) {
	// Retrieve form data
	// Sanitize user inputs
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$username = htmlspecialchars($_POST['username']);
	$email = $_POST['email']; // No need to sanitize email
	$phone = preg_replace('/[^0-9]/', '', $_POST['phone']); // Extract only digits from phone number
	$company = htmlspecialchars($_POST['company']);

	// Validate phone number
	if (
		strlen($phone) !== 10 || !ctype_digit($phone)
	) {
		echo "<script>alert('Error: Phone number must be 10 digits long and contain only numbers.');</script>";
		echo "<script>window.location.href ='clients.php'</script>";
		exit;
	}

	// Check if a file is selected
	if (isset($_FILES['propic']) && $_FILES['propic']['error'] === UPLOAD_ERR_OK) {
		// Grab user profile picture
		$propic = $_FILES["propic"];
		// Generate a unique filename
		$extension = pathinfo($propic["name"], PATHINFO_EXTENSION);
		$propic_filename = md5($propic["name"] . time()) . '.' . $extension;
		// Move the uploaded file to the desired location
		if (move_uploaded_file($propic["tmp_name"], "clients/" . $propic_filename)) {
			// Prepare SQL statement for updating client details with image
			$sql = "UPDATE `clients` SET `FirstName` = :fname, `LastName` = :lname, `UserName` = :username, `Email` = :email, `Phone` = :phone, `Company` = :company, `Picture` = :pic WHERE `id` = :id";
			$query = $dbh->prepare($sql);
			// Bind parameters
			$query->bindParam(':pic', $propic_filename, PDO::PARAM_STR);
		} else {
			echo "<script>alert('Error: Failed to move uploaded file.');</script>";
			echo "<script>window.location.href ='clients.php'</script>";
			exit;
		}
	} else {
		// Prepare SQL statement for updating client details without image
		$sql = "UPDATE `clients` SET `FirstName` = :fname, `LastName` = :lname, `UserName` = :username, `Email` = :email, `Phone` = :phone, `Company` = :company WHERE `id` = :id";
		$query = $dbh->prepare($sql);
	}

	// Bind parameters
	$query->bindParam(':fname', $firstname, PDO::PARAM_STR);
	$query->bindParam(':lname', $lastname, PDO::PARAM_STR);
	$query->bindParam(':username', $username, PDO::PARAM_STR);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':phone', $phone, PDO::PARAM_STR);
	$query->bindParam(':company', $company, PDO::PARAM_STR);
	$query->bindParam(':id', $_POST['id'], PDO::PARAM_INT); // Assuming the hidden input field for client_id is named 'id'
	// Execute query
	if ($query->execute()) {
		echo "<script>alert('Client details have been updated.');</script>";
		echo "<script>window.location.href='clients.php';</script>";
	} else {
		echo "<script>alert('Error: Failed to update client details.');</script>";
	}
}





//editing client here stop 

//adding departments code starts here
elseif (isset($_POST['add_department'])) {
	$department = htmlspecialchars($_POST['department']);
	$sql = "INSERT INTO departments(Department )VALUES(:name)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':name', $department, pdo::PARAM_STR);
	$query->execute();
	$lastInsert = $dbh->lastInsertId();
	if ($lastInsert > 0) {
		echo "<script>alert('Department Has Been Added');</script>";
		echo "<script>window.location.href='departments.php';</script>";
	} else {
		echo "<script>alert('Something went wrong.');</script>";
	}
}

//adding departments code ends here



//editing departments code starts here
elseif (isset($_POST['edit_department'])) {
	$department = htmlspecialchars($_POST['department']);
	$department_id = intval($_POST['id']);

	$sql = "UPDATE departments SET Department = :name WHERE id = :id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':name', $department, PDO::PARAM_STR);
	$query->bindParam(':id', $department_id, PDO::PARAM_INT);
	$query->execute();

	$affected_rows = $query->rowCount();
	if ($affected_rows > 0) {
		echo "<script>alert('Department has been updated.');</script>";
	} else {
		echo "<script>alert('Failed to update department.');</script>";
	}
	echo "<script>window.location.href='departments.php';</script>";
}



//editing departments code ends here





//adding desginations code starts from here
elseif (isset($_POST['add_designation'])) {
	$name = htmlspecialchars($_POST['designation']);
	$department_id = htmlspecialchars($_POST['department_id']);
	$sql = "INSERT INTO `designations` (`Designation`, `Department`) VALUES (:designation, :department_id)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':designation', $name, PDO::PARAM_STR);
	$query->bindParam(':department_id', $department_id, PDO::PARAM_INT); // Assuming department_id is an integer
	$query->execute();
	$lastInsert = $dbh->lastInsertId();
	if (
		$lastInsert > 0
	) {
		echo "<script>alert('Designation Has Been Added');</script>";
		echo "<script>window.location.href='designations.php';</script>";
	} else {
		echo "<script>alert('Something Went wrong');</script>";
	}
}
//adding designations code ends here


//editing designations code starts here
if (isset($_POST['edit_designation'])) {
	$designation_id = htmlspecialchars($_POST['id']); // Get the designation ID from the hidden input
	$name = htmlspecialchars($_POST['designation']);
	$department_id = htmlspecialchars($_POST['department_id']);

	// Update the designation in the database
	$sql = "UPDATE `designations` SET `Designation` = :designation, `Department` = :department_id WHERE `id` = :designation_id";
	$query = $dbh->prepare($sql);
	$query->bindParam(':designation', $name, PDO::PARAM_STR);
	$query->bindParam(':department_id', $department_id, PDO::PARAM_INT); // Assuming department_id is an integer
	$query->bindParam(':designation_id', $designation_id, PDO::PARAM_INT); // Assuming designation_id is an integer
	$query->execute();

	// Check if the update was successful
	$updated_rows = $query->rowCount();
	if ($updated_rows > 0) {
		echo "<script>alert('Designation has been updated successfully');</script>";
		echo "<script>window.location.href='designations.php';</script>";
	} else {
		echo "<script>alert('Failed to update designation');</script>";
	}
}

//editing designations code ends here


//adding holidays starts here
elseif (isset($_POST['add_holiday'])) {
	$holiday_name = htmlspecialchars($_POST['holiday']);
	$holiday_date = htmlspecialchars($_POST['date']);
	$sql = "INSERT INTO holidays(Holiday_Name,Holiday_Date)VALUES(:name,:date)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':name', $holiday_name, PDO::PARAM_STR);
	$query->bindParam(':date', $holiday_date, PDO::PARAM_STR);
	$query->execute();
	$lastInsert = $dbh->lastInsertId();
	if ($lastInsert > 0) {
		echo "<script>alert('Holiday Has Been Added');</script>";
		echo "<script>window.location.href='holidays.php';</script>";
	} else {
		echo "<script>alert('Something Went Wrong.');</script>";
	}
} //adding holidays ends here

//adding employees code starts from here
elseif (isset($_POST['add_employee'])) {
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$username = htmlspecialchars($_POST['username']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$confirm_password = htmlspecialchars($_POST['confirm_pass']);
	$employee_id = htmlspecialchars($_POST['employee_id']);
	$phone = htmlspecialchars($_POST['phone']);
	$department = htmlspecialchars($_POST['department']);
	$designation = htmlspecialchars($_POST['designation']);
	//grabbing the picture
	$file = $_FILES['picture']['name'];
	$file_loc = $_FILES['picture']['tmp_name'];
	$folder = "../employees/";
	$new_file_name = strtolower($file);
	$final_file = str_replace(' ', '-', $new_file_name);

	if (move_uploaded_file($file_loc, $folder . $final_file) && ($password == $confirm_password)) {
		$image = $final_file;
		$password = password_hash($password, PASSWORD_DEFAULT);
	}
	$sql = "INSERT INTO `employees` (`id`, `FirstName`, `LastName`, `UserName`, `Email`, `Password`, `Employee_Id`, `Phone`, `Department`, `Designation`, `Picture`, `DateTime`) 
		VALUES (NULL, :firstname, :lastname, :username, :email,:password, :id, :phone, :department, :designation,  :pic, current_timestamp())";
	$query = $dbh->prepare($sql);
	$query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
	$query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
	$query->bindParam(':username', $username, PDO::PARAM_STR);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->bindParam(':password', $password, PDO::PARAM_STR);
	$query->bindParam(':id', $employee_id, PDO::PARAM_STR);
	$query->bindParam(':phone', $phone, PDO::PARAM_STR);
	$query->bindParam(':department', $department, PDO::PARAM_STR);
	$query->bindParam(':designation', $designation, PDO::PARAM_STR);
	$query->bindParam(':pic', $image, PDO::PARAM_STR);
	$query->execute();
	$lastInsert = $dbh->lastInsertId();
	if ($lastInsert > 0) {
		echo "<script>alert('Employee Has Been Added.');</script>";
		echo "<script>window.location.href='/HR-SYS/employees.php';</script>";
	} else {
		echo "<script>alert('Something Went Wrong');</script>";
	}
} //ading employees code eds here

//employee overtime code begins here

//adding employees leave code starts here
elseif (isset($_POST['add_leave'])) {
	$employee = htmlspecialchars($_POST['employee']);
	$start_date = htmlspecialchars($_POST['starting_at']);
	$end_date = htmlspecialchars($_POST['ends_on']);
	$days_count = htmlspecialchars($_POST['days_count']);
	$reason = htmlspecialchars($_POST['reason']);
	$sql = "INSERT INTO `leaves` (`Employee`, `Starting_At`, `Ending_On`, `dayscount`, `Reason`, `Time_Added`)
		 VALUES ( :employee, :start, :end, :days, :reason, current_timestamp())";
	$query = $dbh->prepare($sql);
	$query->bindParam(':employee', $employee, PDO::PARAM_STR);
	$query->bindParam(':start', $start_date, PDO::PARAM_STR);
	$query->bindParam(':end', $end_date, PDO::PARAM_STR);
	$query->bindParam(':days', $days_count, PDO::PARAM_STR);
	$query->bindParam(':reason', $reason, PDO::PARAM_STR);
	$query->execute();
	$lastInsert = $dbh->lastInsertId();
	if ($lastInsert > 0) {
		echo "<script>alert('Employee Leave Has Been Added');</script>";
		echo "<script>window.location.href='leaves-employee.php';</script>";
	} else {
		echo "<script>alert('Something went wrong');</script>";
	}
}
