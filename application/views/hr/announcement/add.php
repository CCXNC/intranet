<div class="card">
    <div class="card-header"><h4>ADD ANNOUNCEMENT</h4></div>
        <div class="card-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>announcement/do_upload" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <center>
                                    <img src="<?php echo base_url(); ?>assets/images/newsimage.png" alt="" style="width: 30%"><br><br>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type='file' name='userfile' size='20' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    <option value="">Select Category</option>
                                    <option value="loginpage">Login Page</option>
                                    <option value="homepage">Homepage</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content</label>
                                <textarea class="form-control" name="content" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" >
                                <input type="submit" class="btn btn-success float-right"  value="SUBMIT" >
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>