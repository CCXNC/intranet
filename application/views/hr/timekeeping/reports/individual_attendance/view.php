<style>
    .check{
        -webkit-appearance: initial;
        appearance: initial;
        background: white;
        width: 12px;
        height: 12px;
        border: solid black 1px;
        position: relative;
    }
    .check:checked {
        background: red;
    }
    .check:checked:after {
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
<div class="card">
    <div class="card-header" style=""><h4><?php echo $employee_name->fullname; ?> ( <?php echo $employee_name->department_name; ?> ) <a href="<?php echo base_url(); ?>attendance/index_individual_attendance" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</h4></a> 
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color: #3490dc; color:white;"><h5> DAILY ATTENDANCE  </h5>
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap">
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
                                                $explod_time_out = explode(":","00:00");
                                            }
                                            elseif($employee->time_in == NULL && $employee->time_out != NULL)
                                            {
                                                $explod_time_in =  explode(":","00:00");
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
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(127,127,127);color:white;"></p>'; 
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
                    
                                                        }
                                                    } 
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                    {
                                                        if($employee->type_name == "VL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;color:white;"></p>';
                                                        }  elseif($employee->type_name == "SL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                        } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                        }
                                                    }
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">NO IN</p>'; 
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
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(127,127,127);color:white;"></p>'; 
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
                    
                                                        }
                                                    } 
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                    {
                                                        if($employee->type_name == "VL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;color:white;"></p>';
                                                        }  elseif($employee->type_name == "SL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                        } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                        }
                                                    }
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">NO OUT</p>'; 
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
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDPM')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo '0';
                                                        }
                                                        else 
                                                        {
                                                            //COMPUTATION OF ACTUAL TIME IN AND UNDERTIME MORNING 
                                                            $tardiness_mins = $total_time_in_mins - $halfday_in_mins;
                                                            $hours = intval($tardiness_mins/60);
                                                            $min_diff = intval($tardiness_mins%60);
                                                            $minutes = sprintf("%02d", $min_diff);
                                                            echo $hours.".".$minutes.""; 
                                                        }    
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
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDAM')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo '0';
                                                        }
                                                        else
                                                        {
                                                             //COMPUTATION OF ACTUAL TIME IN AND UNDERTIME MORNING 
                                                            $tardiness_mins = $total_time_in_mins - $undertime_am_mins;
                                                            $hours = intval($tardiness_mins/60);
                                                            $min_diff = intval($tardiness_mins%60);
                                                            $minutes = sprintf("%02d", $min_diff);
                                                            echo $hours.".".$minutes."";
                                                            //echo $tardiness_mins;
                                                        }
                                                       
                                                    }
                                                    else
                                                    {
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDAM')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo '0';
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
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDAM')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo '0';
                                                        }
                                                        else
                                                        {
                                                             //COMPUTATION UNDERTIME
                                                            $undertime_mins = $undertime_am_mins - $total_sched_time_in_mins + 5;
                                                            $undertime_hours = intval($undertime_mins/60);
                                                            $undertime_min_diff = intval($undertime_mins%60);
                                                            $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                            echo $undertime_hours.".".$undertime_minutes."";
                                                        }
                                                       
                                                    }
                                                    elseif($undertime_pm_mins <= $total_time_out_mins && $total_sched_time_out_mins >= $total_time_out_mins)
                                                    {
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDPM')
                                                        {
                                                            echo '0';
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo '0';
                                                        }
                                                        else
                                                        {
                                                            //COMPUTATION UNDERTIME
                                                            $undertime_mins = $total_sched_time_out_mins - $total_time_out_mins;
                                                            $undertime_hours = intval($undertime_mins/60);
                                                            $undertime_min_diff = intval($undertime_mins%60);
                                                            $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                            echo $undertime_hours.".".$undertime_minutes."";  
                                                        }    
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
                                        <!--  PROCESS -->
                                        <td>
                                            <?php 
                                                $days_temp_date = date('w', strtotime($employee->temp_date));
                                                if($employee->in_generate == NULL && $employee->out_generate == NULL) { 
                                                    if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) {
                                                        if($employee->ob_type == "FIELD WORK") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(127,127,127);color:white;"></p>'; 
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
                    
                                                        }
                                                    } 
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                    {
                                                        if($employee->type_name == "VL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;color:white;"></p>';
                                                        }  elseif($employee->type_name == "SL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                        } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                        }
                                                    }
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else
                                                    {
                                                        echo  '<p class="" style="width:50%; text-align:center;padding:5px;background-color:#e3342f;color:white;">N/A</p>'; 
                                                    }
                                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == NULL) { 
                                                    echo  '(IN-' . ' ' . $employee->in_generate . ')' ; 
                                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == NULL) { 
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' . '(IN-' . ' ' . $employee->in_generate . ')' . '</p>'; 
                                                }  elseif($employee->in_generate == NULL && $employee->out_generate == "MANUAL") { 
                                                    echo '(IN-' . ' ' . $employee->in_generate . ')'; 
                                                } elseif($employee->out_generate == "SYSTEM" && $employee->in_generate == NULL) { 
                                                    echo '(OUT-' . ' ' . $employee->out_generate . ')'; 
                                                }  elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'SYSTEM') {
                                                    echo 'SYSTEM';
                                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'SYSTEM') {
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' . '(IN-' . ' ' . $employee->in_generate . ')' . '</p>' . ' | ' . '(OUT-' . ' ' . $employee->out_generate . ')';  
                                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'MANUAL') {
                                                    echo  '(IN-' . ' ' . $employee->in_generate . ')' . ' | ' . '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' . '(OUT-' . ' ' . $employee->out_generate . ')' . '</p>';  
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
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:rgb(127,127,127);color:white;">' . $employee->ob_type .'</p>'; 
                                                    } else {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:rgb(113,173,83);color:white;">' . $employee->ob_type .'</p>'; 
                
                                                    }
                                                ?>
                                            <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?>
                                                <?php
                                                    if($employee->type_name == "VL") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#3490dc;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    }  elseif($employee->type_name == "SL") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#38c172;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:rgb(111,49,160);color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    } elseif($employee->type_name == "VACATION LEAVE") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#3490dc;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    } elseif($employee->type_name == "VL W/O PAY") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:rgb(255,100,0);color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    } elseif($employee->type_name == "SICK LEAVE") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#38c172;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    } elseif($employee->type_name == "SL W/O PAY") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    }
                                                ?>    
                                            <?php endif; ?>    
                                        </td>
                                        <!-- ACTION -->
                                        <td data-label="Action">
                                            <?php if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) : ?>
                                                <?php echo strtoupper($employee->ob_created_by); ?>
                                            <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?>
                                                <?php echo strtoupper($employee->leave_created_by); ?>   
                                            <?php else: ?> 
                                                <button title="Add Manual Attendance" type="button" id="test" class="btn btn-info " data-toggle="modal" data-target="#exampleModalCenter_<?php echo $employee->employee_number; ?>_<?php echo $employee->temp_date; ?>">
                                                    View
                                                </button>
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
        <div class="card">
            <div class="card-header" style="background-color: #38c172; color:white;">
                <h5> LEAVE OF ABSENCE <a href="<?php echo base_url(); ?>reports/index_slvl" target="_blank" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">ADD </a> </h5>
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
                        <!--<?php if($employee_leaves) : ?>
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
                        <?php endif; ?>-->
                    </tbody>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color:rgb(127,127,127); color:white;"> 
                <h5>  FIELD WORK / WORK FROM HOME <a target="_blank" href="<?php echo base_url(); ?>reports/index_ob" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">ADD </a> </h5>
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
                        <!--<?php if($employee_obs) : ?>
                            <?php foreach($employee_obs as $employee_ob) : ?>
                                <tr>
                                    <td><?php echo date('D', strtotime($employee_ob->date_ob)); ?></td>
                                    <td><?php echo $employee_ob->date_ob; ?></td>
                                    <td><?php echo $employee_ob->type; ?></td>
                                    <td><?php if($employee_ob->type == "FIELD WORK") { echo substr($employee_ob->purpose,0,50); } else { echo substr($employee_ob->remarks,0,50); } ?></td>
                                    <td><?php if($employee_ob->status == 0) {  echo 'FOR APPROVAL';  } else {  echo 'APPROVED'; } ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>-->
                    </tbody>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color:#067593; color:white;">
                <h5>  UNDERTIME   <a target="_blank" href="<?php echo base_url(); ?>reports/index_ut" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">ADD </a> </h5>
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
            <div class="card-header" style="background-color:#0C2D48; color:white;">
                <h5> OVERTIME<a target="_blank" href="<?php echo base_url(); ?>reports/index_ot" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">ADD </a> </h5>
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
                            <form method="post" action="<?php echo base_url(); ?>attendance/add_individual_manual_attendance" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="date" class="form-control" value="<?php echo $employee->temp_date; ?>" readonly><br>
                                                <input type="text" name="employee_number" value="<?php echo $employee->employee_number; ?>" hidden>
                                                <input type="text" name="biometric_id" value="<?php echo $employee->biometric_id; ?>" hidden>
                                                <select class="form-control attendance"  name="attendance" >
                                                    <option value="1">ADD</option>
                                                    <option value="2">UPDATE</option>
                                                    <option value="3">DELETE</option>
                                                </select>
                                                <br>
                                                <div class="add">
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
                                                
                                                <div class="edit">

                                                    <input type="checkbox" class="editCheckIn" name="edit_no_time_in" value="1">&nbsp;<label for="">TIME IN</label>
                                                    <input  type="time" class="editTimeIn form-control "  name="edit_time_in" value="<?php echo $employee->time_in; ?>"><br>

                                                    <input type="checkbox" class="editCheckOut" name="edit_no_time_out" value="1">&nbsp;<label for="">TIME OUT</label>
                                                    <input type="time" disabled class="editTimeOut form-control" name="edit_time_out" value="<?php echo $employee->time_out; ?>"><br>

                                                    <textarea class="form-control" name="edit_remarks" id="" cols="30" rows="4" placeholder="REMARKS EDIT"></textarea>
                                                </div>

                                                <div class="delete">
                                                
                                                    <input type="checkbox" class="deleteCheckIn" name="delete_no_time_in" value="1">&nbsp;<label for="">TIME IN</label>
                                                    <input  type="time" class="deleteTimeIn form-control"  name="delete_time_in" value="<?php echo $employee->time_in; ?>"><br>

                                                    <input type="checkbox" class="deleteCheckOut" name="delete_no_time_out" value="1">&nbsp;<label for="">TIME OUT</label>
                                                    <input type="time" class="deleteTimeOut form-control" name="delete_time_out" value="<?php echo $employee->time_out; ?>"><br>

                                                    <textarea class="form-control" name="delete_remarks" id="" cols="30" rows="4" placeholder="REMARKS DELETE"></textarea>
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

            //FOR ADD
            $('.check').prop('checked', true);
            $('.timeOut').prop('disabled', true);
            $(".check").click(function(){
                if($(this).prop('checked') == false) {
                    $('.timeOut').attr('disabled', false);
                } else if($(this).prop('checked') == true) {
                    $('.timeOut').attr('disabled', true);
                } 
            });  

            $(".edit").hide();
            $(".delete").hide();
            $('.attendance').on('change', function() {
                var value = $(this).val();
                if(value == 2) {

                    $(".add").hide();
                    $(".edit").show();
                    $(".delete").hide();

                    //FOR EDIT TIME IN
                    $('.editCheckIn').prop('checked', false);
                    $('.editTimeIn').prop('disabled', true);
                    $(".editCheckIn").click(function(){
                        if($(this).prop('checked') == false) {
                            $('.editTimeIn').attr('disabled', true);
                        } else if($(this).prop('checked') == true) {
                            $('.editTimeIn').attr('disabled', false);
                        } 
                    }); 

                    //FOR EDIT TIME OUT
                    $('.editCheckOut').prop('checked', false);
                    $('.editTimeOut').prop('disabled', true);
                    $(".editCheckOut").click(function(){
                        if($(this).prop('checked') == false) {
                            $('.editTimeOut').attr('disabled', true);
                        } else if($(this).prop('checked') == true) {
                            $('.editTimeOut').attr('disabled', false);
                        } 
                    }); 
                } else if(value == 1) {

                    $(".add").show();
                    $(".edit").hide();
                    $(".delete").hide();

                    //FOR ADD
                    $('.check').prop('checked', true);
                    $('.timeOut').prop('disabled', true);
                    $(".check").click(function(){
                        if($(this).prop('checked') == false) {
                            $('.timeOut').attr('disabled', false);
                        } else if($(this).prop('checked') == true) {
                            $('.timeOut').attr('disabled', true);
                        } 
                    });  
                } else if(value == 3) {

                    $(".add").hide();
                    $(".edit").hide();
                    $(".delete").show();

                    //FOR DELETE TIME IN
                    $('.deleteCheckIn').prop('checked', false);
                    $('.deleteTimeIn').prop('disabled', true);
                    $(".deleteCheckIn").click(function(){
                        if($(this).prop('checked') == false) {
                            $('.deleteTimeIn').attr('disabled', true);
                        } else if($(this).prop('checked') == true) {
                            $('.deleteTimeIn').attr('disabled', false);
                        } 
                    }); 

                    //FOR DELETE TIME OUT
                    $('.deleteCheckOut').prop('checked', false);
                    $('.deleteTimeOut').prop('disabled', true);
                    $(".deleteCheckOut").click(function(){
                        if($(this).prop('checked') == false) {
                            $('.deleteTimeOut').attr('disabled', true);
                        } else if($(this).prop('checked') == true) {
                            $('.deleteTimeOut').attr('disabled', false);
                        } 
                    }); 
                }
            });    
        } );
    </script> 
   