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
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content, #caption {  
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
    }

    @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }
</style>
<section>
    <!--<div class="card">
        <div class="card-header main">
            <h4>ANNOUNCEMENTS</h4>
        </div>
        <div class="card-body">
            <?php if($announcement) : ?>
                <?php foreach($announcement as $announcement) : ?>
                    <div class="card">
                        <div class="card-header">
                            <?php echo $announcement->title;  ?>
                            <p style="font-size: 10px;float: right">Created at: <?php echo $announcement->created_date;  ?></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <center>
                                    <h1><img id="myImg" src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" alt="" style="width:70%;"></h1>
                                    </center>
                                </div>
                                <div id="myModal" class="modal">
                                    <span class="close">&times;</span>
                                    <img class="modal-content" id="img01">
                                    <div id="caption"></div>
                                </div>
                            </div>
                            <hr>
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
    </div>-->
    <section>
        <div class="container">
            <div class="carousel slide" id="carouselExampleControls" data-ride="carousel">
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
               <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>
    <!--<div class="float-right">
        <?php echo $this->pagination->create_links(); ?>
        <br>
    </div>-->
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
            modal.style.display = "none";
        }
    </script>
</section>
        
  