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
                                <?php $obj = json_decode($log->datas); ?>
                                <tr>
                                    <td><?php echo $log->created_date; ?></td>
                                    <td><?php echo $log->created_by; ?></td>
                                    <td><?php echo $obj->{'scode'}; ?></td>
                                    <td><?php echo $obj->{'name'}; ?></td>
                                    <td><?php echo $obj->{'contact_name'}; ?></td>
                                    <td><?php echo $obj->{'contact_designation'}; ?></td>
                                    <td><?php echo $obj->{'contact_number'}; ?></td>
                                    <td><?php echo $obj->{'email'}; ?></td>
                                    <td><?php echo $obj->{'address'}; ?></td>
                                    <td><?php echo $obj->{'supplier_profile'}; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>