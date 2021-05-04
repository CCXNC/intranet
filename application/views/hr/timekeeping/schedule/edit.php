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
    <div class="card-header" style="background-color:#0C2D48; border:#0C2D48; color:white;"><h4>EDIT EMPLOYEE SCHEDULE<a href="<?php echo base_url(); ?>schedule/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div> 
        <form method="post" action="<?php echo base_url(); ?>schedule/edit_schedule/<?php echo $schedule->id; ?>" enctype="multipart/form-data"> 
            <div class="form-group">
                <label class="form-check-label"><p>EMPLOYEE NAME</p></label><br>
                <input type="text" class="form-control col-md-6" readonly value="<?php echo $schedule->fullname; ?>">
            </div>
            <!--<?php 
                $week = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]; 
                $count_week = count($week);
                $days = explode(',',$schedule->days);
                $count_data = count($days);
                //echo $count_data;
                // echo $days[0];
            ?>
            <div class="form-group">
                <input type="checkbox" id="checkAll" name="">                       
                <label class="form-check-label"><p>5 DAYS</p></label><br>

                <?php for($i=0; $count_week > $i; $i++) : ?>
                    <input type="checkbox" class="check"  name="days[]" value="<?php echo $week[$i]; ?>"
                    <?php for($a=0; $count_data > $a; $a++) : ?><?php echo $week[$i] == $days[$a] ? 'checked' : ' '; ?><?php endfor; ?>>
                    <label for="vehicle3">&nbsp;<?php echo $week[$i]; ?>&nbsp;</label>
                <?php endfor; ?>    
            </div>-->
            <div class="form-group">
                <label class="form-check-label"><p>TIME IN</p></label>
                <div class="form-group">
                    <input class="form-control col-md-6" type="time" name="time_in" value="<?php echo $schedule->time_in; ?>">
                </div> 
            </div>   
            <div class="form-group">
                <label class="form-check-label"><p>TIME OUT</p></label>
                <div class="form-group">
                    <input class="form-control col-md-6" type="time" name="time_out" value="<?php echo $schedule->time_out; ?>">
                </div> 
            </div>   
            <div class="form-group">
                <label class="form-check-label"><p>GRACE PERIOD (MINUTES)</p></label>
                <div class="form-group">
                    <input class="form-control col-md-6" type="number" name="grace_period" value="<?php echo $schedule->grace_period; ?>">
                </div> 
            </div> 
            <div class="form-group">
                <label class="form-check-label"><p>EFFECTIVE DATE</p></label>
                <input type="date" class="form-control col-md-6" name="effective_date" value="<?php echo $schedule->effective_date; ?>">
            </div>    
            <br>
            <div class="form-group">
                <center>
                    <input type="submit" title="Update Employee Schedule" class="btn btn-info" onclick="return confirm('Do you want to update data?');" value="UPDATE">
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