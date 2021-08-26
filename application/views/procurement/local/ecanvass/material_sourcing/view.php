<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>ELECTRONIC MATERIAL SOURCING REQUEST<a href="<?php echo base_url(); ?>procurement/material_sourcing_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body" style="font-size:12px">
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
                        <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white; font-size:12px" readonly value="<?php echo $material_source->msid; ?>">
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
                            <?php if($material->mcode != NULL) : ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Material Code</label>
                                        <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly  value="<?php echo $material->mcode; ?>">
                                    </div>
                                </div>
                            <?php endif; ?>    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Description</label>
                                    <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="description[]" rows="1" readonly> <?php echo $material->description; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Specification</label>
                                    <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification[]" rows="1" readonly><?php echo $material->specification; ?></textarea>
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly  value="<?php echo $material->quantity; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">UOM</label>
                                    <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly value="<?php echo $material->uom; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Shelf Life (Months)</label>
                                    <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly value="<?php echo $material->shelf_life; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Purpose/Remarks</label>
                                    <textarea class="form-control" style="font-size:12px; background-color: white" id="" name="purpose[]" rows="1" readonly><?php echo $material->remarks; ?></textarea>
                                </div>
                            </div>
                       
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Item Application</label>
                                    <textarea class="form-control" id="" style="font-size:12px; background-color:white" name="item_application[]" rows="1" readonly><?php echo $material->item_application; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Required Document</label>
                                    <textarea class="form-control" style="font-size:12px; background-color:white" id="exampleFormControlTextarea1" name="required_document[]" rows="1" readonly><?php echo $material->required_document; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Material Category</label>
                                    <input type="text" class="form-control" style="font-size:12px; background-color:white" name="quantity[]" placeholder="" readonly value="<?php echo $material->category; ?>">
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
            </div>
            <br>
            <table class="table table-bordered" style="font-size:12px; line-height:13px;">
                <thead>
                    <tr style="background-color: #0D635D; color: white;">
                    <th scope="col">Step/Approver</th>
                    <th scope="col">Primary Approver</th>
                    <th scope="col">Alternate Approver</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Sign-off</th>
                    <th scope="col">Date CT</th>
                    <th scope="col">Sign-off By</th>
                    <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <?php if($approval_lists) : ?>
                    <?php foreach($approval_lists as $approval_list) : ?>
                        <tr>
                            <th scope="row" style="background-color: #0C2D48; color:white"><?php echo $approval_list->step_of_approval; ?></th>
                            <td><?php echo $approval_list->primary_approver; ?></td>
                            <td><?php echo $approval_list->alternate_approver; ?></td>
                            <td><?php echo $approval_list->status; ?></td>
                            <td><?php echo $approval_list->signoff_date; ?></td>
                            <td><?php echo ' ' ?></td>
                            <td><?php echo $approval_list->signoff_by; ?></td>
                            <td><?php echo $approval_list->remarks; ?></td>
                        </tr>
                    
                    <?php endforeach; ?>
                <?php endif; ?>
            
            </table>
            <br>
            <?php //echo $material_source->emp_access; ?>
            <?php if($this->session->userdata('fullname') == $last_entry->primary_approver || $this->session->userdata('fullname') == $last_entry->alternate_approver) : ?>
                <form method="post" action="<?php echo base_url(); ?>procurement/materialsource_approval_process" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">APPROVAL DETAILS</div>
                        <div class="card-body" style="background-color: #E9FAFD">
                            <div class="row">
                                <?php $data_explod = explode(' ', $material_source->role_status); ?>
                                <input type="text" hidden name="primary_approver_superior" value="<?php echo $material_source->primary_approver; ?>">
                                <input type="text" hidden name="alternate_approver_superior" value="<?php echo $material_source->alternate_approver; ?>">
                                <input type="text" hidden name="request_approver" value="<?php echo $data_explod[1]; ?>">
                                <input type="text" hidden name="msid" value="<?php echo $material_source->msid; ?>">

                                <input type="text" hidden name="primary_approver" value="<?php echo $first_entry->primary_approver; ?>">
                                <input type="text" hidden name="alternate_approver" value="<?php echo $first_entry->alternate_approver; ?>">
                               

                                <input type="text" hidden name="id" value="<?php echo $last_entry->id; ?>">
                                <input type="text" hidden name="role_status" value="<?php echo $last_entry->role_status; ?>">
                                <input type="text" hidden name="primary_approver1" value="<?php echo $last_entry->primary_approver; ?>">
                                <input type="text" hidden name="alternate_approver1" value="<?php echo $last_entry->alternate_approver; ?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sign Off:</label>
                                        <br>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                                    <input class="form-check-input" type="radio" name="approve_detail" id="flexRadioDefault1" value="1" checked>
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        <p style="border-radius: 5px; border: 2px solid #469A49; background-color:#469A49;padding:2px; color:white">Approve</p>
                                                    </label>
                                                </div>
                                                <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                                    <input class="form-check-input" type="radio" name="approve_detail" id="flexRadioDefault1" value="2">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        <p style="border-radius: 5px; border: 2px solid #E12A2A; background-color:#E12A2A;padding:2px; color:white">Disapprove</p>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="approve_detail" id="flexRadioDefault2" value="3">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        <p style="border-radius: 5px; border: 2px solid #FAD02C; background-color:#FAD02C;padding:2px; color:white">Action Required</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" id="" style="font-size:12px; background-color:white" name="remarks" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <br>
                    <center>
                        <div class="form-group">
                            <input type="submit" title="Submit Employee Information" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                        </div>
                    </center>
                </form>    
            <?php endif; ?>    
        </div>
    </div>
</div>