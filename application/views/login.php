<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
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
                <img id="image" src="assets/images/logo.png" style="width:150px; position: absolute; left: 0" alt="">
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
        </div>
    </div>
</html>