<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4> <?php echo $employee->fullname; ?></h4></div>
    <form method="post" action="<?php echo base_url(); ?>employee/employee_movement/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>" >  
        <div class="card-body">
            <div class="card">
                <div class="card-header">Movement Information</div>
                <div class="card-body">
                <input type="text" class="form-control" name="employee_number" value="<?php echo $employee->emp_no; ?>" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee Status</label>
                                <select class="form-control" name="employee_status" id="mySelect">
                                    <?php if($statuss) : ?>
                                        <?php foreach($statuss as $status) : ?>
                                            <?php if($status->id <= 4) : ?>
                                                <option value="<?php echo $status->id; ?>"<?php echo $status->id == $employee->emp_status ? 'selected' : ' '; ?>><?php echo $status->name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Business Unit</label>
                                <select class="form-control" name="company">
                                    <?php if($companies) : ?>
                                        <?php foreach($companies as $company) : ?>
                                            <option value="<?php echo $company->id; ?>"<?php echo $company->id == $employee->emp_company ? 'selected' : ' '; ?>><?php echo $company->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Position</label>
                                <input type="text" class="form-control" name="position" value="<?php echo $employee->position; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department Movement From</label>
                                <select class="form-control" name="movement_from" id="dis">
                                    <?php if($departments) : ?>
                                        <?php foreach($departments as $department) : ?>
                                            <option readonly value="<?php echo $department->id; ?>"<?php echo $department->id == $employee->emp_department ? 'selected' : ' '; ?>><?php echo $department->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Movement To</label>
                                <select class="form-control" name="department">
                                    <option value="">Select Department</option>
                                    <?php if($departments) : ?>
                                        <?php foreach($departments as $department) : ?>
                                            <option value="<?php echo $department->id; ?>"><?php echo $department->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Work Group</label>
                                <select class="form-control" name="work_group">
                                    <?php if($groups) : ?>
                                        <?php foreach($groups as $group) : ?>
                                            <option value="<?php echo $group->id; ?>"<?php echo $group->id == $employee->emp_workgroup ? 'selected' : ' '; ?>><?php echo $group->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Superior</label>
                                <input type="text" class="form-control" name="superior" value="<?php echo $employee->superior; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Rank</label>
                                <select class="form-control" name="rank">
                                    <?php if($ranks) : ?>
                                        <?php foreach($ranks as $rank) : ?>
                                            <option value="<?php echo $rank->id; ?>"<?php echo $rank->id == $employee->emp_rank ? 'selected' : ' '; ?>><?php echo $rank->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date Transfer/Promotion</label>
                                <input type="date" class="form-control" name="date_transfer">
                            </div>
                        </div>
                       
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Remarks</label>
                                <input type="text" class="form-control" name="remarks">
                            </div>
                        </div>
                        <div class="col-md-4" id="probitionary">
                            <div class="form-group">
                                <label>Date Of Probationary</label>
                                <input type="date" class="form-control" name="date_probitionary">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="regular">
                                <label>Date Of Regular</label>
                                <input type="date" class="form-control" name="date_regular">
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to update data?');"  value="UPDATE" >
                </div>
            </center> 
            </div> 
        </div>
    </form> 
</div>  
<script>
    $('#dis').attr("disabled", true); 
    $("#probitionary").hide();
    $("#regular").hide(); 
    $('#mySelect').on('change', function() {
        var value = $(this).val();
        if(value == 2 ){
            $("#probitionary").show();
        } else if(value == 1) {
            $("#regular").show();
            $("#probitionary").hide();
        }
    });
   
  
</script>  