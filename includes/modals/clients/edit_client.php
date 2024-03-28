<?php

$profile_image_path = "clients/" . $row->Picture;
?>

<div id="edit_client" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                <input name="firstname" class="form-control"
                                    value="<?php echo htmlentities($row->FirstName); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Last Name</label>
                                <input name="lastname" class="form-control"
                                    value="<?php echo htmlentities($row->LastName); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                <input name="username" class="form-control"
                                    value="<?php echo htmlentities($row->UserName); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input name="email" class="form-control floating"
                                    value="<?php echo htmlentities($row->Email); ?>" type="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Phone </label>
                                <input name="phone" class="form-control"
                                    value="<?php echo htmlentities($row->Phone); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Company Name</label>
                                <input name="company" class="form-control" type="text"
                                    value="<?php echo htmlentities($row->Company); ?>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Update Image </label>

                                <input type="file" class="form-control" name="propic" id="image">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Current Image</label>

                                <img class="form-control" name="test" id="showImage"
                                    src="<?php echo $profile_image_path; ?>" alt="Current Image"
                                    style="max-width: 180px;height: 80px">
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="id" value="<?php echo htmlentities($row->id); ?>">

                    <div class="submit-section">
                        <button type="submit" name="edit_client" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('image').addEventListener('change', function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('showImage').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });
});
</script>