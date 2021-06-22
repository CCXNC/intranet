<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>Active Directory List
<a href="<?php echo base_url(); ?>productivity/index_it" class="btn btn-info float-right" title="Go Back" style="margin-right:10px;">BACK</a>
    </h4> 
</div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th>Employee Picture</th>
            <th scope="col">Employee Name</th>
            <th scope="col">Department</th>
            <th scope="col">Email</th>
            <th scope="col">Telephone No.</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($active_directories) : ?>
            <?php foreach($active_directories as $active_directory) : ?>
                <tr>
                    <td data-label="Employee Picture">
                        <?php if($active_directory->picture != NULL) : ?>
                            <center>
                                <img class="emppic" src="<?php echo base_url(); ?>uploads/employee/<?php echo $active_directory->picture; ?>" style="width:75px; height:75px;" alt="">
                            </center>
                        <?php else : ?>
                            <center>
                                <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width: 100px; height: 100px;"  alt="">
                            </center>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $active_directory->fullname; ?></td>
                    <td><?php echo $active_directory->department; ?></td>
                    <td>
                        <?php
                            if($active_directory->email == NULL){
                                echo '<p class="" style="text-align:center; padding:15px; background-color: #E7D2CC;"></p>';
                            }
                            else{
                                echo $active_directory->email;
                            } 
                        ?>
                    </td>
                    <td><?php echo $active_directory->telephone_no; ?></td>
                    <td data-label="Action">
                        <a href="<?php echo base_url(); ?>productivity/edit_active_directory/<?php echo $active_directory->id; ?>" title="Edit Form" class="btn btn-info " style="margin-right:10px; width: 100%">EDIT</a>
                    </td>
                  
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
  
</table>
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
            //"scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );
    } );
</script>