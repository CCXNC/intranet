<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>EDIT ACTIVE DIRECTORY<a href="<?php echo base_url(); ?>productivity/index_active_directory" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <form method="post" action="<?php echo base_url(); ?>productivity/edit_active_directory/<?php echo $active_directory->id; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <center>
                        <?php if($active_directory->picture != NULL) : ?>
                            <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $active_directory->picture; ?>" style="width:200px; height:250px;" alt="">
                        <?php else : ?>
                            <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width:10%" alt="">
                        <?php endif; ?> 
                    </center>     
                </div> 
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Employee Name</label>
                            <input type="text" class="form-control" name="fullname" readonly value="<?php echo $active_directory->fullname; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="">Department</label>
                            <input type="text" class="form-control" readonly value="<?php echo $active_directory->department; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo $active_directory->email; ?>"><br>
                        </div>
                        <div class="col-md-3">
                            <label for="">Telephone No.</label>
                            <input type="text" class="form-control" name="telephone_no" value="<?php echo $active_directory->telephone_no; ?>"><br>
                        </div>
                    </div>
                </div>
                <center><button type="submit" title="Update Form" class="btn btn-info" onclick="return confirm('Do you want to update data?');">Update</button></center>
        </form>
    </div>
</div>

