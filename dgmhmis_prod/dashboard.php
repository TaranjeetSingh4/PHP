<?php include('dashboard-home-header.php') ?>
<?php

if (isset($_SESSION['user_role'])) {
    $user_role = $_SESSION['user_role'];
} else {
    header("Location:index.php");
    session_destroy();
}

require_once('./controller/get_role_wise_formats.php');
require_once('./controller/config.php');

$district_id = $_SESSION['district_id'];
$query = "select * from master_division join master_district on master_division.id=master_district.division_id where master_district.id=$district_id";
$district_result = mysqli_query($conn, $query);
$district_row = mysqli_fetch_assoc($district_result);

$color = ['red', 'lighblue', 'orange', 'bluegrey', 'green', 'indigo'];
$icon_classes = ['fa-heartbeat', 'fa-plus-square', 'fa-h-square', 'fa-medkit', 'fa-heart', 'fa-certificate'];
?>
<div class="row">
    <!-- page title -->

    <div class="col-md-3  col-sm-12 ">
        <div class="content-left">
            <div class="cntnt-img"> </div>
            <div class="bnr-img"> <img src="images/default-image.jpg" alt="" /> </div>
            <div class="bnr-text">
                <h1><?php echo $_SESSION['username']; ?></h1>
                <?php if ($_SESSION['user_role'] != "admin") { ?>
                    <p>Division: <?php echo $district_row['name']; ?></p>
                    <p>District: <?php echo $district_row['district_name']; ?></p>
                <?php } ?>
                <p>Role: <?php echo $_SESSION['user_role']; ?></p>
                <!-- <p> <strong> Last login </strong> 25-08-2015</p> -->
            </div>
            <div class="btm-icon">
                <div class="col-md-6 col-sm-12">
                    <div class="row"> <a href="my-profile.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-green"> <i class="fa fa-user"></i>
                            <h5>My Profile</h5>
                        </a> </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row"> <a href="change-password.php" class="btn btn-green"> <i class="fa fa-unlock-alt"></i>
                            <h5> Change Password</h5>
                        </a> </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row"> <a href="#" class="btn btn-green"> <i class="fa fa-envelope-o"></i>
                            <h5> Message</h5>
                        </a> </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row"> <a href="./controller/logout.php" class="btn btn-green"> <i class="fa fa-sign-out"></i>
                            <h5> Logout</h5>
                        </a> </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="col-md-12 col-sm-12 col-xs-12 mesg">
            <div class="panel panel-info">
                <div class="panel-heading">Message </div>
                <div class="panel-body">
                    <ul class="news">
                        <li class="item">
                            <h4>DGMIS</h4>
                            <p>The Director General provides leadership in the development and implementation of MIS strategies that align with the organization’s objectives. This includes evaluating current systems, identifying areas for improvement, and planning for future technology needs.</p>
                        </li>
                        <li class="item">
                            <h4>DGMIS</h4>
                            <p>The Director General provides leadership in the development and implementation of MIS strategies that align with the organization’s objectives. This includes evaluating current systems, identifying areas for improvement, and planning for future technology needs.</p>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <ul class="circle">


            <?php if (isset($user_role) && ($user_role == "admin")) { ?>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="format-template.php" class="yellow">
                        <i class="fa fa-plus"></i>
                        Add New Format
                    </a>
                </li>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="edit-template-all.php" class="indigo">
                        <i class="fa fa-edit"></i>
                        Edit Format
                    </a>
                </li>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="mapping-template.php" class="green">
                        <i class="fa fa-edit"></i>
                        Format Mapping
                    </a>
                </li>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="add-user.php" class="orange">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Add New User
                    </a>
                </li>



                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="reports.php" class="green">
                        <i class="fa fa-file-text"></i>
                        Reports
                    </a>
                </li>


                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="outsource_report.php" class="yellow">
                        <i class="fa fa-file-text"></i>
                        Outsource Data Reports
                    </a>
                </li>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="patient-referral.php" class="indigo">
                        <i class="fa fa-superpowers"></i>
                        Patient Referrals/Follow Up
                    </a>
                </li>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="oral_awareness_uploads.php" class="<?php echo $color[3]; ?>">
                        <i class="fa <?php echo $icon_classes[3]; ?>"></i>Oral Awareness Camps Report(s)
                    </a>
                </li>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="critical_surgical_procedure_uploads.php" class="<?php echo $color[2]; ?>">
                        <i class="fa <?php echo $icon_classes[2]; ?>"></i>Critical Surgical Procedure Report(s)
                    </a>
                </li>



                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="#" class="red">
                        <i class="fa fa-edit"></i>
                        Master(s) Mapping
                    </a>
                </li>


            <?php } else if ($user_role != "admin" && $user_role == "DNO") { ?>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="add-user.php" class="orange">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New User
                    </a>
                </li>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="reports.php" class="<?php echo $color[1]; ?>">
                        <i class="fa <?php echo $icon_classes[5]; ?>"></i>Oral Reports
                    </a>
                </li>



                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="patient-referral.php" class="indigo">
                        <i class="fa fa-superpowers"></i>
                        Patient Referrals/Follow Up
                    </a>
                </li>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="oral_awareness_reports.php" class="<?php echo $color[3]; ?>">
                        <i class="fa <?php echo $icon_classes[3]; ?>"></i>Oral Awareness Camps Report(s)
                    </a>
                </li>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="critical_surgical_procedure_reports.php" class="<?php echo $color[2]; ?>">
                        <i class="fa <?php echo $icon_classes[2]; ?>"></i>Critical Surgical Procedure Report(s)
                    </a>
                </li>

            <?php } else if ($user_role != "admin" && $user_role == "CMO") { ?>


                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="outsource_report.php" class="<?php echo $color[1]; ?>">
                        <i class="fa <?php echo $icon_classes[5]; ?>"></i>Outsource Reports
                    </a>
                </li>

                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="add-user.php" class="orange">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New User
                    </a>
                </li>

                <?php } else {
                $count = 0;
                while ($row = mysqli_fetch_assoc($formats_result)) {
                ?>
                    <li class="col-md-3 col-sm-6 col-xs-12">
                        <a href="format-template-view.php?id=<?php echo $row['format_id']; ?>" class="<?php echo $color[$count]; ?>">
                            <i class="fa <?php echo $icon_classes[$count]; ?>"></i><?php echo $row['format_name']; ?>
                        </a>
                    </li>

                <?php
                    $count = $count + 1;
                }
                ?>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="oral_awareness_uploads.php" class="<?php echo $color[3]; ?>">
                        <i class="fa <?php echo $icon_classes[3]; ?>"></i>Oral Awareness Camps Upload(s)
                    </a>
                </li>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="critical_surgical_procedure_uploads.php" class="<?php echo $color[2]; ?>">
                        <i class="fa <?php echo $icon_classes[2]; ?>"></i>Critical Surgical Procedure Upload(s)
                    </a>
                </li>
                <li class="col-md-3 col-sm-6 col-xs-12">
                    <a href="patient-referral.php" class="indigo">
                        <i class="fa fa-superpowers"></i>
                        Patient Referrals/Follow Up
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
                    <li class="col-md-3 col-sm-6 col-xs-12">
                        <a href="list_manage_form_data.php" class="green">
                           <i class="fa fa-database" aria-hidden="true"></i>
                            <span class="menu-text">Manage Form Data</span>
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'CMO Office') : ?>
                    <li class="col-md-3 col-sm-6 col-xs-12">
                        <a href="list_mankaksh.php" class="<?php echo $color[4]; ?>">
                            <i class="fa fa-deaf" aria-hidden="true"></i>
                            Man-Kaksh Reports
                        </a>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12">
                        <a href="list_dua_se_dawa_tak.php" class="<?php echo $color[3]; ?>">
                            <i class="fa fa-hospital-o" aria-hidden="true"></i>
                            Dua Se Dawa Tak
                        </a>
                    </li>

                    <li class="col-md-3 col-sm-6 col-xs-12">
                        <a href="list_dmhp_monthly_report.php" class="indigo">
                            <i class="fa fa-random" aria-hidden="true"></i>
                            DMHP Monthly Report
                        </a>
                    </li>


                    <li class="col-md-3 col-sm-6 col-xs-12">
                        <a href="list_man_chetna_diwas.php" class="<?php echo $color[2]; ?>">
                            <i class="fa fa-empire" aria-hidden="true"></i>
                            Man Chetna Diwas Report
                        </a>
                    </li>
                <?php endif; ?>

            <?php } ?>










        </ul>

    </div>
</div>
</section>




</div>



</div>
<?php include('dashboard-home-footer.php') ?>