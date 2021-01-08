<div class="card">
    <div class="card-header"><h4> <?php echo $employee->fullname; ?></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">Employment Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                       
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date Hired</label>
                            <div class="form-control"><?php echo date('F j, Y',strtotime($employee->date_hired)); ?></div>
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
                            <div class="form-control"><?php echo $employee->position; ?></div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
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
                            <label>Department</label>
                            <select class="form-control" name="department">
                                <?php if($departments) : ?>
                                    <?php foreach($departments as $department) : ?>
                                        <option value="<?php echo $department->id; ?>"<?php echo $department->id == $employee->emp_department ? 'selected' : ' '; ?>><?php echo $department->name; ?></option>
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
                            <div class="form-control"><?php echo $employee->superior; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Employee Status</label>
                            <select class="form-control" name="employee_status">
                                <?php if($statuss) : ?>
                                    <?php foreach($statuss as $status) : ?>
                                        <option value="<?php echo $status->id; ?>"<?php echo $status->id == $employee->emp_status ? 'selected' : ' '; ?>><?php echo $status->name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Years of Service</label>
                            <div class="form-control"><?php echo $employee->years_of_service; ?></div>
                        </div>
                    </div>
                </div>   
                <center>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success"  value="UPDATE" >
                    </div>
                </center> 
            </div>
        </div>
    </div>
</div>    
