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
        FROM man_chetna_diwas c 
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

                    <h2>Man Chetna Diwas Records</h2>

                    <a href="add_man_chetna_diwas.php" class="btn btn-primary" style="float: inline-end;margin-right: 20px;">Add New</a>
                    <div class="col-md-12 mt-3">

                        <div class="panel-heading"> <span class="title elipsis">
                                <h4>Man Chetna Diwas Report</h4>
                            </span> </div>

                        <div class="panel-body">
                            <div class="row" style="padding-left:10px;padding-right:10px">
                                <?php if (isset($user_role)) { ?>
                                    <div class="col-md-12">
                                        <form method="post" id="filter_chetna_form">
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
                                                    <input type="date" name="chetna_date" id="date">
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="submit" class="btn btn-info" value="Search">
                                                    <button type="button" class="btn  btn-primary" id="downloadBtnChetna">Download</button>
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
                                        <table class="table text-center table-striped" style="justify-content:center;align-item:center;" id="referralChetna">
                                            <thead class="thead-dark padding-top-10">
                                                <tr style="font-weight:bold">
                                                    <th>ID</th>
                                                    <th>District Name</th>
                                                    <th>Name OF CHC/PHC</th>
                                                    <th>New OPD patients</th>
                                                    <th>Follow up cases in OPD</th>
                                                    <th>No.of patient counselled (Numbers)</th>
                                                    <th>Referred cases to DH</th>
                                                    <th>Referred back from district hospital</th>
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
                                                        <td><strong><?= $row['chc_phc_name'] ?></strong></td>
                                                        <td><strong><?= $row['new_opd_patients'] ?></strong></td>
                                                        <td><strong><?= $row['follow_up_cases_opd'] ?></strong></td>
                                                        <td><strong><?= $row['patients_counselled'] ?></strong></td>
                                                        <td><strong><?= $row['referred_to_dh'] ?></strong></td>
                                                        <td><strong><?= $row['referred_back_from_dh'] ?></strong></td>
                                                        <td>
                                                            <a class="btn btn-primary" href="edit_man_chetna_diwas.php?id=<?= $row['id'] ?>">Edit</a>
                                                        </td>
                                                    </tr>
                                                    <?php $count = $count + 1; ?>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>



                                        <table class="table text-center table-striped hidden" id="filter-report-chetna">
                                            <thead class="thead-dark p-1">
                                                
                                                    <tr>
                                                        <td><strong>ID</strong></td>
                                                        <td><strong>District Name</strong></td>
                                                        <td><strong>Name OF CHC/PHC</strong></td>
                                                        <td><strong>New OPD patients</strong></td>
                                                        <td><strong>Follow up cases in OPD</strong></td>
                                                        <td><strong>No. of patient counselled (Numbers)</strong></td>
                                                        <td><strong>Referred cases to DH</strong></td>
                                                        <td><strong>Referred back from district hospital</strong></td>
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