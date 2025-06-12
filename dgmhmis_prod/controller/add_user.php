<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();

        function generateRandomPassword($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomPassword = '';
            
            for ($i = 0; $i < $length; $i++) {
                $randomPassword .= $characters[rand(0, $charactersLength - 1)];
            }
            
            return $randomPassword;
        }

        if($_SESSION['user_role']=="CMO"){
            $is_added_by_cmo=1;
        }
        else{
            $is_added_by_cmo=0;
        }

      
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $division_id=$_POST['division_id'];
        $district_id=$_POST['district_id'];
        $designation=$_POST['designation'];
        $facility_name=$_POST['facility_name'];
        // $role_array=$_POST['role'];
        $role_id=$_POST['role'];
        // $roles_string = implode(',', $role_array);
        $date=date("Y-m-d h:i:s");
        // $password=strtolower($designation)."@123";
        $password = generateRandomPassword(10); 



        $requiredFields = [
            'name', 'email', 'phone', 'division_id',
            'district_id', 'designation', 'facility_name','role'
        ];

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {

                $_SESSION['alert_msg']="This '$field' is required.";
                $_SESSION['alert-type']="warning";
                exit;
                die;
            }
        }

        $email = trim($_POST['email']); // Remove leading and trailing spaces

        if (empty($email)) {
            $_SESSION['alert_msg']="Email is required.";
            $_SESSION['alert-type']="warning";
            exit;
            die;
        } elseif (strpos($email, ' ') !== false) {
            $_SESSION['alert_msg']="Email should not contain spaces";
            $_SESSION['alert-type']="warning";
            exit;
            die;
            
        } elseif (strpos($email, ',') !== false) {
            $_SESSION['alert_msg']="Email should not contain commas.";
            $_SESSION['alert-type']="warning";
            exit;
            die;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['alert_msg']="Invalid email format.";
            $_SESSION['alert-type']="warning";
            exit;
            die;
            
        } else {
            echo "Email is valid.";
        }

        $already_exists_check="select * from user where email='$email' or phone='$phone'";
        $check_result=mysqli_query($conn,$already_exists_check);
        if(mysqli_num_rows($check_result)>0){
            $_SESSION['alert-type']="info";
            $_SESSION['alert_msg']="User Already Exists!";
        }
        else{
            $query="INSERT INTO user(`name`,`email`,`phone`,`designation`,`password`,`division_id`,`district_id`,`facility_name`,`is_added_by_cmo`,`created_at`) VALUES('$name','$email','$phone','$designation','$password','$division_id','$district_id','$facility_name','$is_added_by_cmo','$date')";

            if(mysqli_query($conn,$query)){

                $get_user="select id from user where email='$email'";
                $get_user_result=mysqli_query($conn,$get_user);
                $row_user=mysqli_fetch_assoc($get_user_result);
                $user_id=$row_user['id'];
                
                $query="INSERT INTO role_mapping(`user_id`,`role_id`,`created_at`) VALUES('$user_id','$role_id','$date')";
                 mysqli_query($conn,$query);
                
                $_SESSION['alert-type']="success";
                $_SESSION['alert_msg']="User Created Successfully!";
            }
            else{
                $_SESSION['alert-type']="danger";
                $_SESSION['alert_msg']="Something Went Wrong !";
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