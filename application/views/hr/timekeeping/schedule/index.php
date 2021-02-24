<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header"><h4>EMPLOYEE SCHEDULE LIST
    <a href="<?php echo base_url(); ?>schedule/add_schedule" class="btn btn-dark float-right" data-toggle="modal" data-target="#exampleModal" style="border:1px solid #ccc; margin-right:10px;">BIOMETRIC</a>
    <a href="<?php echo base_url(); ?>schedule/add_schedule" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">ADD</a>
    </h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Name</th>
            <th scope="col">Effective Date</th>
            <th scope="col">Days</th>
            <th scope="col">Time</th>
            <th scope="col">Grace Period</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if($schedules) : ?> 
            <?php foreach($schedules as $schedule) : ?>
                <tr>
                    <td data-label="Name"><?php echo $schedule->fullname; ?></td>
                    <td data-label="Effective Date"><?php echo date('F j, Y',strtotime($schedule->effective_date));  ?></td>
                    <td data-label="Days"><?php echo $schedule->days; ?></td>
                    <td data-label="Time"><?php echo date('h:i A', strtotime($schedule->time_in)) . ' | ' . date('h:i A', strtotime($schedule->time_out)); ?></td>
                    <td data-label="Grace Period"><?php echo $schedule->grace_period . ' Minutes'; ?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>schedule/view_schedule/<?php echo $schedule->id; ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>schedule/edit_schedule/<?php echo $schedule->id; ?>">Edit Schedule</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url(); ?>schedule/edit_biometric/<?php echo $schedule->employee_number; ?>">Edit Biometric</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ADD BIOMETRIC</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div style="color:red"><?php echo validation_errors(); ?> </div>
            <form method="post" action="<?php echo base_url(); ?>schedule/add_biometric" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-check-label"><p>EMPLOYEE NAME</p></label>
                            <select name="employee_number" class="form-control">
                                <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                        <option value="<?php echo $employee->id . '|' . $employee->employee_number; ?>"><?php echo $employee->fullname; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-check-label"><p>BIOMETRIC ID</p></label>
                            <input type="number" class="form-control" name="biometric_number" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Do you want to submit data?');">Submit</button>
                </div>
            </form>
    </div>
  </div>
</div>
<script type="text/javascript">  
    $(document).ready(function() {
        $('table.display').DataTable( {
            "scrollX": true,
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
            ]
        } );
    } );
</script>