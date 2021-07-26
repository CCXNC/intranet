<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>MATERIAL SOURCING LIST<a href="<?php echo base_url(); ?>procurement/form_add" title="Add Form" class="btn btn-info float-right">ADD</a></h4> 
</div>
<br>
<div class="row">
    <div class="col-md-2">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 12px; text-align: center">STATUS AS<br>OF:</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">Jul 26, 2021</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 12px; text-align: center">OPEN</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">15</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 12px; text-align: center">PENDING</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">20</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 12px; text-align: center">CLOSE</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">115</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 12px; text-align: center">AVERAGE CT APPROVER</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">2 Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card h-100">
            <div class="card-header h-100" style="background-color: #0C2D48; color: white;">
                <p style="font-size: 12px; text-align: center">AVERAGE CT PROCUREMENT</p>
            </div>
            <div class="card-body">
                <p style="text-align:center">5 Days</p>
            </div>
        </div>
    </div>
</div>
<br>
<table id="" class="display" style="width:100%">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Reference No.</th>
            <th scope="col">Date Requested</th>
            <th scope="col">Date Required</th>
            <th scope="col">Requestor</th>
            <th scope="col">Department</th>
            <th scope="col">No.of Items</th>
            <th scope="col">Ageing</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
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
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="View Idea" href=""> View</a>
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