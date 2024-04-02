<div id="edit_todaywork" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Work Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="includes\modals\timesheet\timesheetFunction.php">
					<input type="hidden" name="timesheetid">
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Project <span class="text-danger">*</span></label>
							<select class="select" name="projectid">
								<?php
								$sql = "SELECT * FROM projects";
								$query = $dbh->prepare($sql);
								$query->execute();
								$results = $query->fetchAll(PDO::FETCH_OBJ);
								if ($query->rowCount() > 0) {
									foreach ($results as $row) {
								?>
										<option class="projectId" value="<?php echo $row->id ?>">
											<?php echo $row->ProjectName  ?></option>
								<?php
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-4">
							<label>Start <span class="text-danger">*</span></label>
							<div class="cal-icon">
								<input class="form-control" type="text" name="Start" readonly="">
							</div>
						</div>
						<div class="form-group col-sm-4">
							<label>Total Hours <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="Totalhoure" readonly="">
						</div>
						<div class="form-group col-sm-4">
							<label>end Hours <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="End" readonly="">
						</div>
					</div>

					<div class="form-group">
						<label>Description <span class="text-danger">*</span></label>
						<textarea rows="4" name="description" class="form-control">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel elit neque.</textarea>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn" name="timesheetedit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>