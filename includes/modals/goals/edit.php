<div id="edit_goal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Goal Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label" for="goal">Goal Type</label>
                                <select name="goal" class="select">
                                    <option>Select Goal Type</option>
                                    <?php
									$sql2 = "SELECT * FROM goal_type";
									$query2 = $dbh->prepare($sql2);
									$query2->execute();
									$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
									foreach ($result2 as $row) {
									?>
                                    <option value="<?php echo htmlentities($row->id); ?>">
                                        <?php echo htmlentities($row->Type); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label" for="subject">Subject</label>
                                <input required name="subject" class="form-control" type="text" value="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Target Achievement</label>
                                <input required name="target" class="form-control" type="text" value="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <div class="cal">
                                    <input required name="start_date"
                                        placeholder="<?php echo ($row->StartDate) ? htmlentities($row->StartDate) : ''; ?>"
                                        class="form-control" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date <span class="text-danger">*</span></label>
                                <div class="cal">
                                    <input class="form-control" type="date" required name="end_date"
                                        placeholder="<?php echo ($row->EndDate) ? htmlentities($row->EndDate) : ''; ?>">
                                </div>


                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea value="" name="description" required class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Completion Percentage</label>
                                <input required class="form-control" type="number" name="progress" min="0" max="100"
                                    step="1">
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="id" value="">
                    <div class="submit-section">
                        <button type="submit" name="edit_goal" class="btn btn-primary submit-btn">Save</button>
                    </div>

            </div>
            </form>
        </div>
    </div>
</div>
</div>