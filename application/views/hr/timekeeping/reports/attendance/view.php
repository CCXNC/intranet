
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
    <div class="card-header"><h4>EMPLOYEE ATTENDANCE LIST <a href="<?php echo base_url(); ?>attendance/index_attendance" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4> 
    </div>
    <br>
    <table id="" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">NAME</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME IN</th>
                <th scope="col">TIME OUT</th>
                <th scope="col">PROCESS</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
           <?php if($employees) : ?>
            <?php foreach($employees as $employee) : ?>
                    <tr>
                        <td><?php echo  $employee->fullname; ?></td>
                        <td>
                        <?php 
                            if($employee->date == NULL)
                            { 
                                echo $employee->temp_date; 

                            } else { 

                                echo $employee->date; 
                            } 
                        ?>
                        </td>
                        <td <?php echo $employee->time_in == NULL ? 'style="background-color:#fa1e0e;color:white;"' : ''; ?>><?php if($employee->time_in == NULL){ echo 'NO IN'; } else{ echo $employee->time_in; } ?></td>
                        <td <?php echo $employee->time_out == NULL ? 'style="background-color:#fa1e0e;color:white;"' : ''; ?>><?php if($employee->time_out == NULL){ echo 'NO OUT'; } else{ echo $employee->time_out; }  ?></td>
                        <td <?php echo $employee->in_generate == NULL && $employee->out_generate == NULL ? 'style="background-color:#fa1e0e;color:white;"' : ''; ?>>
                            <?php 
                                if($employee->in_generate == NULL && $employee->out_generate == NULL) { 
                                    echo  'N/A'; 
                                } elseif($employee->in_generate != NULL && $employee->out_generate == NULL) { 
                                    echo '(IN)' . ' ' . $employee->in_generate; 
                                } elseif($employee->out_generate != NULL && $employee->in_generate == NULL) { 
                                    echo '(OUT)' . ' ' . $employee->out_generate; 
                                } elseif($employee->in_generate != NULL && $employee->out_generate != NULL) {
                                    echo 'SYSTEM';
                                }
                            ?>
                        </td>
                        <td data-label="Action">
                            <?php if($employee->in_generate == NULL || $employee->out_generate == NULL) : ?>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">
                                    ADD 
                                </button>
                            <?php endif; ?>    
                        </td>
                    </tr>
            <?php endforeach; ?>
           <?php endif; ?>
        </tbody>
    </table>  
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">MANUAL ATTENDANCE FORM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-control" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="IN/OUT">IN/OUT</option>
                                            <option value="IN">IN</option>
                                            <option value="OUT">OUT</option>
                                        </select><br>
                                        <input type="time" class="form-control" name="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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