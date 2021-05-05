<style>
    p {
        font-size: 18px;
    }
</style>
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card" style="width: 50rem;"> 
    <div class="card-header" style="background-color:#0C2D48; border:#0C2D48; color:white;"><h4>ADD EMPLOYEE DEFAULT SCHEDULE<a href="<?php echo base_url(); ?>schedule/index" id="back" title="Go Back" class="btn btn-dark float-right"style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <form method="post" action="<?php echo base_url(); ?>schedule/add_schedule" enctype="multipart/form-data">           
            <div class="form-group">
                <label class="form-check-label"><p>EMPLOYEE NAME</p></label><br>
                <select name="employee_number" class="form-control col-md-6">
                    <?php if($schedules) : ?>
                        <?php foreach($schedules as $schedule) : ?>
                            <option value="<?php echo $schedule->employee_number . '|' . $schedule->biometric_id . '|' . $schedule->id; ?>"><?php echo $schedule->fullname; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <!--<div class="form-group">
                <input type="checkbox" id="checkAll" name="">                      
                <label class="form-check-label"><p>5 DAYS</p></label><br>
                <input type="checkbox" class="check"  name="days[]" value="Monday">
                <label for="vehicle3">&nbsp;MONDAY&nbsp;</label>
                <input type="checkbox" class="check" name="days[]" value="Tuesday">
                <label for="vehicle1">&nbsp;TUESDAY&nbsp;</label>
                <input type="checkbox" class="check" name="days[]" value="Wednesday">
                <label for="vehicle2">&nbsp;WEDNESDAY&nbsp;</label>
                <input type="checkbox" class="check" name="days[]" value="Thursday">
                <label for="vehicle2">&nbsp;THURSDAY&nbsp;</label>
                <input type="checkbox" class="check" name="days[]" value="Friday">
                <label for="vehicle2">&nbsp;FRIDAY&nbsp;</label>
                <input type="checkbox" name="days[]" value="Saturday">
                <label for="vehicle2">&nbsp;SATURDAY&nbsp;</label>
                <input type="checkbox" name="days[]" value="Sunday">
                <label for="vehicle2">&nbsp;SUNDAY&nbsp;</label>
            </div>-->
            <div class="form-group">
                <label class="form-check-label"><p>TIME IN</p></label>
                <div class="form-group">
                    <input class="form-control col-md-6" type="time" name="time_in" >
                </div> 
            </div>   
            <div class="form-group">
                <label class="form-check-label"><p>TIME OUT</p></label>
                <div class="form-group">
                    <input class="form-control col-md-6" type="time" name="time_out" >
                </div> 
            </div>   
            <div class="form-group">
                <label class="form-check-label"><p>GRACE PERIOD (MINUTES)</p></label>
                <div class="form-group">
                    <input class="form-control col-md-6" type="number" name="grace_period" >
                </div> 
            </div> 
            <div class="form-group">
                <label class="form-check-label"><p>EFFECTIVE DATE</p></label>
                <input type="date" class="form-control col-md-6" name="effective_date">
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
<script>
    $("#checkAll").click(function(){
   	    $('.check').not(this).prop('checked', this.checked);
	});
</script>