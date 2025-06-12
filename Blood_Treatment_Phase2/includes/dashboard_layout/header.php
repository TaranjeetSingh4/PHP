<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../includes/css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="../includes/css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="../includes/css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="../includes/css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="../includes/css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="../includes/css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="../includes/css/style.css">
    <script src="../includes/js/all.min.js"></script>
    <style>
        .ts-sidebar.active {
            display: block !important;
            position: absolute;
            top: 60px;
            left: 0;
            background-color: #2c3e50;
            height: 100%;
            z-index: 9999;
            padding-top: 0px;
            overflow: hidden;
            padding-bottom: 365px;
        }

        /* Sidebar default hidden on small screens */
        @media (max-width: 767px) {
            .ts-sidebar.active {
                display: block !important;
                position: absolute;
                top: 60px;
                left: 0;
                background-color: #2c3e50;
                height: 100%;
                z-index: 9999;
                padding-top: 0px;
                overflow: hidden;
                padding-bottom: 365px;
            }


        }
    </style>
</head>

<body>
    <div class="brand clearfix">
        <a href="dashboard.php" class="text-white text-decoration-none ps-3" style="font-size: 18px;position: absolute;margin-top: 15px;">Blood and Treatment Center Referral System</a>
        <span class="menu-btn"><i class="fa fa-bars"></i></span>
        <ul class="ts-profile-nav">

            <li class="ts-account">
                <a href="#" class="text-decoration-none"><img src="img/ts-avatar.jpg" class="ts-avatar hidden-side" alt=""> Account <i class="fa fa-angle-down hidden-side"></i></a>
                <ul>
                    <li> <a href="../logout.php" class="text-decoration-none"><i class="fa-solid fa-right-from-bracket pt-1"></i><span class="ps-2">Logout</span></a></li>
                </ul>
            </li>
        </ul>
    </div>

    <nav class="ts-sidebar d-block d-sm-none d-md-none d-lg-none">
        <ul class="ts-sidebar-menu">
            <li class="ts-label">Main</li>
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i><span class="ps-2">Dashboard</span></a></li>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <li><a href="all_donors.php" class="d-flex"><i class="fa-solid fa-droplet pt-1"></i><span class="ps-2"> View All Donor's</span></a></li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'blood_center'): ?>
                <li><a href="register_donor.php"><i class="fa-solid fa-user-plus"></i><span class="ps-2">Register Donor</span></a></li>
                <li><a href="donor_status_update.php"><i class="fa-solid fa-pen-to-square"></i><span class="ps-2">Update Donor Test Status</span></a></li>
                <li><a href="assign_donor_center.php" class="d-flex"><i class="fa fa-upload"></i><span class="ps-2">Assign Donor's to Treatment Center</span></a></li>
                <li><a href="all_donors.php" class="d-flex"><i class="fa-solid fa-droplet pt-1"></i><span class="ps-2"> View All Donor's</span></a></li>
                <li><a href="referred_donors.php" class="d-flex"><i class="fa fa-upload"></i><span class="ps-2"> Referred Donor's</span></a></li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] == 'treatment_center'): ?>
                <li><a href="update_user_treatment.php"><i class="fa-solid fa-pen-to-square"></i><span class="ps-2">Update Donor's Treatment</span></a></li>
                <li><a href="all_donors.php" class="d-flex"><i class="fa-solid fa-droplet pt-1"></i><span class="ps-2"> View All Donor's</span></a></li>
            <?php endif; ?>
            <li><a href="../logout.php" class="d-flex"><i class="fa-solid fa-right-from-bracket pt-1"></i><span class="ps-2">Logout</span></a></li>
        </ul>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuBtn = document.querySelector(".menu-btn");
            const sidebar = document.querySelector(".ts-sidebar");

            menuBtn.addEventListener("click", function() {
                sidebar.classList.toggle("active");
            });
        });
    </script>

</body>

</html>