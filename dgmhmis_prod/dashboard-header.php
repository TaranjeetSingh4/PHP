<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html class=" gecko win js" lang="en"><!-- InstanceBegin template="Templates/property-tax-dashboard.dwt" codeOutsideHTMLIsLocked="false" -->

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>DGMIS Portal</title>
    <!-- InstanceEndEditable -->
    <!-- Bootstrap -->

    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/essentials.css" rel="stylesheet" type="text/css" />
    <link href="css/extra.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-multiselect.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>                 -->
    <link href="//cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css">

    <!-- InstanceBeginEditable name="head" -->
    <!-- InstanceEndEditable -->
</head>

<body>
    <div id="app-wrapper" class="app-hide-lpanel">
        <header id="app-header">
            <div class="app-left-header">
                <a href="dashboard.php"><span>DGMIS</span></a>
                <span class="app-sidebar-toggle"><a href="javascript:void(0)"></a></span>
            </div>

            <div class="app-right-header">
                <span class="app-sidebar-toggle"><a href="javascript:void(0)"></a></span>
                <ul class="right-navbar">
                    <li class="dropdown app-rheader-submenu app-header-profile"> <a href="dashboard.php"> <span><b>Home</b></span> </a> </li>
                    <li class="dropdown app-rheader-submenu app-header-profile">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                            <span>
                                <img class="img-circle " src="images/avatar-1.jpg"></span>
                            <span><b></b><strong> <?php echo $_SESSION['username']; ?></strong> <i class=" fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu ">
                            <li><a href="my-profile.php?id=<?php echo $_SESSION['id']; ?>"><i class="fa fa-user"></i>My Profile</a></li>
                            <li><a href="change-password.php"><i class="fa fa-unlock-alt"></i>Change Password</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-envelope-o"></i>Message</a></li>
                            <!--<li><a href="javascript:void(0)"><i class="fa fa-calendar"></i>My Calendar</a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-envelope"></i>My Inbox  <span class="badge badge-danger">3 </span></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-rocket"></i>My Tasks <span class="badge badge-success">7 </span></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-lock"></i>Lock Screen</a></li>-->
                            <li><a href="index.php"><i class="fa fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>
        <div id="app-container">
            <aside id="app-left-panel">
                <div class="profile-box">
                    <div class="media">
                        <a class="pull-left" href="javascript:void(0)">
                            <img class="img-circle" src="images/avatar-1.jpg">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Welcome <?php echo $_SESSION['username']; ?></h4>
                            <!-- <small>Designation</small> -->
                        </div>
                    </div>
                </div>
                <ul class="nav panel-list">
                    <li class="nav-level">Navigation</li>
                    <!-- <li>
                        <a href="../dashboard.html">
                            <i class="fa fa-tachometer"></i>
                            <span class="menu-text">Dashboard</span>  
                        </a>
                         
                    </li> -->

                    <?php if (($_SESSION['user_role'] == "admin")) { ?>
                        <li>
                            <a href="dashboard.php">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>

                        </li>
                        <li>
                            <a href="reports.php">
                                <i class="fa fa-bullhorn"></i>
                                <span class="menu-text">Reports</span>
                            </a>

                        </li>


                        <li>
                            <a href="outsource_report.php">
                                <i class="fa fa-handshake-o"></i>
                                <span class="menu-text">Outsource Reports</span>
                            </a>

                        </li>

                        <li>
                            <a href="patient-referral.php">
                                <i class="fa fa-users"></i>
                                <span class="menu-text">Patient Referral/Follow Up</span>
                            </a>

                        </li>

                        <li>
                            <a href="oral_awareness_uploads.php">
                                <i class="fa fa-camera-retro"></i>
                                <span class="menu-text">Oral Awareness Camps</span>
                            </a>

                        </li>

                        <li>
                            <a href="critical_surgical_procedure_uploads.php">
                                <i class="fa fa-pie-chart"></i>
                                <span class="menu-text">Critical Surgical Procedures</span>
                            </a>

                        </li>


                    <?php } else if (($_SESSION['user_role'] == "DNO")) { ?>

                        <li>
                            <a href="dashboard.php">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>

                        </li>
                        <li>
                            <a href="reports.php">
                                <i class="fa fa-bullhorn"></i>
                                <span class="menu-text">Reports</span>
                            </a>

                        </li>


                        <li>
                            <a href="patient-referral.php">
                                <i class="fa fa-users"></i>
                                <span class="menu-text">Patient Referral/Follow Up</span>
                            </a>

                        </li>

                        <li>
                            <a href="oral_awareness_uploads.php">
                                <i class="fa fa-camera-retro"></i>
                                <span class="menu-text">Oral Awareness Camps</span>
                            </a>

                        </li>

                        <li>
                            <a href="critical_surgical_procedure_uploads.php">
                                <i class="fa fa-pie-chart"></i>
                                <span class="menu-text">Critical Surgical Procedures</span>
                            </a>

                        </li>

                    <?php } else if (($_SESSION['user_role'] == "CMO")) { ?>

                        <li>
                            <a href="dashboard.php">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>

                        </li>
                        <li>
                            <a href="outsource_report.php">
                                <i class="fa fa-bullhorn"></i>
                                <span class="menu-text">Outsource Reports</span>
                            </a>

                        </li>
                        ?>

                    <?php } else if (($_SESSION['added_by_cmo'] == 0)) { ?>

                        <li>
                            <a href="dashboard.php">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>

                        </li>

                        <li>
                            <a href="patient-referral.php">
                                <i class="fa fa-users"></i>
                                <span class="menu-text">Patient Referral/Follow Up</span>
                            </a>

                        </li>

                        <li>
                            <a href="oral_awareness_uploads.php">
                                <i class="fa fa-camera-retro"></i>
                                <span class="menu-text">Oral Awareness Camps</span>
                            </a>
                        </li>

                        <li>
                            <a href="critical_surgical_procedure_uploads.php">
                                <i class="fa fa-pie-chart"></i>
                                <span class="menu-text">Critical Surgical Procedures</span>
                            </a>
                        </li>

                        <?php
                        if (
                            isset($_SESSION['user_role']) &&
                            (
                                $_SESSION['user_role'] === 'Community Health Centre (CHC)' ||
                                $_SESSION['user_role'] === 'Primary Health Care (PHC)' ||
                                $_SESSION['user_role'] === 'Distict Hospital (CMS)'
                            )
                        ) {
                        ?>
                            <li>
                                <a href="list_manage_form_data.php">
                                    <i class="fa fa-database" aria-hidden="true"></i>
                                    <span class="menu-text">Manage Form Data</span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>


                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'CMO Office') : ?>
                            <li>
                                <a href="list_mankaksh.php">
                                    <i class="fa fa-bullhorn"></i>
                                    <span class="menu-text">Man-Kaksh Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="list_dua_se_dawa_tak.php">
                                    <i class="fa fa-ambulance" aria-hidden="true"></i>
                                    <span class="menu-text">Dua Se Dawa Tak Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="list_dmhp_monthly_report.php">
                                    <i class="fa fa-map-pin" aria-hidden="true"></i>
                                    <span class="menu-text">DMHP Monthly Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="list_man_chetna_diwas.php">
                                    <i class="fa fa-map" aria-hidden="true"></i>
                                    <span class="menu-text">Man Chetna Diwas Reports</span>
                                </a>
                            </li>
                        <?php endif; ?>

                    <?php
                    } else { ?>
                        <li>
                            <a href="outsource_dashboard.php">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>

                        </li>

                    <?php } ?>

                    <!-- <li>
                        <a href="search-property.html">
                            <i class="fa fa-search"></i>
                            <span class="menu-text">Search Property</span> 
                        </a>
                         
                    </li>
                     <li>
                        <a href="know-your-tax.html">
                            <i class="fa fa-file-text-o"></i>
                            <span class="menu-text">Know Your Tax </span>
                        </a>
                         
                    </li>
                    <li>
                        <a href="proceed-to-bill-payment.html">
                            <i class="fa fa-paypal"></i>
                            <span class="menu-text">Proceed to Bill Payment</span>
                        </a>
                         
                    </li> -->


                    <!-- <li>
                        <a href="find-your-property-id.html">
                            <i class="fa fa-building-o"></i>
                            <span class="menu-text">Find Your Property ID</span>
                        </a>
                         
                    </li>
                    <li>
                        <a href="previous-transaction-status.html">
                            <i class="fa fa-files-o"></i>
                            <span class="menu-text">Previous Transaction Status</span>
                        </a>
                         
                    </li> -->

                    <!--<li class="app-has-menu">
                        <a href="javascript:void(0)">
                            <i class="fa fa-table"></i>
                            <span class="menu-text">Tables</span>
                            <span class="selected"></span>
                        </a>
                        <ul class="app-sub-menu">
                            <li class="app-has-menu">
                                <a href="javascript:void(0)">
                                    <span class="menu-text">Datatables </span>
                                    <span class="selected"></span>
                                </a>
                                <ul class="app-sub-menu">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <span class="menu-text">Managed Datatables</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <span class="menu-text">Editable Datatables</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <span class="menu-text">Advanced Datatables</span>
                                            <span class="selected"></span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="menu-text">Bootstrap Tables</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="menu-text">jQuery Grid</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="menu-text">jQuery Footable</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        </ul>
                    </li> 
                    <li class="app-has-menu">
                        <a href="javascript:void(0)">
                            <i class="fa fa-pencil-square-o"></i>
                            <span class="menu-text">Forms</span>
                            <span class="selected"></span>
                        </a>
                        <ul class="app-sub-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="menu-text">Sarah Elements</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="menu-text">Masked Inputs</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="menu-text">Pickers</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </aside>