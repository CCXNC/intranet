<div class="card-header"><h4>EMPLOYEE LIST REPORTS
    <a href="<?php echo base_url(); ?>employee/index" class="btn btn-info float-right" style="margin-right:10px;">BACK</a>
    </h4> 
</div>
<br>
<b>Filter Column: </b>
<div class="row">
    <div class="col-md-4">
        <input id="empno" class="toggle-vis" type="checkbox" checked data-column="0">
        <label for="empno">Employee Number</label>
        <br>
        <input id="fname" class="toggle-vis" type="checkbox" checked data-column="1">
        <label for="fname">Full Name</label>
        <br>
        <input id="bday" class="toggle-vis" type="checkbox" data-column="2" checked>
        <label for="bday">Birthday</label>
        <br>
        <input id="age" class="toggle-vis" type="checkbox" data-column="3" checked>
        <label for="age">Age</label>
        <br>
        <input id="gender" class="toggle-vis" type="checkbox" data-column="4" checked>
        <label for="gender">Gender</label>
        <br>
        <input id="mstatus" class="toggle-vis" type="checkbox" data-column="5" checked>
        <label for="mstatus">Marital Status</label>
        <br>
        <input id="cnumber" class="toggle-vis" type="checkbox" data-column="6" checked>
        <label for="cnumber">Contact Number</label>
        <br>
        <input id="eadd" class="toggle-vis" type="checkbox" data-column="7" checked>
        <label for="eadd">Email Address</label>
        <br>
        <input id="ecname" class="toggle-vis" type="checkbox" data-column="8" checked>
        <label for="ecname">Emergency Contact Name</label>
        <br>
        <input id="ecnumber" class="toggle-vis" type="checkbox" data-column="9" checked>
        <label for="ecnumber">Emergency Contact Number</label>
        <br>
        <input id="ecrel" class="toggle-vis" type="checkbox" data-column="10" checked>
        <label for="ecrel">Emergency Contact Relationship</label>
        <br>
        <input id="add" class="toggle-vis" type="checkbox" data-column="11" checked>
        <label for="add">Address</label>
    </div>
    <div class="col-md-4">
        <input id="sss" class="toggle-vis" type="checkbox" data-column="12" checked>
        <label for="sss">SSS</label>
        <br>
        <input id="tin" class="toggle-vis" type="checkbox" data-column="13" checked>
        <label for="tin">TIN</label>
        <br>
        <input id="pagibig" class="toggle-vis" type="checkbox" data-column="14" checked>
        <label for="pagibig">Pagibig</label>
        <br>
        <input id="philhealth" class="toggle-vis" type="checkbox" data-column="15" checked>
        <label for="philhealth">Philhealth</label>
        <br>
        <input id="datehired" class="toggle-vis" type="checkbox" data-column="16" checked>
        <label for="datehired">Date Hired</label>
        <br>
        <input id="businessunit" class="toggle-vis" type="checkbox" data-column="17" checked>
        <label for="businessunit">Business Unit</label>
        <br>
        <input id="position" class="toggle-vis" type="checkbox" data-column="18" checked>
        <label for="position">Position</label>
        <br>
        <input id="rank" class="toggle-vis" type="checkbox" data-column="19" checked>
        <label for="rank">Rank</label>
        <br>
        <input id="department" class="toggle-vis" type="checkbox" data-column="20" checked>
        <label for="department">Department</label>
        <br>
        <input id="workgroup" class="toggle-vis" type="checkbox" data-column="21" checked>
        <label for="workgroup">Work Group</label>
        <br>
        <input id="superior" class="toggle-vis" type="checkbox" data-column="22" checked>
        <label for="superior">Superior</label>
        <br>
        <input id="employeestatus" class="toggle-vis" type="checkbox" data-column="23" checked>
        <label for="employeestatus">Employee Status</label>
    </div>
    <div class="col-md-4">
        <input id="fathername" class="toggle-vis" type="checkbox" data-column="24" checked>
        <label for="fathername">Father Name</label>
        <br>
        <input id="mothername" class="toggle-vis" type="checkbox" data-column="25" checked>
        <label for="mothername">Mother Name</label>
        <br>
        <input id="spousename" class="toggle-vis" type="checkbox" data-column="26" checked>
        <label for="spousename">Spouse Name</label>
        <br>
        <input id="spousebirthday" class="toggle-vis" type="checkbox" data-column="27" checked>
        <label for="spousebirthday">Spouse Birthday</label>
        <br>
        <input id="spouseage" class="toggle-vis" type="checkbox" data-column="28" checked>
        <label for="spouseage">Spouse Age</label>
        <br>
        <input id="spouseoccupation" class="toggle-vis" type="checkbox" data-column="29" checked>
        <label for="spouseoccupation">Spouse Occupation</label>
        <br>
        <input id="spousemployer" class="toggle-vis" type="checkbox" data-column="30" checked>
        <label for="spouseemployer">Spouse Employer</label>
        <br>
        <input id="school" class="toggle-vis" type="checkbox" data-column="31" checked>
        <label for="school">School</label>
        <br>
        <input id="year_graduated" class="toggle-vis" type="checkbox" data-column="32" checked>
        <label for="year_graduated">Year Graduated</label>
        <br>
        <input id="course" class="toggle-vis" type="checkbox" data-column="33" checked>
        <label for="course">Course</label>
        <br>
        <input id="license" class="toggle-vis" type="checkbox" data-column="34" checked>
        <label for="license">License</label>
    </div>
