<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html class=" gecko win js" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>DGMIS Portal</title>
<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="css/extra.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" />
    
</head>

<body>
    <div id="app-wrapper" class="app-hide-lpanel">
        <header id="app-header">
             

            <div class="app-right-header headmrgin">
               <div class="col-md-6 headlogo">
                    <img src="images/logoEng.png" class="img-responsive" alt="logo" /> <b>Department of Medical, Health & Family Welfare, Uttar Pradesh</b> 
                </div>  
               <ul class="right-navbar">
               <li class="dropdown app-rheader-submenu app-header-profile">
               <a href="javascript:void(0)">
                    <span><b>Hindi Language</b></span>
                        </a>
                </li>
               </ul>
                <!--<ul class="right-navbar">
                    <li class="dropdown app-rheader-submenu app-header-profile">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <span>
                                <img class="img-circle " src="images/avatar-1.jpg"></span>
                            <span><b>Human</b><strong> Name</strong> <i class=" fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu ">
                            <li><a href="my-profile.html"><i class="fa fa-user"></i>My Profile</a></li>
                            <li><a href="change-password.html"><i class="fa fa-user"></i>Change Password</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-user"></i>Message</a></li>
                            <li><a href="index.html"><i class="fa fa-power-off"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>-->
            </div>
        </header>
        <div id="app-container" class="pdingbtm-50">
             

            <section class="container-fluid"> 
            <div class="row">
           
            <div class="content-title mrginbtm">
             <div class="row">
             <div class="col-md-8">
                    <h3 class="main-title">Director General Management Information System 
<span>Directorate General of Medical &amp; Health Services, Uttar Pradesh</span></h3>
 
                </div>
                 <div class="col-md-4 text-right">
                 <div class="datetime">
                                     
 <div class="time"> <i class="fa fa-clock-o" aria-hidden="true"></i>
            <noscript>
            Javascript Required
            </noscript>
            <span id="clockDisplay"> 
            <script type="text/javascript">
                            function renderTime() {
                                var currentTime = new Date();
                                var diem = "AM";
                                var h = currentTime.getHours();
                                var m = currentTime.getMinutes();
                                var s = currentTime.getSeconds();
                                setTimeout('renderTime()', 1000);
                                if (h == 0) {
                                    h = 12;
                                } else if (h > 12) {
                                    h = h - 12;
                                    diem = "PM";
                                }
                                if (h < 10) {
                                    h = "0" + h;
                                }
                                if (m < 10) {
                                    m = "0" + m;
                                }
                                if (s < 10) {
                                    s = "0" + s;
                                }
                                var myClock = document.getElementById('clockDisplay');
                                myClock.textContent = h + ":" + m + ":" + s + " " + diem;
                                myClock.innerText = h + ":" + m + ":" + s + " " + diem;
                            }
                            renderTime();
                        </script> 
            </span>
            <script type="text/javascript">
                        var d = new Date()
                        var weekday = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")
                        var monthname = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec")
                        document.write(weekday[d.getDay()] + ", ")
                        document.write(d.getDate() + " ")
                        document.write(monthname[d.getMonth()] + ", ")
                        document.write(d.getFullYear())
           </script> 
             </div>
                                     </div>
                 </div>
                 </div>
                </div>
                
                 
            </div>
