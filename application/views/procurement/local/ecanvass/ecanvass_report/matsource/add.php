<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=date] {
        font-size: 12px;
    }
</style>
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
                                <label >Canvass No.</label>
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source ID</label>
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase; background-color:white">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source Request Date</label>
                                <input type="date" class="form-control" name="first_name" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control" name="first_name" style="background-color:white" readonly>
                            </div>
                        </div>
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
                                <th scope="col">Description & Specs</th>
                                <th scope="col">Mat Code</th>
                                <th scope="col">QTY</th>
                                <th scope="col">UOM</th>
                                <th scope="col">Previous Purchase</th>
                                <th scope="col">Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Description & Specs">Material 1</td>
                                <td data-label="Mat Code"> 01010101 </td>
                                <td data-label="QTY">1000</td>
                                <td data-label="UOM"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price"></td>
                                <td> <div class="btn btn-sm btn-danger">Remove</div></td>
                            </tr>
                            <tr>
                                <td data-label="Description & Specs">Material 2</td>
                                <td data-label="Mat Code"> 02020202 </td>
                                <td data-label="QTY">1000</td>
                                <td data-label="UOM"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price"></td>
                                <td> <div class="btn btn-sm btn-danger">Remove</div></td>
                            </tr>
                            <tr>
                                <td data-label="Description & Specs">Material 3</td>
                                <td data-label="Mat Code"> 03030303 </td>
                                <td data-label="QTY">1000</td>
                                <td data-label="UOM"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price"></td>
                                <td data-label="Price"><input type="text" class="form-control" name="price"></td>
                                <td> <div class="btn btn-sm btn-danger">Remove</div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <a href="<?php echo base_url(); ?>procurement/report_matsource_add1" style="margin-left:10px;" class="float-right btn btn-info">NEXT</a>
        </form>
    </div>
</div>