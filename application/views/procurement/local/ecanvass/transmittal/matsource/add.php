<style>
    input[type=text] {
        font-size: 12px;
    }
    input[type=date] {
        font-size: 12px;
    }
</style>
<div class="card" style="font-size:12px;">
    <div class="card-header" style="background-color: #0C2D48; color: white"><h4>MATERIAL SAMPLE TRANSMITTAL<a href="<?php echo base_url(); ?>procurement/transmittal" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div style="color:red"><?php echo validation_errors(); ?> </div>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="card">
                <div class="card-header" style="background-color: #0D635D; color: white; font-size:15px;">TRANSMITTAL DETAILS</div>
                <div class="card-body" style="background-color: #E9FAFD;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Transmittal No.</label>
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source ID</label>
                                <select name="" id=""  class="form-control" style="font-size:12px;height:32px">
                                    <option value=" ">SELECT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Material Source Request Date</label>
                                <input type="text" class="form-control" name="first_name" style="background-color:white" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Company</label>
                                <input type="text" class="form-control" name="first_name" style="background-color:white" readonly>
                            </div>
                        </div>
                        <!--<div class="col-md-4">
                            <div class="form-group">
                                <label >PR Number</label>
                                <input type="text" class="form-control" name="first_name" style="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >PR Date</label>
                                <input type="text" class="form-control" name="first_name" style="background-color:white" readonly>
                            </div>
                        </div>-->
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
                                <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Transmittal Date</label>
                                <input type="date" class="form-control" name="first_name" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Email </label>
                                <input type="text" class="form-control" name="first_name" value="blaineintranet@blainegroup.com.ph; test@blainegroup.com.ph;" >
                            </div>
                        </div>
                      
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >RE: </label>
                                <input type="text" class="form-control" name="first_name" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >File Attachment</label><br>
                                <input type='file' class name='image[]' size='20' />
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="Business Unit">Material 1</td>
                                <td>
                                    <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                                </td>
                                <td data-label="Department">
                                    <input type='file' class name='image[]' size='20' />
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Business Unit">Material 2</td>
                                <td>
                                    <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                                </td>
                                <td data-label="Department">
                                    <input type='file' class name='image[]' size='20' />
                                </td>
                            </tr>
                            <tr>
                                <td data-label="Business Unit">Material 3</td>
                                <td>
                                    <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="first_name" style="text-transform:uppercase">
                                </td>
                                <td data-label="Department">
                                    <input type='file' class name='image[]' size='20' />
                                </td>
                            </tr>
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