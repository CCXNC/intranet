<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
    <div class="card-header"><h4>EMPLOYEE ATTENDANCE LIST</h4> 
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
                        <td><?php if($employee->date == NULL){ echo 'NO DATE'; } else{ echo $employee->date; } ?></td>
                        <td><?php if($employee->time_in == NULL){ echo 'NO IN'; } else{ echo $employee->time_in; } ?></td>
                        <td><?php if($employee->time_out == NULL){ echo 'NO OUT'; } else{ echo $employee->time_out; }  ?></td>
                    </tr>
            <?php endforeach; ?>
           <?php endif; ?>
        </tbody>
    </table>  
    <script type="text/javascript">  
        $(document).ready(function() {
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
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false
            } );
        } );
    </script>