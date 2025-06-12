<?php
session_start(); 
require_once 'config.php';
header('Content-Type: application/json');

// Get district ID from session (user's assigned district)
$session_district_id = isset($_SESSION['district_id']) ? intval($_SESSION['district_id']) : 0;

$district_id = isset($_POST['district_id']) ? intval($_POST['district_id']) : 0;
$date = isset($_POST['kaksh_date']) ? $_POST['kaksh_date'] : '';

if ($district_id !== $session_district_id) {
     echo json_encode([]); // empty response if not allowed
    exit;
}

$conn = get_db_connection();

$where = "1=1";
if (!empty($district_id)) {
    $where .= " AND dc.district_id = " . intval($district_id);
}

if (!empty($date)) {
    $where .= " AND DATE(dc.created_at) = '" . mysqli_real_escape_string($conn, $date) . "'";
}

$sql = "SELECT dc.*, d.district_name 
        FROM district_counselling_center_man_kakash dc
        JOIN master_district d ON dc.district_id = d.id
        WHERE $where
        ORDER BY dc.id DESC";

$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['id'],
        'district_name' => $row['district_name'],
        'new_cases_man_kaksh' => $row['new_cases_man_kaksh'],
        'followup_cases_man_kaksh' => $row['followup_cases_man_kaksh'],
        'total_cases' => $row['total_cases'],
        'common_mental_disorders' => $row['common_mental_disorders'],
        'severe_mental_disorders' => $row['severe_mental_disorders'],
        'family_therapy' => $row['family_therapy'],
        'crisis_help_cases' => $row['crisis_help_cases'],
        'suicide' => $row['suicide'],
        'disaster' => $row['disaster'],
        'any_other' => $row['any_other'],
        'psychological_interventions' => $row['psychological_interventions'],
        'disability_certifications' => $row['disability_certifications'],
        'IQ' => $row['IQ'],
        'ASD' => $row['ASD'],
        'LD' => $row['LD'],
        'addiction_cases' => $row['addiction_cases'],
        'tobacco' => $row['tobacco'],
        'alcohol' => $row['alcohol'],
        'opioids' => $row['opioids'],
        'mobile_addiction' => $row['mobile_addiction'],
        'addiction_any_other' => $row['addiction_any_other'],	
        'referrals_from_teaching_institutes' => $row['referrals_from_teaching_institutes'],
        'edit_link' => "edit_mankaksh.php?id=" . $row['id']
    ];
}

echo json_encode($data);
