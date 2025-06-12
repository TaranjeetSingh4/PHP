<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    // $user_id=$_SESSION['id'];
    // $role_id=$_SESSION['login_user_role'];
    
   
    // $user_id=$_GET['user_id'];
   
    
    // $role_id=$_GET['role_id'];
    
    // $month=$_GET['month'];

    // $year=$_GET['year'];

    if(isset($_GET['date']) && $_GET['date']){
      
        $date = new DateTime($_GET['date']);

        // Extract the year and month
        $year = $date->format('Y');
        $month = $date->format('m');

        $date_new=$_GET['date'];
    }
    else{
        //if(isset($_GET['month']) && $_GET['month'] && isset($_GET['year']) && $_GET['year']){
            //$month=$_GET['month'];
          //  $year=$_GET['year'];
    
        //}
      //  else{
    //        $month='09';
  //          $year=2024;
//        }



	        $currentMonth=date('m');
            $currentYear=date('Y');
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $month=(isset($_POST['month']) && (!empty($_POST['month']))) ? $_POST['month'] : "$currentMonth";
                $year=(isset($_POST['year'])  && (!empty($_POST['year']))) ? $_POST['year'] : "$currentYear";  
            }
            else{
                $month=(isset($_GET['month']) && (!empty($_GET['month']))) ? $_GET['month'] : "$currentMonth";
                $year=(isset($_GET['year'])  && (!empty($_GET['year']))) ? $_GET['year'] : "$currentYear";  
            }
    }




    

    
    


    // if((!$month) || (!$year)){
    //     $currentDate = new DateTime();

    //     // Subtract one month from the current date
    //     $currentDate->modify('-1 month');
    
    //     // Get the year and month from the modified DateTime object
    //     // $year = $currentDate->format('Y');
    //     // $month = $currentDate->format('m');
    //     $month='05';
    //     $year=2024;
    // }

    if(isset($_GET['user_id']) && $_GET['user_id']){
        $user_id=$_GET['user_id'];
    }

    if(isset($_GET['role_id']) && $_GET['role_id']){
        $role_id=$_GET['role_id'];
    }

    // if(isset($_GET['role']) && $_GET['role']){
    //     $role=$_GET['role'];
    // }

  



    $format_id=$_GET['id'];
    
    if(isset($_GET['district_id']) && $_GET['district_id']){
        $district_id=$_GET['district_id'];
    }
    else{
        $district_id=$_SESSION['district_id'];
    }
    // $month=date("m",strtotime("-1 Month"));
    // $year=date("Y",strtotime("-1 Month"));
    $format_name_query="select * from formats where id=$format_id";
    
    if(($_SESSION['user_role']=="DNO")){
        $normal_field_query="select * from (SELECT uf.*,f.format_name as format_name FROM `user_filled_data` as uf join formats as f on uf.format_id=f.id where uf.user_id='$user_id' and uf.role_id='$role_id' and uf.format_id='$format_id' and uf.month=$month and uf.year=$year) as t right join format_fields as ff on t.field_id=ff.id where ff.format_id=$format_id";

        $sub_field_query="select * from (SELECT uf.*,f.format_name as format_name FROM `user_filled_data` as uf join formats as f on uf.format_id=f.id where uf.user_id='$user_id' and uf.role_id='$role_id' and uf.format_id='$format_id' and uf.month=$month and uf.year=$year) as t right join format_sections as fs on t.sub_field_id=fs.id where fs.format_id=$format_id";

       
    }

    else if(isset($role_id) && ($role_id!="DNO") && ($role_id!=13) && isset($user_id)){
        $normal_field_query="select * from (SELECT uf.*,f.format_name as format_name FROM `user_filled_data` as uf join formats as f on uf.format_id=f.id where uf.user_id='$user_id' and uf.role_id='$role_id' and uf.format_id='$format_id' and uf.month=$month and uf.year=$year) as t right join format_fields as ff on t.field_id=ff.id where ff.format_id=$format_id";

        $sub_field_query="select * from (SELECT uf.*,f.format_name as format_name FROM `user_filled_data` as uf join formats as f on uf.format_id=f.id where uf.user_id='$user_id' and uf.role_id='$role_id' and uf.format_id='$format_id' and uf.month=$month and uf.year=$year) as t right join format_sections as fs on t.sub_field_id=fs.id where fs.format_id=$format_id";

       
    }

    

    else{
        $normal_field_query="select * from (SELECT m.district_name,ufd.district_id,ufd.field_id, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS value, f.format_name as format_name, ufd.month, ufd.year FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id WHERE ufd.district_id=$district_id and ufd.format_id = $format_id AND ufd.month=$month AND ufd.year=$year GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year) as t right join format_fields as ff on t.field_id=ff.id where ff.format_id=$format_id";
   
    
        $sub_field_query="select * from (SELECT m.district_name,ufd.district_id,ufd.field_id,ufd.sub_field_id, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS value, f.format_name as format_name, ufd.month, ufd.year FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id WHERE ufd.district_id=$district_id and ufd.format_id = $format_id AND ufd.month=$month AND ufd.year=$year GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year) as t right join format_sections as fs on t.sub_field_id=fs.id where fs.format_id=$format_id";
    }
   
    
   
  
    $normal_field_result=mysqli_query($conn,$normal_field_query);
    $normal_field_array=[];
    while($row=mysqli_fetch_assoc($normal_field_result)){
        $normal_field_array[]=$row;
    }


    $sub_field_result=mysqli_query($conn,$sub_field_query);
    $sub_field_array=array();

    while($sub_field_row=mysqli_fetch_assoc($sub_field_result)){

        $sub_field_sub_array=array();
        
        $sub_field_sub_array['format_id']=$sub_field_row['format_id'];
        $sub_field_sub_array['section_name']=$sub_field_row['section_name'];
        $sub_field_sub_array['sub_field_id']=$sub_field_row['sub_field_id'];
        $sub_field_sub_array['sub_field_name']=$sub_field_row['sub_field_name'];
        $sub_field_sub_array['sub_field_type']=$sub_field_row['sub_field_type'];
        $sub_field_sub_array['value']=$sub_field_row['value'];
        
        $section_name=$sub_field_row['section_name'];
        if (!isset($sub_field_array[$section_name])) {
            // If it does not exist, initialize it as an empty array
            $sub_field_array[$section_name] = [];
        }
        
        $sub_field_array[$section_name][]=$sub_field_sub_array;
    }

    $name_result=mysqli_query($conn,$format_name_query);
    $name_row=mysqli_fetch_assoc($name_result);

    // $url = "../edit-format-data.php?id=$id&user_id=$user_id&role_id=$role_id&date=$date";
    // // header("location:../edit-format-data.php");
    // header("Location: " . $url);

   

}
else{
    header('location:../index.php');
}


?>
