
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
                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == NULL) { 
                                    echo '(IN-' . ' ' . $employee->in_generate . ')'; 
                                } elseif($employee->out_generate == "SYSTEM" && $employee->in_generate == NULL) { 
                                    echo '(OUT-' . ' ' . $employee->out_generate . ')'; 
                                }  elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'SYSTEM') {
                                    echo 'SYSTEM';
                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'SYSTEM') {
                                    echo '(IN-' . ' ' . $employee->in_generate . ')' . ' | ' . '(OUT-' . ' ' . $employee->out_generate . ')';  
                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'MANUAL') {
                                    echo '(IN-' . ' ' . $employee->in_generate . ')' . ' | ' . '(OUT-' . ' ' . $employee->out_generate . ')';  
                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'MANUAL') {
                                    echo 'MANUAL';  
                                }
                            ?>
                        </td>
                        <td data-label="Action">
                            <?php if($employee->in_generate == "SYSTEM" && $employee->out_generate == 'MANUAL') : ?>
                                <?php echo strtoupper($employee->out_generated); ?>
                            <?php elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'SYSTEM') : ?>  
                                <?php echo strtoupper($employee->in_generated); ?>
                            <?php elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'MANUAL') : ?>  
                                <?php echo strtoupper($employee->in_generated); ?>    
                            <?php elseif($employee->in_generate != "SYSTEM" || $employee->out_generate != 'SYSTEM') : ?>   
                                <button type="button" id="test" class="btn btn-info " data-toggle="modal" data-target="#exampleModalCenter_<?php echo $employee->employee_number; ?>_<?php echo $employee->temp_date; ?>">
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
    <?php if($employees) : ?>
        <?php foreach($employees as $employee) : ?>
            <div class="modal fade" id="exampleModalCenter_<?php echo $employee->employee_number; ?>_<?php echo $employee->temp_date; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">MANUAL ATTENDANCE FORM</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url(); ?>attendance/add_manual_attendance" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="fullname" value="<?php echo $employee->fullname; ?>" readonly><br>
                                                <label for="">TIME IN</label>
                                                <?php if($employee->time_in != NULL) : ?>
                                                    <input type="text" name="process" value="1" hidden>
                                                    <input  type="time" class="form-control "  name="time_in" value="<?php echo $employee->time_in; ?>" readonly><br>
                                                <?php else : ?>
                                                    <input  type="time" class="form-control " name="time_in" required="required"><br>
                                                <?php endif; ?>   
                                                <label for="">TIME OUT</label>
                                                <input type="time" class="form-control" name="time_out" value="<?php echo $employee->time_out; ?>" required="required">

                                                <input type="text" name="employee_number" value="<?php echo $employee->employee_number; ?>" hidden>
                                                <input type="text" name="biometric_id" value="<?php echo $employee->biometric_id; ?>" hidden>
                                                <input type="text" name="date" value="<?php echo $employee->temp_date; ?>" hidden>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" onclick="return confirm('Do you want to submit data?');" class="btn btn-info">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>            
    <script type="text/javascript">
        $(document).ready(function() {
            $('table.display').DataTable( {
                "paging":   false,
                "ordering": false,
                "info":     false,
                dom: 'Bf',
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
                    ]
            } );
        } );
    </script>