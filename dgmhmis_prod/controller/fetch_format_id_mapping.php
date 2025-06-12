<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $format_id=$_GET['id'];
        $select_query="SELECT * FROM `format_mapping` where format_id=$format_id";
        $mapping_result=mysqli_query($conn,$select_query); 
        $mapping_data_row=mysqli_fetch_assoc($mapping_result);
        $roles_array=explode(",",$mapping_data_row['role_id']);
        
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>