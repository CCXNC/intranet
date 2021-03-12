<div class="card">
    <div class="card-header"><h4>EDIT ANNOUNCEMENT<a href="<?php echo base_url(); ?>announcement/index" title="Go Back" id="back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
        <div class="card-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
                <form method="post" action="<?php echo base_url(); ?>announcement/edit/<?php echo $announcement->id; ?>" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">Announcement</div>
                        <div class="card-body">
                            <div class="form-group">
                                <center>
                                    <?php if($announcement->image != NULL) : ?>
                                        <img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" style="width: 80%" alt="">
                                    <?php else : ?>
                                        <img src="<?php echo base_url(); ?>uploads/announcement/announcement.png" style="width: 80%" alt="">
                                    <?php endif; ?>  
                                </center>                           
                            </div> 
                            <input type='file' name='image' size='20' />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control"  name="title" value="<?php echo $announcement->title; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>*Category</label>
                                        <select class="form-control" name="category">
                                            <option value="">Select Category</option>
                                            <option value="loginpage"<?php echo $announcement->category == 'loginpage' ? 'selected' : ''; ?>>Loginpage</option>
                                            <option value="homepage"<?php echo $announcement->category == 'homepage' ? 'selected' : ''; ?>>Homepage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <input type="text" class="form-control"  name="content" value="<?php echo $announcement->content; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <center>
                    <br>
                        <div class="form-group">
                            <input type="submit" title="Update Announcement" class="btn btn-success" onclick="return confirm('Do you want to update data?');" value="UPDATE" >
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
