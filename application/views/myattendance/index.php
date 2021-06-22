<style>
    input[type=date] {
        color: black;
    }
</style>
<div class="card">
    <div class="card-header" style="background-color: #007BFF; border: #007BFF; color: white"><h4>MY ATTENDANCE <a href="<?php echo base_url(); ?>homepage/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url();?>user/index_my_attendance" enctype="multipart/form-data"> 
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="start_date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">End Date</label>
                        <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="end_date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
            </div><br>
        <center>
            <input type="submit" title="Submit Date" class="btn btn-info" name="SUBMIT">
        </center>
    </form>
        
</div>