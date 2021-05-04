<div class="card">
    <div class="card-header" style="background-color:#478C5C; color:white;"><h4>Economic Holiday List<a href="<?php echo base_url(); ?>calendar/calendar_list" title="Go Back" id="back" class="btn btn-dark float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>calendar/update_employee/<?php echo $calendar->id; ?>/<?php echo $calendar->date; ?>" enctype="multipart/form-data">
            <input type="text" hidden name="regular_date" value="<?php echo $calendar->date; ?>">
            <div class="row">
                <?php if($employees_holiday) : ?>
                    <?php foreach($employees_holiday as $employee_holiday) : ?>
                        <div class="col-md-12">
                            <div class="form-control">
                                <input type="checkbox" name="employee[]" value="<?php echo $employee_holiday->employee_number; ?>">
                                <?php echo $employee_holiday->fullname; ?><br>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div> 
            <br>
            <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Economic Holiday Date</label>
                            <select name="date" class="form-control" id="">
                                <option value="">SELECT ECONOMIC DATE</option>
                                <?php if($economic_dates) : ?>
                                    <?php foreach($economic_dates as $economic_date) : ?>
                                        <option value="<?php echo $economic_date->date; ?>"><?php echo $economic_date->date; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                </div>       
            </div>   

            <center>
                <input type="submit" class="btn btn-info" onclick="return confirm('Do you want to update data?');" value="Update">
            </center>
        </form>    
    </div>
</div>
