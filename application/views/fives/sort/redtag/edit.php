<div class="card">
    <div class="card-header" title="Go Back" style="background-color:#1C4670; color:white;"><h4>RED TAG<a href="<?php echo base_url(); ?>fives/red_tag" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/add_red_tag" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color:#1C4670; color:white;">Edit Form</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" id="" class="form-control">
                                    <option value="">Select Item Unit</option>
                                    <option value="Box">Box</option>
                                    <option value="Pieces">Pieces</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Item Description</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Item Location</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="unit" id="" class="form-control">
                                    <option value="">Select Category</option>
                                    <option value="Box">Equipment Or Tools</option>
                                    <option value="Pieces">Files</option>
                                    <option value="">Finished Goods</option>
                                    <option value="">Maintenance Supplies</option>
                                    <option value="">Office Equipment Or Supplies</option>
                                    <option value="">Raw Materials</option>
                                    <option value="">Work In-Process</option>
                                    <option value="">Unknown</option>
                                    <option value="">Others</option>
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
                                <select name="unit" id="" class="form-control">
                                    <option value="">Select Action</option>
                                    <option value="Box">Descard</option>
                                    <option value="Pieces">Move To Red Tag Area</option>
                                    <option value="">Move To</option>
                                    <option value="">Recycle</option>
                                    <option value="">Returned To</option>
                                    <option value="">Shred</option>
                                    <option value="">Storage</option>
                                    <option value="">Others</option>
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
                                <input type='file' name='data1' size='20' />
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
