<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=number] {
        font-size: 12px;
    }
</style>
<p style="text-align:left"><img class="card-img-top" style="" src="<?php echo base_url(); ?>assets/images/step3.png" alt=""></p>
<div class="card" style="font-size:12px;">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS REPORT GENERATION 2</h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="POST" id="report" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white"><h5>Comparative Statement Quotations</h5></div>
                <div class="card-body" style="background-color: #E9FAFD;" id="form_field">
                    <input type="text" hidden name="canvass_no" value="<?php echo $canvass->canvass_no; ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Select Supplier</label>
                            <div class="form-group">
                                <select class="form-control" id="supplier" style="font-size:12px; height:32px" name="supplier[]" style="font-size:12px;">
                                    <option value=" ">SELECT SUPPLIER</option>
                                    <option value="acc">ACCREDITED</option>
                                    <option value="others">OTHERS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="accreditedData">
                            <div class="form-group">
                                <label for="">Supplier`s Name</label>
                                <select name="accredited[]" class="form-control" id="dataAccredited" style=" font-size: 12px;">
                                    <option value=" ">Select Supplier Name</option>
                                    <?php if($suppliers) : ?>
                                        <?php foreach($suppliers as $supplier) : ?>
                                            <option value="<?php echo $supplier->name; ?>"><?php echo $supplier->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4" id="othersData">
                            <div class="form-group">
                                <label for="">Supplier`s Name</label>
                                <input type="text" name="others[]" id="dataOthers" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-8">   
                            <table id="" class="table table-striped"  style="width:100%">
                                <thead>
                                    <tr style="background-color:#0D635D; color:white;">
                                        <th scope="col">Material</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">UOM</th>
                                        <th scope="col">MOQ</th>
                                        <th scope="col">Price Per UOM</th>
                                        <th scope="col">Currency</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($materials) : ?>
                                        <?php foreach($materials as $material) : ?>
                                            <tr>
                                                <td hidden><input type="text" hidden name="supplier_name[]" class="supplierName"></td>
                                                <td hidden><input type="text" name="id[]" hidden value="<?php echo $material->id; ?>"></td>
                                                <td data-label="Description & Specs"><input type="text" name="description[]" hidden value="<?php echo $material->description; ?>"><?php echo $material->description; ?></td>
                                                <td data-label="QTY"><input type="text" name="quantity[]" hidden value="<?php echo $material->quantity; ?>"><?php echo $material->quantity; ?></td>
                                                <td data-label="UOM"><input type="text" name="uom[]" hidden value="<?php echo $material->uom; ?>"><?php echo $material->uom; ?></td>
                                                <td data-label="MOQ"><input type="text" class="form-control" name="moq[]" value="0"></td>
                                                <td data-label="Price"><input type="text" class="form-control" name="price[]" value="0"></td>
                                                <td data-label="Currency">
                                                    <select name="currency[]" class="form-control" style="font-size:12px; height:32px" style="font-size:12px;">
                                                        <option value=""></option>
                                                            <option selected="selected" value="PHP">PHP</option>
                                                            <option value="USD">USD</option>
                                                            <option value="POUND">POUND</option>
                                                            <option value="YUAN">YUAN</option>
                                                            <option value="EURO">EURO</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                 
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div style="background-color: #0D635D; color: white; padding:7px 5px 4px 5px; border-radius:5px; font-size:14px;">Purchase Term</div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">VAT</label>
                                        <select class="form-control" name="vat[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1">
                                            <option value="INC">INC</option>
                                            <option value="EX">EX</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">WRT</label>
                                        <input type="text" name="wrt[]" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">PMT (Days)</label>
                                        <input type="text" name="pmt[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">DEL (Days)</label>
                                        <input type="text" name="del[]" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Notes</label>
                                        <textarea style="font-size:12px" class="form-control" name="notes[]" id="" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="file" name="files[]" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <br>
            <input type="submit"  style="margin-left:10px;" id="process" class="float-right btn btn-info btn-sm" value="Next">
            <input class="btn btn-sm btn-success float-right" title="Add Form" type="button" name="add" id="fadd" value="Add Material">
        </form>
    </div>
</div>


