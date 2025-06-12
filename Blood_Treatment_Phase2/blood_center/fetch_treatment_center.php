<?php
require '../includes/db.php';

if (isset($_POST['district_id'])) {
    $district_id = intval($_POST['district_id']);

    // 1. Fetch treatment centers by district_id
    $stmt1 = $conn->prepare("SELECT id, center_name FROM treatment_centers WHERE district_id = ?");
    $stmt1->bind_param("i", $district_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    $centers = [];
    while ($row = $result1->fetch_assoc()) {
        $centers[] = $row;
    }

    // 2. Fetch district name from districts table
    $district_name = null;
    $stmt2 = $conn->prepare("SELECT name FROM districts WHERE id = ?");
    $stmt2->bind_param("i", $district_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($row = $result2->fetch_assoc()) {
        $district_name = $row['name'];
    }

    // 3. Send combined result
    echo json_encode([
        'status' => 'success',
        'data' => $centers,
        'district_name' => $district_name
    ]);
}
?>
