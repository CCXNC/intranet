<div class="card">
    <div class="card-header" style="background-color: #478C5C; border: #478C5C; color: white"><h4>ADD EMPLOYEE HOLIDAY<a href="<?php echo base_url(); ?>calendar/calendar_list" title="Go Back" id="back" class="btn btn-dark float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>calendar/add_employee_holiday/<?php echo $calendar->id; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header"><h4><?php echo date('F j, Y', strtotime($calendar->date)); ?> <?php echo '( ' . $calendar->type . ' )'; ?></h4></div>
                <div class="card-body">
                    <input type="text" name="date" hidden value="<?php echo $calendar->date; ?>">
                    <input type="text" name="type" hidden value="<?php echo $calendar->type; ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-control">
                                <input type="checkbox" id="checkAll" name="">
                                <label for="">CHECK ALL</label>
                            </div>
                        </div>   
                    </div>    
                    <div class="row">
                        <?php if($employees) : ?>
                            <?php foreach($employees as $employee) : ?>
                                <div class="col-md-12">
                                    <div class="form-control">
                                        <input type="checkbox" name="employee[]" value="<?php echo $employee->emp_no; ?>">
                                        <?php echo $employee->fullname; ?><br>
                                    </div>
                                </div>
                            <?php endforeach;  ?>
                        <?php endif; ?>
                    </div> 
                </div>    
            </div>
            <center>
                <div class="form-group">
                    <br>
                    <input type="submit" title="Submit Holiday" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
            
        </form>
    </div>
</div>

<script>
   $(document).ready(function() {
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>
