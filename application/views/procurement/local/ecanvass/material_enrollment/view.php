<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>MATERIAL<a href="<?php echo base_url(); ?>procurement/material_enrollment" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">MATERIAL DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Code</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="form-control" style="font-size:12px"><?php echo $material->mcode; ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Description</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="form-control" style="font-size:12px"><?php echo $material->description; ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Group</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="form-control" style="font-size:12px"><?php echo $material->group_name; ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Material Type</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="form-control" style="font-size:12px">
                                    <?php if ($types) : ?>
                                        <?php foreach($types as $type) :?>
                                            <?php 
                                                $explode_data = explode("-", $material->mcode); 
                                                $matcode = $explode_data[0];

                                                if($matcode == $type->code)
                                                {
                                                    echo $type->type_name;
                                                }
                                            ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
    </div>
</div>