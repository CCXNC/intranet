<div class="card">
    <div class="card-header"><h4>EDIT HOLIDAY<a href="<?php echo base_url(); ?>timekeeping/calendar_list" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?></div>
        <form method="post" action="<?php echo base_url(); ?>timekeeping/edit_calendar_list/<?php echo $calendar->id; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">Holiday Information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control" name="date" value="<?php echo $calendar->date; ?>" required><br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control" name="type" value="<?php echo $calendar->type; ?>" required><br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description" value="<?php echo $calendar->description; ?>" required><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-info" onclick="return confirm('Do you want to update data?');">Update</button>
        </form>
    </div>
</div>

