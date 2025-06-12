<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('blood_center');

$staff_id = $_SESSION['user_id'];


// Step 1: Get logged-in staff's name
$stmt = $conn->prepare("SELECT name FROM staff WHERE id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$res = $stmt->get_result();
$staff = $res->fetch_assoc();
$staff_name = $staff['name'] ?? null;

// Step 2: Match that name with blood_centers.name
$blood_center = null;
$blood_center_id = null;

if ($staff_name) {
    $stmt = $conn->prepare("SELECT id, name FROM blood_centers WHERE name = ?");
    $stmt->bind_param("s", $staff_name);
    $stmt->execute();
    $res = $stmt->get_result();
    $blood_center = $res->fetch_assoc();
    $blood_center_id = $blood_center['id'] ?? null;
}
$blood_center_id = $blood_center['id'] ?? null;
$user_list = [];


if ($blood_center_id) {
    $stmt = $conn->prepare("
        SELECT 
            u.id, u.name, u.mobile_number, u.email, u.age, u.dob, u.gender, u.blood_group, u.address, u.blood_center_id, u.referred_blood_center, bc.name AS blood_center_name
        FROM users u
        JOIN blood_centers bc ON u.blood_center_id = bc.id
        WHERE u.blood_center_id = ? AND u.referred_blood_center IS NOT NULL
        GROUP BY u.id
    ");
    $stmt->bind_param("i", $blood_center_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_list = $result->fetch_all(MYSQLI_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign Donor to Treatment Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> 
<style>
       th.dob-column, td.dob-column {
  min-width: 120px;
  white-space: nowrap; /* Ensures it stays on one line */
}
</style>
</head>

<body>
    <?php include('../includes/dashboard_layout/header.php'); ?>

    <div class="ts-main-content">
        <?php include('../includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Referred Donors</h2>
                        <?php if (!empty($user_list)): ?>
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-danger">
                                        <tr>
                                            <th>#</th>
                                            <th>Donor Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Age</th>
                                            <th class="dob-column">Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Blood Group</th>
                                            <th>Address</th>
                                            <th>Current Blood Center</th>
                                            <th>Referred Blood Center</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user_list as $index => $user): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($user['name']) ?></td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td><?= htmlspecialchars($user['mobile_number']) ?></td>
                                                <td><?= htmlspecialchars($user['age']) ?></td>
                                                 <td>
                                                    <?= isset($user['dob']) ? date('d-m-Y', strtotime($user['dob'])) : 'N/A' ?>
                                                </td>
                                                <td><?= htmlspecialchars(ucfirst($user['gender'])) ?></td>
                                                <td><?= htmlspecialchars(strtoupper($user['blood_group'])) ?></td>
                                                <td><?= htmlspecialchars($user['address']) ?></td>
                                                <td><?= htmlspecialchars($user['blood_center_name']) ?></td>
                                                <td>
                                                    <?php
                                                    // Fetch the referred blood center name
                                                    $stmt = $conn->prepare("SELECT name FROM blood_centers WHERE id = ?");
                                                    $stmt->bind_param("i", $user['referred_blood_center']);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();
                                                    $referred_blood_center = $res->fetch_assoc();
                                                    echo htmlspecialchars($referred_blood_center['name'] ?? 'N/A');
                                                    ?>
                                                    </td>


                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mt-4">No referred donors found for your blood center.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('table').DataTable();
    });
</script>
