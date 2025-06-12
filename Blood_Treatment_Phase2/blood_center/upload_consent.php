<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'blood_center') {
    header("Location: ../login.php");
    exit();
}

$blood_center_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $target_dir = "../uploads/consents/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["consent_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["consent_file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO consents (user_id, blood_center_id, file_path) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $user_id, $blood_center_id, $target_file);
        mysqli_stmt_execute($stmt);
        $message = "Consent form uploaded successfully!";
    } else {
        $message = "Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Consent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Upload Consent Form</h2>
    <?php if (!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>User ID</label>
            <input type="number" name="user_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Consent File (PDF/Image)</label>
            <input type="file" name="consent_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        <button class="btn btn-primary">Upload</button>
    </form>
</body>
</html>
