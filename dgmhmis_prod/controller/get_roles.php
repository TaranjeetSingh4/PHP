<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $query="select * from roles order by role asc";
        $result=mysqli_query($conn,$query);
        $role_result=[];
       
        if(mysqli_num_rows($result)>0){
            $final_result=$result;
            while($row=mysqli_fetch_assoc($result)){
                $role_result[]=$row;
            }
        }
        else{
            $final_result=[];
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