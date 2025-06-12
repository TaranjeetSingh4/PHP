<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    try{
        $conn=get_db_connection();
        $role=$_SESSION['login_user_role'];
        $query="SELECT * FROM `formats` join format_mapping on formats.id=format_mapping.format_id where FIND_IN_SET('$role', format_mapping.role_id) > 0";
        $formats_result=mysqli_query($conn,$query);

    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }

        
   
}
else{
    header('location:../index.php');
}


?>