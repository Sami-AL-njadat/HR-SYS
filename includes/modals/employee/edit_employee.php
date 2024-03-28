<div id="edit_employee" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="includes/functions.php" enctype="multipart/form-data" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">

                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                <input class="form-control" id="first_name" name="first_name" type="text">
                            </div>
                            <input type="hidden" name="emp_id" id="id">

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Last Name</label>
                                <input class="form-control" id="last_name" name="last_name" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                <input class="form-control" id="username" name="username" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input class="form-control" id="email_em" name="email_em" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Password</label>
                                <input class="form-control" name="password" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Confirm Password</label>
                                <input class="form-control" name="confirmpassword" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                <input type="text" id="employee_id" readonly="" class="form-control floating">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                <div class=""><input id="joining_date" name="joining_date" class="form-control"
                                        type="date"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Phone </label>
                                <input class="form-control" id="Phone_e" name="phone_e" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Departments</label>
                                <!-- <?php
										// $dsepartment_From_Seseion = $_SESSION['department_e'];
										?> -->
                                <select class="form-control	" name="Department_e">
                                    <?php


									$sql = "SELECT * FROM departments";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $row) {

									?>

                                    <option><?php echo $row->Department ?></option>




                                    <?php }
									} ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
							<div class="form-group">
								<label>Department <span class="text-danger">*</span></label>
								<select class="select">
									<option>Select Department</option>
									<option>Web Development</option>
									<option>IT Management</option>
									<option>Marketing</option>
								</select>
							</div>
						</div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation <span class="text-danger">*</span></label>
                                <select class="form-control" name="designation">
                                    <?php



									$sql = "SELECT * FROM designations";
									$query = $dbh->prepare($sql);
									$query->execute();
									$results = $query->fetchAll(PDO::FETCH_OBJ);
									$cnt = 1;
									if ($query->rowCount() > 0) {
										foreach ($results as $row) {

									?>

                                    <option class="designation_e"><?php echo $row->Designation  ?></option>




                                    <?php }
									} ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" name="edit_employee">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>