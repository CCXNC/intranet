<div class="card">
    <div class="card-header" style="background-color:#1C4670; color:white;"><h4>5S SHARE MY IDEA <a href="<?php echo base_url(); ?>fives/idea" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/edit_status/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color:#1C4670; color:white;">EDIT STATUS FORM</div>
                <div class="card-body">
                    <input type="text" name="control_number" value="<?php echo $idea->control_number; ?>" hidden>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" name="status" class="form-control" value="<?php echo $idea->status; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea type="text" class="form-control" name="remarks" rows="4" cols="50"><?php echo $idea->remarks; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <p><?php echo $idea->file; ?></p>
                                <input type='file' name='data1' size='20' />
                            </div>
                        </div>
                    </div>    
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" class="btn" style="background-color:#1C4670; color:white;" onclick="return confirm('Do you want to update data?');" value="UPDATE" >
                </div>
            </center>
            
        </form>
    </div>
</div>
