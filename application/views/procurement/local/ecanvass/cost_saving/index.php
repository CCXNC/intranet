<div class="card-header" style="background-color: #0C2D48; color: white">
    <h4>CANVASS LIST<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-left:10px;">BACK</a></h4> 
</div>
<br>
<div class="row">
    <div class="col-md-3">
        <div class="card" style="font-size:12px; border-radius:10px 10px 10px 10px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; border-radius:10px 10px 0px 0px;">NET COST SAVING
            </div>
            <div class="card-body" style="background-color:#5488A5; color: white; text-align:center; border-radius:0px 0px 10px 10px;padding-top:10px; padding-bottom:10px;"><?php $net_cost_saving = number_format($net_cost_saving->net_cost_saving, 2, '.', ','); echo $net_cost_saving; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px; border-radius:10px 10px 10px 10px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; border-radius:10px 10px 0px 0px">COST SAVING (+)
            </div>
            <div class="card-body" style="background-color:#469A49; color: white; text-align:center; border-radius:0px 0px 10px 10px;padding-top:10px; padding-bottom:10px;"><?php $cost_saving = number_format($cost_saving->cost_saving, 2, '.', ','); echo $cost_saving; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px; border-radius:10px 10px 10px 10px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; border-radius:10px 10px 0px 0px">COST SAVING (-)
            </div>
            <div class="card-body" style="background-color:#A3C4C3; color: white; text-align:center; border-radius:0px 0px 10px 10px;padding-top:10px; padding-bottom:10px;"><?php $cost_saving_negative = number_format($cost_saving_negative->cost_saving, 2, '.', ','); echo $cost_saving_negative; ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="font-size:12px; border-radius:10px 10px 10px 10px">
            <div class="card-header" style="background-color: #0C2D48; color: white;text-align:center; border-radius:10px 10px 0px 0px">COST AVOIDANCE
            </div>
            <div class="card-body" style="text-align:center;background-color:#5DBDEA; color: white; border-radius:0px 0px 10px 10px;padding-top:10px; padding-bottom:10px;"><?php $cost_avoidance= number_format($net_cost_avoidance->total_saving, 2, '.', ','); echo $cost_avoidance; ?>
            </div>
        </div>
    </div>
</div>
<br>

<table id="" class="display" style="width:100%; font-size:13px;">
    <thead>
        <tr style="background-color:#0D635D;color:white;"> 
            <th scope="col">Canvass Date</th>
            <th scope="col">Canvass No.</th>
            <th scope="col">Company</th>
            <th scope="col">Cost Saving</th>
            <th scope="col">Cost Avoidance</th>
            <th scope="col">Total Price</th>
            <th scope="col">Buyer</th>
            <th scope="col">PR No.</th>
            <th scope="col">No of Supplier Unique Supplier</th>
            <th scope="col">Material Source No.</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if($canvass_lists) : ?>
            <?php foreach($canvass_lists as $canvass_list) : ?>
                <tr>
                    <td data-label="Date"><?php echo $canvass_list->canvass_date; ?></td>
                    <td data-label="Canvass No"><a href="<?php echo base_url(); ?>procurement/comparative_quotations/<?php echo $canvass_list->canvass_no; ?>"><?php echo $canvass_list->canvass_no; ?></a></td>
                    <td data-label="Company"><?php if($canvass_list->company == 0) { echo 'RRLC'; } else { echo 'BMC'; } ?></td>
                    <td data-label="Cost Saving"><?php  $total_cost_saving = number_format($canvass_list->cost_saving, 2, '.', ','); echo $total_cost_saving; ?></td>
                    <td data-label="Cost Aviodance"><?php $total_cost_avoidance= number_format($canvass_list->cost_avoidance, 2, '.', ','); echo $total_cost_avoidance; ?></td>
                    <td data-label="Cost Aviodance"><?php $total_price= number_format($canvass_list->total_price, 2, '.', ','); echo $total_price; ?></td>
                    <td data-label="Buyer"><?php echo $canvass_list->buyer_name; ?></td>
                    <td data-label="Pr No"><?php if($canvass_list->pr_no != NULL){ echo $canvass_list->pr_no; } else { echo '-'; } ?></td>
                    <?php if($canvass_list_suppliers) : ?>
                        <?php foreach($canvass_list_suppliers as $canvass_list_supplier) : ?>
                            <?php if($canvass_list_supplier->canvass_no == $canvass_list->canvass_no) : ?>
                                <?php if($canvass_list_supplier->total_supplier <= 2) : ?>
                                    <td data-label="No of Supplier"><p style="color: #C85250; font-weight:800; text-align: center;"><?php echo $canvass_list_supplier->total_supplier; ?></p></td>
                                <?php elseif($canvass_list_supplier->total_supplier == 3) : ?>  
                                    <td data-label="No of Supplier"><p style="color: #FBC00E; font-weight:800; text-align: center;"><?php echo $canvass_list_supplier->total_supplier; ?></p></td> 
                                <?php elseif($canvass_list_supplier->total_supplier >= 4) : ?>  
                                    <td data-label="No of Supplier"><p style="color: #1D741B; font-weight:800; text-align: center;"><?php echo $canvass_list_supplier->total_supplier; ?></p></td> 
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                  
                    <td data-label="Material Source No"> 
                        <?php if($canvass_list->msid != NULL) : ?>
                            <a href="<?php echo base_url(); ?>procurement/material_sourcing_view/<?php echo $canvass_list->idms; ?>/<?php echo $canvass_list->msid; ?>"><?php echo $canvass_list->msid; ?></a>
                        <?php else : ?>
                            <?php echo '-'; ?>
                        <?php endif; ?>
                    </td>
                    <td data-label="Action">
                        <div class="btn-group">
                            <button title="View Actions" type="button" class="btn btn-info dropdown-toggle btn-sm btnaction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/comparative_quotations/<?php echo $canvass_list->canvass_no; ?>">View</a>
                                <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/add_quotation/<?php echo $canvass_list->canvass_no; ?>">Add Quotation</a>
                                <?php if($canvass_list_logs) : ?>
                                    <?php foreach($canvass_list_logs as $canvass_list_log) : ?>
                                        <?php if($canvass_list_log->activity_id == $canvass_list->canvass_no) : ?>
                                            <a class="dropdown-item" title="View Request" href="<?php echo base_url(); ?>procurement/comparative_quotations_logs/<?php echo $canvass_list->canvass_no; ?>">Logs</a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>        
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