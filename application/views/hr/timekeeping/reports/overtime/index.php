<style>
    input[type=date] {
        color: black;
    }
</style>
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #0C2D48; color:white;"><h4>OVERTIME LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_ot" class="btn btn-dark float-right" title="Add Overtime" style="border:1px solid #ccc; margin-right:10px;">ADD</a> <!--<a href="<?php echo base_url(); ?>reports/cutoff_ot" class="btn btn-dark float-right" title="Add Overtime" style="border:1px solid #ccc; margin-right:10px;">EXTRACTION</a>--> </h4></div>
<br>
<form method="POST" id="ot" enctype="multipart/form-data">
    <div class="row">
        &nbsp;&nbsp;&nbsp;<div class="form-group">
            <label for="">START DATE</label>
            <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="start_date" value="<?php echo $start_date; ?>">
        </div> &nbsp;
        <div class="form-group">
            <label for="">END DATE</label>
            <input type="date" class="form-control" min="2018-12-31" max="2030-12-31" name="end_date" value="<?php echo $end_date; ?>">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input type="submit" title="Submit Date"  value="SUBMIT" class="form-control btn btn-dark">
        </div> &nbsp;
        <div class="form-group">
            <label for="">&nbsp;</label>
            <input class="form-control btn btn-success" style="background-color:#38c172;color:white;" id="process" type="submit" value="APPROVAL">
        </div>
    </div>    
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">DATE</th>
                <th scope="col">EMPLOYEE NAME</th>
                <!--<th scope="col">DEPARTMENT</th>-->
                <!--<th scope="col">TYPE</th>-->
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
                <th scope="col"><center><input type="checkbox" id="checkAll" name=""></center></th>
                <th scope="col">REMARKS</th>
                <th scope="col">TASK</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead> 
        <tbody>
            <?php if($ots) : ?>
                <?php foreach($ots as $ot) : ?>
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

                        // PROCESS FOR ROT
                        if($ot->type == "ROT") 
                        { 

                            // ROT AM PROCESS 
                            if($ot->am_time_in != NULL && $ot->am_time_out != NULL)
                            {
                                //echo $ot->am_time_in . '|' . $ot->am_time_out; 
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
    
                            //COMPUTATION OF ROT AM TIME IN AND TIME OUT TO MINUTES
                            $ot_time_in_hr_to_mins = $ot_time_in_hours * 60;
                            $ot_total_am_time_in_mins = $ot_time_in_hr_to_mins + $ot_time_in_mins;
    
                            $ot_time_out_hr_to_mins = $ot_time_out_hours * 60;
                            $ot_total_am_time_out_mins = $ot_time_out_hr_to_mins + $ot_time_out_mins;
                            //echo 'OT :' .$ot_total_am_time_in_mins . '|' . $ot_total_am_time_out_mins;
                        
                            
                            //echo $total_time_in_mins . ' < ' . $ot_total_am_time_in_mins . ' ---- ' . $sched_time_in_mins .' > ' . $ot_total_am_time_out_mins . ')';
                            if($total_time_in_mins <= $ot_total_am_time_in_mins && $sched_time_in_mins >= $ot_total_am_time_out_mins)
                            {
                                //echo 'sucess';
                                $rot_am = 0;
                            }
                            else
                            {
                                //echo 'fail';
                                $rot_am = 1;
                            }
                            


                            // ROT PM PROCESS
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
    
                                //COMPUTATION OF ROT PM TIME IN AND TIME OUT TO MINUTES
                            $ot_pm_time_in_hr_to_mins = $ot_pm_time_in_hours * 60;
                            $ot_pm_total_am_time_in_mins = $ot_pm_time_in_hr_to_mins + $ot_pm_time_in_mins;
    
                            $ot_pm_time_out_hr_to_mins = $ot_pm_time_out_hours * 60;
                            $ot_pm_total_am_time_out_mins = $ot_pm_time_out_hr_to_mins + $ot_pm_time_out_mins;
                            //echo 'OT :' .$ot_total_am_time_in_mins . '|' . $ot_total_am_time_out_mins;

                            //echo $ot_pm_total_am_time_out_mins. ' <= ' . $total_time_out_mins . '----' . $total_sched_time_out_mins . ' <= ' . $ot_pm_total_am_time_in_mins;
                            if($ot->emp_flexible_time == 1)
                            {
                                $sched_out_total = 1020;
                            }
                            else
                            {
                                $sched_out_total = $total_sched_time_out_mins;
                            }
                            //echo $ot_pm_total_am_time_out_mins. ' <= ' . $total_time_out_mins . '----' . $sched_out_total . ' <= ' . $ot_pm_total_am_time_in_mins;
                            if($ot_pm_total_am_time_out_mins <= $total_time_out_mins && $sched_out_total <= $ot_pm_total_am_time_in_mins)
                            {
                                //echo '--sucess';
                                $rot_pm = 0;
                            }
                            else
                            {
                                //echo '--fail';
                                $rot_pm = 1;
                            }



                            // AUTO ZERO ALL THE OT EXCEPT ROT PROCESS
                            $restriction = 0;
                        } 

                        // PROCESS FOR RD/RDOR RH/RHOT SH/SHOT
                        else 
                        { 
                            //echo $ot->time_start . '|' . $ot->time_end; 
                            $ot_time_in = explode(":",$ot->time_start);
                            $ot_time_out = explode(":",$ot->time_end);  

                            $ot_time_in_hours = $ot_time_in[0];
                            $ot_time_in_mins = $ot_time_in[1];
    
                            $ot_time_out_hours = $ot_time_out[0];
                            $ot_time_out_mins = $ot_time_out[1];
    
                            //COMPUTATION OF OT TIME IN AND TIME OUT TO MINUTES
                            $ot_time_in_hr_to_mins = $ot_time_in_hours * 60;
                            $ot_total_time_in_mins = $ot_time_in_hr_to_mins + $ot_time_in_mins;
    
                            $ot_time_out_hr_to_mins = $ot_time_out_hours * 60;
                            $ot_total_time_out_mins = $ot_time_out_hr_to_mins + $ot_time_out_mins;
                            //echo 'OT :' .$ot_total_time_in_mins . '>' . $total_time_in_mins . '|' . $ot_total_time_out_mins . '<' . $total_time_out_mins;

                            if($ot_total_time_in_mins >= $total_time_in_mins && $ot_total_time_out_mins <= $total_time_out_mins)
                            {
                                //echo ' sucess';
                                $restriction = 0;
                            }
                            else
                            {
                                //echo ' fail';
                                $restriction = 1;
                            }

                            // AUTO ZERO ALL ROTAM AND ROTPM 
                            $rot_am = 0;
                            $rot_pm = 0;
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
                        <td><?php echo $ot->fullname; ?></td>
                        <!--<td><?php echo $ot->department; ?></td>-->
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
                        <!-- ROT AM -->
                        <td title="
                            <?php  
                                if($ot->rotam != NULL)
                                {
                                    $rotam_hrs = floor($ot->rotam / 60);
                                    $rotam_mins = $ot->rotam % 60;
                                    echo $rotam_hrs . ' HOUR/S AND ' . $rotam_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                            
                        " <?php echo $rot_am == 1 && $ot->rotam != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php  
                                if($ot->rotam != NULL)
                                {
                                    $cnvrt_rot_am = $ot->rotam / 60;
                                    $roundoff_rot_am = round($cnvrt_rot_am, 2);
                                    echo $roundoff_rot_am;
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        </td>
                        
                        <!-- ROT PM -->
                        <td title="
                            <?php  
                                if($ot->rotpm != NULL)
                                {
                                    $rotpm_hrs = floor($ot->rotpm / 60);
                                    $rotpm_mins = $ot->rotpm % 60;
                                    echo $rotpm_hrs . ' HOUR/S AND ' . $rotpm_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "   <?php echo $rot_pm == 1 && $ot->rotpm != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php  
                                if($ot->rotpm != NULL)
                                {
                                    $cnvrt_rot_pm = $ot->rotpm / 60;
                                    $roundoff_rot_pm = round($cnvrt_rot_pm, 2);
                                    echo $roundoff_rot_pm;
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        </td>
                        
                        <!-- RD -->
                        <td title="
                            <?php  
                                if($ot->rd != NULL)
                                {
                                    $rd_hrs = floor($ot->rd / 60);
                                    $rd_mins = $ot->rd % 60;
                                    echo $rd_hrs . ' HOUR/S AND ' . $rd_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "   <?php echo $restriction == 1 && $ot->rd != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php 
                                if($ot->rd != NULL)
                                {
                                    $cnvrt_rd = $ot->rd / 60;
                                    $roundoff_rd = round($cnvrt_rd, 2);
                                    echo $roundoff_rd;
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        </td>
                        
                        <!-- RDOT -->
                        <td title="
                            <?php  
                                if($ot->rdot != NULL)
                                {
                                    $rdot_hrs = floor($ot->rdot / 60);
                                    $rdot_mins = $ot->rdot % 60;
                                    echo $rdot_hrs . ' HOUR/S AND ' . $rdot_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "  <?php echo $restriction == 1 && $ot->rdot != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php

                                if($ot->rdot != NULL)
                                {
                                    $cnvrt_rdot = $ot->rdot / 60;
                                    $roundoff_rdot = round($cnvrt_rdot, 2);
                                    echo $roundoff_rdot;
                                }
                                else
                                {
                                    echo ' ';
                                }     
                            
                            ?>
                        </td>

                        <!-- RH -->
                        <td title="
                            <?php  
                                if($ot->rh != NULL)
                                {
                                    $rh_hrs = floor($ot->rh / 60);
                                    $rh_mins = $ot->rh % 60;
                                    echo $rh_hrs . ' HOUR/S AND ' . $rh_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "   <?php echo $restriction == 1 && $ot->rh != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php 
                                if($ot->rh != NULL)
                                {
                                    $cnvrt_rh = $ot->rh / 60;
                                    $roundoff_rh = round($cnvrt_rh, 2);
                                    echo $roundoff_rh;
                                }
                                else
                                {
                                    echo ' ';
                                }     
                            ?>
                        </td>
                        
                        <!-- RHOT -->
                        <td title="
                            <?php  
                                if($ot->rhot != NULL)
                                {
                                    $rhot_hrs = floor($ot->rhot / 60);
                                    $rhot_mins = $ot->rhot % 60;
                                    echo $rhot_hrs . ' HOUR/S AND ' . $rhot_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "   <?php echo $restriction == 1 && $ot->rhot != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php 
                                if($ot->rhot != NULL)
                                {
                                    $cnvrt_rhot = $ot->rhot / 60;
                                    $roundoff_rhot = round($cnvrt_rhot, 2);
                                    echo $roundoff_rhot;
                                }
                                else
                                {
                                    echo ' ';
                                }     
                            ?>
                        </td>
                        
                         <!-- SH -->
                        <td title="
                            <?php  
                                if($ot->sh != NULL)
                                {
                                    $sh_hrs = floor($ot->sh / 60);
                                    $sh_mins = $ot->sh % 60;
                                    echo $sh_hrs . ' HOUR/S AND ' . $sh_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "   <?php echo $restriction == 1 && $ot->sh != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php 
                                if($ot->sh != NULL)
                                {
                                    $cnvrt_sh = $ot->sh / 60;
                                    $roundoff_sh = round($cnvrt_sh, 2);
                                    echo $roundoff_sh;
                                }
                                else
                                {
                                    echo ' ';
                                }     
                            ?>
                        </td>
                        <!-- SHOT -->
                        <td title="
                            <?php  
                                if($ot->shot != NULL)
                                {
                                    $shot_hrs = floor($ot->shot / 60);
                                    $shot_mins = $ot->rh % 60;
                                    echo $shot_hrs . ' HOUR/S AND ' . $shot_mins .' MINUTES ';
                                }
                                else
                                {
                                    echo ' ';
                                }    
                            ?>
                        "   <?php echo $restriction == 1 && $ot->shot != NULL ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                            <?php 
                                if($ot->shot != NULL)
                                {
                                    $cnvrt_shot = $ot->shot / 60;
                                    $roundoff_shot = round($cnvrt_shot, 2);
                                    echo $roundoff_shot;
                                }
                                else
                                {
                                    echo ' ';
                                }     
                            ?>
                        </td>

                        <td><?php if($ot->status != 1) : ?> <center><input type="checkbox" name="ot[]" value="<?php echo $ot->employee_number . '|' . $ot->date_ot; ?>"> <?php endif; ?> </center></td>
        
                        <td><?php if($ot->status == 0) {  echo '<p class="" style="text-align:center;padding:5px;margin-top:15px;background-color:#e3342f;color:white;">FOR APPROVAL</p>';  } else {  echo '<p class="" style="text-align:center;padding:5px;margin-top:15px;background-color:#38c172;color:white;">APPROVED</p>'; } ?></td>

                        <!-- TASK -->
                        <td><?php echo substr($ot->task,0,50); ?></td>

                        <!--<td> <center><input type="checkbox" name="leave[]" value=""> </center></td>-->

                        <!-- ACTION -->
                        <td data-label="Action">
                            <center>
                                <a class="btn btn-danger" onclick="return confirm('Do you want to delete overtime data?');" href="<?php echo base_url(); ?>reports/delete_employee_ot/<?php echo $ot->employee_number; ?>/<?php echo $ot->date_ot; ?>">Delete</a>
                            </center> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>  
</form>
          
<script type="text/javascript">
    $(document).ready(function() {
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
            dom: 'Blfrtip',
            buttons: [
                    {
                        extend: 'excel',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Overtime',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        title: 'Overtime',
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

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $('#process').click(function() {
			var a = confirm("Are you sure you want to Approved Data?");
			if (a == true) {
				$('#ot').attr('action', 'process_ot');
				$('#ot').submit();
			} else {
				return false;
			} 
		});
    } );
</script>