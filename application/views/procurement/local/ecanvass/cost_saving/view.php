<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>COMPARATIVE STATEMENT OF QUOTATIONS<a href="<?php echo base_url(); ?>procurement/ecanvass_cost_saving" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
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
                </div>
                <div class="row">
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
        <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
            <thead>
                <tr>
                    <th colspan="7" style="background-color: #0C2D48; color: white; ">Previous Purchase</th>
                    <?php $a = 1; ?>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <th colspan="" style="background-color: #0C2D48; color: white">Quotation <?php echo $a; ?></th>
                            <?php $a++; ?>
                        <?php endforeach; ?>    
                    <?php endif; ?>
                </tr>
                <tr>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">No</th>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">Material</th>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">QTY</th>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">UOM</th>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">Previous Purchase Per Unit	</th>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">Currency</th>
                    <th scope="col" style="background-color: #0C2D48; color: white; width: 10%">Year</th>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <th colspan="" style="background-color:#0D635D; color:white; width:10%"><?php echo $supplier->supplier_name; ?></th>
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
                                        <td><?php $computation_per_unit = $material->quantity * $supplier_material->price_per_unit; ?><?php if($computation_per_unit == 0) { echo '-';} else { $total_per_unit = number_format($computation_per_unit, 2, '.', ','); echo $total_per_unit ;  } ?></td>
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
                    <td rowspan="5" style="vertical-align:middle; background-color:#0D635D; color:white">Purchase Terms</td>
                    <td colspan="3" style="background-color: #0C2D48; color: white; ">VAT</td>
                    
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
                    <td colspan="3" style="background-color: #0C2D48; color: white; ">PMT (Days)</td>
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
                    <td colspan="3" style="background-color: #0C2D48; color: white; ">DEL (Days)</td>
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
                    <td colspan="3" style="background-color: #0C2D48; color: white; ">WRT</td>
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
                    <td colspan="3" style="background-color: #0C2D48; color: white; ">Notes</td>
                    <?php if($suppliers) : ?>  
                        <?php foreach($suppliers as $supplier) : ?>  
                            <td><?php echo $supplier->notes; ?></td>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                </tr>
            </tbody>
        </table>
        <br>
        <hr>
        <br>
        <!--Computer Recom-->
        <p>
            <input class="btn btn-success" type="button" value="Show Computer Recommendation" id="bt" onclick="toggle(this)">
        </p>
        <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center; display:none" id="comprecom">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">No</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Material</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">QTY</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">UOM</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">MOQ</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Quotation</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Supplier</th>
                    <th colspan="2" style="background-color: #0C2D48; color: white;width: 10%">Cost Saving</th>
                    <th colspan="2" style="background-color: #0C2D48; color: white;width: 10%">Cost Avoidance</th>
                </tr>
                <tr>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Reduction Per Unit</th>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Total Reduction</th>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Savings/Unit</th>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Total Savings</th>
                </tr>
            </thead>
            <tbody style="line-height:12px; background-color: #E9FAFD;color:black">
                <tr >
                    <th scope="row">1</th>
                    <td >Packaging Tape</td>
                    <td>100</td>
                    <td>Pack/s</td>
                    <td></td>
                    <td></td>
                    <td>KJ Packaging</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Latex Gloves</td>
                    <td>1,000</td>
                    <td>Pack/s</td>
                    <td></td>
                    <td></td>
                    <td>ABC Consumables</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Nitrile Gloves</td>
                    <td>1,000</td>
                    <td>Pack/s</td>
                    <td></td>
                    <td></td>
                    <td>JGC Chemicals</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
   
        <hr>
        <br>
        <table class="table table-bordered table-responsive" style="font-size:12px; line-height:13px; text-align: center;">
            <thead>
                <tr>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">No</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Material</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">QTY</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">UOM</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Supplier Name</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">MOQ</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Price Per Unit</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Currency</th>
                    <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Total Price</th>
                    <th colspan="2" style="background-color: #0C2D48; color: white; width: 10%">Cost Saving</th>
                    <th colspan="2" style="background-color: #0C2D48; color: white; width: 10%">Cost Avoidance</th>
                </tr>
                <tr>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Reduction Per Unit</th>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Total Reduction</th>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Savings/Unit</th>
                    <th colspan="" style="background-color:#0D635D; color:white; width: 10%">Total Savings</th>
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
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <p><b>Buyer Name: </b> <?php echo $quotation_canvass->buyer_name; ?></p>
                    <p><b>Remarks: </b> <?php echo $quotation_canvass->remarks; ?></p>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<script>
    function toggle(ele) {
        var cont = document.getElementById('comprecom');
        if (cont.style.display == 'block') {
            cont.style.display = 'none';

            document.getElementById(ele.id).value = 'Show Computer Recommendation';
        }
        else {
            cont.style.display = 'block';
            document.getElementById(ele.id).value = 'Hide Computer Recommendation';
        }
    }
</script>