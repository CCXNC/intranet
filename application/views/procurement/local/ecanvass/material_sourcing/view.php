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

    function toggle(ele) {
        var cont = document.getElementById('comprecom');
        if (cont.style.display == 'block') {
            cont.style.display = 'none';

            document.getElementById(ele.id).value = 'Show Material Details History';
        }
        else {
            cont.style.display = 'block';
            document.getElementById(ele.id).value = 'Hide Material Details History';
        }
    }
</script>
<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
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
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-info float-right d-print-none" data-toggle="modal" data-target="#request" style="margin-left:3px">
                            <span class="fa fa-pencil"></span>
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-lg" id="request" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Request Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="<?php echo base_url(); ?>procurement/update_material_sourcing/<?php echo $material_source->id; ?>/<?php echo $material_source->msid; ?>" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group ">
                                                    <label><b>Business Unit:</b></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select class="form-control" style="font-size:12px" name="company_id" id="">
                                                        <option value="1"<?php echo $material_source->code == 'RRLC' ? 'selected' : ' '; ?>>RRLC</option>
                                                        <option value="2"<?php echo $material_source->code == 'BMC' ? 'selected' : ' '; ?>>BMC</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><b>Sourcing Category:</b></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select class="form-control" name="sourcing_category" style="font-size:12px;height:32px">
                                                        <option value="Price Only"<?php echo $material_source->category == "Price Only" ? 'selected' : ' '; ?>>Price Only</option>
                                                        <option value="Sample Only"<?php echo $material_source->category == "Sample Only" ? 'selected' : ' '; ?>>Sample Only</option>
                                                        <option value="Price w/ Sample"<?php echo $material_source->category == "Price w/ Sample" ? 'selected' : ' '; ?>>Price w/ Sample</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><b>Date Required:</b></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input name="date_required" type="date" class="form-control" id="date_required" value="<?php echo $material_source->date_required; ?>" style="font-size:12px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Do you want to update data?');" value="Update">
                                    </div>
                                </form>  
                            </div>
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
                                    <p><a href="<?php echo base_url(); ?>procurement/download_material_attachment/<?php echo $material->attachment; ?>"><?php echo $material->attachment; ?></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-info float-right d-print-none" data-toggle="modal" data-target="#material<?php echo $material->id;?>" style="margin-left:3px">
                                    <span class="fa fa-pencil"></span>
                                </button>
                                <a href="<?php echo base_url(); ?>procurement/delete_material_sourcing_list/<?php echo $material->id; ?>/<?php echo $material_source->id; ?>/<?php echo $material_source->msid; ?>" title="Delete Form" onclick="return confirm('Are you sure you want to delete data?');" class="btn btn-sm btn-danger float-right d-print-none" style=""><span class="fa fa-trash"></span></a>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="material<?php echo $material->id;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Material Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="<?php echo base_url(); ?>procurement/update_material_sourcing_list/<?php echo $material->id; ?>/<?php echo $material_source->id; ?>/<?php echo $material_source->msid; ?>" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <?php if($material->mcode != NULL) : ?>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label><b>Material Code:</b></label>
                                                                <input type="text" class="form-control" id="myTextbox" readonly id="check" name="material_code" placeholder="" style="font-size:12px" value="<?php echo $material->mcode;?>">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>    
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1"><b>Description:</b></label>
                                                            <input type="text" class="form-control"  id="description" readonly name="description" placeholder="" style="font-size:12px" value="<?php echo $material->description;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1"><b>Specification:</b></label>
                                                            <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification" rows="1" value=""><?php echo $material->specification;?></textarea>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><b>Quantity:</b></label>
                                                            <input type="number" class="form-control" name="quantity" placeholder="" style="font-size:12px" value="<?php echo $material->quantity;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1"><b>UOM:</b></label>
                                                            <input type="text" class="form-control" name="uom" placeholder="" style="font-size:12px" value="<?php echo $material->uom;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><b>Shelf Life (Months):</b></label>
                                                            <input type="number" class="form-control" name="shelf_life" placeholder="" style="font-size:12px" value="<?php echo $material->shelf_life;?>"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1"><b>Purpose/Remarks:</b></label>
                                                            <textarea class="form-control" style="font-size:12px" id="" name="purpose" rows="1"><?php echo $material->remarks;?></textarea>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1"><b>Item Application:</b></label>
                                                            <textarea class="form-control" id="" style="font-size:12px" name="item_application" rows="1"><?php echo $material->item_application; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1"><b>Required Document:</b></label>
                                                            <textarea class="form-control" style="font-size:12px" id="exampleFormControlTextarea1" name="required_document" rows="1"><?php echo $material->required_document;?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1"><b>Material Category:</b></label>
                                                            <input type="text" class="form-control"  id="materialGroup" readonly name="material_category" placeholder="" style="font-size:12px" value="<?php echo $material->category;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label><b>File Attachment:</b></label>
                                                            <input type='file' name='attachment' size='20' />
                                                            <?php echo $material->attachment;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Do you want to update data?');" value="Update">
                                            </div>
                                        </form>    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                </div>    
            </div>
            <br>

            <!-- History -->
            <p>
                <input class="btn btn-sm btn-success d-print-none" type="button" value="Show Material Details History" id="bt" onclick="toggle(this)">
            </p>
            <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center; display:none" id="comprecom">
                <thead>
                    <tr>
                        <th scope="col" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Date Updated</th>
                        <th scope="col" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Updated Data</th>
                        <th scope="col" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Updated By</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #E9FAFD;color:black">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <!-- Step of Approver -->
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
            <?php if($last_entry->step_approval == 4 && $last_entry->role_status == "Procurement") : ?>
                <?php if($this->session->userdata('fullname') == $last_entry->primary_approver || $this->session->userdata('fullname') == $last_entry->alternate_approver) : ?>
                    <div class="card d-print-none">
                        <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">REPORT GENERATION</div>
                        <div class="card-body" style="background-color: #E9FAFD">
                            <div class="row">
                                <!--<div class="col-md-12">
                                    <table class="table table-bordered" style="font-size:12px; line-height:13px;">
                                        <tr>
                                            <th scope="row" class="throw" style="width:20%">Canvass No.</th>
                                            <?php if($canvass_lists) : ?>
                                                <?php foreach($canvass_lists as $canvass_list) : ?>
                                                    <td><?php echo $canvass_list->canvass_no; ?></td>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="throw" style="width:20%">Transmittal No.</th>
                                            <?php if($transmittal_lists) : ?>
                                                <?php foreach($transmittal_lists as $transmittal_list) : ?>
                                                    <td><?php echo $transmittal_list->transmittal_no; ?></td>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tr>
                                    </table>
                                </div>--> 
                                <div class="col-md-6">
                                    <table class="table table-bordered" style="font-size:12px; line-height:13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="background-color: #0C2D48; color:white">Transmittal No.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($transmittal_lists) : ?>
                                                <?php foreach($transmittal_lists as $transmittal_list) : ?>
                                                    <tr>
                                                        <td><?php echo $transmittal_list->transmittal_no; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered" style="font-size:12px; line-height:13px;">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="background-color: #0C2D48; color:white">Canvass No.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($canvass_lists) : ?>
                                                <?php foreach($canvass_lists as $canvass_list) : ?>
                                                    <tr>
                                                        <td><?php echo $canvass_list->canvass_no; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Paid sample only: Cannot provide sample
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Remarks:</label>
                                        <textarea class="form-control" id="" style="font-size:12px; background-color:white" name="remarks" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <div class="form-group">
                                    <input type="submit" title="Submit Employee Information" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                                </div>
                            </center>
                        </div>  
                    </div> 
                <?php endif; ?>     
            <?php else : ?>  
                <?php if($this->session->userdata('fullname') == $last_entry->primary_approver || $this->session->userdata('fullname') == $last_entry->alternate_approver) : ?>
                    <form class="d-print-none" method="post" action="<?php echo base_url(); ?>procurement/materialsource_approval_process" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">APPROVAL DETAILS</div>
                            <div class="card-body" style="background-color: #E9FAFD">
                                <div class="row">

                                    <!-- Get material details for email -->
                                    <input type="text" hidden name="source_id" value="<?php echo $material_source->id; ?>">
                                    <input type="text" hidden name="company" value="<?php echo $material_source->company_name; ?>">
                                    <input type="text" hidden name="category" value="<?php echo $material_source->category; ?>">
                                    <input type="text" hidden name="date_required" value="<?php echo $material_source->date_required; ?>">
                                    <input type="text" hidden name="date_requested" value="<?php echo date('Y-m-d', strtotime($material_source->created_date)); ?>">
                                    <input type="text" hidden name="email_accounts" value="<?php echo $material_source->email; ?>">
                                    <!-- End of get material details for email -->

                                    <?php $data_explod = explode(' ', $material_source->role_status); ?>
                                    <input type="text" hidden name="primary_approver_superior" value="<?php echo $material_source->primary_approver; ?>">
                                    <input type="text" hidden name="alternate_approver_superior" value="<?php echo $material_source->alternate_approver; ?>">
                                    <input type="text" hidden name="request_approver" value="<?php echo $data_explod[1]; ?>">
                                    <input type="text" hidden name="msid" value="<?php echo $material_source->msid; ?>">

                                    <input type="text" hidden name="primary_approver" value="<?php echo $first_entry->primary_approver; ?>">
                                    <input type="text" hidden name="alternate_approver" value="<?php echo $first_entry->alternate_approver; ?>">
                                    <input type="text" hidden name="req_signoff_by" value="<?php echo $first_entry->signoff_by; ?>">
                                    <input type="text" hidden name="req_remarks" value="<?php echo $first_entry->remarks; ?>">

                                    <input type="text" hidden name="id" value="<?php echo $last_entry->id; ?>">
                                    <input type="text" hidden name="role_status" value="<?php echo $last_entry->role_status; ?>">
                                    <input type="text" hidden name="primary_approver1" value="<?php echo $last_entry->primary_approver; ?>">
                                    <input type="text" hidden name="alternate_approver1" value="<?php echo $last_entry->alternate_approver; ?>">

                                    <?php $destination_approval = explode(' ', $last_entry->created_by); ?>
                                    <?php if($destination_approval[1] != null) : ?>
                                        <input type="text" hidden name="destination_approval" value="<?php echo $destination_approval[1]; ?>">
                                    <?php endif; ?>
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

            <?php endif; ?>  
             
        </div>
    </div>
</div>