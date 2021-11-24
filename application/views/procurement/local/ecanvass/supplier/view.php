<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>SUPPLIER INFORMATION<a href="<?php echo base_url(); ?>procurement/supplier_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">SUPPLIER DETAILS
                <?php if($supplier_logs) : ?>
                    <?php foreach($supplier_logs as $supplier_log) : ?>
                        <?php if($supplier_log->activity_id == $supplier->scode) : ?>
                            <a href="<?php echo base_url(); ?>procurement/supplier_logs/<?php echo $supplier->scode; ?>" target="_blank" id="back" title="View Logs" class="btn btn-sm btn-info float-right d-print-none" style="font-size:12px">View Logs</a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="card-body" style="background-color: #E9FAFD;color:black">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Supplier Code</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->scode; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Supplier Name</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->name; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact Name</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                       <div class="form-group">
                           <div class="form-control" style="font-size:12px"><?php echo $supplier->contact_name;?></div>
                       </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact Designation</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->contact_designation; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact Number</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->contact_number; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->email; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->address; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Supplier Profile</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="form-control" style="font-size:12px"><?php echo $supplier->supplier_profile; ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Attachments</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <td data-label="File"><a href="<?php echo base_url(); ?>procurement/download_attachment/<?php echo $supplier->attachment; ?>"><?php echo $supplier->attachment; ?></a></td>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div> 