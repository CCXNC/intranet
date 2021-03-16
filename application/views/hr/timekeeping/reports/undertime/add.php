<div class="card">
    <div class="card-header"><h4>UNDERTIME FORM<a href="<?php echo base_url(); ?>reports/index_ut" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">*Employee Name</label>
                    <select name="" class="form-control col-md-12">  
                        <option value="">SELECT EMPLOYEE</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Date Filed</label>
                    <input type="date" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Date of Undertime</label>
                    <input type="date" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Time Start of Undertime</label>
                    <input type="time" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">*Time End of Undertime</label>
                    <input type="time" class="form-control" name="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">*Reason</label>
                    <textarea class="form-control" name="" id="" cols="30" rows="4"></textarea>
                </div>
            </div>
        </div><br>
        <center>
            <input type="submit" onclick="return confirm('Do you want to submit data?');" title="Submit Data" class="btn btn-info" name="SUBMIT">
        </center>
    </form>  
</div>