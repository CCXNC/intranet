<div class="card">
    <div class="card-header"><h4>Change Password</h4></div>
    <div class="card-body">
        <?php if($this->session->flashdata('error_msg')) : ?>
            <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo base_url(); ?>/user/change_password/<?php echo $this->session->userdata('emp_id'); ?>/<?php echo $this->session->userdata('employee_number'); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>OLD PASSWORD</label>
                        <input type="text" class="form-control"  name="old_password" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NEW PASSWORD</label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" name="new_password" required>
                            <div class="input-group-addon" style="margin-left:5px; margin-top:5px;">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>	
            </div> 
            <center>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to change password?');" value="SUBMIT" >
                </div>
            </center>
        </form>
    </div>
</div>      

<script>
	$(document).ready(function() {
		$("#show_hide_password a").on('click', function(event) {
			event.preventDefault();
			if($('#show_hide_password input').attr("type") == "text")
			{
				$('#show_hide_password input').attr('type', 'password');
				$('#show_hide_password i').addClass( "fa-eye-slash" );
				$('#show_hide_password i').removeClass( "fa-eye" );
			}
			else if($('#show_hide_password input').attr("type") == "password")
			{
				$('#show_hide_password input').attr('type', 'text');
				$('#show_hide_password i').removeClass( "fa-eye-slash" );
				$('#show_hide_password i').addClass( "fa-eye" );
			}
		});
	});
</script>