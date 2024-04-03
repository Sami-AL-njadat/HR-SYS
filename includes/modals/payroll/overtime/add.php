<?php
// Fetch all employees from the database
$sql = "SELECT id, FirstName, LastName 
        FROM employees";
$query = $dbh->query($sql);
$employees = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="add_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="add_salary_form">
                    <div class="form-group">
                        <label>Employee <span class="text-danger">*</span></label>
                        <select name="employee[]" class="select form-control" multiple>
                            <?php
                            foreach ($employees as $employee) {
                                echo '<option value="' . $employee['id'] . '">' . $employee['FirstName'] . ' ' . $employee['LastName'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div hidden class="form-group">
                        <label>All Employees<span class="text-danger">*</span></label>
                        <input id="select_all" class="form-control" type="checkbox">
                    </div>
                    <div class="form-group">
                        <label>Basic Salary <span class="text-danger">*</span></label>
                        <input required name="basic_salary" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <label>Tax Rate (0% to 20%) <span class="text-danger">*</span></label>
                        <input required name="tax_rate" class="form-control" type="number" min="0" max="20" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input required name="month_year" class="form-control" type="date">
                    </div>





                    <div class="submit-section">
                        <button type="submit" name="add_salary" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                    <script>
                        document.getElementById('select_all').addEventListener('change', function() {
                            var checkboxes = document.getElementsByName('employee[]');
                            for (var i = 0; i < checkboxes.length; i++) {
                                checkboxes[i].checked = this.checked;
                            }
                        });
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>