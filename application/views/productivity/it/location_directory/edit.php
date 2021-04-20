<div class="card">
    <div class="card-header"><h4>EDIT LOCATION DIRECTORY<a href="<?php echo base_url(); ?>productivity/index_location_directory" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>productivity/edit_location_directory/<?php echo $location_directory->id; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $location_directory->name; ?>"><br>
                        </div>
                        <div class="col-md-6">
                            <label for="">Telephone No.</label>
                            <input type="text" class="form-control" name="telephone_no" value="<?php echo $location_directory->telephone_no; ?>"><br>
                        </div>
                    </div>
                </div>
                <center><button type="submit" title="Update Form" class="btn btn-info" onclick="return confirm('Do you want to update data?');">Update</button></center>
        </form>
    </div>
</div>

