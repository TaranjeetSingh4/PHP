<?php include('dashboard-header.php') ?>
<?php
session_start();
if (isset($_SESSION['user_role'])) {
    $user_role = $_SESSION['user_role'];
} else {
    header("Location:index.php");
    session_destroy();
}

if ($_SESSION['user_role'] !== 'CMO Office') {
    echo "<div class='text-center text-danger'>
    <strong>Access Denied. You are not authorized to view this page.</strong></div>";
    exit();
}

require_once './controller/config.php';
require_once('./controller/fetch_districts.php');
require_once('./controller/all_formats.php');
$conn = get_db_connection();

$district_id = $_SESSION['district_id'];
// Fetch all records with district name join
$sql = "SELECT c.*, d.district_name 
        FROM district_counselling_center_man_kakash c 
        JOIN master_district d ON c.district_id = d.id 
        WHERE c.district_id = $district_id 
        ORDER BY c.id DESC";
$result = mysqli_query($conn, $sql);
?>

<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-center align-items-center vh-100">
                    <h2>Man-Kaksh Records</h2>

                    <a href="add_mankaksh.php" class="btn btn-primary" style="float: inline-end;">Add New Man-Kaksh</a>
                    <div class="col-md-12 mt-3">

                        <div class="panel-heading"> <span class="title elipsis">
                                <h4>District Counselling Center (Man Kaksh)</h4>
                            </span> </div>

                        <div class="panel-body">
                            <div class="row" style="padding-left:10px;padding-right:10px">
                                <?php if (isset($user_role)) { ?>
                                    <div class="col-md-12">
                                        <form method="post" id="filter_kaksh_form">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <select name="district_id" id="districts">
                                                        <option value="">All Districts</option>
                                                        <?php while ($row = mysqli_fetch_assoc($district_result)) { ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['district_name']; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>


                                                <div class="col-md-2">
                                                    <input type="date" name="kaksh_date" id="date">
                                                </div>

                                                <div class="col-md-3">
                                                    <!-- <button class="btn btn-info" id="filter_search">Search</button> -->
                                                    <input type="submit" class="btn btn-info" value="Search">
                                                    <button type="button" class="btn  btn-primary" id="downloadBtnKaksh">Download</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php } ?>

                            </div>

                            <hr>

                            <div>
                                <p id="alert-data">

                                </p>
                            </div>
                            <div id="response"></div>
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="table-responsive">
                                        <table class="table text-center table-striped" style="justify-content:center;align-item:center;" id="referralKakshTable">
                                            <thead class="thead-dark padding-top-10">
                                                <tr style="font-weight:bold">
                                                    <th>ID</th>
                                                    <th>District Name</th>
                                                    <th>No. of new cases in Man-Kaksh</th>
                                                    <th>No. of Follow up cases in Man-Kaksh</th>
                                                    <th>Total (New Cases + Follow up Cases)</th>
                                                    <th>Cases of Common Mental Disorders out of 1.1.3</th>
                                                    <th>Cases of Severe Mental Disorders out of 1.1.3</th>
                                                    <th>Cases of Family Therapy/ Marital Therapy</th>
                                                    <th>No of cases reported for crisis help</th>
                                                    <th>Suicide</th>
                                                    <th>Disaster</th>
                                                    <th>Any other (Specify)</th>
                                                    <th>No. of Psychological intervention done (Counselling/Psychotherapy)</th>
                                                    <th>No. of Disability Certification Done</th>
                                                    <th>IQ</th>
                                                    <th>ASD (Autism Spectrum Disorder)</th>
                                                    <th>LD (Learning Disability)</th>
                                                    <th>No. of cases benefitted for addiction of Tobacco/Alcohol/opioids/any Drug abuse</th>
                                                    <th>Tobacco</th>
                                                    <th>Alcohol</th>
                                                    <th>Opiods</th>
                                                    <th>Mobile addiction</th>
                                                    <th>any other</th>
                                                    <th>No. of referrals from Teaching institutes</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $count = 1;
                                                while ($row = mysqli_fetch_assoc($result)) : ?>
                                                    <tr>
                                                        <td><strong><?php echo $count; ?></strong></td>
                                                        <td><strong><?= htmlspecialchars($row['district_name']) ?></strong></td>
                                                        <td><strong><?= $row['new_cases_man_kaksh'] ?></strong></td>
                                                        <td><strong><?= $row['followup_cases_man_kaksh'] ?></strong></td>
                                                        <td><strong><?= $row['total_cases'] ?></strong></td>
                                                        <td><strong><?= $row['common_mental_disorders'] ?></strong></td>
                                                        <td><strong><?= $row['severe_mental_disorders'] ?></strong></td>
                                                        <td><strong><?= $row['family_therapy'] ?></strong></td>
                                                        <td><strong><?= $row['crisis_help_cases'] ?></strong></td>
                                                        <td><strong><?= $row['suicide'] ?></strong></td>
                                                        <td><strong><?= $row['disaster'] ?></strong></td>
                                                        <td><strong><?= $row['any_other'] ?></strong></td>
                                                        <td><strong><?= $row['psychological_interventions'] ?></strong></td>
                                                        <td><strong><?= $row['disability_certifications'] ?></strong></td>
                                                        <td><strong><?= $row['IQ'] ?></strong></td>
                                                        <td><strong><?= $row['ASD'] ?></strong></td>
                                                        <td><strong><?= $row['LD'] ?></strong></td>
                                                        <td><strong><?= $row['addiction_cases'] ?></strong></td>
                                                        <td><strong><?= $row['tobacco'] ?></strong></td>
                                                        <td><strong><?= $row['alcohol'] ?></strong></td>
                                                        <td><strong><?= $row['opioids'] ?></strong></td>
                                                        <td><strong><?= $row['mobile_addiction'] ?></strong></td>
                                                        <td><strong><?= $row['addiction_any_other'] ?></strong></td>
                                                        <td><strong><?= $row['referrals_from_teaching_institutes'] ?></strong></td>
                                                        <td>
                                                            <a class="btn btn-primary" href="edit_mankaksh.php?id=<?= $row['id'] ?>">Edit</a>
                                                        </td>
                                                    </tr>
                                                    <?php $count = $count + 1; ?>
                                        <?php endwhile; ?>
                                        </tbody>
                                        </table>

                                        <table class="table text-center table-striped hidden" id="filter-report-kaksh">
                                            <thead class="thead-dark p-1">
                                                <tr>
                                                    <td><strong>ID</strong></td>
                                                    <td><strong>District Name</strong></td>
                                                    <td><strong>No. of new cases in Man-Kaksh</strong></td>
                                                    <td><strong>No. of Follow up cases in Man-Kaksh</strong></td>
                                                    <td><strong>Total (New Cases + Follow up Cases)</strong></td>
                                                    <td><strong>Cases of Common Mental Disorders out of 1.1.3</strong></td>
                                                    <td><strong>Cases of Severe Mental Disorders out of 1.1.3</strong></td>
                                                    <td><strong>Cases of Family Therapy/ Marital Therapy</strong></td>
                                                    <td><strong>No of cases reported for crisis help</strong></td>
                                                    <td><strong>Suicide</strong></td>
                                                    <td><strong>Disaster</strong></td>
                                                    <td><strong>Any other (Specify)</strong></td>
                                                    <td><strong>No. of Psychological intervention done (Counselling/Psychotherapy)</strong></td>
                                                    <td><strong>No. of Disability Certification Done</strong></td>
                                                    <td><strong>IQ</strong></td>
                                                    <td><strong>ASD (Autism Spectrum Disorder)</strong></td>
                                                    <td><strong>LD (Learning Disability)</strong></td>
                                                    <td><strong>No. of cases benefitted for addiction of Tobacco/Alcohol/opioids/any Drug abuse</strong></td>
                                                    <td><strong>Tobacco</strong></td>
                                                    <td><strong>Alcohol</strong></td>
                                                    <td><strong>Opiods</strong></td>
                                                    <td><strong>Mobile addiction</strong></td>
                                                    <td><strong>any other</strong></td>
                                                    <td><strong>No. of referrals from Teaching institutes</strong></td>
                                                    <td><strong>Actions</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <p id="alert-data" class="hidden text-center"></p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('dashboard-footer.php'); ?>