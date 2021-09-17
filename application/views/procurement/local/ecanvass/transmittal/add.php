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
        <form method="post" action="" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" name="requestor" style="text-transform:uppercase">
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
                                <input type="text" class="form-control" name="email" value="blaineintranet@blainegroup.com.ph; test@blainegroup.com.ph;" >
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
                                <input type='file' class name='attachment[]' size='20' />
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
                //console.log(obj);
                $.each(obj,function(index,object){
                    $('#myTextbox').blur(function(e) {
                        var mcodeType = $(this).val();
                        if(mcodeType == object['msid']) {
                            var form = '<tr id="child"><td data-label="Description">'+object['description']+'</td><td data-label="Supplier"><input type="text" class="form-control" name="supplier_name[]"></td><td data-label="Price"><input type="text" class="form-control" name="batch_number[]"></td><td data-label="Year"><input type="file" size="20" name="attachment[]"></td><td> <input class="btn btn-danger btn-sm" style="width: 80px" type="button" name="remove" id="cremove" value="Remove"></td></tr>';
                            $("#form_field").append(form);
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

        $("#form_field").on('click','#cremove',function(){
            $(this).closest('#child').remove();
        });
        
     });    

</script>