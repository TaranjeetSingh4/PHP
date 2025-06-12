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
        $formattedDate = isset($_POST['dmhp_date']) && !empty($_POST['dmhp_date']) ? $_POST['dmhp_date'] : '';

        // Base query
        $query = "SELECT 
                    m.district_name AS 'District Name',
                    d.nodal_officer_name AS 'Nodal Officer Name',
                    d.nodal_officer_mobile AS 'Nodal Officer Mobile',
                    d.nodal_officer_email AS 'Nodal Officer Email',

                    d.psychiatrist AS 'Psychiatrist',
                    d.trained_mo_psychiatrist AS 'Trained MO in Psychiatry',
                    d.clinical_psychologist AS 'Clinical Psychologist',
                    d.trained_psychologist AS 'Trained Psychologist',
                    d.psychiatric_social_worker AS 'Psychiatric Social Worker',
                    d.trained_social_worker AS 'Trained Social Worker',
                    d.psychiatric_nurse AS 'Psychiatric Nurse',
                    d.trained_nurse AS 'Trained Nurse',
                    d.community_nurse AS 'Community Nurse',
                    d.monitoring_evaluation_officer AS 'Monitoring & Evaluation Officer',
                    d.case_registry_assistant AS 'Case Registry Assistant',
                    d.ward_assistant_orderly AS 'Ward Assistant/Orderly',

                    d.mo_under_dmhp AS 'MO under DMHP',
                    d.community_level_psychologist AS 'Community Level Psychologist',
                    d.community_psych_social_worker AS 'Community Psych. Social Worker',
                    d.community_health_worker AS 'Community Health Worker',
                    d.dh_mo_trained_mental_health AS 'DH MO Trained in Mental Health',
                    d.psychologist AS 'Psychologist',
                    d.social_worker_counselor AS 'Social Worker/Counselor',
                    d.nurses AS 'Nurses',
                    d.chc_phc_mo_trained AS 'CHC/PHC MO Trained in Mental Health',
                    d.pharmacists AS 'Pharmacists',
                    d.anms AS 'ANMs',
                    d.ashas_community_workers AS 'ASHAs/Community Workers',
                    d.others_specify AS 'Others (Specify)',
                    d.other_stakeholders AS 'Other Stakeholders',
                    d.panchayat_leaders AS 'Panchayat Leaders',
                    d.community_members AS 'Community Members',

                    d.opd_new_patients AS 'New OPD Patients',
                    d.opd_followup_cases AS 'Follow-up OPD Cases',
                    d.opd_referred_tertiary AS 'OPD Referred to Tertiary Hospital',
                    d.opd_patients_counselled AS 'OPD Patients Counselled',
                    d.opd_total_cases AS 'Total OPD Cases',

                    d.depression AS 'Depression',
                    d.anxiety_panic_disorders AS 'Anxiety/Panic Disorders',
                    d.somatisation_disorders AS 'Somatisation Disorders',
                    d.child_mental_disorders AS 'Child Mental Disorders',
                    d.neurological_conditions AS 'Neurological Conditions',
                    d.epilepsy AS 'Epilepsy',
                    d.dementia AS 'Dementia',
                    d.substance_use_disorders AS 'Substance Use Disorders',
                    d.suicidal_risk_cases AS 'Suicidal Risk Cases',

                    d.new_opd_patients AS 'New OPD Patients (CHC)',
                    d.followup_opd_cases AS 'Follow-up OPD Cases (CHC)',
                    d.opd_patient_counselled AS 'OPD Patients Counselled (CHC)',
                    d.referred_cases_dh AS 'Cases Referred to DH (CHC)',
                    d.referred_back_from_dh AS 'Cases Referred Back from DH (CHC)',

                    d.phc_new_opd_patients AS 'New OPD Patients (PHC)',
                    d.phc_follow_up_opd_cases AS 'Follow-up Cases in OPD (PHC)',
                    d.phc_patient_counselled AS 'Patients Counselled (PHC)',
                    d.phc_referred_to_dh AS 'Cases Referred to DH (PHC)',
                    d.phc_referred_back_from_dh AS 'Cases Referred Back from District Hospital (PHC)',


                    d.inpatient_services AS 'Inpatient Services Available',
                    d.psychiatric_beds AS 'No. of Psychiatric Beds',
                    d.ipd_admissions AS 'IPD Admissions',
                    d.avg_stay_days AS 'Average Stay (Days)',
                    d.community_care_linkage AS 'Community-based Care Linkage',

                    d.day_care_centers AS 'Day Care Centers',
                    d.residential_care_center_6_months AS 'Residential Care (≤ 6 months)',
                    d.residential_care_center_long_term AS 'Residential Care (> 6 months)',
                    d.day_care_patients AS 'Patients in Day Care',
                    d.residential_care_patients AS 'Patients in Residential Care (Short-term)',
                    d.long_term_care_patients AS 'Patients in Long-term Care',

                    d.drug_antidepressant_available AS 'Antidepressant Available',
                    d.drug_antipsychotic_available AS 'Antipsychotic Available',
                    d.drug_anticonvulsant_available AS 'Anticonvulsant Available',
                    d.drug_anxiolytic_available AS 'Anxiolytic Available',

                    d.state_antidepressant AS 'State Supply: Antidepressant',
                    d.state_antipsychotic AS 'State Supply: Antipsychotic',
                    d.state_anticonvulsant AS 'State Supply: Anticonvulsant',
                    d.state_anxiolytic AS 'State Supply: Anxiolytic',
                    d.drug_source AS 'Other Drug Source',

                    d.tv_broadcasts AS 'TV Broadcasts',
                    d.community_radio_messages AS 'Community Radio Messages',
                    d.mental_health_films AS 'Mental Health Films',
                    d.newspaper_ads AS 'Newspaper Advertisements',
                    d.hoardings AS 'Hoardings',
                    d.bus_panels AS 'Bus Panels',
                    d.exhibitions AS 'Exhibitions',
                    d.wall_paintings AS 'Wall Paintings',
                    d.street_plays AS 'Street Plays',
                    d.puppet_shows AS 'Puppet Shows',
                    d.dance_song_shows AS 'Dance & Song Shows',
                    d.community_meetings AS 'Community Meetings',
                    d.patient_family_meetings AS 'Patient & Family Meetings',
                    d.haat_sessions AS 'Haat Bazaar Sessions',
                    d.other_specified_activities AS 'Other Specified Activities',
                    d.others AS 'Other Activities',

                    d.district_counselling_centers AS 'District Counselling Centers',
                    d.helpline_established AS 'Helpline Established',
                    d.school_counselling_sessions AS 'School Counselling Sessions',
                    d.students_counselled_schools AS 'Students Counselled (Schools)',
                    d.teachers_life_skills_schools AS 'Teachers Trained (Schools)',
                    d.college_counselling_sessions AS 'College Counselling Sessions',
                    d.teachers_life_skills_college AS 'Teachers Trained (Colleges)',
                    d.students_counselled_college AS 'Students Counselled (Colleges)',
                    d.suicide_prevention_camps AS 'Suicide Prevention Camps',
                    d.people_attended_suicide_prevention AS 'People Attended Suicide Prevention Camps',
                    d.stress_management_sessions AS 'Stress Management Sessions',
                    d.stress_session_attendees AS 'Attendees in Stress Sessions',

                    d.home_visits AS 'Home Visits',
                    d.family_members_counselled AS 'Family Members Counselled',
                    d.neighbours_counselled AS 'Neighbours Counselled',

                    d.jail_visits AS 'Jail Visits',
                    d.jail_inmates_counselled AS 'Jail Inmates Counselled',

                    d.old_age_home_visits AS 'Old Age Home Visits',
                    d.old_age_individuals_counselled AS 'Old Age Individuals Counselled',

                    d.child_care_institution_visits AS 'Child Care Institution Visits',
                    d.children_counselled_institutions AS 'Children Counselled (Institutions)',

                    d.service_approach AS 'Service Delivery Approach',
                    d.outreach_visits AS 'Outreach Visits',
                    d.outreach_cases_examined AS 'Outreach Cases Examined',
                    d.outreach_referred_district AS 'Referred to District Hospital',
                    d.outreach_referred_rehabilitation AS 'Referred to Rehabilitation Center',

                    d.helpline_available AS 'Is Helpline Available',
                    d.helpline_contact AS 'Helpline Contact Number',
                    d.helpline_calls AS 'Helpline Calls Received',

                    d.ngos_engaged AS 'NGOs Engaged',
                    d.panchayati_raj_engaged AS 'Panchayati Raj Engaged',
                    d.user_family_groups AS 'User/Family Groups Formed',
                    d.suicide_attempt_reports AS 'Suicide Attempt Reports',

                    d.budget_received AS 'Budget Received',
                    d.opening_balance AS 'Opening Balance',
                    d.total_funds_available AS 'Total Funds Available',
                    d.expenditure_incurred AS 'Expenditure Incurred',
                    d.balance AS 'Balance'

              FROM 
                dmhp_monthly_report d
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

        $filename = "dmhp_monthly_report_data.csv";
        $columns1 = [
            "District Name",
            "Nodal Officer Name",
            "Nodal Officer Mobile",
            "Nodal Officer Email",

            "Psychiatrist",
            "Trained MO in Psychiatry",
            "Clinical Psychologist",
            "Trained Psychologist",
            "Psychiatric Social Worker",
            "Trained Social Worker",
            "Psychiatric Nurse",
            "Trained Nurse",
            "Community Nurse",
            "Monitoring & Evaluation Officer",
            "Case Registry Assistant",
            "Ward Assistant/Orderly",

            "MO under DMHP",
            "Community Level Psychologist",
            "Community Psych. Social Worker",
            "Community Health Worker",
            "DH MO Trained in Mental Health",
            "Psychologist",
            "Social Worker/Counselor",
            "Nurses",
            "CHC/PHC MO Trained in Mental Health",
            "Pharmacists",
            "ANMs",
            "ASHAs/Community Workers",
            "Others (Specify)",
            "Other Stakeholders",
            "Panchayat Leaders",
            "Community Members",

            "New OPD Patients",
            "Follow-up OPD Cases",
            "OPD Referred to Tertiary Hospital",
            "OPD Patients Counselled",
            "Total OPD Cases",

            "Depression",
            "Anxiety/Panic Disorders",
            "Somatisation Disorders",
            "Child Mental Disorders",
            "Neurological Conditions",
            "Epilepsy",
            "Dementia",
            "Substance Use Disorders",
            "Suicidal Risk Cases",

            "New OPD Patients (CHC)",
            "Follow-up OPD Cases (CHC)",
            "OPD Patients Counselled (CHC)",
            "Cases Referred to DH (CHC)",
            "Cases Referred Back from DH (CHC)",

            "New OPD Patients (PHC)",
            "Follow-up Cases in OPD (PHC)",
            "Patients Counselled (PHC)",
            "Cases Referred to DH (PHC)",
            "Cases Referred Back from District Hospital (PHC)",

            "Inpatient Services Available",
            "No. of Psychiatric Beds",
            "IPD Admissions",
            "Average Stay (Days)",
            "Community-based Care Linkage",

            "Day Care Centers",
            "Residential Care (≤ 6 months)",
            "Residential Care (> 6 months)",
            "Patients in Day Care",
            "Patients in Residential Care (Short-term)",
            "Patients in Long-term Care",

            "Antidepressant Available",
            "Antipsychotic Available",
            "Anticonvulsant Available",
            "Anxiolytic Available",

            "State Supply: Antidepressant",
            "State Supply: Antipsychotic",
            "State Supply: Anticonvulsant",
            "State Supply: Anxiolytic",
            "Other Drug Source",

            "TV Broadcasts",
            "Community Radio Messages",
            "Mental Health Films",
            "Newspaper Advertisements",
            "Hoardings",
            "Bus Panels",
            "Exhibitions",
            "Wall Paintings",
            "Street Plays",
            "Puppet Shows",
            "Dance & Song Shows",
            "Community Meetings",
            "Patient & Family Meetings",
            "Haat Bazaar Sessions",
            "Other Specified Activities",
            "Other Activities",

            "District Counselling Centers",
            "Helpline Established",
            "School Counselling Sessions",
            "Students Counselled (Schools)",
            "Teachers Trained (Schools)",
            "College Counselling Sessions",
            "Teachers Trained (Colleges)",
            "Students Counselled (Colleges)",
            "Suicide Prevention Camps",
            "People Attended Suicide Prevention Camps",
            "Stress Management Sessions",
            "Attendees in Stress Sessions",

            "Home Visits",
            "Family Members Counselled",
            "Neighbours Counselled",

            "Jail Visits",
            "Jail Inmates Counselled",

            "Old Age Home Visits",
            "Old Age Individuals Counselled",

            "Child Care Institution Visits",
            "Children Counselled (Institutions)",

            "Service Delivery Approach",
            "Outreach Visits",
            "Outreach Cases Examined",
            "Referred to District Hospital",
            "Referred to Rehabilitation Center",

            "Is Helpline Available",
            "Helpline Contact Number",
            "Helpline Calls Received",

            "NGOs Engaged",
            "Panchayati Raj Engaged",
            "User/Family Groups Formed",
            "Suicide Attempt Reports",

            "Budget Received",
            "Opening Balance",
            "Total Funds Available",
            "Expenditure Incurred",
            "Balance"
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
