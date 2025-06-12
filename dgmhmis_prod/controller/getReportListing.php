<?php

require_once("config.php");
session_start();



if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    
    // $currentYear= date('Y');
    // $currentMonth=date('m');
    $currentDate = new DateTime();

    // Subtract one month from the current date
    $currentDate->modify('-1 month');
    
    // Get the previous month and year
    $previousMonth = $currentDate->format('m'); // Format as numeric month (01-12)
    $previousYear = $currentDate->format('Y');

   

    $district_id=$_SESSION['district_id'];

    // $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=07 and t1.year=2024) t3 join master_district on master_district.id = t3.district_id";
    if($_SESSION['user_role']=="admin"){
    $query="SELECT m.district_name,ufd.district_id, ufd.format_id,concat('DNO ',m.district_name) as user_name, 'DNO' as role, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year ,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id WHERE ufd.format_id = 15 AND ufd.month=$previousMonth AND ufd.year=$previousYear GROUP BY ufd.district_id,ufd.format_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.status";
    }
    else{
        $query="SELECT m.district_name,ufd.district_id, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name as user_name,ufd.role_id,roles.role, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.format_id,ufd.month, ufd.year,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id left join roles on ufd.role_id=roles.id WHERE ufd.format_id = 15 AND ufd.month=$previousMonth AND ufd.year=$previousYear and ufd.district_id=$district_id GROUP BY ufd.district_id, ufd.format_id,ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id,ufd.status,ufd.role_id";
    }
    
    $report_result=mysqli_query($conn,$query);

    
    $report_array=[];
    $stats=[];
    if(mysqli_num_rows($report_result)>0){
        while($report_row=mysqli_fetch_assoc($report_result)){
            if($_SESSION['user_role']=="admin"){
                $stats[$report_row['status']]=$report_row['status'];
                if(sizeof($stats)==1){
                    $report_row['status']=$report_row['status'];
                }
                else{
                    $report_row['status']=3;
                }
                $report_array[$report_row['district_name']]=$report_row;
            }
            else{
                $report_array[$report_row['user_id']]=$report_row;
            }

           
            
            
        }
           
    }
    else{
        $report_array=[];
    }

  

    

   
}

else{
    header('location:../index.php');
}


?>
