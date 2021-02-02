<div class="card">
    <div class="card-header"><h4>5S IDEAS</h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/add" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>*Title</label>
                            <input type="text" class="form-control" name="employee_number">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>*Idea</label>
                            <textarea class="form-control" name="content" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
            
        </form>
    </div>
</div>
