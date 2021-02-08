<div class="card">
    <div class="card-header"><h4>5S SHARE MY IDEA</h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/idea_add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">My Idea</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <label>Control Number</label>
                                <input type="text" class="form-control" name="control_number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current</label>
                                <textarea type="text" class="form-control" name="current" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proposal</label>
                                <textarea type="text" class="form-control" name="proposal" rows="4" cols="50"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="attachment" placeholder="Attachment name"><br>
                                <input type='file' name='data1' size='20' />
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
