<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $id=$_GET['id'];
        $query="delete from user where id=$id";
        $role_query="delete from role_mapping where user_id=$id";
        $user_filled_data_query="delete from user_filled_data where user_id=$id";
        mysqli_query($conn,$query);
        mysqli_query($conn,$role_query);
        mysqli_query($conn,$user_filled_data_query);
        header('location:../add-user.php');
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>