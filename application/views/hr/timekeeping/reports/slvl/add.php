<div class="card">
    <div class="card-header"><h4>LEAVE OF ABSENCE FORM<a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
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
                    <label for="">Type</label>
                    <select class="form-control" name="type">
                        <option value="">Select Type</option>
                        <option value="">Vacation with Pay</option>
                        <option value="">Vacation without Pay</option>
                        <option value="">Sick with Pay</option>
                        <option value="">Sick without Pay</option>
                        <option value="">Maternity</option>
                        <option value="">Paternity</option>
                        <option value="">Emergency</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Reason/s</label>
                    <textarea class="form-control" name="" id="" cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Address While On Leave</label>
                    <input type="text" class="form-control" name="">
                </div>
            </div>
        </div><br>
        <center>
            <input type="submit" class="btn btn-info" name="SUBMIT">
        </center>
    </form>  
</div>