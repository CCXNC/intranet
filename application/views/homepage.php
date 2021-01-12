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
</style>
<section>
    <div class="card">
        <div class="card-header main">
            <h4>ANNOUNCEMENTS</h4>
        </div>
        <div class="card-body">
            <?php if($announcements) : ?>
                <?php foreach($announcements as $announcement) : ?>
                    <div class="card">
                        <div class="card-header">
                            <?php echo $announcement->title;  ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                    <h1><img src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" style="width: 80%" alt=""></h1>
                                    </center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="announcement">
                                        <?php echo $announcement->content;  ?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
        
  