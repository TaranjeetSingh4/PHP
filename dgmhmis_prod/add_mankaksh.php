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

  $sql = "INSERT INTO district_counselling_center_man_kakash (
        district_id, new_cases_man_kaksh, followup_cases_man_kaksh, total_cases, common_mental_disorders, severe_mental_disorders, 
        family_therapy, crisis_help_cases, suicide, disaster, any_other, psychological_interventions, disability_certifications,
        IQ, ASD, LD, addiction_cases, tobacco, alcohol, opioids, mobile_addiction, addiction_any_other, referrals_from_teaching_institutes
    ) VALUES (
        $district_id, $new_cases_man_kaksh, $followup_cases_man_kaksh, $total_cases, $common_mental_disorders, $severe_mental_disorders,
        $family_therapy, $crisis_help_cases, $suicide, $disaster, $any_other, $psychological_interventions, $disability_certifications,
        $IQ, $ASD, $LD, $addiction_cases, $tobacco, $alcohol, $opioids, $mobile_addiction, $addiction_any_other, $referrals_from_teaching_institutes
    )";


  if (mysqli_query($conn, $sql)) {
    $success = true;
    header("Location: list_mankaksh.php");
  } else {
    $error = "Error: " . mysqli_error($conn);
  }
}
?>

<section id="main-content" style="min-height: 100vh;">
  <!-- page title -->
  <div id="content" class="dashboard padding-20 margin-bottom-50">
    <div class="row">
      <h2 class="text-center">Add New Record</h2>
      <a href="list_mankaksh.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
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
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="districtName" class="form-label">District Name</label>
                    <input type="text" id="districtName" class="form-control" value="<?= htmlspecialchars($district_name) ?>" readonly required>
                    <input type="hidden" name="district_id" value="<?= $district_id ?>">
                  </div>

                  <div class="mb-3">
                    <label for="newCases" class="form-label">New Cases Man Kaksh</label>
                    <input type="number" id="newCases" name="new_cases_man_kaksh" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="followupCases" class="form-label">Follow up Cases Man Kaksh</label>
                    <input type="number" id="followupCases" name="followup_cases_man_kaksh" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="totalCases" class="form-label">Total Cases (New + Follow Up)</label>
                    <input type="number" id="totalCases" name="total_cases" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="commonMental" class="form-label">Cases of Common Mental Disorders</label>
                    <input type="number" id="commonMental" name="common_mental_disorders" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="severeMental" class="form-label">Cases of Severe Mental Disorders</label>
                    <input type="number" id="severeMental" name="severe_mental_disorders" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="familyTherapy" class="form-label">Cases of Family Therapy/ Marital Therapy</label>
                    <input type="number" id="familyTherapy" name="family_therapy" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="crisisHelp" class="form-label">No of cases reported for crisis help</label>
                    <input type="number" id="crisisHelp" name="crisis_help_cases" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="suicide" class="form-label">Suicide</label>
                    <input type="number" id="suicide" name="suicide" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="disaster" class="form-label">Disaster</label>
                    <input type="number" id="disaster" name="disaster" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="anyOther" class="form-label">Any other</label>
                    <input type="number" id="anyOther" name="any_other" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="psychologicalIntervention" class="form-label">No. of Psychological intervention done</label>
                    <input type="number" id="psychologicalIntervention" name="psychological_interventions" class="form-control" required>
                  </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="disabilityCertification" class="form-label">No. of Disability Certification Done</label>
                    <input type="number" id="disabilityCertification" name="disability_certifications" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="IQ" class="form-label">IQ</label>
                    <input type="number" id="IQ" name="IQ" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="ASD" class="form-label">ASD (Autism Spectrum Disorder)</label>
                    <input type="number" id="ASD" name="ASD" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="LD" class="form-label">LD (Learning Disability)</label>
                    <input type="number" id="LD" name="LD" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="addictionCases" class="form-label">No. of cases benefitted for addiction</label>
                    <input type="number" id="addictionCases" name="addiction_cases" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="tobacco" class="form-label">Tobacco</label>
                    <input type="number" id="tobacco" name="tobacco" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="alcohol" class="form-label">Alcohol</label>
                    <input type="number" id="alcohol" name="alcohol" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="opioids" class="form-label">Opioids</label>
                    <input type="number" id="opioids" name="opioids" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="mobileAddiction" class="form-label">Mobile addiction</label>
                    <input type="number" id="mobileAddiction" name="mobile_addiction" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="addictionAnyOther" class="form-label">Any other addiction</label>
                    <input type="number" id="addictionAnyOther" name="addiction_any_other" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="referrals" class="form-label">No. of referrals from Teaching institutes</label>
                    <input type="number" id="referrals" name="referrals_from_teaching_institutes" class="form-control" required>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <button type="submit" class="btn btn-primary">Add Record</button>
              </div>
            </div>
          </div>
        </form>
      </div>



    </div>
  </div>
</section>

<?php include('dashboard-footer.php'); ?>