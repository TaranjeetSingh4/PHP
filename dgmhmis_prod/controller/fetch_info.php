<?php

require_once("config.php");
session_start();



if(isset($_SESSION['email'])){
    $conn=get_db_connection();


    function getAllFormatListing(){
        $sql="select * from formats order by format_name ASC";
    
        $result=mysqli_query($GLOBALS['conn'],$sql);
       
        return $result;
    }


    function getActiveFormatListing(){
        $sql="select * from formats where format_status=1 order by format_name ASC";
        $result=mysqli_query($GLOBALS['conn'],$sql);
        return $result;
    }

    function getDeactiveFormatListing(){
        $sql="select * from formats where format_status=0 order by format_name ASC";
        $result=mysqli_query($GLOBALS['conn'],$sql);
        return $result;
    }


    if(isset($_GET['value'])){
        
        if($_GET['value']=='active'){
            $function_result=getActiveFormatListing();
        }
        else if($_GET['value']=='inactive'){
            $function_result=getDeactiveFormatListing();
        }
        else{
            $function_result=getAllFormatListing();
        }
        $filter_final_result=[];
        while($row_result=mysqli_fetch_assoc($function_result)){
            $filter_final_result[]=$row_result;
        }

        print_r(json_encode($filter_final_result));

        // print_r(json_encode($filter_final_result));
    }


       
}

else{
    header('location:../index.php');
}


?>