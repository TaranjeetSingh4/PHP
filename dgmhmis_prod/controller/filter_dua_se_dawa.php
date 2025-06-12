<?php
session_start(); 
require_once 'config.php';
header('Content-Type: application/json');


// Get district ID from session (user's assigned district)
$session_district_id = isset($_SESSION['district_id']) ? intval($_SESSION['district_id']) : 0;

$district_id = isset($_POST['district_id']) ? intval($_POST['district_id']) : 0;
$date = isset($_POST['camp_date']) ? $_POST['camp_date'] : '';

if ($district_id !== $session_district_id) {
     echo json_encode([]); // empty response if not allowed
    exit;
}

$conn = get_db_connection();

$where = "1=1";
if (!empty($district_id)) {
    $where .= " AND c.district_id = " . intval($district_id);
}
if (!empty($date)) {
    $where .= " AND DATE(c.created_at) = '" . mysqli_real_escape_string($conn, $date) . "'";
}

$sql = "SELECT c.*, d.district_name 
        FROM dua_se_dawa_tak c
        JOIN master_district d ON c.district_id = d.id
        WHERE $where
        ORDER BY c.id DESC";

$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['id'],
        'district_name' => $row['district_name'],
        'total_dawa_camps' => $row['total_dawa_camps'],
        'persons_screened' => $row['persons_screened'],
        'patients_referred_district_hospital' => $row['patients_referred_district_hospital'],
        'edit_link' => "edit_dua_se_dawa_tak.php?id=" . $row['id']
    ];
}

echo json_encode($data);
