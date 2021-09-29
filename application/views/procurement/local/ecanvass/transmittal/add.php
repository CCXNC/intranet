<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=date] {
        font-size: 12px;
    }
</style>
<div class="card" style="font-size:12px;">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>MATERIAL SAMPLE TRANSMITTAL<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>procurement/transmittal" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px;">TRANSMITTAL DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source ID</label>
                                <input type="text" class="form-control" id="myTextbox" name="msid" style="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source Request Date</label>
                                <input type="date" class="form-control" id="dateRequested" name="ms_request_date" style="background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Company</label>
                                <input type="text" class="form-control" name="company" id="company" style="background-color:white" readonly>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px">REQUEST DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >To Requestor</label>
                                <input type="text" class="form-control" name="requestor" id="requestor" style="background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Transmittal Date</label>
                                <input type="date" class="form-control" name="transmittal_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Email </label>
                                <input type="text" class="form-control" name="email" id="email" value="" style="background-color:white" readonly>
                            </div>
                        </div>
                      
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >RE: </label>
                                <input type="text" class="form-control" name="subject" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >File Attachment</label><br>
                                <input type='file' class name='attachment' size='20' />
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <div class="card">
                <div class="card-body" style="background-color: #E9FAFD;">
                    <table id="" class="table table-striped"  style="width:100%">
                        <thead>
                            <tr style="background-color:#0D635D; color:white;">
                                <th scope="col">Material Description</th>
                                <th scope="col">Supplier</th>
                                <th></th>
                                <th scope="col">Batch Number</th>
                                <th scope="col">Supporting Documents</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="form_field">
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <a href="" style="margin-left:10px;" class="float-right btn btn-danger">CANCEL</a>
            <input type="submit" class="float-right btn btn-info" value="SUBMIT">   
        </form>
    </div>
</div>
<script>
     $(document).ready(function(){

        $.ajax({
            url:"<?php echo base_url();?>/procurement/json_material_sourcing_list",
            dataType:'text',
            type:"POST",
            success: function(result){
                var obj = $.parseJSON(result);
                var f = 1;
                //console.log(obj);
                $.each(obj,function(index,object){
                    $('#myTextbox').blur(function(e) {
                        var mcodeType = $(this).val();
                        if(mcodeType == object['msid']) {
                            var form = "<tr id='child'><td data-label='Description'><input type='text' id='' class='form-control' name='description[]' value='"+object['description']+"'></td><td data-label='Supplier'><div class=''><div class='form-group'><select class='form-control' id='supplier"+f+"' style='font-size:12px; height:32px' name='supplier[]'><option value=''>SELECT SUPPLIER</option><option value='acc'>ACCREDITED</option><option value='others'>OTHERS</option></select></div></div></td><td><div class='' id='accreditedData"+f+"'><div class='form-group'><select name='accredited[]' class='form-control' id='dataAccredited"+f+"' style=' font-size: 12px;height:32px; width: 200px;'><option value=' '>Select Supplier Name</option><?php if($suppliers) : ?><?php foreach($suppliers as $supplier) : ?><option value='<?php echo $supplier->name; ?>'><?php echo $supplier->name; ?></option><?php endforeach; ?><?php endif; ?></select></div></div><div class='' id='othersData"+f+"'><div class='form-group'><input type='text' name='others[]' id='dataOthers"+f+"' class='form-control'></div></div></td><td data-label='Price'><input type='text' class='form-control' name='batch_number[]'></td><td data-label='Year'><input type='file' size='20' name='attachment[]'></td><td><input class='btn btn-danger btn-sm' style='width: 80px' type='button' name='remove' id='cremove' value='Remove'></td></tr>";
                            $("#form_field").append(form);

                            $('#accreditedData1').hide();
                            $('#othersData1').hide();

                            $('#accreditedData2').hide();
                            $('#othersData2').hide();

                            $('#accreditedData3').hide();
                            $('#othersData3').hide();

                            $('#accreditedData4').hide();
                            $('#othersData4').hide();

                            $('#accreditedData5').hide();
                            $('#othersData5').hide();

                            $('#accreditedData6').hide();
                            $('#othersData6').hide();

                            $('#accreditedData7').hide();
                            $('#othersData7').hide();

                            $('#accreditedData8').hide();
                            $('#othersData8').hide();

                            $('#accreditedData9').hide();
                            $('#othersData9').hide();

                            $('#accreditedData10').hide();
                            $('#othersData10').hide();

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

                            f++;
                        }
                    });
                    
                    
                });
                
            }
        });

        $.ajax({
            url:"<?php echo base_url();?>/procurement/json_material_sourcing",
            dataType:'text',
            type:"POST",
            success: function(result){
                var obj1 = $.parseJSON(result);
                //console.log(obj1);
                $.each(obj1,function(index,object){
                    $('#myTextbox').blur(function(e) {
                        var mcodeType = $(this).val();
                        if(mcodeType == object['msid']) {
                            if(object['company_id'] == '1') {
                                $('#company').val('RRLC');
                            } else if(object['company_id'] == '2') {
                                $('#company').val('BMC');
                            }   
                            $('#dateRequested').val(object['date_required']);
                            
                        }
                    });
                });
                
            }
        });

        $.ajax({
            url:"<?php echo base_url();?>/procurement/json_material_restriction",
            dataType:'text',
            type:"POST",
            success: function(result){
                var obj1 = $.parseJSON(result);

                $.each(obj1, function(index, object){
                    $('#myTextbox').blur(function(e) {
                        var mcodeType = $(this).val();
                        if(mcodeType == object['msid']) {
                            $('#email').val(object['email']);
                            $('#requestor').val(object['fullname']);
                        }
                    });
                });
            }
        });

        $("#form_field").on('click','#cremove',function(){
            $(this).closest('#child').remove();
        });
        
     });    

</script>