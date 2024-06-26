<div id="edit_designation" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Designation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Designation Name <span class="text-danger">*</span></label>
                        <input required name="designation" class="form-control" type="text" value="">
                    </div>
                    <div class="form-group">
                        <label>Department <span class="text-danger">*</span></label>
                        <select required name="department_id" class="select">
                            <option value="">Select Department</option>
                            <?php
                            $sql2 = "SELECT * FROM departments";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result2 as $row) { ?>
                                <option value="<?php echo htmlentities($row->id); ?>">
                                    <?php echo htmlentities($row->Department); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="">

                    <div class="submit-section">
                        <button name="edit_designation" type="submit" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>