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
$sql = "SELECT * FROM district_counselling_center_man_kakash WHERE id = $id";
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
    $new_cases_man_kaksh = (int)$_POST['new_cases_man_kaksh'];
    $followup_cases_man_kaksh = (int)$_POST['followup_cases_man_kaksh'];
    $total_cases = (int)$_POST['total_cases'];
    $common_mental_disorders = (int)$_POST['common_mental_disorders'];
    $severe_mental_disorders = (int)$_POST['severe_mental_disorders'];
    $family_therapy = (int)$_POST['family_therapy'];
    $crisis_help_cases = (int)$_POST['crisis_help_cases'];
    $suicide = (int)$_POST['suicide'];
    $disaster = (int)$_POST['disaster'];
    $any_other = (int)$_POST['any_other'];
    $psychological_interventions = (int)$_POST['psychological_interventions'];
    $disability_certifications = (int)$_POST['disability_certifications'];
    $IQ = (int)$_POST['IQ'];
    $ASD = (int)$_POST['ASD'];
    $LD = (int)$_POST['LD'];
    $addiction_cases = (int)$_POST['addiction_cases'];
    $tobacco = (int)$_POST['tobacco'];
    $alcohol = (int)$_POST['alcohol'];
    $opioids = (int)$_POST['opioids'];
    $mobile_addiction = (int)$_POST['mobile_addiction'];
    $addiction_any_other = (int)$_POST['addiction_any_other'];
    $referrals_from_teaching_institutes = (int)$_POST['referrals_from_teaching_institutes'];

    $sql_update = "UPDATE district_counselling_center_man_kakash SET
        new_cases_man_kaksh = $new_cases_man_kaksh,
        followup_cases_man_kaksh = $followup_cases_man_kaksh,
        total_cases = $total_cases,
        common_mental_disorders = $common_mental_disorders,
        severe_mental_disorders = $severe_mental_disorders,
        family_therapy = $family_therapy,
        crisis_help_cases = $crisis_help_cases,
        suicide = $suicide,
        disaster = $disaster,
        any_other = $any_other,
        psychological_interventions = $psychological_interventions,
        disability_certifications = $disability_certifications,
        IQ = $IQ,
        ASD = $ASD,
        LD = $LD,
        addiction_cases = $addiction_cases,
        tobacco = $tobacco,
        alcohol = $alcohol,
        opioids = $opioids,
        mobile_addiction = $mobile_addiction,
        addiction_any_other = $addiction_any_other,
        referrals_from_teaching_institutes = $referrals_from_teaching_institutes
        WHERE id = $id";

    if (mysqli_query($conn, $sql_update)) {
        $success = true;

        // Re-fetch the updated record
        $result = mysqli_query($conn, "SELECT * FROM district_counselling_center_man_kakash WHERE id = $id");
        $data = mysqli_fetch_assoc($result);
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Edit Record #<?= $id ?></h2>

<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
            <h2 class="text-center">Update Record</h2>
            <a href="list_mankaksh.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
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
                                        <label class="form-label">New Cases Man Kaksh</label>
                                        <input type="number" class="form-control" name="new_cases_man_kaksh" value="<?= (int)$data['new_cases_man_kaksh'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Follow up Cases Man Kaksh</label>
                                        <input type="number" class="form-control" name="followup_cases_man_kaksh" value="<?= (int)$data['followup_cases_man_kaksh'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Total Cases (New + Follow Up)</label>
                                        <input type="number" class="form-control" name="total_cases" value="<?= (int)$data['total_cases'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cases of Common Mental Disorders</label>
                                        <input type="number" class="form-control" name="common_mental_disorders" value="<?= (int)$data['common_mental_disorders'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cases of Severe Mental Disorders</label>
                                        <input type="number" class="form-control" name="severe_mental_disorders" value="<?= (int)$data['severe_mental_disorders'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Cases of Family Therapy/ Marital Therapy</label>
                                        <input type="number" class="form-control" name="family_therapy" value="<?= (int)$data['family_therapy'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No of cases reported for crisis help</label>
                                        <input type="number" class="form-control" name="crisis_help_cases" value="<?= (int)$data['crisis_help_cases'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Suicide</label>
                                        <input type="number" class="form-control" name="suicide" value="<?= (int)$data['suicide'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Disaster</label>
                                        <input type="number" class="form-control" name="disaster" value="<?= (int)$data['disaster'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Any other</label>
                                        <input type="number" class="form-control" name="any_other" value="<?= (int)$data['any_other'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No. of Psychological intervention done</label>
                                        <input type="number" class="form-control" name="psychological_interventions" value="<?= (int)$data['psychological_interventions'] ?>">
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">No. of Disability Certification Done</label>
                                        <input type="number" class="form-control" name="disability_certifications" value="<?= (int)$data['disability_certifications'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">IQ</label>
                                        <input type="number" class="form-control" name="IQ" value="<?= (int)$data['IQ'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">ASD (Autism Spectrum Disorder)</label>
                                        <input type="number" class="form-control" name="ASD" value="<?= (int)$data['ASD'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">LD (Learning Disability)</label>
                                        <input type="number" class="form-control" name="LD" value="<?= (int)$data['LD'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No. of cases benefitted for addiction</label>
                                        <input type="number" class="form-control" name="addiction_cases" value="<?= (int)$data['addiction_cases'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tobacco</label>
                                        <input type="number" class="form-control" name="tobacco" value="<?= (int)$data['tobacco'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Alcohol</label>
                                        <input type="number" class="form-control" name="alcohol" value="<?= (int)$data['alcohol'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Opioids</label>
                                        <input type="number" class="form-control" name="opioids" value="<?= (int)$data['opioids'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mobile addiction</label>
                                        <input type="number" class="form-control" name="mobile_addiction" value="<?= (int)$data['mobile_addiction'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Any other addiction</label>
                                        <input type="number" class="form-control" name="addiction_any_other" value="<?= (int)$data['addiction_any_other'] ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">No. of referrals from Teaching institutes</label>
                                        <input type="number" class="form-control" name="referrals_from_teaching_institutes" value="<?= (int)$data['referrals_from_teaching_institutes'] ?>">
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