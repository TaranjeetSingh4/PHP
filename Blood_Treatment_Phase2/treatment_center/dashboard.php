<?php
require '../includes/auth.php';
requireRole('treatment_center');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
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
</head>
<body>
    <?php include('../includes/dashboard_layout/header.php'); ?>

    <div class="ts-main-content">
        <?php include('../includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                           <h2 class="page-title">Welcome to the <?php echo $_SESSION['name']; ?> Dashboard</h2>
                           <h5>This is the dashboard panel</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
