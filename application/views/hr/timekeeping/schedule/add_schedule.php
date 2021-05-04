<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card">
    <div class="card-header" style="background-color: #0C2D48; border: #0C2D48; color: white"><h4>ADD EMPLOYEE SCHEDULE
    <a href="<?php echo base_url(); ?>schedule/index" class="btn btn-dark float-right" title="Add Employee Schedule" style="border:1px solid #ccc; margin-right:10px;color:white;">BACK</a>
    </h4> 
    </div>
    <div class="card-body" >
        <form method="post" action="<?php echo base_url(); ?>schedule/add_employee_schedule/<?php echo $employee_schedule->employee_number; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">EMPLOYEE NAME</label>
                        <div class="form-control" readonly><?php echo $employee_schedule->fullname; ?></div>
                        <input type="text" name="employee_number" hidden value="<?php echo $employee_schedule->employee_number; ?>">
                        <input type="text" name="biometric_number" hidden value="<?php echo $employee_schedule->biometric_id; ?>">
                    </div>  
                </div>    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">START DATE</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>  
                </div>     
                <div class="col-md-6"> 
                    <div class="form-group">    
                        <label for="">END DATE</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div> 
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">    
                        <label for="">TIME IN</label>
                        <input type="time" class="form-control" name="time_in" required>
                    </div> 
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">    
                    <label for="">TIME OUT</label>
                        <input type="time" class="form-control" name="time_out" required>
                    </div> 
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">    
                        <label for="">GRACE PERIOD</label>
                        <input type="text" class="form-control" name="grace_period" required>
                    </div> 
                </div>
            </div>
            <br>
            <div class="form-group">
                <center>
                    <input type="submit" title="Submit Employee Schedule" class="btn btn-info" onclick="return confirm('Do you want to submit data?');" value="SUBMIT">
                </center>
            </div>    
        </form>
    </div>
</div>
    
                                                