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
                                 <input class="form-control" type="text" name="asset_name" placeholder="<?php echo htmlentities($row->assetName); ?>">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Purchase Date</label>
                                 <input type="date" name="purchase_date" class="form-control" placeholder="<?php echo ($row->PurchaseDate) ? htmlentities($row->PurchaseDate) : ''; ?>">
                             </div>
                         </div>



                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Purchase From</label>
                                 <input class="form-control" type="text" name="purchase_from" value="<?php echo htmlentities($row->PurchaseFrom); ?>">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Manufacturer</label>
                                 <input name="manufacturer" class="form-control" type="text" value="<?php echo htmlentities($row->Manufacturer); ?>">
                             </div>
                         </div>
                     </div>

                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Model</label>
                                 <input name="model" class="form-control" type="text" value="<?php echo htmlentities($row->Model); ?>">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Supplier</label>
                                 <input name="supplier" class="form-control" type="text" value="<?php echo htmlentities($row->Supplier); ?>">
                             </div>
                         </div>
                     </div>
                     <!-- //*/* -->
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Status</label>

                                 <select name="status" class="form-control">

                                     <option value="0" <?php if ($row->Status == 0) echo 'selected'; ?>>Pending</option>
                                     <option value="1" <?php if ($row->Status == 1) echo 'selected'; ?>>Approved
                                     </option>
                                     <option value="2" <?php if ($row->Status == 2) echo 'selected'; ?>>Deployed
                                     </option>
                                     <option value="3" <?php if ($row->Status == 3) echo 'selected'; ?>>Damaged</option>
                                 </select>

                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Condition</label>
                                 <input name="condition" class="form-control" type="text" value="<?php echo htmlentities($row->AssetCondition); ?>">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Value/Price</label>
                                 <input name="value" class="form-control" type="text" value="<?php echo isset($row->$value) ? htmlentities($row->$value) : ''; ?>" placeholder="1800">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Asset User</label>
                                 <select name="asset_user" class="form-control">
                                     <option value="John Doe" <?php if ($asset_user == "John Doe") echo "selected"; ?>>
                                         John Doe
                                     </option>
                                     <option value="Richard Miles" <?php if ($asset_user == "Richard Miles") echo "selected"; ?>>
                                         Richard Miles
                                     </option>
                                 </select>


                             </div>



                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Warranty</label>
                                 <input name="warranty" class="form-control" type="text" value="<?php echo isset($row->$warranty) ? htmlentities($row->$warranty) : ''; ?>" placeholder="In Months">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label>Description</label>
                                 <input name="descriptiones" class="form-control" rows="2"><?php echo isset($row->$descriptiones) ? htmlentities($row->$descriptiones) : ''; ?></input>
                             </div>
                         </div>



                     </div>


                     <input type="hidden" name="id" value="<?php echo htmlentities($row->id); ?>">
                     <div class="submit-section">
                         <button type="submit" name="edit_asset" class="btn btn-primary submit-btn">Save</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>