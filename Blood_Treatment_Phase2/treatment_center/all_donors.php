<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('treatment_center');

$staff_id = $_SESSION['user_id'];

// Step 1: Get staff name
$stmt = $conn->prepare("SELECT name FROM staff WHERE id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$res = $stmt->get_result();
$staff = $res->fetch_assoc();
$staff_name = $staff['name'] ?? null;



// Step 2: Get treatment center details by matching name
$treatment_center = null;
$treatment_center_id = null;

if ($staff_name) {
    $stmt = $conn->prepare("SELECT id, center_name FROM treatment_centers WHERE center_name = ?");
    $stmt->bind_param("s", $staff_name);
    $stmt->execute();
    $res = $stmt->get_result();

    $treatment_center = $res->fetch_assoc();

    $treatment_center_id = $treatment_center['id'] ?? null;
}

// Step 3: Fetch user names allotted to this treatment center
$user_list = [];

if ($treatment_center_id) {
    $stmt = $conn->prepare("
        SELECT 
            u.id,
            u.name,
            u.email,
            u.mobile_number,
            u.age,
            u.dob,
            u.gender,
            u.blood_group,
            u.address,
            t.block,
            t.room_no,
            t.doctor_name,
            t.status,
            t.file_path,
            bc.name AS blood_center_name,
            d.name AS district_name,
            tc.center_name
        FROM users u
        JOIN treatments t ON t.user_id = u.id
        JOIN blood_centers bc ON t.blood_center_id = bc.id
        LEFT JOIN districts d ON t.district_id = d.id
        LEFT JOIN treatment_centers tc ON t.treatment_center_id = tc.id
        WHERE t.treatment_center_id = ?
    ");
    $stmt->bind_param("i", $treatment_center_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user_list = $res->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign Donor's to Block</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        th.dob-column,
        td.dob-column {
            min-width: 120px;
            white-space: nowrap;
            /* Ensures it stays on one line */
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
                        <h2 class="page-title">View All Donors</h2>
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
                                            <th>District</th>
                                            <th>Blood Center</th>
                                            <th>Treatment Center</th>
                                            <th>Block</th>
                                            <th>Room</th>
                                            <th>Doctor Assigned</th>
                                            <th>Treatment Satus</th>
                                            <th>Consent Fomr</th>
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
                                                <td><?= htmlspecialchars($user['district_name'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['blood_center_name']) ?></td>
                                                <td><?= htmlspecialchars($user['center_name'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['block'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['room_no'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['doctor_name'] ?? 'N/A') ?></td>
                                                <td><?= !empty($user['status']) ? htmlspecialchars($user['status']) : 'Not Started'; ?></td>
                                                <td>
                                                    <?php if (!empty($user['file_path'])): ?>
                                                        <a href="<?= htmlspecialchars($user['file_path']) ?>" target="_blank">View Consent Form</a>
                                                    <?php else: ?>
                                                        Not Uploaded yet !!
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning mt-4">No donors found for your blood center.</div>
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