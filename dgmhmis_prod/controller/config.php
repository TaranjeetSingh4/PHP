<?php

function get_db_connection($db_host='localhost',$db_user='root',$db_password='',$db_name='template_servers_new'){
    $conn = mysqli_connect($db_host,$db_user,$db_password,$db_name);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

?>
