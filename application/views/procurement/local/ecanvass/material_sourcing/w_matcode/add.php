<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=date] {
        font-size: 12px;
    }
    input[type=number] {
        font-size: 12px;
    }
</style>
<p style="text-align:left"><img class="card-img-top" style="" src="<?php echo base_url(); ?>assets/images/sourcing_step2.png" alt=""></p>
<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>ELECTRONIC MATERIAL SOURCING REQUEST FORM<a href="<?php echo base_url(); ?>procurement/material_sourcing" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>procurement/material_sourcing_matcode" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Business Unit</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                        <input class="form-check-input" type="radio" name="company" id="flexRadioDefault1" value="2">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            <p>BMC</p>
                                        </label>
                                    </div>
                                    <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                        <input class="form-check-input" type="radio" name="company" id="flexRadioDefault1" value="1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            <p>RRLC</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Date Required</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input name="date_required" type="date" class="form-control" id="#required_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Sourcing Category</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1"  name="sourcing_category" style="font-size:12px;height:32px">
                                <option value="" selected>Select Category</option>
                                <option value="Price Only">Price Only</option>
                                <option value="Sample Only">Sample Only</option>
                                <option value="Price w/ Sample">Price w/ Sample</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">MATERIAL DETAILS</div>
                <div class="card-body" id="form_field" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Material Code</label>&nbsp;<i class="verified" style="color:green;"></i>
                                <input type="text" class="form-control" id="myTextbox" id="check" name="material_code[]" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <input type="text" class="form-control"  id="description" readonly name="description[]" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Specification</label>
                                <textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification[]" rows="1" ></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" name="quantity[]" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">UOM</label>
                                <select class="form-control" name="uom[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1">
                                <option value=" ">Select UOM</option>
                                <?php if($uoms) : ?>
                                    <?php foreach($uoms as $uom) : ?>
                                        <option value="<?php echo $uom->name; ?>"><?php echo $uom->name; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Shelf Life (Months)</label>
                                <input type="number" class="form-control" name="shelf_life[]" placeholder=""> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Purpose/Remarks</label>
                                <textarea class="form-control" style="font-size:12px" id="" name="purpose[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Item Application</label>
                                <textarea class="form-control" id="" style="font-size:12px" name="item_application[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Required Document</label>
                                <textarea class="form-control" style="font-size:12px" id="exampleFormControlTextarea1" name="required_document[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Material Group</label>
                                    <input type="text" class="form-control"  id="materialGroup" readonly name="material_category[]" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>File Attachment</label>
                                <input type='file' name='attachment[]' size='20' />
                            </div>
                        </div> 
                    </div>
                    <input class="btn btn-success" title="Add Form" type="button" name="add" id="fadd" value="ADD">
                    <br>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; font-size:15px; color:white">APPROVAL DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Other Notes</label>
                            <textarea class="form-control" style="font-size:12px" name="remarks" id="exampleFormControlTextarea1" rows="1"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Step/Approver</label>
                        </div>
                        <div class="col-md-4">
                            <label for="">Primary Approver</label>
                        </div>
                        <div class="col-md-4">
                            <label for="">Alternate Approver</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Requestor</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select style="color:black;font-size:12px" name="requestor_primary1"  class="form-control" > 
                                    <option value="">Select Primary Approver</option> 
                                    <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                        <option value="<?php echo $employee->fullname.'|'. $employee->emp_no ; ?>"<?php echo $this->session->userdata('employee_number') ==  $employee->emp_no ? 'selected' : ''; ?>><?php echo $employee->fullname; ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select style="color:black;font-size:12px" name="requestor_alternate1" class="form-control">
                                    <option value="">Select Alternate Approver</option>
                                    <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                        <option value="<?php echo $employee->fullname.'|'. $employee->emp_no ; ?>"><?php echo $employee->fullname;?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">Immediate Superior Approval</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select style="color:black;font-size:12px" name="requestor_primary2" class="form-control">
                                    <option value="">Select Primary Approver</option>
                                    <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                        <option value="<?php echo $employee->fullname.'|'. $employee->emp_no ; ?>"><?php echo $employee->fullname;?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select style="color:black;font-size:12px" name="requestor_alternate2"  class="form-control">
                                    <option value="">Select Alternate Approver</option>
                                    <?php if($employees) : ?>
                                    <?php foreach($employees as $employee) : ?>
                                        <option value="<?php echo $employee->fullname.'|'. $employee->emp_no ; ?>"><?php echo $employee->fullname;?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>                    

            <center>
                <div class="form-group">
                    <input type="submit" title="Submit Employee Information" id="process" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        // FIRST MATERIAL POST
        $.ajax({
            url:"<?php echo base_url();?>/procurement/json_material",
            dataType:'text',
            type:"POST",
            success: function(result){
                var obj = $.parseJSON(result);
                $.each(obj,function(index,object){
                    $('#myTextbox').blur(function(e) {
                        var mcodeType = $(this).val();
                        if(mcodeType == object['mcode']) {
                            console.log('SUCCESS');
                            $('#description').val(object['description']);
                            $('#materialGroup').val(object['group_name']);
                            $('.verified').addClass("fas fa-check");
                        }
                    });
                });
                
            }
        })

        // LIMIT OF ADD MATERIAL CODE class="fa fa-times"
        var fmax = 20;
        var f = 1;

        $("#fadd").click(function(){
            if(f <= fmax) {
                $.ajax({
                    url:"<?php echo base_url();?>/procurement/json_material",
                    dataType:'text',
                    type:"POST",
                    success: function(result){
                        
                        var form = '<div id="form"><br><hr><br><div class="row"><div class="col-md-3"><div class="form-group"><label>Material Code</label>&nbsp;<i class="verified'+f+'" style="color:green;"></i><input type="text" class="form-control" id="myTextbox'+f+'" name="material_code[]" placeholder=""></div></div><div class="col-md-3"><div class="form-group"><label for="exampleFormControlTextarea1">Description</label><input type="text" class="form-control" readonly id="description'+f+'" name="description[]" placeholder=""></div></div><div class="col-md-6"><div class="form-group"><label for="exampleFormControlTextarea1">Specification</label><textarea style="background-color:white; font-size:12px" class="form-control" id="" name="specification[]" rows="1" ></textarea></div></div><div class="col-md-3"><div class="form-group"><label>Quantity</label><input type="number" class="form-control" name="quantity[]" placeholder=""></div></div><div class="col-md-3"><div class="form-group"><label for="exampleFormControlSelect1">UOM</label><select class="form-control" name="uom[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1"><option value=" ">Select UOM</option><?php if($uoms) : ?><?php foreach($uoms as $uom) : ?><option value="<?php echo $uom->name; ?>"><?php echo $uom->name; ?></option><?php endforeach; ?><?php endif; ?></select></div></div><div class="col-md-3"><div class="form-group"><label>Shelf Life (Months)</label><input type="number" class="form-control" name="shelf_life[]" placeholder=""></div></div><div class="col-md-3"><div class="form-group"><label for="exampleFormControlTextarea1">Purpose/Remarks</label><textarea class="form-control" style="font-size:12px" id="" name="purpose[]" rows="1"></textarea></div></div><div class="col-md-3"><div class="form-group"><label for="exampleFormControlTextarea1">Item Application</label><textarea class="form-control" id="" style="font-size:12px" name="item_application[]" rows="1"></textarea></div></div><div class="col-md-3"><div class="form-group"><label for="exampleFormControlTextarea1">Required Document</label><textarea class="form-control" style="font-size:12px" id="exampleFormControlTextarea1" name="required_document[]" rows="1"></textarea></div></div><div class="col-md-3"><div class="form-group"><label for="exampleFormControlSelect1">Material Group</label><input type="text" class="form-control"  id="materialGroup'+f+'" readonly name="material_category[]" placeholder=""></div></div><div class="col-md-3"><div class="form-group"><label>File Attachment</label><input type="file" name="attachment[]" size="20" /></div></div></div><input class="btn btn-danger" type="button" name="remove" id="fremove" value="Remove"></div>';
                        $("#form_field").append(form);

                        var obj = $.parseJSON(result);
                        $.each(obj,function(index,object){
                            $('#myTextbox'+f+'').blur(function(e) {
                                var mcodeType = $(this).val();
                                if(mcodeType == object['mcode']) {
                                    console.log('SUCCESS');
                                    $('#description'+f+'').val(object['description']);
                                    $('#materialGroup'+f+'').val(object['group_name']);
                                    $('.verified'+f+'').addClass("fas fa-check");
                                } 
                            });
                        });
                       
                    }
                })
              
                f++;
            }
        });
        $("#form_field").on('click','#fremove',function(){
            $(this).closest('#form').remove();
            f--;
        });
       
          
        var required_date_input = document.getElementById("#required_date")

        var n =  new Date();
        var y = n.getFullYear();
        var m = n.getMonth() + 1;
        var d = n.getDate() + 1;
        if(m < 12)
        m = '0' + m.toString();
        else if(d < 12)
        d = '0' + d.toString();

        var minDate = y + '-' + m + '-' + d

        required_date_input.setAttribute("min",minDate)


      
    });
</script>