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
                <table id="" class="display" style="width:100%">
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <!--<th scope="col">SHCEDULE (IN|OUT|GP)</th>-->
                            <th scope="col">DATE</th>
                            <th scope="col">TIME IN</th>
                            <th scope="col">TIME OUT</th>
                            <th scope="col">TARDINESS</th>
                            <th scope="col">UNDERTIME</th>
                            <th scope="col">EXCESS AM</th>
                            <th scope="col">EXCESS PM</th>
                            <th scope="col">EXCESS WEEKEND</th>
                            <th scope="col">ND</th>
                            <th scope="col">PROCESS</th>
                            <th scope="col">REMARKS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employees) : ?>
                            <?php $total_tardiness = 0; $total_undertime = 0; $total_nd = 0; ?>
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
                                                $explod_time_in = explode(":","00:00");
                                                $explod_time_out = explode(":","00:00");
                                            }
                                            $explode_time_in_hours = $explod_time_in[0];
                                            $explode_time_in_mins = $explod_time_in[1];

                                            $explode_time_out_hours = $explod_time_out[0];
                                            $explode_time_out_mins = $explod_time_out[1];
                                            //echo $explode_time_in_hours . 'HOURS |' . $explode_time_in_mins . 'MINS';
                                            //echo $explode_time_out_hours . 'HOURS |' . $explode_time_out_mins . 'MINS';

                                             //COMPUTATION OF ACTUAL TIME IN AND TIME OUT TO MINUTES
                                             $time_in_mins = $explode_time_in_hours * 60;
                                             $total_time_in_mins = $time_in_mins + $explode_time_in_mins;
 
                                             $time_out_mins = $explode_time_out_hours * 60;
                                             $total_time_out_mins = $time_out_mins + $explode_time_out_mins;
                                             //echo $total_time_in_mins . '|' . $total_time_out_mins;


                                            if($employee->emp_sched_date == $employee->temp_date)
                                            {
                                                //EXPLODE SCHEDULE TIME IN AND TIME OUT
                                                $explod_sched_time_in = explode(":",$employee->emp_sched_time_in);
                                                $explod_sched_time_out = explode(":",$employee->emp_sched_time_out);

                                                $explode_sched_time_in_hours = $explod_sched_time_in[0];
                                                $explode_sched_time_in_mins = $explod_sched_time_in[1];

                                                $explode_sched_time_out_hours = $explod_sched_time_out[0];
                                                $explode_sched_time_out_mins = $explod_sched_time_out[1];
                                                //echo $explode_sched_time_in_hours . 'HOURS |' . $explode_sched_time_in_mins . 'MINS';
                                                //echo $explode_sched_time_out_hours . 'HOURS |' . $explode_sched_time_out_mins . 'MINS';

                                                //COMPUTATION OF SCHEDULE TIME IN PLUS GRACE PERIOD AND TIME OUT TO MINUTES
                                                $sched_time_in_mins = $explode_sched_time_in_hours * 60;
                                                $total_sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins + $employee->emp_sched_grace_period;
                                                $sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins;

                                                $sched_time_out_mins = $explode_sched_time_out_hours * 60;
                                                $total_sched_time_out_mins = $sched_time_out_mins + $explode_sched_time_out_mins;
                                                //echo $total_sched_time_in_mins . '|' . $total_sched_time_out_mins;
                                            }
                                            else
                                            {
                                                //EXPLODE SCHEDULE TIME IN AND TIME OUT
                                                $explod_sched_time_in = explode(":",$employee->sched_time_in);
                                                $explod_sched_time_out = explode(":",$employee->sched_time_out);

                                                $explode_sched_time_in_hours = $explod_sched_time_in[0];
                                                $explode_sched_time_in_mins = $explod_sched_time_in[1];

                                                $explode_sched_time_out_hours = $explod_sched_time_out[0];
                                                $explode_sched_time_out_mins = $explod_sched_time_out[1];
                                                //echo $explode_sched_time_in_hours . 'HOURS |' . $explode_sched_time_in_mins . 'MINS';
                                                //echo $explode_sched_time_out_hours . 'HOURS |' . $explode_sched_time_out_mins . 'MINS';

                                                //COMPUTATION OF SCHEDULE TIME IN PLUS GRACE PERIOD AND TIME OUT TO MINUTES
                                                $sched_time_in_mins = $explode_sched_time_in_hours * 60;
                                                $total_sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins + $employee->grace_period;
                                                $sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins;

                                                $sched_time_out_mins = $explode_sched_time_out_hours * 60;
                                                $total_sched_time_out_mins = $sched_time_out_mins + $explode_sched_time_out_mins;
                                                //echo $total_sched_time_in_mins . '|' . $total_sched_time_out_mins;
                                            }


                                            // UNDERTIME MORNING MINUTES
                                            /*if($sched_time_in_mins == 420 && $total_sched_time_out_mins == 1020)
                                            {
                                                $undertime_am_mins = 540;
                                                $undertime_pm_mins = 900;
                                            }
                                            elseif($sched_time_in_mins == 480 && $total_sched_time_out_mins == 1080)
                                            {
                                                $undertime_am_mins = 600;
                                                $undertime_pm_mins = 960;
                                            }
                                            else
                                            {
                                                $undertime_am_mins = 0;
                                                $undertime_pm_mins = 0;
                                            }*/
                                            
                                            
                                            $undertime_am_mins = $sched_time_in_mins + 120;
                                            $undertime_pm_mins = $total_sched_time_out_mins - 120;
                                            
                                            if($sched_time_in_mins == 360 && $total_sched_time_out_mins == 960)
                                            {
                                                $halfday_mins = $sched_time_in_mins + 240;
                                                $halfday_in_mins = $sched_time_in_mins + 300;
                                            }
                                            else
                                            {
                                                //HALFDAY MINUTES
                                                $halfday_mins = 720;
                                                $halfday_in_mins = 780;
                                            }                                         
                                        
                                        ?>
                                        <!-- DAYS -->
                                        <td title="
                                            <?php 
                                                if($employee->date_in != NULL || $employee->date_out != NULL)
                                                {
                                                    if($employee->emp_sched_date == $employee->temp_date)
                                                    {
                                                        echo $employee->emp_sched_time_in . ' AM | ' . $employee->emp_sched_time_out . ' PM | ' . $employee->emp_sched_grace_period . ' MINS'; 
                                                    }
                                                    else
                                                    {
                                                        echo $employee->sched_time_in . ' AM | ' . $employee->sched_time_out . ' PM | ' . $employee->grace_period . ' MINS'; 
                                                    }
                                                }
                                            ?>
                                        ">
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
                                                        } elseif($employee->type_name == "SL W/O PAY") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#e3342f;color:white;"></p>';
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                        }
                                                    }
                                                    elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:17px;background-color:#9f5f80;color:white;"></p>';
                                                    }
                                                    elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">NO IN</p>'; 
                                                    }
                                                }
                                                else { 
                                                    if($halfday_mins <= $total_time_in_mins)
                                                    {
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                        {
                                                            echo $employee->time_in; 
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo $employee->time_in; 
                                                        }
                                                        elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut)
                                                        {
                                                            echo $employee->time_in; 
                                                        }
                                                        else
                                                        {
                                                            if($days_temp_date == '6' || $days_temp_date == '0' && $employee->employee_number != '03151077') 
                                                            {
                                                                echo $employee->time_in; 
                                                            }
                                                            else
                                                            {
                                                                echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">' . $employee->time_in . '</p>'; 
                                                            }    
                                                        }
                                                    }
                                                   
                                                    else
                                                    {
                                                        echo $employee->time_in; 
                                                    }
                                                   
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
                                                        }  elseif($employee->type_name == "SL W/O PAY") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#e3342f;color:white;"></p>';
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                        }
                                                    }
                                                    elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:17px;background-color:#9f5f80;color:white;"></p>';
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
                                                    
                                                    if($undertime_pm_mins > $total_time_out_mins)
                                                    {
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                        {
                                                            echo $employee->time_out; 
                                                        }
                                                        elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                        {
                                                            echo $employee->time_out; 
                                                        }
                                                        elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut)
                                                        {
                                                            echo $employee->time_out; 
                                                        }
                                                        else
                                                        {
                                                            if($days_temp_date == '6' || $days_temp_date == '0' && $employee->employee_number != '03151077') 
                                                            {
                                                                echo $employee->time_out; 
                                                            }
                                                            else
                                                            {
                                                                echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">' . $employee->time_out .'</p>'; 
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo $employee->time_out;   
                                                    }
                                                   
                                                } 
                                            ?>
                                        </td>
                                        <!-- TARDINESS-->
                                        <td>
                                            <?php 
                                                if($total_sched_time_in_mins <= $total_time_in_mins)
                                                {
                                                    $w_date = date('w', strtotime($employee->temp_date));
                                                    if($w_date == 6  || $w_date == 0)
                                                    {
                                                        if($employee->employee_number == '03151077')
                                                        {
                                                            $tardiness_mins = $total_time_in_mins - $total_sched_time_in_mins;
                                                            $hours = intval($tardiness_mins/60);
                                                            $min_diff = intval($tardiness_mins%60);
                                                            $minutes = sprintf("%02d", $min_diff);
                                                            echo $hours.".".$minutes."";
                                                            $late_mins = $tardiness_mins;
                                                        }
                                                        else
                                                        {
                                                            echo '0';
                                                            $late_mins = 0;
                                                        }
                                                      
                                                    }
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                    {
                                                        echo '0';
                                                        $late_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDAM')
                                                    {
                                                        if($halfday_mins <= $total_time_in_mins)
                                                        {
                                                            if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDPM')
                                                            {
                                                                echo '0';
                                                                $late_mins = 0;
                                                            }
                                                            elseif($halfday_in_mins <= $total_time_in_mins)
                                                            {
                                                                $tardiness_mins = $total_time_in_mins - $halfday_in_mins;
                                                                $hours = intval($tardiness_mins/60);
                                                                $min_diff = intval($tardiness_mins%60);
                                                                $minutes = sprintf("%02d", $min_diff);
                                                                echo $hours.".".$minutes."";
                                                                $late_mins = $tardiness_mins;
                                                            }
                                                            else
                                                            {
                                                                echo '0';
                                                                $late_mins = 0;
                                                            }
                                                        
                                                        }  
                                                        else
                                                        {
                                                            echo '0';
                                                            $late_mins = 0;
                                                        }  
                                                    }
                                                    elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                    {
                                                        echo '0';
                                                        $late_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                    {
                                                        echo '0';
                                                        $late_mins = 0;
                                                    }  
                                                    elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut)
                                                    {
                                                        echo '0';
                                                        $late_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                    {
                                                        echo '0';
                                                        $late_mins = 0;
                                                    }
                                                    elseif($halfday_mins <= $total_time_in_mins)
                                                    {
                                                        if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDPM')
                                                        {
                                                            echo '0';
                                                            $late_mins = 0;
                                                        }
                                                        elseif($halfday_in_mins <= $total_time_in_mins)
                                                        {
                                                            $tardiness_mins = $total_time_in_mins - $halfday_in_mins;
                                                            $hours = intval($tardiness_mins/60);
                                                            $min_diff = intval($tardiness_mins%60);
                                                            $minutes = sprintf("%02d", $min_diff);
                                                            echo $hours.".".$minutes."";
                                                            $late_mins = $tardiness_mins;
                                                        }
                                                        else
                                                        {
                                                            echo '0';
                                                            $late_mins = 0;
                                                        }
                                                     
                                                    }    
                                                    elseif($undertime_am_mins <= $total_time_in_mins)
                                                    {
                                                        $tardiness_mins = $total_time_in_mins - $undertime_am_mins;
                                                        $hours = intval($tardiness_mins/60);
                                                        $min_diff = intval($tardiness_mins%60);
                                                        $minutes = sprintf("%02d", $min_diff);
                                                        echo $hours.".".$minutes."";
                                                        $late_mins = $tardiness_mins;
                                                    }  
                                                    else
                                                    {
                                                        $tardiness_mins = $total_time_in_mins - $total_sched_time_in_mins;
                                                        $hours = intval($tardiness_mins/60);
                                                        $min_diff = intval($tardiness_mins%60);
                                                        $minutes = sprintf("%02d", $min_diff);
                                                        echo $hours.".".$minutes."";
                                                        $late_mins = $tardiness_mins;
                                                    }
                                                  
                                                }
                                                else
                                                {
                                                    echo ' ';
                                                    $late_mins = 0;
                                                }   
                                                $total_tardiness += $late_mins;
                                            ?>
                                        </td>
                                        <!-- UNDERTIME -->
                                        <td>
                                            <?php 
                                                $w_date = date('w', strtotime($employee->temp_date));
                                                if($w_date == 6  || $w_date == 0)
                                                {
                                                    if($employee->employee_number == '03151077')
                                                    {
                                                        if($undertime_pm_mins <= $total_time_out_mins && $total_sched_time_out_mins >= $total_time_out_mins)
                                                        {
                                                            //COMPUTATION UNDERTIME
                                                            $undertime_mins = $total_sched_time_out_mins - $total_time_out_mins;
                                                            $undertime_hours = intval($undertime_mins/60);
                                                            $undertime_min_diff = intval($undertime_mins%60);
                                                            $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                            echo $undertime_hours.".".$undertime_minutes.""; 
                                                            $ut_mins = $undertime_mins;
                                                        }
                                                        else
                                                        {
                                                            echo '0';
                                                            $ut_mins = 0;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                
                                                }
                                                elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut)
                                                {
                                                    $ut_num = $employee->ut_num;
                                                    $undertime_hours = intval($ut_num/60);
                                                    $undertime_min_diff = intval($ut_num%60);
                                                    $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                    echo $undertime_hours.".".$undertime_minutes."";
                                                    $ut_mins = $undertime_mins;
                                                }
                                                elseif($undertime_am_mins <= $total_time_in_mins)
                                                {
                                                    if($halfday_mins <= $total_time_in_mins)
                                                    {
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDAM')
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    else
                                                    {
                                                        $undertime_mins = $undertime_am_mins - $total_sched_time_in_mins + 5;
                                                        $undertime_hours = intval($undertime_mins/60);
                                                        $undertime_min_diff = intval($undertime_mins%60);
                                                        $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                        echo $undertime_hours.".".$undertime_minutes."";
                                                        $ut_mins = $undertime_mins;
                                                    }
                                                 
                                                }
                                                elseif($undertime_pm_mins <= $total_time_out_mins && $total_sched_time_out_mins >= $total_time_out_mins)
                                                {
                                                    if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'WD')
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave && $employee->leave_day == 'HDAM')
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                    {
                                                        echo '0';
                                                        $ut_mins = 0;
                                                    }
                                                    else
                                                    {
                                                        //COMPUTATION UNDERTIME
                                                        $undertime_mins = $total_sched_time_out_mins - $total_time_out_mins;
                                                        $undertime_hours = intval($undertime_mins/60);
                                                        $undertime_min_diff = intval($undertime_mins%60);
                                                        $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                        echo $undertime_hours.".".$undertime_minutes."";  
                                                        $ut_mins = $undertime_mins;
                                                    }
                                                 
                                                }
                                                else
                                                {
                                                    $ut_mins = 0;
                                                }

                                                $total_undertime += $ut_mins;
                                            ?>

                                        </td>
                                        <!-- EXCESS AM -->
                                        <td>
                                            <?php
                                                if($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                {
                                                    
                                                }
                                                else
                                                {
                                                    if($sched_time_in_mins > $total_time_in_mins && $employee->date_in != NULL)
                                                    {
                                                        $week_day = date('w', strtotime($employee->temp_date));
                                                        if($week_day != 6 && $week_day != 0)
                                                        {
                                                            $total_ot_am =  $sched_time_in_mins - $total_time_in_mins; 
                                                            if($total_ot_am >= 60)
                                                            {
                                                                $hours = intval($total_ot_am/60);
                                                                $min_diff = intval($total_ot_am%60);
                                                                $minutes = sprintf("%02d", $min_diff);
                                                                echo $hours.".".$minutes."";
                                                            }
                                                        
                                                        }
                                                       
                                                    }
                                                }
                                             
                                            
                                            
                                            ?>
                                        </td>
                                        <!-- EXCESS PM -->
                                        <td>
                                            <?php 
                                                if($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                {
                                                    
                                                }
                                                else
                                                {
                                                    if($total_time_out_mins > $sched_time_out_mins && $employee->date_out != NULL)
                                                    {
                                                        $week_day = date('w', strtotime($employee->temp_date));
                                                        if($week_day != 6 && $week_day != 0)
                                                        {
                                                            $total_ot_pm = $total_time_out_mins - $sched_time_out_mins;
                                                            if($total_ot_pm >= 60)
                                                            {
                                                                $hours = intval($total_ot_pm/60);
                                                                $min_diff = intval($total_ot_pm%60);
                                                                $minutes = sprintf("%02d", $min_diff);
                                                                echo $hours.".".$minutes."";
                                                            }    
                                                        }    
                                                    }
                                                }    
                                            ?>
                                          
                                        </td>
                                        <!-- OT WD -->
                                        <td>
                                            <?php 
                                                $week_day = date('w', strtotime($employee->temp_date));
                                                if($week_day == 6 || $week_day == 0 || $employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                {
                                                    if($employee->employee_number != '03151077')
                                                    {
                                                        $total_ot_wd = $total_time_out_mins - $total_time_in_mins;
                                                        if($total_ot_wd >= 60)
                                                        {
                                                            if($total_ot_wd <= 480)
                                                            {
                                                                if($total_time_out_mins >= 780)
                                                                {
                                                                    $less_breaktime = $total_ot_wd;
                                                                    $hours = intval($less_breaktime/60);
                                                                    $min_diff = intval($less_breaktime%60);
                                                                    $minutes = sprintf("%02d", $min_diff);
                                                                    echo $hours.".".$minutes." | 0";
                                                                }
                                                                else
                                                                {
                                                                    //$compute_ot = $total_ot_wd - 480;
                                                                    $hours = intval($total_ot_wd/60);
                                                                    $min_diff = intval($total_ot_wd%60);
                                                                    $minutes = sprintf("%02d", $min_diff);
                                                                    echo $hours.".".$minutes." | 0";
                                                                }
                                                               
                                                            }
                                                            elseif($total_ot_wd >= 480)
                                                            {
                                                                if($total_time_out_mins >= 780)
                                                                {
                                                                    if($total_ot_wd >= 480)
                                                                    {
                                                                        $less_breaktime = $total_ot_wd;
                                                                        //echo $less_breaktime;
                                                                    }
                                                                    else
                                                                    {
                                                                        $less_breaktime = $total_ot_wd;
                                                                    }

                                                                    if($less_breaktime >= 480)
                                                                    {
                                                                        $excess_hours = 480;
                                                                        $compute_ot = $total_ot_wd - 480 - 60;
                                                                        $hours = intval($compute_ot/60);
                                                                        $min_diff = intval($compute_ot%60);
                                                                        $minutes = sprintf("%02d", $min_diff);
                                                                        echo "8.00 | " . $hours.".".$minutes."";
                                                                    }
                                                                    else
                                                                    {
                                                                        $hours = intval($less_breaktime/60);
                                                                        $min_diff = intval($less_breaktime%60);
                                                                        $minutes = sprintf("%02d", $min_diff);
                                                                        echo $hours.".".$minutes."";
                                                                    }
                                                                    
                                                                  
                                                                  
                                                                    /*$excess_hours = 480;
                                                                    $compute_ot = $total_ot_wd - 480 - 60;
                                                                    $hours = intval($compute_ot/60);
                                                                    $min_diff = intval($compute_ot%60);
                                                                    $minutes = sprintf("%02d", $min_diff);
                                                                    echo "8.00 | " . $hours.".".$minutes."";*/
                                                                }  
                                                                else
                                                                {
                                                                   echo 0;
                                                                }  
                                                            }

                                                         
                                                        }    
                                                    }
                                                }
                                               
                                            ?>
                                        </td>
                                        <!-- NIGHT DIFF -->
                                        <td>
                                            <?php
                                                $start_nd = 1320;
                                                $end_nd = 360;

                                                if($end_nd > $total_time_in_mins && $employee->date_in != NULL && $start_nd < $total_time_out_mins && $employee->date_out != NULL)
                                                {
                                                    $total_nd_am = $end_nd - $total_time_in_mins;
                                                    $total_nd_pm = $total_time_out_mins - $start_nd;
                                                    $total_nd = $total_nd_am + $total_nd_pm;

                                                    $hours = intval($total_nd/60);
                                                    $min_diff = intval($total_nd%60);

                                                    if($total_nd >= 30)
                                                    {
                                                        if($min_diff >= 30) {
                                                            echo $hours . '.' . 5;
                                                            $hr_diff = $hours * 60;
                                                            $nd = $hr_diff + 30;
                                                            $nd_compute =  $nd;
                                                        } 
                                                        elseif($min_diff <= 30) {
                                                            echo $hours . '.' . 00;
                                                            $hr_diff = $hours * 60;
                                                            $nd = $hr_diff + 00;
                                                            $nd_compute =  $nd;
                                                        }
                                                        else
                                                        {
                                                            $nd_compute = 0;
                                                            //echo 0;
                                                        }
                                                        
                                                    }
                                                    else
                                                    {
                                                        $nd_compute = 0;
                                                        //echo 0;
                                                    }
                                                   
                                                }
                                                else
                                                {
                                                    if($end_nd > $total_time_in_mins && $employee->date_in != NULL && $end_nd > $total_time_out_mins && $employee->date_out != NULL)
                                                    {
                                                        $total_nd_am = $total_time_out_mins - $total_time_in_mins;

                                                        $hours = intval($total_nd_am/60);
                                                        $min_diff = intval($total_nd_am%60);
                                                        
                                                        //echo $total_nd_am;
                                                        if($total_nd_am >= 30)
                                                        {
                                                            if($min_diff >= 30) {
                                                                echo $hours . '.' . 5;
                                                                $hr_diff = $hours * 60;
                                                                $nd = $hr_diff + 30;
                                                                $nd_compute =  $nd;
                                                            } elseif($min_diff <= 30) {
                                                                echo $hours . '.' . 00;
                                                                $hr_diff = $hours * 60;
                                                                $nd = $hr_diff + 00;
                                                                $nd_compute =  $nd;
                                                            }
                                                            else
                                                            {
                                                                $nd_compute = 0;
                                                                //echo 0;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $nd_compute = 0;
                                                            //echo 0;
                                                        }
                                                       
                                                    }
                                                    elseif($end_nd > $total_time_in_mins && $employee->date_in != NULL && $end_nd < $total_time_out_mins && $employee->date_out != NULL)
                                                    {
                                                       
                                                        $total_nd_am = $end_nd - $total_time_in_mins;

                                                        $hours = intval($total_nd_am/60);
                                                        $min_diff = intval($total_nd_am%60);
                                                        
                                                        //echo $total_nd_am;
                                                        if($total_nd_am >= 30)
                                                        {
                                                            if($min_diff >= 30) {
                                                                echo $hours . '.' . 5;
                                                                $hr_diff = $hours * 60;
                                                                $nd = $hr_diff + 30;
                                                                $nd_compute =  $nd;
                                                            } 
                                                            elseif($min_diff <= 30) {
                                                                echo $hours . '.' . 00;
                                                                $hr_diff = $hours * 60;
                                                                $nd = $hr_diff + 00;
                                                                $nd_compute =  $nd;
                                                            }
                                                            else
                                                            {
                                                                $nd_compute = 0;
                                                                //echo 0;
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $nd_compute = 0;
                                                            //echo 0;
                                                        }
                                                       
                                                    }
                                                    elseif($start_nd < $total_time_out_mins && $employee->date_out != NULL)
                                                    {
                                                        $total_nd_pm = $total_time_out_mins - $start_nd;

                                                        $hours = intval($total_nd_pm/60);
                                                        $min_diff = intval($total_nd_pm%60);

                                                        if($total_nd_pm >= 30)
                                                        {
                                                            if($min_diff >= 30) {
                                                                echo $hours . '.' . 5;
                                                                $hr_diff = $hours * 60;
                                                                $nd = $hr_diff + 30;
                                                                $nd_compute =  $nd;
                                                            } 
                                                            elseif($min_diff <= 30) {
                                                                echo $hours . '.' . 00;
                                                                $hr_diff = $hours * 60;
                                                                $nd = $hr_diff + 00;
                                                                $nd_compute =  $nd;
                                                            }
                                                            else
                                                            {
                                                                $nd_compute = 0;
                                                                //echo 0;
                                                            }   
                                                          
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $nd_compute = 0;
                                                        //echo 0;
                                                    }
                                                }

                                                $total_nd += $nd_compute;
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
                                                        } elseif($employee->type_name == "SL W/O PAY") {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:#e3342f;color:white;"></p>';
                                                        } else {
                                                            echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                        }
                                                    }
                                                    elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:17px;background-color:#9f5f80;color:white;"></p>';
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
                                                } elseif($employee->in_generate == NULL && $employee->out_generate == "SYSTEM") { 
                                                    echo  '(OUT-' . ' ' . $employee->out_generate . ')' ; 
                                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'SYSTEM') {
                                                    echo 'SYSTEM';
                                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == NULL) { 
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' . '(IN-' . ' ' . $employee->in_generate . ')' . '</p>'; 
                                                } elseif($employee->in_generate == NULL && $employee->out_generate == "MANUAL") { 
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' .  '(OUT-' . ' ' . $employee->out_generate . ')'; 
                                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'MANUAL') {
                                                    echo  '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' .  'MANUAL';  
                                                } elseif($employee->in_generate == "MANUAL" && $employee->out_generate == 'SYSTEM') {
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' . '(IN-' . ' ' . $employee->in_generate . ')' . '</p>' . ' | ' . '(OUT-' . ' ' . $employee->out_generate . ')';  
                                                } elseif($employee->in_generate == "SYSTEM" && $employee->out_generate == 'MANUAL') {
                                                    echo  '(IN-' . ' ' . $employee->in_generate . ')' . ' | ' . '<p class="" style="text-align:center;padding:5px;background-color:#ffed4a;">' . '(OUT-' . ' ' . $employee->out_generate . ')' . '</p>';  
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
                                                    } elseif($employee->type_name == "SPL") {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:rgb(255,100,0);color:white;">'. $employee->type_name . ' ' . $employee->leave_day . '' .'</p>';
                                                    }
                                                ?>   
                                            <?php elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut): ?>   
                                                <?php
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#067593;color:white;">'. 'UNDERTIME' .'</p>';
                                                ?>
                                            <?php elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date): ?>   
                                                <?php
                                                    echo '<p class="" style="text-align:center;padding:5px;background-color:#9f5f80;color:white;">'. $employee->holiday_type .'</p>';
                                                ?>
                                            <?php endif; ?>    
                                        </td>
                                        <!-- ACTION -->
                                        <td data-label="Action">
                                            <?php if($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob) : ?>
                                                <?php echo strtoupper($employee->ob_process_by); ?>
                                            <?php elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave): ?>
                                                <?php echo strtoupper($employee->leave_process_by); ?>   
                                            <?php elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut): ?>   
                                                <?php echo strtoupper($employee->ut_process_by); ?>  
                                            <?php elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date): ?>         
                                                <?php echo strtoupper($employee->holiday_created_by); ?>  
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
        <!-- LEAVE LIST -->
        <div class="card">
            <div class="card-header" style="background-color: #38c172; color:white;">
                <h5> LEAVE OF ABSENCE <a href="<?php echo base_url(); ?>reports/index_slvl" target="_blank" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">VIEW </a> </h5>
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">DAY</th>
                            <th scope="col">TYPE</th>
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
                                    <td><?php echo substr($employee_leave->reason,0,50); ?></td>
                                    <td><?php if($employee_leave->status == 0) {  echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">FOR APPROVAL</p>';  } else {  echo '<p class="" style="text-align:center;padding:5px;background-color:#38c172;color:white;">APPROVED</p>'; } ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>

        <br>
        <!-- FIELD WORK / WORK FROM HOME LIST -->
        <div class="card">
            <div class="card-header" style="background-color:rgb(127,127,127); color:white;"> 
                <h5>  FIELD WORK / WORK FROM HOME <a target="_blank" href="<?php echo base_url(); ?>reports/index_ob" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">VIEW </a> </h5>
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
                                    <td><?php if($employee_ob->status == 0) {  echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">FOR APPROVAL</p>';  } else {  echo '<p class="" style="text-align:center;padding:5px;background-color:#38c172;color:white;">APPROVED</p>'; } ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>

        <br>
        <!-- UNDERTIME LIST -->
        <div class="card">
            <div class="card-header" style="background-color:#067593; color:white;">
                <h5>UNDERTIME <a target="_blank" href="<?php echo base_url(); ?>reports/index_ut" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">VIEW </a> </h5>
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME START</th>
                            <th scope="col">TIME END</th>
                            <th scope="col">UT HOURS</th>
                            <th scope="col">REASON</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employee_ut) :?>
                            <?php foreach($employee_ut as $ut) : ?>
                                <tr>
                                    <td><?php echo date('D', strtotime($ut->date_ut)); ?></td>
                                    <td><?php echo $ut->date_ut; ?></td>
                                    <td><?php echo $ut->time_start; ?></td>
                                    <td><?php echo $ut->time_end; ?></td>
                                    <td>
                                        <?php 
                                            $ut_num = $ut->ut_num;
                                            $ut_hrs = intdiv($ut_num, 60).'.'. ($ut_num % 60);
                                            echo $ut_hrs;
                                        ?>
                                    </td>
                                    <td><?php echo substr($ut->reason,0,50); ?></td>
                                    <td><?php if($ut->status == 0) {  echo '<p class="" style="text-align:center;padding:5px;margin-top:15px;background-color:#e3342f;color:white;">FOR APPROVAL</p>';  } else {  echo '<p class="" style="text-align:center;padding:5px;margin-top:15px;background-color:#38c172;color:white;">APPROVED</p>'; } ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>

        <br>
        <!-- OVERTIME LIST -->
        <div class="card">
            <div class="card-header" style="background-color:#0C2D48; color:white;">
                <h5> OVERTIME<a target="_blank" href="<?php echo base_url(); ?>reports/index_ot" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">VIEW </a> </h5>
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                    <tr style="background-color:#D4F1F4;">
                        <th scope="col">DATE</th>
                        <th scope="col">ACTUAL IN</th>
                        <th scope="col">ACTUAL OUT</th>
                        <th scope="col">OT TIME START</th>
                        <th scope="col">OT TIME END</th>
                        <th scope="col">ROT AM</th>
                        <th scope="col">ROT PM</th>
                        <th scope="col">RD</th>
                        <th scope="col">RDOT</th>
                        <th scope="col">RH</th>
                        <th scope="col">RHOT</th>
                        <th scope="col">SH</th>
                        <th scope="col">SHOT</th>
                        <th scope="col">TASK</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if($employee_ot) : ?>
                            <?php foreach($employee_ot as $ot) : ?>
                                <?php
                                    if($ot->actual_time_in != NULL && $ot->actual_time_out != NULL)
                                    {
                                        $explod_time_in = explode(":",$ot->actual_time_in);
                                        $explod_time_out = explode(":",$ot->actual_time_out);
                                    }
                                    elseif($ot->actual_time_in != NULL && $ot->actual_time_out == NULL)
                                    {
                                        $explod_time_in = explode(":",$ot->actual_time_in);
                                        $explod_time_out = explode(":","00:00");
                                    }
                                    elseif($ot->actual_time_in == NULL && $ot->actual_time_out != NULL)
                                    {
                                        $explod_time_in =  explode(":","00:00");
                                        $explod_time_out = explode(":",$ot->actual_time_out);
                                    }
                                    else
                                    {
                                        $explod_time_in = explode(":","00:00");
                                        $explod_time_out = explode(":","00:00");
                                    }
                                    $explode_time_in_hours = $explod_time_in[0];
                                    $explode_time_in_mins = $explod_time_in[1];
            
                                    $explode_time_out_hours = $explod_time_out[0];
                                    $explode_time_out_mins = $explod_time_out[1];
                                    //echo $explode_time_in_hours . 'HOURS |' . $explode_time_in_mins . 'MINS';
                                    //echo $explode_time_out_hours . 'HOURS |' . $explode_time_out_mins . 'MINS';
            
                                    //COMPUTATION OF ACTUAL TIME IN AND TIME OUT TO MINUTES
                                    $time_in_mins = $explode_time_in_hours * 60;
                                    $total_time_in_mins = $time_in_mins + $explode_time_in_mins;
            
                                    $time_out_mins = $explode_time_out_hours * 60;
                                    $total_time_out_mins = $time_out_mins + $explode_time_out_mins;
                                    //echo 'ACTUAL :' . $total_time_in_mins . '|' . $total_time_out_mins . '__';

                                    if($ot->emp_sched_date == $ot->date_ot)
                                    {
                                        //EXPLODE SCHEDULE TIME IN AND TIME OUT
                                        $explod_sched_time_in = explode(":",$ot->emp_sched_time_in);
                                        $explod_sched_time_out = explode(":",$ot->emp_sched_time_out);

                                        $explode_sched_time_in_hours = $explod_sched_time_in[0];
                                        $explode_sched_time_in_mins = $explod_sched_time_in[1];

                                        $explode_sched_time_out_hours = $explod_sched_time_out[0];
                                        $explode_sched_time_out_mins = $explod_sched_time_out[1];
                                        //echo $explode_sched_time_in_hours . 'HOURS |' . $explode_sched_time_in_mins . 'MINS';
                                        //echo $explode_sched_time_out_hours . 'HOURS |' . $explode_sched_time_out_mins . 'MINS';

                                        //COMPUTATION OF SCHEDULE TIME IN PLUS GRACE PERIOD AND TIME OUT TO MINUTES
                                        $sched_time_in_mins = $explode_sched_time_in_hours * 60;
                                        $total_sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins + $ot->emp_sched_grace_period;

                                        $sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins;

                                        $sched_time_out_mins = $explode_sched_time_out_hours * 60;
                                        $total_sched_time_out_mins = $sched_time_out_mins + $explode_sched_time_out_mins;
                                        //echo $sched_time_in_mins . '|' . $total_sched_time_out_mins;
                                    }
                                    else
                                    {
                                        
                                        //EXPLODE SCHEDULE TIME IN AND TIME OUT
                                        $explod_sched_time_in = explode(":",$ot->sched_time_in);
                                        $explod_sched_time_out = explode(":",$ot->sched_time_out);

                                        $explode_sched_time_in_hours = $explod_sched_time_in[0];
                                        $explode_sched_time_in_mins = $explod_sched_time_in[1];

                                        $explode_sched_time_out_hours = $explod_sched_time_out[0];
                                        $explode_sched_time_out_mins = $explod_sched_time_out[1];
                                        //echo $explode_sched_time_in_hours . 'HOURS |' . $explode_sched_time_in_mins . 'MINS';
                                        //echo $explode_sched_time_out_hours . 'HOURS |' . $explode_sched_time_out_mins . 'MINS';

                                        //COMPUTATION OF SCHEDULE TIME IN PLUS GRACE PERIOD AND TIME OUT TO MINUTES
                                        $sched_time_in_mins = $explode_sched_time_in_hours * 60;
                                        $total_sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins + $ot->grace_period;

                                        $sched_time_in_mins = $sched_time_in_mins + $explode_sched_time_in_mins;

                                        $sched_time_out_mins = $explode_sched_time_out_hours * 60;
                                        $total_sched_time_out_mins = $sched_time_out_mins + $explode_sched_time_out_mins;
                                        //echo $sched_time_in_mins . '|' . $total_sched_time_out_mins;
                                    }

                                    if($ot->type == "ROT") 
                                    { 
                                        if($ot->am_time_in != NULL && $ot->am_time_out != NULL)
                                        {
                                            //echo $ot->time_in . '|' . $ot->time_out; 
                                            $ot_time_in = explode(":",$ot->am_time_in);
                                            $ot_time_out = explode(":",$ot->am_time_out); 
                                        }
                                        else
                                        {
                                            //echo $ot->time_in . '|' . $ot->time_out; 
                                            $ot_time_in = explode(":","00:00");
                                            $ot_time_out = explode(":","00:00"); 
                                        }
                                  

                                        $ot_time_in_hours = $ot_time_in[0];
                                        $ot_time_in_mins = $ot_time_in[1];
                
                                        $ot_time_out_hours = $ot_time_out[0];
                                        $ot_time_out_mins = $ot_time_out[1];
                
                                        //COMPUTATION OF ACTUAL TIME IN AND TIME OUT TO MINUTES
                                        $ot_time_in_hr_to_mins = $ot_time_in_hours * 60;
                                        $ot_total_am_time_in_mins = $ot_time_in_hr_to_mins + $ot_time_in_mins;
                
                                        $ot_time_out_hr_to_mins = $ot_time_out_hours * 60;
                                        $ot_total_am_time_out_mins = $ot_time_out_hr_to_mins + $ot_time_out_mins;
                                        //echo 'OT :' .$ot_total_am_time_in_mins . '|' . $ot_total_am_time_out_mins;
                                    
                                      
                                        //echo $total_time_in_mins . ' | ' . $ot_total_am_time_in_mins . ' ---- ' . $sched_time_in_mins .' | ' . $ot_total_am_time_out_mins;
                                        if($total_time_in_mins <= $ot_total_am_time_in_mins)
                                        {
                                            //echo 'sucess';
                                            $rot_am = 0;
                                        }
                                        else
                                        {
                                            //echo 'fail';
                                            $rot_am = 1;
                                        }
                                       
                                        if($ot->pm_time_in != NULL && $ot->pm_time_out != NULL)
                                        {
                                            //echo $ot->time_in . '|' . $ot->time_out; 
                                            $ot_pm_time_in = explode(":",$ot->pm_time_in);
                                            $ot_pm_time_out = explode(":",$ot->pm_time_out); 
                                        }
                                        else
                                        {
                                            //echo $ot->time_in . '|' . $ot->time_out; 
                                            $ot_pm_time_in = explode(":","00:00");
                                            $ot_pm_time_out = explode(":","00:00"); 
                                        }

                                        $ot_pm_time_in_hours = $ot_pm_time_in[0];
                                        $ot_pm_time_in_mins = $ot_pm_time_in[1];
                
                                        $ot_pm_time_out_hours = $ot_pm_time_out[0];
                                        $ot_pm_time_out_mins = $ot_pm_time_out[1];
                
                                        //COMPUTATION OF ACTUAL TIME IN AND TIME OUT TO MINUTES
                                        $ot_pm_time_in_hr_to_mins = $ot_pm_time_in_hours * 60;
                                        $ot_pm_total_am_time_in_mins = $ot_pm_time_in_hr_to_mins + $ot_pm_time_in_mins;
                
                                        $ot_pm_time_out_hr_to_mins = $ot_pm_time_out_hours * 60;
                                        $ot_pm_total_am_time_out_mins = $ot_pm_time_out_hr_to_mins + $ot_pm_time_out_mins;
                                        //echo 'OT :' .$ot_total_am_time_in_mins . '|' . $ot_total_am_time_out_mins;

                                        //echo $ot_pm_total_am_time_out_mins. ' <= ' . $total_time_out_mins . '----' . $total_sched_time_out_mins . ' <= ' . $ot_pm_total_am_time_in_mins;
                                        if($ot_pm_total_am_time_out_mins <= $total_time_out_mins && $total_sched_time_out_mins <= $ot_pm_total_am_time_in_mins)
                                        {
                                            //echo '--sucess';
                                            $rot_pm = 0;
                                        }
                                        else
                                        {
                                            //echo '--fail';
                                            $rot_pm = 1;
                                        }

                                        $restriction = 0;
                                    } 
                                 
                                    else 
                                    { 
                                        //echo $ot->time_start . '|' . $ot->time_end; 
                                        $ot_time_in = explode(":",$ot->time_start);
                                        $ot_time_out = explode(":",$ot->time_end);  

                                        $ot_time_in_hours = $ot_time_in[0];
                                        $ot_time_in_mins = $ot_time_in[1];
                
                                        $ot_time_out_hours = $ot_time_out[0];
                                        $ot_time_out_mins = $ot_time_out[1];
                
                                        //COMPUTATION OF ACTUAL TIME IN AND TIME OUT TO MINUTES
                                        $ot_time_in_hr_to_mins = $ot_time_in_hours * 60;
                                        $ot_total_time_in_mins = $ot_time_in_hr_to_mins + $ot_time_in_mins;
                
                                        $ot_time_out_hr_to_mins = $ot_time_out_hours * 60;
                                        $ot_total_time_out_mins = $ot_time_out_hr_to_mins + $ot_time_out_mins;
                                        //echo 'OT :' .$ot_total_time_in_mins . '|' . $ot_total_time_out_mins;

                                        if($total_time_in_mins <= $ot_total_time_in_mins && $total_time_out_mins <= $ot_total_time_out_mins)
                                        {
                                            //echo ' sucess';
                                            $restriction = 0;
                                        }
                                        else
                                        {
                                            //echo ' fail';
                                            $restriction = 1;
                                        }
                                    }
                                ?>
                                <tr>
                                    <td title="
                                        <?php 
                                            if($ot->emp_sched_date == $ot->date_ot)
                                            {
                                                echo $ot->emp_sched_time_in . ' AM | ' . $ot->emp_sched_time_out . ' PM | ' . $ot->emp_sched_grace_period . ' MINS'; 
                                            }
                                            else
                                            {
                                                echo $ot->sched_time_in . ' AM | ' . $ot->sched_time_out . ' PM | ' . $ot->grace_period . ' MINS'; 
                                            }
                                        
                                        ?>
                                    "><?php echo $ot->date_ot; ?></td>
                                    <td><?php echo $ot->actual_time_in; ?></td>
                                    <td><?php echo  $ot->actual_time_out; ?></td>
                                    <td>
                                        <?php 
                                            if($ot->type == "ROT") 
                                            { 
                                                if($ot->am_time_in != NULL)
                                                {
                                                    echo $ot->am_time_in;
                                                }
                                                else
                                                {
                                                    echo $ot->pm_time_in;
                                                }
                                            } 
                                            else 
                                            { 
                                                echo $ot->time_start; 
                                            } 
                                        
                                        ?>
                                    </td>
                                    <td>    
                                        <?php 
                                            if($ot->type == "ROT") 
                                            { 
                                                if($ot->pm_time_out != NULL)
                                                {
                                                    echo $ot->pm_time_out;
                                                }
                                                else
                                                {
                                                    echo $ot->am_time_out;
                                                }
                                               
                                               
                                            } 
                                            else 
                                            { 
                                                echo $ot->time_end; 
                                            } 
                                        ?>
                                    </td>
                                    <td <?php echo $rot_am == 1 && $ot->rotam != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->rotam; ?></td>
                                    <td <?php echo $rot_pm == 1 && $ot->rotpm != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->rotpm; ?></td>
                                    <td <?php echo $restriction == 1 && $ot->rd != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->rd; ?></td>
                                    <td <?php echo $restriction == 1 && $ot->rdot != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->rdot; ?></td>
                                    <td <?php echo $restriction == 1 && $ot->rh != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->rh; ?></td>
                                    <td <?php echo $restriction == 1 && $ot->rhot != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->rhot; ?></td>
                                    <td <?php echo $restriction == 1 && $ot->sh != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->sh; ?></td>
                                    <td <?php echo $restriction == 1 && $ot->shot != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>><?php echo $ot->shot; ?></td>
                                    <td><?php echo substr($ot->task,0,50); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>

        <br>
        <!-- TOTAL SUMMARY -->
        <div class="card">
            <div class="card-header" style="background-color: #3490dc; color:white;">
                <h5> TOTAL SUMMARY  </h5>
            </div>
            <div class="card-body">
                <table id="" class="display" style="width:100%">
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">TARDINESS</th>
                            <th scope="col">UNDERTIME</th>
                            <th scope="col">ABSENCES</th>
                            <th scope="col">SL</th>
                            <th scope="col">VL</th>
                            <th scope="col">ML</th>
                            <th scope="col">PL</th>
                            <th scope="col">BL</th>
                            <th scope="col">SPL</th>
                            <th scope="col">ROT</th>
                            <th scope="col">ND</th>
                            <th scope="col">RD</th>
                            <th scope="col">RDOT</th>
                            <th scope="col">RH</th>
                            <th scope="col">RHOT</th>
                            <th scope="col">SH</th>
                            <th scope="col">SHOT</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <!-- TARDINESS -->
                        <td>
                            <?php 
                                if($total_tardiness != 0)
                                {
                                    $hours = intval($total_tardiness/60);
                                    $min_diff = intval($total_tardiness%60);
                                    $minutes = sprintf("%02d", $min_diff);
                                    echo $hours.".".$minutes."";
                                }
                                else
                                {
                                    echo 0;
                                }
                               
                            ?>
                        </td>

                        <!-- UNDERTIME -->
                        <td>
                            <?php 
                                if($total_undertime != 0)
                                {
                                    $hours = intval($total_undertime/60);
                                    $min_diff = intval($total_undertime%60);
                                    $minutes = sprintf("%02d", $min_diff);
                                    echo $hours.".".$minutes."";
                                }
                                else
                                {
                                    echo 0;
                                }
                            
                            ?>
                        </td>

                        <!-- ABSENCES -->
                        <td>
                            <?php $total_ab = 0; ?>
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "AB" && $employee_leave->status == 1)
                                        {
                                            $total_ab += $employee_leave->leave_num;
                                        }  
                                      
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_ab; ?>
                        </td>

                        <!-- SICK LEAVE -->
                        <td>
                            <?php $total_sl = 0; ?>
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "SL" && $employee_leave->status == 1)
                                        {
                                            $total_sl += $employee_leave->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_sl; ?>
                        </td>

                        <!-- VACATION LEAVE -->
                        <td>
                            <?php $total_vl = 0; ?>
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "VL" && $employee_leave->status == 1)
                                        {
                                            $total_vl += $employee_leave->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_vl; ?>
                        </td>

                        <!-- MATERNITY LEAVE -->
                        <td>
                            <?php $total_ml = 0; ?>            
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "ML" && $employee_leave->status == 1)
                                        {
                                            $total_ml += $employee_leave->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_ml; ?>
                        </td>
                        
                        <!-- PATERNITY LEAVE -->
                        <td>
                            <?php $total_pl = 0; ?>
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "PL" && $employee_leave->status == 1)
                                        {
                                            $total_pl += $employee_leave->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_pl; ?>
                        </td>
                        
                        <!-- BEREAVEMENT LEAVE -->
                        <td>
                            <?php $total_bl = 0; ?>
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "BL" && $employee_leave->status == 1)
                                        {
                                            $total_bl += $employee_leave->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_bl; ?>
                        </td>
                        
                        <!-- SOLO PARENT LEAVE -->
                        <td>
                            <?php $total_spl = 0; ?>
                            <?php if($employee_leaves) : ?>
                                <?php foreach($employee_leaves as $employee_leave) : ?>
                                    <?php  
                                        if($employee_leave->type == "SPL" && $employee_leave->status == 1)
                                        {
                                            $total_spl += $employee_leave->leave_num;
                                        }    
                                    ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php echo $total_spl; ?>
                        </td>

                        <td>-</td>
                        <!-- NIGHT DIFF -->
                        <td>
                            <?php 
                                if($total_nd != 0)
                                {
                                    $hours = intval($total_nd/60);
                                    $min_diff = intval($total_nd%60);
                                    if($min_diff >= 30) {
                                        echo $hours . '.' . 5;
                                    } 
                                    elseif($min_diff <= 30) {
                                        echo $hours . '.0';
                                    }
                                }
                                else
                                {
                                    echo 0;
                                }
                               
                            ?>
                        </td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    </tbody>
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
                                                <input  type="time" class="deleteTimeIn form-control" readonly  name="delete_time_in" value="<?php echo $employee->time_in; ?>"><br>

                                                <input type="checkbox" class="deleteCheckOut" name="delete_no_time_out" value="1">&nbsp;<label for="">TIME OUT</label>
                                                <input type="time" class="deleteTimeOut form-control" readonly name="delete_time_out" value="<?php echo $employee->time_out; ?>"><br>

                                                <textarea class="form-control" name="delete_remarks" id="" cols="30" rows="4" placeholder="REMARKS DELETE"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" title="Close Manual Attendance Form" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <div class="add">
                                    <button type="submit" title="Submit Manual Attendance Form" onclick="return confirm('Do you want to submit data?');" class="btn btn-info">Submit</button>
                                </div>
                                <div class="edit">
                                    <button type="submit" title="Update Manual Attendance Form" onclick="return confirm('Do you want to update data?');" class="btn btn-info">Update</button>
                                </div>
                                <div class="delete">
                                    <button type="submit" title="Delete Manual Attendance Form" onclick="return confirm('Do you want to delete data?');" class="btn btn-danger">Delete</button>
                                </div>
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
            // DAILY ATTENDANCE
            $('table.display').DataTable( {
            "order": [[ 0, 'desc' ]],
            //"bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            //"scrollY" : '50vh',
            "scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'lrtip'
        } );

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
        });
    </script> 
   