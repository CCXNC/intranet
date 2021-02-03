<div class="card" style="width: 35rem;">
    <div class="card-header"><h4>EDIT BLAINE FORMS<a href="<?php echo base_url(); ?>forms/index" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <center>
        <form method="post" action="<?php echo base_url(); ?>forms/edit_forms/<?php echo $attachment->id; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" class="form-control" name="attachment1" value="<?php echo $attachment->name; ?>" required><br>
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Template"<?php echo $attachment->category == 'Template' ? 'selected' : ''; ?>>TEMPLATE</option>
                            <option value="Forms"<?php echo $attachment->category == 'Forms' ? 'selected' : ''; ?>>FORMS</option>
                        </select><br>
                        <p><?php echo $attachment->attachment; ?></p>
                        <input type='file' name='data1' size='20'/>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-info" onclick="return confirm('Do you want to update data?');">Update</button>
        </form>
    </center>
       
    
    </div>
</div>

