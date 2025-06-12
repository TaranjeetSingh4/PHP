<?php include('dashboard-header.php') ?>

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

$district_id = '';
$district_name = '';

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'CMO Office') {
    // Get district ID from session
    if (!empty($_SESSION['district_id'])) {
        $district_id = $_SESSION['district_id'];

        // Fetch district name using district_id
        $query = "SELECT district_name FROM master_district WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $district_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $district_name = $row['district_name'];
        } else {
            $district_name = 'Unknown District';
        }
    } else {
        $district_name = 'District ID not found in session';
    }
} else {
    $district_name = 'Access Denied';
}

$success = false;
$error = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get POST values (cast to int for safety)
    $district_id = (int)$_POST['district_id'];
    $chc_phc_name = htmlspecialchars(trim($_POST['chc_phc_name']), ENT_QUOTES, 'UTF-8');
    $new_opd_patients = (int)$_POST['new_opd_patients'];
    $follow_up_cases_opd = (int)$_POST['follow_up_cases_opd'];
    $patients_counselled = (int)$_POST['patients_counselled'];
    $referred_to_dh = (int)$_POST['referred_to_dh'];
    $referred_back_from_dh = (int)$_POST['referred_back_from_dh'];

    $sql = "INSERT INTO man_chetna_diwas (
    district_id, chc_phc_name, new_opd_patients, follow_up_cases_opd, patients_counselled, referred_to_dh, referred_back_from_dh
) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiiiii", $district_id, $chc_phc_name, $new_opd_patients, $follow_up_cases_opd, $patients_counselled, $referred_to_dh, $referred_back_from_dh);

    if ($stmt->execute()) {
        $success = true;
        header("Location: list_man_chetna_diwas.php");
        
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
            <h2 class="text-center">Add New Record</h2>
            <a href="list_man_chetna_diwas.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <?php if ($success): ?>
                    <div class="alert alert-success  col-md-4">
                        Your data has been saved successfully.
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
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="districtName" class="form-label">District Name</label>
                                        <input type="text" id="districtName" class="form-control" value="<?= htmlspecialchars($district_name) ?>" readonly required>
                                        <input type="hidden" name="district_id" value="<?= $district_id ?>">
                                    </div>

                                    <!-- Name of CHC/PHC -->
                                    <div class="mb-3">
                                        <label for="chcPhcName" class="form-label">Name of CHC/PHC</label>
                                        <input type="text" id="chcPhcName" name="chc_phc_name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="newOpdPatients" class="form-label">New OPD Patients</label>
                                        <input type="number" id="newOpdPatients" name="new_opd_patients" class="form-control" required>
                                    </div>

                                    <!-- Follow up cases in OPD -->
                                    <div class="mb-3">
                                        <label for="followUpCasesOpd" class="form-label">Follow up Cases in OPD</label>
                                        <input type="number" id="followUpCasesOpd" name="follow_up_cases_opd" class="form-control" required>
                                    </div>

                                    <!-- No. of patients counselled -->
                                    <div class="mb-3">
                                        <label for="patientsCounselled" class="form-label">No. of Patients Counselled</label>
                                        <input type="number" id="patientsCounselled" name="patients_counselled" class="form-control" required>
                                    </div>

                                    <!-- Referred cases to DH -->
                                    <div class="mb-3">
                                        <label for="referredToDh" class="form-label">Referred Cases to District Hospital (DH)</label>
                                        <input type="number" id="referredToDh" name="referred_to_dh" class="form-control" required>
                                    </div>

                                    <!-- Referred back from district hospital -->
                                    <div class="mb-3">
                                        <label for="referredBackFromDh" class="form-label">Referred Back from District Hospital</label>
                                        <input type="number" id="referredBackFromDh" name="referred_back_from_dh" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 14px;">Add Record</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>



        </div>
    </div>
</section>

<?php include('dashboard-footer.php'); ?>