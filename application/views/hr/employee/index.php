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

        img{
            width: 50% !important;
        }

        .btnaction{
            float: right;
        }
    }
</style>

<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4>EMPLOYEE LIST
    <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#exampleModal_00">
        DOWNLOAD
    </button>
    <a href="<?php echo base_url(); ?>employee/do_upload" class="btn btn-info float-right" style="margin-right:10px;">ADD</a></h4> </div>
    <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Employee Picture</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Business Unit</th>
                    <th scope="col">Department</th>
                    <th scope="col">Position</th>
                    <th scope="col">Date Hired</th>
                    <th scope="col">Employee Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($employees) : ?> 
                    <?php foreach($employees as $employee) : ?>
                        <tr>
                            <td data-label="Employee Picture">
                                    <?php if($employee->picture != NULL) : ?>
                                        <img class="emppic" src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee->picture; ?>" style="width: 100%" alt="">
                                    <?php else : ?>
                                        <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" style="width: 100%"  alt="">
                                    <?php endif; ?>
                            </td>
                            <td data-label="Full Name"><?php echo $employee->fullname;  ?></td>
                            <td data-label="Business Unit"><?php echo $employee->company;  ?></td>
                            <td data-label="Department"><?php echo $employee->department;  ?></td>
                            <td data-label="Position"><?php echo $employee->position;  ?></td>
                            <td data-label="Date Hired"><?php echo date('F j, Y',strtotime($employee->date_hired));  ?></td>
                            <td data-label="Employee Status"><?php echo $employee->employee_status;  ?></td>
                            <td data-label="Action">
                                
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/view_employee/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>"> View</a>
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/edit_employee/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Edit</a>
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/delete_view_employee/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Delete</a>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/add_info/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Add Info</a>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/employee_movement/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Movement</a>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/employee_termination/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Termination</a>
                                        </div>
                                    </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="float-right">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>

        
  