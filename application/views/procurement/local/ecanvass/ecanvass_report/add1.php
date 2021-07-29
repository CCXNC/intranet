<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=number] {
        font-size: 12px;
    }
</style>
<div class="card" style="font-size:12px;">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS REPORT GENERATION 2<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white"><h5>Comparative Statement Quotations</h5></div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="supplier" class="form-control" id="" style="font-size:12px;">
                                    <option value="">SELECT SUPPLIER</option>
                                </select>
                            </div>
                          
                            <table id="" class="table table-striped"  style="width:100%">
                                <thead>
                                    <tr style="background-color:#0D635D; color:white;">
                                        <th scope="col">Material</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">UOM</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Currency</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Description & Specs">Material 1</td>
                                        <td data-label="QTY">1000</td>
                                        <td data-label="UOM">1</td>
                                        <td data-label="Price"><input type="number" class="form-control" name="price"></td>
                                        <td data-label="Currency">
                                            <select name="currency" class="form-control" id="" style="font-size:12px;">
                                                <option value="">PHP </option>
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
                                        <td data-label="Price"><input type="number" class="form-control" name="price"></td>
                                        <td data-label="Currency">
                                            <select name="currency" class="form-control" id="" style="font-size:12px;">
                                                <option value="">PHP </option>
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
                                        <td data-label="Price"><input type="number" class="form-control" name="price"></td>
                                        <td data-label="Currency">
                                            <select name="currency" class="form-control" id="" style="font-size:12px;">
                                                <option value="">PHP </option>
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

                        <div class="col-md-6">
                            <div style="background-color: #0D635D; color: white; padding:7px 5px 4px 5px; border-radius:5px; font-size:15px;"><h5>Purchase Term</h5></div>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">VAT</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">WRT</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">PMT (Days)</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">DEL (Days)</label>
                                        <input type="number" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Notes</label>
                                        <input type="text" class="form-control">
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
            <a href="<?php echo base_url(); ?>procurement/ecanvass_index" style="margin-left:10px;" class="float-right btn btn-info">SUBMIT</a>
        </form>
    </div>
</div>