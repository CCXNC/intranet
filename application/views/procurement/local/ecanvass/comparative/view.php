<p style="text-align:left"><img class="card-img-top" style="" src="<?php echo base_url(); ?>assets/images/step4.png" alt=""></p>
<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>COMPARATIVE STATEMENT OF QUOTATIONS: CHOOSING OF SUPPLIER<a href="<?php echo base_url(); ?>procurement/report_pr_add1" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url();?>procurement/comparative_view/<?php echo $canvass->canvass_no; ?>" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" name="canvass_no" style="text-transform:uppercase; font-size:12px;background-color:white" readonly value="<?php echo $canvass->canvass_no; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" style="text-transform:uppercase; font-size:12px; background-color:white" readonly value="<?php if($canvass->company == 0) { echo 'RRLC'; } else { echo 'BMC'; } ?>">
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
                                <input type="text" class="form-control" style="text-transform:uppercase; font-size:12px;background-color:white" readonly value="<?php echo $canvass->material_pr_no; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>PR Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control"  style="font-size:12px;background-color:white" readonly value="<?php echo date('Y-m-d', strtotime($canvass->pr_date)); ?>">
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
            <br>
            <hr>
            <br>
            <!--Buyer Recom-->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Buyer Recommendation</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="buyer_name" style="text-transform:uppercase;font-size:12px;background-color:white" readonly value="<?php echo $this->session->userdata('username'); ?>">
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">No</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Material</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">QTY</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">UOM</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle; width: 10%">Quotation</th>
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
                    <?php $y = 1; ?>
                    <?php if($materials) : ?>  
                        <?php foreach($materials as $material) : ?>  
                                <?php if($cost_aviodances) : ?>
                                    <?php $z = 1; ?>
                                    <?php foreach($cost_aviodances as $cost_aviodance) : ?>
                                        <?php if($y == $z): ?>
                                            <input type="text" hidden id="totalPerMaterial<?php echo $y; ?>" value="<?php echo $cost_aviodance->total_price_per_material; ?>">
                                            <input type="text" hidden id="materialCount<?php echo $y; ?>" value="<?php echo $cost_aviodance->count_per_material ; ?>">
                                            <br>
                                        <?php endif; ?>
                                        <?php $z++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <tr>
                                <th scope="row"><?php echo $y; ?></th>
                                <td ><?php echo $material->description; ?> <input type="text" value="<?php echo $material->description; ?>" name="material_name[]" hidden></td>
                                <td><?php echo $material->quantity; ?> <input type="text" value="<?php echo $material->quantity; ?>" name="qty[]" hidden></td>
                                <td><?php echo $material->uom; ?> <input type="text" value="<?php echo $material->uom; ?>" name="uom[]" hidden></td>
                                <td>
                                    <?php $p = 1; ?>
                                    <select name="" class="form-control" id="selectSupplier<?php echo $y; ?>" style="font-size:12px; height:32px" id="">
                                        <option value=" ">Select Quatation</option>
                                        <?php if($supplier_materials) : ?>  
                                            <?php foreach($supplier_materials as $supplier_material) : ?>  
                                                <?php if($supplier_material->material_id == $material->id) : ?> 
                                                    <?php if($supplier_material->price_per_unit != 0) : ?>
                                                        <option value="<?php echo $supplier_material->moq. '|'.$supplier_material->price_per_unit . '|' .$material->quantity.'|'.$material->prev_purchase_unit.'|'.$supplier_material->supplier_name. '|' . $supplier_material->currency. '|' . $supplier_material->currency; ?>"><?php echo 'Quotation '.$p.''; ?></option>
                                                    <?php endif; ?> 
                                                    <?php $p++; ?>
                                                <?php endif; ?> 
                                            <?php endforeach; ?>    
                                        <?php endif; ?> 
                                    </select>
                                </td>
                                <td><p id="supplierName<?php echo $y; ?>"></p> <input type="text" id="valSupplierName<?php echo $y; ?>" name="supplier_name[]" hidden> </td>
                                <td><p id="moq<?php echo $y; ?>"></p> <input type="text" id="valMoq<?php echo $y; ?>" name="moq[]" hidden> </td>
                                <td><p id="perUnit<?php echo $y; ?>"></p> <input type="text" id="valPerUnit<?php echo $y; ?>" name="price_per_unit[]" hidden> </td>
                                <td><p id="currency<?php echo $y; ?>"></p> <input type="text" id="valCurrency<?php echo $y; ?>" name="currency[]" hidden> </td>
                                <td><p id="totalPriceUnit<?php echo $y; ?>"></p> <input type="text" id="valTotalPriceUnit<?php echo $y; ?>" name="total_price[]" hidden> </td>
                                <td><p id="costSavingPerUnit<?php echo $y; ?>"></p> <input type="text" id="valCostSavingPerUnit<?php echo $y; ?>" name="reduction_per_unit[]" hidden></td>
                                <td><p id="costSavingTotalReduction<?php echo $y; ?>"></p> <input type="text" id="valCostSavingTotalReduction<?php echo $y; ?>" name="total_reduction[]" hidden></td>
                                <td><p id="costAviodancePerUnit<?php echo $y; ?>"></p> <input type="text" id="valCostAviodancePerUnit<?php echo $y; ?>" name="saving_unit[]" hidden></td>
                                <td><p id="costAviodanceTotal<?php echo $y; ?>"></p> <input type="text" id="valCostAviodanceTotal<?php echo $y; ?>" name="total_saving[]" hidden></td>
                            </tr>
                            <?php $y++; ?>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                    <input type="text" id="total_material" hidden value="<?php $deduct1 = $y - 1; echo $deduct1; ?>">
                    <tr>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <tH style="background-color: #0C2D48; color: white; width: 10%">Total</tH>
                        <td id="sumCostSavingPerUnit"></td>
                        <td id="sumCostSavingTotalReduction"></td>
                        <td id="sumCostAviodancePerUnit"></td>
                        <td id="sumCostAviodanceTotal"></td>
                    </tr>
                </tbody> 
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="remarks" rows="1" ></textarea>
                    </div>
                </div>
            </div>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="Submit Employee Information" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
        </form>
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
    $(document).ready(function(){
        var dtaValue = $('#total_material').val();
        var sumReductionPerUnit = 0;
        var sumTotalReduction = 0;
        var sumSavingsPerUnit = 0;
        var sumTotalSavings = 0;

        for(let incVal = 1;dtaValue >= incVal; incVal++)
        {
            $('#selectSupplier'+incVal+'').on('change', function() {
                var dta =  $('#selectSupplier'+incVal+'').val().split('|');
                var moq = dta[0];
                var pricePerUnit = dta[1];
                var materialQuantity = dta[2];
                var prevPurchaseUnit = dta[3];
                var supplierName = dta[4];
                var currency = dta[5];

                var computeQuatation =  pricePerUnit * materialQuantity;
                if(prevPurchaseUnit == 0) {
                    var reductionPerUnit = 0;
                    var totalReduction = 0;  
                } else {
                    var reductionPerUnit = prevPurchaseUnit - pricePerUnit;
                    var totalReduction = reductionPerUnit * materialQuantity;
                }
                
                var totalPerMaterialDta = $('#totalPerMaterial'+incVal+'').val();
                var materialCountDta = $('#materialCount'+incVal+'').val();

                var computeCostAviodance = totalPerMaterialDta / materialCountDta;
                var savingsPerUnit = computeCostAviodance - pricePerUnit;
                var totalSavings = savingsPerUnit * materialQuantity;

                // COMPUTATION OF COST SAVING AND COST AVIODANCE
                sumReductionPerUnit +=  reductionPerUnit;
                sumTotalReduction += totalReduction;
                sumSavingsPerUnit += savingsPerUnit;
                sumTotalSavings += totalSavings;

                // VIEWING VALUE
                $('#supplierName'+incVal+'').text(supplierName); 
                $('#moq'+incVal+'').text(moq); 
                $('#perUnit'+incVal+'').text(pricePerUnit); 
                $('#currency'+incVal+'').text(currency); 
                $('#totalPriceUnit'+incVal+'').text(computeQuatation); 

                $('#costSavingPerUnit'+incVal+'').text(parseFloat(reductionPerUnit).toFixed(2));
                $('#costSavingTotalReduction'+incVal+'').text(parseFloat(totalReduction).toFixed(2));
                $('#costAviodancePerUnit'+incVal+'').text(parseFloat(savingsPerUnit).toFixed(2));
                $('#costAviodanceTotal'+incVal+'').text(parseFloat(totalSavings).toFixed(2));

                // INPUT VALUE
                $('#valSupplierName'+incVal+'').val(supplierName); 
                $('#valMoq'+incVal+'').val(moq); 
                $('#valPerUnit'+incVal+'').val(pricePerUnit); 
                $('#valCurrency'+incVal+'').val(currency); 
                $('#valTotalPriceUnit'+incVal+'').val(computeQuatation); 

                $('#valCostSavingPerUnit'+incVal+'').val(parseFloat(reductionPerUnit).toFixed(2));
                $('#valCostSavingTotalReduction'+incVal+'').val(parseFloat(totalReduction).toFixed(2));
                $('#valCostAviodancePerUnit'+incVal+'').val(parseFloat(savingsPerUnit).toFixed(2));
                $('#valCostAviodanceTotal'+incVal+'').val(parseFloat(totalSavings).toFixed(2));


                // TOTAL OF COST SAVING AND COST AVIODANCE
                $('#sumCostSavingPerUnit').text(parseFloat(sumReductionPerUnit).toFixed(2));
                $('#sumCostSavingTotalReduction').text(parseFloat(sumTotalReduction).toFixed(2));
                $('#sumCostAviodancePerUnit').text(parseFloat(sumSavingsPerUnit).toFixed(2));
                $('#sumCostAviodanceTotal').text(parseFloat(sumTotalSavings).toFixed(2));
            });
            
        }
    });            
</script>