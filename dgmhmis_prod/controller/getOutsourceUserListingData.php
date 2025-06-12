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

    $user_id=$_SESSION['id'];
    

    // $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=07 and t1.year=2024) t3 join master_district on master_district.id = t3.district_id";
    if($_SESSION['user_role']=="admin"){
    $sql="SELECT 
                o.id as 'row_id',
                o.*,
                -- o.hospital_name,
                -- o.hospital_address,
                -- o.employee_name,
                -- o.father_husband_name,
                -- o.aadhar_card,
                -- o.mobile_no,
                -- o.designation,
                -- o.gender,
                -- o.grade,
                -- o.employee_category,
                -- o.skilled_unskilled,
                -- o.joining_date,
                -- o.agency_name,
                -- o.minimum_wage,
                -- o.epf,
                -- o.esi,
                -- o.gross,
                -- o.total_cost,
                -- o.agency_charge_percent,
                -- o.gst_percent,
                -- o.grand_total,
                -- o.post_type,
                -- o.sanctioned_post,
                -- o.remarks,
                -- o.government_orders,
                -- o.added_by_user_id,
                -- o.district_id,
                -- o.created_at,  
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
              MONTH(o.created_at) = (SELECT MONTH(MAX(created_at)) FROM outsourcing_data)
              YEAR(o.created_at) = (SELECT YEAR(MAX(created_at)) FROM outsourcing_data)
            ORDER BY 
                o.created_at DESC  
            ";
    }
    else if($_SESSION['user_role']=="CMO"){
        $sql="SELECT 
                o.id as 'row_id',
                o.*,
                -- o.hospital_name,
                -- o.hospital_address,
                -- o.employee_name,
                -- o.father_husband_name,
                -- o.aadhar_card,
                -- o.mobile_no,
                -- o.designation,
                -- o.gender,
                -- o.grade,
                -- o.employee_category,
                -- o.skilled_unskilled,
                -- o.joining_date,
                -- o.agency_name,
                -- o.minimum_wage,
                -- o.epf,
                -- o.esi,
                -- o.gross,
                -- o.total_cost,
                -- o.agency_charge_percent,
                -- o.gst_percent,
                -- o.grand_total,
                -- o.post_type,
                -- o.sanctioned_post,
                -- o.remarks,
                -- o.government_orders,
                -- o.added_by_user_id,
                -- o.district_id,
                -- o.created_at,  
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
                
                o.district_id  = $district_id
                AND MONTH(o.created_at) = (SELECT MONTH(MAX(created_at)) FROM outsourcing_data WHERE district_id = $district_id)
                AND YEAR(o.created_at) = (SELECT YEAR(MAX(created_at)) FROM outsourcing_data WHERE district_id = $district_id)

            ORDER BY 
                o.created_at DESC  
            
             ";
    }
    else{
        $sql="SELECT 
                o.id as 'row_id',
                o.*,
                -- o.hospital_name,
                -- o.hospital_address,
                -- o.employee_name,
                -- o.father_husband_name,
                -- o.aadhar_card,
                -- o.mobile_no,
                -- o.designation,
                -- o.gender,
                -- o.grade,
                -- o.employee_category,
                -- o.skilled_unskilled,
                -- o.joining_date,
                -- o.agency_name,
                -- o.minimum_wage,
                -- o.epf,
                -- o.esi,
                -- o.gross,
                -- o.total_cost,
                -- o.agency_charge_percent,
                -- o.gst_percent,
                -- o.grand_total,
                -- o.post_type,
                -- o.sanctioned_post,
                -- o.remarks,
                -- o.government_orders,
                -- o.added_by_user_id,
                -- o.district_id,
                -- o.created_at,  
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
                o.added_by_user_id = $user_id  
                AND o.district_id  = $district_id
                AND MONTH(o.created_at) = (SELECT MONTH(MAX(created_at)) FROM outsourcing_data WHERE added_by_user_id = $user_id AND district_id = $district_id)
                AND YEAR(o.created_at) = (SELECT YEAR(MAX(created_at)) FROM outsourcing_data WHERE added_by_user_id = $user_id AND district_id = $district_id)
            ORDER BY 
                o.created_at DESC  
            
             ";
    }

   
    
    $report_result=mysqli_query($conn,$sql);

    
    $report_array=[];
    $stats=[];
    if(mysqli_num_rows($report_result)>0){
        while($report_row=mysqli_fetch_assoc($report_result)){
           $report_array[]=$report_row;
            
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
