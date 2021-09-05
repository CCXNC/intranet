<style>
    .printMe {
        display: none;
    }
    @media print {
        div {
            display: none;
        }
        .printMe {
            display: block;
        }
    }
    .tbrow{
        background-color:#0D635D !important;
        -webkit-print-color-adjust: exact;
        color: white; 
    }
    .throw{
       background-color: #0C2D48 !important; 
       -webkit-print-color-adjust: exact;
       color:white;
    }
    /*.print{
        background-image: url(<?php echo base_url(); ?>assets/images/watermark.png);
    }*/
</style>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<div class="card" id="printableArea">
    <p style="text-align:center" class="printMe"><img class="card-img-top" style="width:40%" src="<?php echo base_url(); ?>assets/images/header.png" alt=""></p>
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>ELECTRONIC MATERIAL SOURCING REQUEST<a href="<?php echo base_url(); ?>procurement/material_sourcing_index" id="back" title="Go Back" class="btn btn-info float-right d-print-none" style="margin-right:10px;">BACK</a><button type="button" style="margin-right:5px;" class="btn btn-info float-right d-print-none" onclick="printDiv('printableArea')" value="print a div!">PRINT</button></h4></div>
    <div class="card-body" style="font-size:12px">
        <div class="card" >
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
            <div class="card-body" style="background-color: #E9FAFD;color:black">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label><b>Business Unit:</b></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php echo $material_source->company_name; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Material Source ID:</b></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <p><?php echo $material_source->msid; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Sourcing Category:</b></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <p><?php echo $material_source->category; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Date Required:</b></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php echo $material_source->date_required; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><b>Material Source Request Date:</b></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php echo date('Y-m-d', strtotime($material_source->created_date)); ?></p>
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
                                        <label><b>Material Code:</b></label>
                                        <p><?php echo $material->mcode; ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"><b>Description:</b></label>
                                    <p><?php echo $material->description; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"><b>Specification:</b></label>
                                    <p><?php echo $material->specification; ?></p>
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Quantity:</b></label>
                                    <p><?php echo $material->quantity; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1"><b>UOM:</b></label>
                                    <p><?php echo $material->uom; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>Shelf Life (Months):</b></label>
                                    <p><?php echo $material->shelf_life; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"><b>Purpose/Remarks:</b></label>
                                    <p><?php echo $material->remarks; ?></p>
                                </div>
                            </div>
                       
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"><b>Item Application:</b></label>
                                    <p><?php echo $material->item_application; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"><b>Required Document:</b></label>
                                    <p><?php echo $material->required_document; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1"><b>Material Category:</b></label>
                                    <p><?php echo $material->category; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><b>File Attachment:</b></label>
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
                    <tr class="tbrow">
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
                            <th scope="row" class="throw"><?php echo $approval_list->step_of_approval; ?></th>
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
            <p class="printMe">
                Printed By: <?php echo $this->session->userdata('fullname'); ?> <br>
                Date:
                <?php 
                    date_default_timezone_set('Asia/Singapore'); 
                    echo $date = date('Y-m-d H:i:s');
                ?>
            </p>
            <br>
            <?php //echo $material_source->emp_access; ?>
            <?php if($this->session->userdata('fullname') == $last_entry->primary_approver || $this->session->userdata('fullname') == $last_entry->alternate_approver) : ?>
                <form class="d-print-none" method="post" action="<?php echo base_url(); ?>procurement/materialsource_approval_process" enctype="multipart/form-data">
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