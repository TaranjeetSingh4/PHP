<?php

require_once("config.php");

session_start();

if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $format_id=$_GET['id'];
    $format_status=$_GET['status'];
    if($format_status==1){
        $delete_query="update formats set format_status=0 where id=$format_id";
    }
    else{
        $delete_query="update formats set format_status=1 where id=$format_id";
    }
    mysqli_query($conn,$delete_query);

    header('location:../edit-template-all.php');
}

else{
    header('location:../index.php');
}

?>