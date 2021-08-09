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
            <th scope="col">Reference PR</th>
            <th scope="col">Reference Canvass Request</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="Material"></td>
            <td data-label="Supplier"></td>
            <td data-label="Price"></td>
            <td data-label="Terms"></td>
            <td data-label="Buyer"></td>
            <td data-label="Canvass No."></td>
            <td data-label="Reference PR"></td>
            <td data-label="Reference Canvass Request"></td>
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