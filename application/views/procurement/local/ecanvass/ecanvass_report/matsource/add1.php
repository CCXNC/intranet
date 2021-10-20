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
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS REPORT GENERATION 2<a href="<?php echo base_url(); ?>procurement/report_matsource_add" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>procurement/report_matsource_add_supplier/<?php echo $canvass->canvass_no; ?>/<?php echo $canvass->material_pr_no; ?>" enctype="multipart/form-data">
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
                                                <td data-label="MOQ"><input type="number" class="form-control" name="moq[]" value="0"></td>
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
                                            <option value="" selected></option>
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
                                        <input type="text" name="pmt[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">DEL (Days)</label>
                                        <input type="text" name="del[]" class="form-control">
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
                        </div>
                    
                        <div class="col-md-6">
                            <input class="btn btn-success" title="Add Form" type="button" name="add" id="fadd" value="ADD">
                        </div>
                    </div>
                    <br><br>
                </div>  
                
            </div>
            <br>
            <input type="submit"  style="margin-left:10px;" class="float-right btn btn-info" value="NEXT">
        </form>
    </div>
</div>


<script>
    $(document).ready(function(){

        // LIMIT OF ADD MATERIAL CODE class="fa fa-times"
        var fmax = 20;
        var f = 1;

        $("#fadd").click(function(){

            if(f <= fmax) {
              
                var form = "<div id='form'><div class='row'><div class='col-md-4'><label for=''>Select Supplier</label><div class='form-group'><select style='font-size:12px; height:32px' class='form-control' id='supplier"+f+"'  name='supplier[]' style='font-size:12px;'><option value='aa'>SELECT SUPPLIER</option><option value='acc'>ACCREDITED</option><option value='others'>OTHERS</option></select></div></div><div class='col-md-4' id='accreditedData"+f+"' style='display:none;'><div class='form-group'><label for=''>Supplier`s Name</label><select name='accredited[]' id='dataAccredited"+f+"' class='form-control' style=' font-size: 12px;'> <option value=' '>Select Supplier Name</option><?php if($suppliers) : ?><?php foreach($suppliers as $supplier) : ?><option value='<?php echo $supplier->name; ?>'><?php echo $supplier->name; ?></option><?php endforeach; ?><?php endif; ?></select></div></div><div class='col-md-4' id='othersData"+f+"'style='display:none;'><div class='form-group'><label for=''>Supplier`s Name</label><input type='text' name='others[]' id='dataOthers"+f+"' class='form-control'></div></div></div><div class='row'><div class='col-md-8'><table id='' class='table table-striped'  style='width:100%'><thead><tr style='background-color:#0D635D; color:white;'><th scope='col'>Material</th><th scope='col'>QTY</th><th scope='col'>UOM</th><th scope='col'>MOQ</th><th scope='col'>Price Per UOM</th><th scope='col'>Currency</th></tr></thead><tbody><?php if($materials) : ?><?php foreach($materials as $material) : ?><tr><td hidden><input type='text' hidden name='supplier_name[]' class='supplierName"+f+"'></td><td hidden><input type='text' name='id[]' hidden value='<?php echo $material->id; ?>'></td><td data-label='Description & Specs'><input type='text' name='description[]' hidden value='<?php echo $material->description; ?>'><?php echo $material->description; ?></td><td data-label='QTY'><input type='text' name='quantity[]' hidden value='<?php echo $material->quantity; ?>'><?php echo $material->quantity; ?></td><td data-label='UOM'><input type='text' name='uom[]' hidden value='<?php echo $material->uom; ?>'><?php echo $material->uom; ?></td><td data-label='MOQ'><input type='number' class='form-control' name='moq[]' value='0'></td><td data-label='Price'><input type='text' class='form-control' name='price[]' value='0'></td><td data-label='Currency'><select name='currency[]' style='font-size:12px; height:32px' class='form-control' id='' style='font-size:12px;'><option value=''></option><option selected='selected' value='PHP'>PHP</option><option value='USD'>USD</option><option value='POUND'>POUND</option><option value='YUAN'>YUAN</option><option value='EURO'>EURO</option></select></td></tr><?php endforeach; ?><?php endif; ?></tbody></table></div><div class='col-md-4'><div style='background-color: #0D635D; color: white; padding:7px 5px 4px 5px; border-radius:5px; font-size:14px;'>Purchase Term</div><div class='row' style='margin-top:10px;'><div class='col-md-6'><div class='form-group'><label for='exampleFormControlSelect1'>VAT</label><select class='form-control' name='vat[]' style='font-size:12px; height:32px' id='exampleFormControlSelect1'><option value='' selected></option><option value='INC'>INC</option><option value='EX'>EX</option></select></div></div><div class='col-md-6'><div class='form-group'><label for=''>WRT</label><input type='text' name='wrt[]' class='form-control'></div></div></div><div class='row'><div class='col-md-6'><div class='form-group'><label for=''>PMT (Days)</label><input type='text' name='pmt[]' class='form-control'></div></div><div class='col-md-6'><div class='form-group'><label for=''>DEL (Days)</label><input type='text' name='del[]' class='form-control'></div></div></div><div class='row'><div class='col-md-12'><div class='form-group'><label for=''>Notes</label><textarea style='font-size:12px' class='form-control' name='notes[]' id='' rows='1'></textarea></div></div></div></div></div><input class='btn btn-danger' type='button' name='remove' id='fremove' value='Remove'></div><br>";
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


    
    });
</script>