<div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS</h4></div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
            <a style="width: 100%; background-color:#29A0B1; padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:18px; font-weight: 500; border: 2px solid #238795; border-radius: 10px" href="<?php echo base_url(); ?>procurement/material_sourcing_index" class="btn btn-primary btn-md float-left">MATERIAL SOURCING LIST <i style="" class="fa fa-cart-plus fa-2x float-right"></i></a>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
            <a style="width: 100%; background-color:#29A0B1; padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:18px; font-weight: 500; border: 2px solid #238795; border-radius: 10px" href="<?php echo base_url(); ?>procurement/material_sourcing" class="btn btn-primary btn-md float-left">MATERIAL SOURCING FORM <i style="" class="fa fa-cart-plus fa-2x float-right"></i></a>
        </div>
    </div>
</div>
<br>
<?php if($this->session->userdata('access_level_id') == 1 && $this->session->userdata('department_id') == 25 || $this->session->userdata('employee_number') == '09061027' || $this->session->userdata('employee_number') == '06212107') : ?>
<div class="row">
    <!--<div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%" href="<?php echo base_url(); ?>procurement/comparative" class="btn btn-primary btn-md float-left">COMPARATIVE STATEMENT</a>
                <i style="" class="fa fa-file-word fa-2x float-right"></i>
            </div>
        </div>
    </div>-->
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
            <a style="width: 100%; background-color: #175873;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/ecanvass_report_generation" class="btn btn-primary btn-md float-left">E-CANVASS REPORT GENERATION<i style="" class="fa fa-chart-bar fa-2x float-right"></i></a>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
            <a style="width: 100%;background-color: #175873;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size:18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/transmittal" class="btn btn-primary btn-md float-left">TRANSMITTAL REPORT GENERATION<i style="" class="fa fa-chart-bar fa-2x float-right"></i></a>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
                <a style="width: 100%; background-color: #87ACA3;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/ecanvass_cost_saving" class="btn btn-primary btn-md float-left">CANVASS LIST<i style="" class="fa fa-list-ul fa-2x float-right"></i></a>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
                <a style="width: 100%; background-color: #87ACA3;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/material_canvass" class="btn btn-primary btn-md float-left">MATERIAL CANVASS HISTORY<i style="" class="fa fa-list-ul fa-2x float-right"></i></a>
            
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
                <a style="width: 100%; background-color:#0C1446;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/supplier_index" class="btn btn-primary btn-md float-left">SUPPLIER ENROLLMENT<i style="" class="fa fa-folder fa-2x float-right"></i></a>
            
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
                <a style="width: 100%; background-color:#0C1446;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/material_enrollment" class="btn btn-primary btn-md float-left">MATERIAL ENROLLMENT<i style="" class="fa fa-folder fa-2x float-right"></i></a>
            
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card" style="border-radius: 10px">
                <a style="width: 100%;background-color: #175873;  padding: 12px; box-shadow: 5px 10px 18px #B0B0B0; font-size: 18px; font-weight: 500; border-radius: 10px; border: 2px solid #238795" href="<?php echo base_url(); ?>procurement/transmittal_list" class="btn btn-primary btn-md float-left">TRANSMITTAL LIST<i style="" class="fa fa-chart-bar fa-2x float-right"></i></a>
        </div>
    </div>
</div>
<?php endif; ?>