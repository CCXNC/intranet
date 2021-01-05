<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Intranet</title>
    </head>
    <body>
    <style>
        #sidebar {
            overflow: hidden;
            z-index: 3;
        }

        #sidebar .list-group {
            max-width: 200px;
            background-color: #003153;
            min-height: 100vh;
        }

        #sidebar i {
            margin-right: 6px;
        }

        #sidebar .list-group-item {
            border-radius: 0;
            background-color: #003153;
            color: #EEE;
            border-left: 0;
            border-right: 0;
            border-color: white;
            white-space: nowrap;
        }

        #sidebar .list-group-item:not(.collapsed) {
            background-color: #003153;
        }

        #sidebar .list-group .list-group-item[aria-expanded="false"]::after {
            content: "\f0d7";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 5px;
        }

        #sidebar .list-group .list-group-item[aria-expanded="true"] {
            background-color: #222;
        }
        #sidebar .list-group .list-group-item[aria-expanded="true"]::after {
            content: "";
            font-family: FontAwesome;
            display: inline;
            text-align: right;
            padding-left: 5px;
        }

        #sidebar .list-group .collapse .list-group-item,
        #sidebar .list-group .collapsing .list-group-item  {
            padding-left: 40px;
        }

        #sidebar .list-group .collapse > .collapse .list-group-item,
        #sidebar .list-group .collapse > .collapsing .list-group-item {
            padding-left: 30px;
        }

        #sidebar .list-group .collapse > .collapse > .collapse .list-group-item {
            padding-left: 40px;
        }

        @media (max-width:768px) {
            #sidebar {
                min-width: 35px;
                max-width: 40px;
                overflow-y: auto;
                overflow-x: visible;
                transition: all 0.25s ease;
                transform: translateX(-45px);
                position: fixed;
            }
            
            #sidebar.show {
                transform: translateX(0);
            }

            #sidebar::-webkit-scrollbar{ width: 0px; }
            
            #sidebar, #sidebar .list-group {
                min-width: 1px;
                overflow: visible;
            }
            #sidebar .list-group .collapse.show, #sidebar .list-group .collapsing {
                position: relative;
                z-index: 1;
                width: 190px;
                top: 0;
            }
            #sidebar .list-group > .list-group-item {
                text-align: center;
                padding: .75rem .5rem;
            }
            #sidebar .list-group > .list-group-item[aria-expanded="true"]::after,
            #sidebar .list-group > .list-group-item[aria-expanded="false"]::after {
                display:none;
            }
        }

        .collapse.show {
            visibility: visible;
        }

        .collapsing {
            visibility: visible;
            height: 0;
            -webkit-transition-property: height, visibility;
            transition-property: height, visibility;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }

        .collapsing.width {
            -webkit-transition-property: width, visibility;
            transition-property: width, visibility;
            width: 0;
            height: 100%;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }
    </style>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm stroke" style="background-color: #003153 !important;">
        <div class="container">
            <a class="navbar" href="{{ url('/') }}">
                <!--<img id="image" src="../assets/images/BC.png" style="width:100px" alt="">-->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav ml-auto fw">
                    <span class="navbar-text">
                        <a href="<?php echo site_url('Login/logout');?>" class="nav-link logout" style="color: white">Logout</a>
                    </span>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row d-flex d-md-block flex-nowrap wrapper">
            <div class="col-md-2 float-left col-1 pl-0 pr-0 collapse width show" id="sidebar">
                <div class="list-group border-0 text-center text-md-left">
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-home" aria-hidden="true"></i> <span class="d-none d-md-inline">Homepage</span> </a>
                    
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-tachometer" aria-hidden="true"></i> <span class="d-none d-md-inline">Dashboard</span></a>
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-archive" aria-hidden="true"></i><span class="d-none d-md-inline">5S and ESH</span></a>
                    <a href="#menu3" data-id="" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-users" aria-hidden="true"></i><span class="d-none d-md-inline">HR</span></a>
                    <div class="collapse" id="menu3" data-parent="#sidebar">
                        <a href="<?php echo base_url(); ?>index.php/HrController/homepage" class="list-group-item" data-parent="#menu3">201</a>
                        <a href="#" class="list-group-item" data-parent="#menu3">Announcement</a>
                        <a href="#" class="list-group-item" data-parent="#menu3">Timekeeping</a>
                    </div>
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-cogs" aria-hidden="true"></i><span class="d-none d-md-inline">Supply Chain</span></a>
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-wrench" aria-hidden="true"></i><span class="d-none d-md-inline">Engineering</span></a>
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="d-none d-md-inline">DCC</span></a>
                    <a href="#" class="list-group-item d-inline-block collapsed"><i class="fa fa-desktop" aria-hidden="true"></i><span class="d-none d-md-inline">Productivity - IT</span></a>
                   </div>
            </div>
            <main class="col-md-10 float-left col px-5 pl-md-2 pt-2 main">
                <a href="#" data-target="#sidebar" data-toggle="collapse"></a>
                <div class="page-header">
                    <?php $this->load->view($main_content); ?>
                </div>
                
            </main>
        </div>
</div>
   
    </body>
</html>