<style>
    p {
        font-size: 18px;
    }
</style>
<div class="card" style="width: 30rem;"> 
    <div class="card-header"><h4>EDIT EMPLOYEE BIOMETRIC<a href="<?php echo base_url(); ?>schedule/index" class="btn btn-dark float-right" title="Go Back" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <form method="post" action="<?php echo base_url(); ?>schedule/edit_biometric/<?php echo $bio->employee_number; ?>" enctype="multipart/form-data">           
    <div class="form-group">
                <label class="form-check-label"><p>EMPLOYEE NAME</p></label><br>
                <input type="text" class="form-control" readonly value="<?php echo $bio->fullname; ?>">
            </div>
            <div class="form-group">
                <label class="form-check-label"><p>BIOMETRIC ID</p></label>
                <div class="form-group">
                    <input class="form-control" type="text" name="biometric_id" value="<?php echo $bio->biometric_id; ?>">
                </div> 
            </div> 
            <br>
            <div class="form-group">
                <center>
                    <input type="submit" title="Update Employee Biometric" class="btn btn-info" onclick="return confirm('Do you want to update data?');" value="UPDATE">
                </center>
            </div>  
                       
        </form>
    </div>
</div>