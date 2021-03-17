<div class="card">
    <div class="card-header" style="background-color:#1C4670; color:white;"><h4>IMPLEMENTED 5S SHARE MY IDEA<a href="<?php echo base_url(); ?>fives/implemented" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>fives/edit_implemented_idea/<?php echo $idea->id; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color:#1C4670; color:white;">My Idea</div>
                <div class="card-body">
                    <div class="row">
                        <input type="text" name="control_number" value="<?php echo $idea->control_number; ?>" hidden>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current</label>
                                <textarea type="text" class="form-control" name="current" rows="4" cols="50"><?php echo $idea->current; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proposal</label>
                                <textarea type="text" class="form-control" name="proposal" rows="4" cols="50"><?php echo $idea->proposal; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Impact</label>
                                <textarea type="text" class="form-control" name="impact" rows="4" cols="50"><?php echo $idea->impact; ?></textarea>
                                <br>
                                <p><?php echo $idea->file; ?></p>
                                <input type='file' name='data1' size='20' />
                            </div>
                        </div>
                    </div>
                    <?php 
                        $explod_data = explode(',',$idea->classification); 
                        $count_data = count($explod_data);
                        //echo $count_data;
                    ?>
                   
                    <?php if($classifications) : ?>
                        <?php foreach($classifications as $classification) : ?>
                           
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="checkbox" name="classification[]" value="<?php echo $classification->name; ?>"
                                            <?php for($i=0; $count_data > $i; $i++) : ?><?php echo $classification->name == $explod_data[$i] ? 'checked' : ' '; ?>  <?php endfor; ?>
                                            <label for="vehicle1"><?php echo $classification->name; ?></label><br>
                                        </div>
                                    </div>
                                </div> 
                          
                        <?php endforeach; ?>
                            
                    <?php endif; ?>
                </div>
                <br>
                <center>
                    <div class="form-group">
                        <input type="submit" class="btn" title="Update Idea" style="background-color:#1C4670; color:white;" onclick="return confirm('Do you want to update data?');" value="Update" >
                    </div>
                </center>
            </div>
        </form>
    </div>
</div>
