<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>User Account List
<a href="<?php echo base_url(); ?>productivity/index_softdev" class="btn btn-info float-right" title="Go Back" style="margin-right:10px;">BACK</a>
    </h4> 
</div>
<br>
<table id="" class="display" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Employee Name</th>
            <th scope="col">Username</th>
            <th scope="col">Default Password</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($users) : ?>
            <?php foreach($users as $user) : ?>
                <tr>
                    <td><?php echo $user->fullname; ?></td>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $user->default_password; ?></td>
                    <td><a style="background-color: #0C2D48; color: white" class="btn-sm" onclick="return confirm('Do you want to reset password?');"  href="<?php echo base_url(); ?>productivity/reset_password/<?php echo $user->employee_number; ?>">Reset Password</a></td>
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