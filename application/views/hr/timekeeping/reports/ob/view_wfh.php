<div class="card">
    <div class="card-header" style="background-color:rgb(127,127,127); color: white"><h4><?php echo $ob->fullname; ?> ( <?php echo $ob->department; ?> )<a href="<?php echo base_url(); ?>reports/index_ob" title="Go Back" class="btn btn-dark float-right" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for=""> Date of OB</label>
                    <div class="form-control"><?php echo $ob->date_ob; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Type</label>
                    <div class="form-control"><?php echo $ob->type; ?></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Remarks</label>
                    <div class="form-control"><?php echo $ob->remarks; ?></div>
                </div>
            </div>
        </div>
    </div>    
</div>