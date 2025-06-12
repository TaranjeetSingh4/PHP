<?php
session_start(); 
require_once 'config.php';
header('Content-Type: application/json');

// Get district ID from session (user's assigned district)
$session_district_id = isset($_SESSION['district_id']) ? intval($_SESSION['district_id']) : 0;

$district_id = isset($_POST['district_id']) ? intval($_POST['district_id']) : 0;
$date = isset($_POST['dmhp_date']) ? $_POST['dmhp_date'] : '';

if ($district_id !== $session_district_id) {
     echo json_encode([]); // empty response if not allowed
    exit;
}


$conn = get_db_connection();

$where = "1=1";
if (!empty($district_id)) {
    $where .= " AND dh.district_id = " . intval($district_id);
}
if (!empty($date)) {
    $where .= " AND DATE(dh.created_at) = '" . mysqli_real_escape_string($conn, $date) . "'";
}

$sql = "SELECT dh.*, d.district_name 
        FROM dmhp_monthly_report dh
        JOIN master_district d ON dh.district_id = d.id
        WHERE $where
        ORDER BY dh.id DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['id'],
        'district_name' => $row['district_name'],
        'nodal_officer_name' => $row['nodal_officer_name'],
        'nodal_officer_mobile' => $row['nodal_officer_mobile'],
        'nodal_officer_email' => $row['nodal_officer_email'],
        'psychiatrist' => $row['psychiatrist'],
        'trained_mo_psychiatrist' => $row['trained_mo_psychiatrist'],
        'clinical_psychologist' => $row['clinical_psychologist'],
        'trained_psychologist' => $row['trained_psychologist'],
        'psychiatric_social_worker' => $row['psychiatric_social_worker'],
        'trained_social_worker' => $row['trained_social_worker'],
        'psychiatric_nurse' => $row['psychiatric_nurse'],
        'edit_link' => "edit_dmhp_monthly_report.php?id=" . $row['id']
    ];
}

echo json_encode($data);
