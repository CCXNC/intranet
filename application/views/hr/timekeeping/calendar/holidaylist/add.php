<div class="card">
    <div class="card-header"><h4>ADD HOLIDAY</h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>timekeeping/add_calendar_list" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">Holiday Information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control" name="type">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control"  name="description">
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <center>
                <div class="form-group">
                    <br>
                    <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
            
        </form>
    </div>
</div>
