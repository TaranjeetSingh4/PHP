<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        if($_SESSION['user_role']=="DNO"){
            $query="select * from roles where status=1 and is_dno=1 order by role asc";
        }
        else if($_SESSION['user_role']=="CMO"){
            $query="select * from roles where status=1 and is_cmo=1 order by role asc";
        }
        else{
            $query="select * from roles where status=1 order by role asc";
        }
        
        $active_role_result=mysqli_query($conn,$query);
       
        if(mysqli_num_rows($active_role_result)>0){
            $final_active_roles_result=$active_role_result;
        }
        else{
            $final_active_roles_result=[];
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