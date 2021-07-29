<div class="card" style="font-size:12px">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>COMPARATIVE STATEMENT OF QUOTATIONS: CHOOSING OF SUPPLIER<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
    <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="<?php echo base_url(); ?>employee/add" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0C2D48;"><h4></h4></div>
                <div class="card-body" style="background-color: #E9FAFD;color:black">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; font-size:12px; background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Canvass Number</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; font-size:12px;background-color:white" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>PR Number</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; font-size:12px;background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>PR Date</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" style="font-size:12px;background-color:white" readonly>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <br>
            <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
                <thead>
                    <tr>
                        <th colspan="7" style="background-color: #0C2D48; color: white; ">Previous Purchase</th>
                        <th colspan="" style="background-color: #0C2D48; color: white">Quotation 1</th>
                        <th colspan="" style="background-color: #0C2D48; color: white">Quotation 2</th>
                        <th colspan="" style="background-color: #0C2D48; color: white">Quotation 3</th>
                    </tr>
                    <tr>
                        <th scope="col" style="background-color: #0C2D48; color: white;">No</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Material</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">QTY</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">UOM</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Price</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Currency</th>
                        <th scope="col" style="background-color: #0C2D48; color: white">Year</th>
                        <th colspan="" style="background-color:#0D635D; color:white">ABC Consumables</th>
                        <th colspan="" style="background-color:#0D635D; color:white">JGC Chemicals</th>
                        <th colspan="" style="background-color:#0D635D; color:white">KJ Packaging</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #F5F5F5">
                    <tr >
                        <th scope="row">1</th>
                        <td >Packaging Tape</td>
                        <td>100</td>
                        <td>Pack/s</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>1,000 PHP</td>
                        <td>990 PHP</td>
                        <td>900 PHP</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Latex Gloves</td>
                        <td>1,000</td>
                        <td>Pack/s</td>
                        <td>100</td>
                        <td>USD</td>
                        <td>2021</td>
                        <td>100 USD</td>
                        <td>100 USD</td>
                        <td>995 USD</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Nitrile Gloves</td>
                        <td>1,000</td>
                        <td>Pack/s</td>
                        <td>3,000</td>
                        <td>PHP</td>
                        <td>2021</td>
                        <td>3,500 PHP</td>
                        <td>3,650 PHP</td>
                        <td>3,500 PHP</td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: white; border:none"></th>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td rowspan="5" style="vertical-align:middle; background-color:#0D635D; color:white">Purchase Terms</td>
                        <td colspan="3" style="background-color: #0C2D48; color: white; ">VAT</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: white; border:none"></th>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td colspan="3" style="background-color: #0C2D48; color: white; ">PMT (Days)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: white; border:none"></th>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td colspan="3" style="background-color: #0C2D48; color: white; ">DEL (Days)</td>
                        <td style="background-color: white"></td>
                        <td style="background-color: white"></td>
                        <td style="background-color: white"></td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: white; border:none"></th>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td colspan="3" style="background-color: #0C2D48; color: white; ">WRT</td>
                        <td style="background-color: white"></td>
                        <td style="background-color: white"></td>
                        <td style="background-color: white"></td>
                    </tr>
                    <tr>
                        <th scope="row" style="background-color: white; border:none"></th>
                        <td style="background-color: white; border:none"></td>
                        <td style="background-color: white; border:none"></td>
                        <td colspan="3" style="background-color: #0C2D48; color: white; ">Notes</td>
                        <td style="background-color: white"></td>
                        <td style="background-color: white"></td>
                        <td style="background-color: white"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Computer Recommendation</label>
                    </div>
                </div>
            </div>
            <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">No</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Material</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">QTY</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">UOM</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Supplier</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Saving</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Avoidance</th>
                    </tr>
                    <tr>
                        <th colspan="" style="background-color:#0D635D; color:white">Reduction Per Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Reduction</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Savings/Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Savings</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #F5F5F5">
                    <tr >
                        <th scope="row">1</th>
                        <td >Packaging Tape</td>
                        <td>100</td>
                        <td>Pack/s</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Latex Gloves</td>
                        <td>1,000</td>
                        <td>Pack/s</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Nitrile Gloves</td>
                        <td>1,000</td>
                        <td>Pack/s</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Buyer Disposition</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="first_name" style="text-transform:uppercase;font-size:12px;background-color:white" readonly>
                    </div>
                </div>
            </div>
            <table class="table table-bordered" style="font-size:12px; line-height:13px; text-align: center;">
                <thead>
                    <tr>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">No</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Material</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">QTY</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">UOM</th>
                        <th scope="col" rowspan="2" style="background-color: #0C2D48; color: white; vertical-align:middle">Supplier</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Saving</th>
                        <th colspan="2" style="background-color: #0C2D48; color: white;">Cost Avoidance</th>
                    </tr>
                    <tr>
                        <th colspan="" style="background-color:#0D635D; color:white">Reduction Per Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Reduction</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Savings/Unit</th>
                        <th colspan="" style="background-color:#0D635D; color:white">Total Savings</th>
                    </tr>
                </thead>
                <tbody style="line-height:12px; background-color: #F5F5F5">
                    <tr >
                        <th scope="row">1</th>
                        <td >Packaging Tape</td>
                        <td>100</td>
                        <td>Pack/s</td>
                        <td>
                            <select class="form-control" id="exampleFormControlSelect1" name="material_category[]" style="height: 10px;font-size:12px">
                                <option value="" disabled selected style="font-size:10px"></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Latex Gloves</td>
                        <td>1,000</td>
                        <td>Pack/s</td>
                        <td>
                            <select class="form-control" id="exampleFormControlSelect1" name="material_category[]" style="height: 10px;font-size:12px">
                                <option value="" disabled selected style="font-size:10px"></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Nitrile Gloves</td>
                        <td>1,000</td>
                        <td>Pack/s</td>
                        <td>
                            <select class="form-control" id="exampleFormControlSelect1" name="material_category[]" style="height: 10px;font-size:12px">
                                <option value="" disabled selected style="font-size:10px"></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <center>
                <div class="form-group">
                    <input type="submit" title="Submit Employee Information" class="btn btn-success" onclick="return confirm('Do you want to submit data?');" value="SUBMIT" >
                </div>
            </center>
        </form>
    </div>
</div>