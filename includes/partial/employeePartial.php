<?php
include_once("../config.php");

$designationName = isset($_POST['designationName']) ? $_POST['designationName'] : null;

// Check if the designationName is valid
if (!is_null($designationName) && !empty($designationName)) {
    $sql = "SELECT * FROM employees WHERE Designation = :designationName"; // Corrected SQL query
    $query = $dbh->prepare($sql);
    $query->bindParam(':designationName', $designationName, PDO::PARAM_STR); // Use PDO::PARAM_STR for string parameters
} else {

    $sql = "SELECT * FROM employees";
    $query = $dbh->prepare($sql);
}

$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;

if ($query->rowCount() > 0) {
    foreach ($results as $row) {
?>
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
            <div class="profile-widget">
                <div class="profile-img">
                    <a href="profile.html" class="avatar"><img src="employees/<?php echo htmlentities($row->Picture); ?>" alt="picture"></a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-employee" href="#" data-toggle="modal" data-target="#edit_employee" data-employeeid="<?php echo $row->Employee_Id; ?>" data-firstname="<?php echo htmlentities($row->FirstName); ?>" data-lastname="<?php echo htmlentities($row->LastName); ?>" data-designation="<?php echo htmlentities($row->Designation); ?>
												" data-picture="<?php echo htmlentities($row->Picture); ?>" data-email="<?php echo htmlentities($row->Email); ?>" data-phone="<?php echo htmlentities($row->Phone); ?>" data-department="<?php echo htmlentities($row->Department); ?>" data-designation="<?php echo htmlentities($row->Designation); ?>" data-Picture="<?php echo htmlentities($row->Picture); ?>" data-DateTime="<?php echo htmlentities($row->DateTime); ?>" data-username="<?php echo htmlentities($row->UserName); ?>" data-joiningdate="<?php echo ($row->Joining_Date) ?>" data-id="<?php echo ($row->id); ?>"><i class="fa fa-pencil m-r-5"></i> Edit

                        </a>

                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#delete_employee" onclick="setEmployeeIdToDelete(<?php echo $row->id; ?>)">Delete</a>


                    </div>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="profile.html"><?php echo htmlentities($row->FirstName) . " " . htmlentities($row->LastName); ?></a></h4>
                <div class="small text-muted"><?php echo htmlentities($row->Designation); ?></div>
            </div>
        </div>
<?php
        $cnt += 1;
    }
}
?>


<script>
    $(document).ready(function() {

        $('.edit-employee').click(function() {
            var Employee_Id = $(this).data('employeeid');
            var id = $(this).data('id');
            console.log("id", id);
            var firstName = $(this).data('firstname');
            var lastName = $(this).data('lastname');
            var designation = $(this).data('designation');
            var Email = $(this).data('email');
            var UserName = $(this).data('username');

            var Phone = $(this).data('phone');
            var picture = $(this).data('picture');
            var Department = $(this).data('department');
            var Joining_Date = $(this).data('joiningdate');
            console.log('Joining_Date', Joining_Date);


            $('#edit_employee #employee_id').val(Employee_Id);
            $('#edit_employee #first_name').val(firstName);
            $('#edit_employee #last_name').val(lastName);
            $('#edit_employee #designation').val(designation);
            $('#edit_employee #email_em').val(Email);
            $('#edit_employee #Phone_e').val(Phone);
            $('#edit_employee #Department_e').val(Department);
            // $('#edit_employee #Joining_Date').val(Joining_Date);
            $('#edit_employee #username').val(UserName);

            $('.form-group select[name="Department_e"]').val(Department);
            $(' input[name="joining_date"]').val(Joining_Date);
            $(' input[name="emp_id"]').val(id);
            $('.designation_e').each(function() {

                if ($(this).html().replace(/\s/g, '') == designation.replace(/\s/g, '')) {

                    $(this).prop('selected', true);
                }
            });



            $.ajax({
                url: 'http://localhost/HR-SYS/includes/modals/employee/savedatatosesion.php',

                type: 'POST',
                data: {

                    department_e: Department,
                    designation_e: designation,

                },
                success: function(response) {
                    console.log(response);
                    console.log('Data saved successfully in session.');

                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', error);

                }
            });
        });
    });
</script>