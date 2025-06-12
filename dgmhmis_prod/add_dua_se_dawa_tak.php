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
  $total_dawa_camps = (int)$_POST['total_dawa_camps'];
  $persons_screened = (int)$_POST['persons_screened'];
  $patients_referred_district_hospital = (int)$_POST['patients_referred_district_hospital'];
  

  $sql = "INSERT INTO dua_se_dawa_tak (
        district_id, total_dawa_camps, persons_screened, patients_referred_district_hospital
    ) VALUES (
        $district_id, $total_dawa_camps, $persons_screened, $patients_referred_district_hospital
    )";


  if (mysqli_query($conn, $sql)) {
    $success = true;
    header("Location: list_dua_se_dawa_tak.php");
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
      <a href="list_dua_se_dawa_tak.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
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

                  <div class="mb-3">
                    <label for="totalCamps" class="form-label">No. of Dua Se Dawa Tak Camp</label>
                    <input type="number" id="totalCamps" name="total_dawa_camps" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="personScreened" class="form-label">No.of person screened in Dua se Dawa Tak Camp</label>
                    <input type="number" id="personScreened" name="persons_screened" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label for="referredPatients" class="form-label">No. of patient refered to Distrct Hospital for further treatment</label>
                    <input type="number" id="referredPatients" name="patients_referred_district_hospital" class="form-control" required>
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