<script>
    $(document).ready(function(){

        // LIMIT OF ADD MATERIAL CODE class="fa fa-times"
        var fmax = 50;
        var f = 1;

        $("#fadd").click(function(){

            if(f <= fmax) {
              
                var form = "<div id='form'><div class='row'><div class='col-md-4'><label for=''>Select Supplier</label><div class='form-group'><select style='font-size:12px; height:32px' class='form-control' id='supplier"+f+"'  name='supplier[]' style='font-size:12px;'><option value='aa'>SELECT SUPPLIER</option><option value='acc'>ACCREDITED</option><option value='others'>OTHERS</option></select></div></div><div class='col-md-4' id='accreditedData"+f+"' style='display:none;'><div class='form-group'><label for=''>Supplier`s Name</label><select name='accredited[]' id='dataAccredited"+f+"' class='form-control' style=' font-size: 12px;'> <option value=' '>Select Supplier Name</option><?php if($suppliers) : ?><?php foreach($suppliers as $supplier) : ?><option value='<?php echo $supplier->name; ?>'><?php echo $supplier->name; ?></option><?php endforeach; ?><?php endif; ?></select></div></div><div class='col-md-4' id='othersData"+f+"'style='display:none;'><div class='form-group'><label for=''>Supplier`s Name</label><input type='text' name='others[]' id='dataOthers"+f+"' class='form-control'></div></div></div><div class='row'><div class='col-md-8'><table id='' class='table table-striped'  style='width:100%'><thead><tr style='background-color:#0D635D; color:white;'><th scope='col'>Material</th><th scope='col'>QTY</th><th scope='col'>UOM</th><th scope='col'>MOQ</th><th scope='col'>Price Per UOM</th><th scope='col'>Currency</th></tr></thead><tbody><?php if($materials) : ?><?php foreach($materials as $material) : ?><tr><td hidden><input type='text' hidden name='supplier_name[]' class='supplierName"+f+"'></td><td hidden><input type='text' name='id[]' hidden value='<?php echo $material->id; ?>'></td><td data-label='Description & Specs'><input type='text' name='description[]' hidden value='<?php echo $material->description; ?>'><?php echo $material->description; ?></td><td data-label='QTY'><input type='text' name='quantity[]' hidden value='<?php echo $material->quantity; ?>'><?php echo $material->quantity; ?></td><td data-label='UOM'><input type='text' name='uom[]' hidden value='<?php echo $material->uom; ?>'><?php echo $material->uom; ?></td><td data-label='MOQ'><input type='text' class='form-control' name='moq[]' value='0'></td><td data-label='Price'><input type='text' class='form-control' name='price[]' value='0'></td><td data-label='Currency'><select name='currency[]' style='font-size:12px; height:32px' class='form-control' id='' style='font-size:12px;'><option value=''></option><option selected='selected' value='PHP'>PHP</option><option value='USD'>USD</option><option value='POUND'>POUND</option><option value='YUAN'>YUAN</option><option value='EURO'>EURO</option></select></td></tr><?php endforeach; ?><?php endif; ?></tbody></table></div><div class='col-md-4'><div style='background-color: #0D635D; color: white; padding:7px 5px 4px 5px; border-radius:5px; font-size:14px;'>Purchase Term</div><div class='row' style='margin-top:10px;'><div class='col-md-6'><div class='form-group'><label for='exampleFormControlSelect1'>VAT</label><select class='form-control' name='vat[]' style='font-size:12px; height:32px' id='exampleFormControlSelect1'><option value='INC'>INC</option><option value='EX'>EX</option></select></div></div><div class='col-md-6'><div class='form-group'><label for=''>WRT</label><input type='text' name='wrt[]' class='form-control'></div></div></div><div class='row'><div class='col-md-6'><div class='form-group'><label for=''>PMT (Days)</label><input type='text' name='pmt[]' class='form-control' required></div></div><div class='col-md-6'><div class='form-group'><label for=''>DEL (Days)</label><input type='text' name='del[]' class='form-control' required></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for=''>Notes</label><textarea style='font-size:12px' class='form-control' name='notes[]' id='' rows='1'></textarea></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><input type='file' name='files[]' /></div></div></div></div></div><input class='btn btn-danger btn-sm float-right' type='button' name='remove' id='fremove' value='Remove Material'></div><br><br>";
                //var form = "<div id='form'><div class='row'><div class='col-md-4'><label for=''>Select Supplier</label><div class='form-group'><select class='form-control' id='test"+f+"' style='font-size:12px;'><option value='aa'>SELECT SUPPLIER</option><option value='acc"+f+"'>ACCREDITED</option><option value='others"+f+"'>OTHERS</option></select></div></div><div class='col-md-4' id='accreditedView"+f+"'></div><div class='col-md-4' id='othersView"+f+"'></div></div><div class='row'><div class='col-md-8'>   <table id='' class='table table-striped'  style='width:100%'><thead><tr style='background-color:#0D635D; color:white;'><th scope='col'>Material</th><th scope='col'>QTY</th><th scope='col'>UOM</th><th scope='col'>MOQ</th><th scope='col'>Price Per UOM</th><th scope='col'>Currency</th></tr></thead><tbody><?php if($materials) : ?><?php foreach($materials as $material) : ?><tr><td data-label='Description & Specs'><?php echo $material->description; ?></td><td data-label='QTY'><?php echo $material->quantity; ?></td><td data-label='UOM'><?php echo $material->uom; ?></td><td data-label='MOQ'><input type='number' class='form-control' name='moq[]'></td><td data-label='Price'><input type='number' class='form-control' name='price[]'></td><td data-label='Currency'><select name='currency[]' class='form-control' id='' style='font-size:12px;'><option value=''></option><option selected='selected' value='PHP'>PHP</option><option value='USD'>USD</option><option value='POUND'>POUND</option><option value='YUAN'>YUAN</option><option value='EURO'>EURO</option></select></td></tr><?php endforeach; ?><?php endif; ?></tbody></table></div><div class='col-md-4'><div style='background-color: #0D635D; color: white; padding:7px 5px 4px 5px; border-radius:5px; font-size:14px;'>Purchase Term</div><div class='row' style='margin-top:10px;'><div class='col-md-6'><div class='form-group'><label for='exampleFormControlSelect1'>VAT</label><select class='form-control' name='uom[]' style='font-size:12px; height:32px' id='exampleFormControlSelect1'><option value='' selected></option><option>INC</option><option>EX</option></select></div></div><div class='col-md-6'><div class='form-group'><label for=''>WRT</label><input type='text' name='wrt[]' class='form-control'></div></div></div><div class='row'><div class='col-md-6'><div class='form-group'><label for=''>PMT (Days)</label><input type='text' name='pmt[]' class='form-control'></div></div><div class='col-md-6'><div class='form-group'><label for=''>DEL (Days)</label><input type='text' name='del[]' class='form-control'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for=''>Notes</label><textarea style='font-size:12px' class='form-control' name='notes[]' id='' rows='1'></textarea></div></div></div></div></div><input class='btn btn-danger' type='button' name='remove' id='fremove' value='Remove'></div><br>"
                $("#form_field").append(form);
               
                $('#supplier1').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData1').show(); 
                            $('#othersData1').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData1').show();
                            $('#accreditedData1').hide();
                    }
                });


                $('#supplier2').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData2').show(); 
                            $('#othersData2').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData2').show();
                            $('#accreditedData2').hide();
                    }
                });


                $('#supplier3').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData3').show(); 
                            $('#othersData3').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData3').show();
                            $('#accreditedData3').hide();
                    }
                });

                $('#supplier4').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData4').show(); 
                            $('#othersData4').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData4').show();
                            $('#accreditedData4').hide();
                    }
                });

                $('#supplier5').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData5').show(); 
                            $('#othersData5').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData5').show();
                            $('#accreditedData5').hide();
                    }
                });

                $('#supplier6').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData6').show(); 
                            $('#othersData6').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData6').show();
                            $('#accreditedData6').hide();
                    }
                });

                $('#supplier7').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData7').show(); 
                            $('#othersData7').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData7').show();
                            $('#accreditedData7').hide();
                    }
                });

                $('#supplier8').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData8').show(); 
                            $('#othersData8').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData8').show();
                            $('#accreditedData8').hide();
                    }
                });

                $('#supplier9').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData9').show(); 
                            $('#othersData9').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData9').show();
                            $('#accreditedData9').hide();
                    }
                });

                $('#supplier10').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData10').show(); 
                            $('#othersData10').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData10').show();
                            $('#accreditedData10').hide();
                    }
                });

                $('#supplier11').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData11').show(); 
                            $('#othersData11').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData11').show();
                            $('#accreditedData11').hide();
                    }
                });


                $('#supplier12').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData12').show(); 
                            $('#othersData12').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData12').show();
                            $('#accreditedData12').hide();
                    }
                });


                $('#supplier13').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData13').show(); 
                            $('#othersData13').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData13').show();
                            $('#accreditedData13').hide();
                    }
                });

                $('#supplier14').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData14').show(); 
                            $('#othersData14').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData14').show();
                            $('#accreditedData14').hide();
                    }
                });

                $('#supplier15').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData15').show(); 
                            $('#othersData15').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData15').show();
                            $('#accreditedData15').hide();
                    }
                });

                $('#supplier16').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData16').show(); 
                            $('#othersData16').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData16').show();
                            $('#accreditedData16').hide();
                    }
                });

                $('#supplier17').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData17').show(); 
                            $('#othersData17').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData17').show();
                            $('#accreditedData17').hide();
                    }
                });

                $('#supplier18').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData18').show(); 
                            $('#othersData18').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData18').show();
                            $('#accreditedData18').hide();
                    }
                });

                $('#supplier19').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData19').show(); 
                            $('#othersData19').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData19').show();
                            $('#accreditedData19').hide();
                    }
                });

                $('#supplier20').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData20').show(); 
                            $('#othersData20').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData20').show();
                            $('#accreditedData20').hide();
                    }
                });

                $('#supplier21').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData21').show(); 
                            $('#othersData21').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData21').show();
                            $('#accreditedData21').hide();
                    }
                });


                $('#supplier22').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData22').show(); 
                            $('#othersData22').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData22').show();
                            $('#accreditedData22').hide();
                    }
                });


                $('#supplier23').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData23').show(); 
                            $('#othersData23').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData23').show();
                            $('#accreditedData23').hide();
                    }
                });

                $('#supplier24').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData24').show(); 
                            $('#othersData24').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData24').show();
                            $('#accreditedData24').hide();
                    }
                });

                $('#supplier25').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData25').show(); 
                            $('#othersData25').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData25').show();
                            $('#accreditedData25').hide();
                    }
                });

                $('#supplier26').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData26').show(); 
                            $('#othersData26').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData26').show();
                            $('#accreditedData26').hide();
                    }
                });

                $('#supplier27').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData27').show(); 
                            $('#othersData27').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData27').show();
                            $('#accreditedData27').hide();
                    }
                });

                $('#supplier28').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData28').show(); 
                            $('#othersData28').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData28').show();
                            $('#accreditedData28').hide();
                    }
                });

                $('#supplier29').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData29').show(); 
                            $('#othersData29').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData29').show();
                            $('#accreditedData29').hide();
                    }
                });

                $('#supplier30').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData30').show(); 
                            $('#othersData30').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData30').show();
                            $('#accreditedData30').hide();
                    }
                });

                $('#supplier31').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData31').show(); 
                            $('#othersData31').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData31').show();
                            $('#accreditedData31').hide();
                    }
                });


                $('#supplier32').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData32').show(); 
                            $('#othersData32').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData32').show();
                            $('#accreditedData32').hide();
                    }
                });


                $('#supplier33').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData33').show(); 
                            $('#othersData33').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData33').show();
                            $('#accreditedData33').hide();
                    }
                });

                $('#supplier34').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData34').show(); 
                            $('#othersData34').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData34').show();
                            $('#accreditedData34').hide();
                    }
                });

                $('#supplier35').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData35').show(); 
                            $('#othersData35').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData35').show();
                            $('#accreditedData35').hide();
                    }
                });

                $('#supplier36').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData36').show(); 
                            $('#othersData36').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData36').show();
                            $('#accreditedData36').hide();
                    }
                });

                $('#supplier37').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData37').show(); 
                            $('#othersData37').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData37').show();
                            $('#accreditedData37').hide();
                    }
                });

                $('#supplier38').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData38').show(); 
                            $('#othersData38').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData38').show();
                            $('#accreditedData38').hide();
                    }
                });

                $('#supplier39').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData39').show(); 
                            $('#othersData39').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData39').show();
                            $('#accreditedData39').hide();
                    }
                });

                $('#supplier40').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData40').show(); 
                            $('#othersData40').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData40').show();
                            $('#accreditedData40').hide();
                    }
                });


                $('#supplier41').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData41').show(); 
                            $('#othersData41').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData41').show();
                            $('#accreditedData41').hide();
                    }
                });


                $('#supplier42').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData42').show(); 
                            $('#othersData42').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData42').show();
                            $('#accreditedData42').hide();
                    }
                });


                $('#supplier43').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData43').show(); 
                            $('#othersData43').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData43').show();
                            $('#accreditedData43').hide();
                    }
                });

                $('#supplier44').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData44').show(); 
                            $('#othersData44').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData44').show();
                            $('#accreditedData44').hide();
                    }
                });

                $('#supplier45').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData45').show(); 
                            $('#othersData45').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData45').show();
                            $('#accreditedData45').hide();
                    }
                });

                $('#supplier46').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData46').show(); 
                            $('#othersData46').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData46').show();
                            $('#accreditedData46').hide();
                    }
                });

                $('#supplier47').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData47').show(); 
                            $('#othersData47').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData47').show();
                            $('#accreditedData47').hide();
                    }
                });

                $('#supplier48').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData48').show(); 
                            $('#othersData48').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData48').show();
                            $('#accreditedData48').hide();
                    }
                });

                $('#supplier49').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData49').show(); 
                            $('#othersData49').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData49').show();
                            $('#accreditedData49').hide();
                    }
                });

                $('#supplier50').on('change', function() {
                    if(this.value == 'acc')
                    {
                            $('#accreditedData50').show(); 
                            $('#othersData50').hide();
                    }
                    else if(this.value == 'others')
                    {
                            $('#othersData50').show();
                            $('#accreditedData50').hide();
                    }
                });


                $('#dataAccredited1').on('change', function() {
                    var dta =  $('#dataAccredited1').val();
                    $('.supplierName1').val(dta); 
                });

                $('#dataOthers1').on('blur', function() {
                    var dta =  $('#dataOthers1').val();
                    $('.supplierName1').val(dta); 
                });

                $('#dataAccredited2').on('change', function() {
                    var dta =  $('#dataAccredited2').val();
                    $('.supplierName2').val(dta); 
                });

                $('#dataOthers2').on('blur', function() {
                    var dta =  $('#dataOthers2').val();
                    $('.supplierName2').val(dta); 
                });

                $('#dataAccredited3').on('change', function() {
                    var dta =  $('#dataAccredited3').val();
                    $('.supplierName3').val(dta); 
                });

                $('#dataOthers3').on('blur', function() {
                    var dta =  $('#dataOthers3').val();
                    $('.supplierName3').val(dta); 
                });

                $('#dataAccredited4').on('change', function() {
                    var dta =  $('#dataAccredited4').val();
                    $('.supplierName4').val(dta); 
                });

                $('#dataOthers4').on('blur', function() {
                    var dta =  $('#dataOthers4').val();
                    $('.supplierName4').val(dta); 
                });

                $('#dataAccredited5').on('change', function() {
                    var dta =  $('#dataAccredited5').val();
                    $('.supplierName5').val(dta); 
                });

                $('#dataOthers5').on('blur', function() {
                    var dta =  $('#dataOthers5').val();
                    $('.supplierName5').val(dta); 
                });

                $('#dataAccredited6').on('change', function() {
                    var dta =  $('#dataAccredited6').val();
                    $('.supplierName6').val(dta); 
                });

                $('#dataOthers6').on('blur', function() {
                    var dta =  $('#dataOthers6').val();
                    $('.supplierName6').val(dta); 
                });

                $('#dataAccredited7').on('change', function() {
                    var dta =  $('#dataAccredited7').val();
                    $('.supplierName7').val(dta); 
                });

                $('#dataOthers7').on('blur', function() {
                    var dta =  $('#dataOthers7').val();
                    $('.supplierName7').val(dta); 
                });

                $('#dataAccredited8').on('change', function() {
                    var dta =  $('#dataAccredited8').val();
                    $('.supplierName8').val(dta); 
                });

                $('#dataOthers8').on('blur', function() {
                    var dta =  $('#dataOthers8').val();
                    $('.supplierName8').val(dta); 
                });

                $('#dataAccredited9').on('change', function() {
                    var dta =  $('#dataAccredited9').val();
                    $('.supplierName9').val(dta); 
                });

                $('#dataOthers9').on('blur', function() {
                    var dta =  $('#dataOthers9').val();
                    $('.supplierName9').val(dta); 
                });

                $('#dataAccredited10').on('change', function() {
                    var dta =  $('#dataAccredited10').val();
                    $('.supplierName10').val(dta); 
                });

                $('#dataOthers10').on('blur', function() {
                    var dta =  $('#dataOthers10').val();
                    $('.supplierName10').val(dta); 
                });

                $('#dataAccredited11').on('change', function() {
                    var dta =  $('#dataAccredited11').val();
                    $('.supplierName11').val(dta); 
                });

                $('#dataOthers11').on('blur', function() {
                    var dta =  $('#dataOthers11').val();
                    $('.supplierName11').val(dta); 
                });

                $('#dataAccredited12').on('change', function() {
                    var dta =  $('#dataAccredited12').val();
                    $('.supplierName12').val(dta); 
                });

                $('#dataOthers12').on('blur', function() {
                    var dta =  $('#dataOthers12').val();
                    $('.supplierName12').val(dta); 
                });

                $('#dataAccredited13').on('change', function() {
                    var dta =  $('#dataAccredited13').val();
                    $('.supplierName13').val(dta); 
                });

                $('#dataOthers13').on('blur', function() {
                    var dta =  $('#dataOthers13').val();
                    $('.supplierName13').val(dta); 
                });

                $('#dataAccredited14').on('change', function() {
                    var dta =  $('#dataAccredited14').val();
                    $('.supplierName14').val(dta); 
                });

                $('#dataOthers14').on('blur', function() {
                    var dta =  $('#dataOthers14').val();
                    $('.supplierName14').val(dta); 
                });

                $('#dataAccredited15').on('change', function() {
                    var dta =  $('#dataAccredited15').val();
                    $('.supplierName15').val(dta); 
                });

                $('#dataOthers15').on('blur', function() {
                    var dta =  $('#dataOthers15').val();
                    $('.supplierName15').val(dta); 
                });

                $('#dataAccredited16').on('change', function() {
                    var dta =  $('#dataAccredited16').val();
                    $('.supplierName16').val(dta); 
                });

                $('#dataOthers16').on('blur', function() {
                    var dta =  $('#dataOthers16').val();
                    $('.supplierName16').val(dta); 
                });

                $('#dataAccredited17').on('change', function() {
                    var dta =  $('#dataAccredited17').val();
                    $('.supplierName17').val(dta); 
                });

                $('#dataOthers17').on('blur', function() {
                    var dta =  $('#dataOthers17').val();
                    $('.supplierName17').val(dta); 
                });

                $('#dataAccredited18').on('change', function() {
                    var dta =  $('#dataAccredited18').val();
                    $('.supplierName18').val(dta); 
                });

                $('#dataOthers18').on('blur', function() {
                    var dta =  $('#dataOthers18').val();
                    $('.supplierName18').val(dta); 
                });

                $('#dataAccredited19').on('change', function() {
                    var dta =  $('#dataAccredited19').val();
                    $('.supplierName19').val(dta); 
                });

                $('#dataOthers19').on('blur', function() {
                    var dta =  $('#dataOthers19').val();
                    $('.supplierName19').val(dta); 
                });

                $('#dataAccredited20').on('change', function() {
                    var dta =  $('#dataAccredited20').val();
                    $('.supplierName20').val(dta); 
                });

                $('#dataOthers20').on('blur', function() {
                    var dta =  $('#dataOthers20').val();
                    $('.supplierName20').val(dta); 
                });
              
                $('#dataAccredited21').on('change', function() {
                    var dta =  $('#dataAccredited21').val();
                    $('.supplierName21').val(dta); 
                });

                $('#dataOthers21').on('blur', function() {
                    var dta =  $('#dataOthers21').val();
                    $('.supplierName21').val(dta); 
                });

                $('#dataAccredited22').on('change', function() {
                    var dta =  $('#dataAccredited22').val();
                    $('.supplierName22').val(dta); 
                });

                $('#dataOthers22').on('blur', function() {
                    var dta =  $('#dataOthers22').val();
                    $('.supplierName22').val(dta); 
                });

                $('#dataAccredited23').on('change', function() {
                    var dta =  $('#dataAccredited23').val();
                    $('.supplierName23').val(dta); 
                });

                $('#dataOthers23').on('blur', function() {
                    var dta =  $('#dataOthers23').val();
                    $('.supplierName23').val(dta); 
                });

                $('#dataAccredited24').on('change', function() {
                    var dta =  $('#dataAccredited24').val();
                    $('.supplierName4').val(dta); 
                });

                $('#dataOthers24').on('blur', function() {
                    var dta =  $('#dataOthers24').val();
                    $('.supplierName24').val(dta); 
                });

                $('#dataAccredited25').on('change', function() {
                    var dta =  $('#dataAccredited25').val();
                    $('.supplierName25').val(dta); 
                });

                $('#dataOthers25').on('blur', function() {
                    var dta =  $('#dataOthers25').val();
                    $('.supplierName25').val(dta); 
                });

                $('#dataAccredited26').on('change', function() {
                    var dta =  $('#dataAccredited26').val();
                    $('.supplierName26').val(dta); 
                });

                $('#dataOthers26').on('blur', function() {
                    var dta =  $('#dataOthers26').val();
                    $('.supplierName26').val(dta); 
                });

                $('#dataAccredited27').on('change', function() {
                    var dta =  $('#dataAccredited27').val();
                    $('.supplierName27').val(dta); 
                });

                $('#dataOthers27').on('blur', function() {
                    var dta =  $('#dataOthers27').val();
                    $('.supplierName27').val(dta); 
                });

                $('#dataAccredited28').on('change', function() {
                    var dta =  $('#dataAccredited28').val();
                    $('.supplierName28').val(dta); 
                });

                $('#dataOthers28').on('blur', function() {
                    var dta =  $('#dataOthers28').val();
                    $('.supplierName28').val(dta); 
                });

                $('#dataAccredited29').on('change', function() {
                    var dta =  $('#dataAccredited29').val();
                    $('.supplierName29').val(dta); 
                });

                $('#dataOthers29').on('blur', function() {
                    var dta =  $('#dataOthers29').val();
                    $('.supplierName29').val(dta); 
                });

                $('#dataAccredited30').on('change', function() {
                    var dta =  $('#dataAccredited30').val();
                    $('.supplierName30').val(dta); 
                });

                $('#dataOthers30').on('blur', function() {
                    var dta =  $('#dataOthers30').val();
                    $('.supplierName30').val(dta); 
                });

                $('#dataAccredited31').on('change', function() {
                    var dta =  $('#dataAccredited31').val();
                    $('.supplierName31').val(dta); 
                });

                $('#dataOthers31').on('blur', function() {
                    var dta =  $('#dataOthers31').val();
                    $('.supplierName31').val(dta); 
                });

                $('#dataAccredited32').on('change', function() {
                    var dta =  $('#dataAccredited32').val();
                    $('.supplierName32').val(dta); 
                });

                $('#dataOthers32').on('blur', function() {
                    var dta =  $('#dataOthers32').val();
                    $('.supplierName32').val(dta); 
                });

                $('#dataAccredited33').on('change', function() {
                    var dta =  $('#dataAccredited33').val();
                    $('.supplierName33').val(dta); 
                });

                $('#dataOthers33').on('blur', function() {
                    var dta =  $('#dataOthers33').val();
                    $('.supplierName33').val(dta); 
                });

                $('#dataAccredited34').on('change', function() {
                    var dta =  $('#dataAccredited34').val();
                    $('.supplierName34').val(dta); 
                });

                $('#dataOthers34').on('blur', function() {
                    var dta =  $('#dataOthers34').val();
                    $('.supplierName34').val(dta); 
                });

                $('#dataAccredited35').on('change', function() {
                    var dta =  $('#dataAccredited35').val();
                    $('.supplierName35').val(dta); 
                });

                $('#dataOthers35').on('blur', function() {
                    var dta =  $('#dataOthers35').val();
                    $('.supplierName35').val(dta); 
                });

                $('#dataAccredited36').on('change', function() {
                    var dta =  $('#dataAccredited36').val();
                    $('.supplierName36').val(dta); 
                });

                $('#dataOthers36').on('blur', function() {
                    var dta =  $('#dataOthers36').val();
                    $('.supplierName36').val(dta); 
                });

                $('#dataAccredited37').on('change', function() {
                    var dta =  $('#dataAccredited37').val();
                    $('.supplierName37').val(dta); 
                });

                $('#dataOthers37').on('blur', function() {
                    var dta =  $('#dataOthers37').val();
                    $('.supplierName37').val(dta); 
                });

                $('#dataAccredited38').on('change', function() {
                    var dta =  $('#dataAccredited38').val();
                    $('.supplierName38').val(dta); 
                });

                $('#dataOthers38').on('blur', function() {
                    var dta =  $('#dataOthers38').val();
                    $('.supplierName38').val(dta); 
                });

                $('#dataAccredited39').on('change', function() {
                    var dta =  $('#dataAccredited39').val();
                    $('.supplierName39').val(dta); 
                });

                $('#dataOthers39').on('blur', function() {
                    var dta =  $('#dataOthers39').val();
                    $('.supplierName39').val(dta); 
                });

                $('#dataAccredited40').on('change', function() {
                    var dta =  $('#dataAccredited40').val();
                    $('.supplierName40').val(dta); 
                });

                $('#dataOthers40').on('blur', function() {
                    var dta =  $('#dataOthers40').val();
                    $('.supplierName40').val(dta); 
                });

                $('#dataAccredited41').on('change', function() {
                    var dta =  $('#dataAccredited41').val();
                    $('.supplierName41').val(dta); 
                });

                $('#dataOthers41').on('blur', function() {
                    var dta =  $('#dataOthers41').val();
                    $('.supplierName41').val(dta); 
                });

                $('#dataAccredited42').on('change', function() {
                    var dta =  $('#dataAccredited42').val();
                    $('.supplierName42').val(dta); 
                });

                $('#dataOthers42').on('blur', function() {
                    var dta =  $('#dataOthers42').val();
                    $('.supplierName42').val(dta); 
                });

                $('#dataAccredited43').on('change', function() {
                    var dta =  $('#dataAccredited43').val();
                    $('.supplierName43').val(dta); 
                });

                $('#dataOthers43').on('blur', function() {
                    var dta =  $('#dataOthers43').val();
                    $('.supplierName43').val(dta); 
                });

                $('#dataAccredited44').on('change', function() {
                    var dta =  $('#dataAccredited4').val();
                    $('.supplierName4').val(dta); 
                });

                $('#dataOthers44').on('blur', function() {
                    var dta =  $('#dataOthers44').val();
                    $('.supplierName44').val(dta); 
                });

                $('#dataAccredited45').on('change', function() {
                    var dta =  $('#dataAccredited45').val();
                    $('.supplierName45').val(dta); 
                });

                $('#dataOthers45').on('blur', function() {
                    var dta =  $('#dataOthers45').val();
                    $('.supplierName45').val(dta); 
                });

                $('#dataAccredited46').on('change', function() {
                    var dta =  $('#dataAccredited46').val();
                    $('.supplierName46').val(dta); 
                });

                $('#dataOthers46').on('blur', function() {
                    var dta =  $('#dataOthers46').val();
                    $('.supplierName46').val(dta); 
                });

                $('#dataAccredited47').on('change', function() {
                    var dta =  $('#dataAccredited47').val();
                    $('.supplierName47').val(dta); 
                });

                $('#dataOthers47').on('blur', function() {
                    var dta =  $('#dataOthers47').val();
                    $('.supplierName47').val(dta); 
                });

                $('#dataAccredited48').on('change', function() {
                    var dta =  $('#dataAccredited48').val();
                    $('.supplierName48').val(dta); 
                });

                $('#dataOthers48').on('blur', function() {
                    var dta =  $('#dataOthers48').val();
                    $('.supplierName48').val(dta); 
                });

                $('#dataAccredited49').on('change', function() {
                    var dta =  $('#dataAccredited49').val();
                    $('.supplierName49').val(dta); 
                });

                $('#dataOthers49').on('blur', function() {
                    var dta =  $('#dataOthers49').val();
                    $('.supplierName49').val(dta); 
                });

                $('#dataAccredited50').on('change', function() {
                    var dta =  $('#dataAccredited50').val();
                    $('.supplierName50').val(dta); 
                });

                $('#dataOthers50').on('blur', function() {
                    var dta =  $('#dataOthers50').val();
                    $('.supplierName50').val(dta); 
                });
              
                f++;
            }
        });

        $("#form_field").on('click','#fremove',function(){
            $(this).closest('#form').remove();
            f--;
        });

        $('#accreditedData').hide();
        $('#othersData').hide();

        $('#supplier').on('change', function() {
           if(this.value == 'acc')
           {
                $('#accreditedData').show(); 
                $('#othersData').hide();
           }
           else if(this.value == 'others')
           {
                $('#othersData').show();
                $('#accreditedData').hide();
           }
        });

        $('#dataAccredited').on('change', function() {
           var dta =  $('#dataAccredited').val();
           $('.supplierName').val(dta); 
        });

        $('#dataOthers').on('blur', function() {
           var dta =  $('#dataOthers').val();
           $('.supplierName').val(dta); 
        });

        $('#process').click(function() {
            if(f < 3) {
                var a = confirm("You have encoded less than 3 suppliers. Are you sure you want to proceed?");
                if (a == true) {
                    var canvassNo = $('#canvassNo').val(); 
                    $('#report').attr('action', 'report_matsource_add_supplier/'+canvassNo+'');
                    $('#report').submit();
                } else {
                    return false;
                } 
            } else {
                var canvassNo = $('#canvassNo').val(); 
                $('#report').attr('action', 'report_matsource_add_supplier/'+canvassNo+'');
                $('#report').submit();
            }
		});
    
    });
</script>