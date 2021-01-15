<div class="card">
    <div class="card-header"><h4>EMPLOYEE INFORMATION</h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">Personal Information</div>
            <div class="card-body">
                
                    <div style="position:absolute;">
                        <div class="form-group">
                            <?php if($employee->picture != NULL) : ?>
                                <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee->picture; ?>" width="150px" height="150px" alt="">
                            <?php else : ?>
                                <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" width="150px" height="150px" alt="">
                            <?php endif; ?> 
                        </div>
                    </div>    
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Employee Number</label>
                            <div class="form-control"><?php echo $employee->emp_no; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>FullName</label>
                            <div class="form-control"><?php echo $employee->fullname; ?></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nickname</label>
                            <div class="form-control"><?php echo $employee->nick_name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gender</label>
                            <div class="form-control"><?php echo $employee->gender; ?></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Birthdate</label>
                            <div class="form-control"><?php echo date('F j, Y',strtotime($employee->birthday)); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Age</label>
                            <div class="form-control"><?php echo $employee->age; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <div class="form-control"><?php echo $employee->contact_number; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="form-control"><?php echo $employee->email_address; ?></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Marital Status</label>
                            <div class="form-control"><?php echo $employee->marital_status; ?></div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Address</label>
                            <div class="form-control"><?php echo $employee->address; ?></div>
                        </div>
                    </div>
                </div>

            </div>    
        </div>
        <br>
        <div class="card">
            <div class="card-header">Employment Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date Hired</label>
                            <div class="form-control"><?php echo date('F j, Y',strtotime($employee->date_hired)); ?> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Business Unit</label>
                            <div class="form-control"><?php echo $employee->company_name; ?> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Position</label>
                            <div class="form-control"><?php echo $employee->position; ?> </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Rank</label>
                            <div class="form-control"><?php echo $employee->rank_name; ?> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Department</label>
                            <div class="form-control"><?php echo $employee->department_name; ?> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Work Group</label>
                            <div class="form-control"><?php echo $employee->work_group; ?> </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>*Superior</label>
                            <div class="form-control"><?php echo $employee->superior; ?> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>*Employee Status</label>
                            <div class="form-control"><?php echo $employee->employee_status; ?> </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Years of Service</label>
                            <div class="form-control"><?php echo $employee->years_of_service; ?> </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">Government Mandated IDs</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tin Number</label>
                            <div class="form-control"><?php echo $employee->tin; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SSS Number</label>
                            <div class="form-control"><?php echo $employee->sss; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Philhealth Number</label>
                            <div class="form-control"><?php echo $employee->philhealth; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pag-ibig Number</label>
                            <div class="form-control"><?php echo $employee->pagibig; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <br>
        <div class="card">
            <div class="card-header">Parent`s Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Father`s Name</label>
                            <div class="form-control"><?php echo $employee->father_name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mother`s Maiden Name</label>
                            <div class="form-control"><?php echo $employee->mother_name; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <br>
        <div class="card">
            <div class="card-header">Spouse's Information
            </div>
            <div class="card-body">
            <?php if($employee->spouse_name != NULL) :  ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fullname</label>
                            <div class="form-control"><?php echo $employee->spouse_name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Birthdate</label>
                            <div class="form-control"><?php echo date('F j, Y',strtotime($employee->spouse_birthday)); ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Age</label>
                            <div class="form-control"><?php echo $employee->spouse_age; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Occupation</label>
                            <div class="form-control"><?php echo $employee->spouse_occupation; ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>    
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">Children Information
            </div>
            <div class="card-body">
                <?php if($children_infos != NULL) : ?>
                    <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th>Gender</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($children_infos) : ?> 
                                <?php foreach($children_infos as $children_info) : ?>
                                    <tr>
                                        <td><?php echo $children_info->name;  ?></td>
                                        <td><?php echo $children_info->age;  ?></td>
                                        <td><?php echo date('F j, Y',strtotime($children_info->birthday));  ?></td>
                                        <td><?php echo $children_info->gender;  ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table> 
                <?php endif; ?>  
            </div>
        </div>        
        <br>
        <div class="card">
            <div class="card-header">Academe Information
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>School</th>
                            <th>Year Graduated</th>
                            <th>Course</th>
                            <th>License</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($academe_infos) : ?> 
                            <?php foreach($academe_infos as $academe_info) : ?>
                                <tr>
                                    <td><?php echo $academe_info->school;  ?></td>
                                    <td><?php echo $academe_info->year_graduated;  ?></td>
                                    <td><?php echo $academe_info->course;  ?></td>
                                    <td><?php echo $academe_info->license;  ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>   
            </div>
        </div> 
        <br>
        <div class="card">
            <div class="card-header">Emergency Contact Person's Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>*FullName</label>
                            <div class="form-control"><?php echo $employee->emergency_name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>*Contact Number</label>
                            <div class="form-control"><?php echo $employee->emergency_contact_number; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>*Relationship</label>
                            <div class="form-control"><?php echo $employee->emergency_contact_relationship; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">Recent Movement / Promotion
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Company</th> 
                            <th>Department</th>
                            <th>Position</th>
                            <th>Rank</th>
                            <th>Work Group</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($transfer) : ?>
                            <?php foreach($transfer as $trans) : ?>
                                <tr>
                                    <td><?php echo date('F j, Y',strtotime($trans->date));  ?></td>
                                    <td><?php echo $trans->employee_status;  ?></td>
                                    <td><?php echo $trans->company_name; ?></td>
                                    <td><?php echo $trans->department_name; ?></td>
                                    <td><?php echo $trans->position; ?></td>
                                    <td><?php echo $trans->rank_name; ?></td>
                                    <td><?php echo $trans->work_group; ?></td>
                                    <td><?php echo $trans->remarks; ?></td>
                                </tr>
                            <?php endforeach; ?> 
                        <?php endif; ?>
                    </tbody>
                </table>   
            </div>
        </div>  
    </div>      
</div>    