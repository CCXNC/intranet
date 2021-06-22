<style>
    .announcement{
        text-align: justify;
    }

    .card-header{
        background-color: #003153 !important;
        color: white;
    }
    
    .main {
        background-color: white !important;
        color: black;
    }

    .carousel-indicators .cindicator{
        background-color: gray;
    }

    .carousel-indicators .active{
        background-color: black;
    }

    .carousel-indicators li {
        width: 10px;
        height: 10px;
        border-radius: 100%;
    }

    .carousel-indicators {
        top: 63px;
    }
</style>
<section>
    <section>
        <!-- Patch Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#003153; color: white">
                        <h5 class="modal-title">Release Update - June 21, 2020</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p><b>New and Improved</b></p>
                        <small>
                            • Employee Profile in Sidebar
                            <br>
                            • Activity Logs
                            <br>
                            • Overtime Approval Functionality
                            <br>
                            • Summary List Fields
                        </small>
                        <p><b><br>Enhancement</b></p>
                        <small>
                            • Overtime Computation
                            <br>
                            • Timekeeping Module
                            <br>
                            • Bug Fixes and Design Improvements
                        </small>
                        <hr>
                        <small>
                            Patch: 21.06.21001
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card" style="width: 50%; border-color:black; margin-top: -25px; margin-bottom: -20px">
                <div class="card-body">
                    <p class="card-title" style="margin-bottom: 0px; margin-top:-20px; font-size:13px"><i>Quick Links</i></p>
                    <p style="margin-bottom: -20px; font-size: 15px; font-family: arial">
                        <a href="<?php echo base_url(); ?>homepage/active_directory" class="card-link" style="margin-bottom: 0px">• Active Directory</a>
                        <a href="<?php echo base_url(); ?>fives/idea" class="card-link">• 5S Share My Idea</a>
                        <a href="<?php echo base_url(); ?>feedback/index" class="card-link">• E-Feedback List</a>
                    </p>
                </div>
            </div>
            <br>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active cindicator"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1" class="cindicator"></li>
                </ol>
                <div class="carousel-inner">
                    <?php $active = true; ?>
                        <?php if($announcements) : ?>
                            <?php foreach($announcements as $announcement) : ?>
                                <div class="carousel-item <?php echo ($active == true)?"active":"" ?>">
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #003153; color: white; font-size: 18px;">
                                                <?php echo $announcement->title; ?>
                                                <p style="font-size: 10px;float: right">Created at: <?php echo date('Y-m-d', strtotime($announcement->created_date));  ?></p>                                            
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <h1><img class="" style="width:70%;" src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" alt="First slide"></h1>
                                                        </center>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="announcement">
                                                            <?php echo $announcement->content; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $active = false; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div> 
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div> 
        </div>
    </section>
</section>
<script>
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
</script>
        
  