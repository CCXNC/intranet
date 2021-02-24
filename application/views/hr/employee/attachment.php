<div class="card">
    <div class="card-header"><h4>ADD ATTACHMENT<a href="<?php echo base_url(); ?>employee/index" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/employee_attachment/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <p><i style="color: blue">Allowed file types: jpg | jpeg | png | gif</i></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" name="attachment" placeholder="Attachment name" required><br>
                        <input type='file' name='resume' size='20' required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" name="attachment1" placeholder="Attachment name"><br>
                        <input type='file' name='data1' size='20' />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" name="attachment2" placeholder="Attachment name"><br>
                        <input type='file' name='data2' size='20' />
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

