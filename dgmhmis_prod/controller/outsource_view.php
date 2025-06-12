<?php

require_once("config.php");
session_start();
$conn=get_db_connection();

if(isset($_SESSION['email'])){
    $row_id=$_GET['id'];
    $sql="SELECT 
                o.id as 'row_id', 
                o.*,
                m.district_name, 
                r.role,     
                u.name,
                u.email
            FROM 
                outsourcing_data o
            JOIN 
                user u ON o.added_by_user_id=u.id
            JOIN 
                master_district m ON o.district_id = m.id
            JOIN 
                roles r ON o.role_id = r.id
            WHERE 
                o.id = $row_id";
    
    $result=mysqli_query($conn,$sql);
    $data=mysqli_fetch_assoc($result);
    
}

else{
    header('location:../index.php');
}


?>
