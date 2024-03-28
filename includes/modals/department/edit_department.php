<div id="edit_department" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Department</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST">
					<div class="form-group">
						<label>Department Name <span class="text-danger">*</span></label>
						<input class="form-control" name="department" required type="text" value="<?php echo htmlentities($row->Department); ?>">
					</div>
					<input type="hidden" name="id" value="<?php echo htmlentities($row->id); ?>">

					<div class="submit-section">
						<button name="edit_department" type="POST" class="btn btn-primary submit-btn">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>