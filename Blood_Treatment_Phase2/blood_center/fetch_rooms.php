<?php
require '../includes/db.php';

if (isset($_POST['block_id'])) {
    $block_id = intval($_POST['block_id']);

    $stmt = $conn->prepare("SELECT id, room_name, doctor_name FROM rooms WHERE block_id = ?");
    $stmt->bind_param("i", $block_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['room_name']}</option>";
    }
}
?>
