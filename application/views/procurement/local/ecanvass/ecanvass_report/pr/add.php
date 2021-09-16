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
        <form method="post" action="<?php echo base_url(); ?>procurement/report_pr_add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px;"><h5>Comparative Statement Quotations</h5></div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >PR Number</label>
                                <input type="text" class="form-control" name="pr_no">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >PR Date</label>
                                <input type="date" class="form-control" name="pr_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Company</label>
                                <select name="company" class="form-control" style="font-size:12px; height:32px" style="font-size:12px;">
                                    <option value="RRLC">RRLC</option>
                                    <option value="BMC">BMC</option>
                                </select>
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
                                <th scope="col">Previous Purchase Per Unit</th>
                                <th>Currency</th>
                                <th scope="col">Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="form_field">
                            <tr >
                                <td>
                                    <input type="text" class="form-control" id="mCode" name="mat_code[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="description" name="description[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="qty[]">
                                </td>
                                <td>
                                    <select class="form-control" name="uom[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1">
                                        <option value=" ">SELECT UOM</option>
                                        <?php if($uoms) : ?>
                                            <?php foreach($uoms as $uom) : ?>
                                                <option value="<?php echo $uom->name; ?>"><?php echo $uom->name; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="previous[]">
                                </td>
                                <td>
                                    <select name="currency[]" class="form-control" style="font-size:12px; height:32px" style="font-size:12px;">
                                        <option value=""></option>
                                            <option selected="selected" value="PHP">PHP</option>
                                            <option value="USD">USD</option>
                                            <option value="POUND">POUND</option>
                                            <option value="YUAN">YUAN</option>
                                            <option value="EURO">EURO</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="year[]" style="text-transform:uppercase">
                                </td>
                                <td>
                                    <input class="btn btn-success btn-sm" style="width:80px" title="Add Children" type="button" name="add" id="fadd" value="Add">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <input type="submit" style="margin-left:10px;" class="float-right btn btn-info" value="NEXT">
            <!--<a href="<?php echo base_url(); ?>procurement/report_pr_add1" style="margin-left:10px;" class="float-right btn btn-info">NEXT</a>-->
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
                    $('#mCode').blur(function(e) {
                        var mcodeType = $(this).val();
                        if(mcodeType == object['mcode']) {
                            console.log('SUCCESS');
                            $('#description').val(object['description']);
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
                        
                        var form = '<tr id="child"><br><td><input type="text" class="form-control" id="mCode'+f+'" name="mat_code[]"></td><td><input type="text" class="form-control" id="description'+f+'" name="description[]"></td><td><input type="text" class="form-control" name="qty[]"></td><td><select class="form-control" name="uom[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1"><option value=" ">SELECT UOM</option><?php if($uoms) : ?><?php foreach($uoms as $uom) : ?><option value="<?php echo $uom->name; ?>"><?php echo $uom->name; ?></option><?php endforeach; ?><?php endif; ?></select></td><td><input type="text" class="form-control" name="previous[]"></td><td><select name="currency[]" class="form-control" style="font-size:12px; height:32px" style="font-size:12px;"><option value=""></option><option selected="selected" value="PHP">PHP</option><option value="USD">USD</option><option value="POUND">POUND</option><option value="YUAN">YUAN</option><option value="EURO">EURO</option></select></td><td><input type="text" class="form-control" name="year[]" style="text-transform:uppercase"></td><td> <input class="btn btn-danger btn-sm" style="width: 80px" type="button" name="remove" id="cremove" value="Remove"></td></tr>';
                        $("#form_field").append(form);

                        var obj = $.parseJSON(result);
                        $.each(obj,function(index,object){
                            $('#mCode'+f+'').blur(function(e) {
                                var mcodeType = $(this).val();
                                if(mcodeType == object['mcode']) {
                                    console.log('SUCCESS');
                                    $('#description'+f+'').val(object['description']);
                                } 
                            });
                        });
                       
                    }
                })
              
                f++;
            }
        });
        $("#form_field").on('click','#cremove',function(){
            $(this).closest('#child').remove();
            f--;
        });

        //var children = '<tr id="child"><br><td><input type="text" class="form-control" name="mat_code[]"></td><td><input type="text" class="form-control" name="description[]"></td><td><input type="text" class="form-control" name="qty[]"></td><td><input type="text" class="form-control" name="uom[]"></td><td><input type="text" class="form-control" name="previous[]"></td><td><input type="text" class="form-control" name="year[]" style="text-transform:uppercase"></td><td> <input class="btn btn-danger btn-sm" style="width: 80px" type="button" name="remove" id="cremove" value="Remove"></td></tr>';

    });
</script>
