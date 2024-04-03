<?php $set = '1234567890';
$id = substr(str_shuffle($set), 0, 6); ?>
<div id="add_asset" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asset Name</label>
                                <input required name="asset_name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asset Id</label>
                                <input readonly name="asset_id" value="<?php echo '#AST-' . $id; ?>"
                                    class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input required type="date" name="purchase_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase From</label>
                                <input required name="purchase_from" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Manufacturer</label>
                                <input required name="manufacturer" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Model</label>
                                <input required name="model" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select required name="status" class="select">
                                    <option value="0">New</option>
                                    <option value="1">Used</option>
                                    <option value="2">Maintenance</option>
                                    <option value="3">Damaged</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supplier</label>
                                <input required name="supplier" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Condition</label>
                                <input required name="condition" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Warranty</label>
                                <input required name="warranty" class="form-control" type="text"
                                    placeholder="In Months">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Value/Price</label>
                                <input placeholder="1800" required name="value" class="form-control" type="number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asset User</label>
                                <select name="asset_user" class="select">
                                    <?php
                                    $sql = "SELECT id, FirstName, LastName FROM employees";
                                    $query = $dbh->query($sql);
                                    $employees = $query->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($employees as $employee) {
                                        echo "<option value=\"{$employee['id']}\">{$employee['FirstName']} {$employee['LastName']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea required name="descriptiones" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="submit-section">
                        <button type="submit" name="add_asset" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>