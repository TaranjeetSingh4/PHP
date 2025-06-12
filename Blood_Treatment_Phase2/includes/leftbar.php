<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../includes/css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../includes/css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="../includes/css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="../includes/css/style.css">
      <script src="../includes/js/all.min.js"></script>



      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


</head>
<body>
    <nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">
        <li class="ts-label">Main</li>
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i><span class="ps-2">Dashboard</span></a></li>
         <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li><a href="all_donors.php" class="d-flex"><i class="fa-solid fa-droplet pt-1"></i><span class="ps-2"> View All Donor's</span></a></li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'blood_center'): ?>
             <li><a href="register_donor.php"><i class="fa-solid fa-user-plus"></i><span class="ps-2">Register Donor</span></a></li>
            <li><a href="donor_status_update.php"><i class="fa-solid fa-pen-to-square"></i><span class="ps-2">Update Donor Test Status</span></a></li>
            <li><a href="assign_donor_center.php" class="d-flex"><i class="fa fa-upload pt-2"></i><span class="ps-2">Assign Donor's to Treatment Center</span></a></li>
            <li><a href="all_donors.php" class="d-flex"><i class="fa-solid fa-droplet pt-1"></i><span class="ps-2"> View All Donor's</span></a></li>
            <li><a href="referred_donors.php" class="d-flex"><i class="fa-solid fa-retweet pt-1"></i><span class="ps-2"> Referred Donor's</span></a></li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'treatment_center'): ?>
            <li><a href="update_user_treatment.php"><i class="fa-solid fa-pen-to-square"></i><span class="ps-2">Update Donor's Treatment</span></a></li>
            <li><a href="all_donors.php" class="d-flex"><i class="fa-solid fa-droplet pt-1"></i><span class="ps-2"> View All Donor's</span></a></li>
        <?php endif; ?>
    </ul>
</nav>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
 <script>
    $(function () {
        $("#dob").datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2025"
        });
    });
</script>
</body>
</html>
