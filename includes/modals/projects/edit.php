<div id="edit_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" multiple enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Project Name</label>
                                <input placeholder="<?php echo htmlentities($project["ProjectName"]); ?>" value="" required class="form-control" type="text" name="projectName">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Client</label>
                                <select required name="clientId" class="select">
                                    <option>Select Client</option>
                                    <?php
                                    $sql2 = "SELECT * FROM clients";
                                    $query2 = $dbh->prepare($sql2);
                                    $query2->execute();
                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result2 as $row) {
                                    ?>
                                        <option value="<?php echo htmlentities($row->id); ?>">
                                            <?php echo htmlentities($row->FirstName) . " " . htmlentities($row->LastName); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>




                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select required name="deparId" class="select">
                                    <option>Select Department</option>
                                    <?php
                                    $sql = "SELECT * FROM departments";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $departments = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($departments as $departmentes) {

                                    ?>
                                        <option value="<?php echo htmlentities($departmentes->id); ?>">
                                            <?php echo htmlentities($departmentes->Department); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Designation</label>
                                <select required name="desiId" class="select">
                                    <option>Select Designation</option>
                                    <?php
                                    $sql = "SELECT * FROM designations";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $designations = $query->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($designations as $designation) {
                                    ?>
                                        <option value="<?php echo htmlentities($designation['id']); ?>">
                                            <?php echo htmlentities($designation['Designation']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Project Leader</label>
                                <select required name="projectled" class="select">
                                    <option>Select Project Leader</option>
                                    <?php
                                    $sql = "SELECT * FROM employees";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $result = $query->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo htmlentities($row->id); ?>">
                                            <?php echo htmlentities($row->FirstName) . " " . htmlentities($row->LastName); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Team Members</label>
                                <select required name="teamMem[]" class="select" multiple>

                                    <?php
                                    $sql2 = "SELECT * FROM employees";
                                    $query2 = $dbh->prepare($sql2);
                                    $query2->execute();
                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result2 as $row2) {
                                    ?>
                                        <option value="<?php echo htmlentities($row2->id); ?>">
                                            <?php echo htmlentities($row2->FirstName) . " " . htmlentities($row2->LastName); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Price</label>
                                <input value="<?php echo htmlentities($project['Price']); ?>" required name="price" placeholder="$50" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select required name="status" class="select">
                                    <option value="0" <?php if ($project['Status'] == 0) echo 'selected'; ?>>Pending
                                    </option>
                                    <option value="1" <?php if ($project['Status'] == 1) echo 'selected'; ?>>In process
                                    </option>
                                    <option value="2" <?php if ($project['Status'] == 2) echo 'selected'; ?>>Finished
                                    </option>
                                    <option value="3" <?php if ($project['Status'] == 3) echo 'selected'; ?>>Start soon
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Priority</label>
                                <select required name="priority" class="select">
                                    <option value="0" <?php if ($project['Status'] == 0) echo 'selected'; ?>>High
                                    </option>
                                    <option value="1" <?php if ($project['Status'] == 1) echo 'selected'; ?>>Medium
                                    </option>
                                    <option value="2" <?php if ($project['Status'] == 2) echo 'selected'; ?>>Low
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Completion Percentage</label>
                                <input value="<?php echo isset($project["CompletionPercentage"]) ? htmlentities($project["CompletionPercentage"]) : ''; ?>" required class="form-control" type="number" name="percentage" min="0" max="100" step="1">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input placeholder="<?php echo ($project["StartDate"]) ? htmlentities($project["StartDate"]) : ''; ?>" required name="start_date" class="form-control" type="date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input placeholder="<?php echo ($project["EndDate"]) ? htmlentities($project["EndDate"]) : ''; ?>" required name="end_date" class="form-control" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="filess">Choose a file:</label>
                        <small id="fileNameDisplay" class="form-text text-muted"><?php echo isset($project['Filees']) ? htmlentities($project['Filees']) : ''; ?></small>

                        <input class="form-control-file" type="file" id="filess" name="filess">

                    </div>









                    <div class="form-group">
                        <label>Description</label>
                        <textarea value="" rows="3" name="description" class="form-control">
                        <?php echo isset($project["Description"]) ? htmlentities($project["Description"]) : ''; ?>
                        </textarea>
                    </div>



                    <input type="hidden" name="id" value="<?php echo htmlentities($project["id"]); ?>">

                    <div class="submit-section">
                        <button type="submit" name="edit_project" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>