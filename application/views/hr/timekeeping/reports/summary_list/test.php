    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">NAME</th>
                <th scope="col">DATE</th>
                <th scope="col">TIME IN</th>
                <th scope="col">TIME OUT</th>
                <th scope="col">TARDINESS</th>
                <th scope="col">UNDERTIME</th>
                <th scope="col">ND</th>
                <th scope="col">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <?php if($employees) : ?>
                <?php $total_tardiness = 0; $total_undertime = 0; $total_night_diff = 0; $test_tard = 0; ?>
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


                               // echo '<pre>' . $employee->employee_number . ' | ' .  $employee->temp_date . ' | ' . $employee->sched_time_in . ' | ' . $employee->sched_time_out . '</pre>';
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
                                    $flexi_time = $employee->emp_flexi_time;

                                    // VALIDATION FOR NIGHT DIFF
                                    $change_sched = 1;
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
                                    $flexi_time = $employee->flexi_time;

                                    // VALIDATION FOR NIGHT DIFF
                                    $change_sched = 0;
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
                            <!-- FULLNAME -->
                            <td>
                                <?php echo $employee->fullname; ?>
                            </td>
                            <!-- DATE -->
                            <td title=" 
                                <?php 
                                    if($employee->date_in != NULL || $employee->date_out != NULL)
                                    {
                                        if($employee->emp_sched_date == $employee->temp_date)
                                        {
                                            echo $employee->emp_sched_time_in . ' AM | ' . $employee->emp_sched_time_out . ' PM | ' . $employee->emp_sched_grace_period . ' MINS ' . $employee->emp_flexi_time;; 
                                        }
                                        else
                                        {
                                            echo $employee->sched_time_in . ' AM | ' . $employee->sched_time_out . ' PM | ' . $employee->grace_period . ' MINS ' . $employee->flexi_time; 
                                        }
                                    }
                                ?>
                            ">
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
                                            } elseif($employee->type_name == "VACATION LEAVE") {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;white;"></p>';
                                            } elseif($employee->type_name == "VL W/O PAY") {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);white;"></p>';
                                            } elseif($employee->type_name == "SICK LEAVE") {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
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
                            <!-- TIME OUT -->
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
                                            } elseif($employee->type_name == "VACATION LEAVE") {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;white;"></p>';
                                            } elseif($employee->type_name == "VL W/O PAY") {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);white;"></p>';
                                            } elseif($employee->type_name == "SICK LEAVE") {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
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
                            <!-- TARDINESS -->
                            <td title=" 
                                <?php 
                                    if($employee->flexi_time != 1)
                                    {
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
                                                    echo $hours." HOUR/S AND ".$minutes." MINUTES";
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
                                                        echo $hours." HOUR/S AND ".$minutes." MINUTES";
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
                                                    echo $hours." HOUR/S AND ".$minutes." MINUTES";
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
                                                echo $hours." HOUR/S AND ".$minutes." MINUTES";
                                                $late_mins = $tardiness_mins;
                                            }  
                                            else
                                            {
                                                $tardiness_mins = $total_time_in_mins - $total_sched_time_in_mins;
                                                $hours = intval($tardiness_mins/60);
                                                $min_diff = intval($tardiness_mins%60);
                                                $minutes = sprintf("%02d", $min_diff);
                                                echo $hours." HOUR/S AND ".$minutes." MINUTES";
                                                $late_mins = $tardiness_mins;
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo ' ';
                                            $late_mins = 0;
                                        }   
                                    }
                                    else
                                    {
                                        $late_mins = 0;
                                        echo ' ';
                                    }
                                    
                                    //$total_tardiness += $late_mins;
                                ?>
                            ">
                                <?php 
                                    if($employee->flexi_time != 1)
                                    {
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
                                                    echo $hours."|".$minutes."";
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
                                                        echo $hours."|".$minutes."";
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
                                                    echo $hours."|".$minutes."";
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
                                                echo $hours."|".$minutes."";
                                                $late_mins = $tardiness_mins;
                                            }  
                                            else
                                            {
                                                $tardiness_mins = $total_time_in_mins - $total_sched_time_in_mins;
                                                $hours = intval($tardiness_mins/60);
                                                $min_diff = intval($tardiness_mins%60);
                                                $minutes = sprintf("%02d", $min_diff);
                                                echo $hours."|".$minutes."";
                                                $late_mins = $tardiness_mins;
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo ' ';
                                            $late_mins = 0;
                                        }   
                                    }
                                    else
                                    {
                                        $late_mins = 0;
                                        echo ' ';
                                    }
                                
                                    $total_tardiness += $late_mins;
                                   
                                ?>
                              
                            </td>
                            <!-- UNDERTIME -->
                            <td title="
                                <?php 
                                    if($flexi_time != 1)
                                    {
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
                                                    echo $undertime_hours." HOUR/S AND ".$undertime_minutes." MINUTES"; 
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
                                            echo $undertime_hours." HOUR/S AND ".$undertime_minutes." MINUTES"; 
                                            $ut_mins = $ut_num;
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
                                                echo $undertime_hours." HOUR/S AND ".$undertime_minutes." MINUTES"; 
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
                                                echo $undertime_hours." HOUR/S AND ".$undertime_minutes." MINUTES"; 
                                                $ut_mins = $undertime_mins;
                                            }
                                            
                                        }
                                        else
                                        {
                                            $ut_mins = 0;
                                        }
                                    }
                                    else
                                    {
                                        if($employee->time_in != NULL && $employee->time_out != NULL)
                                        {
                                            $total_daily_hrs = $total_time_out_mins - $total_time_in_mins;

                                            if($total_daily_hrs < 600)
                                            {
                                                $undertime_mins = 600 - $total_daily_hrs; 
                                                $undertime_hours = intval($undertime_mins/60);
                                                $undertime_min_diff = intval($undertime_mins%60);
                                                $undertime_minutes = sprintf("%02d", $undertime_min_diff);
                                                echo $undertime_hours." HOUR/S AND ".$undertime_minutes." MINUTES"; 
                                                $ut_mins = $undertime_mins;
                                                //echo $undertime_mins;
                                            } 
                                            else
                                            {
                                                $ut_mins = 0;
                                            }  
                                        
                                        }
                                        else
                                        {
                                            $ut_mins = 0;
                                        }
                                        
                                    }
                                    

                                    //$total_undertime += $ut_mins;
                                ?>
                            ">
                                <?php 
                                    if($flexi_time != 1)
                                    {
                                        $w_date = date('w', strtotime($employee->temp_date));
                                        if($w_date == 6  || $w_date == 0)
                                        {
                                            if($employee->employee_number == '03151077')
                                            {
                                                if($undertime_pm_mins <= $total_time_out_mins && $total_sched_time_out_mins >= $total_time_out_mins)
                                                {
                                                    //COMPUTATION UNDERTIME
                                                    $undertime_mins = $total_sched_time_out_mins - $total_time_out_mins;
                                                    $convert_undertime = $undertime_mins / 60;
                                                    $round_off_ut = round($convert_undertime, 2);
                                                    echo $round_off_ut;
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
                                            $convert_undertime = $ut_num / 60;
                                            $round_off_ut = round($convert_undertime, 2);
                                            echo $round_off_ut;
                                            $ut_mins = $ut_num;
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
                                                $convert_undertime = $undertime_mins / 60;
                                                $round_off_ut = round($convert_undertime, 2);
                                                echo $round_off_ut;
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
                                                $convert_undertime = $undertime_mins / 60;
                                                $round_off_ut = round($convert_undertime, 2);
                                                echo $round_off_ut;
                                                $ut_mins = $undertime_mins;
                                            }
                                            
                                        }
                                        else
                                        {
                                            $ut_mins = 0;
                                        }
                                    }
                                    else
                                    {
                                        if($employee->time_in != NULL && $employee->time_out != NULL)
                                        {
                                            $total_daily_hrs = $total_time_out_mins - $total_time_in_mins;

                                            if($total_daily_hrs < 600)
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
                                                    $undertime_mins = 600 - $total_daily_hrs; 
                                                    $convert_undertime = $undertime_mins / 60;
                                                    $round_off_ut = round($convert_undertime, 2);
                                                    echo $round_off_ut;
                                                    $ut_mins = $undertime_mins;
                                                    //echo $undertime_mins;
                                                }
                                                
                                            } 
                                            
                                            else
                                            {
                                                $ut_mins = 0;
                                            }  
                                        
                                        }
                                        else
                                        {
                                            $ut_mins = 0;
                                        }
                                        
                                    }

                                    //$total_undertime += $ut_mins;
                                ?>

                            </td>
                            <!-- NIGHT DIFF -->
                            <td title="
                                <?php
                                    $start_nd = 1320;
                                    $end_nd = 360;
                                    //if($employee->employee_number == $employee->ot_employee_number && $employee->date_ot == $employee->temp_date)
                                    if($change_sched == 1 || $employee->employee_number == $employee->ot_employee_number && $employee->date_ot == $employee->temp_date || $employee->flexi_time == 1)
                                    {
                                        //
                                        if($end_nd > $total_time_in_mins && $employee->date_in != NULL && $start_nd < $total_time_out_mins && $employee->date_out != NULL)
                                        {
                                            $total_nd_am = $end_nd - $total_time_in_mins;
                                            $total_nd_pm = $total_time_out_mins - $start_nd;

                                            if($total_time_in_mins == 01 && $total_time_out_mins == 1439)
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins + 1;
                                                $total_nd_pm = $total_time_out_mins - $start_nd + 1;
                                            }
                                            elseif($total_time_in_mins == 01 && $total_time_out_mins != 1439)
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins + 1;
                                                $total_nd_pm = $total_time_out_mins - $start_nd;
                                            }
                                            elseif($total_time_in_mins != 01 && $total_time_out_mins == 1439)
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins;
                                                $total_nd_pm = $total_time_out_mins - $start_nd + 1;
                                            }
                                            else
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins;
                                                $total_nd_pm = $total_time_out_mins - $start_nd;
                                            }

                                            $total_nd = $total_nd_am + $total_nd_pm;

                                            $hours = intval($total_nd/60);
                                            $min_diff = intval($total_nd%60);
                                            if($total_nd >= 30)
                                            {
                                                if($min_diff >= 30) {
                                                    echo $hours . ' HOUR/S AND ' . ' 30 MINUTES';
                                                    $hr_diff = $hours * 60;
                                                    $nd = $hr_diff + 30;
                                                    $nd_compute =  $nd;
                                                } 
                                                elseif($min_diff <= 30) {
                                                    echo $hours . ' HOUR/S AND ' . ' 00 MINUTES';
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
                                                if($total_time_in_mins == 01)
                                                {
                                                    $total_nd_am = $total_time_out_mins - $total_time_in_mins + 1;
                                                }
                                                else
                                                {
                                                    $total_nd_am = $total_time_out_mins - $total_time_in_mins;
                                                }    

                                                $hours = intval($total_nd_am/60);
                                                $min_diff = intval($total_nd_am%60);
                                                
                                                //echo $total_nd_am;
                                                if($total_nd_am >= 30)
                                                {
                                                    if($min_diff >= 30) {
                                                        echo $hours . ' HOUR/S AND ' . ' 30 MINUTES';
                                                        $hr_diff = $hours * 60;
                                                        $nd = $hr_diff + 30;
                                                        $nd_compute =  $nd;
                                                    } 
                                                    elseif($min_diff <= 30) 
                                                    {
                                                        echo $hours . ' HOUR/S AND ' . ' 00 MINUTES';
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
                                                if($total_time_in_mins == 01)
                                                {
                                                    $total_nd_am = $end_nd - $total_time_in_mins + 1;
                                                }
                                                else
                                                {
                                                    $total_nd_am = $end_nd - $total_time_in_mins;
                                                }    

                                                $hours = intval($total_nd_am/60);
                                                $min_diff = intval($total_nd_am%60);
                                                
                                                //echo $total_nd_am;
                                                if($total_nd_am >= 30)
                                                {
                                                    if($min_diff >= 30) {
                                                        echo $hours . ' HOUR/S AND ' . ' 30 MINUTES';
                                                        $hr_diff = $hours * 60;
                                                        $nd = $hr_diff + 30;
                                                        $nd_compute =  $nd;
                                                    } 
                                                    elseif($min_diff <= 30) {
                                                        echo $hours . ' HOUR/S AND ' . ' 00 MINUTES';
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

                                                if($total_time_out_mins == 1439)
                                                {
                                                    $total_nd_pm = $total_time_out_mins - $start_nd + 1;
                                                }
                                                else
                                                {
                                                    $total_nd_pm = $total_time_out_mins - $start_nd;
                                                }
                                                
                                                $hours = intval($total_nd_pm/60);
                                                $min_diff = intval($total_nd_pm%60);

                                                if($total_nd_pm >= 30)
                                                {
                                                    if($min_diff >= 30) {
                                                        echo $hours . ' HOUR/S AND ' . ' 30 MINUTES';
                                                        $hr_diff = $hours * 60;
                                                        $nd = $hr_diff + 30;
                                                        $nd_compute =  $nd;
                                                    } 
                                                    elseif($min_diff <= 30) {
                                                        echo $hours . ' HOUR/S AND ' . ' 00 MINUTES';
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
                                    }
                                    else
                                    {
                                        echo ' ';
                                        $nd_compute = 0;
                                    }
                                ?>
                            ">
                                <?php
                                    $start_nd = 1320;
                                    $end_nd = 360;
                                    //if($employee->employee_number == $employee->ot_employee_number && $employee->date_ot == $employee->temp_date)
                                    if($change_sched == 1 || $employee->employee_number == $employee->ot_employee_number && $employee->date_ot == $employee->temp_date || $employee->flexi_time == 1)
                                    {
                                        //
                                        if($end_nd > $total_time_in_mins && $employee->date_in != NULL && $start_nd < $total_time_out_mins && $employee->date_out != NULL)
                                        {
                                            $total_nd_am = $end_nd - $total_time_in_mins;
                                            $total_nd_pm = $total_time_out_mins - $start_nd;

                                            if($total_time_in_mins == 01 && $total_time_out_mins == 1439)
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins + 1;
                                                $total_nd_pm = $total_time_out_mins - $start_nd + 1;
                                            }
                                            elseif($total_time_in_mins == 01 && $total_time_out_mins != 1439)
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins + 1;
                                                $total_nd_pm = $total_time_out_mins - $start_nd;
                                            }
                                            elseif($total_time_in_mins != 01 && $total_time_out_mins == 1439)
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins;
                                                $total_nd_pm = $total_time_out_mins - $start_nd + 1;
                                            }
                                            else
                                            {
                                                $total_nd_am = $end_nd - $total_time_in_mins;
                                                $total_nd_pm = $total_time_out_mins - $start_nd;
                                            }

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
                                                if($total_time_in_mins == 01)
                                                {
                                                    $total_nd_am = $total_time_out_mins - $total_time_in_mins + 1;
                                                }
                                                else
                                                {
                                                    $total_nd_am = $total_time_out_mins - $total_time_in_mins;
                                                }    

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
                                                    elseif($min_diff <= 30) 
                                                    {
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
                                                if($total_time_in_mins == 01)
                                                {
                                                    $total_nd_am = $end_nd - $total_time_in_mins + 1;
                                                }
                                                else
                                                {
                                                    $total_nd_am = $end_nd - $total_time_in_mins;
                                                }    

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

                                                if($total_time_out_mins == 1439)
                                                {
                                                    $total_nd_pm = $total_time_out_mins - $start_nd + 1;
                                                }
                                                else
                                                {
                                                    $total_nd_pm = $total_time_out_mins - $start_nd;
                                                }
                                                
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
                                    }
                                    else
                                    {
                                        echo ' ';
                                        $nd_compute = 0;
                                    }
                                    
                                ?>
                                <?php  $total_night_diff += $nd_compute; ?>
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
                        <?php endif; ?>    
                    </tr>
                   
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>  

    <script type="text/javascript">
        $(document).ready(function() {
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
    