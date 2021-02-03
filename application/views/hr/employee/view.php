<style>
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    @media screen and (max-width: 950px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }
        
        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
    
        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
        
        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }
    
        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        table td:last-child {
            border-bottom: 0;
        }
    }

    
        @page {
            margin-top: 70pt;
            margin-bottom:100pt;
        }


</style>
<div class="card">
    <div class="card-header"><h4>EMPLOYEE INFORMATION<a href="<?php echo base_url(); ?>employee/index" id="back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a><input type="submit" style="margin-right:10px;" class="btn btn-info float-right" id="printButton" value="PRINT"></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">Personal Information</div>
            <div class="card-body">
                <div class="form-group">
                    <center>
                        <?php if($employee->picture != NULL) : ?>
                            <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee->picture; ?>" style="width:25%" alt="">
                        <?php else : ?>
                            <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width:25%" alt="">
                        <?php endif; ?> 
                    </center>     
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Employee Number</label>
                            <div class="form-control"><?php echo $employee->emp_no; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>FullName</label>
                            <div class="form-control"><?php echo $employee->fullname; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nickname</label>
                            <div class="form-control"><?php echo $employee->nick_name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-3">
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
        <div class="card" id="employmentMargin">
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
        <div class="card"  id="governmentMargin">
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
        <div class="card" id="parentMargin">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fullname</label>
                            <div class="form-control"><?php echo $employee->spouse_name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Birthdate</label>
                            <div class="form-control"><?php echo date('F j, Y',strtotime($employee->spouse_birthday)); ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Age</label>
                            <div class="form-control"><?php echo $employee->spouse_age; ?></div>
                        </div>
                    </div>
                </div>   
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Occupation</label>
                            <div class="form-control"><?php echo $employee->spouse_occupation; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Employer</label>
                            <div class="form-control"><?php echo $employee->spouse_employer; ?></div>
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
                                <th scope="col">Fullname</th>
                                <th scope="col">Age</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Gender</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($children_infos) : ?> 
                                <?php foreach($children_infos as $children_info) : ?>
                                    <tr>
                                        <td data-label="Fullname"><?php echo $children_info->name;  ?></td>
                                        <td data-label="Age"><?php echo $children_info->age;  ?></td>
                                        <td data-label="Birthday"><?php echo date('F j, Y',strtotime($children_info->birthday));  ?></td>
                                        <td data-label="Gender"><?php echo $children_info->gender;  ?></td>
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
                            <th scope="col">School</th>
                            <th scope="col">Year Graduated</th>
                            <th scope="col">Course</th>
                            <th scope="col">License</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($academe_infos) : ?> 
                            <?php foreach($academe_infos as $academe_info) : ?>
                                <tr>
                                    <td data-label="School"><?php echo $academe_info->school;  ?></td>
                                    <td data-label="Year Graduated"><?php echo $academe_info->year_graduated;  ?></td>
                                    <td data-label="Course"><?php echo $academe_info->course;  ?></td>
                                    <td data-label="License"><?php echo $academe_info->license;  ?></td>
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
                            <th scope="col">Date Log</th>
                            <th scope="col">Date Movement/Promotion</th>
                            <th scope="col">Status</th>
                            <th scope="col">Company</th> 
                            <th scope="col">Department</th>
                            <th scope="col">Position</th>
                            <th scope="col">Rank</th>
                            <th scope="col">Work Group</th>
                            <th scope="col">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($transfer) : ?>
                            <?php foreach($transfer as $trans) : ?>
                                <tr>
                                    <td data-label="Date Log"><?php echo date('F j, Y',strtotime($trans->date_created));  ?></td>
                                    <td data-label="Date Movement/Promotion"><?php echo date('F j, Y',strtotime($trans->date));  ?></td>
                                    <td data-label="Status"><?php echo $trans->employee_status;  ?></td>
                                    <td data-label="Company"><?php echo $trans->company_name; ?></td>
                                    <td data-label="Department"><?php echo $trans->department_name; ?></td>
                                    <td data-label="Position"><?php echo $trans->position; ?></td>
                                    <td data-label="Rank"><?php echo $trans->rank_name; ?></td>
                                    <td data-label="Work Group"><?php echo $trans->work_group; ?></td>
                                    <td data-label="Remarks"><?php echo $trans->remarks; ?></td>
                                </tr>
                            <?php endforeach; ?> 
                        <?php endif; ?>
                    </tbody>
                </table>   
            </div>
        </div>  
        <br>
        <div class="card">
            <div class="card-header">Attachments
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($attachments) : ?>
                            <?php foreach($attachments as $attachment) : ?>
                                <tr>
                                    <td data-label="Date"><?php echo date('F j, Y',strtotime($attachment->created_date));  ?></td>
                                    <td data-label="Title"><?php echo $attachment->name; ?></td>
                                    <td data-label="File">
                                    <a href="<?php echo base_url(); ?>employee/download_attachment/<?php echo $attachment->file; ?>"><?php echo $attachment->file; ?></a></td>
                                </tr>
                            <?php endforeach; ?> 
                        <?php endif; ?>
                    </tbody>
                </table>   
            </div>
        </div>    
    </div>      
</div>    
<script>
    $(document).ready(function(){
        $('#printButton').click(function() {
            $('#menuTab').css('display', 'none');
            $('#show-sidebar').hide();
            $('#back').hide();
            $('#printButton').hide();
            window.print();
        });
        
    });
</script>