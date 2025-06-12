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
        SELECT id, name 
        FROM users 
        WHERE (blood_center_id = ? AND referred_blood_center IS NULL) 
           OR referred_blood_center = ?
    ");
    $stmt->bind_param("ii", $blood_center_id, $blood_center_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_list = $result->fetch_all(MYSQLI_ASSOC);
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and assign POST values
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $result = isset($_POST['test_result']) ? trim($_POST['test_result']) : '';
    $blood_center_id = isset($_POST['blood_center_id']) ? intval($_POST['blood_center_id']) : 0;

    if (empty($user_id) || empty($result) || empty($blood_center_id)) {
        $message = "All fields are required.";
    } else {
        // Check if the user_id already exists in user_test_results
        $check_stmt = $conn->prepare("SELECT id FROM user_test_results WHERE user_id = ?");
        $check_stmt->bind_param("i", $user_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Record exists, perform UPDATE
            $update_stmt = $conn->prepare("UPDATE user_test_results SET status = ?, blood_center_id = ? WHERE user_id = ?");
            $update_stmt->bind_param("sii", $result, $blood_center_id, $user_id);
            if ($update_stmt->execute()) {
                $message = "Test result updated successfully!";
            } else {
                $message = "Update failed: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            // Record does not exist, perform INSERT
            $insert_stmt = $conn->prepare("INSERT INTO user_test_results (user_id, status, blood_center_id) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("isi", $user_id, $result, $blood_center_id);
            if ($insert_stmt->execute()) {
                $message = "Test result saved successfully!";
            } else {
                $message = "Insert failed: " . $insert_stmt->error;
            }
            $insert_stmt->close();
        }

        $check_stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Donor Status Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../includes/dashboard_layout/header.php'); ?>

    <div class="ts-main-content">
        <?php include('../includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Update Donor Blood Test</h2>
                        <?php if (!empty($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="blood_center_name">Your Blood Center</label>
                                <input type="text" readonly class="form-control" value="<?= htmlspecialchars($blood_center['name'] ?? 'N/A') ?>">
                                <input type="hidden" name="blood_center_id" value="<?= $blood_center_id ?>">
                            </div>


                            <div class="mb-3">
                                <label for="user_id">User List</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Select User</option>
                                    <?php foreach ($user_list as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <div class="mb-3">
                                <label>Test Result</label>
                                <select name="test_result" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>

                            <button class="btn btn-primary">Submit Test</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>