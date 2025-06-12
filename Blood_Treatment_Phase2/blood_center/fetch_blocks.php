<?php
require '../includes/db.php';

if (isset($_POST['treatment_center_id'])) {
    $treatment_center_id = intval($_POST['treatment_center_id']);

    $stmt = $conn->prepare("SELECT id, block_name FROM blocks WHERE treatment_center_id = ?");
    $stmt->bind_param("i", $treatment_center_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        echo "<option value='{$row['id']}'>" . htmlspecialchars($row['block_name']) . "</option>";
    }
}
?>
