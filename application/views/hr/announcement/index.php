<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
    <div class="card-header"><h4>ANNOUNCEMENT LIST<a href="<?php echo base_url(); ?>announcement/add" title="Add Announcement" class="btn btn-info float-right">ADD</a></h4> </div>
    <br>
    <table id="" class="display" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Picture</th>
                <th scope="col">Category</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if($announcement) : ?>
                <?php foreach($announcement as $announcement) : ?>
                    <tr>
                        <td data-label="Picture"><img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" style="width:250px; height: 80px;" alt=""></td>
                        <td data-label="Category"><?php echo $announcement->category;  ?></td>
                        <td data-label="Title"><?php echo $announcement->title;  ?></td>
                        <td data-label="Content"><?php echo word_limiter($announcement->content,10); ?></td>
                        <td data-label="Date"><?php echo date('F j Y', strtotime($announcement->created_date)); ?></td>
                        <td data-label="Action">
                            <div class="btn-group">
                                <button type="button" title="View Actions" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" title="View Announcement" href="<?php echo base_url(); ?>announcement/view_announcement/<?php echo $announcement->id; ?>"> View</a>
                                    <a class="dropdown-item" title="Edit Announcement" href="<?php echo base_url(); ?>announcement/edit/<?php echo $announcement->id; ?>">Edit</a>
                                    <a onclick="return confirm('Are you sure you want to delete data?');" title="Delete Announcement" class="dropdown-item" href="<?php echo base_url(); ?>announcement/delete/<?php echo $announcement->id?>">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('table.display').DataTable( {
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
           "scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );
    } );
</script>

        
  