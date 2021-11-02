<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>SUPPLIER INFORMATION<a href="<?php echo base_url(); ?>procurement/supplier_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">SUPPLIER HISTORY</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Updated Date</th>
                            <th scope="col">Updated By</th>
                            <th scope="col">Supplier Code</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Contact Name</th>
                            <th scope="col">Contact Designation</th>
                            <th scope="col">Contact Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Supplier Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($logs) : ?>
                            <?php foreach($logs as $log) : ?>
                                <tr>
                                    <td><?php echo $log->updated_date;?></td>
                                    <td><?php echo $log->updated_by;?></td>
                                    <td><?php echo $log->scode; ?></td>
                                    <td><?php echo $log->name; ?></td>
                                    <td><?php echo $log->contact_name; ?></td>
                                    <td><?php echo $log->contact_designation; ?></td>
                                    <td><?php echo $log->contact_number; ?></td>
                                    <td><?php echo $log->email; ?></td>
                                    <td><?php echo $log->address; ?></td>
                                    <td><?php echo $log->supplier_profile; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>