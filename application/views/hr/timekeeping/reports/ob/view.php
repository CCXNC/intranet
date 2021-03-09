<div class="card">
    <div class="card-header"><h4><?php echo $ob->fullname; ?> ( <?php echo $ob->department; ?> )<a href="<?php echo base_url(); ?>reports/index_ob" title="Go Back to Menu" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""> Date of OB</label>
                    <div class="form-control"><?php echo $ob->date_ob; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Destination</label>
                    <div class="form-control"><?php echo $ob->destination; ?></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Purpose</label>
                    <div class="form-control"><?php echo $ob->purpose; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Transport</label>
                    <div class="form-control"><?php echo $ob->transport; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Plate Number</label>
                    <div class="form-control"><?php echo $ob->plate_no; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure</label>
                    <div class="form-control"><?php echo $ob->time_departure; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Time of Departure Destination</label>
                    <div class="form-control"><?php echo $ob->time_departure_destination; ?></div>
                </div>
            </div>
        </div>
</div>