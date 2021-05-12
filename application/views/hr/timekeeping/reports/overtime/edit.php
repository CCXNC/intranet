<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color:white;"><h4>OVERTIME FORM<a href="<?php echo base_url(); ?>reports/index_ot" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/edit_employee_ot/<?php echo $ot->id; ?>" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6"> 
                <div class="form-group">
                    <label class="">*Employee Name </label>
                    <div class="form-control"><?php echo $ot->fullname; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Date of Overtime</label> 
                    <input type="date" class="form-control" name="date_ot" value="<?php echo $ot->date_ot; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Time Start of Overtime</label>
                    <input type="time" class="form-control" name="time_start" value="<?php echo $ot->time_start; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Time End of Overtime</label>
                    <input type="time" class="form-control" name="time_end" value="<?php echo $ot->time_end; ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">*Specific Task To Be Done</label>
                    <textarea class="form-control" name="task" id="" cols="30" rows="4"><?php echo $ot->task; ?></textarea>
                </div>
            </div>
        </div><br>
        <center>
        <input type="submit" onclick="return confirm('Do you want to update data?');" title="Submit Data" class="btn btn-info" name="SUBMIT" value="UPDATE">
        </center>
    </form>  
</div>