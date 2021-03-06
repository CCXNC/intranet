<style>
    input[type="checkbox"]{
        -webkit-appearance: initial;
        appearance: initial;
        background: white;
        width: 12px;
        height: 12px;
        border: solid black 1px;
        position: relative;
    }
    input[type="checkbox"]:checked {
        background: red;
    }
    input[type="checkbox"]:checked:after {
        /* Heres your symbol replacement */
        content: "X";
        color: white;
        /* The following positions my tick in the center, 
        * but you could just overlay the entire box
        * with a full after element with a background if you want to */
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
    }
</style>
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
    <div class="card-header" style="background-color: #007BFF; border: #007BFF; color: white"><h4>DAILY ATTENDANCE<a href="<?php echo base_url(); ?>attendance/index_attendance" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4> 
    </div>
    <br>
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">NAME</th>
                <th scope="col">BUSINESS UNIT</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">RANK</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME IN</th>
                <th scope="col">TIME OUT</th>
                <th scope="col">PROCESS</th>
                <th scope="col">REMARKS</th>
                <th scope="col">REASON</th>
                <th scope="col">ACTION BY</th>
            </tr>
        </thead>
        <tbody>
            <?php if($employees) : ?>
                <?php foreach($employees as $employee) : ?>
                    <tr>
                        <!-- FULLNAME -->
                        <td><?php echo $employee->fullname; ?></td>
                        <!-- BUSINET UNIT -->
                        <td><?php echo $employee->company_name; ?></td>
                        <!-- DEPARTMENT -->
                        <td><?php echo $employee->department_name; ?></td>
                         <!-- DEPARTMENT -->
                         <td><?php echo $employee->rank_name; ?></td>
                        <!-- DATE -->
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
                        <!-- TIME IN -->
                        <td>
                            <?php 
                                if($employee->time_in == NULL) { 
                                    if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) {
                                        if($employee->ob_type == "FIELD WORK") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(127,127,127);color:white;"></p>'; 
                                        } else {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
      
                                        }
                                    } 
                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                    {
                                        if($employee->type_name == "VL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:#3490dc;color:white;"></p>';
                                        }  elseif($employee->type_name == "SL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:#38c172;color:white;"></p>';
                                        } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                        } else {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                        }
                                    }
                                    else
                                    {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#e3342f;color:white;">NO IN</p>'; 
                                    }
                                }
                               else { 
                                    echo $employee->time_in; 
                                } 
                            ?>
                        </td>
                        <!-- TIME OUT-->
                        <td> 
                            <?php 
                                if($employee->time_out == NULL) { 
                                    if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) {
                                        if($employee->ob_type == "FIELD WORK") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(127,127,127);color:white;"></p>'; 
                                        } else {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
      
                                        }
                                    } 
                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                    {
                                        if($employee->type_name == "VL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:#3490dc;color:white;"></p>';
                                        }  elseif($employee->type_name == "SL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:#38c172;color:white;"></p>';
                                        } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                        } else {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                        }
                                    }
                                    else
                                    {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#e3342f;color:white;">NO OUT</p>'; 
                                    }
                                }
                               else { 
                                    echo $employee->time_out; 
                                } 
                            ?>
                        </td>
                         <!-- PROCESS-->
                        <td>
                            <?php 
                                if($employee->in_generate == NULL && $employee->out_generate == NULL) { 
                                    if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) {
                                        if($employee->ob_type == "FIELD WORK") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(127,127,127);color:white;"></p>'; 
                                        } else {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
      
                                        }
                                    } 
                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                    {
                                        if($employee->type_name == "VL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:#3490dc;color:white;"></p>';
                                        }  elseif($employee->type_name == "SL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:#38c172;color:white;"></p>';
                                        } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                        } else {
                                            echo '<p class="" style="text-align:center;margin-top:15px;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                        }
                                    }
                                    else
                                    {
                                        echo  '<p class="" style="width:50%; text-align:center;margin-top:15px;padding:5px;background-color:#e3342f;color:white;">N/A</p>'; 
                                    }
                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == NULL) { 
                                    echo  '(IN-' . ' ' . $employee->in_generate . ')' ; 
                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == NULL) { 
                                    echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#ffed4a;">' . '(IN-' . ' ' . $employee->in_generate . ')' . '</p>'; 
                                }  elseif($employee->in_generate == NULL && $employee->out_generate == "MANUAL") { 
                                    echo '(IN-' . ' ' . $employee->in_generate . ')'; 
                                } elseif($employee->out_generate == "SYSTEM" && $employee->in_generate == NULL) { 
                                    echo '(OUT-' . ' ' . $employee->out_generate . ')'; 
                                }  elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'SYSTEM') {
                                    echo 'SYSTEM';
                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'SYSTEM') {
                                    echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#ffed4a;">' . '(IN-' . ' ' . $employee->in_generate . ')' . '</p>' . ' | ' . '(OUT-' . ' ' . $employee->out_generate . ')';  
                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'MANUAL') {
                                    echo  '(IN-' . ' ' . $employee->in_generate . ')' . ' | ' . '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#ffed4a;">' . '(OUT-' . ' ' . $employee->out_generate . ')' . '</p>';  
                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'MANUAL') {
                                    echo 'MANUAL';  
                                }
                            ?>
                        </td>
                         <!-- REMARKS-->
                        <td>
                            <?php if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) : ?>
                                <?php 
                                    if($employee->ob_type == "FIELD WORK") {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:rgb(127,127,127);color:white;">' . $employee->ob_type .'</p>'; 
                                    } else {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:rgb(113,173,83);color:white;">' . $employee->ob_type .'</p>'; 
  
                                    }
                                ?>
                            <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?>
                                <?php

                                    if($employee->type_name == "VL") {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#3490dc;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                    }  elseif($employee->type_name == "SL") {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#38c172;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                    } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:rgb(111,49,160);color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                    } else {
                                        echo '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:rgb(255,100,0);color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                    }
                                ?>    
                            <?php endif; ?>    
                        </td>
                        <!-- REASON-->
                        <td>
                            <?php if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) : ?>
                                    <?php 
                                        if($employee->ob_type == "FIELD WORK") {
                                            echo '<p>' . $employee->ob_purpose .'</p>'; 
                                        } else {
                                            echo '<p>' . $employee->ob_remarks .'</p>'; 
    
                                        }
                                    ?>
                            <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?>
                                <?php

                                    if($employee->type_name == "VL" || $employee->type_name == "SL" || $employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                        echo '<p>'. $employee->leave_reason  . '' .'</p>';
                                    }  
                                ?>    
                            <?php endif; ?>    
                        </td>
                        <!-- ACTION -->
                        <td data-label="Action">
                            <?php if($employee->in_generate == "SYSTEM" && $employee->out_generate == 'MANUAL') : ?>
                                <?php echo strtoupper($employee->out_generated); ?>
                            <?php elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'SYSTEM') : ?>  
                                <?php echo strtoupper($employee->in_generated); ?>
                            <?php elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'MANUAL') : ?>  
                                <?php echo strtoupper($employee->in_generated); ?>    
                            <?php elseif($employee->in_generate != "SYSTEM" || $employee->out_generate != 'SYSTEM') : ?>   
                                <?php  if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) : ?>
                                    <?php echo strtoupper($employee->ob_created_by); ?>
                                <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?> 
                                    <?php echo strtoupper($employee->leave_created_by); ?>   
                                <?php else: ?>
                                    <button title="Add Manual Attendance" type="button" id="test" class="btn btn-info " data-toggle="modal" data-target="#exampleModalCenter_<?php echo $employee->employee_number; ?>_<?php echo $employee->temp_date; ?>">
                                        ADD 
                                    </button>
                                <?php endif; ?>
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
                            <h5 class="modal-title" id="exampleModalLongTitle">ATTENDANCE FORM</h5>
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
                                                <input type="text" name="date" class="form-control" value="<?php echo $employee->temp_date; ?>" readonly><br>
                                                <input type="text" name="employee_number" value="<?php echo $employee->employee_number; ?>" hidden>
                                                <input type="text" name="department_id" value="<?php echo $employee->department_id; ?>" hidden>
                                                <input type="text" name="company_id" value="<?php echo $employee->company_id; ?>" hidden>
                                                <input type="text" name="biometric_id" value="<?php echo $employee->biometric_id; ?>" hidden>
                                                <select class="form-control attendance"  name="attendance" >
                                                    <option value="1">MANUAL ATTENDANCE</option>
                                                    <option value="2">OTHERS</option>
                                                </select>
                                                <br>
                                                <div class="others">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="other" value="SL" checked>
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            SICK LEAVE
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="other" value="VL">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            VACATION LEAVE
                                                        </label>
                                                    </div> 
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="other" value="ML">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            MATERNITY LEAVE
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="other" value="NO WORK SCHEDULE">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            NO WORK SCHEDULE
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="other" value="FIELD WORK">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            FIELD WORK
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="other" value="WORK FROM HOME">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            WORK FROM HOME
                                                        </label>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="manual">
                                                    <label for="">TIME IN</label>
                                                    <?php if($employee->time_in != NULL) : ?>
                                                        <input type="text" name="process" value="1" hidden>
                                                        <input  type="time" class="form-control "  name="time_in" value="<?php echo $employee->time_in; ?>" readonly><br>
                                                    <?php else : ?>
                                                        <input  type="time" class="form-control " name="time_in"><br>
                                                    <?php endif; ?>   
                                                    <input type="checkbox" checked class="check" name="no_time_out" value="1">&nbsp;<label for="">TIME OUT</label>
                                                    <input type="time" class="timeOut form-control" name="time_out" value="<?php echo $employee->time_out; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" title="Close Manual Attendance Form" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" title="Submit Manual Attendance Form" onclick="return confirm('Do you want to submit data?');" class="btn btn-info">Submit</button>
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
            $('.check').prop('checked', true);
            $('.timeOut').prop('disabled', true);
            $(".check").click(function(){
                if($(this).prop('checked') == false) {
                    $('.timeOut').attr('disabled', false);
                } else if($(this).prop('checked') == true) {
                    $('.timeOut').attr('disabled', true);
                } 
            });  

            $(".others").hide();
            $('.attendance').on('change', function() {
                var value = $(this).val();
                if(value == 2) {
                    $(".others").show();
                    $(".manual").hide();
                } else if(value == 1) {
                    $(".others").hide();
                    $(".manual").show();
                }
            });    

            $('table.display').DataTable( {
                "bStateSave": true,
                "fnStateSave": function (oSettings, oData) {
                    localStorage.setItem('table.display', JSON.stringify(oData));
                },
                "fnStateLoad": function (oSettings) {
                    return JSON.parse(localStorage.getItem('table.display'));
                },
                "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
                dom: 'Blfrtp',
                buttons: [
                        {
                            extend: 'excel',
                            title: 'Daily Attendance',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Daily Attendance',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'Daily Attendance',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            title: 'Daily Attendance',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'copy',
                            title: 'Daily Attendance',
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
    