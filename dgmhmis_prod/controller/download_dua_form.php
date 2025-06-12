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
        $formattedDate = isset($_POST['camp_date']) && !empty($_POST['camp_date']) ? $_POST['camp_date'] : '';

        // Base query
        $query = "SELECT 
                m.district_name AS 'District Name',
                d.total_dawa_camps AS 'No. of Dua Se Dawa Tak Camp',
                d.persons_screened AS 'No.of person screened in Dua se Dawa Tak Camp',   
                d.patients_referred_district_hospital AS 'No. of patient refered to Distrct Hospital for further treatment'
              FROM 
                dua_se_dawa_tak d
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

        $filename = "dua_se_dawa_tak_data.csv";
        $columns1 = ["District Name", "No. of Dua Se Dawa Tak Camp", "No.of person screened in Dua se Dawa Tak Camp", "No. of patient refered to Distrct Hospital for further treatment"];
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
