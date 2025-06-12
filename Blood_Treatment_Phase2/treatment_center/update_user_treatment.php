<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('treatment_center');

$staff_id = $_SESSION['user_id'];
// Get staff name
$stmt = $conn->prepare("SELECT name FROM staff WHERE id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$staff = $stmt->get_result()->fetch_assoc();
$staff_name = $staff['name'] ?? null;

// Get treatment_center_id
$treatment_center = null;
$treatment_center_id = null;

if ($staff_name) {
    $stmt = $conn->prepare("SELECT id FROM treatment_centers WHERE center_name = ?");
    $stmt->bind_param("s", $staff_name);
    $stmt->execute();
    $treatment_center = $stmt->get_result()->fetch_assoc();
    $treatment_center_id = $treatment_center['id'] ?? null;
}

$message = '';
$treatments = [];

// Update status logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'] ?? null;

    if ($action === 'start') {
        $stmt = $conn->prepare("UPDATE treatments SET status = 'Started', started_at = NOW() WHERE user_id = ? AND treatment_center_id = ?");
        $stmt->bind_param("ii", $user_id, $treatment_center_id);
        $stmt->execute();
    }

}

// Fetch users from treatments table
if ($treatment_center_id) {
    $stmt = $conn->prepare("
        SELECT t.user_id, u.name, t.status
        FROM treatments t
        JOIN users u ON u.id = t.user_id
        WHERE t.treatment_center_id = ?
    ");
    $stmt->bind_param("i", $treatment_center_id);
    $stmt->execute();
    $treatments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update User Treatment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="../includes/css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="../includes/css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="../includes/css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="../includes/css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="../includes/css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="../includes/css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="../includes/css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="../includes/css/style.css">
</head>

<body>
    <?php include('../includes/dashboard_layout/header.php'); ?>

    <div class="ts-main-content">
        <?php include('../includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Update Donor's Treatment</h2>

                        <?= $message ?>

                        <form method="POST">
                            <div class="mb-3 col-5">
                                <label for="user_id" class="form-label">Select User</label>
                                <select class="form-select" name="user_id" id="user_id" required onchange="this.form.submit()">
                                    <option value="">-- Select User --</option>
                                    <?php foreach ($treatments as $t): ?>
                                        <option value="<?= $t['user_id'] ?>" <?= (isset($_POST['user_id']) && $_POST['user_id'] == $t['user_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($t['name']) ?> (Status: <?= $t['status'] ?? 'Not Started' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>

                        <?php
                            if (isset($_POST['user_id']) && $_POST['user_id'] !== ''):
                                $selected_user_id = $_POST['user_id'];
                                $selected = array_filter($treatments, fn($u) => $u['user_id'] == $selected_user_id);
                                $selected = reset($selected);

                                if ($selected): // <-- This opens the inner if block
                        ?>

                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= $selected_user_id ?>">

                                <?php if ($selected['status'] === 'Not Started'): ?>
                                    <input type="hidden" name="action" value="start">
                                    <button type="submit" class="btn btn-success">Initiate Treatment</button>

                                <?php elseif ($selected['status'] === 'Started'): ?>
                                    <div class="alert alert-info mt-3">
                                        Treatment for <strong><?= htmlspecialchars($selected['name']) ?></strong> is started, Thank you.
                                    </div>
                                <?php endif; ?>
                            </form>

                        <?php endif; 
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>