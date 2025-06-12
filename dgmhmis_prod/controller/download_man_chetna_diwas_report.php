<?php

require_once("config.php");
session_start();

if (isset($_SESSION['email'])) {
    $conn = get_db_connection();

    $session_district_id = isset($_SESSION['district_id']) ? intval($_SESSION['district_id']) : 0;
    $currentYear = date('Y');
    $currentMonth = date('m');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $district_id = isset($_POST['district_id']) && !empty($_POST['district_id']) ? $_POST['district_id'] : '';
        $formattedDate = isset($_POST['chetna_date']) && !empty($_POST['chetna_date']) ? $_POST['chetna_date'] : '';

        // Base query
        $query = "SELECT 
                m.district_name AS 'District Name',
                d.chc_phc_name AS 'Name Of CHC/PHC',
                d.new_opd_patients AS 'New OPD patients',   
                d.follow_up_cases_opd AS 'Follow up cases in OPD',
                d.patients_counselled AS 'No.of patient counselled',
                d.referred_to_dh AS 'Referred cases to DH',
                d.referred_back_from_dh AS 'Referred back from district hospital'
              FROM 
                man_chetna_diwas d
              JOIN 
                master_district m ON d.district_id = m.id
              WHERE 1=1";

        if (!empty($district_id)) {
            // If a district is selected in POST, ensure it matches session
            if ($district_id != $session_district_id) {
                $query .= " AND 0";
            } else {
                $query .= " AND d.district_id = " . intval($district_id);
            }
        } else {
            // Default to session district
            $query .= " AND d.district_id = " . $session_district_id;
        }

        if (!empty($formattedDate)) {
            $query .= " AND DATE(d.created_at) = '" . mysqli_real_escape_string($conn, $formattedDate) . "'";
        }

        $query .= " ORDER BY d.created_at DESC";

        $filename = "man_chetna_diwas_report.csv";
        $columns1 = ["District Name", "Name Of CHC/PHC", "New OPD patients", "Follow up cases in OPD", "No.of patient counselled", "Referred cases to DH", "Referred back from district hospital"];
    }


    // Set headers to download the file as a CSV
    $result = mysqli_query($conn, $query);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);

    $output = fopen('php://output', 'w');

    // Write CSV header
    fputcsv($output, $columns1);

    // Write CSV data
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
} else {
    header('location:../index.php');
}
