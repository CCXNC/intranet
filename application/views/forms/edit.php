<div class="card">
    <div class="card-header"><h4>EDIT BLAINE FORMS<a href="<?php echo base_url(); ?>forms/index" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <center>
        <form method="post" action="<?php echo base_url(); ?>forms/edit_forms/<?php echo $attachment->id; ?>" enctype="multipart/form-data">
           
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="attachment1" value="<?php echo $attachment->name; ?>" required><br>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Template"<?php echo $attachment->category == 'Template' ? 'selected' : ''; ?>>TEMPLATE</option>
                                    <option value="Forms"<?php echo $attachment->category == 'Forms' ? 'selected' : ''; ?>>FORMS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p><?php echo $attachment->attachment; ?></p>
                            <input type='file' name='data1' size='20'/>
                        </div>
                        
                    </div>
            <br>
            <button type="submit" title="Update Form" class="btn btn-info" onclick="return confirm('Do you want to update data?');">Update</button>
        </form>
    </center>
       
    
    </div>
</div>

