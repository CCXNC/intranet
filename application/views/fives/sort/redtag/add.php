<div class="card">
    <div class="card-header" title="Go Back" style="background-color:#1C4670; color:white;"><h4>RED TAG<a href="<?php echo base_url(); ?>fives/red_tag" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/red_tag_add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color:#1C4670; color:white;">Add Form</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" name="quantity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" id="" class="form-control">
                                    <option value="">Select Item Unit</option>
                                    <option value="Box">Box</option>
                                    <option value="Gallon/s">Gallon/s</option>
                                    <option value="Gram">Gram</option>
                                    <option value="Kilogram">Kilogram</option>
                                    <option value="Liter">Liter</option>
                                    <option value="Milligram">Milligram</option>
                                    <option value="Milliliter">Milliliter</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Piece/s">Piece/s</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Item Description</label>
                                <input type="text" class="form-control" name="item_description">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Item Location</label>
                                <input type="text" class="form-control" name="item_location">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category" id="" class="form-control">
                                    <option value="">Select Category</option>
                                    <option value="Equipment Or Tools">Equipment Or Tools</option>
                                    <option value="Files">Files</option>
                                    <option value="Finished Goods">Finished Goods</option>
                                    <option value="Maintenance Supplies">Maintenance Supplies</option>
                                    <option value="Office Equipment Or Supplies">Office Equipment Or Supplies</option>
                                    <option value="Raw Materials">Raw Materials</option>
                                    <option value="Work In-Process">Work In-Process</option>
                                    <option value="Unknown">Unknown</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Reason</label>
                                <textarea type="text" class="form-control" name="reason" rows="1" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Action</label>
                                <select name="action" id="" class="form-control">
                                    <option value="">Select Action</option>
                                    <option value="Descard">Descard</option>
                                    <option value="Move To Red Tag Area">Move To Red Tag Area</option>
                                    <option value="Move To">Move To</option>
                                    <option value="Recycle">Recycle</option>
                                    <option value="Returned To">Returned To</option>
                                    <option value="Shred">Shred</option>
                                    <option value="Storage">Storage</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tagged By</label>
                                <select name="employee" id="" class="form-control">
                                    <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                    <option value="<?php echo $employee->fullname . '|' . $employee->department_id . '|' . $employee->company_id; ?>"<?php echo $this->session->userdata('employee_number') == $employee->emp_no ? 'selected' : ''; ?>><?php echo $employee->fullname; ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Attachment</label>
                                <input type='file' name='attachment1' size='20' />
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="Submit Idea" class="btn" style="background-color:#1C4670; color:white;" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
            
        </form>
    </div>
</div>
