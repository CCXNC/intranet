<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: #C3E0E5">
        <li class="breadcrumb-item" style="color:#0C2D48"><b>Select Transaction</b></li>
        <li class="breadcrumb-item" style="color:gray">Encode Material Sourcing Request</li>
    </ol>
</nav>
<!--<p style="text-align:left"><img class="card-img-top" style="" src="<?php echo base_url(); ?>assets/images/sourcing_step1.png" alt=""></p>-->
<div class="card-header" style="background-color: #0C2D48; color: white"><h4>MATERIAL SOURCING FORM<a href="<?php echo base_url(); ?>procurement/ecanvass_index" id="back" title="Go Back" class="btn btn-info float-right" style="margin-right:10px;">BACK</a></h4></div>
<br>
<div class="row">
    <div class="col-sm-6">
        <a href="<?php echo base_url(); ?>procurement/material_sourcing_matcode">
            <div class="card mx-auto" style="background-color:#E9FAFD; width:80%">
                <p style="text-align:center; padding-top:10px"><img class="card-img-top" style="width:50%; border-radius:2%" src="<?php echo base_url(); ?>assets/images/matcode.png" alt=""></p>
                <div class="card-body">
                    <a style="width: 100%; background-color:#18A558; border:white" href="<?php echo base_url(); ?>procurement/material_sourcing_matcode" class="btn btn-primary btn-md float-left"><h4>With Matcode</h4></a>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6">
        <a href="<?php echo base_url(); ?>procurement/material_sourcing_nomatcode">
            <div class="card mx-auto" style="background-color:#E9FAFD; width:80%">
                <p style="text-align:center; padding-top:10px"><img class="card-img-top" style="width:50%; border-radius:2%" src="<?php echo base_url(); ?>assets/images/nomatcode.png" alt=""></p>
                <div class="card-body">
                    <a style="width: 100%; background-color:#082E90; border:white" href="<?php echo base_url(); ?>procurement/material_sourcing_nomatcode" class="btn btn-primary btn-md float-left"><h4>Without Matcode</h4></a>
                </div>
            </div>
        </a>
    </div>
</div>