<div class="card">
    <div class="card-header"  style="background-color: #067593;color:white;"><h4>UNDERTIME FORM<a href="<?php echo base_url(); ?>reports/index_ut" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>reports/edit_employee_ut/<?php echo $ut->id; ?>" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">Employee Name</label>
                        <input type="text" class="form-control" value="<?php echo $ut->fullname; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">*Date of Undertime</label>
                        <input type="date" class="form-control" name="date_ut" value="<?php echo $ut->date_ut; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">*Time Start of Undertime</label>
                        <input type="time" class="form-control" name="time_start" value="<?php echo $ut->time_start; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">*Time End of Undertime</label>
                        <input type="time" class="form-control" name="time_end" value="<?php echo $ut->time_end; ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">*Reason</label>
                        <textarea class="form-control" name="reason" id="" cols="30" rows="4"><?php echo $ut->reason; ?></textarea>
                    </div>
                </div>
            </div><br>
            <center>
                <input type="submit" onclick="return confirm('Do you want to update data?');" title="Submit Data" class="btn btn-info" value="UPDATE">
            </center>
        </form>  
    </div>    
</div>