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
            if($_SESSION['user_role']=="CMO"){
                $district_id=$_SESSION['district_id'];
            }
            else{
                $district_id="";
            }
            
        }
        
        
       
       
        if(isset($_POST['date']) && $_POST['date']){
            $formattedDate = $_POST['date']; 
            // $dateObj = DateTime::createFromFormat('d-m-Y', $selectedDate);
            // $formattedDate = $dateObj->format('Y-m-d');
        }
        else{
            $formattedDate = date('Y-m-d');
        }

       

        
        
       
        
        if(($district_id) && (!empty($district_id))  && empty($_POST['date'])){
            // only district
            $query="SELECT 
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
            AND DATE(o.created_at) = '$formattedDate'
        ORDER BY 
            o.created_at DESC  ";

            
        }
        else if(empty($district_id) && $_POST['date']){
            // only date
            // $query="SELECT m.district_name,ufd.district_id, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name as user_name,ufd.role_id,roles.role, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.format_id,ufd.month, ufd.year,ufd.status FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id left join roles on ufd.role_id=roles.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year GROUP BY ufd.district_id,ufd.format_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id,ufd.status,ufd.role_id";



            $query="SELECT 
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
           DATE(o.created_at) = '$formattedDate'
        ORDER BY 
            o.created_at DESC  ";

          
        }
        else if(($district_id) && (!empty($district_id)) && $_POST['date']){
           
            // district and date
            $query="SELECT 
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
            AND DATE(o.created_at) = '$formattedDate'
        ORDER BY 
            o.created_at DESC  
        
         ";

          
        }
        else{
            $query="SELECT 
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
            MONTH(o.created_at) = (SELECT MONTH(MAX(created_at)) FROM outsourcing_data) AND
            YEAR(o.created_at) = (SELECT YEAR(MAX(created_at)) FROM outsourcing_data)

        ORDER BY 
            o.created_at DESC  ";

        }
        
    
        $filter_result=mysqli_query($conn,$query);
        
        
        
        $filter_report_result=[];
        $stats=[];
        if(mysqli_num_rows($filter_result)>0){
            while($report_row=mysqli_fetch_assoc($filter_result)){

                $filter_report_result[]=$report_row;
                // print_r($filter_report_result);
               

                // if($report_row['user_id']){
                //     $filter_report_result[$report_row['user_id']]=$report_row;
                // }
                // else{
                //     $stats[$report_row['status']]=$report_row['status'];
                //     $report_row['role_id']=13;
                //     if(sizeof($stats)==1){
                //         $report_row['status']=$report_row['status'];
                //     }
                //     else{
                //         $report_row['status']=3;
                //     }
                //     $filter_report_result[$report_row['district_id']]=$report_row;
                // }
                
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
