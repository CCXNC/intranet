<script type="text/javascript">
    $(document).ready(function(){
        var html = '<div id="sib"><br><div class="row"><div class="col-md-3"><div class="form-group"><label for="">*Date of Overtime</label> <input type="date" class="form-control" name="date_ot[]"></div></div><div class="col-md-3"><div class="form-group"><label for="">*Type</label><select name="ot_type[]" id="" class="form-control"><option value="">SELECT TYPE OF OVERTIME</option><option value="OT">REGULAR OT</option><option value="RHOT">REGULAR HOLIDAY OT</option><option value="SHOT">SPECIAL HOLIDAY OT</option></select></div></div><div class="col-md-3"><div class="form-group"><label for="">*Time Start of Overtime</label><input type="time" class="form-control" name="time_start[]" value="<?php echo date('Y-m-d'); ?>"></div></div><div class="col-md-3"><div class="form-group"><label for="">*Time End of Overtime</label><input type="time" class="form-control" name="time_end[]" value="<?php echo date('Y-m-d'); ?>"></div></div><div class="col-md-12"><div class="form-group"><label for="">*Specific Task To Be Done</label><textarea class="form-control" name="task[]" id="" cols="30" rows="4"></textarea></div></div></div><input class="btn btn-danger" type="button" name="remove" id="remove" value="Remove"></div>'
        //var html = '<div id="sib"><br><div class="row"><div class="col-md-3"><div class="form-group"><label>School/Establishment</label><input type="text" class="form-control" name="school[]" ></div></div><div class="col-md-3"><div class="form-group"><label>Course/Diploma</label><input type="text" class="form-control" name="course[]" ></div></div><div class="col-md-3"><div class="form-group"><label>Year Graduated</label><input type="text" class="form-control"  name="year_graduated[]" > </div></div><div class="col-md-3"><div class="form-group"><label>License</label> <input type="text" class="form-control"  name="license[]" ></div></div></div> <input class="btn btn-danger" type="button" name="remove" id="remove" value="Remove"></div>';
        var max = 30;
        var x = 1;

        $("#add").click(function(){
        if(x <= max){
            $("#table_field").append(html);
            x++;
        }
        });
        $("#table_field").on('click','#remove',function(){
        $(this).closest('#sib').remove();
        x--;
        });

    });
</script>
<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color:white;"><h4>OVERTIME FORM<a href="<?php echo base_url(); ?>reports/index_ot" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/add_ot" enctype="multipart/form-data"> 
        <div class="card-body" id="table_field">
            <div class="row" >
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label class="">*Employee Name </label>
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">*Date of Overtime</label> 
                        <input type="date" class="form-control" name="date_ot[]">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">*Type</label> 
                        <select name="ot_type[]" id="" class="form-control">
                            <option value="">SELECT TYPE OF OVERTIME</option>
                            <option value="OT">REGULAR OT</option>
                            <option value="RHOT">REGULAR HOLIDAY OT</option>
                            <option value="SHOT">SPECIAL HOLIDAY OT</option>
                        </select>        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">*Time Start of Overtime</label>
                        <input type="time" class="form-control" name="time_start[]" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">*Time End of Overtime</label>
                        <input type="time" class="form-control" name="time_end[]" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">*Specific Task To Be Done</label>
                        <textarea class="form-control" name="task[]" id="" cols="30" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input class="btn btn-success" title="Add Overtime Field" type="button" name="add" id="add" value="ADD">
                    </div>    
                </div>
                <br>
                      
            </div>   
        </div> 
        <div class="col-md-12">
                    <div class="form-group">
                        <center>
                            <input type="submit" onclick="return confirm('Do you want to submit data?');" title="Submit Data" class="btn btn-info" name="SUBMIT">
                        </center>
                     </div>    
                </div>            
    </form>                          
</div>