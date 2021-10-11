<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>CANVASS LIST<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a></h4> 
</div>
<br>
<div class="row">
    <div class="col-md-3">
        <div class="card" style="font-size:12px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center">NET COST SAVING
            </div>
            <div class="card-body" style="background-color:#5488A5; color: white; border-radius: 2px;text-align:center; "><?php $net_cost_saving = number_format($net_cost_saving->net_cost_saving, 2, '.', ','); echo $net_cost_saving; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center">COST SAVING (+)
            </div>
            <div class="card-body" style="background-color:#469A49; color: white; border-radius: 2px;text-align:center; "><?php $cost_saving = number_format($cost_saving->cost_saving, 2, '.', ','); echo $cost_saving; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center">COST SAVING (-)
            </div>
            <div class="card-body" style="background-color:#A3C4C3; color: white; border-radius: 2px;text-align:center; "><?php $cost_saving_negative = number_format($cost_saving_negative->cost_saving, 2, '.', ','); echo $cost_saving_negative; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center">COST AVOIDANCE
            </div>
            <div class="card-body" style="text-align:center;background-color:#5DBDEA; color: white; border-radius: 2px;"><?php $cost_avoidance= number_format($net_cost_avoidance->total_saving, 2, '.', ','); echo $cost_avoidance; ?>
            </div>
        </div>
    </div>
</div>
<br>

<table id="" class="display" style="width:100%; font-size:13px;">
    <thead>
        <tr style="background-color:#D4F1F4;">
            <th scope="col">Canvass No.</th>
            <th scope="col">Canvass Date</th>
            <th scope="col">Company</th>
            <th scope="col">Cost Saving</th>
            <th scope="col">Cost Avoidance</th>
            <th scope="col">Buyer</th>
            <th scope="col">PR No.</th>
            <th scope="col">Material Source No.</th>
        </tr>
    </thead>
    <tbody>
        <?php if($canvass_lists) : ?>
            <?php foreach($canvass_lists as $canvass_list) : ?>
                <tr>
                    <td data-label="Canvass No"><a href="<?php echo base_url(); ?>procurement/comparative_quotations/<?php echo $canvass_list->canvass_no; ?>"><?php echo $canvass_list->canvass_no; ?></a></td>
                    <td data-label="Date"><?php echo $canvass_list->canvass_date; ?></td>
                    <td data-label="Company"><?php if($canvass_list->company == 0) { echo 'RRLC'; } else { echo 'BMC'; } ?></td>
                    <td data-label="Cost Saving"><?php  $total_cost_saving = number_format($canvass_list->cost_saving, 2, '.', ','); echo $total_cost_saving; ?></td>
                    <td data-label="Cost Aviodance"><?php $total_cost_avoidance= number_format($canvass_list->cost_avoidance, 2, '.', ','); echo $total_cost_avoidance; ?></td>
                    <td data-label="Buyer"><?php echo $canvass_list->buyer_name; ?></td>
                    <td data-label="Pr No"><?php echo $canvass_list->pr_no; ?></td>
                    <td data-label="Material Source No"> 
                        <?php if($canvass_list->msid != NULL) : ?>
                            <a href="<?php echo base_url(); ?>procurement/material_sourcing_view/<?php echo $canvass_list->idms; ?>/<?php echo $canvass_list->msid; ?>"><?php echo $canvass_list->msid; ?></a>
                        <?php else : ?>
                            <?php echo '-'; ?>
                        <?php endif; ?>
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