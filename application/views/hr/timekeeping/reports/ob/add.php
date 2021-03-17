<div class="card">
    <div class="card-header" style="background-color:rgb(127,127,127); color: white"><h4>FIELD WORK / WORK FROM HOME FORM<a href="<?php echo base_url(); ?>reports/index_ob" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/add_ob" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">*Employee Name</label>
                    <select name="employee" class="form-control col-md-12">  
                        <option value="">SELECT EMPLOYEE</option>
                        <?php if($employees) : ?>
                        <?php foreach($employees as $employee) : ?>
                            <option value="<?php echo $employee->emp_no . '|' . $employee->department_id; ?>"><?php echo $employee->fullname; ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Type</label>
                    <select class="form-control" name="type" id="type">
                        <option value="FIELD WORK">FIELD WORK</option>
                        <option value="WORK FROM HOME">WORK FROM HOME</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Start Date</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*End Date</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
            </div>
            <div class="fieldWork col-md-12">
                <div class=" form-group">
                    <label for="">*Destination</label>
                    <input type="text" class="form-control" name="destination">
                </div>
            </div>
            <div class="fieldWork col-md-12">
                <div class="form-group">
                    <label for="">*Purpose</label>
                    <textarea class="form-control" name="purpose" id="" cols="30" rows="4"></textarea>
                </div>
            </div>
            <div class="fieldWork col-md-6">
                <div class="form-group">
                    <label for="">*Transport</label>
                    <select class="form-control" name="transport">
                        <option value="">Select Transport</option>
                        <option value="Company Car">Company Car</option>
                        <option value="Private Car">Private Car</option>
                        <option value="Commute">Commute</option>
                        <option value="Walk">Walk</option>
                    </select>
                </div>
            </div>
            <div class="fieldWork col-md-6">
                <div class="form-group">
                    <label for="">Plate Number</label>
                    <input type="text" class="form-control" name="plate_number">
                </div>
            </div>
            <div id="wfh"class="col-md-12">
                <div class="form-group">
                    <label for="">*Remarks</label>
                    <textarea class="form-control" name="remarks" id="" cols="30" rows="4"></textarea>
                </div>
            </div>
            <!--<div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure</label>
                    <input type="time" class="form-control" name="time_of_departure">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure Destination</label>
                    <input type="time" class="form-control" name="time_of_departure_destination">
                </div>
            </div>-->
        </div><br>
        <center>
            <input type="submit" onclick="return confirm('Do you want to submit data?');" title="Submit Data" class="btn btn-info" name="SUBMIT">
        </center>
    </form>  
</div>

<script>
    $("#wfh").hide(); 
    $('#type').on('change', function() {
        var value = $(this).val();
        if(value == "WORK FROM HOME" ){
            $("#wfh").show(); 
            $(".fieldWork").hide();
        } else if(value == "FIELD WORK") {
            $("#wfh").hide(); 
            $(".fieldWork").show();
        } 
    });
</script>