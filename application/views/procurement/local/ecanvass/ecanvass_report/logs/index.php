<style>
    .printMe {
        display: none;
    }
    @media print {
        div {
            display: none;
        }
        .printMe {
            display: block;
        }
    }
    .tbrow{
        background-color:#0D635D !important;
        -webkit-print-color-adjust: exact;
        color: white; 
    }
    .throw{
       background-color: #0C2D48 !important; 
       -webkit-print-color-adjust: exact;
       color:white;
    }
</style>
<div class="card" style="font-size:12px" id="printableArea">
    <p style="text-align:center" class="printMe"><img class="card-img-top" style="width:40%" src="<?php echo base_url(); ?>assets/images/header.png" alt=""></p>
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>COMPARATIVE STATEMENT OF QUOTATION LOGS<a href="<?php echo base_url(); ?>procurement/ecanvass_cost_saving" id="back" title="Go Back" class="btn btn-info float-right d-print-none" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
        <div class="card">
            <div class="card-header" style="background-color: #0D635D;"><h4></h4></div>
            <div class="card-body" style="background-color: #E9FAFD;color:black">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Canvass Number</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php echo $canvass->canvass_no; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Company</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php if($canvass->company == 0) { echo 'RRLC'; } else { echo 'BMC'; } ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>PR Number</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php echo $canvass->material_pr_no; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>PR Date</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <p><?php echo date('Y-m-d', strtotime($canvass->pr_date)); ?></p>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <br>
        <table class="table table-bordered table-responsive" style="font-size:12px; line-height:13px; text-align: center;">
            <thead>
                <tr class="tbrow">
                    <th colspan="7" style="vertical-align: middle">Previous Purchase</th>
                    <?php $a = 1; ?>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <th colspan="" style="vertical-align: middle">Quotation <?php echo $a; ?></th>
                            <?php $a++; ?>
                        <?php endforeach; ?>    
                    <?php endif; ?>
                </tr>
                <tr>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">No</th>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">Material</th>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">QTY</th>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">UOM</th>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">Previous Purchase Per Unit	</th>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">Currency</th>
                    <th class="throw" scope="col" style="width: 10%; vertical-align: middle">Year</th>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <th class="tbrow" colspan="" style="width:10%; vertical-align:middle"><?php echo $supplier->supplier_name; ?></th>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
            </thead>
            <tbody style="line-height:12px; background-color: #E9FAFD;color:black" >
                <?php $i = 1; ?>
                <?php if($materials) : ?>  
                    <?php foreach($materials as $material) : ?>  
                        <tr >
                            <th scope="row"><?php echo $i; ?></th>
                            <td ><?php echo $material->description; ?></td>
                            <td><?php echo $material->quantity; ?></td>
                            <td><?php echo $material->uom; ?></td>
                            <td><?php if($material->prev_purchase_unit != 0) { echo $material->prev_purchase_unit; } else { echo '-'; } ?></td>
                            <td><?php echo $material->currency; ?></td>
                            <td><?php if($material->year != 0) { echo $material->year; } else { echo '-'; } ?></td>
                            <!-- Computation -->
                            <?php if($supplier_materials) : ?>  
                                <?php foreach($supplier_materials as $supplier_material) : ?> 
                                    <?php if($supplier_material->material_id == $material->id) : ?> 
                                        <!--<td><?php if($supplier_material->price_per_unit == 0) { echo '-';} else { $total_per_unit = number_format($supplier_material->price_per_unit, 2, '.', ','); echo $total_per_unit ;  } ?><br>per uom</td>-->
                                        <td><?php if($supplier_material->price_per_unit == 0) { echo '-';} else { $total_per_unit = number_format($supplier_material->price_per_unit, 2, '.', ','); echo $total_per_unit .'<br> <p style="font-size:10px;">'. $material->currency. '/' .$material->uom. '</p>';  } ?></td>
                                        <!--<td><?php $computation_per_unit = $material->quantity * $supplier_material->price_per_unit; ?><?php if($computation_per_unit == 0) { echo '-';} else { $total_per_unit = number_format($computation_per_unit, 2, '.', ','); echo $total_per_unit ;  } ?></td>-->
                                    <?php endif; ?> 
                                <?php endforeach; ?>    
                            <?php endif; ?>  
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>    
                <?php endif; ?>  
                
                
                <tr>
                    <th scope="row" style="background-color: white; border:none"></th>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td class="tbrow" rowspan="6" style="vertical-align:middle">Purchase Terms</td>
                    <td class="throw" colspan="3" style="">VAT</td>
                    
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <td><?php echo $supplier->vat; ?></td>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
                <tr>
                    <th scope="row" style="background-color: white; border:none"></th>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td class="throw" colspan="3" style="">PMT (Days)</td>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <td><?php echo $supplier->pmt; ?></td>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
                <tr>
                    <th scope="row" style="background-color: white; border:none"></th>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td class="throw" colspan="3" style="">DEL (Days)</td>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <td><?php echo $supplier->del; ?></td>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
                <tr>
                    <th scope="row" style="background-color: white; border:none"></th>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td class="throw" colspan="3" style="">WRT</td>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <td><?php echo $supplier->wrt; ?></td>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
                <tr>
                    <th scope="row" style="background-color: white; border:none"></th>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td class="throw" colspan="3" style="">Notes</td>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <td><?php echo $supplier->notes; ?></td>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
                <tr>
                    <th scope="row" style="background-color: white; border:none"></th>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td class="throw" colspan="3" style="">Attachment</td>
                    <?php if($suppliers) : ?>  
                        <?php $q = 1; ?>
                        <?php foreach($suppliers as $supplier) : ?>  
                            <?php if($supplier->attachment != NULL) : ?>
                                <td><a href="<?php echo base_url(); ?>procurement/download_supplier_matertial_attachment/<?php echo $supplier->attachment; ?>">file <?php echo $q; ?> </a></td>
                            <?php else: ?>
                                <td></td>
                            <?php endif; ?>    
                                <?php $q++; ?>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-bordered table-responsive" style="font-size:12px; line-height:13px; text-align: center;">
            <thead>
                <tr class="tbrow">
                    <th colspan="13" style="vertical-align: middle">Recent Revisions (<?php echo date('Y-m-d', strtotime($new_revision->created_date)); ?>) </th>
                </tr>
                <tr class="throw">
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">No</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Material</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">QTY</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">UOM</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Supplier Name</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">MOQ</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Price Per Unit</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Currency</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Total Price</th>
                    <th colspan="2" style="width: 10%; vertical-align: middle">Cost Saving</th>
                    <th colspan="2" style="width: 10%; vertical-align: middle">Cost Avoidance</th>
                </tr>
                <tr class="tbrow">
                    <th colspan="" style="width: 10%; vertical-align: middle">Reduction Per Unit</th>
                    <th colspan="" style="width: 10%; vertical-align: middle">Total Reduction</th>
                    <th colspan="" style="width: 10%; vertical-align: middle">Savings/Unit</th>
                    <th colspan="" style="width: 10%; vertical-align: middle">Total Savings</th>
                </tr>
            </thead>
            <tbody style="line-height:12px; background-color: #E9FAFD;color:black">
                <?php $sum_reduction_per_unit = 0; $sum_reduction = 0; $sum_saving_per_unit = 0; $sum_saving = 0; $y = 1; ?>
                <?php if($quotation_lists) : ?>
                    <?php foreach($quotation_lists as $quotation_list) : ?>
                        <tr>
                            <th><?php echo $y; ?></th>
                            <td><?php echo $quotation_list->material_name; ?></td>
                            <td><?php echo $quotation_list->quantity; ?></td>
                            <td><?php echo $quotation_list->uom; ?></td>
                            <td><?php echo $quotation_list->supplier_name; ?></td>
                            <td><?php echo $quotation_list->moq; ?></td>
                            <td><?php echo $quotation_list->price_per_unit; ?></td>
                            <td><?php echo $quotation_list->currency; ?></td>
                            <td><?php echo $quotation_list->total_price; ?></td>
                            <td><?php echo $quotation_list->reduction_per_unit; ?></td>
                            <td><?php echo $quotation_list->total_reduction; ?></td>
                            <td><?php echo $quotation_list->saving_per_unit; ?></td>
                            <td><?php echo $quotation_list->total_saving; ?></td>
                        </tr>
                        <?php $y++; ?>
                        <?php 
                            $sum_reduction_per_unit += $quotation_list->reduction_per_unit; 
                            $sum_reduction += $quotation_list->total_reduction; 
                            $sum_saving_per_unit += $quotation_list->saving_per_unit; 
                            $sum_saving += $quotation_list->total_saving;  
                        ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <tH style="background-color: #0C2D48; color: white; width: 10%">Total</tH>
                    <td id="sumCostSavingPerUnit"><?php echo $sum_reduction_per_unit; ?></td>
                    <td id="sumCostSavingTotalReduction"><?php echo $sum_reduction; ?></td>
                    <td id="sumCostAviodancePerUnit"><?php echo $sum_saving_per_unit; ?></td>
                    <td id="sumCostAviodanceTotal"><?php echo $sum_saving; ?></td>
                </tr>
            </tbody> 
        </table>
        <br>

        <table class="table table-bordered table-responsive" style="font-size:12px; line-height:13px; text-align: center;">
            <thead>
                <tr class="tbrow">
                    <th colspan="13" style="vertical-align: middle">Previous Revisions (<?php echo date('Y-m-d', strtotime($old_revision->created_date)); ?>)</th>
                </tr>
                <tr class="throw">
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">No</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Material</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">QTY</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">UOM</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Supplier Name</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">MOQ</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Price Per Unit</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Currency</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 10%">Total Price</th>
                    <th colspan="2" style="width: 10%; vertical-align: middle">Cost Saving</th>
                    <th colspan="2" style="width: 10%; vertical-align: middle">Cost Avoidance</th>
                </tr>
                <tr class="tbrow">
                    <th colspan="" style="width: 10%; vertical-align: middle">Reduction Per Unit</th>
                    <th colspan="" style="width: 10%; vertical-align: middle">Total Reduction</th>
                    <th colspan="" style="width: 10%; vertical-align: middle">Savings/Unit</th>
                    <th colspan="" style="width: 10%; vertical-align: middle">Total Savings</th>
                </tr>
            </thead>
            <tbody style="line-height:12px; background-color: #E9FAFD;color:black">
                <?php $old_sum_reduction_per_unit = 0; $old_sum_reduction = 0; $old_sum_saving_per_unit = 0; $old_sum_saving = 0; $a = 1; ?>
                <?php if($old_quotation_lists) : ?>
                    <?php foreach($old_quotation_lists as $old_quotation_list) : ?>
                        <tr>
                            <th><?php echo $a; ?></th>
                            <td><?php echo $old_quotation_list->material_name; ?></td>
                            <td><?php echo $old_quotation_list->quantity; ?></td>
                            <td><?php echo $old_quotation_list->uom; ?></td>
                            <td><?php echo $old_quotation_list->supplier_name; ?></td>
                            <td><?php echo $old_quotation_list->moq; ?></td>
                            <td><?php echo $old_quotation_list->price_per_unit; ?></td>
                            <td><?php echo $old_quotation_list->currency; ?></td>
                            <td><?php echo $old_quotation_list->total_price; ?></td>
                            <td><?php echo $old_quotation_list->reduction_per_unit; ?></td>
                            <td><?php echo $old_quotation_list->total_reduction; ?></td>
                            <td><?php echo $old_quotation_list->saving_per_unit; ?></td>
                            <td><?php echo $old_quotation_list->total_saving; ?></td>
                        </tr>
                        <?php $a++; ?>
                        <?php 
                            $old_sum_reduction_per_unit += $old_quotation_list->reduction_per_unit; 
                            $old_sum_reduction += $old_quotation_list->total_reduction; 
                            $old_sum_saving_per_unit += $old_quotation_list->saving_per_unit; 
                            $old_sum_saving += $old_quotation_list->total_saving;  
                        ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <td style="background-color: white; border:none"></td>
                    <tH style="background-color: #0C2D48; color: white; width: 10%">Total</tH>
                    <td id="sumCostSavingPerUnit"><?php echo $old_sum_reduction_per_unit; ?></td>
                    <td id="sumCostSavingTotalReduction"><?php echo $old_sum_reduction; ?></td>
                    <td id="sumCostAviodancePerUnit"><?php echo $old_sum_saving_per_unit; ?></td>
                    <td id="sumCostAviodanceTotal"><?php echo $old_sum_saving; ?></td>
                </tr>
            </tbody> 
        </table>

        <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
            <thead>
                <tr class="throw">
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 20%">Supplier Name</th>
                    <th scope="col" rowspan="2" style="vertical-align:middle; width: 20%">Date Generated</th>
                </tr>
            </thead>
            <tbody style="line-height:12px; background-color: #E9FAFD;color:black">
                <?php if($suppliers) : ?>  
                    <?php foreach($suppliers as $supplier) : ?> 
                        <tr>
                            <td><?php echo $supplier->supplier_name; ?></td>
                            <td><?php echo $supplier->created_date; ?></td>
                        </tr>
                    <?php endforeach; ?>    
                <?php endif; ?>  
            </tbody>
        </table>
    </div>
</div>