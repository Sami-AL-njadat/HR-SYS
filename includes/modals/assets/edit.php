<div id="edit_asset" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Asset</h5>
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
                                <input name="asset_name" class="form-control" type="text"
                                    value="<?php echo $asset_info['assetName']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asset Id</label>
                                <input name="asset_id" class="form-control" type="text"
                                    value="<?php echo $asset_info['assetId']; ?>" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input name="purchase_date" class="form-control datetimepicker" type="text"
                                    value="<?php echo $asset_info['PurchaseDate']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase From</label>
                                <input name="purchase_from" class="form-control" type="text"
                                    value="<?php echo $asset_info['PurchaseFrom']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Manufacturer</label>
                                <input name="manufacturer" class="form-control" type="text"
                                    value="<?php echo $asset_info['Manufacturer']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Model</label>
                                <input name="model" class="form-control" type="text"
                                    value="<?php echo $asset_info['Model']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Serial Number</label>
                                <input name="serial_number" class="form-control" type="text"
                                    value="<?php echo $asset_info['SerialNumber']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supplier</label>
                                <input name="supplier" class="form-control" type="text"
                                    value="<?php echo $asset_info['Supplier']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Condition</label>
                                <input name="condition" class="form-control" type="text"
                                    value="<?php echo $asset_info['AssetCondition']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Warranty</label>
                                <input name="warranty" class="form-control" type="text"
                                    value="<?php echo $asset_info['Warranty']; ?>" placeholder="In Months">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Value</label>
                                <input name="value" class="form-control" type="text"
                                    value="<?php echo $asset_info['Price']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asset User</label>
                                <select name="asset_user" class="select">
                                    <option <?php if ($asset_info['AssetUser'] == 'John Doe') echo 'selected'; ?>>John
                                        Doe</option>
                                    <option <?php if ($asset_info['AssetUser'] == 'Richard Miles') echo 'selected'; ?>>
                                        Richard Miles</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description"
                                    class="form-control"><?php echo $asset_info['Description']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="select">
                                    <option value="0" <?php if ($asset_info['Status'] == 0) echo 'selected'; ?>>Pending
                                    </option>
                                    <option value="1" <?php if ($asset_info['Status'] == 1) echo 'selected'; ?>>Approved
                                    </option>
                                    <option value="2" <?php if ($asset_info['Status'] == 2) echo 'selected'; ?>>Deployed
                                    </option>
                                    <option value="3" <?php if ($asset_info['Status'] == 3) echo 'selected'; ?>>Damaged
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" name="edit_asset" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>