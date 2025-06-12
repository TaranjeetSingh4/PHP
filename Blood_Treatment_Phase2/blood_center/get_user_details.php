<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('blood_center');

header('Content-Type: application/json');

if (isset($_POST['user_id'])) {
    $id = intval($_POST['user_id']);

    $stmt = $conn->prepare("SELECT  email, age, gender, dob, blood_group, address, mobile_number FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result( $email, $age, $gender, $dob, $blood_group, $address, $mobile_number);

    if ($stmt->fetch()) {
        echo json_encode([
            'status' => 'success',
            'data' => [
               
                'email' => $email,
                'age' => $age,
                'gender' => $gender,
                'dob' => $dob,
                'blood_group' => $blood_group,
                'address' => $address,
                'mobile_number' => $mobile_number
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
