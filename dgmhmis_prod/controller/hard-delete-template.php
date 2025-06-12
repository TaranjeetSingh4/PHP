<?php

require_once("config.php");

session_start();

if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $format_id=$_GET['id'];
    
    $delete_query="delete from formats where id=$format_id";
    mysqli_query($conn,$delete_query);

    header('location:../edit-template-all.php');
}

else{
    header('location:../index.php');
}

?>