<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>UPDATE SUPPLIER INFORMATION<a href="<?php echo base_url(); ?>procurement/supplier_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">SUPPLIER DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Vendor Code</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="vendor_code" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Supplier Name</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="supplier_name" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Name</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="contact_name" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Designation</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="contact_designation" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact Number</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="number" class="form-control" name="contact_number" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="address" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Supplier Profile</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="supplier_profile" style="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Attachments</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type='file' name='attachments' size='20' />
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="Update Supplier Information" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
        </form>
    </div>
</div>