<div class="card">
    <div class="card-header"><h4>ATTENDANCE</h4></div>
    <div class="card-body">
    <form method="post" action="<?php echo base_url();?>attendance/view_attendance" enctype="multipart/form-data"> 
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="date" class="form-control" name="start_date">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">End Date</label>
                        <input type="date" class="form-control" name="end_date">
                    </div>
                </div>
            </div><br>
        <center>
            <input type="submit" class="btn btn-dark" name="SUBMIT">
        </center>
    </form>
        
</div>