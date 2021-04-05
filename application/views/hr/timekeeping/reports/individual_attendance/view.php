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
                            <th scope="col">HOURS LATE</th>
                            <th scope="col">UNDERTIME</th>
                            <th scope="col">OT</th>
                            <th scope="col">ND</th>
                            <th scope="col">REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($employee_times) : ?>
                            <?php foreach($employee_times as $employee_time) : ?>
                                <tr>
                                    <td><?php echo date('D', strtotime($employee_time->date)); ?></td>
                                    <td><?php echo $employee_time->date; ?></td>
                                    <td><?php echo $employee_time->time_in; ?></td>
                                    <td><?php echo $employee_time->time_out; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
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
        </div>
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
   