<div class="card">
    <div class="card-header" ><h4>OB LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
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
            </div><br>
        <center>
            <input type="submit" class="btn btn-info" name="SUBMIT">
        </center>
    </form>  
</div>