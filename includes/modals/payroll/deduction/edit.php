<?php
$sql = "SELECT a.*, s.employee_id, e.FirstName, e.LastName
        FROM deductions a
        INNER JOIN salary s ON a.salary_id = s.id
        INNER JOIN employees e ON s.employee_id = e.id
        WHERE a.id = :id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $deductionsIdId, PDO::PARAM_INT);
$query->execute();
$deductionsIdData = $query->fetch(PDO::FETCH_ASSOC);
?>

<div id="edit_deduction" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label>Employee <span class="text-danger">*</span></label>
                        <select readonly name="employee" class="select">
                            <option value="" <?php if (!isset($deductionsIdData['employee_id']) || empty($deductionsIdData['employee_id'])) echo 'selected'; ?>>
                            </option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label>Deduction Name <span class="text-danger">*</span></label>
                        <input value="" name="deduction_name" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <label>Value of deduction <span class="text-danger">*</span></label>
                        <input value="" name="deduction_value" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <label>Reason of deduction</label>
                        <textarea value="" name="deduction_reason" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input value="" name="month_year" class="form-control" type="date">
                    </div>
                    <input type="hidden" name="salaryid" value="">

                    <input type="hidden" name="id" value="">

                    <div class="submit-section">
                        <button type="submit" name="edit_deduction" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>