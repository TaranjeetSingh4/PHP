<?php

require_once("config.php");
session_start();
$conn=get_db_connection();

if(isset($_SESSION['email'])){
    $format_id=$_GET['id'];
    $sql="SELECT formats.id as format_id,format_fields.id as field_id,format_name,format_heading,field_name,field_type,format_status FROM `formats` inner join format_fields on formats.id=format_fields.format_id where formats.id=$format_id";
    
    $result=mysqli_query($conn,$sql);


    $format_name_query="SELECT * from formats where id=$format_id";

    $format_name_result=mysqli_query($conn,$format_name_query);
    $format_name_row=mysqli_fetch_assoc($format_name_result);

    $sql="SELECT * from format_sections where format_id=$format_id";
    $result_section=mysqli_query($conn,$sql);
    
}

else{
    header('location:../index.php');
}


?>
