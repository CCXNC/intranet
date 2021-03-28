<div class="card">
    <div class="card-header" style="background-color: #38c172;color: white;"><h4>EDIT LEAVE OF ABSENCE FORM<a href="<?php echo base_url(); ?>reports/index_slvl" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>reports/edit_employee_slvl/<?php echo $leave->id; ?>" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">Employee Name</label>
                        <input type="text" class="form-control" value="<?php echo $leave->fullname; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Type</label>
                        <select class="form-control" name="type">
                            <option value="VL|VL"<?php echo $leave->type_name == 'VL' ? 'selected' : ''; ?>>VL</option>
                            <option value="SL|SL"<?php echo $leave->type_name == 'SL' ? 'selected' : ''; ?>>SL</option>
                            <option value="AB|NO WORK SCHEDULE"<?php echo $leave->type_name == 'NO WORK SCHEDULE' ? 'selected' : ''; ?>>No Work Schedule</option>
                            <option value="VL|VL"<?php echo $leave->type_name == 'VACATION LEAVE' ? 'selected' : ''; ?>>Vacation with Pay</option>
                            <option value="AB|VL W/O PAY"<?php echo $leave->type_name == 'VL W/O PAY' ? 'selected' : ''; ?>>Vacation without Pay</option>
                            <option value="SL|SL"<?php echo $leave->type_name == 'SICK LEAVE' ? 'selected' : ''; ?>>Sick with Pay</option>
                            <option value="AB|SL W/O PAY"<?php echo $leave->type_name == 'SL W/O PAY' ? 'selected' : ''; ?>>Sick without Pay</option>
                            <option value="ML|ML"<?php echo $leave->type_name == 'ML' ? 'selected' : ''; ?>>Maternity</option>
                            <option value="PL|PL"<?php echo $leave->type_name == 'PL' ? 'selected' : ''; ?>>Paternity</option>
                            <option value="BL|BL"<?php echo $leave->type_name == 'BL' ? 'selected' : ''; ?>>Bereavement Leave</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Effective Date of Leave</label>
                        <input type="date" class="form-control" name="leave_date" value="<?php echo $leave->leave_date; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Day</label>
                        <select class="form-control" name="day">
                            <option value="WD"<?php echo $leave->leave_day == 'WD' ? 'selected' : ''; ?>>WHOLEDAY</option>
                            <option value="HDAM"<?php echo $leave->leave_day == 'HDAM' ? 'selected' : ''; ?>>HALF DAY (AM)</option>
                            <option value="HDPM"<?php echo $leave->leave_day == 'HDPM' ? 'selected' : ''; ?>>HALF DAY (PM)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Address While On Leave</label>
                        <input type="text" class="form-control" name="address_leave" value="<?php echo $leave->leave_address; ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Reason/s</label>
                        <textarea class="form-control" name="reason" id="" cols="30" rows="5"><?php echo $leave->reason; ?></textarea>
                    </div>
                </div>
            
            </div><br>
            <center>
                <input type="submit" onclick="return confirm('Do you want to update data?');" class="btn btn-info" value="UPDATE">
            </center>
        </form>  
    </div>    
</div>