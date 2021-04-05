<div class="card">
    <div class="card-header" style="background-color: #067593;color:white;"><h4><?php echo $ut->fullname; ?> ( <?php echo $ut->department; ?> )<a href="<?php echo base_url(); ?>reports/index_ut" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Date of Undertime</label>
                    <div class="form-control"><?php echo $ut->date_ut; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time Start of Undertime</label>
                    <div class="form-control"><?php echo $ut->time_start; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time End of Undertime</label>
                    <div class="form-control"><?php echo $ut->time_end; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Ut Hours</label>
                    <div class="form-control">
                        <?php 
                            $hours = floor($ut->ut_num / 60);
                            $minutes = $ut->ut_num % 60;
                            $ut_hrs = $hours. '.' .$minutes;
                            echo $ut_hrs;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Reason</label>
                    <div class="form-control"><?php echo $ut->reason; ?></div>
                </div>
            </div>
        </div>
</div>