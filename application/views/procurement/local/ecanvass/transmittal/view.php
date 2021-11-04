<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>TRANSMITTAL INFORMATION<a href="<?php echo base_url(); ?>procurement/transmittal_list" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">TRANSMITTAL DETAILS</div>
            <div class="card-body" style="background-color: #E9FAFD;color:black">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>Material Source ID</b></label>
                            <p><?php echo $transmittal_lists->msid; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>Material Source Request Date</b></label>
                            <p><?php echo date('Y-m-d', strtotime($transmittal_lists->ms_request_date)); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>Company</b></label>
                            <p><?php echo $transmittal_lists->company; ?></p>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
            <div class="card-body" style="background-color: #E9FAFD;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>To Requestor</b></label>
                            <p><?php echo $transmittal_lists->requestor; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>Transmittal Date</b></label>
                            <p><?php echo date('Y-m-d', strtotime($transmittal_lists->transmittal_date)); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>Email</b> </label>
                            <p><?php echo $transmittal_lists->email; ?></p>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label ><b>File Attachment</b></label><br>
                            <p><a href="<?php echo base_url(); ?>procurement/download_transmittal_attachment/<?php echo $transmittal_lists->attachment; ?>"><?php echo $transmittal_lists->attachment; ?></a></p>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <br>
        <div class="card">
            <div class="card-body" style="background-color: #E9FAFD;">
                <table id="" class="table table-striped"  style="width:100%">
                    <thead>
                        <tr style="background-color:#0D635D; color:white;">
                            <th scope="col">Material Description</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Batch Number</th>
                            <th scope="col">Supporting Documents</th>
                            <th scope="col">Status</th>
                            <th scope="col">PIC</th>
                        </tr>
                    </thead>
                    <?php if($transmittal_materials) : ?>
                        <?php foreach($transmittal_materials as $transmittal_material) : ?>
                            <tr>
                                <td><?php echo $transmittal_material->description; ?></td>
                                <td><?php echo $transmittal_material->supplier_name; ?></td>
                                <td><?php echo $transmittal_material->batch_number; ?></td>
                                <td><a href="<?php echo base_url(); ?>procurement/download_transmittal_attachment/<?php echo $transmittal_material->attachment; ?>"><?php echo $transmittal_material->attachment; ?></a></td>
                                <td><?php if($transmittal_material->status == NULL) { echo '-';} else { if($transmittal_material->status == 1) { echo 'Passed'; } elseif($transmittal_material->status == 0) { echo 'Failed';} } ?></td>
                                <td><?php echo $transmittal_material->updated_by; ?></td>
                            </tr>
                        
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>