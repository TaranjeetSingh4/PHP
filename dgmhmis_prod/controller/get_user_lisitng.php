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
        // else{
        //     $sql="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where FIND_IN_SET('13', role_id) > 0";
        // }
        else{
            $sql="SELECT user.id as userid,user.*, master_district.*, role_mapping.*,
    (SELECT COUNT(DISTINCT(u.id)) 
     FROM user u
     LEFT JOIN role_mapping rm ON u.id = rm.user_id
     WHERE u.district_id = user.district_id
     AND rm.role_id != 13
    ) AS total_district_user_count,

    (SELECT COUNT(DISTINCT(u.id)) 
     FROM user u
     JOIN user_filled_data ufd ON u.id = ufd.user_id
     WHERE u.district_id = user.district_id
     AND ufd.month = $month
     AND ufd.year = $year
    ) AS filled_data_user_count,

    CASE
        WHEN (SELECT COUNT(DISTINCT(u.id)) 
              FROM user u
              JOIN user_filled_data ufd ON u.id = ufd.user_id
              WHERE u.district_id = user.district_id
              AND ufd.month = $month 
              AND ufd.year = $year
             ) = 0 THEN 'not filled'
        WHEN (SELECT COUNT(DISTINCT(u.id)) 
              FROM user u
              JOIN user_filled_data ufd ON u.id = ufd.user_id
              WHERE u.district_id = user.district_id
              AND ufd.month = $month
              AND ufd.year = $year
             ) < (SELECT COUNT(DISTINCT(u.id)) 
                  FROM user u
                  LEFT JOIN role_mapping rm ON u.id = rm.user_id
                  WHERE u.district_id = user.district_id
                  AND rm.role_id != 13
                 ) THEN 'partially filled'
        ELSE 'filled'
    END AS status

FROM user 
JOIN role_mapping ON user.id = role_mapping.user_id
JOIN master_district ON user.district_id = master_district.id
WHERE FIND_IN_SET('13', role_mapping.role_id) > 0
             ";
            }
        
            
            // print_r($sql);
            $result=mysqli_query($conn,$sql);
            $final_result=[];
            while($row=mysqli_fetch_assoc($result)){
                $roles_string=$row['role_id'];
                // print_r($roles_string);
                $roles_array=explode(",",$roles_string);
                $final_role=[];
                foreach($roles_array as $key=>$value){
                    $query="select role from roles where id=$value";
                    $roles_result=mysqli_query($conn,$query);
                    $roles_row=mysqli_fetch_assoc($roles_result);
                    $final_role[]=$roles_row['role'];
                }

                $row['roles_array']=implode(",",$final_role);
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
