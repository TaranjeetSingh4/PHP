<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $user_id=$_SESSION['id'];
    $role_id=$_SESSION['login_user_role'];
    $format_id=$_POST['format_id'];
    $district_id=$_SESSION['district_id'];
    $currentDate = date('Y-m-d H:i:s');



    print_r($_POST);

    // date data starts
    $dateString=$_POST['filled_data_month_year'];
    $date = DateTime::createFromFormat('m/d/Y', $dateString);
    if ($date) {
        // Extract the month
        $month = $date->format('m');
        // Extract the year
        $year = $date->format('Y');
    }

    $select_query="select * from user_filled_data where user_id='$user_id' and format_id='$format_id' and role_id='$role_id' and month='$month' and year='$year'";
    $check_result=mysqli_query($conn,$select_query);
    if(mysqli_num_rows($check_result)>0){
        $_SESSION['alert-msg']="You have already submitted the form! You can edit the form.";
        $_SESSION['alert-type']='danger';
    }

    // date data ends

    else{
        // normal fields data starts
        $field_ids_array=$_POST['field_ids'];
        $field_ids_value_array=$_POST['field_names'];
        if($_POST['field_ids']){
        foreach($field_ids_array as $key=>$value){
            $field_id=$value;
            $field_value=$field_ids_value_array[$key];
            $sub_field_id=0;
    
            $insert_query="insert into user_filled_data(user_id,role_id,format_id,field_id,sub_field_id,value,month,year,district_id,created_at) VALUES('$user_id','$role_id','$format_id','$field_id','$sub_field_id','$field_value','$month','$year','$district_id','$currentDate')";
            
            mysqli_query($conn,$insert_query);
        }
        // normal fields data ends
        }
    
        // sub fields data starts
        if($_POST['section_sub_field_ids']){
        $sub_field_ids_array=$_POST['section_sub_field_ids'];
        $sub_field_ids_value_array=$_POST['section_sub_field_names'];
        foreach($sub_field_ids_array as $key=>$value){
            $sub_field_id=$value;
            $sub_field_value=$sub_field_ids_value_array[$key];
            $field_id=0;
    
            $insert_query="insert into user_filled_data(user_id,role_id,format_id,field_id,sub_field_id,value,month,year,district_id,created_at) VALUES('$user_id','$role_id','$format_id','$field_id','$sub_field_id','$sub_field_value','$month','$year','$district_id','$currentDate')";
            
            mysqli_query($conn,$insert_query);
        }
        }
        
        // sub fields data ends
    
        $_SESSION['alert-msg']="Form Submitted Successfully!";
        $_SESSION['alert-type']="success";
    }


    

    header("location:../format-template-view.php?id=". urlencode($format_id));
    exit();
    


   
}
else{
    header('location:../index.php');
}


?>