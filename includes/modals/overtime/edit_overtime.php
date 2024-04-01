<div id="edit_overtime" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Overtime</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="/HR-SYS/includes/modals/overtime/overtimefunction.php" method="POST">
					<input type="hidden" name="overtimeid">
					<div class="form-group">
						<label>Select Employee <span class="text-danger">*</span></label>
						<select class="form-control	" name="employee">
							<?php
							$sql2 = "SELECT * from employees";
							$query2 = $dbh->prepare($sql2);
							$query2->execute();
							$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
							foreach ($result2 as $row) {
							?>
								<option value="<?php echo htmlentities($row->FirstName) . ' ' . htmlentities($row->LastName); ?>">
									<?php echo htmlentities($row->FirstName) . " " . htmlentities($row->LastName); ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Overtime Date <span class="text-danger">*</span></label>
						<div class="cal-icon">
							<input name="ov_date" class="form-control datetimepicker" type="text">
						</div>
					</div>
					<div class="form-group">
						<label>Overtime Hours <span class="text-danger">*</span></label>
						<input name="ov_hours" class="form-control" type="text">
					</div>
					<div class="form-group">
						<label>Description <span class="text-danger">*</span></label>
						<textarea rows="4" name="description" class="form-control"></textarea>
					</div>
					<div class="submit-section">
						<button name="EDITovertime" class="btn btn-primary submit-btn">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>