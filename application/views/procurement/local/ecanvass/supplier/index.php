<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?>
<div class="card-header" style="background-color: #0C2D48; color: white;">
    <h4>SUPPLIER LIST SUMMARY<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a><a href="<?php echo base_url(); ?>procurement/supplier_add" title="Add Form" class="btn btn-info float-right">ADD</a><a href="<?php echo base_url(); ?>procurement/supplier_import_view" title="Add Form" class="btn btn-info float-right" style="margin-right: 10px">IMPORT</a></h4> 
</div>
<br>
<table id="" class="display table-responsive" style="width:100%;font-size:13px">
    <thead>
        <tr style="background-color:#0D635D;color:white">
            <th scope="col">Vendor Code</th>
            <th scope="col">Supplier Name</th>
            <th scope="col">Contact Name</th>
            <th scope="col">Contact Designation</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Supplier Profile</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($suppliers) : ?>
            <?php foreach($suppliers as $supplier) : ?>
                <tr>
                    <td><?php echo $supplier->scode; ?></td>
                    <td><?php echo $supplier->name;?></td>
                    <td><?php echo $supplier->contact_name;?></td>
                    <td><?php echo $supplier->contact_designation;?></td>
                    <td><?php echo $supplier->contact_number;?></td>
                    <td><?php echo $supplier->email;?></td>
                    <td><?php echo $supplier->address;?></td>
                    <td><?php echo $supplier->supplier_profile;?></td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="View Supplier" href="<?php echo base_url(); ?>procurement/supplier_view/<?php echo $supplier->id;?>">View</a>
                                <a class="dropdown-item" title="Edit Supplier" href="<?php echo base_url(); ?>procurement/supplier_edit/<?php echo $supplier->id; ?>">Edit</a>
                                <a onclick="return confirm('Are you sure you want to delete data?');" title="Delete Supplier" class="dropdown-item" href="<?php echo base_url(); ?>procurement/supplier_delete/<?php echo $supplier->id;?>">Delete</a>
                                <?php if($suppliers_logs) : ?>
                                    <?php foreach($suppliers_logs as $suppliers_log) : ?>
                                        <?php if($suppliers_log->activity_id == $supplier->scode) : ?>
                                            <a class="dropdown-item" title="View Logs" href="<?php echo base_url(); ?>procurement/supplier_logs/<?php echo $supplier->scode; ?>">Logs</a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">  
    $(document).ready(function() {
        $('table.display').DataTable( {
            // "order": [[ 1, 'desc' ]],
            //"bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('table.display', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('table.display'));
            },
            //"scrollY" : '50vh',
            //"scrollX" : true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            dom: 'Blfrtip',
            
            buttons: [
            <?php if($this->session->userdata('access_level_id') == 1 && $this->session->userdata('department_id') == 25) : ?>
                //EXCEL
                {
                    extend: 'excel',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                //PRINT
                {
                    extend: 'print',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                //COPY
                {
                    extend: 'copy',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            <?php endif; ?>  
                //PDF
                {
                    extend: 'pdf',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                //FILTER
                {
                    extend: 'colvis',
                    text: 'Filter'
                }
            ]
        } );
    } );
</script>