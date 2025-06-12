<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('admin');

$staff_id = $_SESSION['user_id'];


// Step 1: Get logged-in staff's name
$stmt = $conn->prepare("SELECT name FROM staff WHERE id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$res = $stmt->get_result();
$staff = $res->fetch_assoc();
$staff_name = $staff['name'] ?? null;

$user_list = [];

if ($staff_name) {
    $sql = "
        SELECT 
            u.id, u.name, u.mobile_number, u.email, u.dob, u.age, u.gender, u.blood_group, u.address, 
            u.blood_center_id, u.referred_blood_center, 
            bc.name AS blood_center_name,
            t.status AS treatment_status, t.room_no, t.block, t.doctor_name, t.file_path,
            d.name AS district_name,
            tc.center_name
        FROM users u
        JOIN blood_centers bc ON u.blood_center_id = bc.id
        LEFT JOIN treatments t ON u.id = t.user_id
        LEFT JOIN districts d ON t.district_id = d.id
        LEFT JOIN treatment_centers tc ON t.treatment_center_id = tc.id
        GROUP BY u.id
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
                                <table id="donorTable" class="table table-bordered table-striped nowrap">

                                    <thead class="table-danger">
                                        <tr>
                                            <th>#</th>
                                            <th>Donor Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th class="dob-column">Date of Birth</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Blood Group</th>
                                            <th>Address</th>
                                            <th>District</th>
                                            <th>Current Blood Center</th>
                                            <th>Treatment Center</th>
                                            <th>Room No.</th>
                                            <th>Block</th>
                                            <th>Doctor Assigned</th>
                                            <th>Treatment Status</th>
                                            <th>Consent Form</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user_list as $index => $user): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($user['name']) ?></td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                                <td><?= htmlspecialchars($user['mobile_number']) ?></td>
                                                <td>
                                                    <?= isset($user['dob']) ? date('d-m-Y', strtotime($user['dob'])) : 'N/A' ?>
                                                </td>
                                                <td><?= htmlspecialchars($user['age']) ?></td>
                                                <td><?= htmlspecialchars(ucfirst($user['gender'])) ?></td>
                                                <td><?= htmlspecialchars(strtoupper($user['blood_group'])) ?></td>
                                                <td><?= htmlspecialchars($user['address']) ?></td>
                                                <td><?= htmlspecialchars($user['district_name'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['blood_center_name']) ?></td>
                                                <td><?= htmlspecialchars($user['center_name'] ?? 'N/A') ?></td>
                                                <td><?= isset($user['room_no']) && $user['room_no'] !== null ? htmlspecialchars($user['room_no']) : 'N/A' ?></td>

                                                <td><?= htmlspecialchars($user['block'] ?? 'N/A') ?></td>
                                                <td><?= htmlspecialchars($user['doctor_name'] ?? 'N/A') ?></td>
                                                <td><?= !empty($user['treatment_status']) ? htmlspecialchars($user['treatment_status']) : 'Not Started'; ?></td>
                                                <td>
                                                    <?php if (!empty($user['file_path'])): ?>
                                                        <a class="text-decoration-none" href="<?= htmlspecialchars($user['file_path']) ?>" target="_blank">View Consent Form</a>
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
        $('#donorTable').DataTable({

            autoWidth: false,
            columnDefs: [{
                targets: 4,
                width: '130px'
            }]
        });
    });
</script>