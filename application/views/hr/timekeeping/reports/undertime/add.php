<div class="card">
    <div class="card-header"  style="background-color: #067593;color:white;"><h4>UNDERTIME FORM<a href="<?php echo base_url(); ?>reports/index_ut" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/add_ut" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">*Employee Name</label>
                    <select name="employee" class="form-control col-md-12">  
                        <option value="">SELECT EMPLOYEE</option>
                        <?php if($employees) : ?>
                        <?php foreach($employees as $employee) : ?>
                            <option value="<?php echo $employee->emp_no . '|' . $employee->department_id . '|' . $employee->company_id; ?>"><?php echo $employee->fullname; ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Date of Undertime</label>
                    <input type="date" class="form-control" name="date_ut">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Time Start of Undertime</label>
                    <input type="time" class="form-control" name="time_start" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Time End of Undertime</label>
                    <input type="time" class="form-control" name="time_end" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">*Reason</label>
                    <textarea class="form-control" name="reason" id="" cols="30" rows="4"></textarea>
                </div>
            </div>
        </div><br>
        <center>
            <input type="submit" onclick="return confirm('Do you want to submit data?');" title="Submit Data" class="btn btn-info" name="SUBMIT">
        </center>
    </form>  
</div>