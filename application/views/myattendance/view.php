<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card">
    <div class="card-header" style=""><h4><?php echo $employee_name->fullname; ?> ( <?php echo $employee_name->department_name; ?> ) <a href="<?php echo base_url(); ?>user/index_my_attendance" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</h4></a> 
    </div>
    <div class="card-body" >
        <div class="card">
            <div class="card-header" style="background-color: #3490dc; color:white;"><h5>SCHEDULE</h5></div>
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">EMPLOYEE NUMBER</th>
                            <th scope="col">BIOMETRIC ID</th>
                            <th scope="col">DAYS</th>
                            <th scope="col">TIME</th>
                            <th scope="col">GRACE PERIOD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $employee_name->employee_number; ?></td>
                            <td><?php echo $employee_name->biometric_id; ?></td>
                            <td><?php echo $employee_name->days; ?></td>
                            <td><?php echo date('h:i A', strtotime($employee_name->time_in)) . ' | ' . date('h:i A', strtotime($employee_name->time_out)); ?></td>
                            <td><?php echo $employee_name->grace_period . ' MINUTES'; ?></td>
                        </tr>
                    </tbody>
                </table>   
            </div>
        </div> 
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
                            <th scope="col">DAILY HOURS</th>
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
                                                $explod_time_in = explode(":","00:00");
                                                $explod_time_out = explode(":","00:00");
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
                                                   if($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#bdc7c9;color:white;">NO IN</p>'; 
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
                                                   if($days_temp_date == '6' || $days_temp_date == '0') 
                                                    {
                                                    }
                                                    else
                                                    {
                                                        echo '<p class="" style="text-align:center;padding:5px;background-color:#bdc7c9;color:white;">NO OUT</p>'; 
                                                    }
                                                }
                                                else { 
                                                    echo $employee->time_out; 
                                                } 
                                            ?>
                                        </td>
                                         <!--  PROCESS -->
                                         <td>
                                            <?php 
                                                if($total_time_in_mins != NULL && $total_time_out_mins != NULL)
                                                {
                                                    $daily_mins = $total_time_out_mins - $total_time_in_mins;
                                                    $hours = intval($daily_mins/60);
                                                    $min_diff = intval($daily_mins%60);
                                                    $minutes = sprintf("%02d", $min_diff);
                                                    echo $hours." Hours"." &     ".$minutes." Minutes"; 
                                                }
                                                else
                                                {

                                                }
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>

    
   