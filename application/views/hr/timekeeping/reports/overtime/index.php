<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card-header" style="background-color: #0C2D48; color:white;"><h4>OVERTIME LIST <a href="<?php echo base_url(); ?>attendance/index" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a> <a href="<?php echo base_url(); ?>reports/add_ot" class="btn btn-dark float-right" title="Add Overtime" style="border:1px solid #ccc; margin-right:10px;">ADD</a> </h4></div>
<br>
<form method="POST" id="" enctype="multipart/form-data">
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
        <!--<div class="form-group">
            <label for="">&nbsp;</label>
            <input class="form-control btn btn-success" id="" type="submit" value="APPROVAL">
        </div>-->
    </div>    
    <table id="" class="display" style="width:100%">
        <thead>
            <tr style="background-color:#D4F1F4;">
                <th scope="col">DATE</th>
                <th scope="col">EMPLOYEE NAME</th>
                <th scope="col">DEPARTMENT</th>
                <th scope="col">TYPE</th>
                <th>OT AM</th>
                <th>OT PM</th>
                <th>OT WD</th>
                <th scope="col">TIME START</th>
                <th scope="col">TIME END</th>
                <th scope="col">OT (HOURS.MINS)</th>
                <th scope="col">TASK</th>
                <!--<th scope="col"><center><input type="checkbox" id="checkAll" name=""></center></th>
                <th scope="col">STATUS</th>-->
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if($ots) : ?>
                <?php foreach($ots as $ot) : ?>
                    <?php
                        //EXPLODE ACTUAL TIME IN AND TIME OUT
                        if($ot->time_in != NULL && $ot->time_out != NULL)
                        {
                            $explod_time_in = explode(":",$ot->time_in);
                            $explod_time_out = explode(":",$ot->time_out);
                        }
                        elseif($ot->time_in != NULL && $ot->time_out == NULL)
                        {
                            $explod_time_in = explode(":",$ot->time_in);
                            $explod_time_out = explode(":","00:00");
                        }
                        elseif($ot->time_in == NULL && $ot->time_out != NULL)
                        {
                            $explod_time_in =  explode(":","00:00");
                            $explod_time_out = explode(":",$ot->time_out);
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
                            //echo $total_sched_time_in_mins . '|' . $total_sched_time_out_mins;
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
                            //echo $total_sched_time_in_mins . '|' . $total_sched_time_out_mins;
                        }
                 
                        $week_day = date('w', strtotime($ot->date_ot));
                        if($week_day == 6 || $week_day == 0)
                        {
                            $actual_total_ot = $total_time_out_mins - $total_time_in_mins;
                            //echo $actual_total_ot;
                        }
                        else
                        {
                            if($sched_time_in_mins > $total_time_in_mins && $ot->date_in != NULL && $ot->day == 'am')
                            {
                                $actual_total_ot =  $sched_time_in_mins - $total_time_in_mins; 
                                //echo $actual_total_ot;
                            
                            }
                            elseif($total_time_out_mins > $sched_time_out_mins && $ot->date_out != NULL && $ot->day == 'pm')
                            {
                                $actual_total_ot = $total_time_out_mins - $sched_time_out_mins;
                                //echo $actual_total_ot;
                            }
                        }
                        
                        $explod_ot = explode(".", $ot->ot_num);
                        $ot_hrs = $explod_ot[0] * 60;
                        $total_ot = $ot_hrs + $explod_ot[1];
                        //echo $total_ot;
                        
                    ?>
                    <tr <?php echo $actual_total_ot < $total_ot ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
                        <td><?php echo $ot->date_ot; ?></td>
                        <td><?php echo $ot->fullname; ?></td>
                        <td><?php echo $ot->department; ?></td>
                        <td><?php if($ot->type == 'OT') { echo "REGULAR OVERTIME"; } elseif($ot->type == 'RHOT') { echo "REGULAR HOLIDAY OVERTIME"; } elseif($ot->type == 'SHOT') { echo "SPECIAL HOLIDAY OVERTIME"; } ?></td>
                        <td>
                            <?php
                                if($sched_time_in_mins > $total_time_in_mins && $ot->date_in != NULL && $ot->day == 'am')
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
                            
                            ?>
                        </td>
                        <td>
                            <?php 
                                if($total_time_out_mins > $sched_time_out_mins && $ot->date_out != NULL && $ot->day == 'pm')
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
                            ?>
                            
                        </td>
                         <td>
                            <?php 
                                $week_day = date('w', strtotime($ot->date_ot));
                                if($week_day == 6 || $week_day == 0)
                                {
                                    $total_ot_pm = $total_time_out_mins - $total_time_in_mins;
                                    if($total_ot_pm >= 60)
                                    {
                                        $hours = intval($total_ot_pm/60);
                                        $min_diff = intval($total_ot_pm%60);
                                        $minutes = sprintf("%02d", $min_diff);
                                        echo $hours.".".$minutes."";
                                    }    
                                }
                                
                            ?>
                        </td>
                        <td><?php echo $ot->time_start; ?></td>
                        <td><?php echo $ot->time_end; ?></td>
                        <td><?php echo $ot->ot_num; ?></td>
                        <td><?php echo substr($ot->task,0,50); ?></td>
                        <!--<td> <center><input type="checkbox" name="leave[]" value=""> </center></td>
                        <td>
                            <?php 
                                if($ot->status == 1) {
                                    echo 'APPROVED';
                                } else {
                                    echo 'FOR APPROVAL';
                                }
                            ?>
                        </td>-->
                        <td data-label="Action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>reports/view_employee_ot/<?php echo $ot->id; ?>">View</a>
                                    <a class="dropdown-item" href="<?php echo base_url(); ?>reports/edit_employee_ot/<?php echo $ot->id; ?>">Edit</a>
                                    <a class="dropdown-item" onclick="return confirm('Do you want to delete data?');" href="<?php echo base_url(); ?>reports/delete_employee_ot/<?php echo $ot->id; ?>">Delete</a>
                                </div>
                            </div>
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
            "bSortClasses": false,
            "paging":   false,
            "ordering": true,
            "info":     false,
            dom: 'Bf',
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
				$('#ut').attr('action', 'process_ut');
				$('#ut').submit();
			} else {
				return false;
			} 
		});
    } );
</script>