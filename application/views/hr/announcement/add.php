
    <div class="card">
        <div class="card-header"><h4>ANNOUNCEMENT</h4></div>
        <div class="card-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>employee/add">
                <div class="card">
                    <div class="card-header">Add Announcement</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="employee_number">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Body</label>
                                    <textarea class="form-control" rows="4" cols="50" name="comment" form="usrform">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>

                <br>
                <center>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success"  value="SUBMIT" >
                    </div>
                </center>
               
            </form>
        </div>
    </div>