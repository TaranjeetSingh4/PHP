<?php

require_once("config.php");

session_start();

if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $month=$_GET['month'];
    $year=$_GET['year'];
    $format_id=$_GET['id'];
    $role_id=$_GET['role_id'];
    $user_id=$_GET['user_id'];

    $query="update user_filled_data set status=0 where user_id=$user_id and role_id=$role_id and format_id=$format_id and month=$month and year=$year";
   
    mysqli_query($conn,$query);

    header('location:../reports.php');
}

else{
    header('location:../index.php');
}

?>