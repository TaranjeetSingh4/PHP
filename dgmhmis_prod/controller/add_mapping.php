<?php
require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    try{
        $conn=get_db_connection();
        $format_id=$_POST['format'];
        $roles_id_array=$_POST['roles'];
        $roles_string = implode(',', $roles_id_array);
        $status=1;
        $date=date('Y-m-d H:i:s');
        $select_query="select * from format_mapping where format_id=$format_id";
        $check_result=mysqli_query($conn,$select_query);
        if(mysqli_num_rows($check_result)>0){
            
            unset($_SESSION['alert-msg']);
            $_SESSION['alert-msg']="Format already Mapped! Please Edit The format mapping below";
            $_SESSION['alert-type']="success";
        }
        else{
            
                $query="INSERT INTO format_mapping(role_id,format_id,status,created_at) VALUES('$roles_string','$format_id','$status','$date')";
                if(mysqli_query($conn,$query)){
                    $say=true;
                }
                else{
                    $say=false;
                }
            

            if($say){
                unset($_SESSION['alert-msg']);
                $_SESSION['alert-msg']="Format Mapped Successfully!";
                $_SESSION['alert-type']="success";
            }
            else{
                unset($_SESSION['alert-msg']);
                $_SESSION['alert-msg']="Something went wrong!!";
                $_SESSION['alert-type']="danger";
                echo "$query";
            }
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