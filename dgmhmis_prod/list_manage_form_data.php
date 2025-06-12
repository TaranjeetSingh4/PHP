<?php include('dashboard-header.php') ?>
<?php
// Get logged-in user's ID
$user_id = $_SESSION['id'];

if (isset($_SESSION['user_role'])) {
    $user_role = $_SESSION['user_role'];
} else {
    header("Location:index.php");
    session_destroy();
}

$allowed_roles = ['Community Health Centre (CHC)', 'Primary Health Care (PHC)', 'District Hospital (CMS)'];
if (!in_array($user_role, $allowed_roles)) {
    echo "<div class='text-center text-danger'><strong>Access Denied. You are not authorized to view this page.</strong></div>";
    exit();
}

require_once './controller/config.php';

$conn = get_db_connection();

$filter_applied = false;
$filter_month = '';
$filter_year = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_month = $_POST['month'] ?? '';
    $filter_year = $_POST['year'] ?? '';
    $filter_applied = !empty($filter_month) && !empty($filter_year);
}

$query = "SELECT 
            ufd.id AS data_id,
            ufd.format_id,
            f.format_name,
            ff.field_name,
            fs.sub_field_name,
            ufd.value,
            ufd.month,
            ufd.year,
            ufd.status
          FROM user_filled_data ufd
          LEFT JOIN formats f ON ufd.format_id = f.id
          LEFT JOIN format_fields ff ON ufd.field_id = ff.id
          LEFT JOIN format_sections fs ON ufd.sub_field_id = fs.id
          WHERE ufd.user_id = ?";

if ($filter_applied) {
    $query .= " AND ufd.month = ? AND ufd.year = ?";
}

$query .= " ORDER BY ufd.year, ufd.month, ff.field_name, fs.sub_field_name";

$stmt = $conn->prepare($query);
if ($filter_applied) {
    $stmt->bind_param("iii", $user_id, $filter_month, $filter_year);
} else {
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();

$pivoted = [];
$field_headers = [];
$format_ids = [];
$format_names = [];

while ($row = $result->fetch_assoc()) {
    $month = $row['month'];
    $year = $row['year'];
    $field = $row['field_name'];
    $sub_field = $row['sub_field_name'];
    $label = $sub_field ?: $field;

    $key = "$month-$year";
    $field_headers[$label] = true;

    if (!isset($pivoted[$key])) {
        $pivoted[$key] = [
            'month' => $month,
            'year' => $year,
            'format_name' => $row['format_name']
        ];
        $format_ids[$key] = $row['format_id'];
    }

    $pivoted[$key][$label] = $row['value'];
}
?>

<section id="main-content" style="min-height: 100vh;">
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-center align-items-center">
                    <h2>Manage Form Records</h2>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="panel-heading">
                        <span class="title elipsis">
                            <h4>Manage Form Records</h4>
                        </span>
                    </div>

                    <div class="panel-body">
                        <form method="POST" class="form-inline mb-3">
                            <div class="form-group mr-2">
                                <label for="month">Month:</label>
                                <select name="month" id="month" class="form-control ml-2">
                                    <option value="">Select Month</option>
                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?= $m ?>" <?= ($filter_month == $m) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 10)) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label for="year">Year:</label>
                                <select name="year" id="year" class="form-control ml-2">
                                    <option value="">Select Year</option>
                                    <?php for ($y = date('Y'); $y >= 1980; $y--): ?>
                                        <option value="<?= $y ?>" <?= ($filter_year == $y) ? 'selected' : '' ?>><?= $y ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ml-2">Search</button>
                        </form>

                        <?php if ($filter_applied && !empty($pivoted)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Form Name</th>
                                            <?php foreach ($field_headers as $header => $_): ?>
                                                <th><?= htmlspecialchars($header) ?></th>
                                            <?php endforeach; ?>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pivoted as $key => $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['month']) ?></td>
                                                <td><?= htmlspecialchars($row['year']) ?></td>
                                                  <td><?= htmlspecialchars($row['format_name']) ?></td>
                                                <?php foreach ($field_headers as $header => $_): ?>
                                                    <td><?= isset($row[$header]) ? htmlspecialchars($row[$header]) : '-' ?></td>
                                                <?php endforeach; ?>
                                                <td>
                                                    <?php
                                                    $format_id = $format_ids[$key];
                                                    $user_id = $_SESSION['id'];
                                                    $role_id = $_SESSION['login_user_role'];
                                                    $date = str_pad($row['month'], 2, "0", STR_PAD_LEFT) . '/01/' . $row['year'];
                                                    $url = "edit-format-data.php?id=$format_id&user_id=$user_id&role_id=$role_id&date=$date";
                                                    ?>
                                                    <a href="<?= $url ?>" class="btn btn-sm btn-warning">Edit</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php elseif ($filter_applied): ?>
                            <p>No records found for selected filter.</p>
                        <?php else: ?>
                            <p>Please select a Month and Year to view records.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('dashboard-footer.php'); ?>
