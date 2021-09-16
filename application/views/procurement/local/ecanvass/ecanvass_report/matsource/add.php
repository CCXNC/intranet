<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=date] {
        font-size: 12px;
    }
</style>
<p style="text-align:left"><img class="card-img-top" style="" src="<?php echo base_url(); ?>assets/images/step2.png" alt=""></p>
<div class="card" style="font-size:12px;">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS REPORT GENERATION<a href="<?php echo base_url(); ?>procurement/ecanvass_report_generation" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px;"><h5>Comparative Statement Quotations</h5></div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source ID</label>
                                <input type="text" class="form-control" name="first_name"  id="myTextbox" style="text-transform:uppercase; background-color:white">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source Request Date</label>
                                <input type="date" class="form-control" name="first_name" id="dateRequested" style="background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control" name="first_name" id="company" style="background-color:white" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >PR Number</label>
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >PR Date</label>
                                <input type="date" class="form-control" name="first_name" value="<?php echo date('Y-m-d'); ?>">
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
                                <th scope="col">Mat Code</th>
                                <th scope="col">Description</th>
                                <th scope="col">QTY</th>
                                <th scope="col">UOM</th>
                                <th scope="col">Currency</th>
                                <th scope="col">Previous Purchase Per Unit</th>
                                <th scope="col">Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="form_field">
                            <!--<tr>
                                <td data-label="Description & Specs">Material 1</td>
                                <td data-label="Mat Code"> 01010101 </td>
                                <td data-label="QTY">1000</td>
                                <td data-label="UOM"></td>
                                <td data-label="Currency"><input type="text" class="form-control" name="currency[]"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price_per_unit[]"></td>
                                <td data-label="Year"><input type="text" class="form-control" name="year"></td>
                                <td><div class="btn btn-sm btn-danger">Remove</div></td>
                            </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <a href="<?php echo base_url(); ?>procurement/report_matsource_add1" style="margin-left:10px;" class="float-right btn btn-info">NEXT</a>
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
                            var form = ' <tr id="child"><td data-label="Mat Code">'+object['mcode']+'</td><td data-label="Description & Specs">'+object['description']+'</td> <td data-label="QTY">'+object['quantity']+'</td> <td data-label="UOM">'+object['uom']+'</td><td data-label="Currency"><input type="text" class="form-control" name="currency[]"></td><td data-label="Price"><input type="text" class="form-control" name="price_per_unit[]"></td><td data-label="Year"><input type="text" class="form-control" name="year"></td><td> <input class="btn btn-danger btn-sm" style="width: 80px" type="button" name="remove" id="cremove" value="Remove"></td>></tr>';
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