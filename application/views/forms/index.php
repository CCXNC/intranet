<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color:#1C4670; color:white;"><h4>Blaine Form List
<?php if($this->session->userdata('access_level_id') == 1) : ?><a href="#" class="btn btn-dark float-right"  data-toggle="modal" data-target="#exampleModal" style="border:1px solid #ccc; margin-right:10px;">ADD</a> <?php endif; ?>
    </h4> 
</div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Name</th>
            <th scope="col">Attachment</th>
            <th scope="col">Category</th>
            <?php if($this->session->userdata('access_level_id') == 1) : ?>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if($attachments) : ?>
        <?php foreach($attachments as $attachment) : ?>
            <tr>
                <td data-label="Name"><?php echo $attachment->name;  ?></td>
                <td data-label="Attachment"><a href="<?php echo base_url(); ?>forms/download_attachment/<?php echo $attachment->attachment; ?>"><?php echo $attachment->attachment; ?></a></td></td>
                <td data-label="Category"><?php echo $attachment->category;  ?></td>               
                <?php if($this->session->userdata('access_level_id') == 1 && $this->session->userdata('department_id') == 10 || $this->session->userdata('department_id') == 25) : ?>
                    <td data-label="Date"><?php echo date('F j, Y',strtotime($attachment->date)); ?></td>
                    <td data-label="Action">
                        <a href="<?php echo base_url(); ?>forms/edit_forms/<?php echo $attachment->id; ?>" class="btn btn-info " style="margin-right:10px; width: 100%">EDIT</a>
                        <a href="<?php echo base_url(); ?>forms/delete_form/<?php echo $attachment->id; ?>" onclick="return confirm('Are you sure you want to delete data?');" class="btn btn-danger " style="margin-right:10px; width: 100%">DELETE</a>
                    </td>
                <?php endif; ?>    
            </tr>        
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ADD ATTACHMENT</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>forms/add_attachment" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="attachment1" placeholder="Attachment name" style="text-transform:uppercase" required><br>
                            <select class="form-control" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Template">TEMPLATE</option>
                                <option value="Forms">FORMS</option>
                            </select><br>
                            <input type='file' name='data1' size='20' required/>
                            <p><i style="color: blue">Allowed file types: jpg | jpeg | png | gif | docx | xls | xlsx | pdf</i></p>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
    </div>
  </div>
</div>
<script type="text/javascript">  
    $(document).ready(function() {
        $('.display').DataTable( {
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