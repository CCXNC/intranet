<?php if($this->session->flashdata('success_msg')) : ?>
    <p class="alert alert-dismissable alert-success"><?php echo $this->session->flashdata('success_msg'); ?></p>
<?php endif; ?>
<?php if($this->session->flashdata('error_msg')) : ?>
    <p class="alert alert-dismissable alert-danger"><?php echo $this->session->flashdata('error_msg'); ?></p>
<?php endif; ?> 
<div class="card">
    <div class="card-header" style=""><h4><?php echo $this->session->userdata('fullname'); ?> <a href="<?php echo base_url(); ?>attendance/index_attendance" class="btn btn-dark float-right" title="Go Back" style="border:1px solid #ccc; margin-right:10px;">BACK</a></h4> 
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header" style="background-color: #3490dc; color:white;"><h4>DAILY ATTENDANCE </h4> 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME IN</th>
                            <th scope="col">TIME OUT</th>
                            <th scope="col">HOURS LATE</th>
                            <th scope="col">UNDERTIME</th>
                            <th scope="col">OT</th>
                            <th scope="col">ND</th>
                            <th scope="col">REMARKS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color: #6547cd; color:white;"><h4>LEAVE OF ABSENCE </h4> 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">ADDRESS WHILE ON LEAVE</th>
                            <th scope="col">REASON</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="background-color:#38c172; color:white;"><h4>OFFICIAL BUSINESS</h4> 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">DESTINATION</th>
                            <th scope="col">PURPOSE</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style=""><h4>UNDERTIME </h4> 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TIME</th>
                            <th scope="col">UT HOURS</th>
                            <th scope="col">REASON</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header" style=""><h4>OVERTIME </h4> 
            </div>
            <div class="card-body">
                <table id="" class="table table-bordered no-wrap" >
                    <thead>
                        <tr style="background-color:#D4F1F4;">
                            <th scope="col">DAYS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">TIME IN</th>
                            <th scope="col">TIME OUT</th>
                            <th scope="col">OT HOURS</th>
                            <th scope="col">NATURE OF WORK</th>
                            <th scope="col">STATUS</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
    </div>
</div>
   
    <br>
   