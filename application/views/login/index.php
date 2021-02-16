<!DOCTYPE html>
<html> 
<head>
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script>
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    </script>   
</head>
<style>
    
    .login-wrap{
        width:auto;
        background:url(<?php echo base_url(); ?>assets/images/image1.png) no-repeat center;
        box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
    }
    .login-html{
        width:auto;
        height:auto;
        padding:100px 30px 80px 30px;
        background:rgba(40,57,101,.9);
        margin-bottom: 20px;
    }
    .login-form .group .label,
    .login-form .group .input,
    .login-form .group .button{
        width:100%;
        color:#fff;
        display:block;
    }
    .login-form .group .input{
        border:none;
        padding:10px 20px;
        border-radius:25px;
        /*background:rgba(255,255,255,.1);*/
        color:black;
    }
    
    
    .login-form .group .button{
        border:none;
        padding:10px 20px;
        border-radius:25px;
        background:rgba(255,255,255,.1);
    }

    .login-form .group input[data-type="password"]{
        text-security:circle;
        -webkit-text-security:circle;
    }
    .login-form .group .label{
        color:#aaa;
        font-size:12px;
    }
    .login-form .group .button{
        background:#1161ee;
    }
    .login-form .group label .icon{
        width:15px;
        height:15px;
        border-radius:2px;
        position:relative;
        display:inline-block;
        background:rgba(255,255,255,.1);
    }
    .login-form .group label .icon:before,
    .login-form .group label .icon:after{
        content:'';
        width:10px;
        height:2px;
        background:#fff;
        position:absolute;
        transition:all .2s ease-in-out 0s;
    }
    .login-form .group label .icon:before{
        left:3px;
        width:5px;
        bottom:6px;
        transform:scale(0) rotate(0);
    }
    .login-form .group label .icon:after{
        top:6px;
        right:0;
        transform:scale(0) rotate(0);
    }
    .login-form .group .check:checked + label{
        color:#fff;
    }
    .login-form .group .check:checked + label .icon{
        background:#1161ee;
    }
    .login-form .group .check:checked + label .icon:before{
        transform:scale(1) rotate(45deg);
    }
    .login-form .group .check:checked + label .icon:after{
        transform:scale(1) rotate(-45deg);
    }
    .hr{
        height:2px;
        margin:60px 0 50px 0;
        background:rgba(255,255,255,.2);
    }
    .foot-lnk{
        text-align:center;
    }
    .announcement {
        text-align: justify;
    }
