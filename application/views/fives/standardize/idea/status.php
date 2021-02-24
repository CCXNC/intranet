<div class="card">
    <div class="card-header" style="background-color:#1C4670; color:white;"><h4>SHARE MY IDEA <a href="<?php echo base_url(); ?>fives/idea" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
            <div class="card">
                <div class="card-header" style="background-color:#1C4670; color:white;">STATUS FORM</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control" id="mySelect">
                                    <?php if($attach->status != 'Open') : ?>
                                        <option value="Open">Open</option>
                                    <?php endif; ?>
                                    <?php if($attach->status != 'Ongoing') : ?>
                                        <option value="Ongoing">Ongoing</option>
                                    <?php endif; ?>
                                    <option value="Implemented">Implemented</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="<?php echo base_url(); ?>fives/status/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>" enctype="multipart/form-data" id="open-ongoing">
                        <input type="text" name="id" value="<?php echo $idea->id; ?>" hidden>
                        <input type="text" name="control_number" value="<?php echo $idea->control_number; ?>" hidden>
                        <div class="row" hidden>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" id="mySelect">
                                        <?php if($attach->status != 'Open') : ?>
                                            <option value="Open">Open</option>
                                        <?php endif; ?>
                                        <?php if($attach->status != 'Ongoing') : ?>
                                            <option value="Ongoing">Ongoing</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea type="text" class="form-control" name="remarks" rows="4" cols="50"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type='file' name='data1' size='20' />
                                    <p><i style="color: blue">Allowed file types: jpg | jpeg | png | gif | docx | xls | xlsx | pdf</i></p>
                                </div>
                            </div>
                        </div> 
                        <center>
                            <div class="form-group">
                                <input type="submit" class="btn" style="background-color:#1C4670; color:white;" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                            </div>
                        </center>
                    </form>  
                    <form method="post" action="<?php echo base_url(); ?>fives/implemented_add/<?php echo $idea->id; ?>/<?php echo $idea->control_number; ?>/<?php echo $idea->status; ?>" enctype="multipart/form-data" id="implemented">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Before</label>
                                    <textarea type="text" class="form-control" name="current" rows="4" cols="50" required="required"></textarea >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>After</label>
                                    <textarea type="text" class="form-control" name="proposal" rows="4" cols="50" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Impact</label>
                                    <textarea type="text" class="form-control" name="impact" rows="4" cols="50" required="required"></textarea>
                                    <br>
                                    <input type='file' name='data1' size='20' />
                                    <p><i style="color: blue">Allowed file types: jpg | jpeg | png | gif | docx | xls | xlsx | pdf</i></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox" name="classification[]" value="Quality">
                                    <label for="vehicle1">Quality</label><br>
                                    <input type="checkbox" name="classification[]" value="Safety">
                                    <label for="vehicle2">Safety</label><br>
                                    <input type="checkbox" name="classification[]" value="Cost Saving">
                                    <label for="vehicle3">Cost Saving</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="checkbox"  name="classification[]" value="Process Efficiency">
                                    <label for="vehicle3">Process Efficiency</label><br>
                                    <input type="checkbox" name="classification[]" value="System Creation/Tool">
                                    <label for="vehicle1">System Creation/Tool</label><br>
                                    <input type="checkbox" name="classification[]" value="Customer Satisfaction">
                                    <label for="vehicle2">Customer Satisfaction</label>
                                </div>
                            </div>
                        </div>  
                        <br>
                        <center>
                            <div class="form-group">
                                <input type="submit" class="btn" style="background-color:#1C4670; color:white;" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                            </div>
                        </center>
                    </form> 
                </div>
            </div>
    </div>
</div>
<script>
    $("#implemented").hide(); 
    $('#mySelect').on('change', function() {
        var value = $(this).val();
        if(value == "Implemented" ){
            $("#implemented").show();
            $("#open-ongoing").hide();
        } else if(value == "Open") {
            $("#open-ongoing").show();
            $("#implemented").hide();
        } else if(value == "Ongoing") {
            $("#open-ongoing").show();
            $("#implemented").hide();
        }
    });
  
</script>
