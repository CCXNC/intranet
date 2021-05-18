<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color:white;"><h4><?php echo $ot->fullname; ?><a href="<?php echo base_url(); ?>reports/index_ot" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""> Date of Overtime</label>
                    <div class="form-control"><?php echo date('F j, Y', strtotime($ot->date_ot)); ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time Start of Overtime</label>
                    <div class="form-control"><?php echo $ot->time_start; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time End of Overtime</label>
                    <div class="form-control"><?php echo $ot->time_end; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Estimated Number of Hours</label>
                    <div class="form-control">
                        <?php    
                            echo $ot->ot_num;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Type</label>
                    <div class="form-control"><?php if($ot->type == 'OT') { echo "REGULAR OVERTIME"; } elseif($ot->type == 'RHOT') { echo "REGULAR HOLIDAY OVERTIME"; } elseif($ot->type == 'SHOT') { echo "SPECIAL HOLIDAY OVERTIME"; } ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Specific Task To Be Done</label>
                    <div class="form-control"><?php echo $ot->task; ?></div>
                </div>
            </div>
        </div>
    </div>    
</div>