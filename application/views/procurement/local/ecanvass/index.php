<style>   
    .custom-btn {
        width: 130px;
        height: 40px;
        color: #fff;
        border-radius: 5px;
        padding: 10px 25px;
        font-family: 'Lato', sans-serif;
        font-weight: 500;
        background: transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        7px 7px 20px 0px rgba(0,0,0,.1),
        4px 4px 5px 0px rgba(0,0,0,.1);
        outline: none;
        box-shadow: 5px 10px 18px #B0B0B0;
    }
    /* 5 */
    .btn-5 {
        width: 350px;
        height: 50px;
        line-height: 42px;
        padding: 0;
        border: none;
        background: rgb(0,172,238);
        background: linear-gradient(0deg, rgba(0,137,204,231) 0%, rgba(2,104,187,227) 100%);
        
    }
    .btn-5:hover {
        color: black;
        background: #BDF5F9;
        box-shadow:none;
        outline:none;
    }
    .btn-5:before,
    .btn-5:after{
        content:'';
        position:absolute;
        top:0;
        right:0;
        height:2px;
        width:0;
        background: #2387AF;
        box-shadow:
        -1px -1px 5px 0px #fff,
        7px 7px 20px 0px #0003,
        4px 4px 5px 0px #0002;
        transition:400ms ease all;
    }
    .btn-5:after{
        right:inherit;
        top:inherit;
        left:0;
        bottom:0;
    }
    .btn-5:hover:before,
    .btn-5:hover:after{
        width:100%;
        transition:800ms ease all;
    }

     .btn-5 {
        width: 350px;
        height: 50px;
        line-height: 42px;
        padding: 0;
        border: none;
        background: rgb(0,172,238);
        background: linear-gradient(0deg, rgba(0,137,204,231) 0%, rgba(2,104,187,227) 100%);
        
    }
    .btn-5:hover {
        color: black;
        background: #BDF5F9;
        box-shadow:none;
        outline:none;
    }
    .btn-5:before,
    .btn-5:after{
        content:'';
        position:absolute;
        top:0;
        right:0;
        height:2px;
        width:0;
        background: #2387AF;
        box-shadow:
        -1px -1px 5px 0px #fff,
        7px 7px 20px 0px #0003,
        4px 4px 5px 0px #0002;
        transition:400ms ease all;
    }
    .btn-5:after{
        right:inherit;
        top:inherit;
        left:0;
        bottom:0;
    }
    .btn-5:hover:before,
    .btn-5:hover:after{
        width:100%;
        transition:800ms ease all;
    }

    /*4 */
    .btn-4 {
        width: 350px;
        height: 50px;
        line-height: 42px;
        padding: 0;
        border: none;
        background: rgb(0,172,238);
        background: linear-gradient(0deg, rgba(0,137,204,231) 0%, rgba(2,104,187,227) 100%);
        
    }
    .btn-4:hover {
        color: black;
        background: #EDF2F3;
        box-shadow:none;
        outline:none;
    }
    .btn-4:before,
    .btn-4:after{
        content:'';
        position:absolute;
        top:0;
        right:0;
        height:2px;
        width:0;
        background: #2387AF;
        box-shadow:
        -1px -1px 5px 0px #fff,
        7px 7px 20px 0px #0003,
        4px 4px 5px 0px #0002;
        transition:400ms ease all;
    }
    .btn-4:after{
        right:inherit;
        top:inherit;
        left:0;
        bottom:0;
    }
    .btn-4:hover:before,
    .btn-4:hover:after{
        width:100%;
        transition:800ms ease all;
    }
</style>
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS</h4></div>
<br>
<div class="card" style="border: solid #175873 1.5px">
    <div class="card-header" style="background-color: #175873; color: white;">
        <h5 style="margin-top:-5px; margin-bottom:-5px">Request List</h5>
    </div>
    <div class="card-body" style="background-color: #BDF5F9">
        <div class="row">
            <div class="col-sm-6">
                <!--<a style="width: 75%; background-color:#175873; padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:15px; font-weight: 500; border: 2px solid #2387AF; border-radius: 10px; margin-left:50px;" href="<?php echo base_url(); ?>procurement/material_sourcing_index" class="btn btn-primary btn-md float-left">MATERIAL SOURCING LIST <i style="font-size:25px" class="fa fa-cart-plus float-right"></i></a>--> 
                <center><button class="custom-btn btn-4" onclick="location.href='<?php echo base_url(); ?>procurement/material_sourcing_index'"><span>MATERIAL SOURCING LIST</span></button></center>
            </div>
            <div class="col-sm-6">
                <!--<a style="width: 75%; background-color:#175873; padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:15px; font-weight: 500; border: 2px solid #2387AF; border-radius: 10px; margin-left:50px" href="<?php echo base_url(); ?>procurement/material_sourcing" class="btn btn-primary btn-md float-left">MATERIAL SOURCING FORM <i style="font-size:25px" class="fa fa-cart-plus float-right"></i></a>--> 
                <center><button class="custom-btn btn-4" onclick="location.href='<?php echo base_url(); ?>procurement/material_sourcing'"><span>MATERIAL SOURCING FORM</span></button></center>
            </div>
        </div>
    </div>