</style>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm stroke" style="background-color: #003153 !important; height: 65px;">
        <div class="container">
            <a class="navbar" href="">
                <img id="image" src="<?php echo base_url(); ?>assets/images/glowlogo.png" style="width:150px; position: absolute; left: 0;" alt="">
            </a>
        </div>
    </nav>
    <div class="container">
    <br><br>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="login-wrap">
                            <form action="<?php echo site_url('Login/auth');?>" method="POST">
                                <div class="login-html">
                                    <div class="login-form">
                                        <div class="sign-in-htm">
                                            <div class="group">
                                                <label for="exampleInputUsername" class="label">Username</label>
                                                <input id="exampleInputUsername" name="username" type="text" class="input">
                                            </div>
                                            <div class="group">
                                                <label for="exampleInputPassword1" class="label">Password</label>
                                                <input id="exampleInputPassword1" name="password" type="password" class="input" data-type="password">
                                            </div>
                                            <div class="group" style="color:white; padding-top:10px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" required>

                                                    <label class="form-check-label" for="remember">
                                                        I accept the Terms and Conditions. <br>
                                                        <div id="gallery" data-toggle="modal" data-target="#exampleModal">
                                                            Click here to view  
                                                        <a href="#" data-target="#carouselExample" data-slide-to="0">(Terms and Conditions)</a>
                                                        </div>    
                                                        
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="group">
                                                <br>
                                                <input type="submit" class="button" value="Sign In">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <section>
                            <div class="container">
                            
                                    <!--<?php if($announcement) : ?>
                                        <?php foreach($announcement as $announcement) : ?>
                                            <div class="card">
                                                <div class="card-header" style="background-color: #003153; color: white">
                                                    <?php echo $announcement->title;  ?>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <center>
                                                            <h1><img class="d-block w-100" src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" alt="First slide"></h1>
                                                            </center>
                                                        </div>
                                                        <div id="myModal" class="modal">
                                                            <span class="close">&times;</span>
                                                            <img class="modal-content" id="img01">
                                                            <div id="caption"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p class="announcement">
                                                                <?php echo word_limiter($announcement->content,100); ?></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <br>
                                        <?php endforeach; ?>
                                    <?php endif; ?>-->
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php $active = true; ?>
                                                <?php if($announcements) : ?>
                                                    <?php foreach($announcements as $announcement) : ?>
                                                        <div class="carousel-item <?php echo ($active == true)?"active":"" ?>">
                                                            <div class="row">
                                                                <div class="card">
                                                                    <div class="card-header" style="background-color: #003153; color: white">
                                                                        <?php echo $announcement->title;  ?>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <center>
                                                                                <h1><img class="d-block w-100" src="<?php echo base_url(); ?>uploads/announcement/<?php echo $announcement->image; ?>" alt="First slide"></h1>
                                                                                </center>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <p class="announcement">
                                                                                    <textarea class="form-control" name="content" rows="4" cols="50" readonly><?php echo $announcement->content; ?></textarea>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
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
                       
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" >
                            <div id="carouselExample" class="carousel slide" data-ride="">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="row" >
                                                <div class="col-md-12" style="text-align:justify; padding-left:50px; padding-right:50px;">
                                                    <h3 style="text-align:center;" > General Terms and Conditions for Intranet Administration</h3>
                                                    <p><b>Introduction:</b>
                                                    <br>These System Standard Terms and Conditions written on this system shall manage your use of our system, Blaine Intranet accessible at http://www.blaineintranet/intranet/login/index. <br><br>
                                                    These Terms will be applied fully and affect to your use of this system. By using this system, you agreed to accept all terms and conditions written in here. You must not use this system if you disagree with any of these system Standard Terms and Conditions. These Terms and Conditions have been generated with the help of the Terms And Conditions Template and the Terms and Conditions Generator. 
                                                    People who are not employed by Blaine are not allowed to use this Website. 
                                                    <br><br>
                                                    <b>Intellectual Property Rights: </b>
                                                    <br>
                                                    Other than the content you own, under these Terms, Blaine Corporation and/or its licensors own all the intellectual property rights and materials contained in this system. You are granted limited license only for purposes of viewing the material contained on this system.<br><br>
                                                    <b>Restrictions:</b>
                                                    <br>
                                                    You are specifically restricted from all of the following:<br>

                                                    - publishing any system material in any other media; <br>
                                                    - selling, sublicensing and/or otherwise commercializing any system material; <br>
                                                    - publicly performing and/or showing any system material;<br>
                                                    - using this system in any way that is or may be damaging to this system and/or company;<br>
                                                    - using this system in any way that impacts user access to this system;<br>
                                                    - using this system contrary to applicable laws and regulations, or in any way may cause harm to the system, or to any person or business entity;<br>
                                                    - engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this system;<br>
                                                    - using this system to engage in any advertising or marketing.<br><br>
                                                    Certain areas of this system are restricted from being access by you and Blaine Corporation may further restrict access by you to any areas of this system, at any time, in absolute discretion. Any user ID and password you may have for this system are confidential and you must maintain confidentiality as well.<br><br>

                                                    <b>Your Content</b><br>
                                                    In these System Standard Terms and Conditions, "Your Content" shall mean any audio, video text, images or other material you choose to display on this system. By displaying Your Content, you grant Blaine Corporation a non-exclusive, worldwide irrevocable, sub licensable license to use, reproduce, adapt, publish, translate and distribute it in any and all media.<br><br>

                                                    Your Content must be your own and must not be invading any third-party’s rights. Blaine Corporation reserves the right to remove any of Your Content from this Website at any time without notice.<br><br>

                                                    <b>Your Privacy</b><br>
                                                    Please read Privacy Policy.<br><br>

                                                    <b>No warranties</b><br>
                                                    This System is provided "as is," with all faults, and Blaine Corporation express no representations or warranties, of any kind related to this system or the materials contained on this system. Also, nothing contained on this system shall be interpreted as advising you.<br><br>

                                                    <b>Limitation of liability</b><br>
                                                    In no event shall Blaine Corporation, nor any of its officers, directors and employees, shall be held liable for anything arising out of or in any way connected with your use of this system whether such liability is under contract.  Blaine Corporation, including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this system.<br><br>

                                                    <b>Indemnification</b><br>
                                                    You hereby indemnify to the fullest extent Blaine Corporation from and against any and/or all liabilities, costs, demands, causes of action, damages and expenses arising in any way related to your breach of any of the provisions of these Terms.<br><br>

                                                    <b>Severability</b><br>
                                                    If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting the remaining provisions herein.<br><br>

                                                    <b>Variation of Terms</b><br>
                                                    Blaine Corporation is permitted to revise these Terms at any time as it sees fit, and by using this system you are expected to review these Terms on a regular basis.<br><br>

                                                    <b>Assignment</b><br>
                                                    The Blaine Corporation is allowed to assign, transfer, and subcontract its rights and/or obligations under these Terms without any notification. However, you are not allowed to assign, transfer, or subcontract any of your rights and/or obligations under these Terms.<br><br>

                                                    <b>Entire Agreement</b><br>
                                                    These Terms constitute the entire agreement between Blaine Corporation and you in relation to your use of this system, and supersede all prior agreements and understandings.<br><br>

                                                    <b>Governing Law & Jurisdiction</b><br>
                                                    These Terms will be governed by and interpreted in accordance with the laws of the State of Ph, and you submit to the non-exclusive jurisdiction of the state and federal courts located in Ph for the resolution of any disputes.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</html>
