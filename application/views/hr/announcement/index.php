<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4>ANNOUNCEMENT LIST<a href="<?php echo base_url(); ?>announcement/do_upload" class="btn btn-info float-right">ADD</a></h4> </div>
    <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Announcement Picture</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($announcements) : ?>
                    <?php foreach($announcements as $announcement) : ?>
                        <tr>
                            <td><center><img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" width="150px" height="50px" alt=""></center></td>
                            <td><?php echo $announcement->title;  ?></td>
                            <td><?php echo $announcement->content;  ?></td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>announcement/view">View</a>
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>announcement/edit">Edit</a>
                                            <a class="dropdown-item" href="#">Delete</a>
                                        </div>
                                    </div>
                                </center>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

        
  