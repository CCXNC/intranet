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
        background:url(assets/images/image1.png) no-repeat center;
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
                <img id="image" src="assets/images/logo.png" style="width:150px; position: absolute; left: 0; box-shadow: 0px 0px 5px #fff;" alt="">
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
                            
                                    <?php if($announcements) : ?>
                                        <?php foreach($announcements as $announcement) : ?>
                                            <div class="card">
                                                <div class="card-header" style="background-color: #003153; color: white">
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
                                                                <?php echo word_limiter($announcement->content,50); ?></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <br>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
                                                    <h3 style="text-align:left;" > General Terms and Conditions for Intranet Administration</h3>
                                                    <p>The person in charge of the administration and updating of the contents of the Company’s intranet as well as in answering potential queries from customers and clients shall observe the following terms and conditions: </p> 
                                                    <p>1. Ensure that all pictures and articles to be uploaded in the site are original and will not be subjected to any plagiarism/copyright lawsuits. Consequently, all contents uploaded in the site are owned by Blaine Group of Companies. In the event that the articles or pictures uploaded to the site are not owned by Blaine, the source of the same shall be cited.</p> 
                                                    <p>2. There shall be no assignment of duties in the maintenance and administration of this site.  As such, access to the site as the person in charge of the maintenance and updating of the website shall be limited to those authorized by Blaine to perform the said activities.  Log in user name and password shall specifically be allocated to the person/s in charge in the maintenance of the website and shall be kept for themselves at all times.</p>
                                                    <p>3. In the maintenance and administration of the company’s website, the person in charge shall make sure that all contents uploaded in the site and the manner they interact with its potential clients and customers in the said site shall not prejudice the interest of the company and its owners by conducting themselves with decorum and providing valuable information that would boost the reputation of the company and its products.  </p>
                                                    <p>4. Compliance of RA 10173 or the Data Privacy Act of 2012 shall be adhered to at all times in any information derived from the performance of duties as the one in charge in the maintenance and handling of this site particularly data gathered from inquiring customers/clients.
                                                        Breach of any of the above-enumerated terms could be a subject for disciplinary action and/or other legal remedies available to the Company in making sure its interest is protected.</p>
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
 
</html>
