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
$sql = "SELECT * FROM dua_se_dawa_tak WHERE id = $id";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update record with posted values
    $total_dawa_camps = (int)$_POST['total_dawa_camps'];
    $persons_screened = (int)$_POST['persons_screened'];
    $patients_referred_district_hospital = (int)$_POST['patients_referred_district_hospital'];
    
    

    $sql_update = "UPDATE dua_se_dawa_tak SET
        total_dawa_camps = $total_dawa_camps,
        persons_screened = $persons_screened,
        patients_referred_district_hospital = $patients_referred_district_hospital
        WHERE id = $id";

    if (mysqli_query($conn, $sql_update)) {
        $success = true;

        // Re-fetch the updated record
        $result = mysqli_query($conn, "SELECT * FROM dua_se_dawa_tak WHERE id = $id");
        $data = mysqli_fetch_assoc($result);
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
            <h2 class="text-center">Update Record</h2>
            <a href="list_dua_se_dawa_tak.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
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
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($district_name) ?>" readonly>
                                        <input type="hidden" name="district_id" value="<?= $district_id ?>">
                                    </div>
                                    <div class="mb-3">
                                         <label class="form-label">No. of Dua Se Dawa Tak Camp</label>
                                        <input type="number"  name="total_dawa_camps" class="form-control" value="<?= (int)$data['total_dawa_camps'] ?>">
                                    </div>

                                    <div class="mb-3">
                                         <label class="form-label">No.of person screened in Dua se Dawa Tak Camp</label>
                                        <input type="number" name="persons_screened" class="form-control" value="<?= (int)$data['persons_screened'] ?>">
                                    </div>

                                    <div class="mb-3">
                                          <label class="form-label">No. of patient refered to Distrct Hospital for further treatment</label>
                                        <input type="number" name="patients_referred_district_hospital" class="form-control" value="<?= (int)$data['patients_referred_district_hospital'] ?>">
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