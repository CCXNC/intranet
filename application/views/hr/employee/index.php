<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
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
                    <th>Employee Picture</th>
                    <th>Full Name</th>
                    <th>Business Unit</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Date Hired</th>
                    <th>Employee Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($employees) : ?> 
                    <?php foreach($employees as $employee) : ?>
                        <tr>
                            <td>
                                <center>
                                    <?php if($employee->picture != NULL) : ?>
                                        <img src="<?php echo base_url(); ?>uploads/employee/<?php echo $employee->picture; ?>" width="120px" height="120px" alt="">
                                    <?php else : ?>
                                        <img src="<?php echo base_url(); ?>uploads/employee/user.jpg" width="120px" height="120px" alt="">
                                    <?php endif; ?>
                                </center>
                            </td>
                            <td><?php echo $employee->fullname;  ?></td>
                            <td><?php echo $employee->company;  ?></td>
                            <td><?php echo $employee->department;  ?></td>
                            <td><?php echo $employee->position;  ?></td>
                            <td><?php echo date('F j, Y',strtotime($employee->date_hired));  ?></td>
                            <td><?php echo $employee->employee_status;  ?></td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/view_employee/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>"> View</a>
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee/edit_employee/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Edit</a>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/add_info/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Add Info</a>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/employee_movement/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Movement</a>
                                            <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/employee_termination/<?php echo $employee->id; ?>/<?php echo $employee->emp_no; ?>">Termination</a>
                                        </div>
                                    </div>
                                </center>
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
    <!--<div class="modal fade" id="exampleModal_00" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SEARCH </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>employee/index" method="post">
                    <div class="col-md-12">
                        <div class="form-group">
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
                    <div class="col-md-12">
                        <div class="form-group">
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
                    <div class="col-md-12">
                        <div class="form-group">
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
                    <center><input type="submit" class="btn btn-info"  value="LOAD"> </center>
                </form>
            </div>
        </div>
    </div> -->
</div>

        
  