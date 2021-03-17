<div class="card">
    <div class="card-header" style="background-color:rgb(127,127,127); color: white"><h4>EDIT WORK FROM HOME<a href="<?php echo base_url(); ?>reports/index_ob" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/edit_employee_ob_wfh/<?php echo $ob->id; ?>" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="">Employee Name</label>
                    <input type="text" class="form-control" name="" value="<?php echo $ob->fullname; ?>" readonly>    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Date</label>
                    <input type="date" class="form-control" name="date_of_ob" value="<?php echo $ob->date_ob; ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">*Remarks</label>
                    <textarea class="form-control" name="remarks" id="" cols="30" rows="4"><?php echo $ob->remarks; ?></textarea>
                </div>
            </div>
        </div><br>
        <center>
            <input type="submit" onclick="return confirm('Do you want to update data?');" title="Submit Data" class="btn btn-info" value="UPDATE">
        </center>
    </form>  
</div>