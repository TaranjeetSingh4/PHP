<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $id=$_REQUEST['id'];
    $sql="select * from user where id=$id";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);

    $role_id=$_SESSION['login_user_role'];
    $get_role_query="select * from roles where id=$role_id";
    $get_role_result=mysqli_query($conn,$get_role_query);
    $row_role=mysqli_fetch_assoc($get_role_result);
}

else{
    header('location:../index.php');
}


?>