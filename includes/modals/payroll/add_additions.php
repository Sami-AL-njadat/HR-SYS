<!-- Add Additionals Modal -->
<div id="add_addition" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Additionals</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post">
					<div class="form-group">
						<label>Employee <span class="text-danger">*</span></label>
						<select name="employees[]" class="select form-control" multiple>
							<option value="">Select Employee</option>
							<?php
							$sql = "SELECT DISTINCT s.id, e.FirstName, e.LastName 
                                    FROM salary s
                                    INNER JOIN employees e ON s.employee_id = e.id";
							$query = $dbh->query($sql);
							$employees = $query->fetchAll(PDO::FETCH_ASSOC);

							foreach ($employees as $employee) {
								echo '<option value="' . $employee['id'] . '">' . $employee['FirstName'] . ' ' . $employee['LastName'] . '</option>';
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label>Addition Name <span class="text-danger">*</span></label>
						<input name="addition_name" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label>Value of Addition <span class="text-danger">*</span></label>
						<input name="addition_value" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label>Reason of Addition</label>
						<textarea name="addition_reason" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label>Date <span class="text-danger">*</span></label>
						<input name="month_year" class="form-control" type="date">
					</div>

					<div class="submit-section">
						<button type="submit" name="add_addition" class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>