<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card">
    <div class="card-header" style=""><h4><?php echo $employee_name->fullname; ?> ( <?php echo $employee_name->department_name; ?> ) <a href="<?php echo base_url(); ?>attendance/index_individual_attendance" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</h4></a> 
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color: #3490dc; color:white;">DAILY ATTENDANCE  
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME IN</th>
                            <th scope="col">TIME OUT</th>
                            <th scope="col">TARDINESS</th>
                            <th scope="col">UNDERTIME</th>
                            <th>Schedule (IN/OUT/GP)</th>
                            <th scope="col">PROCESS</th>
                            <th scope="col">REMARKS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employees) : ?>
                            <?php foreach($employees as $employee) : ?>
                                <tr>
                                    <?php $w_date = date('w', strtotime($employee->temp_date)); ?>
                                    <?php if(($employee->date_in != NULL || $employee->date_out != NULL) || ($w_date != 6  && $w_date != 0)) : ?>
                                        <?php
                                            //EXPLODE ACTUAL TIME IN AND TIME OUT
                                            if($employee->time_in != NULL && $employee->time_out != NULL)
                                            {
                                                $explod_time_in = explode(":",$employee->time_in);
                                                $explod_time_out = explode(":",$employee->time_out);
                                            }
                                            elseif($employee->time_in != NULL && $employee->time_out == NULL)
                                            {
                                                $explod_time_in = explode(":",$employee->time_in);
                                                $explod_time_out = explode(":",'00:00');
                                            }
                                            elseif($employee->time_in == NULL && $employee->time_out != NULL)
                                            {
                                                $explod_time_in = explode(":",'00:00');
                                                $explod_time_out = explode(":",$employee->time_out);
                                            }
                                            else
                                            {
                                                $explod_time_in = explode(":",'00:00');
                                                $explod_time_out = explode(":",'00:00');
                                            }
                                            $explode_time_in_hours = $explod_time_in[0];
                                            $explode_time_in_mins = $explod_time_in[1];

                                            $explode_time_out_hours = $explod_time_out[0];
                                            $explode_time_out_mins = $explod_time_out[1];
                                            //echo $explode_time_in_hours . 'HOURS |' . $explode_time_in_mins . 'MINS';
                                            //echo $explode_time_out_hours . 'HOURS |' . $explode_time_out_mins . 'MINS';

                                            //EXPLODE SCHEDULE TIME IN AND TIME OUT
                                            $explod_sched_time_in = explode(":",$employee->sched_time_in);
                                            $explod_sched_time_out = explode(":",$employee->sched_time_out);

                                            $explode_sched_time_in_hours = $explod_sched_time_in[0];
                                            $explode_sched_time_in_mins = $explod_sched_time_in[1];

                                            $explode_sched_time_out_hours = $explod_sched_time_out[0];
                                            $explode_sched_time_out_mins = $explod_sched_time_out[1];
                                            //echo $explode_sched_time_in_hours . 'HOURS |' . $explode_sched_time_in_mins . 'MINS';
                                            //echo $explode_sched_time_out_hours . 'HOURS |' . $explode_sched_time_out_mins . 'MINS';

                                            //COMPUTATION OF ACTUAL TIME IN AND TIME OUT TO MINUTES
                                            $time_in_mins = $explode_time_in_hours * 60;
                                            $total_time_in_mins = $time_in_mins + $explode_time_in_mins;

                                            $time_out_mins = $explode_time_out_hours * 60;
                                            $total_time_out_mins = $time_out_mins + $explode_time_out_mins;
                                            //echo $total_time_in_mins . '|' . $total_time_out_mins;

                                            //COMPUTATION OF SCHEDULE TIME IN PLUS GRACE PERIOD AND TIME OUT TO MINUTES
                                            $sched_time_in_mins = $explode_sched_time_in_hours * 60;
                                            $total_sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins + $employee->grace_period;

                                            $sched_time_out_mins = $explode_sched_time_out_hours * 60;
                                            $total_sched_time_out_mins = $sched_time_out_mins + $explode_sched_time_out_mins;
                                            //echo $total_sched_time_in_mins . '|' . $total_sched_time_out_mins;

                                            // UNDERTIME MORNING MINUTES
                                            $undertime_am_mins = 540;
                                            $undertime_pm_mins = 900;

                                            //HALFDAY MINUTES
                                            $halfday_mins = 660;
                                            $halfday_in_mins = 780;
                                        
                                        ?>
                                        <!-- DAYS -->
                                        <td>
                                            <?php
                                                if($employee->date_in != NULL)
                                                { 
                                                    echo date('D', strtotime($employee->date_in)); 

                                                } elseif($employee->date_out != NULL) { 

                                                    echo date('D', strtotime($employee->date_out)); 
                                                } else {
                                                    echo date('D', strtotime($employee->temp_date)); 
                                                }
                                            ?>    
                                        </td>
                                        <!-- DATE -->
                                        <td>
                                            <?php  
                                                if($employee->date_in != NULL) { 

                                                    echo $employee->date_in; 

                                                } elseif($employee->date_out != NULL) { 

                                                    echo $employee->date_out; 
                                                } else {
                                                    
                                                   echo $employee->temp_date; 
                                                } 
                                            ?>
                                        </td>
                                        <!-- TIME IN -->
                                        <td>
                                            <?php 
                                                $days_temp_date = date('w', strtotime($employee->temp_date));
                                                if($employee->time_in == NULL) { 
                                                    if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) 
                                                    {
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
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else {
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
                                                $days_temp_date = date('w', strtotime($employee->temp_date));
                                                if($employee->time_out == NULL) { 
                                                    if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) 
                                                    {
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
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
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
                                        <!-- TARDINESS-->
                                        <td>
                                            <?php 
                                                // HALFDAY 
                                                if($halfday_mins <= $total_time_in_mins)
                                                {
                                                    if($halfday_in_mins <= $total_time_in_mins)
                                                    {
                                                        //COMPUTATION OF ACTUAL TIME IN AND UNDERTIME MORNING 
                                                        $tardiness_mins = $total_time_in_mins - $halfday_in_mins;
                                                        $hours = intval($tardiness_mins/60);
                                                        $min_diff = intval($tardiness_mins%60);
                                                        $minutes = sprintf("%02d", $min_diff);
                                                        echo $hours.".".$minutes.""; 
                                                    }
                                                }
                                                // WHOLEDAY
                                                else
                                                {
                                                    if($total_sched_time_in_mins >= $total_time_in_mins)
                                                    {
                                                        
                                                    }
                                                    elseif($undertime_am_mins <= $total_time_in_mins)
                                                    {
                                                        /*COMPUTATION OF ACTUAL TIME IN AND UNDERTIME MORNING 
                                                        $tardiness_mins = $total_time_in_mins - $undertime_am_mins;
                                                        $hours = intval($tardiness_mins/60);
                                                        $min_diff = intval($tardiness_mins%60);
                                                        $minutes = sprintf("%02d", $min_diff);
                                                        echo $hours.".".$minutes."";
                                                        echo $tardiness_mins;*/

                                                        //COMPUTATION UNDERTIME
                                                        /*$undertime_mins = $undertime_mins - $total_sched_time_in_mins;
                                                        $undertime_hours = intval($undertime_mins/60);
                                                        $undertime_min_diff = intval($undertime_mins%60);
                                                        $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                        echo $undertime_hours.".".$undertime_minutes."";*/
                                                    }
                                                    else
                                                    {
                                                        //COMPUTATION OF ACTUAL TIME IN AND SCHEDULE TIME IN
                                                        $tardiness_mins = $total_time_in_mins - $total_sched_time_in_mins;
                                                        $hours = intval($tardiness_mins/60);
                                                        $min_diff = intval($tardiness_mins%60);
                                                        $minutes = sprintf("%02d", $min_diff);
                                                        echo $hours.".".$minutes."";
                                                        //echo $tardiness_mins;
                                                    }
                                                }
                                            
                                            ?>
                                        </td>
                                        <!-- UNDERTIME AM -->
                                        <td>
                                            <?php 
                                                if($halfday_mins <= $total_time_in_mins)
                                                {
                                                    
                                                }
                                                else
                                                {
                                                    if($undertime_am_mins <= $total_time_in_mins)
                                                    {
                                                        //COMPUTATION UNDERTIME
                                                        $undertime_mins = $total_time_in_mins - $total_sched_time_in_mins + 5;
                                                        $undertime_hours = intval($undertime_mins/60);
                                                        $undertime_min_diff = intval($undertime_mins%60);
                                                        $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                        echo $undertime_hours.".".$undertime_minutes."";
                                                    }
                                                    elseif($undertime_pm_mins <= $total_time_out_mins && $total_sched_time_out_mins >= $total_time_out_mins)
                                                    {
                                                        //COMPUTATION UNDERTIME
                                                        $undertime_mins = $total_sched_time_out_mins - $total_time_out_mins;
                                                        $undertime_hours = intval($undertime_mins/60);
                                                        $undertime_min_diff = intval($undertime_mins%60);
                                                        $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                        echo $undertime_hours.".".$undertime_minutes."";  
                                                    }
                                                }
                                            ?>

                                        </td>
                                        <!--  ScHEDULES-->
                                        <td>
                                            <?php 
                                                if($employee->date_in != NULL || $employee->date_out != NULL)
                                                {
                                                    echo $employee->sched_time_in . '|' . $employee->sched_time_out . '|' . $employee->grace_period; 
                                                }
                                                
                                            ?>
                                        </td>
                                        <!-- PROCESS-->
                                        <td>
                                            <?php 
                                                $days_temp_date = date('w', strtotime($employee->temp_date));
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
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
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
                                                    echo  '<p class="" style="text-align:center;margin-top:15px;padding:5px;background-color:#ffed4a;">' . 'MANUAL' . '</p>';  
 
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
                                                    <?php endif; ?>
                                                <?php elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'SYSTEM') : ?>   
                                                    <?php  if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) : ?>
                                                        <?php echo strtoupper($employee->ob_created_by); ?>
                                                    <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?> 
                                                        <?php echo strtoupper($employee->leave_created_by); ?>  
                                                    <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>
        <br>
        <!--<div class="card">
            <div class="card-header" style="background-color: #6547cd; color:white;">LEAVE OF ABSENCE 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">DAY</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">ADDRESS WHILE ON LEAVE</th>
                            <th scope="col">REASON</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employee_leaves) : ?>
                            <?php foreach($employee_leaves as $employee_leave) : ?>
                                <tr>
                                    <td><?php echo date('D', strtotime($employee_leave->leave_date)); ?></td>
                                    <td><?php echo $employee_leave->leave_date; ?></td>
                                    <td><?php if($employee_leave->leave_day == "WD") { echo "WHOLE DAY"; } elseif($employee_leave->leave_day == "HDAM") { echo "HALFDAY (AM)"; } elseif($employee_leave->leave_day == "HDPM") { echo "HALFDAY (PM)"; } else { echo ''; } ?></td>
                                    <td><?php echo $employee_leave->type_name; ?></td>
                                    <td><?php echo $employee_leave->leave_address; ?></td>
                                    <td><?php echo substr($employee_leave->reason,0,50); ?></td>
                                    <td><?php if($employee_leave->status == 0) {  echo 'FOR APPROVAL';  } else {  echo 'APPROVED'; } ?></td>
                        </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color:#38c172; color:white;">OFFICIAL BUSINESS 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">PURPOSE / REMARKS</th> 
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employee_obs) : ?>
                            <?php foreach($employee_obs as $employee_ob) : ?>
                                <tr>
                                    <td><?php echo date('D', strtotime($employee_ob->date_ob)); ?></td>
                                    <td><?php echo $employee_ob->date_ob; ?></td>
                                    <td><?php echo $employee_ob->type; ?></td>
                                    <td><?php if($employee_ob->type == "FIELD WORK") { echo substr($employee_ob->purpose,0,50); } else { echo substr($employee_ob->remarks,0,50); } ?></td>
                                    <td><?php if($employee_ob->status == 0) {  echo 'FOR APPROVAL';  } else {  echo 'APPROVED'; } ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>-->
        <br>
        <div class="card">
            <div class="card-header" style="background-color:#067593; color:white;">UNDERTIME  
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME</th>
                            <th scope="col">UT HOURS</th>
                            <th scope="col">REASON</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color:#0C2D48; color:white;">OVERTIME  
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">TIME IN</th>
                            <th scope="col">TIME OUT</th>
                            <th scope="col">OT HOURS</th>
                            <th scope="col">NATURE OF WORK</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
    </div>
</div>
   
    <br>
   