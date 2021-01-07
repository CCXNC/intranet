<script type="text/javascript">
    $(document).ready(function(){

        var children = '<div id="child"><br><div class="row"><div class="col-md-12"><div class="form-group"><input type="text" class="form-control" name="children_full_name[]" placeholder="Full Name"></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label>Birthdate</label><input type="date" class="form-control"  name="children_birthday[]"></div></div><div class="col-md-4"><div class="form-group"><label>Age</label><input type="text" class="form-control"  name="children_age[]"></div></div><div class="col-md-4"><div class="form-group"><label>Gender</label><select class="form-control" name="children_gender[]"><option value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div></div></div>   <input class="btn btn-danger" type="button" name="remove" id="cremove" value="Remove"></div></div>';
        var max = 10;
        var x = 1;
        var cmax = 10;
        var c = 1;

        $("#add").click(function(){
        if(x <= max){
            $("#table_field").append(html);
            x++;
        }
        });
        $("#table_field").on('click','#remove',function(){
        $(this).closest('#sib').remove();
        x--;
        });

        $("#cadd").click(function(){
        if(c <= cmax){
            $("#children_field").append(children);
            c++;
        }
        });
        $("#children_field").on('click','#cremove',function(){
        $(this).closest('#child').remove();
        c--;
        });

    });
</script>

    <div class="card">
        <div class="card-header"><h4>HR USER MANAGEMENT</h4></div>
        <div class="card-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>employee/do_upload" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">Personal Information</div>
                    <div class="card-body">
                     
                            <div style="position:absolute;">
                                <div class="form-group">
                                    <img src="<?php echo base_url(); ?>assets/images/user1.png" width="150px" height="150px" alt="" style="margin-left:20px;"><br><br>
                                </div>
                            </div>    
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Employee Number</label>
                                    <input type="text" class="form-control" name="employee_number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*First Name</label>
                                    <input type="text" class="form-control" name="first_name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control"  name="middle_name">
                                </div>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Last Name</label>
                                    <input type="text" class="form-control"  name="last_name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nickname</label>
                                    <input type="text" class="form-control"  name="nickname">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Gender</label>
                                    <select class="form-control" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <input type='file' name='userfile' size='20' />
                               
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Birthdate</label>
                                    <input type="date" class="form-control"  name="birthday">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Age</label>
                                    <input type="number" class="form-control"  name="age">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Religion</label>
                                    <input type="text" class="form-control"  name="religion">
                                </div>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Email Address</label>
                                    <input type="text" class="form-control"  name="email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Contact Number</label>
                                    <input type="text" class="form-control"  name="contact_number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Marital Status</label>
                                    <select class="form-control" name="marital_status">
                                        <option value="">Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widowed">Widowed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>*Address</label>
                                    <input type="text" class="form-control"  name="address">
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="card">
                    <div class="card-header">Parent`s Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>*Father`s Name</label>
                                    <input type="text" class="form-control" name="father_full_name" placeholder="Full Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>*Mother`s Maiden Name</label>
                                    <input type="text" class="form-control" name="mother_full_name" placeholder="Full Name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Spouse's Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="spouse_full_name" placeholder="Full Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" class="form-control"  name="spouse_birthday">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="text" class="form-control"  name="spouse_age">
                                </div>
                            </div>
                        </div> 
                       
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">Children's Information</div>
                    <div class="card-body" id="children_field">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="children_full_name[]" placeholder="Full Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="date" class="form-control"  name="children_birthday[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="text" class="form-control"  name="children_age[]">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="children_gender[]">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>   
                        <input class="btn btn-success" type="button" name="add" id="cadd" value="ADD">
                        <br>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Emergency Contact Person's Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>*FullName</label>
                                    <input type="text" class="form-control" name="emergency_name" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>*Contact Number</label>
                                    <input type="text" class="form-control"  name="emergency_contact" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">Academe Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*School</label>
                                    <input type="text" class="form-control" name="school" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Course</label>
                                    <input type="text" class="form-control" name="course" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>*Year Graduated</label>
                                    <input type="text" class="form-control"  name="year_graduated" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>License</label>
                                    <input type="text" class="form-control"  name="license" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Employment Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Date Hired</label>
                                    <input type="date" class="form-control" name="date_hired" >
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group">
                                    <label>*Business Unit</label>
                                    <select class="form-control" name="company">
                                        <option value="">Business Unit</option>
                                        <?php if($companies) : ?>
                                            <?php foreach($companies as $company) : ?>
                                                <option value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Position</label>
                                    <input type="text" class="form-control"  name="position" >
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Rank</label>
                                    <select class="form-control" name="rank">
                                        <option value="">Select Department</option>
                                        <?php if($ranks) : ?>
                                            <?php foreach($ranks as $rank) : ?>
                                                <option value="<?php echo $rank->id; ?>"><?php echo $rank->name; ?></option>
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
                                                <option value="<?php echo $department->id; ?>"><?php echo $department->name; ?></option>
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
                                                <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>    
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Superior</label>
                                    <input type="text" class="form-control"  name="superior">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>*Employee Status</label>
                                    <select class="form-control" name="employee_status">
                                        <option value="">Select Employee Status</option>
                                        <?php if($statuss) : ?>
                                            <?php foreach($statuss as $status) : ?>
                                                <option value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>  
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Years of Service</label>
                                    <input type="text" class="form-control"  name="year_of_service">
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Government Mandated IDs</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tin Number</label>
                                    <input type="number" class="form-control" name="tin" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>SSS Number</label>
                                    <input type="number" class="form-control" name="sss" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Philhealth Number</label>
                                    <input type="number" class="form-control"  name="philhealth" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Pag-ibig Number</label>
                                    <input type="number" class="form-control"  name="pagibig" >
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