</div>




<table id="employee">
  <thead>
    <tr>
        <th>Employee Number</th>
        <th>Full Name</th>
        <th>Birthday</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Marital Status</th>
        <th>Contact Number</th>
        <th>Email Address</th>
        <th>Emergency Contact Name</th>
        <th>Emergency Contact Number</th>
        <th>Emergency Contact Relationship</th>
        <th>Address</th>
        <th>SSS</th>
        <th>TIN</th>
        <th>Pagibig</th>
        <th>Philhealth</th>
        <th>Date Hired</th>
        <th>Business Unit</th>
        <th>Position</th>
        <th>Rank</th>  
        <th>Department</th>
        <th>Work Group</th>
        <th>Superior</th>
        <th>Employee Status</th>
        <th>Father Name</th>
        <th>Mother Name</th>
        <th>Spouse Name</th>
        <th>Spouse Birthday</th>
        <th>Spouse Age</th>
        <th>Spouse Occupation</th>
        <th>Spouse Employer</th>
        <th>School</th>
        <th>Year Graduated</th>
        <th>Course</th>
        <th>License</th>
    </tr>
    
  </thead>
  <tbody>
  <?php if($employees) : ?> 
            <?php foreach($employees as $employee) : ?>
                <tr>
                    <td><?php echo $employee->emp_no?></td>
                    <td><?php echo $employee->fullname?></td>
                    <td><?php echo $employee->birthday?></td>
                    <td><?php echo $employee->age?></td>
                    <td><?php echo $employee->gender?></td>
                    <td><?php echo $employee->marital_status?></td>
                    <td><?php echo $employee->contact_number?></td>
                    <td><?php echo $employee->email_address?></td>
                    <td><?php echo $employee->emergency_contact_name?></td>
                    <td><?php echo $employee->emergency_contact_number?></td>
                    <td><?php echo $employee->emergency_contact_relationship?></td>
                    <td><?php echo $employee->address?></td>
                    <td><?php echo $employee->sss_number?></td>
                    <td><?php echo $employee->tin_number?></td>
                    <td><?php echo $employee->pagibig_number?></td>
                    <td><?php echo $employee->philhealth_number?></td>
                    <td><?php echo $employee->date_hired?></td>
                    <td><?php echo $employee->company?></td>
                    <td><?php echo $employee->position?></td>
                    <td><?php echo $employee->rank?></td>
                    <td><?php echo $employee->department?></td>
                    <td><?php echo $employee->work_group?></td>
                    <td><?php echo $employee->superior?></td>
                    <td><?php echo $employee->employee_status?></td>
                    <td><?php echo $employee->father_name?></td>
                    <td><?php echo $employee->mother_name?></td>
                    <td><?php echo $employee->sps_name?></td>
                    <td><?php echo $employee->sps_bday?></td>
                    <td><?php echo $employee->sps_age?></td>
                    <td><?php echo $employee->sps_occupation?></td>
                    <td><?php echo $employee->sps_employer?></td>
                    
                    <td><?php echo $employee->school?></td>
                    <td><?php echo $employee->year_graduated?></td>
                    <td><?php echo $employee->course?></td>
                    <td><?php echo $employee->license?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        var employee = $('#employee').DataTable({
            //"scrollY": "200px",
            dom: 'Brtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Extract to Excel',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    text: 'Copy Data',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            columns: [
                { data: 'Employee Number'},
                { data: 'Full Name' },
                { data: 'Birthday' },
                { data: 'Age' },
                { data: 'Gender' },
                { data: 'Marital Status' },
                { data: 'Contact Number' },
                { data: 'Email Address' },
                { data: 'Emergency Contact Name' },
                { data: 'Emergency Contact Number' },
                { data: 'Emergency Contact Relationship' },
                { data: 'Address' },
                { data: 'SSS' },
                { data: 'TIN' },
                { data: 'Pagibig' },
                { data: 'Philhealth' },
                { data: 'Date Hired' },
                { data: 'Business Unit' },
                { data: 'Position' },
                { data: 'Rank' },
                { data: 'Department' },
                { data: 'Work Group' },
                { data: 'Superior' },
                { data: 'Employee Status' },
                { data: 'Father Name' },
                { data: 'Mother Name' },
                { data: 'Spouse Name' },
                { data: 'Spouse Birthday' },
                { data: 'Spouse Age' },
                { data: 'Spouse Occupation' },
                { data: 'Spouse Employer' },

                { data: 'School' },
                { data: 'Year Graduted' },
                { data: 'Course' },
                { data: 'License' }

            ]
        });
        
            $('input.toggle-vis').on( 'change', function (e) {
                e.preventDefault();
        
                // Get the column API object
                var column = employee.column( $(this).attr('data-column') );
        
                // Toggle the visibility
                column.visible( ! column.visible() );
            } );
    } );
</script>