<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $id=$_POST['id'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $designation=$_POST['designation'];
        $facility_name=$_POST['facility_name'];
	$district_id=$_POST['district_id'];
        $division_id=$_POST['division_id'];
        // $role_array=$_POST['role'];
        // $role_string=implode(",",$role_array);
        $role=$_POST['role'];
        $query="UPDATE user set `name`='$name',`email`='$email',`phone`='$phone',`designation`='$designation', `facility_name`='$facility_name',`division_id`='$division_id', `district_id`='$district_id'  where id=$id";
        $res=mysqli_query($conn,$query);
        $mapping_query="UPDATE role_mapping set role_id='$role' where user_id=$id";
        $res_mapping=mysqli_query($conn,$mapping_query);
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
