<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>MATERIAL<a href="<?php echo base_url(); ?>procurement/material_enrollment" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>procurement/material_enrollment_edit/<?php echo $material->id; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">MATERIAL DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD; color:black;">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Code</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="mcode" style="font-size:12px" value="<?php echo $material->mcode; ?>">
                            </div>
                        </div>
                    </div>    

                    <div class="row">    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Description</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="description" style="font-size:12px" value="<?php echo $material->description; ?>">
                            </div>
                        </div>
                    </div>    

                    <div class="row">        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Group</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <select  style="font-size:12px" class="form-control" name="material_group" id="">
                                <?php if($material_groups) : ?>
                                    <?php foreach($material_groups as $material_group) : ?>
                                        <option class="form-group" value="<?php echo $material_group->code; ?>"<?php echo $material_group->code == $material->code_id ? 'selected' : ' '; ?>><?php echo $material_group->name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                 
                </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="" class="btn btn-success" onclick="return confirm('Do you want to update data?');" value="UPDATE" >
                </div>
            </center>
        </form>
    </div>
</div>