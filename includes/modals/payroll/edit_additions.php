<?php
$sql = "SELECT a.*, s.employee_id, e.FirstName, e.LastName
        FROM additionals a
        INNER JOIN salary s ON a.salary_id = s.id
        INNER JOIN employees e ON s.employee_id = e.id
        WHERE a.id = :id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $additionId, PDO::PARAM_INT);
$query->execute();
$additionData = $query->fetch(PDO::FETCH_ASSOC);
?>
<div id="edit_addition" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Additionals</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label>Employee <span class="text-danger">*</span></label>
                        <select readonly name="employee" class="select">
                            <option value="" <?php if (!isset($additionData['employee_id']) || empty($additionData['employee_id'])) echo 'selected'; ?>>
                            </option>
                        </select>



                    </div>

                    <div class="form-group">
                        <label>Addition Name <span class="text-danger">*</span></label>
                        <input value="" name="addition_name" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <label>Value of Addition <span class="text-danger">*</span></label>
                        <input value="" name="addition_value" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <label>Reason of Addition</label>
                        <textarea value="" name="addition_reason" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input value="" name="month_year" class="form-control" type="date">
                    </div>
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="salaryid" value="">

                    <div class="submit-section">
                        <button type="submit" name="edit_addition" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>