
<div class="card">
    <div class="card-header"><h4>VIEW ANNOUNCEMENT</h4></div>
        <div class="card-body">
            
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                        <img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" alt="" style="width: 80%"><br><br>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <div class="form-control"><?php echo $announcement->title; ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <div class="form-control"><?php echo $announcement->category; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <div class="form-control"><?php echo $announcement->content; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>
