<?php
session_start();
require 'includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Escape user input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);


    // First check in users table
    $sql_user = "SELECT * FROM users WHERE email = '$email'";
    $result_user = mysqli_query($conn, $sql_user);

    if ($result_user && mysqli_num_rows($result_user) == 1) {
        $user = mysqli_fetch_assoc($result_user);
    } else {
        // Check in staff table if not found in users
        $sql_staff = "SELECT * FROM staff WHERE email = '$email'";
        $result_staff = mysqli_query($conn, $sql_staff);

        if ($result_staff && mysqli_num_rows($result_staff) == 1) {
            $user = mysqli_fetch_assoc($result_staff);
        } else {
            $user = null;
        }
    }

    if ($user && md5($password) === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        

        switch ($user['role']) {
            case 'admin':
                header("Location: admin/dashboard.php");
                break;
            case 'user':
                header("Location: user/dashboard.php");
                break;
            case 'blood_center':
                header("Location: blood_center/dashboard.php");
                break;
            case 'treatment_center':
                header("Location: treatment_center/dashboard.php");
                break;
        }
        exit();
    } else {
        $error = "Invalid credentials!";
    }

    
}
?>




<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Blood Bank Donar Management System | About Us </title>
    <!-- Meta tag Keywords -->

    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!--// Meta tag Keywords -->

    <!-- Custom-Files -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Style-CSS -->
    <link rel="stylesheet" href="css/fontawesome-all.css">
    <!-- Font-Awesome-Icons-CSS -->
    <!-- //Custom-Files -->

    <!-- Web-Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <!-- //Web-Fonts -->

</head>

<body>
    <?php include('includes/header.php'); ?>

    <!-- banner 2 -->
    <div class="inner-banner-w3ls">
        <div class="container">

        </div>
        <!-- //banner 2 -->
    </div>
    <!-- page details -->
    <div class="breadcrumb-agile">
        <div aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Login</li>
            </ol>
        </div>
    </div>
    <!-- //page details -->

    <!-- about -->
    <section class="about py-5">
        <div class="container py-xl-5 py-lg-3">
            <div class="login px-4 mx-auto mw-100">
                <h5 class="text-center mb-4">Login Now</h5>
                <form action="#" method="post" name="login">
                    <div class="form-group">
                        <label>Email ID</label>
                        <input type="email" class="form-control" name="email" placeholder="" required="">
                    </div>
                    <div class="form-group">
                        <label class="mb-2">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="" required="">
                    </div>
                    <button type="submit" class="btn submit mb-4" name="login">Login</button>
                    <!--     <p class="forgot-w3ls text-center pb-4">
                                    <a href="#" class="text-white">Forgot your password?</a>
                                </p> -->
                    <p class="account-w3ls text-center pb-4" style="color:#000">
                        Stay update,by logging in to your account.
                    </p>
                </form>
            </div>

        </div>
    </section>
    <!-- //about -->



    <?php include('includes/footer.php'); ?>


    <!-- Js files -->
    <!-- JavaScript -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- Default-JavaScript-File -->

    <!-- banner slider -->
    <script src="js/responsiveslides.min.js"></script>
    <script>
        $(function() {
            $("#slider4").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 1000,
                namespace: "callbacks",
                before: function() {
                    $('.events').append("<li>before event fired.</li>");
                },
                after: function() {
                    $('.events').append("<li>after event fired.</li>");
                }
            });
        });
    </script>
    <!-- //banner slider -->

    <!-- fixed navigation -->
    <script src="js/fixed-nav.js"></script>
    <!-- //fixed navigation -->

    <!-- smooth scrolling -->
    <script src="js/SmoothScroll.min.js"></script>
    <!-- move-top -->
    <script src="js/move-top.js"></script>
    <!-- easing -->
    <script src="js/easing.js"></script>
    <!--  necessary snippets for few javascript files -->
    <script src="js/medic.js"></script>

    <script src="js/bootstrap.js"></script>
    <!-- Necessary-JavaScript-File-For-Bootstrap -->

    <!-- //Js files -->

</body>

</html>