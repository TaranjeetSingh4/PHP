<?php
require '../includes/db.php'; // change this to your actual DB connection file

if (isset($_POST['room_id'])) {
    $room_id = intval($_POST['room_id']);
    $stmt = $conn->prepare("SELECT doctor_name, doctor_contact FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();

      $response = [
        'doctor_name' => 'N/A',
        'doctor_contact' => 'N/A',
        
    ];

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $response['doctor_name'] = $data['doctor_name'];
        $response['doctor_contact'] = $data['doctor_contact'];
    }



    echo json_encode($response);
}
?>
