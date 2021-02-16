<div class="card">
    <div class="card-header"><h4>EDIT HOLIDAY<a href="<?php echo base_url(); ?>calendar/calendar_list" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?></div>
        <form method="post" action="<?php echo base_url(); ?>calendar/edit_calendar_list/<?php echo $calendar->id; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header">Holiday Information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" name="start" value="<?php echo date('Y-m-d', strtotime($calendar->start)); ?>" required><br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" name="end" value="<?php echo date('Y-m-d', strtotime($calendar->end)); ?>" required><br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="type">
                                    <option value="">Select Type</option>
                                    <option value="Special Holiday"<?php echo $calendar->type == 'Special Holiday' ? 'selected' : ''; ?>>Special Holiday</option>
                                    <option value="Legal Holiday"<?php echo $calendar->type == 'Legal Holiday' ? 'selected' : ''; ?>>Legal Holiday</option>
                                    <option value="Economic Holiday"<?php echo $calendar->type == 'Economic Holiday' ? 'selected' : ''; ?>>Economic Holiday</option>
                                </select>
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

