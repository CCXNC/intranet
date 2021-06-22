<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>Location Directory List
<a href="<?php echo base_url(); ?>productivity/index_it" class="btn btn-info float-right" title="Go Back" style="margin-right:10px;">BACK</a><a href="#"  data-toggle="modal" data-target="#exampleModal" class="btn btn-info float-right" title="Go Back" style="margin-right:10px;">ADD</a></h4> 
</div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Name</th>
            <th scope="col">Telephone No.</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($location_directories) : ?>
        <?php foreach($location_directories as $loc_directory) :?>
            <tr>
                <td><?php echo strtoupper($loc_directory->name); ?></td>
                <td><?php echo $loc_directory->telephone_no; ?></td>
                <td data-label="Action">
                    <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo base_url();?>productivity/edit_location_directory/<?php echo $loc_directory->id; ?>">Edit</a>
                            <a class="dropdown-item" onclick="return confirm('Do you want to delete data?');" href="<?php echo base_url(); ?>productivity/delete_location_directory/<?php echo $loc_directory->id; ?>">Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ADD LOCATION DIRECTORY</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>productivity/add_location_directory" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="NAME" style="text-transform:uppercase" required><br>
                            <input type="text" class="form-control" name="telephone_no" placeholder="TELEPHONE NO" style="text-transform:uppercase" required><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" title="Close Form" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" title="Submit Form" class="btn btn-primary" onclick="return confirm('Do you want to submit data?');"  >Submit</button>
            </div>
            </form>
    </div>
  </div>
</div>
<script type="text/javascript">  
    $(document).ready(function() {
        $('.display').DataTable( {
            "bStateSave": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );
    } );
</script>