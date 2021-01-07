<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header"><h4>EMPLOYEE LIST<a href="<?php echo base_url(); ?>employee/do_upload" class="btn btn-info float-right">ADD</a></h4> </div>
    <div class="card-body">
        <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Employee Picture</th>
                    <th>Employee Number</th>
                    <th>Full Name</th>
                    <th>Date Hired</th>
                    <th>Employee Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($employees) : ?>
                    <?php foreach($employees as $employee) : ?>
                        <tr>
                            <td><center><img src="<?php echo base_url(); ?>uploads/images/<?php echo $employee->picture; ?>" width="100px" height="100px" alt=""></center></td>
                            <td><?php echo $employee->emp_no;  ?></td>
                            <td><?php echo $employee->fullname;  ?></td>
                            <td><?php echo $employee->date_hired;  ?></td>
                            <td><?php echo $employee->employee_status;  ?></td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">View</a>
                                            <a class="dropdown-item" href="#">Update</a>
                                            <a class="dropdown-item" href="#">Employment Status</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Transfer</a>
                                        </div>
                                    </div>
                                </center>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

        
  