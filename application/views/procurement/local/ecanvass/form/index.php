<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>ELECTRONIC MATERIAL SOURCING REQUEST LIST<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a><a href="<?php echo base_url(); ?>procurement/form_add" title="Add Form" class="btn btn-info float-right">ADD</a></h4> 
</div>
<br>
<div class="row" style="font-size:14px">
    <div class="col-md-2">
        <div class="card" style="line-height:13px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; font-size:12px; padding-bottom:24.5px; ">
                STATUS AS OF:
            </div>
            <div class="card-body" style="background-color:#A3C4C3; color: white; border-radius: 2px; text-align: center">
                <?php echo date("d-M-y")?>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card" style="line-height:13px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; font-size:12px; padding-bottom:24.5px; ">
                OPEN
            </div>
            <div class="card-body" style="background-color:#FAD02C; color: white; border-radius: 2px; text-align: center">
                15
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card" style="line-height:13px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; font-size:12px; padding-bottom:24.5px; ">
                PENDING
            </div>
            <div class="card-body" style="background-color:#E12A2A; color: white; border-radius: 2px; text-align: center">
                20
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card" style="line-height:13px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; font-size:12px; padding-bottom:24.5px; ">
                CLOSED
            </div>
            <div class="card-body" style="background-color:#469A49; color: white; border-radius: 2px; text-align: center">
                115
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card" style="line-height:13px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; font-size:12px">
                AVERAGE CT<br>APPROVER
            </div>
            <div class="card-body" style="background-color:#5DBDEA; color: white; border-radius: 2px; text-align: center">
                2 Days
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card" style="line-height:13px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; font-size:12px">
                AVERAGE CT PROCUREMENT
            </div>
            <div class="card-body" style="background-color:#5488A5; color: white; border-radius: 2px; text-align: center">
                5 Days
            </div>
        </div>
    </div>
</div>
<br>
<table id="" class="display" style="width:100%; font-size:14px">
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
            <td data-label="Reference No."><a href="<?php echo base_url();?>procurement/form_view">00001001</a></td>
            <td data-label="Date Requested">21-Jul-2021</td>
            <td data-label="Date Required">30-Jul-2021</td>
            <td data-label="Requestor">Kirsten Mondreal</td>
            <td data-label="Department">Finance</td>
            <td data-label="No. of Items">5 Bag/s</td>
            <td data-label="Ageing">7 Days</td>
            <td data-label="Status" style="background-color:#E12A2A">Pending</td>
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/form_view">View</a>
                        <a class="dropdown-item" title="Edit Request" href="<?php echo base_url(); ?>procurement/form_edit">Edit</a>
                        <a class="dropdown-item" title="Delete Request" href="">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td data-label="Reference No."><a href="<?php echo base_url();?>procurement/form_view">00001002</a></td>
            <td data-label="Date Requested">21-Jul-2021</td>
            <td data-label="Date Required">30-Jul-2021</td>
            <td data-label="Requestor">Primo Javelona</td>
            <td data-label="Department">HRAD</td>
            <td data-label="No. of Items">2 Pack/s</td>
            <td data-label="Ageing">7 Days</td>
            <td data-label="Status" style="background-color:#FAD02C">Open</td>
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" style="font-size:14px" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" >
                        <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/form_view">View</a>
                        <a class="dropdown-item" title="Edit Request" href="<?php echo base_url(); ?>procurement/form_edit">Edit</a>
                        <a class="dropdown-item" title="Delete Request" href="">Delete</a>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td data-label="Reference No."><a href="<?php echo base_url();?>procurement/form_view">00001003</a></td>
            <td data-label="Date Requested">21-Jul-2021</td>
            <td data-label="Date Required">30-Jul-2021</td>
            <td data-label="Requestor">Andre Alcantara</td>
            <td data-label="Department">IT</td>
            <td data-label="No. of Items">2 Piece/s</td>
            <td data-label="Ageing">7 Days</td>
            <td data-label="Status" style="background-color:#469A49">Closed</td>
            <td data-label="Action">
                <div class="btn-group">
                    <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/form_view">View</a>
                        <a class="dropdown-item" title="Edit Request" href="<?php echo base_url(); ?>procurement/form_edit">Edit</a>
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