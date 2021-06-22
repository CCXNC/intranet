<style>
    .announcement{
        text-align: justify;
    }

    .card-header{
        background-color: #003153 !important;
        color: white;
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
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <section>
                            <div class="container">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active cindicator"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="1" class="cindicator"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="2" class="cindicator"></li>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="3" class="cindicator"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php $active = true; ?>
                                            <?php if($announcements) : ?>
                                                <?php foreach($announcements as $announcement) : ?>
                                                    <div class="carousel-item <?php echo ($active == true)?"active":"" ?>">
                                                        <div class="row">
                                                            <div class="card" style="width: 100%">
                                                                <div class="card-header" style="background-color: #003153; color: white; font-size: 18px;">
                                                                    <?php echo $announcement->title; ?>
                                                                    <p style="font-size: 10px;float: right">Created at: <?php echo date('Y-m-d', strtotime($announcement->created_date));  ?></p>                                            
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <center>
                                                                                <h1><img class="" style="width:65%;" src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" alt="First slide"></h1>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
        
  