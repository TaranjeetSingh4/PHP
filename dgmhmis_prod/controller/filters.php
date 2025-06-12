<?php

require_once("config.php");
session_start();



if(isset($_SESSION['email'])){
    $conn=get_db_connection();

   
    
    $designation=$_POST['designation'];
    $role=$_POST['role'];
    $district_id=$_POST['district_id'];


    if($_SESSION['user_role']=="DNO"){
        $district_id=$_SESSION['district_id'];
        if($designation && $role=="null"){
            //only designation filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.designation='$designation' and user.district_id=$district_id";
        }
        else if($role && $role!='null' && empty($designation)){
            //only role filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where  user.district_id=$district_id and FIND_IN_SET('$role', role_id) > 0";
        }
        else if($designation && $role){
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.designation='$designation' and user.district_id=$district_id and FIND_IN_SET('$role', role_id) > 0";
        }
        else if(!isset($designation) && $role=="null"){
            $query="select * from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id=$district_id";
        }
    
        else{
            $query="select * from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id=$district_id";
        }
    }

    else{
        if($designation && $role=="null" && $district_id=="null"){
            //only designation filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.designation='$designation'";
            
        }
        else if($role && $role!='null' && empty($designation) && $district_id=="null"){
            //only role filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where FIND_IN_SET('$role', role_id) > 0";

            // $query="SELECT DISTINCT(user.id) as userid, user.*, role_mapping.role_id, master_district.district_name, -- Status based on filled data CASE WHEN ufd.user_id IS NOT NULL THEN 'filled' ELSE 'not filled' END AS status FROM user JOIN role_mapping ON user.id = role_mapping.user_id JOIN master_district ON user.district_id = master_district.id -- Left join with user_filled_data to check if data is filled LEFT JOIN user_filled_data ufd ON user.id = ufd.user_id AND ufd.month = 09 AND ufd.year = 2024 WHERE user.district_id = 9 AND FIND_IN_SET('$role', role_mapping.role_id) > 0";
        }
        else if($role=='null' && empty($designation) && $district_id!="null"){
            //only district filter
            // $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id='$district_id' and (not FIND_IN_SET('13', role_id) > 0)";

            $query="SELECT DISTINCT(user.id) as userid, user.*, role_mapping.role_id, master_district.district_name,  CASE WHEN ufd.user_id IS NOT NULL THEN 'filled' ELSE 'not filled' END AS status FROM user JOIN role_mapping ON user.id = role_mapping.user_id JOIN master_district ON user.district_id = master_district.id  LEFT JOIN user_filled_data ufd ON user.id = ufd.user_id AND ufd.month = 09 AND ufd.year = 2024 WHERE user.district_id = '$district_id' AND NOT FIND_IN_SET('13', role_mapping.role_id) > 0";
        }
        else if($role && ($role!='null') && empty($designation) && $district_id!="null"){
            // role and district filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id='$district_id' and FIND_IN_SET('$role', role_id) > 0";

            

        }
        else if($role=='null' && $designation && $district_id!="null"){
            // district and designation filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id='$district_id' and user.designation='$designation' and (not FIND_IN_SET('13', role_id) > 0)";
        }
        else if($role!='null' && $designation && $district_id!="null"){
            // district, role and designation filter
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.district_id='$district_id' and user.designation='$designation' and FIND_IN_SET('$role', role_id) > 0 and (not FIND_IN_SET('13', role_id) > 0)";
        }
        else if($designation && $role && $district_id=='null'){
            $query="select user.*,role_mapping.role_id,master_district.district_name from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where user.designation='$designation'  and FIND_IN_SET('$role', role_id) > 0";
        }
        else if(!isset($designation) && $role=="null" && $district_id="null"){
            $query="select * from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where FIND_IN_SET('13', role_id) > 0";
        }
    
        else{
            // $query="select * from user join role_mapping on user.id=role_mapping.user_id join master_district on user.district_id=master_district.id where FIND_IN_SET('13', role_id) > 0";
            $query="SELECT DISTINCT(user.id) as userid, user.*, role_mapping.role_id, master_district.district_name,  CASE WHEN ufd.user_id IS NOT NULL THEN 'filled' ELSE 'not filled' END AS status FROM user JOIN role_mapping ON user.id = role_mapping.user_id JOIN master_district ON user.district_id = master_district.id  LEFT JOIN user_filled_data ufd ON user.id = ufd.user_id AND ufd.month = 09 AND ufd.year = 2024 WHERE user.district_id = '$district_id' AND NOT FIND_IN_SET('13', role_mapping.role_id) > 0";
        }
    }


    
  




    
    $user_filtered_result=mysqli_query($conn,$query);
    $final_resul2t=[];
    while($row2=mysqli_fetch_assoc($user_filtered_result)){
        $roles_string=$row2['role_id'];
                // print_r($roles_string);
        $roles_array=explode(",",$roles_string);
        $final_role=[];
        foreach($roles_array as $key=>$value){
            $query="select role from roles where id=$value";
            $roles_result=mysqli_query($conn,$query);
            $roles_row=mysqli_fetch_assoc($roles_result);
            $final_role[]=$roles_row['role'];
        }

        $row2['roles_array']=implode(",",$final_role);
        $final_result2[]=$row2;
    }

    

    print_r(json_encode($final_result2));

    
       
}

else{
    header('location:../index.php');
}


?>