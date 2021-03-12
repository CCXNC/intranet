<div class="card">
    <div class="card-header"><h4><?php echo $leave->fullname; ?> ( <?php echo $leave->department; ?> )<a href="<?php echo base_url(); ?>reports/index_slvl" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
    <form method="post" action="<?php echo base_url(); ?>reports/add_slvl" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Type</label>
                    <div class="form-control"><?php echo $leave->type_name; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Day</label>
                    <div class="form-control">
                        <?php 
                           if($leave->leave_day == 'WD')
                           {
                               echo "WHOLE DAY";
                           }
                           elseif($leave->leave_day == 'HDAM')
                           {
                               echo "HALF DAY (AM)";
                           }
                           elseif($leave->leave_day == 'HDPM')
                           {
                                echo "HALF DAY (PM)";
                           } 
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Effective Date of leave</label>
                    <div class="form-control"><?php echo date('F j, Y', strtotime($leave->leave_date)); ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Address While On Leave</label>
                    <div class="form-control"><?php echo $leave->leave_address; ?></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Reason/s</label>
                    <textarea class="form-control" name="reason" id="" cols="30" rows="6"><?php echo $leave->reason; ?></textarea>
                </div>
            </div>
        </div><br>
      
    </form>  
</div>
