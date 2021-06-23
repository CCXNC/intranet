<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<div class="card">
    <div class="card-header" style="background-color: #007BFF; border: #007BFF; color: white"><h4>SUMMARY LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url();?>reports/summary_list" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="start_date" value="<?php echo $first_date->first_date; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">End Date</label>
                        <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="end_date" value="<?php echo $last_date->last_date; ?>">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row" style="float: right">
                    <input type="submit" title="Submit Date" class="btn btn-info" value="SUBMIT">
                    </form> &nbsp;
                    <form method="post" action="<?php echo base_url();?>reports/process_tard_ut_nd" enctype="multipart/form-data"> 
                    <input class="btn btn-success" id="processTime" type="submit" value="VIEW DATA">
                </div>
            </div>
    </div>    
</div>
<br>
        <table id="" hidden class="display" style="width:100%">
            <thead>
                <tr style="background-color:#D4F1F4;">
                    <th scope="col">NAME</th>
                    <th scope="col">DATE</th>
                    <th scope="col">TIME IN</th>
                    <th scope="col">TIME OUT</th>
                    <th scope="col">TARDINESS</th>
                    <th scope="col">UNDERTIME</th>
                    <th scope="col">ND</th>
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
                                    <input type="text" name="employee_number[]" value="<?php echo $employee->employee_number; ?>">
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
                                    ?>">
                                    <?php  
                                        if($employee->date_in != NULL) { 

                                            echo $employee->date_in; 
                                            $emp_date = $employee->date_in; 

                                        } elseif($employee->date_out != NULL) { 

                                            echo $employee->date_out; 
                                            $emp_date = $employee->date_out; 
                                        } else {
                                            
                                            echo $employee->temp_date; 
                                            $emp_date = $employee->temp_date; 
                                        } 
                                    ?>
                                    <input type="text" name="date[]" value="<?php echo $emp_date; ?>">
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
                                                    $emp_time_in = ' ';
                                                } else {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
                                                    $emp_time_in = ' ';
                                                }
                                            } 
                                            elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                            {
                                                
                                                if($employee->type_name == "VL") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;color:white;"></p>';
                                                    $emp_time_in = ' ';
                                                }  elseif($employee->type_name == "SL") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                    $emp_time_in = ' ';
                                                } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                                    $emp_time_in = ' ';
                                                } elseif($employee->type_name == "VACATION LEAVE") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;white;"></p>';
                                                    $emp_time_in = ' ';
                                                } elseif($employee->type_name == "VL W/O PAY") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);white;"></p>';
                                                    $emp_time_in = ' ';
                                                } elseif($employee->type_name == "SICK LEAVE") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                    $emp_time_in = ' ';
                                                } elseif($employee->type_name == "SL W/O PAY") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#e3342f;color:white;"></p>';
                                                    $emp_time_in = ' ';
                                                } else {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                    $emp_time_in = ' ';
                                                }
                                            }
                                            elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                            {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:#9f5f80;color:white;"></p>';
                                                $emp_time_in = ' ';
                                            }
                                            elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                            {
                                                $emp_time_in = ' ';
                                            }
                                            else {
                                                echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">NO IN</p>'; 
                                                $emp_time_in = ' ';
                                            }
                                        }
                                        else { 
                                            if($halfday_mins <= $total_time_in_mins)
                                            {
                                                if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                {
                                                    echo $employee->time_in; 
                                                    $emp_time_in =  $employee->time_in; 
                                                }
                                                elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                {
                                                    echo $employee->time_in; 
                                                    $emp_time_in =  $employee->time_in; 
                                                }
                                                elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut)
                                                {
                                                    echo $employee->time_in; 
                                                    $emp_time_in =  $employee->time_in; 
                                                }
                                                else
                                                {
                                                    if($days_temp_date == '6' || $days_temp_date == '0' && $employee->employee_number != '03151077') 
                                                    {
                                                        echo $employee->time_in; 
                                                        $emp_time_in =  $employee->time_in; 
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">' . $employee->time_in . '</p>'; 
                                                        $emp_time_in = ' ';
                                                    }    
                                                }
                                            }
                                            
                                            else
                                            {
                                                echo $employee->time_in; 
                                                $emp_time_in =  $employee->time_in; 
                                            }
                                            
                                        } 
                                    ?>
                                    <input type="text" name="time_in[]" value="<?php echo $emp_time_in; ?>">
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
                                                    $emp_time_out = ' ';
                                                } else {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(113,173,83);color:white;"></p>'; 
                                                    $emp_time_out = ' ';
            
                                                }
                                            } 
                                            elseif($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                            {
                                                if($employee->type_name == "VL") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;color:white;"></p>';
                                                    $emp_time_out = ' ';
                                                }  elseif($employee->type_name == "SL") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                    $emp_time_out = ' ';
                                                } elseif($employee->type_name == "ML" || $employee->type_name == "PL" || $employee->type_name == "BL") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(111,49,160);color:white;"></p>';
                                                    $emp_time_out = ' ';
                                                } elseif($employee->type_name == "VACATION LEAVE") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#3490dc;white;"></p>';
                                                    $emp_time_out = ' ';
                                                } elseif($employee->type_name == "VL W/O PAY") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);white;"></p>';
                                                    $emp_time_out = ' ';
                                                } elseif($employee->type_name == "SICK LEAVE") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#38c172;color:white;"></p>';
                                                    $emp_time_out = ' ';
                                                } elseif($employee->type_name == "SL W/O PAY") {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:#e3342f;color:white;"></p>';
                                                    $emp_time_out = ' ';
                                                } else {
                                                    echo '<p class="" style="text-align:center;padding:17px;background-color:rgb(255,100,0);color:white;"></p>';
                                                    $emp_time_out = ' ';
                                                }
                                            }
                                            elseif($employee->employee_number == $employee->holiday_employee_number && $employee->temp_date == $employee->holiday_date)
                                            {
                                                echo '<p class="" style="text-align:center;padding:17px;background-color:#9f5f80;color:white;"></p>';
                                                $emp_time_out = ' ';
                                            }
                                            elseif($days_temp_date == '6' || $days_temp_date == '0') 
                                            {
                                                $emp_time_out = ' ';
                                            }
                                            else
                                            {
                                                echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">NO OUT</p>'; 
                                                $emp_time_out = ' ';
                                            }
                                        }
                                        else { 
                                            
                                            if($undertime_pm_mins > $total_time_out_mins)
                                            {
                                                if($employee->employee_number == $employee->leave_employee_number && $employee->temp_date == $employee->date_leave)
                                                {
                                                    echo $employee->time_out; 
                                                    $emp_time_out = $employee->time_out; 
                                                }
                                                elseif($employee->employee_number == $employee->ob_employee_number && $employee->temp_date == $employee->date_ob)
                                                {
                                                    echo $employee->time_out; 
                                                    $emp_time_out = $employee->time_out; 
                                                }
                                                elseif($employee->employee_number == $employee->ut_employee_number && $employee->temp_date == $employee->date_ut)
                                                {
                                                    echo $employee->time_out; 
                                                    $emp_time_out = $employee->time_out; 
                                                }
                                                else
                                                {
                                                    if($days_temp_date == '6' || $days_temp_date == '0' && $employee->employee_number != '03151077') 
                                                    {
                                                        echo $employee->time_out; 
                                                        $emp_time_out = $employee->time_out; 
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#e3342f;color:white;">' . $employee->time_out .'</p>'; 
                                                        $emp_time_out = ' ';
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                echo $employee->time_out;   
                                                $emp_time_out = $employee->time_out;   
                                            }
                                        } 

                                    ?>
                                    <input type="text" name="time_out[]" value="<?php echo $emp_time_out; ?>">
                                </td>
                                <!-- TARDINESS -->
                                <td title="">
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
                                    ?>
                                    <input type="text" name="tardiness[]" value="<?php echo $late_mins; ?>">
                                </td>
                                <!-- UNDERTIME -->
                                <td title="">
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
                                    ?>
                                    <input type="text" name="undertime[]" value="<?php echo $ut_mins; ?>">
                                </td>
                                <!-- NIGHT DIFF -->
                                <td title="">
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
                                    <input type="text" name="night_diff[]" value="<?php echo $nd_compute; ?>">
                                </td>
                            <?php endif; ?>    
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table> 
    </form>     



  