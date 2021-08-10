<div class="card-header" style="background-color: #0C2D48; color: white;">
    <h4>SUPPLIER LIST SUMMARY<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a><a href="<?php echo base_url(); ?>procurement/supplier_add" title="Add Form" class="btn btn-info float-right">ADD</a><a href="<?php echo base_url(); ?>procurement/supplier_import_view" title="Add Form" class="btn btn-info float-right" style="margin-right: 10px">IMPORT</a></h4> 
</div>
<br>
<table id="" class="display" style="width:100%;font-size:14px">
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
        <tr>
            <td data-label="Vendor Code"><a href="<?php echo base_url();?>procurement/supplier_view">00001001</a></td>
            <td data-label="Supplier Name">KJ Packaging</td>
            <td data-label="Contact Name">Juan San Miguel</td>
            <td data-label="Contact Designation">Sales & Marketing</td>
            <td data-label="Contact Number">0909092909</td>
            <td data-label="Email">juanmiguel@gmail.com</td>
            <td data-label="Address">San Juan, Manila</td>
            <td data-label="Supplier Profile">Lorem Ipsum</td>
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/supplier_view">View</a>
                        <a class="dropdown-item" title="Edit Request" href="<?php echo base_url(); ?>procurement/supplier_edit">Edit</a>
                        <a class="dropdown-item" title="Delete Request" href="">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td data-label="Vendor Code"><a href="<?php echo base_url();?>procurement/supplier_view">00001002</a></td>
            <td data-label="Supplier Name">ABC Consumables</td>
            <td data-label="Contact Name">Louis Ruiz</td>
            <td data-label="Contact Designation">Sales</td>
            <td data-label="Contact Number">0921092909</td>
            <td data-label="Email">ruiz.louis@gmail.com</td>
            <td data-label="Address">Malate, Manila</td>
            <td data-label="Supplier Profile">Lorem Ipsum</td>
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/supplier_view">View</a>
                        <a class="dropdown-item" title="Edit Request" href="<?php echo base_url(); ?>procurement/supplier_edit">Edit</a>
                        <a class="dropdown-item" title="Delete Request" href="">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td data-label="Vendor Code"><a href="<?php echo base_url();?>procurement/supplier_view">00001002</a></td>
            <td data-label="Supplier Name">JGC Chemicals</td>
            <td data-label="Contact Name">Karleen Gregorio</td>
            <td data-label="Contact Designation">Sales</td>
            <td data-label="Contact Number">0990092909</td>
            <td data-label="Email">kgregorio@gmail.com</td>
            <td data-label="Address">Richville, Alabang, Muntinlupa</td>
            <td data-label="Supplier Profile">Lorem Ipsum</td>
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/supplier_view">View</a>
                        <a class="dropdown-item" title="Edit Request" href="<?php echo base_url(); ?>procurement/supplier_edit">Edit</a>
                        <a class="dropdown-item" title="Delete Request" href="">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
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