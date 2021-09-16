<p style="text-align:left"><img class="card-img-top" style="" src="<?php echo base_url(); ?>assets/images/step4.png" alt=""></p>
<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>COMPARATIVE STATEMENT OF QUOTATIONS: CHOOSING OF SUPPLIER<a href="<?php echo base_url(); ?>procurement/report_pr_add1" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; font-size:12px;background-color:white" readonly value="<?php echo $canvass->canvass_no; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; font-size:12px; background-color:white" readonly value="<?php if($canvass->company == 0) { echo 'RRLC'; } else { echo 'BMC'; } ?>">
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
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; font-size:12px;background-color:white" readonly value="<?php echo $canvass->material_pr_no; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>PR Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="font-size:12px;background-color:white" readonly value="<?php echo date('Y-m-d', strtotime($canvass->pr_date)); ?>">
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
                        <th scope="col" style="background-color: #0C2D48; color: white;">No</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Material</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">QTY</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">UOM</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Previous Purchase Per Unit	</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Currency</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Year</th>
                        <?php if($suppliers) : ?>  
                            <?php foreach($suppliers as $supplier) : ?>  
                                <th colspan="" style="background-color:#0D635D; color:white"><?php echo $supplier->supplier_name; ?></th>
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
                                <td><?php echo $material->prev_purchase_unit; ?></td>
                                <td><?php echo $material->currency; ?></td>
                                <td><?php echo $material->year; ?></td>
                                <!-- Computation -->
                                <?php if($supplier_materials) : ?>  
                                    <?php foreach($supplier_materials as $supplier_material) : ?> 
                                        <?php if($supplier_material->material_id == $material->id) : ?> 
                                            <td><?php $computation_per_unit = $material->quantity * $supplier_material->price_per_unit; ?><?php echo $computation_per_unit; ?></td>
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
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">No</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Material</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">QTY</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">UOM</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">MOQ</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Quotation</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Supplier</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Saving</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Avoidance</th>
                    </tr>
                    <tr>
                        <th colspan="" style="background-color:#0D635D; color:white">Reduction Per Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Reduction</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Savings/Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Savings</th>
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
                        <input type="text" class="form-control" name="first_name" style="text-transform:uppercase;font-size:12px;background-color:white" readonly value="<?php echo $this->session->userdata('fullname'); ?>">
                    </div>
                </div>
            </div>
            <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">No</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Material</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">QTY</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">UOM</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Quotation</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Supplier</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">MOQ</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Saving</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Avoidance</th>
                    </tr>
                    <tr>
                        <th colspan="" style="background-color:#0D635D; color:white">Reduction Per Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Reduction</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Savings/Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Savings</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #E9FAFD;color:black">
                    <?php $y = 1; ?>
                    <?php if($materials) : ?>  
                        <?php foreach($materials as $material) : ?>  
                            <tr >
                                <th scope="row"><?php echo $y; ?></th>
                                <td ><?php echo $material->description; ?></td>
                                <td><?php echo $material->quantity; ?></td>
                                <td><?php echo $material->uom; ?></td>
                                <td><p id="quatation<?php echo $y; ?>"></p></td>
                                <td>
                                    <select name="" class="form-control" id="selectSupplier<?php echo $y; ?>" style="font-size:12px; height:32px" id="">
                                        <option value=" ">Select Supplier</option>
                                        <?php if($supplier_materials) : ?>  
                                            <?php foreach($supplier_materials as $supplier_material) : ?>  
                                                <?php if($supplier_material->material_id == $material->id) : ?> 
                                                    <option value="<?php echo $supplier_material->moq. '|'.$supplier_material->price_per_unit . '|' .$material->quantity; ?>"><?php echo $supplier_material->supplier_name; ?></option>
                                                <?php endif; ?> 
                                            <?php endforeach; ?>    
                                        <?php endif; ?> 
                                    </select>
                                </td>
                                <td><p id="moq<?php echo $y; ?>"></p></td>
                            </tr>
                            <?php $y++; ?>
                        <?php endforeach; ?>    
                    <?php endif; ?>  
                    <input type="text" hidden id="total_material" value="<?php echo $y; ?>">
                </tbody> 
            </table>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification[]" rows="1" ></textarea>
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
        
        for(let incVal = 0;dtaValue >= incVal; incVal++)
        {
           
            $('#selectSupplier'+incVal+'').on('change', function() {
                var dta =  $('#selectSupplier'+incVal+'').val().split('|');
                var computeQuatation =  dta[1] * dta[2];
                
                $('#moq'+incVal+'').text(dta[0]); 
                $('#quatation'+incVal+'').text(computeQuatation); 
            });
        }
    });            
</script>