<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<form method="post" action="<?php echo base_url();?>csv_import/add_employees_attendance" enctype="multipart/form-data">  
    <div class="card-header"><h4>EMPLOYEE ATTENDANCE LIST
       <input type="submit" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;" value="PROCESS"></h4> 
    </div>
    <br>
    <table id="" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">Biometric ID</th>
                <th scope="col">Name</th>
                <th scope="col">Days</th>
                <th scope="col">Time</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if($attendances) : ?>
            <?php foreach($attendances as $attendance) : ?>
                <tr>
                    <td> <input type="text" name="biometric_id[]" value="<?php echo $attendance->biometric_id; ?>" hidden><?php echo $attendance->biometric_id; ?></td>
                    <td> <input type="text" name="employee_number[]" value="<?php echo $attendance->employee_number; ?>" hidden><?php echo $attendance->fullname; ?></td>
                    <td>
                        <?php $explod_date = explode(' ', $attendance->date_time); echo $explod_date[0]; ?>
                        <input type="text" name="date[]" value="<?php echo $explod_date[0]; ?>" hidden>
                    </td>
                    <td> 
                        <?php $explod_date = explode(' ', $attendance->date_time); echo $explod_date[1]; ?>
                        <input type="text" name="time[]" value="<?php echo $explod_date[1]; ?>" hidden>
                    </td>
                    <td>
                        <?php if($attendance->status == 1010) : ?>
                            <?php echo 'IN'; ?>
                            <input type="text" name="status[]" value="<?php echo 'IN'; ?>" hidden>
                        <?php else: ?>
                            <?php echo 'OUT'; ?>
                            <input type="text" name="status[]" value="<?php echo 'OUT'; ?>" hidden>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach;?>
            <?php endif; ?>
        </tbody>
    </table>
</form>    
    <script type="text/javascript">  
        $(document).ready(function() {
            "columnDefs": [
            ],
            $('.display').DataTable( {
                "bStateSave": true,
                "fnStateSave": function (oSettings, oData) {
                    localStorage.setItem('table.display', JSON.stringify(oData));
                },
                "fnStateLoad": function (oSettings) {
                    return JSON.parse(localStorage.getItem('table.display'));
                },
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "bAutoWidth": false
            } );
        } );
    </script>