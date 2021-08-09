<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=number] {
        font-size: 12px;
    }
</style>
<div class="card" style="font-size:12px;">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS REPORT GENERATION 2<a href="<?php echo base_url(); ?>procurement/report_pr_add" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white"><h5>Comparative Statement Quotations</h5></div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">Select Supplier</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <p>Accredited</p>
                                            </label>
                                        </div>
                                        <div class="form-check" style="margin-right: 20px; margin-left: 15px">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <p>Others</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                                        <th scope="col">Price</th>
                                        <th scope="col">Currency</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Description & Specs">Material 1</td>
                                        <td data-label="QTY">1000</td>
                                        <td data-label="UOM">1</td>
                                        <td data-label="MOQ"><input type="number" class="form-control" name="moq"></td>
                                        <td data-label="Price"><input type="number" class="form-control" name="price"></td>
                                        <td data-label="Currency">
                                            <select name="currency" class="form-control" id="" style="font-size:12px;">
                                                <option value=""></option>
                                                <option selected="selected" value="">PHP </option>
                                                <option value="">USD </option>
                                                <option value="">POUND </option>
                                                <option value="">YUAN </option>
                                                <option value="">EURO </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Description & Specs">Material 2</td>
                                        <td data-label="QTY">1000</td>
                                        <td data-label="UOM">2</td>
                                        <td data-label="MOQ"><input type="number" class="form-control" name="moq"></td>
                                        <td data-label="Price"><input type="number" class="form-control" name="price"></td>
                                        <td data-label="Currency">
                                            <select name="currency" class="form-control" id="" style="font-size:12px;">
                                                <option value=""></option>
                                                <option selected="selected" value="">PHP </option>
                                                <option value="">USD </option>
                                                <option value="">POUND </option>
                                                <option value="">YUAN </option>
                                                <option value="">EURO </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td data-label="Description & Specs">Material 3</td>
                                        <td data-label="QTY">1000</td>
                                        <td data-label="UOM">3</td>
                                        <td data-label="MOQ"><input type="number" class="form-control" name="moq"></td>
                                        <td data-label="Price"><input type="number" class="form-control" name="price"></td>
                                        <td data-label="Currency">
                                            <select name="currency" class="form-control" id="" style="font-size:12px;">
                                                <option value=""></option>
                                                <option selected="selected" value="">PHP </option>
                                                <option value="">USD </option>
                                                <option value="">POUND </option>
                                                <option value="">YUAN </option>
                                                <option value="">EURO </option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div style="background-color: #0D635D; color: white; padding:7px 5px 4px 5px; border-radius:5px; font-size:14px;">Purchase Term</div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">VAT</label>
                                        <select class="form-control" name="uom[]" style="font-size:12px; height:32px" id="exampleFormControlSelect1">
                                            <option value="" selected></option>
                                            <option>INC</option>
                                            <option>EX</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">WRT</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">PMT (Days)</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">DEL (Days)</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Notes</label>
                                        <textarea style="font-size:12px" class="form-control" name="" id="" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    
                        <div class="col-md-6">
                            <input class="btn btn-success" title="Add Form" type="button" name="add" id="fadd" value="ADD">
                        </div>
                    
                    </div>
                </div>    
            </div>
            <br>
            <a href="<?php echo base_url(); ?>procurement/comparative_pr_view" style="margin-left:10px;" class="float-right btn btn-info">NEXT</a>
        </form>
    </div>
</div>