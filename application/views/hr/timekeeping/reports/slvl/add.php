<div class="card">
    <div class="card-header"><h4>LEAVE OF ABSENCE FORM<a href="<?php echo base_url(); ?>reports/index_slvl" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/add_slvl" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">Employee Name</label>
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
                    <label for="">Type</label>
                    <select class="form-control" name="type">
                        <option value="">Select Leave Type</option>
                        <option value="VL|VL">Vacation with Pay</option>
                        <option value="AB|VL W/O PAY">Vacation without Pay</option>
                        <option value="SL|SL">Sick with Pay</option>
                        <option value="AB|SL W/O PAY">Sick without Pay</option>
                        <option value="ML|ML">Maternity</option>
                        <option value="PL|PL">Paternity</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Effective Date of Leave (START)</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">&nbsp; (END)</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Day</label>
                    <select class="form-control" name="day">
                        <option value="">Select Day Type</option>
                        <option value="WD">WHOLEDAY</option>
                        <option value="HDAM">HALF DAY (AM)</option>
                        <option value="HDPM">HALF DAY (PM)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Address While On Leave</label>
                    <input type="text" class="form-control" name="address_leave">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Reason/s</label>
                    <textarea class="form-control" name="reason" id="" cols="30" rows="5"></textarea>
                </div>
            </div>
           
        </div><br>
        <center>
            <input type="submit" onclick="return confirm('Do you want to submit data?');" class="btn btn-info" value="SUBMIT">
        </center>
    </form>  
</div>