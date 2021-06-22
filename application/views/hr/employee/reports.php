<style>
input[type="checkbox"]{
    -webkit-appearance: initial;
    appearance: initial;
    background: white;
    width: 12px;
    height: 12px;
    border: solid black 1px;
    position: relative;
}
input[type="checkbox"]:checked {
    background: red;
}
input[type="checkbox"]:checked:after {
    /* Heres your symbol replacement */
    content: "X";
    color: white;
    /* The following positions my tick in the center, 
     * but you could just overlay the entire box
     * with a full after element with a background if you want to */
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%,-50%);
    -moz-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    /*
     * If you want to fully change the check appearance, use the following:
     * content: " ";
     * width: 100%;
     * height: 100%;
     * background: blue;
     * top: 0;
     * left: 0;
     */
}
</style>
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>EMPLOYEE LIST REPORTS
    <a href="<?php echo base_url(); ?>employee/index" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a>
    </h4> 
</div>
<br>
<b>Filter Column: </b>
<div class="row">
    <div class="col-md-4">
        <input id="empno" class="toggle-vis" type="checkbox"   data-column="0">
        <label for="empno">Employee Number</label>
        <br>
        <input id="fname" class="toggle-vis" type="checkbox"   data-column="1">
        <label for="fname">Full Name</label>
        <br>
        <input id="bday" class="toggle-vis" type="checkbox" data-column="2"  >
        <label for="bday">Birthday</label>
        <br>
        <input id="age" class="toggle-vis" type="checkbox" data-column="3"  >
        <label for="age">Age</label>
        <br>
        <input id="gender" class="toggle-vis" type="checkbox" data-column="4"  >
        <label for="gender">Gender</label>
        <br>
        <input id="mstatus" class="toggle-vis" type="checkbox" data-column="5"  >
        <label for="mstatus">Marital Status</label>
        <br>
        <input id="cnumber" class="toggle-vis" type="checkbox" data-column="6"  >
        <label for="cnumber">Contact Number</label>
        <br>
        <input id="eadd" class="toggle-vis" type="checkbox" data-column="7"  >
        <label for="eadd">Email Address</label>
        <br>
        <input id="ecname" class="toggle-vis" type="checkbox" data-column="8"  >
        <label for="ecname">Emergency Contact Name</label>
        <br>
        <input id="ecnumber" class="toggle-vis" type="checkbox" data-column="9"  >
        <label for="ecnumber">Emergency Contact Number</label>
        <br>
        <input id="ecrel" class="toggle-vis" type="checkbox" data-column="10"  >
        <label for="ecrel">Emergency Contact Relationship</label>
        <br>
        <input id="add" class="toggle-vis" type="checkbox" data-column="11"  >
        <label for="add">Address</label>
    </div>
    <div class="col-md-4">
        <input id="sss" class="toggle-vis" type="checkbox" data-column="12"  >
        <label for="sss">SSS</label>
        <br>
        <input id="tin" class="toggle-vis" type="checkbox" data-column="13"  >
        <label for="tin">TIN</label>
        <br>
        <input id="pagibig" class="toggle-vis" type="checkbox" data-column="14"  >
        <label for="pagibig">Pagibig</label>
        <br>
        <input id="philhealth" class="toggle-vis" type="checkbox" data-column="15"  >
        <label for="philhealth">Philhealth</label>
        <br>
        <input id="datehired" class="toggle-vis" type="checkbox" data-column="16"  >
        <label for="datehired">Date Hired</label>
        <br>
        <input id="businessunit" class="toggle-vis" type="checkbox" data-column="17"  >
        <label for="businessunit">Business Unit</label>
        <br>
        <input id="position" class="toggle-vis" type="checkbox" data-column="18"  >
        <label for="position">Position</label>
        <br>
        <input id="rank" class="toggle-vis" type="checkbox" data-column="19"  >
        <label for="rank">Rank</label>
        <br>
        <input id="department" class="toggle-vis" type="checkbox" data-column="20"  >
        <label for="department">Department</label>
        <br>
        <input id="workgroup" class="toggle-vis" type="checkbox" data-column="21"  >
        <label for="workgroup">Work Group</label>
        <br>
        <input id="superior" class="toggle-vis" type="checkbox" data-column="22"  >
        <label for="superior">Superior</label>
        <br>
        <input id="employeestatus" class="toggle-vis" type="checkbox" data-column="23"  >
        <label for="employeestatus">Employee Status</label>
    </div>
    <div class="col-md-4">
        <input id="fathername" class="toggle-vis" type="checkbox" data-column="24"  >
        <label for="fathername">Father Name</label>
        <br>
        <input id="mothername" class="toggle-vis" type="checkbox" data-column="25"  >
        <label for="mothername">Mother Name</label>
        <br>
        <input id="spousename" class="toggle-vis" type="checkbox" data-column="26"  >
        <label for="spousename">Spouse Name</label>
        <br>
        <input id="spousebirthday" class="toggle-vis" type="checkbox" data-column="27"  >
        <label for="spousebirthday">Spouse Birthday</label>
        <br>
        <input id="spouseage" class="toggle-vis" type="checkbox" data-column="28"  >
        <label for="spouseage">Spouse Age</label>
        <br>
        <input id="spouseoccupation" class="toggle-vis" type="checkbox" data-column="29"  >
        <label for="spouseoccupation">Spouse Occupation</label>
        <br>
        <input id="spousemployer" class="toggle-vis" type="checkbox" data-column="30"  >
        <label for="spouseemployer">Spouse Employer</label>
        <br>
        <input id="school" class="toggle-vis" type="checkbox" data-column="31"  >
        <label for="school">School</label>
        <br>
        <input id="year_graduated" class="toggle-vis" type="checkbox" data-column="32"  >
        <label for="year_graduated">Year Graduated</label>
        <br>
        <input id="course" class="toggle-vis" type="checkbox" data-column="33"  >
        <label for="course">Course</label>
        <br>
        <input id="license" class="toggle-vis" type="checkbox" data-column="34"  >
        <label for="license">License</label>
    </div>
</div>




<table id="employee" width="100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
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
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            "scrollX": true,
            dom: 'Brtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Extract to Excel',
                    title: 'Employee List',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    text: 'Copy Data',
                    title: 'Employee List',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvisGroup',
                    text: 'Hide All',
                    hide: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 
                            11, 12, 13, 14, 15, 16, 17, 18, 19, 
                            20, 21, 22, 23, 24, 25, 26, 27, 28,
                            29, 30, 31, 32, 33, 34 ]
                },
                {
                    extend: 'colvisGroup',
                    text: 'Show All',
                    show: ':hidden'
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