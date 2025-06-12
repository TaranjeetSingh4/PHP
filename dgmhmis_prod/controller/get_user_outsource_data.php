<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();

        $month = date('m');
        $year = date('Y');

        if($_SESSION['user_role']=="DNO"){
            $district_id=$_SESSION['district_id'];
            // $sql="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id=$district_id and (not FIND_IN_SET('13', role_id) > 0)";

            $sql="SELECT DISTINCT(user.id) as userid, user.*, role_mapping.role_id, master_district.district_name,  CASE WHEN ufd.user_id IS NOT NULL THEN 'filled' ELSE 'not filled' END AS status FROM user JOIN role_mapping ON user.id = role_mapping.user_id JOIN master_district ON user.district_id = master_district.id  LEFT JOIN user_filled_data ufd ON user.id = ufd.user_id AND ufd.month = '$month' AND ufd.year = $year WHERE user.district_id = '$district_id' AND NOT FIND_IN_SET('13', role_mapping.role_id) > 0";
        }
        else if($_SESSION['user_role']=="CMO"){
            $district_id=$_SESSION['district_id'];
            // $sql="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id=$district_id and (not FIND_IN_SET('13', role_id) > 0)";

            $sql="SELECT DISTINCT(user.id) as userid, user.*, role_mapping.role_id, master_district.district_name,  CASE WHEN ufd.user_id IS NOT NULL THEN 'filled' ELSE 'not filled' END AS status FROM user JOIN role_mapping ON user.id = role_mapping.user_id JOIN master_district ON user.district_id = master_district.id  LEFT JOIN user_filled_data ufd ON user.id = ufd.user_id AND ufd.month = '$month' AND ufd.year = $year WHERE user.district_id = '$district_id' AND NOT FIND_IN_SET('13', role_mapping.role_id) > 0";
        }

        else{
            $sql="SELECT 
                o.hospital_name,
                o.hospital_address,
                o.employee_name,
                o.father_husband_name,
                o.aadhar_card,
                o.mobile_no,
                o.designation,
                o.grade,
                o.employee_category,
                o.skilled_unskilled,
                o.joining_date,
                o.agency_name,
                o.minimum_wage,
                o.epf,
                o.esi,
                o.gross,
                o.total_cost,
                o.agency_charge_percent,
                o.gst_percent,
                o.grand_total,
                o.post_type,
                o.sanctioned_post,
                o.remarks,
                o.added_by_user_id,
                o.district_id,
                o.created_at,  
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
                o.added_by_user_id = 313  
                AND o.district_id  
            ORDER BY 
                o.created_at DESC  
            LIMIT 1
             ";
            }
        
            
            // print_r($sql);
            $result=mysqli_query($conn,$sql);
            $final_result=[];
            while($row=mysqli_fetch_assoc($result)){
                $final_result[]=$row;
            }

            print_r(json_encode($final_result));

            // print_r(json_encode($final_result));
       
        
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>
