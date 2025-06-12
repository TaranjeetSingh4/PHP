<?php

require_once("config.php");
session_start();



if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    // echo "$MESSAGE_API_URL";

   
    $userid=$_GET['id'];
    $query="select * from user where id=$userid";
   
    $result=mysqli_query($conn,$query);
    $row_data=mysqli_fetch_assoc($result);
    $email=$row_data['email'];
    
    $password=$row_data['password'];
    $mobile_number=$row_data['phone'];
    

    $text="Dear User,
    You are requested to login on mis.dgmhup.in through your username '$email' and password '$password' -UPDGMH IT Cell";
    $endpoint = 'https://amazesms.in/api/pushsms';
    $params = array('user' => 'UPDGMH','authkey'=>'92nHRwgOCN0HU','sender'=>'UPDGMH','mobile'=>$mobile_number,'text'=>$text,'entityid'=>1001959722217619726,'templateid'=>1007457145690409545);
    $url = $endpoint . '?' . http_build_query($params);
   
    
    $curl = curl_init($url);

    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_VERBOSE, true);

    $output = curl_exec($curl);

    $error_no=curl_errno($curl);

    if(curl_exec($curl) === false){ echo 'Curl error: ' . print_r(curl_errno($curl)); }
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($httpcode==200 && $error_no==0){
        unset($_SESSION['alert_msg']);
        $_SESSION['alert_msg']="Message Sent Successfully!";
        $_SESSION['alert-type']="success";
    }
    else{
        unset($_SESSION['alert_msg']);
        $_SESSION['alert_msg']="Something Went Wrong !";
        $_SESSION['alert-type']="danger";
    }

    header('location:../add-user.php');    

    
}

else{
    header('location:../index.php');
}


?>