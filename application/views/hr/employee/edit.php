<div class="card">
    <div class="card-header"><h4>EDIT EMPLOYEE<a href="<?php echo base_url(); ?>employee/index" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/edit_employee/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">Personal Information</div>
                <div class="card-body">
                        <div class="form-group">
                            <?php if($employee->picture != NULL) : ?>
                                <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee->picture; ?>" width="150px" height="150px" alt="">
                            <?php else : ?>
                                <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" width="150px" height="150px" alt="">
                            <?php endif; ?>                             
                        </div> 
                        <input type='file' name='image' size='20' />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Employee Number</label>
                                <input type="text" class="form-control" name="employee_number" value="<?php echo $employee->emp_no; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo $employee->first_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control"  name="middle_name" value="<?php echo $employee->middle_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Last Name</label>
                                <input type="text" class="form-control"  name="last_name" value="<?php echo $employee->last_name; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nickname</label>
                                <input type="text" class="form-control"  name="nickname" value="<?php echo $employee->nick_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male"<?php echo $employee->gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female"<?php echo $employee->gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Birthdate</label>
                                <input type="date" class="form-control"  name="birthday" value="<?php echo $employee->birthday; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Contact Number</label>
                                <input type="text" class="form-control"  name="contact_number" value="<?php echo $employee->contact_number; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Marital Status</label>
                                <select class="form-control" name="marital_status">
                                    <option value="Single"<?php echo $employee->marital_status == 'Single' ? 'selected' : ''; ?>>Single</option>
                                    <option value="Married"<?php echo $employee->marital_status == 'Married' ? 'selected' : ''; ?>>Married</option>
                                    <option value="Divorced"<?php echo $employee->marital_status == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                    <option value="Widowed"<?php echo $employee->marital_status == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Personal Email Address</label>
                                <input type="text" class="form-control"  name="email" value="<?php echo $employee->email_address; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>*Address</label>
                                <input type="text" class="form-control"  name="address" value="<?php echo $employee->address; ?>">
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <div class="card">
                <div class="card-header">Parent`s Information</div>
                <div class="card-body">
                <input type="text" class="form-control" name="parent_id" value="<?php echo $employee->parent_id; ?>" hidden>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>*Father`s Name</label>
                                <input type="text" class="form-control" name="father_full_name" placeholder="Full Name" value="<?php echo $employee->father_name; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>*Mother`s Maiden Name</label>
                                <input type="text" class="form-control" name="mother_full_name" placeholder="Full Name" value="<?php echo $employee->mother_name; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Spouse's Information</div>
                <div class="card-body">
                    <?php if($employee->spouse_id != NULL) : ?>
                        <input type="text" class="form-control" name="spouse_id" value="<?php echo $employee->spouse_id; ?>" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" name="spouse_full_name" value="<?php echo $employee->spouse_name; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" class="form-control"  name="spouse_birthday" value="<?php echo $employee->spouse_birthday; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Occupation</label>
                                    <input type="text" class="form-control"  name="occupation" value="<?php echo $employee->spouse_occupation; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employer</label>
                                    <input type="text" class="form-control"  name="employer" value="<?php echo $employee->spouse_employer; ?>">
                                </div>
                            </div>
                        </div> 
                    <?php endif; ?>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Children's Information</div>
                <div class="card-body" id="children_field">
                    <?php if($children_infos) : ?>
                        <?php foreach($children_infos as $children_info) : ?>
                            <?php if($children_info->id != NULL) : ?>
                                <input type="text" class="form-control"  name="children_id[]" value="<?php echo $children_info->id; ?>" hidden >
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="children_full_name[]" placeholder="Full Name" value="<?php echo $children_info->name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birthdate</label>
                                            <input type="date" class="form-control"  name="children_birthday[]" value="<?php echo $children_info->birthday; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" name="children_gender[]">
                                                <option value="">Select Gender</option>
                                                <option value="Male"<?php echo $children_info->gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female"<?php echo $children_info->gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>   
                            <?php endif; ?>    
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                                <input type="text" class="form-control" name="emergency_name" value="<?php echo $employee->emergency_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Contact Number</label>
                                <input type="text" class="form-control"  name="emergency_contact" value="<?php echo $employee->emergency_contact_number; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Relationship</label>
                                <input type="text" class="form-control"  name="emergency_relationship" value="<?php echo $employee->emergency_contact_relationship; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <br>   
            <div class="card">
                <div class="card-header">Academe Information</div>
                <div class="card-body" id="table_field">
                    <?php if($academe_infos) : ?>
                        <?php foreach($academe_infos as $academe_info) : ?>
                            <input type="text" class="form-control"  name="academe_id[]" value="<?php echo $academe_info->id; ?>" hidden>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>School/Establishment</label>
                                        <input type="text" class="form-control" name="school[]" value="<?php echo $academe_info->school; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Course/Diploma</label>
                                        <input type="text" class="form-control" name="course[]" value="<?php echo $academe_info->course; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Year Graduated</label>
                                        <input type="text" class="form-control"  name="year_graduated[]" value="<?php echo $academe_info->year_graduated; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>License</label>
                                        <input type="text" class="form-control"  name="license[]" value="<?php echo $academe_info->license; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Employment Information</div>
                <div class="card-body">
                    <input type="text" class="form-control" name="employment_id" value="<?php echo $employee->employment_id; ?>" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Date Hired</label>
                                <input type="date" class="form-control" name="date_hired" value="<?php echo $employee->date_hired; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date Probationary</label>
                                <input type="date" class="form-control" name="date_probitionary" value="<?php echo $employee->date_probitionary; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date Regular</label>
                                <input type="date" class="form-control" name="date_regular" value="<?php echo $employee->date_regular; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Business Unit</label>
                                <select class="form-control" name="company">
                                    <?php if($companies) : ?>
                                        <?php foreach($companies as $company) : ?>
                                            <option value="<?php echo $company->id; ?>"<?php echo $employee->company_id == $company->id ? 'selected' : ''; ?>><?php echo $company->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Position</label>
                                <input type="text" class="form-control"  name="position" value="<?php echo $employee->position; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Category</label>
                                <select class="form-control" name="category">
                                    <option value=""<?php echo $employee->category_id == 0 ? 'selected' : ''; ?>Select Category</option>
                                    <option value="1"<?php echo $employee->category_id == 1 ? 'selected' : ''; ?>>Strategic</option>    
                                    <option value="2"<?php echo $employee->category_id == 2 ? 'selected' : ''; ?>>Non Strategic</option>        
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Employee Status</label>
                                <select class="form-control" name="employee_status">
                                    <option value="">Select Employee Status</option>
                                    <?php if($statuss) : ?>
                                        <?php foreach($statuss as $status) : ?>
                                            <?php if($status->id <= 4) : ?>
                                                <option value="<?php echo $status->id; ?>"<?php echo $employee->employee_status_id == $status->id ? 'selected' : ''; ?>><?php echo $status->name; ?></option> 
                                            <?php endif; ?>                                           
                                        <?php endforeach; ?>
                                    <?php endif; ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Department</label>
                                <select class="form-control" name="department">
                                    <option value="">Select Department</option>
                                    <?php if($departments) : ?>
                                        <?php foreach($departments as $department) : ?>
                                            <option value="<?php echo $department->id; ?>"<?php echo $employee->department_id == $department->id ? 'selected' : ''; ?>><?php echo $department->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Work Group</label>
                                <select class="form-control" name="work_group">
                                    <option value="">Select Work Group</option>
                                    <?php if($groups) : ?>
                                        <?php foreach($groups as $group) : ?>
                                            <option value="<?php echo $group->id; ?>"<?php echo $employee->work_group_id == $group->id ? 'selected' : ''; ?>><?php echo $group->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>    
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Rank</label>
                                <select class="form-control" name="rank">
                                    <option value="">Select Rank</option>
                                    <?php if($ranks) : ?>
                                        <?php foreach($ranks as $rank) : ?>
                                            <option value="<?php echo $rank->id; ?>"<?php echo $employee->rank_id == $rank->id ? 'selected' : ''; ?>><?php echo $rank->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>*Superior</label>
                                <input type="text" class="form-control"  name="superior" value="<?php echo $employee->superior; ?>">
                            </div>
                        </div>
                                            
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Years of Service</label>
                                <input type="text" class="form-control"  name="year_of_service" value="<?php echo $employee->years_of_service; ?>">
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
                                <input type="number" class="form-control" name="tin" value="<?php echo $employee->tin; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>SSS Number</label>
                                <input type="number" class="form-control" name="sss" value="<?php echo $employee->sss; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Philhealth Number</label>
                                <input type="number" class="form-control"  name="philhealth" value="<?php echo $employee->philhealth; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Pag-ibig Number</label>
                                <input type="number" class="form-control"  name="pagibig" value="<?php echo $employee->pagibig; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <center>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" onclick="return confirm('Do you want to update data?');" value="UPDATE" >
                </div>
            </center>
            
        </form>
    </div>
</div>
