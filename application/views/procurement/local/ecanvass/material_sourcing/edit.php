
<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>EDIT ELECTRONIC MATERIAL SOURCING REQUEST FORM<a href="<?php echo base_url(); ?>procurement/material_sourcing_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>procurement/material_sourcing_edit/<?php echo $material_source->id; ?>/<?php echo $material_source->msid; ?>" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Business Unit</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly value="<?php echo $material_source->company_name; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Material Source ID</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <input type="text" class="form-control" name="msid" style="text-transform:uppercase; background-color:white; font-size:12px" readonly value="<?php echo $material_source->msid; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Sourcing Category</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly value="<?php echo $material_source->category; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Date Required</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly  value="<?php echo $material_source->date_required; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Material Source Request Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly value="<?php echo date('Y-m-d', strtotime($material_source->created_date)); ?>">
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
            <br>
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">MATERIAL DETAILS</div>
                <div class="card-body" id="form_field" style="background-color: #E9FAFD;color:black">
                    <?php if($materials) : ?>
                        <?php foreach($materials as $material) : ?>
                            <div class="row">
                                <input type="text" hidden name="mid[]" value="<?php echo $material->id; ?>">
                                <?php if($material->mcode != NULL) : ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Material Code</label>
                                            <input type="text" class="form-control" style="font-size:12px; background-color:white" name="material_code[]" placeholder="" readonly  value="<?php echo $material->mcode; ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Description</label>
                                        <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="description[]" rows="1" > <?php echo $material->description; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Specification</label>
                                        <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification[]" rows="1" ><?php echo $material->specification; ?></textarea>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder=""   value="<?php echo $material->quantity; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">UOM</label>
                                        <select class="form-control" name="uom[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1">
                                        <option value=" ">Select UOM</option>
                                        <?php if($uoms) : ?>
                                            <?php foreach($uoms as $uom) : ?>
                                                <option value="<?php echo $uom->name; ?>"<?php echo $material->uom == $uom->name ? 'selected' : ''; ?>><?php echo $uom->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Shelf Life (Months)</label>
                                        <input type="number" class="form-control" style="font-size:12px; background-color:white" name="shelf_life[]" placeholder=""  value="<?php echo $material->shelf_life; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Purpose/Remarks</label>
                                        <textarea class="form-control" style="font-size:12px; background-color: white" id="" name="purpose[]" rows="1"><?php echo $material->remarks; ?></textarea>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Item Application</label>
                                        <textarea class="form-control" id="" style="font-size:12px; background-color:white" name="item_application[]" rows="1" ><?php echo $material->item_application; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Required Document</label>
                                        <textarea class="form-control" style="font-size:12px; background-color:white" id="exampleFormControlTextarea1" name="required_document[]" rows="1" ><?php echo $material->required_document; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Material Group</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="material_category[]" style="font-size:12px;height:32px">
                                            <option value="">Select Category</option>
                                            <?php if($material_groups) : ?>    
                                            <?php foreach($material_groups as $material_group) : ?> 
                                                <option value="<?php echo $material_group->name; ?>"<?php echo $material->category == $material_group->name ? 'selected' : ''; ?>><?php echo $material_group->name; ?></option>   
                                            <?php endforeach; ?>    
                                            <?php endif; ?>    
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>File Attachment</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                    <br>
                </div>   
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="Submit Employee Information" class="btn btn-success" onclick="return confirm('Do you want to update data?');" value="UPDATE" >
                </div>
            </center>
        </form>
    </div>
</div>