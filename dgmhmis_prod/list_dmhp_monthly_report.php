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
$sql = "SELECT dm.*, d.district_name 
        FROM dmhp_monthly_report dm 
        JOIN master_district d ON dm.district_id = d.id 
        WHERE dm.district_id = $district_id
        ORDER BY dm.id DESC";
$result = mysqli_query($conn, $sql);
?>

<section id="main-content" style="min-height: 100vh;">
    <!-- page title -->
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-center align-items-center vh-100">

                    <h2>DMHP MONTHLY REPORT RECORDS</h2>

                    <a href="add_dmhp_monthly_report.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Add New</a>
                    <div class="col-md-12 mt-3">

                        <div class="panel-heading"> <span class="title elipsis">
                                <h4>DMHP MONTHLY REPORT</h4>
                            </span> </div>

                        <div class="panel-body">
                            <div class="row" style="padding-left:10px;padding-right:10px">
                                <?php if (isset($user_role)) { ?>
                                    <div class="col-md-12">
                                        <form method="post" id="filter_dmhp_form">
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
                                                    <input type="date" name="dmhp_date" id="date">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="submit" class="btn btn-info" value="Search">
                                                    <button type="button" class="btn  btn-primary" id="downloadBtnDmhp">Download</button>
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
                                        <table class="table text-center table-striped" style="justify-content:center;align-item:center;" id="referralDmhpTable">
                                            <thead class="thead-dark padding-top-10">
                                                <tr style="font-weight:bold">
                                                    <th>ID</th>
                                                    <th>District Name</th>
                                                    <th>Name of the Nodal Officer, DMHP</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email ID</th>
                                                    <th>Psychiatrist</th>
                                                    <th>Trained MO working as Psychiatrist</th>
                                                    <th>Clinical Psychologist</th>
                                                    <th>Trained Psychologist</th>
                                                    <th>Psychiatric Social Worker</th>
                                                    <th>Trained Social Worker</th>
                                                    <th>Psychiatric Nurse</th>
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
                                                        <td><strong><?= $row['nodal_officer_name'] ?></strong></td>
                                                        <td><strong><?= $row['nodal_officer_mobile'] ?></strong></td>
                                                        <td><strong><?= $row['nodal_officer_email'] ?></strong></td>
                                                        <td><strong><?= $row['psychiatrist'] ?></strong></td>
                                                        <td><strong><?= $row['trained_mo_psychiatrist'] ?></strong></td>
                                                        <td><strong><?= $row['clinical_psychologist'] ?></strong></td>
                                                        <td><strong><?= $row['trained_psychologist'] ?></strong></td>
                                                        <td><strong><?= $row['psychiatric_social_worker'] ?></strong></td>
                                                        <td><strong><?= $row['trained_social_worker'] ?></strong></td>
                                                        <td><strong><?= $row['psychiatric_nurse'] ?></strong></td>
                                                        <td>
                                                            <a class="btn btn-primary" href="edit_dmhp_monthly_report.php?id=<?= $row['id'] ?>">Edit</a>
                                                        </td>
                                                    </tr>
                                                    <?php $count = $count + 1; ?>

                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>



                                        <table class="table text-center table-striped hidden" id="filter-report-dmhp">
                                            <thead class="thead-dark padding-top-10">
                                                <tr>
                                                    <td><strong>ID</strong></td>
                                                    <td><strong>District Name</strong></td>
                                                    <td><strong>Name of the Nodal Officer, DMHP</strong></td>
                                                    <td><strong>Mobile Number</strong></td>
                                                    <td><strong>Email ID</strong></td>
                                                    <td><strong>Psychiatrist</strong></td>
                                                    <td><strong>Trained MO working as Psychiatrist</strong></td>
                                                    <td><strong>Clinical Psychologist</strong></td>
                                                    <td><strong>Trained Psychologist</strong></td>
                                                    <td><strong>Psychiatric Social Worker</strong></td>
                                                    <td><strong>Trained Social Worker</strong></td>
                                                    <td><strong>Psychiatric Nurse</strong></td>
                                                    <td><strong>Action(s)</strong></td>
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