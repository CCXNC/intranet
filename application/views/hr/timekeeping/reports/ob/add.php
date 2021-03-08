<div class="card">
    <div class="card-header"><h4>OB FORM<a href="<?php echo base_url(); ?>attendance/index" title="Go Back to Menu" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Start Date</label>
                    <input type="date" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">End Date</label>
                    <input type="date" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">Employee Name</label>
                    <select name="employee_number" class="form-control col-md-12">  
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Destination</label>
                    <input type="text" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Purpose</label>
                    <textarea class="form-control" name="" id="" cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Transport</label>
                    <select class="form-control" name="type">
                        <option value="">Select Type</option>
                        <option value="">Company Car</option>
                        <option value="">Private Car</option>
                        <option value="">Commute</option>
                        <option value="">Walk</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Plate Number</label>
                    <input type="text" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure</label>
                    <input type="time" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Arrival</label>
                    <input type="time" class="form-control" name="">
                </div>
            </div>
        </div><br>
        <center>
            <input type="submit" title="Submit Data" class="btn btn-info" name="SUBMIT">
        </center>
    </form>  
</div>