<script type="text/javascript">
    $(document).ready(function(){
        
        var form = '<div id="form"><br><div class="row"><div class="col-md-4"><div class="form-group"><label for="exampleFormControlTextarea1">Description</label><textarea class="form-control" id="" name="description[]" rows="1"></textarea></div></div><div class="col-md-8"><div class="form-group"><label for="exampleFormControlTextarea1">Specification</label><textarea class="form-control" id="" name="specification[]" rows="1"></textarea></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label>Quantity</label><input type="number" class="form-control" name="quantity[]" placeholder=""></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlSelect1">UOM</label><select class="form-control" name="uom[]" id="exampleFormControlSelect1"><option value="" disabled selected>Select UOM</option><option>Kilogram/s</option><option>Meter/s</option><option>Box/es</option><option>Pack/s</option><option>Bag/s</option></select></div></div><div class="col-md-4"><div class="form-group"><label>Shelf Life</label><input type="number" class="form-control" name="shelf_life[]" placeholder=""></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label for="exampleFormControlTextarea1">Purpose/Remarks</label><textarea class="form-control" id="" name="purpose[]" rows="1"></textarea></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlTextarea1">Item Application</label><textarea class="form-control" id="" name="item_application[]" rows="1"></textarea></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlSelect1">Sourcing Category</label><select class="form-control" id="exampleFormControlSelect1" name="sourcing_category[]"><option value="" disabled selected>Select Category</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label for="exampleFormControlTextarea1">Required Document</label><textarea class="form-control" id="exampleFormControlTextarea1" name="required_document[]" rows="1"></textarea></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlSelect1">Material Category</label><select class="form-control" id="exampleFormControlSelect1" name="material_category[]"><option value="" disabled selected>Select Category</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div></div></div><input class="btn btn-danger" type="button" name="remove" id="cremove" value="Remove"></div>';
        var cmax = 10;
        var c = 1;

        $("#fadd").click(function(){
        if(c <= cmax){
            $("#form_field").append(form);
            c++;
        }
        });
        $("#form_field").on('click','#cremove',function(){
        $(this).closest('#form').remove();
        c--;
        });

    });
</script>
<div class="card">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>MATERIAL SOURCING<a href="<?php echo base_url(); ?>procurement/form_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Business Unit</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-check" style="margin-right: 30px; margin-left: 15px">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            RRLC
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            BMC
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Date Required</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>*Reference Number</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase" readonly>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <div class="card">
                <div class="card-body" id="form_field">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="" name="description[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Specification</label>
                                <textarea class="form-control" id="" name="specification[]" rows="1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" name="quantity[]" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">UOM</label>
                                <select class="form-control" name="uom[]" id="exampleFormControlSelect1">
                                <option value="" disabled selected>Select UOM</option>
                                <option>Kilogram/s</option>
                                <option>Meter/s</option>
                                <option>Box/es</option>
                                <option>Pack/s</option>
                                <option>Bag/s</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Shelf Life</label>
                                <input type="number" class="form-control" name="shelf_life[]" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Purpose/Remarks</label>
                                <textarea class="form-control" id="" name="purpose[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Item Application</label>
                                <textarea class="form-control" id="" name="item_application[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Sourcing Category</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="sourcing_category[]">
                                <option value="" disabled selected>Select Category</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Required Document</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="required_document[]" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Material Category</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="material_category[]">
                                <option value="" disabled selected>Select Category</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>File Attachment</label>
                                <input type='file' class name='image[]' size='20' />
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-success" title="Add Form" type="button" name="add" id="fadd" value="ADD">
                    <br>
                </div>    
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Other Notes</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
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
                                <select class="form-control" id="exampleFormControlSelect1">
                                <option value="" disabled selected>Select Primary Approver</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                <option value="" disabled selected>Select Alternate Approver</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
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
                                <select class="form-control" id="exampleFormControlSelect1">
                                <option value="" disabled selected>Select Primary Approver</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" id="exampleFormControlSelect1">
                                <option value="" disabled selected>Select Secondary Approver</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </form>
    </div>
</div>