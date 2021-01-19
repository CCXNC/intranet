<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4>ANNOUNCEMENT LIST<a href="<?php echo base_url(); ?>announcement/do_upload" class="btn btn-info float-right">ADD</a></h4> </div>
    <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($announcement) : ?>
                    <?php foreach($announcement as $announcement) : ?>
                        <tr>
                            <td style="width: 10%"><img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" style="width:100%" alt=""></td>
                            <td style="width: 10%"><?php echo $announcement->category;  ?></td>
                            <td style="width: 20%"><?php echo $announcement->title;  ?></td>
                            <td style="width: 30%"><?php echo word_limiter($announcement->content,10); ?></td>
                            <td style="width: 20%"><?php echo $announcement->created_date; ?></td>
                            <td style="width: 10%">
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>announcement/view_announcement/<?php echo $announcement->id; ?>"> View</a>
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>announcement/edit/<?php echo $announcement->id; ?>">Edit</a>
                                            <a onclick="return confirm('Are you sure you want to delete data?');" class="dropdown-item" href="<?php echo base_url(); ?>announcement/delete/<?php echo $announcement->id?>">Delete</a>
                                        </div>
                                    </div>
                                </center>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="float-right">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>

        
  