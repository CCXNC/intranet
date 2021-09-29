<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>MATERIAL CANVASS HISTORY<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4> 
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Material</th>
            <th scope="col">Supplier</th>
            <th scope="col">Price</th>
            <th scope="col">Terms</th>
            <th scope="col">Buyer</th>
            <th scope="col">Canvass No.</th>
            <th scope="col">PR No.</th>
            <th scope="col">Material Source No.</th>
        </tr>
    </thead>
    <tbody>
        <?php if($materials) : ?>
            <?php foreach($materials as $material) : ?>
                <tr>
                    <td data-label="Material"><?php echo $material->material_name; ?></td>
                    <td data-label="Supplier"><?php echo $material->supplier_name; ?></td>
                    <td data-label="Price"><?php echo $material->total_price; ?></td>
                    <td data-label="Terms"><?php echo $material->terms; ?></td>
                    <td data-label="Buyer"><?php echo $material->buyer_name; ?></td>
                    <td data-label="Canvass No."><?php echo $material->canvass_no; ?></td>
                    <td data-label="Reference PR"><?php echo $material->pr_no; ?></td>
                    <td data-label="Reference Canvass Request"><?php echo $material->msid; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif;  ?>
       
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