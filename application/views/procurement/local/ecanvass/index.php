<div class="card-header" style="background-color: #0C2D48; color: white"><h4>E-CANVASS</h4></div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card" >
            <div class="card-body">
                <a style="width: 70%; background-color:#29A0B1; border: white" href="<?php echo base_url(); ?>procurement/material_sourcing_index" class="btn btn-primary btn-md float-left">MATERIAL SOURCING LIST</a>
                <i style="" class="fa fa-cart-plus fa-2x float-right"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%; background-color:#29A0B1; border: white" href="<?php echo base_url(); ?>procurement/material_sourcing" class="btn btn-primary btn-md float-left">MATERIAL SOURCING FORM</a>
                <i style="" class="fa fa-cart-plus fa-2x float-right"></i>
            </div>
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
        <div class="card">
            <div class="card-body">
                <a style="width: 70%; background-color: #175873; border:white" href="<?php echo base_url(); ?>procurement/ecanvass_report_generation" class="btn btn-primary btn-md float-left">E-CANVASS REPORT GENERATION</a>
                <i style="" class="fa fa-chart-bar fa-2x float-right"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%;background-color: #175873; border:white" href="<?php echo base_url(); ?>procurement/transmittal" class="btn btn-primary btn-md float-left">TRANSMITTAL REPORT GENERATION</a>
                <i style="" class="fa fa-chart-bar fa-2x float-right"></i>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%; background-color: #87ACA3; border:white" href="<?php echo base_url(); ?>procurement/ecanvass_cost_saving" class="btn btn-primary btn-md float-left">CANVASS LIST</a>
                <i style="" class="fa fa-list-ul fa-2x float-right"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%; background-color: #87ACA3; border:white" href="<?php echo base_url(); ?>procurement/material_canvass" class="btn btn-primary btn-md float-left">MATERIAL CANVASS HISTORY</a>
                <i style="" class="fa fa-list-ul fa-2x float-right"></i>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%; background-color:#0C1446; border:white" href="<?php echo base_url(); ?>procurement/supplier_index" class="btn btn-primary btn-md float-left">SUPPLIER ENROLLMENT</a>
                <i style="" class="fa fa-folder fa-2x float-right"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <a style="width: 70%; background-color:#0C1446; border:white" href="<?php echo base_url(); ?>procurement/material_enrollment" class="btn btn-primary btn-md float-left">MATERIAL ENROLLMENT</a>
                <i style="" class="fa fa-folder fa-2x float-right"></i>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>