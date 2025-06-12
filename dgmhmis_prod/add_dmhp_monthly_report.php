<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
include('dashboard-header.php')
?>
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'CMO Office') {
    header("Location: index.php");
    exit();
}

require_once './controller/config.php';
$conn = get_db_connection();

$district_id = $_SESSION['district_id'] ?? '';
$district_name = '';

if ($district_id) {
    $stmt = $conn->prepare("SELECT district_name FROM master_district WHERE id = ?");
    $stmt->bind_param('i', $district_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $district_name = $result->fetch_assoc()['district_name'] ?? 'Unknown District';
    $stmt->close();
} else {
    $district_name = 'District ID not found in session';
}

$success = false;
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [

        'nodal_officer_name',
        'nodal_officer_mobile',
        'nodal_officer_email',
        'psychiatrist',
        'trained_mo_psychiatrist',
        'clinical_psychologist',
        'trained_psychologist',
        'psychiatric_social_worker',
        'trained_social_worker',
        'psychiatric_nurse',
        'trained_nurse',
        'community_nurse',
        'monitoring_evaluation_officer',
        'case_registry_assistant',
        'ward_assistant_orderly',
        'mo_under_dmhp',
        'community_level_psychologist',
        'community_psych_social_worker',
        'community_health_worker',
        'dh_mo_trained_mental_health',
        'psychologist',
        'social_worker_counselor',
        'nurses',
        'chc_phc_mo_trained',
        'pharmacists',
        'anms',
        'ashas_community_workers',
        'others_specify',
        'other_stakeholders',
        'panchayat_leaders',
        'community_members',
        'opd_new_patients',
        'opd_followup_cases',
        'opd_referred_tertiary',
        'opd_patients_counselled',
        'opd_total_cases',
        'common_mentaldisorder_out_of_total_opd',
        'depression',
        'anxiety_panic_disorders',
        'somatisation_disorders',
        'severe_mental_disorders_total_opd_cases',
        'schizophrenia',
        'bipolar_disorder',
        'severe_depression',
        'child_mental_disorders',
        'neurological_conditions',
        'epilepsy',
        'dementia',
        'substance_use_disorders',
        'suicidal_risk_cases',
        'new_opd_patients',
        'followup_opd_cases',
        'opd_patient_counselled',
        'referred_cases_dh',
        'referred_back_from_dh',
        'phc_new_opd_patients',
        'phc_follow_up_opd_cases',
        'phc_patient_counselled',
        'phc_referred_to_dh',
        'phc_referred_back_from_dh',
        'inpatient_services',
        'psychiatric_beds',
        'ipd_admissions',
        'avg_stay_days',
        'community_care_linkage',
        'day_care_centers',
        'residential_care_center_6_months',
        'residential_care_center_long_term',
        'day_care_patients',
        'residential_care_patients',
        'long_term_care_patients',
        'drug_antidepressant_available',
        'drug_antipsychotic_available',
        'drug_anticonvulsant_available',
        'drug_anxiolytic_available',
        'state_antidepressant',
        'state_antipsychotic',
        'state_anticonvulsant',
        'state_anxiolytic',
        'drug_source',
        'tv_broadcasts',
        'community_radio_messages',
        'mental_health_films',
        'newspaper_ads',
        'hoardings',
        'bus_panels',
        'exhibitions',
        'wall_paintings',
        'street_plays',
        'puppet_shows',
        'dance_song_shows',
        'community_meetings',
        'patient_family_meetings',
        'haat_sessions',
        'other_specified_activities',
        'others',
        'district_counselling_centers',
        'helpline_established',
        'school_counselling_sessions',
        'students_counselled_schools',
        'teachers_life_skills_schools',
        'college_counselling_sessions',
        'teachers_life_skills_college',
        'students_counselled_college',
        'suicide_prevention_camps',
        'people_attended_suicide_prevention',
        'stress_management_sessions',
        'stress_session_attendees',
        'home_visits',
        'family_members_counselled',
        'neighbours_counselled',
        'jail_visits',
        'jail_inmates_counselled',
        'old_age_home_visits',
        'old_age_individuals_counselled',
        'child_care_institution_visits',
        'children_counselled_institutions',
        'service_approach',
        'outreach_visits',
        'outreach_cases_examined',
        'outreach_referred_district',
        'outreach_referred_rehabilitation',
        'helpline_available',
        'helpline_contact',
        'helpline_calls',
        'ngos_engaged',
        'panchayati_raj_engaged',
        'user_family_groups',
        'suicide_attempt_reports',
        'budget_received',
        'opening_balance',
        'total_funds_available',
        'expenditure_incurred',
        'balance'


    ];

    $placeholders = implode(', ', array_fill(0, count($fields), '?'));
    $columns = implode(', ', $fields);

    $types = str_repeat('s', count($fields));
    $values = array_map(fn($field) => trim($_POST[$field] ?? ''), $fields);

    $query = "INSERT INTO dmhp_monthly_report (district_id, $columns) VALUES (?, $placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i' . $types, $district_id, ...$values);

    if ($stmt->execute()) {
        $success = true;
        echo "<p>Record saved successfully.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>




<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
            <h2 class="text-center">Add New Record</h2>
            <a href="list_dmhp_monthly_report.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Go Back</a>
            <div class="d-flex justify-content-center align-items-center vh-100">
                <?php if ($success): ?>
                    <div class="alert alert-success col-md-4">
                        Your data has been saved successfully.
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form class="p-4 border rounded bg-light container" method="post">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="districtName" class="form-label">District Name</label>
                                        <input type="text" id="districtName" class="form-control" value="<?= htmlspecialchars($district_name) ?>" readonly required>
                                        <input type="hidden" name="district_id" value="<?= $district_id ?>">
                                    </div>

                                    <h4>NAME OF DISTRICT</h4>
                                    <div class="mb-3">
                                        <label for="nodal_officer_name" class="form-label">Name of the Nodal Officer, DMHP</label>
                                        <input type="text" id="nodal_officer_name" name="nodal_officer_name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nodal_officer_mobile" class="form-label">Mobile Number</label>
                                        <input type="text" id="nodal_officer_mobile" name="nodal_officer_mobile"
                                            class="form-control" maxlength="10" pattern="\d{10}" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            title="Please enter exactly 10 digits">
                                    </div>

                                    <div class="mb-3">
                                        <label for="nodal_officer_email" class="form-label">Email ID</label>
                                        <input type="email" id="nodal_officer_email" name="nodal_officer_email" class="form-control" required>
                                    </div>

                                    <h4>Status of Availability of Mental Health Professionals under DMHP Designation/ Position</h4>
                                    <h5>At District level</h5>
                                    <div class="mb-3">
                                        <label for="psychiatrist" class="form-label">Psychiatrist</label>
                                        <input type="number" id="psychiatrist" name="psychiatrist" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="trained_mo_psychiatrist" class="form-label">Trained MO working as Psychiatrist</label>
                                        <input type="number" id="trained_mo_psychiatrist" name="trained_mo_psychiatrist" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="clinical_psychologist" class="form-label">Clinical Psychologist</label>
                                        <input type="number" id="clinical_psychologist" name="clinical_psychologist" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="trained_psychologist" class="form-label">Trained Psychologist</label>
                                        <input type="number" id="trained_psychologist" name="trained_psychologist" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="psychiatric_social_worker" class="form-label">Psychiatric Social Worker</label>
                                        <input type="number" id="psychiatric_social_worker" name="psychiatric_social_worker" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="trained_social_worker" class="form-label">Trained Social Worker</label>
                                        <input type="number" id="trained_social_worker" name="trained_social_worker" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="psychiatric_nurse" class="form-label">Psychiatric Nurse</label>
                                        <input type="number" id="psychiatric_nurse" name="psychiatric_nurse" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="trained_nurse" class="form-label">Trained Nurse (Working as Psychiatric Nurse)</label>
                                        <input type="number" id="trained_nurse" name="trained_nurse" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="community_nurse" class="form-label">Community Nurse</label>
                                        <input type="number" id="community_nurse" name="community_nurse" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="monitoring_evaluation_officer" class="form-label">Monitoring & Evaluation Officer</label>
                                        <input type="number" id="monitoring_evaluation_officer" name="monitoring_evaluation_officer" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="case_registry_assistant" class="form-label">Case Registry Assistant</label>
                                        <input type="number" id="case_registry_assistant" name="case_registry_assistant" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ward_assistant_orderly" class="form-label">Ward Assistant/Orderly</label>
                                        <input type="number" id="ward_assistant_orderly" name="ward_assistant_orderly" class="form-control" required>
                                    </div>

                                    <h5>At CHC/Taluk level</h5>

                                    <div class="mb-3">
                                        <label for="mo_under_dmhp" class="form-label">Medical Officer under DMHP</label>
                                        <input type="number" id="mo_under_dmhp" name="mo_under_dmhp" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="community_level_psychologist" class="form-label">Clinical Psychologist/Community Level Psychologist</label>
                                        <input type="number" id="community_level_psychologist" name="community_level_psychologist" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="community_psych_social_worker" class="form-label">Psychiatric Social Worker</label>
                                        <input type="number" id="community_psych_social_worker" name="community_psych_social_worker" class="form-control" required>
                                    </div>

                                    <h5>At PHC level</h5>

                                    <div class="mb-3">
                                        <label for="community_health_worker" class="form-label">Community Health Worker</label>
                                        <input type="number" id="community_health_worker" name="community_health_worker" class="form-control" required>
                                    </div>

                                    <h5>Trainings</h5>

                                    <div class="mb-3">
                                        <label for="dh_mo_trained_mental_health" class="form-label">Medical Officer posted at District Hospital trained in Mental Health</label>
                                        <input type="number" id="dh_mo_trained_mental_health" name="dh_mo_trained_mental_health" class="form-control" required>
                                    </div>



                                    <div class="mb-3">
                                        <label for="psychologist" class="form-label">Psychologist</label>
                                        <input type="number" id="psychologist" name="psychologist" class="form-control" required>
                                    </div>



                                    <div class="mb-3">
                                        <label for="social_worker_counselor" class="form-label">Social worker/ Counselor</label>
                                        <input type="number" id="social_worker_counselor" name="social_worker_counselor" class="form-control" required>
                                    </div>




                                    <div class="mb-3">
                                        <label for="nurses" class="form-label">Nurses</label>
                                        <input type="number" id="nurses" name="nurses" class="form-control" required>
                                    </div>



                                    <div class="mb-3">
                                        <label for="chc_phc_mo_trained" class="form-label">Medical Officer of CHC and PHC (30 per batch)</label>
                                        <input type="number" id="chc_phc_mo_trained" name="chc_phc_mo_trained" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="pharmacists" class="form-label">Pharmacists</label>
                                        <input type="number" id="pharmacists" name="pharmacists" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="anms" class="form-label">ANMs</label>
                                        <input type="number" id="anms" name="anms" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="ashas_community_workers" class="form-label">ASHAs/Community Health Worker</label>
                                        <input type="number" id="ashas_community_workers" name="ashas_community_workers" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="others_specify" class="form-label">Others; if any, please specify</label>
                                        <input type="number" id="others_specify" name="others_specify" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="other_stakeholders" class="form-label">Other stakeholder of the community</label>
                                        <input type="number" id="other_stakeholders" name="other_stakeholders" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="panchayat_leaders" class="form-label">Panchayat Leaders</label>
                                        <input type="number" id="panchayat_leaders" name="panchayat_leaders" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="community_members" class="form-label">Community Members</label>
                                        <input type="number" id="community_members" name="community_members" class="form-control" required>
                                    </div>

                                    <h4>Service Delivery</h4>
                                    <h5>Service delivery at DH/SDH/Equivalent level</h5>

                                    <div class="mb-3">
                                        <label for="opd_new_patients" class="form-label">Total no. of new patients seen in the OPD in the reported month</label>
                                        <input type="number" id="opd_new_patients" name="opd_new_patients" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="opd_followup_cases" class="form-label">Total no. of follow up cases seen in OPD in the reported month</label>
                                        <input type="number" id="opd_followup_cases" name="opd_followup_cases" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="opd_referred_tertiary" class="form-label">Total no. of cases Referred to tertiary hospital in the reported month</label>
                                        <input type="number" id="opd_referred_tertiary" name="opd_referred_tertiary" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="opd_patients_counselled" class="form-label">Total no. of patients counseled</label>
                                        <input type="number" id="opd_patients_counselled" name="opd_patients_counselled" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="opd_total_cases" class="form-label">Total OPD cases (New Patients + Follow Up Patients)</label>
                                        <input type="number" id="opd_total_cases" name="opd_total_cases" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="common_mentaldisorder_out_of_total_opd" class="form-label">Cases of Common Mental Disorders out of Total OPD Cases</label>
                                        <input type="number" id="common_mentaldisorder_out_of_total_opd" name="common_mentaldisorder_out_of_total_opd" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="depression" class="form-label">Depression</label>
                                        <input type="number" id="depression" name="depression" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="anxiety_panic_disorders" class="form-label">Anxiety / Panic Disorders</label>
                                        <input type="number" id="anxiety_panic_disorders" name="anxiety_panic_disorders" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="somatisation_disorders" class="form-label">Somatisation/Psychosomatic Disorders</label>
                                        <input type="number" id="somatisation_disorders" name="somatisation_disorders" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="severe_mental_disorders_total_opd_cases" class="form-label">Cases of Severe Mental Disorders out of Total OPD Cases</label>
                                        <input type="number" id="severe_mental_disorders_total_opd_cases" name="severe_mental_disorders_total_opd_cases" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="schizophrenia" class="form-label">Schizophrenia</label>
                                        <input type="number" id="schizophrenia" name="schizophrenia" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bipolar_disorder" class="form-label">Bipolar Disorder</label>
                                        <input type="number" id="bipolar_disorder" name="bipolar_disorder" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="severe_depression" class="form-label">Severe Depression</label>
                                        <input type="number" id="severe_depression" name="severe_depression" class="form-control" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="child_mental_disorders" class="form-label">Child and Adolescent Mental Health Disorders (C&AMHDs)</label>
                                        <input type="number" id="child_mental_disorders" name="child_mental_disorders" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="neurological_conditions" class="form-label">Neurological Conditions: Epilepsy and Dementia (including Alzheimer’s)</label>
                                        <input type="number" id="neurological_conditions" name="neurological_conditions" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="epilepsy" class="form-label">Epilepsy</label>
                                        <input type="number" id="epilepsy" name="epilepsy" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dementia" class="form-label">Dementia (including Alzheimer’s)</label>
                                        <input type="number" id="dementia" name="dementia" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="substance_use_disorders" class="form-label">Substance Use Disorder (SUDs): Tobacco, Alcohol and Drug Use Disorders</label>
                                        <input type="number" id="substance_use_disorders" name="substance_use_disorders" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="suicidal_risk_cases" class="form-label">Cases with Suicidal Risk out of Total OPD Cases (Suicide Ideation/Behaviours)</label>
                                        <input type="number" id="suicidal_risk_cases" name="suicidal_risk_cases" class="form-control" required>
                                    </div>


                                    <h4>Service delivery at CHC/Taluka/Equivalent level</h4>

                                    <div class="mb-3">
                                        <label for="new_opd_patients" class="form-label">New OPD Patients</label>
                                        <input type="number" id="new_opd_patients" name="new_opd_patients" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="followup_opd_cases" class="form-label">Follow-up OPD Cases</label>
                                        <input type="number" id="followup_opd_cases" name="followup_opd_cases" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="opd_patient_counselled" class="form-label">No.of patient counselled</label>
                                        <input type="number" id="opd_patient_counselled" name="opd_patient_counselled" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="referred_cases_dh" class="form-label">Referred cases to DH</label>
                                        <input type="number" id="referred_cases_dh" name="referred_cases_dh" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="referred_back_from_dh" class="form-label">Referred back from district hospital</label>
                                        <input type="number" id="referred_back_from_dh" name="referred_back_from_dh" class="form-control" required>
                                    </div>

                                    <h4 class="mt-4">Service Delivery at PHC/Equivalent Level</h4>

                                    <div class="mb-3">
                                        <label for="phc_new_opd_patients" class="form-label">New OPD patients</label>
                                        <input type="number" id="phc_new_opd_patients" name="phc_new_opd_patients" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phc_follow_up_opd_cases" class="form-label">Follow up cases in OPD</label>
                                        <input type="number" id="phc_follow_up_opd_cases" name="phc_follow_up_opd_cases" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phc_patient_counselled" class="form-label">No. of patient counselled</label>
                                        <input type="number" id="phc_patient_counselled" name="phc_patient_counselled" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phc_referred_to_dh" class="form-label">Referred cases to DH</label>
                                        <input type="number" id="phc_referred_to_dh" name="phc_referred_to_dh" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phc_referred_back_from_dh" class="form-label">Referred back from district hospital</label>
                                        <input type="number" id="phc_referred_back_from_dh" name="phc_referred_back_from_dh" class="form-control" required>
                                    </div>


                                    <h4>Mental Health Service - In Patient Department (IPD) at district hospital/equivalent level</h4>
                                    <!-- Inpatient Services -->
                                    <div class="mb-3">
                                        <label for="inpatient_services" class="form-label">Availability of In-patient services (Yes/No)</label>
                                        <select id="inpatient_services" name="inpatient_services" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="psychiatric_beds" class="form-label">Number of dedicated beds available for psychiatric patients</label>
                                        <input type="number" id="psychiatric_beds" name="psychiatric_beds" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ipd_admissions" class="form-label">Total No. of patients admitted in IPD during this month</label>
                                        <input type="number" id="ipd_admissions" name="ipd_admissions" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="avg_stay_days" class="form-label">Average Duration of Stay</label>
                                        <input type="number" id="avg_stay_days" name="avg_stay_days" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="community_care_linkage" class="form-label">Are there any linkage between DMHP and other institution to provide discarged patients with continuing community care (Yes/NO)</label>
                                        <select id="community_care_linkage" name="community_care_linkage" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <h4>Mental Health Services - After treatment continuing care at District Level</h4>

                                    <!-- Care Centers -->
                                    <div class="mb-3">
                                        <label for="day_care_centers" class="form-label">No. of Day Care Centres available/ set up in the district</label>
                                        <input type="number" id="day_care_centers" name="day_care_centers" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="residential_care_center_6_months" class="form-label">No. of Residential Continuing Care Centre (stay upto 6 months) in the district</label>
                                        <input type="number" id="residential_care_center_6_months" name="residential_care_center_6_months" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="residential_care_center_long_term" class="form-label">No. of Long term Residential Continuing Care Centre (long stay) in the district</label>
                                        <input type="number" id="residential_care_center_long_term" name="residential_care_center_long_term" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="day_care_patients" class="form-label">Total No. of patients availed services at Day Care Centres</label>
                                        <input type="number" id="day_care_patients" name="day_care_patients" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="residential_care_patients" class="form-label">Total No. of patients availed services at Residential Continuing Care Centre</label>
                                        <input type="number" id="residential_care_patients" name="residential_care_patients" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="long_term_care_patients" class="form-label">Total No. of patients availed services at Long Term Residential Continuing Care Centre</label>
                                        <input type="number" id="long_term_care_patients" name="long_term_care_patients" class="form-control" required>
                                    </div>

                                    <h4>Availability and Dispensing of Essential Psyhcotropic Drugs at DH/Equivalent Level {Hint to fill the responses: (A = Regularly available, B= Irregularly available and NA = Not Available)}</h4>
                                    <div class="mb-3">
                                        <label for="drug_antidepressant_available" class="form-label">Antidepressant</label>
                                        <select class="form-control" id="drug_antidepressant_available" name="drug_antidepressant_available" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="drug_antipsychotic_available" class="form-label">Antipsychotic</label>
                                        <select class="form-control" id="drug_antipsychotic_available" name="drug_antipsychotic_available" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="drug_anticonvulsant_available" class="form-label">Anticonvulsant</label>
                                        <select class="form-control" id="drug_anticonvulsant_available" name="drug_anticonvulsant_available" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="drug_anxiolytic_available" class="form-label">Anxiolytic</label>
                                        <select class="form-control" id="drug_anxiolytic_available" name="drug_anxiolytic_available" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>


                                    <h4>Availability and Dispensing of Essential Psyhcotropic Drugs at PHC and CHC Level {Hint to fill the responses: (A = Regularly available, B= Irregularly available and NA = Not Available)}</h4>

                                    <div class="mb-3">
                                        <label for="stateAntidepressant" class="form-label">Antidepressant</label>
                                        <select id="stateAntidepressant" name="state_antidepressant" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stateAntipsychotic" class="form-label">Antipsychotic</label>
                                        <select id="stateAntipsychotic" name="state_antipsychotic" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stateAnticonvulsant" class="form-label">Anticonvulsant</label>
                                        <select id="stateAnticonvulsant" name="state_anticonvulsant" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stateAnxiolytic" class="form-label">Anxiolytic/ hypnotic</label>
                                        <select id="stateAnxiolytic" name="state_anxiolytic" class="form-control" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="drugSource" class="form-label">Source of Essential Drugs - State Govt./DMHP fund/Others (mark whichever is applicable)</label>
                                        <select id="drugSource" name="drug_source" class="form-control" required>
                                            <option value="">-- Select Source --</option>
                                            <option value="State Govt">State Govt</option>
                                            <option value="DMHP fund">DMHP fund</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>

                                    <h4>Mass media</h4>
                                    <div class="mb-3">
                                        <label for="tv_broadcasts" class="form-label">Broadcasting of video clips on local TV channels</label>
                                        <input type="number" id="tv_broadcasts" name="tv_broadcasts" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="community_radio_messages" class="form-label">Dissemination of messages through community radio</label>
                                        <input type="number" id="community_radio_messages" name="community_radio_messages" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mental_health_films" class="form-label">Showing films on mental health</label>
                                        <input type="number" id="mental_health_films" name="mental_health_films" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="newspaper_ads" class="form-label">Advertisement on mental health in local newspapers, magazines, etc.</label>
                                        <input type="number" id="newspaper_ads" name="newspaper_ads" class="form-control" required>
                                    </div>

                                    <h4>Outdoor media</h4>

                                    <div class="mb-3">
                                        <label for="hoardings" class="form-label">Hoardings</label>
                                        <input type="number" id="hoardings" name="hoardings" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bus_panels" class="form-label">Bus Panels</label>
                                        <input type="number" id="bus_panels" name="bus_panels" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="exhibitions" class="form-label">Exhibitions</label>
                                        <input type="number" id="exhibitions" name="exhibitions" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="wall_paintings" class="form-label">Wall Paintings</label>
                                        <input type="number" id="wall_paintings" name="wall_paintings" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="street_plays" class="form-label">Street Plays</label>
                                        <input type="number" id="street_plays" name="street_plays" class="form-control" required>
                                    </div>

                                    <h4>Folk media</h4>

                                    <div class="mb-3">
                                        <label for="puppet_shows" class="form-label">Puppet Shows</label>
                                        <input type="number" id="puppet_shows" name="puppet_shows" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dance_song_shows" class="form-label">Dance & Song Shows</label>
                                        <input type="number" id="dance_song_shows" name="dance_song_shows" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="community_meetings" class="form-label">Community meetings with general people</label>
                                        <input type="number" id="community_meetings" name="community_meetings" class="form-control" required>
                                    </div>

                                    <h4>Interpersonal communication (IPC)</h4>

                                    <div class="mb-3">
                                        <label for="patient_family_meetings" class="form-label">Meetings with the family members of the patients</label>
                                        <input type="number" id="patient_family_meetings" name="patient_family_meetings" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="haat_sessions" class="form-label">Interactive sessions on mental health in Haats</label>
                                        <input type="number" id="haat_sessions" name="haat_sessions" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="other_specified_activities" class="form-label">Specify Activities</label>
                                        <input type="number" id="other_specified_activities" name="other_specified_activities" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="others" class="form-label">Others (Please specify)</label>
                                        <input type="number" id="others" name="others" class="form-control" required>
                                    </div>


                                    <h4>Targeted interventions at community level (Please provide number)</h4>

                                    <div class="mb-3">
                                        <label for="district_counselling_centers" class="form-label">District Counselling Centers</label>
                                        <input type="number" class="form-control" id="district_counselling_centers" name="district_counselling_centers" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="helpline_established" class="form-label">Crisis helpline/Mental Health Counselling helpline established(Y/N)</label>
                                        <select class="form-control" id="helpline_established" name="helpline_established" required>
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="school_counselling_sessions" class="form-label">Numbers of Couselling session in schools</label>
                                        <input type="number" class="form-control" id="school_counselling_sessions" name="school_counselling_sessions" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="students_counselled_schools" class="form-label">Number of students counselled in schools</label>
                                        <input type="number" class="form-control" id="students_counselled_schools" name="students_counselled_schools" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="teachers_life_skills_schools" class="form-label">Numbers of School teachers trained in life skills</label>
                                        <input type="number" class="form-control" id="teachers_life_skills_schools" name="teachers_life_skills_schools" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="college_counselling_sessions" class="form-label">Number of Counselling sessions in colleges</label>
                                        <input type="number" class="form-control" id="college_counselling_sessions" name="college_counselling_sessions" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="teachers_life_skills_college" class="form-label">Numbers of Colleges teachers trained in life skills</label>
                                        <input type="number" class="form-control" id="teachers_life_skills_college" name="teachers_life_skills_college" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="students_counselled_college" class="form-label">Number of studnets counselled in college</label>
                                        <input type="number" class="form-control" id="students_counselled_college" name="students_counselled_college" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="suicide_prevention_camps" class="form-label">Number of suicide prevention camps</label>
                                        <input type="number" class="form-control" id="suicide_prevention_camps" name="suicide_prevention_camps" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="people_attended_suicide_prevention" class="form-label">Number of people attended suicide prevention camps</label>
                                        <input type="number" class="form-control" id="people_attended_suicide_prevention" name="people_attended_suicide_prevention" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stress_management_sessions" class="form-label">Number of Workplace stress management sessions</label>
                                        <input type="number" class="form-control" id="stress_management_sessions" name="stress_management_sessions" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stress_session_attendees" class="form-label">Number of people attended stress management sessions</label>
                                        <input type="number" class="form-control" id="stress_session_attendees" name="stress_session_attendees" required>
                                    </div>

                                    <h4>Special Interventions</h4>

                                    <h5>Home Visists</h5>

                                    <div class="mb-3">
                                        <label for="home_visits" class="form-label">Number of Home visits conducted to the patients (Home)</label>
                                        <input type="number" class="form-control" id="home_visits" name="home_visits" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="family_members_counselled" class="form-label">Number of Family members counselled</label>
                                        <input type="number" class="form-control" id="family_members_counselled" name="family_members_counselled" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="neighbours_counselled" class="form-label">Number of neighbours counselled</label>
                                        <input type="number" class="form-control" id="neighbours_counselled" name="neighbours_counselled" required>
                                    </div>

                                    <h5>Jails</h5>

                                    <div class="mb-3">
                                        <label for="jail_visits" class="form-label">Number of visits to jails</label>
                                        <input type="number" class="form-control" id="jail_visits" name="jail_visits" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jail_inmates_counselled" class="form-label">Number of Jail inmates counselled</label>
                                        <input type="number" class="form-control" id="jail_inmates_counselled" name="jail_inmates_counselled" required>
                                    </div>

                                    <h5>Old Age Home</h5>

                                    <div class="mb-3">
                                        <label for="old_age_home_visits" class="form-label">Number of Old age home visits</label>
                                        <input type="number" class="form-control" id="old_age_home_visits" name="old_age_home_visits" required>
                                    </div>


                                    <div class="mb-3">
                                        <label for="old_age_individuals_counselled" class="form-label">Number of Individuals counselled</label>
                                        <input type="number" class="form-control" id="old_age_individuals_counselled" name="old_age_individuals_counselled" required>
                                    </div>

                                    <h4>Child Care Institutions/Observation homes/Special homes/Place of Safety/Children Homes/Orphanage Homes</h4>


                                    <div class="mb-3">
                                        <label for="child_care_institution_visits" class="form-label">Number of visits to Child care institutions</label>
                                        <input type="number" class="form-control" id="child_care_institution_visits" name="child_care_institution_visits" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="children_counselled_institutions" class="form-label">Number of childre counselled in child care institution</label>
                                        <input type="number" class="form-control" id="children_counselled_institutions" name="children_counselled_institutions" required>
                                    </div>

                                    <h4>Out reach service delivery</h4>


                                    <div class="mb-3">
                                        <label for="service_approach" class="form-label">Approach used by DMHP to deliver mental health services - Please mention {A = Outreach (camps) based, B = PHC based, C = Both (outreach and PHC based)}, If outreach (camp) based or both the approaches are used; please answer following</label>
                                        <select class="form-control" id="service_approach" name="service_approach" required>
                                            <option value="">Select</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="outreach_visits" class="form-label">Total no. of Out reach visits made by DMHP team in the month</label>
                                        <input type="number" class="form-control" id="outreach_visits" name="outreach_visits" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="outreach_cases_examined" class="form-label">Total no. of cases examined in the outreach camps</label>
                                        <input type="number" class="form-control" id="outreach_cases_examined" name="outreach_cases_examined" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="outreach_referred_district" class="form-label">Total no. of cases refered at District level for management</label>
                                        <input type="number" class="form-control" id="outreach_referred_district" name="outreach_referred_district" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="outreach_referred_rehabilitation" class="form-label">Total no. of cases referred for rehabilitaion/ counselling</label>
                                        <input type="number" class="form-control" id="outreach_referred_rehabilitation" name="outreach_referred_rehabilitation" required>
                                    </div>
                                    <h4>Mental health help line</h4>
                                    <div class="mb-3">
                                        <label for="helpline_available" class="form-label">Whether Mental health helpline available? (if yes, provide contact number)</label>
                                        <select class="form-control" id="helpline_available" name="helpline_available" required onchange="toggleHelplineContact()">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="helpline_contact" class="form-label">Helpline Contact</label>
                                        <input type="text" class="form-control" id="helpline_contact" name="helpline_contact"
                                            maxlength="10" pattern="\d{4,10}" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            title="Please enter between 4 to 10 digits only">
                                    </div>

                                    <div class="mb-3">
                                        <label for="helpline_calls" class="form-label">Number of calls received in month</label>
                                        <input type="number" class="form-control" id="helpline_calls" name="helpline_calls" required>
                                    </div>

                                    <h4>Communitisation of DMHP</h4>

                                    <div class="mb-3">
                                        <label for="ngosEngaged" class="form-label">No. of NGOs engaged for mental health activities</label>
                                        <input type="number" id="ngosEngaged" name="ngos_engaged" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="panchayatiRajEngaged" class="form-label">No. of Panchayati Raj Institutions engaged for mental health activities of DMHP</label>
                                        <input type="number" id="panchayatiRajEngaged" name="panchayati_raj_engaged" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="userFamilyGroups" class="form-label">No. of User Groups/Family Associations in the district</label>
                                        <input type="number" id="userFamilyGroups" name="user_family_groups" class="form-control" required>
                                    </div>

                                    <h4>Monitoring of Suicidal Attempts</h4>

                                    <div class="mb-3">
                                        <label for="suicideAttemptReports" class="form-label">Number of case reports of attempted suicides</label>
                                        <input type="number" id="suicideAttemptReports" name="suicide_attempt_reports" class="form-control" required>
                                    </div>

                                    <h5 class="mt-4">Financial Status (Reporting Quarter)</h5>

                                    <div class="mb-3">
                                        <label for="budget_received" class="form-label">Budget Received</label>
                                        <input type="number" id="budget_received" name="budget_received" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="opening_balance" class="form-label">Opening balance as on (reporting quarter)</label>
                                        <input type="number" id="opening_balance" name="opening_balance" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="total_funds_available" class="form-label">Total Funds Available</label>
                                        <input type="number" id="total_funds_available" name="total_funds_available" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="expenditure_incurred" class="form-label">Expenditure incurred during the quarter</label>
                                        <input type="number" id="expenditure_incurred" name="expenditure_incurred" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="balance" class="form-label">Balance</label>
                                        <input type="number" id="balance" name="balance" class="form-control" required>
                                    </div>


                                </div>


                            </div>








                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

<script>
    function toggleHelplineContact() {
        const helplineAvailable = document.getElementById('helpline_available').value;
        const helplineContact = document.getElementById('helpline_contact');

        if (helplineAvailable === 'Yes') {
            helplineContact.setAttribute('required', 'required');
        } else {
            helplineContact.removeAttribute('required');
        }
    }

    // Optional: Run on page load in case of form re-population
    window.addEventListener('DOMContentLoaded', toggleHelplineContact);
</script>

<?php include('dashboard-footer.php'); ?>