<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $format_id=$_POST['format_id'];
        $roles_id_array=$_POST['roles'];
        $status=1;
        $date=date('Y-m-d H:i:s');
        $role_ids_string=implode(",", $roles_id_array);
        $query="UPDATE format_mapping set `role_id`='$role_ids_string', `updated_at`='$date' where format_id=$format_id";
        $res=mysqli_query($conn,$query);
        if($res){
            unset($_SESSION['alert-msg']);
            $_SESSION['alert-msg']="Format Mapping Updated Successfully!!";
            $_SESSION['alert-type']="success";
            header('location:../mapping-template.php');
        }   
        else{
            unset($_SESSION['alert-msg']);
            $_SESSION['alert-msg']="Something Went Wrong!!";
            $_SESSION['alert-type']="danger";
            header('location:../mapping-template.php');
        }
        
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>