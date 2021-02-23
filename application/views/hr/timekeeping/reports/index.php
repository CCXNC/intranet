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
                <th scope="col">NAME</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME IN</th>
                <th scope="col">TIME OUT</th>
            </tr>
        </thead>
        <tbody>
           <?php if($employees) : ?>
            <?php foreach($employees as $employee) : ?>
                    <tr>
                        <td><?php echo $employee->fullname; ?></td>
                        <td><?php echo $employee->date; ?></td>
                        <td><?php echo $employee->time_in . '|' . $employee->in_id; ?></td>
                        <td><?php if($employee->time_out == NULL){ echo 'NO OUT'; } else{ echo $employee->time_out . '|' . $employee->out_id; }  ?></td>
                    </tr>
            <?php endforeach; ?>
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