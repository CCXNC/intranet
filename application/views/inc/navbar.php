<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
        <title>INTRANET</title>
        <link rel="icon" href="<?=base_url()?>assets/images/favicon.png" type="image/png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <!-- DATA TABLE CDN -->
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> 
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script> 

        <!-- NAVBAR CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    
    </head>
    <style>
        @keyframes swing {
            0% {
                transform: rotate(0deg);
            }
            10% {
                transform: rotate(10deg);
            }
            30% {
                transform: rotate(0deg);
            }
            40% {
                transform: rotate(-10deg);
            }
            50% {
                transform: rotate(0deg);
            }
            60% {
                transform: rotate(5deg);
            }
            70% {
                transform: rotate(0deg);
            }
            80% {
                transform: rotate(-5deg);
            }
            100% {
                transform: rotate(0deg);
            }
        }

        @keyframes sonar {
            0% {
                transform: scale(0.9);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .notification {
            color: white;
            text-decoration: none;
            position: relative;
            display: inline-block;
            border-radius: 2px;
        }

        .notification .badge {
            position: absolute;
            top: 3px;
            right: 108px;
            border-radius: 50%;
            background-color: red;
            color: white;
        }

        body {
            font-size: 1rem;
        }
        
        .page-wrapper .sidebar-wrapper,
        .sidebar-wrapper .sidebar-brand > a,
        .sidebar-wrapper .sidebar-dropdown > a:after,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before,
        .sidebar-wrapper ul li a i,
        .page-wrapper .page-content,
        .sidebar-wrapper .sidebar-search input.search-menu,
        .sidebar-wrapper .sidebar-search .input-group-text,
        .sidebar-wrapper .sidebar-menu ul li a,
        #show-sidebar,
        #close-sidebar {
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        /*----------------page-wrapper----------------*/
        .page-wrapper {
            height: 100vh;
        }

        .page-wrapper .theme {
            width: 40px;
            height: 40px;
            display: inline-block;
            border-radius: 4px;
            margin: 2px;
        }

        .page-wrapper .theme.chiller-theme {
            background: #1e2229;
        }

        /*----------------toggeled sidebar----------------*/
        .page-wrapper.toggled .sidebar-wrapper {
            left: 0px;
        }

        @media screen and (min-width: 768px) {
            .page-wrapper.toggled .page-content {
                padding-left: 220px;
            }
        }

        /*----------------show sidebar button----------------*/
        #show-sidebar {
            position: fixed;
            left: 0;
            top: 10px;
            border-radius: 0 4px 4px 0px;
            width: 35px;
            transition-delay: 0.3s;
        }

        .page-wrapper.toggled #show-sidebar {
            left: -40px;
        }

        /*----------------sidebar-wrapper----------------*/

        .sidebar-wrapper {
            width: 230px; /*260px*/
            height: 100%;
            max-height: 100%;
            position: fixed;
            top: 0;
            left: -300px;
            z-index: 999;
        }

        .sidebar-wrapper ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-wrapper a {
            text-decoration: none;
        }

        /*----------------sidebar-content----------------*/

        .sidebar-content {
            max-height: calc(100% - 30px);
            height: calc(100% - 30px);
            overflow-y: auto;
            position: relative;
        }

        .sidebar-content.desktop {
            overflow-y: hidden;
        }

        /*--------------------sidebar-brand----------------------*/

        .sidebar-wrapper .sidebar-brand {
            padding: 10px 20px;
            display: flex;
            align-items: center;
        }

        .sidebar-wrapper .sidebar-brand > a {
            text-transform: uppercase;
            font-weight: bold;
            flex-grow: 1;
        }

        .sidebar-wrapper .sidebar-brand #close-sidebar {
            cursor: pointer;
            font-size: 20px;
        }
        
        /*--------------------sidebar-header----------------------*/
        .sidebar-wrapper .sidebar-header {
            padding: 20px;
            overflow: hidden;
        }

        .sidebar-wrapper .sidebar-header .user-pic {
            float: left;
            width: 60px;
            padding: 2px;
            border-radius: 12px;
            overflow: hidden;
        }

        .sidebar-wrapper .sidebar-header .user-pic img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .sidebar-wrapper .sidebar-header .user-info {
            float: left;
        }

        .sidebar-wrapper .sidebar-header .user-info > span {
            display: block;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-role {
            font-size: 9px;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-status {
            font-size: 11px;
            margin-top: 4px;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-status i {
            font-size: 8px;
            margin-right: 4px;
            color: #5cb85c;
        }

        /*-----------------------sidebar-search------------------------*/

        .sidebar-wrapper .sidebar-search > div {
            padding: 10px 20px;
        }

        /*----------------------sidebar-menu-------------------------*/

        .sidebar-wrapper .sidebar-menu {
            padding-bottom: 10px;
        }

        .sidebar-wrapper .sidebar-menu .header-menu span {
            font-weight: bold;
            font-size: 14px;
            padding: 15px 20px 5px 20px;
            display: inline-block;
        }


        .sidebar-wrapper .sidebar-menu ul li:hover {
           background-color: #3B3F48;
        }

        .sidebar-wrapper .sidebar-menu ul li a {
            display: inline-block;
            width: 100%;
            text-decoration: none;
            position: relative;
            padding: 8px 30px 8px 20px;
        }

        .sidebar-wrapper .sidebar-menu ul li a i {
            margin-right: 10px;
            font-size: 14px;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            border-radius: 4px;
        }

        .sidebar-wrapper .sidebar-menu ul li a:hover > i::before {
            display: inline-block;
            animation: swing ease-in-out 0.5s 1 alternate;
            
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown > a:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f105";
            font-style: normal;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-align: center;
            background: 0 0;
            position: absolute;
            right: 15px;
            top: 14px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu ul {
            padding: 5px 0;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li {
            padding-left: 25px;
            font-size: 12px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before {
            content: "\f111";
            font-family: "Font Awesome 5 Free";
            font-weight: 400;
            font-style: normal;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin-right: 10px;
            font-size: 8px;
        }

        .sidebar-wrapper .sidebar-menu ul li a span.label,
        .sidebar-wrapper .sidebar-menu ul li a span.badge {
        float: right;
            margin-top: 8px;
            margin-left: 5px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .badge,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .label {
            float: right;
            margin-top: 0px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-submenu {
            display: none;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active > a:after {
            transform: rotate(90deg);
            right: 17px;
        }

        /*--------------------------side-footer------------------------------*/

        .sidebar-footer {
            position: absolute;
            width: 100%;
            bottom: 0;
            display: flex;
        }

        .sidebar-footer > a {
            flex-grow: 1;
            text-align: center;
            height: 30px;
            line-height: 30px;
            position: relative;
        }

        .sidebar-footer > a .notification {
            position: absolute;
            top: 0;
        }

        .badge-sonar {
            display: inline-block;
            background: #980303;
            border-radius: 50%;
            height: 8px;
            width: 8px;
            position: absolute;
            top: 0;
        }

        .badge-sonar:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            border: 2px solid #980303;
            opacity: 0;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            animation: sonar 1.5s infinite;
        }

        /*--------------------------page-content-----------------------------*/

        .page-wrapper .page-content {
            display: inline-block;
            width: 100%;
            padding-left: 0px;
            padding-top: 20px;
        }

        .page-wrapper .page-content > div {
            padding: 20px 40px;
        }

        .page-wrapper .page-content {
            overflow-x: hidden;
        }

        /*------------------scroll bar---------------------*/

        ::-webkit-scrollbar {
            width: 10px;
            height: 7px;
        }
        ::-webkit-scrollbar-button {
            width: 0px;
            height: 0px;
        }
        ::-webkit-scrollbar-thumb {
            background: #525965;
            border: 0px none #ffffff;
            border-radius: 0px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #525965;
        }
        ::-webkit-scrollbar-thumb:active {
            background: #525965;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
            border: 0px none #ffffff;
            border-radius: 50px;
        }
        ::-webkit-scrollbar-track:hover {
            background: transparent;
        }
        ::-webkit-scrollbar-track:active {
            background: transparent;
        }
        ::-webkit-scrollbar-corner {
            background: transparent;
        }


        /*-----------------------------chiller-theme---------------------------------*/

        .chiller-theme .sidebar-wrapper {
            background: #003153;
        }

        .chiller-theme .sidebar-wrapper .sidebar-header,
        .chiller-theme .sidebar-wrapper .sidebar-search,
        .chiller-theme .sidebar-wrapper .sidebar-menu {
            border-top: 1px solid #3a3f48;
        }

        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
        .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
            border-color: transparent;
            box-shadow: none;
        }

        .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-role,
        .chiller-theme .sidebar-wrapper .sidebar-header .user-info .user-status,
        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
        .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text,
        .chiller-theme .sidebar-wrapper .sidebar-brand>a,
        .chiller-theme .sidebar-wrapper .sidebar-menu ul li a,
        .chiller-theme .sidebar-footer>a {
            color: white;
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu ul li:hover>a,
        .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active>a,
        .chiller-theme .sidebar-wrapper .sidebar-header .user-info,
        .chiller-theme .sidebar-wrapper .sidebar-brand>a:hover,
        .chiller-theme .sidebar-footer>a:hover i {
            color: white;
        }

        .page-wrapper.chiller-theme.toggled #close-sidebar {
            color: white;
        }

        .page-wrapper.chiller-theme.toggled #close-sidebar:hover {
            color: #ffffff;
        }

        .chiller-theme .sidebar-wrapper ul li:hover a i,
        .chiller-theme .sidebar-wrapper .sidebar-dropdown .sidebar-submenu li a:hover:before,
        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu:focus+span,
        .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active a i {
            color: white;
            text-shadow:0px 0px 10px rgba(22, 199, 255, 0.5);
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu ul li a i,
        .chiller-theme .sidebar-wrapper .sidebar-menu .sidebar-dropdown div,
        .chiller-theme .sidebar-wrapper .sidebar-search input.search-menu,
        .chiller-theme .sidebar-wrapper .sidebar-search .input-group-text {
            background: #0066AC;
        }

        .chiller-theme .sidebar-wrapper .sidebar-menu .header-menu span {
            color: #6c7b88;
        }

        .chiller-theme .sidebar-footer {
            background: #3a3f48;
            box-shadow: 0px -1px 5px #282c33;
            border-top: 1px solid #464a52;
        }

        .chiller-theme .sidebar-footer>a:first-child {
            border-left: none;
        }

        .chiller-theme .sidebar-footer>a:last-child {
            border-right: none;
        }
    </style>
    <script>
        jQuery(function ($) {
            $(".sidebar-dropdown > a").click(function() {
                $(".sidebar-submenu").slideUp(200);
                if (
                    $(this)
                    .parent()
                    .hasClass("active")
                ) {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                    .parent()
                    .removeClass("active");
                } else {
                    $(".sidebar-dropdown").removeClass("active");
                    $(this)
                    .next(".sidebar-submenu")
                    .slideDown(200);
                    $(this)
                    .parent()
                    .addClass("active");
                }
            });

            $("#close-sidebar").click(function() {
                $(".page-wrapper").removeClass("toggled");
            });
            $("#show-sidebar").click(function() {
                $(".page-wrapper").addClass("toggled");
            });
        });
    </script>
    <body>
    <nav class="navbar navbar-expand-md navbar-light bg-light" style="background-color: #003153 !important;" id="navhide">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown notification">
                    <a style="color:white" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user-circle"></i>
                        <span><?php echo $this->session->userdata('username'); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>homepage/employee_profile/<?php echo $this->session->userdata('emp_id'); ?>/<?php echo $this->session->userdata('employee_number'); ?>">My Profile</a>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>user/index_my_attendance">My Attendance</a> 
                        <a class="dropdown-item" href="<?php echo base_url(); ?>user/index_change_password">Change Password</a> 
                        <a class="dropdown-item" href="#">Notification</a> 
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('Login/logout');?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
        <div class="page-wrapper chiller-theme toggled" >
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                <i class="fas fa-bars"></i>
            </a>
            <nav id="sidebar" class="sidebar-wrapper" >
                <div class="sidebar-content">
                    <div class="sidebar-brand">
                        <a href="<?php echo base_url(); ?>homepage/index">
                            <img id="image" src="<?php echo base_url(); ?>assets/images/glowlogo.png" style="width:60%;" alt="">
                        </a>
                        <div id="close-sidebar">
                            <i class="fas fa-window-minimize"></i>
                        </div>
                    </div>
                    <div class="sidebar-header">
                        <div class="col-md-5 user-pic">
                            <img class="img-responsive img-rounded" src="<?php echo base_url(); ?>uploads/employee/<?php echo $this->session->userdata('picture'); ?>" alt="">
                        </div>
                        <div class="col-md-7 user-info">
                            <span style="font-size:10px">Hello!</span>
                            <span class="user-name" style="font-size:12px"><?php echo $this->session->userdata('first_name'); ?>
                            </span>
                            <span class="user-role" style="font-size:8px"><?php echo $this->session->userdata('position'); ?></span>
                            <span class="user-status">
                                <i class="fa fa-circle"></i>
                                <span>Online</span>
                            </span>
                        </div>
                    </div>
                    <div class="sidebar-menu">
                        <ul>
                            <!--HOMEPAGE-->
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="fa fa-home" style="background-color:#138B83"></i>
                                    <span>Homepage</span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="<?php echo base_url(); ?>homepage/index">Announcement</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>homepage/active_directory">Active Directory</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>homepage/location_directory">Location Directory</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!--DASHBOARD-->
                            <li class="">
                                <a href="<?php echo base_url(); ?>announcement/test">
                                    <i class="fa fa-tachometer" style="background-color:#138B83"></i>
                                    <span>Dashboard</span>
                                </a>
                                <!--<div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="#">Add Category</a>
                                        </li>
                                        <li>
                                            <a href="#">View Category</a>
                                        </li>
                                    </ul>
                                </div>-->
                            </li>
                            <!--BLAINE FORMS-->
                            <li class="">
                                <a href="<?php echo base_url(); ?>forms/index">
                                    <i class="fa fa-clipboard" style="background-color:#138B83"></i>
                                    <span>Blaine Forms</span>
                                </a>
                                <!--<div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                        <a href="#">Add Movies</a>
                                        </li>
                                        <li>
                                        <a href="#">View Movies</a>
                                        </li>
                                    </ul>
                                </div>-->
                            </li>
                            <!--5s and ESH-->
                            <!--HOMEPAGE-->
                            <li class="sidebar-dropdown">
                                <a href="#">
                                    <i class="fa fa-home" style="background-color:#138B83"></i>
                                    <span>5S and EHS</span>
                                </a>
                                <div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                            <a href="<?php echo base_url(); ?>fives/sort/index">1S: Sort</a>
                                        </li>
                                        <li>
                                            <a href="">2S: Set</a>
                                        </li>
                                        <li>
                                            <a href="">3S: Shine</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>fives/standardize/index">4S: Standardize</a>
                                        </li>
                                        <li>
                                            <a href="">5S: Sustain</a>
                                        </li>
                                        <li>
                                            <a href="">EHS</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                                <!--HR-->
                                <li class="sidebar-dropdown">
                                    <a href="#">
                                        <i class="fa fa-address-card" style="background-color:#138B83"></i>
                                        <span>HR</span>
                                    </a>
                                    <div class="sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="<?php echo base_url(); ?>dashboard/hr_dashboard">Dashboard</a>
                                            </li>
                                            <?php if($this->session->userdata('access_level_id') == 1 && $this->session->userdata('department_id') == 10 || $this->session->userdata('department_id') == 25 && $this->session->userdata('access_level_id') == 1) : ?>
                                            <li>
                                                <a href="<?php echo base_url(); ?>employee/index">201</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>announcement/index">Announcement</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>timekeeping/index">Timekeeping</a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                          
                           
                            <!--SUPPLY CHAIN-->
                            <li class="">
                                <a href="#">
                                    <i class="fa fa-truck" style="background-color:#138B83"></i>
                                    <span>Supply Chain</span>
                                </a>
                                <!--<div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                        <a href="#">Add Movies</a>
                                        </li>
                                        <li>
                                        <a href="#">View Movies</a>
                                        </li>
                                    </ul>
                                </div>-->
                            </li>
                            <!--ENGINEERING-->
                            <li class="">
                                <a href="#">
                                    <i class="fa fa-cogs" style="background-color:#138B83"></i>
                                    <span>Engineering</span>
                                </a>
                                <!--<div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                        <a href="#">Add Movies</a>
                                        </li>
                                        <li>
                                        <a href="#">View Movies</a>
                                        </li>
                                    </ul>
                                </div>-->
                            </li>
                            <!--DCC-->
                            <li class="">
                                <a href="#">
                                    <i class="fa fa-file-alt" style="background-color:#138B83"></i>
                                    <span>DCC</span>
                                </a>
                                <!--<div class="sidebar-submenu">
                                    <ul>
                                        <li>
                                        <a href="#">Add Movies</a>
                                        </li>
                                        <li>
                                        <a href="#">View Movies</a>
                                        </li>
                                    </ul>
                                </div>-->
                            </li>
                            <!--PRODUCTIVITY-->
                                <?php if($this->session->userdata('department_id') == 25) : ?>
                            
                                    <li class="sidebar-dropdown">
                                        <a href="#">
                                            <i class="fa fa-address-card" style="background-color:#138B83"></i>
                                            <span>Productivity</span>
                                        </a>
                                        <div class="sidebar-submenu">
                                            <ul>
                                                <li>
                                                    <a>CIT</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>productivity/index_softdev">Software Developer</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>productivity/index_it">IT</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>
                                <li class="sidebar">
                                    <a href="<?php echo base_url(); ?>feedback/index">
                                        <i class="fa fa-clipboard" style="background-color:#138B83"></i>
                                        <span>E-Feedback Form</span>
                                    </a>
                                </li>
                           
                            <!--<li>
                                <a href="#">
                                <i class="fas fa-book"></i>
                                <span>Sign Out</span>
                                </a>
                            </li>-->
                            <!--<a href="<?php echo site_url('Login/logout');?>" class="nav-link logout" style="color: white">Logout</a>-->
                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                </div>
            </nav>
            <!-- sidebar-wrapper  -->
                <main class="page-content">
                    <div class="container-fluid">
                        <?php $this->load->view($main_content); ?>
                    </div>
                </main>
            <!-- page-content" -->
        </div>
        
    </body>
</html>