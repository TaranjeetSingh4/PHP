<?php include('dashboard-header.php'); ?>

<?php
session_start();
if (!isset($_SESSION['user_role'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['user_role'] !== 'CMO Office') {
    echo "<div class='text-center text-danger'>
    <strong>Access Denied. You are not authorized to view this page.</strong></div>";
    exit();
}
require_once './controller/config.php';
$conn = get_db_connection();
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$success = false;
$error = '';

$id = (int)$_GET['id'];

// Fetch existing record
$sql = "SELECT * FROM man_chetna_diwas WHERE id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);


if (!$data) {
    echo "Record not found.";
    exit;
}

// Fetch district name
$district_id = $data['district_id'];
$sql2 = "SELECT district_name FROM master_district WHERE id = $district_id";
$result2 = mysqli_query($conn, $sql2);
$district = mysqli_fetch_assoc($result2);
$district_name = $district['district_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_GET['id']; // Make sure 'id' is posted

    // Define all fields from your form
    $fields = [
        'chc_phc_name',
        'new_opd_patients',
        'follow_up_cases_opd',
        'patients_counselled',
        'referred_to_dh',
        'referred_back_from_dh'
    ];

    // Build SET part of the SQL
    $update_parts = [];
    foreach ($fields as $field) {
        $value = mysqli_real_escape_string($conn, $_POST[$field] ?? '');
        $update_parts[] = "$field = '$value'";
    }

    $set_clause = implode(', ', $update_parts);

    $sql_update = "UPDATE man_chetna_diwas SET $set_clause WHERE id = $id";

    if (mysqli_query($conn, $sql_update)) {
        $success = true;
        echo "<p>Record updated successfully.</p>";

        // Optional: fetch the updated record
        $result = mysqli_query($conn, "SELECT * FROM man_chetna_diwas WHERE id = $id");
        $data = mysqli_fetch_assoc($result);
    } else {
        $error = "Update failed: " . mysqli_error($conn);
        echo "<p style='color:red;'>$error</p>";
    }
}

?>

<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
            <h2 class="text-center">Update Record</h2>
            <a href="list_man_chetna_diwas.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <?php if ($success): ?>
                    <div class="alert alert-success  col-md-4">
                        Your data has been updated successfully.
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form class="p-4 border rounded bg-light container" method="post">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="districtName" class="form-label">District Name</label>
                                        <input type="text" id="districtName" class="form-control" value="<?= htmlspecialchars($district_name) ?>" readonly required>
                                        <input type="hidden" name="district_id" value="<?= $district_id ?>">
                                    </div>

                                    <!-- Name of CHC/PHC -->
                                    <div class="mb-3">
                                        <label for="chcPhcName" class="form-label">Name of CHC/PHC</label>
                                        <input type="text" id="chcPhcName" name="chc_phc_name" class="form-control" value="<?= isset($data['chc_phc_name']) ? htmlspecialchars($data['chc_phc_name']) : '' ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="newOpdPatients" class="form-label">New OPD Patients</label>
                                        <input type="number" id="newOpdPatients" name="new_opd_patients" class="form-control" value="<?= htmlspecialchars($data['new_opd_patients']) ?>" required>
                                    </div>

                                    <!-- Follow up cases in OPD -->
                                    <div class="mb-3">
                                        <label for="followUpCasesOpd" class="form-label">Follow up Cases in OPD</label>
                                        <input type="number" id="followUpCasesOpd" name="follow_up_cases_opd" class="form-control" value="<?= htmlspecialchars($data['follow_up_cases_opd']) ?>" required>
                                    </div>

                                    <!-- No. of patients counselled -->
                                    <div class="mb-3">
                                        <label for="patientsCounselled" class="form-label">No. of Patients Counselled</label>
                                        <input type="number" id="patientsCounselled" name="patients_counselled" class="form-control" value="<?= htmlspecialchars($data['patients_counselled']) ?>" required>
                                    </div>

                                    <!-- Referred cases to DH -->
                                    <div class="mb-3">
                                        <label for="referredToDh" class="form-label">Referred Cases to District Hospital (DH)</label>
                                        <input type="number" id="referredToDh" name="referred_to_dh" class="form-control" value="<?= htmlspecialchars($data['referred_to_dh']) ?>"  required>
                                    </div>

                                    <!-- Referred back from district hospital -->
                                    <div class="mb-3">
                                        <label for="referredBackFromDh" class="form-label">Referred Back from District Hospital</label>
                                        <input type="number" id="referredBackFromDh" name="referred_back_from_dh" class="form-control" value="<?= htmlspecialchars($data['referred_back_from_dh']) ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Record</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?php include('dashboard-footer.php'); ?>