</div>
<br>
<?php if($this->session->userdata('access_level_id') == 1 && $this->session->userdata('department_id') == 25 || $this->session->userdata('employee_number') == '09061027' || $this->session->userdata('employee_number') == '10212112') : ?>
    <div class="card" style="border: solid #175873 1.5px">
        <div class="card-header" style="background-color: #175873; color: white">
            <h5 style="margin-top:-5px; margin-bottom:-5px">Report Generation</h5>
        </div>
        <div class="card-body" style="background-color: #EDF2F3">
            <div class="row">
                <div class="col-sm-6">
                    <!--<a style="width: 75%; background-color: #2387AF;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:15px; font-weight: 500; border-radius: 10px; border: 2px solid #175873; margin-left:50px" href="<?php echo base_url(); ?>procurement/ecanvass_report_generation" class="btn btn-primary btn-md float-left">E-CANVASS REPORT GENERATION<i style="font-size:25px" class="fa fa-chart-bar float-right"></i></a>--> 
                    <center><button class="custom-btn btn-5" onclick="location.href='<?php echo base_url(); ?>procurement/ecanvass_report_generation'"><span>E-CANVASS REPORT GENERATION</span></button></center>
                </div>
                <div class="col-sm-6">
                    <!--<a style="width: 75%;background-color: #2387AF;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:15px; font-weight: 500; border-radius: 10px; border: 2px solid #175873; margin-left:50px" href="<?php echo base_url(); ?>procurement/transmittal" class="btn btn-primary btn-md float-left">TRANSMITTAL REPORT GENERATION<i style="font-size:25px" class="fa fa-chart-bar float-right"></i></a>-->
                    <center><button class="custom-btn btn-5" onclick="location.href='<?php echo base_url(); ?>procurement/transmittal'"><span>TRANSMITTAL REPORT GENERATION</span></button></center>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card" style="border: solid #175873 1.5px">
        <div class="card-header" style="background-color: #175873; color: white">
            <h5 style="margin-top:-5px; margin-bottom:-5px">Report List</h5>
        </div>
        <div class="card-body" style="background-color: #BDF5F9">
            <div class="row">
                <div class="col-sm-6">
                    <!--<a style="width: 75%; background-color: #175873;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 15px; font-weight: 500; border-radius: 10px; border: 2px solid #2387AF; margin-left:50px" href="<?php echo base_url(); ?>procurement/ecanvass_cost_saving" class="btn btn-primary btn-md float-left">CANVASS LIST<i style="font-size:25px" class="fa fa-list-ul float-right"></i></a>-->
                    <center><button class="custom-btn btn-4" onclick="location.href='<?php echo base_url(); ?>procurement/ecanvass_cost_saving'"><span>CANVASS LIST</span></button></center>
                </div>
                <div class="col-sm-6">
                    <!--<a style="width: 75%; background-color: #175873;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 15px; font-weight: 500; border-radius: 10px; border: 2px solid #2387AF; margin-left:50px" href="<?php echo base_url(); ?>procurement/material_canvass" class="btn btn-primary btn-md float-left">MATERIAL CANVASS HISTORY<i style="font-size:25px" class="fa fa-list-ul float-right"></i></a>-->
                    <center><button class="custom-btn btn-4" onclick="location.href='<?php echo base_url(); ?>procurement/material_canvass'"><span>MATERIAL CANVASS HISTORY</span></button></center>
                </div>
                <div class="col-sm-6">
                    <br>
                    <!--<a style="width: 75%;background-color: #175873;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 15px; font-weight: 500; border-radius: 10px; border: 2px solid #2387AF; margin-left:50px" href="<?php echo base_url(); ?>procurement/transmittal_list" class="btn btn-primary btn-md float-left">TRANSMITTAL LIST<i style="font-size:25px" class="fa fa-chart-bar float-right"></i></a>-->
                    <center><button class="custom-btn btn-4" onclick="location.href='<?php echo base_url(); ?>procurement/transmittal_list'"><span>TRANSMITTAL LIST</span></button></center>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card" style="border: solid #175873 1.5px">
        <div class="card-header" style="background-color: #175873; color: white">
            <h5 style="margin-top:-5px; margin-bottom:-5px">Data Enrollment</h5>
        </div>
        <div class="card-body" style="background-color: #E9F4FB">
            <div class="row">
                <div class="col-sm-6">
                    <!--<a style="width: 75%; background-color:#2387AF;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 15px; font-weight: 500; border-radius: 10px; border: 2px solid #175873; margin-left:50px" href="<?php echo base_url(); ?>procurement/supplier_index" class="btn btn-primary btn-md float-left">SUPPLIER ENROLLMENT<i style="font-size:25px" class="fa fa-folder float-right"></i></a>--> 
                    <center><button class="custom-btn btn-5" onclick="location.href='<?php echo base_url(); ?>procurement/supplier_index'"><span>SUPPLIER ENROLLMENT</span></button></center>
                </div>
                <div class="col-sm-6">
                    <!--<a style="width: 75%; background-color:#2387AF;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 15px; font-weight: 500; border-radius: 10px; border: 2px solid #175873; margin-left:50px" href="<?php echo base_url(); ?>procurement/material_enrollment" class="btn btn-primary btn-md float-left">MATERIAL ENROLLMENT<i style="font-size:25px" class="fa fa-folder float-right"></i></a>--> 
                    <center><button class="custom-btn btn-5" onclick="location.href='<?php echo base_url(); ?>procurement/material_enrollment'"><span>MATERIAL ENROLLMENT</span></button></center>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>