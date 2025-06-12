<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $old_pass=$_POST['old_password'];
    $new_pass=$_POST['new_password'];
    $conf_pass=$_POST['confirm_password'];
    $id=$_POST['id'];
    $select_query="select * from user where id=$id";
    $result=mysqli_query($conn,$select_query);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $saved_pass=$row['password'];
        if($old_pass==$saved_pass){
            if($new_pass==$conf_pass){
                $updated_query="UPDATE `user` SET `password` = '$new_pass' WHERE `user`.`id` = $id;";
                mysqli_query($conn,$updated_query);
		unset($_SESSION['email']);
                session_destroy();
                header('location:index.php');
                //echo "Password Changed Successfully!";
               // header('location:index.php');
                
            }
            else{
                echo "New & confirm password do not match";
            }
        }
        else{
            echo "Old Password is incorrect.";
        }
    }
    else{
        echo "Something went wrong!";
    }
}

else{
    header('location:../index.php');
}


?>
