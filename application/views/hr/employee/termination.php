<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4> <?php echo $employee->fullname; ?><a href="<?php echo base_url(); ?>employee/index" class="btn btn-info float-right" title="Go Back" style="margin-right:10px;">BACK</a></h4></div>
    <form method="post" action="<?php echo base_url(); ?>employee/employee_termination/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>" >    
        <div class="card-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <div class="card">
                <div class="card-header">Termination Information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee Status</label>
                                <select class="form-control" name="employee_status" id="mySelect">
                                    <?php if($statuss) : ?>
                                        <?php foreach($statuss as $status) : ?>
                                            <?php if($status->id >= 5) : ?>
                                                <option value="<?php echo $status->id; ?>"<?php echo $status->id == $employee->emp_status ? 'selected' : ' '; ?>><?php echo $status->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date of Termination/Retired</label>
                                <input type="date" class="form-control" name="date_termination" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date of Clearance</label>
                                <input type="date" class="form-control" name="date_clearance" >
                            </div>
                        </div>
                    </div>                        
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarks</label>
                                <input type="text" class="form-control" name="remarks" >
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" title="Update Termination Information" onclick="return confirm('Do you want to update data?');"  value="UPDATE" >
                    </div>
                </center> 
            </div>
        </div>
    </form> 
</div>   
<script>
    
  
</script> 
