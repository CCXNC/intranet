<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>CANVASS LIST<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a></h4> 
</div>
<br>
<div class="row">
    <div class="col-md-3">
        <div class="card" style="font-size:12px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center">COST SAVING
            </div>
            <div class="card-body" style="background-color:#5488A5; color: white; border-radius: 2px;text-align:center; ">15,000
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center">COST AVOIDANCE
            </div>
            <div class="card-body" style="text-align:center;background-color:#5DBDEA; color: white; border-radius: 2px;">20,000
            </div>
        </div>
    </div>
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Canvass No.</th>
            <th scope="col">Canvass Date</th>
            <th scope="col">Company</th>
            <th scope="col">Cost Saving</th>
            <th scope="col">Cost Avoidance</th>
            <th scope="col">Buyer</th>
            <th scope="col">Reference PR</th>
            <th scope="col">Reference Canvass Request</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="Business Unit"></td>
            <td data-label="Date"></td>
            <td data-label="Department"></td>
            <td data-label="Department"></td>
            <td data-label="Date Hired"></td>
            <td data-label="Date Hired"></td>
            <td data-label="Proposal"></td>
            <td data-label="Status"></td>
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