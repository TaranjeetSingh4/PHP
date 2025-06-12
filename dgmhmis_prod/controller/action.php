<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
   
    $format_name=$_POST['format_name'];
    $format_heading=$_POST['format_heading'];
    $format_insert_sql="INSERT INTO formats(format_name,format_heading,format_status) VALUES('$format_name','$format_heading',1)";
    mysqli_query($conn,$format_insert_sql);
    $date=date("Y-m-d h:i:s");
    $get_id_query="select id from formats where format_name='$format_name'";
    $res=mysqli_query($conn,$get_id_query);

    if(mysqli_num_rows($res) > 0){
        $row=mysqli_fetch_assoc($res);
        $format_id=$row['id'];
        foreach($_POST['field_name'] as $key=>$value){
            $field_type=$_POST['field_type'][$key];
            $sql="insert into format_fields(format_id,field_name,field_type) values('$format_id','$value','$field_type')";
            mysqli_query($conn,$sql);
        
        }

        if(isset($_POST['section_name'])){
            foreach($_POST['section_name'] as $key=>$value){
                $sub_field_name=$_POST['sub_field_name'][$key];
                $sub_field_type=$_POST['sub_field_type'][$key];
               
                $sql="insert into format_sections(format_id,section_name,sub_field_name,sub_field_type,created_at) values($format_id,'$value','$sub_field_name','$sub_field_type','$date')";
                mysqli_query($conn,$sql);

                
            }
        }

        // header('location:../dashboard.php');
        
    }
    else{
        echo "Something went wrong!";
    }
}
else{
    header('location:../index.php');
}


?>