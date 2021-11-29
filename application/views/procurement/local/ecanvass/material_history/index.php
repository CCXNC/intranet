<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>MATERIAL CANVASS HISTORY<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4> 
</div>
<br>
<table id="" class="display table-responsive" style="width:100%; font-size:13px">
    <thead>
        <tr style="background-color:#0D635D;color:white">
            <th scope="col">Canvass Date</th>
            <th scope="col">Material</th>
            <th scope="col">Quantity</th>
            <th scope="col">Uom</th>
            <th scope="col">Currency</th>
            <th scope="col">Prev Purchase Unit</th>
            <th scope="col">Year</th>

            <th scope="col">Supplier Name</th>
            <th scope="col">Moq</th>
            <th scope="col">Terms</th>
            <th scope="col">Price Per Unit</th>
            <th scope="col">Total Price</th>
            <th scope="col">Buyer</th>

            <th scope="col">PR No.</th>
            <th scope="col">Material Source No.</th>
            <th scope="col">Canvass No.</th>
            
            <th>Attachment</th>
        </tr>
    </thead>
    <tbody>
        <?php if($materials) : ?>
            <?php foreach($materials as $material) : ?>
                <tr>
                    <td data-label="Canvass Date"><?php echo date('Y-m-d', strtotime($material->canvass_date)); ?></td>
                    <td data-label="Material"><?php echo $material->material_name; ?></td>
                    <td data-label="Quantity"><?php echo $material->quantity; ?></td>
                    <td data-label="Uom"><?php echo $material->uom; ?></td>
                    <td data-label="currency"><?php echo $material->currency; ?></td>
                    <td data-label="prev_purchase_unit"><?php if($material->prev_purchase_unit != 0) { $prev_purchase_unit = number_format($material->prev_purchase_unit, 2, '.',','); echo $prev_purchase_unit; } else { echo '-'; } ?></td>
                    <td data-label="year"><?php if($material->year != 0) { echo $material->year; } else { echo '-'; }?></td>
                    <td data-label="Supplier"><?php echo $material->supplier_name; ?></td>
                    <td data-label="Moq"><?php echo $material->moq; ?></td>
                    <td data-label="Terms"><?php echo $material->terms; ?></td>
                    <td data-label="price_per_unit"><?php $price_per_unit = number_format($material->price_per_unit, 2, '.',','); echo $price_per_unit; ?></td>
                    <td data-label="Total Price">
                        <?php 
                            $computation = $material->price_per_unit * $material->quantity;
                            $total_price = number_format($computation, 2, '.',',');   
                            echo $total_price;               
                        ?>
                    </td>
                   
                    <td data-label="Buyer"><?php echo $material->buyer_name; ?></td>
                    <td data-label="Reference PR"><?php echo $material->pr_no; ?></td>
                    <td data-label="Material Source No"> 
                        <?php if($material->msid != NULL) : ?>
                            <a href="<?php echo base_url(); ?>procurement/material_sourcing_view/<?php echo $material->idms; ?>/<?php echo $material->msid; ?>"><?php echo $material->msid; ?></a>
                        <?php else : ?>
                            <?php echo '-'; ?>
                        <?php endif; ?>
                    </td>
                    <td data-label="Canvass No"><a href="<?php echo base_url(); ?>procurement/comparative_quotations/<?php echo $material->canvass_no; ?>"><?php echo $material->canvass_no; ?></a></td>
                    <td><p><a href="<?php echo base_url(); ?>procurement/download_supplier_matertial_attachment/<?php echo $material->attachment; ?>"><?php if($material->attachment != NULL) { echo "Download"; } ?></a></p></td>
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
            "pageLength": 50,
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