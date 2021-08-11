<div class="card-header" style="background-color: #0C2D48; color: white;">
    <h4>SUPPLIER LIST SUMMARY<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a><a href="<?php echo base_url(); ?>procurement/supplier_add" title="Add Form" class="btn btn-info float-right">ADD</a><a href="<?php echo base_url(); ?>procurement/supplier_import_view" title="Add Form" class="btn btn-info float-right" style="margin-right: 10px">IMPORT</a></h4> 
</div>
<br>
<table id="" class="display table-responsive" style="width:100%;font-size:14px">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Supplier Code</th>
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
                                <a class="dropdown-item" title="View Idea" href="<?php echo base_url(); ?>procurement/supplier_view"> View</a>
                                <a class="dropdown-item" title="Edit Supplier" href="<?php echo base_url(); ?>procurement/supplier_edit">Edit</a>
                                <a class="dropdown-item" title="Delete Supplier" href="">Delete</a>
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
                {
                    extend: 'excel',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    title: 'E-Canvass',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Filter'
                }
            ]
        } );
    } );
</script>