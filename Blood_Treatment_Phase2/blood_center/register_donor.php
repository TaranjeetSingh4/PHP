<?php
session_start();
error_reporting(0);
require '../includes/auth.php';
require '../includes/db.php';
requireRole('blood_center');

$staff_id = $_SESSION['user_id'];

// Step 1: Get logged-in staff's name
$stmt = $conn->prepare("SELECT name FROM staff WHERE id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$res = $stmt->get_result();
$staff = $res->fetch_assoc();
$staff_name = $staff['name'] ?? null;

// Step 2: Match that name with blood_centers.name
$blood_center = null;
$blood_center_id = null;

if ($staff_name) {
    $stmt = $conn->prepare("SELECT id, name, district_id  FROM blood_centers WHERE name = ?");
    $stmt->bind_param("s", $staff_name);
    $stmt->execute();
    $res = $stmt->get_result();
    $blood_center = $res->fetch_assoc();
    $blood_center_id = $blood_center['id'] ?? null;
    $district_id = $blood_center['district_id'] ?? null;
}
$blood_center_id = $blood_center['id'] ?? null;


if (isset($_POST['submit'])) {
    $fullname = $_POST['name'];
    $mobile = $_POST['mobile_number'];
    $email = $_POST['email'];
    $dob_input = $_POST['dob']; // Format: dd-mm-yyyy
    $date = DateTime::createFromFormat('d-m-Y', $dob_input);
    $dob = $date ? $date->format('Y-m-d') : null; // Format for MySQL

    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $bloodgroup = $_POST['blood_group'];
    $b_center_id = $blood_center_id;
    $address = $_POST['address'];
    $status = 1;
    $refer_option = $_POST['refer_option'] ?? 'continue';
    $referred_center = null;

    if ($refer_option === 'refer' && !empty($_POST['referred_blood_center'])) {
        $referred_center = $_POST['referred_blood_center'];
    }


    // Check if email already exists
    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO users 
(name, mobile_number, email, dob, age, gender, blood_group, address, status, blood_center_id, referred_blood_center) 
VALUES 
('$fullname', '$mobile', '$email', '$dob', '$age', '$gender', '$bloodgroup', '$address', '$status', '$b_center_id', " . ($referred_center ? "'$referred_center'" : "NULL") . ")";


        $insert = mysqli_query($conn, $sql);

        if ($insert) {
            echo "<script>alert('You have registered donor successfully');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        echo "<script>alert('Email ID already exists. Please try again');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Register Donor</title>
    <!-- Meta tag Keywords -->

    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <!-- Web-Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <!-- //Web-Fonts -->


</head>

<body>
    <?php include('../includes/dashboard_layout/header.php'); ?>

    <div class="ts-main-content">
        <?php include('../includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Register Donor</h2>
                        <!-- about -->
                        <section class="about">
                            <div class="py-xl-5 py-lg-3">
                                <div class="login px-4 mx-auto mw-100">
                                    <form action="#" method="post" name="signup">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Full Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile_number" id="mobile_number" required="true" placeholder="Mobile Number" maxlength="10" pattern="[0-9]+">
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-2">Email Id</label>
                                            <input type="email" name="email" class="form-control" placeholder="Email Id">
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-2">Date of Birth</label>
                                            <input type="text" class="form-control" name="dob" id="dob" placeholder="DD-MM-YYYY" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-2">Age</label>
                                            <input type="text" class="form-control" name="age" id="age" placeholder="Age" required readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-2">Gender</label>
                                            <select name="gender" class="form-control" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-2">Blood Group</label>
                                            <select name="blood_group" class="form-control" required>
                                                <option value="">Select Blood Group</option>
                                                <?php
                                                $sql = "SELECT * FROM bloodgroup";
                                                $result = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . htmlspecialchars($row['BloodGroup']) . '">' . htmlspecialchars($row['BloodGroup']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address" id="address" required="true" placeholder="Address">
                                        </div>
                                        <div class="form-group">
                                            <label>Continue/Refer to Blood Center</label>
                                            <select name="refer_option" id="refer_option" class="form-control">
                                                <option value="continue" selected>Continue with Current Blood Center</option>
                                                <option value="refer">Refer To</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="refer_blood_center_group" style="display: none;">
                                            <label>Select Blood Center to Refer</label>
                                            <select name="referred_blood_center" class="form-control">
                                                <option value="">Select Blood Center</option>
                                                <?php
                                                $stmt = $conn->prepare("
                                                            SELECT bc.id, bc.name AS center_name, d.name AS district_name 
                                                            FROM blood_centers bc 
                                                            JOIN districts d ON bc.district_id = d.id 
                                                            WHERE bc.id != ?
                                                        ");
                                                $stmt->bind_param("i", $blood_center_id);
                                                $stmt->execute();
                                                $res = $stmt->get_result();

                                                while ($center = $res->fetch_assoc()) {
                                                    $center_id = $center['id'];
                                                    $center_name = htmlspecialchars($center['center_name']);
                                                    $district_name = htmlspecialchars($center['district_name']);
                                                    echo "<option value='$center_id'>$center_name ($district_name)</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary submit mb-4" name="submit">Register</button>
                                    </form>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- //about -->

    <?php include('includes/footer.php'); ?>
    <script>
        $(document).ready(function() {
            $('#refer_option').change(function() {
                if ($(this).val() === 'refer') {
                    $('#refer_blood_center_group').show();
                } else {
                    $('#refer_blood_center_group').hide();
                }
            });

            $('#dob').change(function() {
                var dobStr = $('#dob').val();
                var parts = dobStr.split('-');

                if (parts.length === 3) {
                    var day = parseInt(parts[0], 10);
                    var month = parseInt(parts[1], 10) - 1;
                    var year = parseInt(parts[2], 10);

                    var birthDate = new Date(year, month, day);
                    var today = new Date();

                    var age = today.getFullYear() - birthDate.getFullYear();
                    var m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    if (!isNaN(age)) {
                        $('#age').val(age);
                    } else {
                        $('#age').val('');
                    }
                } else {
                    $('#age').val('');
                }
            });
        });
    </script>


</body>

</html>