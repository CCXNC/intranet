<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>COST SAVING / AVOIDANCE REPORT SUMMARY</h4> 
</div>
<br>
<div class="row">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 14px; text-align: center">COST SAVING</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">Jul 26, 2021</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 14px; text-align: center">COST AVIODANCE</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">15</p>
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