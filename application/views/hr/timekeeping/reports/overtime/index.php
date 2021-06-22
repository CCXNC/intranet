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
                <th scope="col">TASK</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php if($ots) : ?>
                <?php foreach($ots as $ot) : ?>
                    <tr <?php //echo $actual_total_ot < $total_ot ? "style='background-color:#e3342f !important;color:white !important;'" : ''; ?>>
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
                        ">
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
                        ">
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
                        ">
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
                        ">
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
                        ">
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
                        ">
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
                        ">
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
                        ">
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