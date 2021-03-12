<div class="card">
    <div class="card-header"><h4>EDIT OB FORM<a href="<?php echo base_url(); ?>reports/index_ob" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/edit_employee_ob/<?php echo $ob->id; ?>" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">Employee Name</label>
                    <input type="text" class="form-control" name="" value="<?php echo $ob->fullname; ?>" readonly>    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""> Date of OB</label>
                    <input type="date" class="form-control" name="date_of_ob" value="<?php echo $ob->date_ob; ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Destination</label>
                    <input type="text" class="form-control" name="destination" value="<?php echo $ob->destination; ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Purpose</label>
                    <textarea class="form-control" name="purpose" id="" cols="30" rows="5"><?php echo $ob->purpose; ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Transport</label>
                    <select class="form-control" name="transport">
                        <option value="">Select Type</option>
                        <option value="Company Car"<?php echo $ob->transport == "Company Car" ? 'selected' : ''; ?>>Company Car</option>
                        <option value="Private Car"<?php echo $ob->transport == "Private Car" ? 'selected' : ''; ?>>Private Car</option>
                        <option value="Commute"<?php echo $ob->transport == "Commute" ? 'selected' : ''; ?>>Commute</option>
                        <option value="Walk"<?php echo $ob->transport == "Walk" ? 'selected' : ''; ?>>Walk</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Plate Number</label>
                    <input type="text" class="form-control" name="plate_number" value="<?php echo $ob->plate_no ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure</label>
                    <input type="time" class="form-control" name="time_of_departure" value="<?php echo $ob->time_departure; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure Destination</label>
                    <input type="time" class="form-control" name="time_of_departure_destination" value="<?php echo $ob->time_departure_destination; ?>">
                </div>
            </div>
        </div><br>
        <center>
            <input type="submit" onclick="return confirm('Do you want to update data?');" title="Submit Data" class="btn btn-info" value="UPDATE">
        </center>
    </form>  
</div>