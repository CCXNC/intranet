<div class="card">
    <div class="card-header"><h4>SHARE MY IDEA </h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/status/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">STATUS FORM</div>
                <div class="card-body">
                    <input type="text" name="id" value="<?php echo $idea->id; ?>" hidden>
                    <input type="text" name="control_number" value="<?php echo $idea->control_number; ?>" hidden>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <?php if($attach->status != 'Ongoing') : ?>
                                        <option value="Ongoing">Ongoing</option>
                                    <?php endif; ?>
                                    <option value="Implemented">Implemented</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea type="text" class="form-control" name="remarks" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="attachment" placeholder="Attachment name"><br>
                                <input type='file' name='data1' size='20' />
                            </div>
                        </div>
                    </div>    
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
            
        </form>
    </div>
</div>
