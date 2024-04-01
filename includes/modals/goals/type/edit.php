<div id="edit_type" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Goal Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Goal Type <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" value="" required name="type">
                    </div>
                    <div class=" form-group">
                        <label>Description <span class="text-danger">*</span></label>
                        <textarea value="" required name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <option>Select status option </option>

                        <select name="status" class="form-control">
                            <option value="1" <?php if ($row->Status == 1) echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if ($row->Status == 0) echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="">

                    <div class="submit-section">
                        <button type="submit" name="edit_type" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>