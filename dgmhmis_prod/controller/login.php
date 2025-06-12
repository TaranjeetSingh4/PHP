<?php

require_once("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $conn = get_db_connection();
        
        $email=$_POST['email'];
        $password=$_POST['password'];

        
        $role=$_POST['role'];
        if(isset($email) && isset($password)){
            $sql_query = "SELECT user.*,role_mapping.role_id FROM user join role_mapping on user.id=role_mapping.user_id where user.email='$email' and user.password='$password'";
            
            $result = mysqli_query($conn, $sql_query);

            $role_query="select * from roles where id = $role";
            $role_result=mysqli_query($conn,$role_query);

            if(mysqli_num_rows($role_result)>0){
                $role_row=mysqli_fetch_assoc($role_result);
                $role_name=$role_row['role'];
            }
            else{
                $role_name="";
            }

            if(mysqli_num_rows($result) > 0){
                $row=mysqli_fetch_assoc($result);
                $role_string=$row['role_id'];
                $role_array=explode(",",$role_string);
                
                $user_email=$row['email'];
                $user_name=$row['name'];
                $user_id=$row['id'];
                $_SESSION['email']=$user_email;
                $_SESSION['username']=$user_name;
                $_SESSION['id']=$user_id;
                $_SESSION['role_array']=$row['role_id'];
                $_SESSION['login_user_role']=$role;
                $_SESSION['district_id']=$row['district_id'];
                $_SESSION['division_id']=$row['division_id'];
                $_SESSION['added_by_cmo']=$row['is_added_by_cmo'];
                $_SESSION['hospital_name']=$row['hospital_name'];
                $_SESSION['hospital_address']=$row['hospital_address'];

                
                

                // if($row['role']==12){
                //     header('Location:../dashboard.php');
            
                // }
                if(in_array($role,$role_array)){
                    if($role==12){
                        $_SESSION['user_role']='admin';
                        
                    }
                    else{
                        $_SESSION['user_role']=$role_name;
                    }
                    $login_time = date('Y-m-d H:i:s');

                    $sql = "INSERT INTO user_activity_log (user_id, login_time) VALUES ('$user_id', '$login_time')";
                    mysqli_query($conn,$sql);

                   if($row['is_added_by_cmo']==1){
                    if($row['first_time_login']==1){
                        header('Location:../outsource_dashboard.php');
                    }
                    else{
                        header('Location:../my-profile.php');
                    }
                    
                   }
                   else{
                    header('Location:../dashboard.php');
                   }            
                    
                }
                else{
                    $_SESSION['alert_msg']="Dashboard for role is in process";
                    header('location:../index.php');
                }
                

            }
            else{
                $_SESSION['alert_msg']="Invalid Credentials";
                header('location:../index.php');
            }
        }
        die;
        
        mysqli_close($conn);
    }
    catch(Exception $e) {
        http_response_code(500);
        echo json_encode(array("status" => FALSE, "message" => "Internal Server Error.", "status_code" => 500));
    }
}


?>