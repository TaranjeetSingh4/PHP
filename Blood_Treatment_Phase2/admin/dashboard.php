<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blood Center Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <h5>This is the Admin dashboard panel</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>