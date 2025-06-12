<?php
session_start(); 
require_once 'config.php';
header('Content-Type: application/json');

// Get district ID from session (user's assigned district)
$session_district_id = isset($_SESSION['district_id']) ? intval($_SESSION['district_id']) : 0;

$district_id = isset($_POST['district_id']) ? intval($_POST['district_id']) : 0;
$date = isset($_POST['chetna_date']) ? $_POST['chetna_date'] : '';

if ($district_id !== $session_district_id) {
     echo json_encode([]); // empty response if not allowed
    exit;
}

$conn = get_db_connection();

$where = "1=1";
if (!empty($district_id)) {
    $where .= " AND mc.district_id = " . intval($district_id);
}
if (!empty($date)) {
    $where .= " AND DATE(mc.created_at) = '" . mysqli_real_escape_string($conn, $date) . "'";
}

$sql = "SELECT mc.*, d.district_name 
        FROM man_chetna_diwas mc
        JOIN master_district d ON mc.district_id = d.id
        WHERE $where
        ORDER BY mc.id DESC";

$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['id'],
        'district_name' => $row['district_name'],
        'chc_phc_name' => $row['chc_phc_name'],
        'new_opd_patients' => $row['new_opd_patients'],
        'follow_up_cases_opd' => $row['follow_up_cases_opd'],
        'patients_counselled' => $row['patients_counselled'],
        'referred_to_dh' => $row['referred_to_dh'],
        'referred_back_from_dh' => $row['referred_back_from_dh'],
        'edit_link' => "edit_man_chetna_diwas.php?id=" . $row['id']
    ];
}

echo json_encode($data);
