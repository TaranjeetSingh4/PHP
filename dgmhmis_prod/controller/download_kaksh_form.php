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
        $formattedDate = isset($_POST['kaksh_date']) && !empty($_POST['kaksh_date']) ? $_POST['kaksh_date'] : '';

        // Base query
        $query = "SELECT 
                m.district_name AS 'District Name',
                d.new_cases_man_kaksh AS 'No. of new cases in Man-Kaksh',
                d.followup_cases_man_kaksh AS 'No. of Follow up cases in Man-Kaksh',   
                d.total_cases AS 'Total (New + Follow up Cases)',
                d.common_mental_disorders AS 'Cases of Common Mental Disorders out of 1.1.3',   
                d.severe_mental_disorders AS 'Cases of Severe Mental Disorders out of 1.1.3',   
                d.family_therapy AS 'Cases of Family Therapy/ Marital Therapy',   
                d.crisis_help_cases AS 'No of cases reported for crisis help ',   
                d.suicide AS 'Suicide',   
                d.disaster AS 'Disaster',   

                d.any_other AS 'Any other (Specify)',   
                d.psychological_interventions AS 'No. of Psychological intervention done (Counselling/Psychotherapy)',   
                d.disability_certifications AS 'No. of Disability Certification Done',   
                d.IQ AS 'IQ',   
                d.ASD AS 'ASD (Autism Spectrum Disorder)',   
                d.LD AS 'LD (Learning Disability)',   
                d.addiction_cases AS 'No. of cases benefitted for addiction of Tobacco/Alcohol/opioids/any Drug abuse',   
                d.tobacco AS 'Tobacco',   
                d.alcohol AS 'Alcohol',   
                d.opioids AS 'Opiods',   
                d.mobile_addiction AS 'Mobile addiction',   
                d.addiction_any_other AS 'Addiction Any other',   
                d.referrals_from_teaching_institutes AS 'No. of referrals from Teaching institutes'

              FROM 
                district_counselling_center_man_kakash d
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

        $filename = "man_kaksh_data.csv";
        $columns1 = [
            "District Name",
            "No. of new cases in Man-Kaksh",
            "No. of Follow up cases in Man-Kaksh",
            "Total (New + Follow up Cases)",
            "Cases of Common Mental Disorders out of 1.1.3",
            "Cases of Severe Mental Disorders out of 1.1.3",
            "Cases of Family Therapy/ Marital Therapy",
            "No of cases reported for crisis help",
            "Suicide",
            "Disaster",
            "Any other (Specify)",
            "No. of Psychological intervention done (Counselling/Psychotherapy)",
            "No. of Disability Certification Done",
            "IQ",
            "ASD (Autism Spectrum Disorder)",
            "LD (Learning Disability)",
            "No. of cases benefitted for addiction of Tobacco/Alcohol/opioids/any Drug abuse",
            "Tobacco",
            "Alcohol",
            "Opiods",
            "Mobile addiction",
            "Addiction Any other",
            "No. of referrals from Teaching institutes"
        ];
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
