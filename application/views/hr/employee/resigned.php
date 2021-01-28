<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header"><h4>RESIGNED EMPLOYEE LIST</h4></div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr>
            <th scope="col">Employee Picture</th>
            <th scope="col">Full Name</th>
            <th scope="col">Business Unit</th>
            <th scope="col">Department</th>
            <th scope="col">Position</th>
            <th scope="col">Date Hired</th>
            <th scope="col">Date Terminated</th>
            <th scope="col">Employee Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if($employees) : ?> 
            <?php foreach($employees as $employee) : ?>
                <tr>
                    <td data-label="Employee Picture">
                        <?php if($employee->picture != NULL) : ?>
                            <center>
                                <img class="emppic" src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee->picture; ?>" style="width: 150px; height: 150px;" alt="">
                            </center>
                        <?php else : ?>
                            <center>
                                <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width: 150px; height: 150px;"  alt="">
                            </center>
                        <?php endif; ?>
                    </td>
                    <td data-label="Full Name"><?php echo $employee->fullname;  ?></td>
                    <td data-label="Business Unit"><?php echo $employee->company;  ?></td>
                    <td data-label="Department"><?php echo $employee->department;  ?></td>
                    <td data-label="Position"><?php echo $employee->position;  ?></td>
                    <td data-label="Date Hired"><?php echo date('F j, Y',strtotime($employee->date_hired));  ?></td>
                    <td data-label="Date Termination"><?php echo date('F j, Y',strtotime($employee->date_termination));  ?></td>
                    <td data-label="Employee Status"><?php echo $employee->employee_status;  ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('table.display').DataTable( {
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    title: '',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Filter'
                }
            ],
            columnDefs: [ {
                targets: -1,
                visible: false
            } ]
        } );
    } );
</script>