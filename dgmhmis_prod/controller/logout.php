<?php

require_once("config.php");

session_start();
$user_id = $_SESSION['id'];
$logout_time = date('Y-m-d H:i:s');
$conn=get_db_connection();
$sql = "UPDATE user_activity_log SET logout_time='$logout_time' WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1";
$res=mysqli_query($conn,$sql);

unset($_SESSION['email']);
session_destroy();
header('location:../index.php');


?>