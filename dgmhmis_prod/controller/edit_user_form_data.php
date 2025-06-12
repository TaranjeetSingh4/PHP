<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $user_id=$_SESSION['id'];
    $role_id=$_SESSION['login_user_role'];
    $format_id=$_POST['format_id'];

    // $currentDate = new DateTime();
    // $currentDate->modify('-1 month');
    // $year = $currentDate->format('Y');
    // $month = $currentDate->format('m');

    $month=date('m');
    $year=date('Y');



    if(isset($_POST['date']) && $_POST['date']){
        $date = new DateTime($_POST['date']);

        // Extract the year and month
        $year = $date->format('Y');
        $month = $date->format('m');

        $data_date=$_POST['date'];
    }
    else{
        $currentMonth=date('m');
        $currentYear=date('Y');
        $month=(isset($_POST['month']) && (!empty($_POST['month']))) ? $_POST['month'] : "$currentMonth";
        $year=(isset($_POST['year'])  && (!empty($_POST['year']))) ? $_POST['year'] : "$currentYear";      
    }


    // $currentDate = date('Y-m-d H:i:s');


        // normal fields data starts
        $field_ids_array=$_POST['field_ids'];
        $field_ids_value_array=$_POST['field_names'];
        if($_POST['field_ids']){
        foreach($field_ids_array as $key=>$value){
            $field_id=$value;
            $field_value=$field_ids_value_array[$key];
            $sub_field_id=0;
            $update_query="update user_filled_data set value='$field_value' where user_id=$user_id and role_id=$role_id and format_id=$format_id and month=$month and year=$year and field_id=$field_id";
            // $insert_query="insert into user_filled_data(user_id,role_id,format_id,field_id,sub_field_id,value,month,year,created_at) VALUES('$user_id','$role_id','$format_id','$field_id','$sub_field_id','$field_value','$month','$year','$currentDate')";
            
            mysqli_query($conn,$update_query);
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
            $update_query="update user_filled_data set value='$sub_field_value' where user_id=$user_id and role_id=$role_id and format_id=$format_id and month=$month and year=$year and sub_field_id=$sub_field_id";
            // $insert_query="insert into user_filled_data(user_id,role_id,format_id,field_id,sub_field_id,value,month,year,created_at) VALUES('$user_id','$role_id','$format_id','$field_id','$sub_field_id','$sub_field_value','$month','$year','$currentDate')";
            
            mysqli_query($conn,$update_query);
        }

        
        
        // sub fields data ends
    
        $_SESSION['alert-msg']="Data Updated Successfully!";
        $_SESSION['alert-type']="success";
    }


    

    header("location:../format-template-view.php?id=". urlencode($format_id));
    exit();
    


   
}
else{
    header('location:../index.php');
}


?>
