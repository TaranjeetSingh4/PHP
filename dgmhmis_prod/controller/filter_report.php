<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        if(isset($_POST['districts']) && $_POST['districts']){
            $district_id=$_POST['districts'];
        }
        else{
            if($_SESSION['user_role']=="DNO"){
                $district_id=$_SESSION['district_id'];
            }
            else{
                $district_id="";
            }
            
        }
        
        
        $format_id=$_POST['format_id'];
      
      
       
        if(isset($_POST['date']) && $_POST['date']){
            $date = new DateTime($_POST['date']);

            // Extract the year and month
            $year = $date->format('Y');
            $month = $date->format('m');
        }
        else{
         //   $month='09';
          //  $year=2024;
            $currentMonth=date('m');
            $currentYear=date('Y');
            $month=(isset($_POST['month']) && (!empty($_POST['month']))) ? $_POST['month'] : "$currentMonth";
            $year=(isset($_POST['year'])  && (!empty($_POST['year']))) ? $_POST['year'] : "$currentYear"; 
        }

        
        
       
        
        if(($district_id) && (!empty($district_id))  && empty($_POST['date'])){
            // only district
            $query="SELECT m.district_name,ufd.district_id, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name as user_name,ufd.role_id,roles.role, SUM(ufd.value) AS total_value, f.format_name as format_name,ufd.format_id,ufd.month, ufd.year,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id left join roles on ufd.role_id=roles.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year and ufd.district_id=$district_id GROUP BY ufd.district_id, ufd.format_id,ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id,ufd.status,ufd.role_id";

            
        }
        else if(empty($district_id) && $_POST['date']){
            // only date
            // $query="SELECT m.district_name,ufd.district_id, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name as user_name,ufd.role_id,roles.role, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.format_id,ufd.month, ufd.year,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id left join roles on ufd.role_id=roles.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year GROUP BY ufd.district_id,ufd.format_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id,ufd.status,ufd.role_id";



            $query="SELECT m.district_name,ufd.district_id, ufd.format_id,concat('DNO ',m.district_name) as user_name, 'DNO' as role, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year ,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year GROUP BY ufd.district_id,ufd.format_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.status";

          
        }
        else if(($district_id) && (!empty($district_id)) && $_POST['date']){
            // district and date
            $query="SELECT m.district_name,ufd.district_id, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name as user_name,ufd.role_id,roles.role, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.format_id,ufd.month, ufd.year,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id left join roles on ufd.role_id=roles.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year and ufd.district_id=$district_id GROUP BY ufd.district_id, ufd.format_id,ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id,ufd.status,ufd.role_id";

          
        }
        else{
            $query="SELECT m.district_name,ufd.district_id, ufd.format_id,concat('DNO ',m.district_name) as user_name, 'DNO' as role,'13' as role_id, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year ,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id WHERE ufd.format_id = 15 AND ufd.month=05 AND ufd.year=2024 GROUP BY ufd.district_id,ufd.format_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.status";

        }
        
    
        $filter_result=mysqli_query($conn,$query);
        
        
        
        $filter_report_result=[];
        $stats=[];
        if(mysqli_num_rows($filter_result)>0){
            while($report_row=mysqli_fetch_assoc($filter_result)){
                // print_r($filter_report_result);
               

                if($report_row['user_id']){
                    $filter_report_result[$report_row['user_id']]=$report_row;
                }
                else{
                    $stats[$report_row['status']]=$report_row['status'];
                    $report_row['role_id']=13;
                    if(sizeof($stats)==1){
                        $report_row['status']=$report_row['status'];
                    }
                    else{
                        $report_row['status']=3;
                    }
                    $filter_report_result[$report_row['district_id']]=$report_row;
                }
                
            }
               
        }
        else{
            $filter_report_result=[];
        }

        // print_r($filter_report_result);
        

        // print_r($query);
        // die;
        // print_r($filter_report_result);

        print_r(json_encode($filter_report_result));
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>
