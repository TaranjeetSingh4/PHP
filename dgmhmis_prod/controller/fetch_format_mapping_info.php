<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $select_query="SELECT format_mapping.id as id,format_mapping.format_id as format_id,formats.format_name,format_mapping.role_id,format_mapping.status FROM `format_mapping` inner join formats on format_mapping.format_id=formats.id";
        $mapping_result=mysqli_query($conn,$select_query);
        $format_mapping_data=array();
        while($maping_row=mysqli_fetch_assoc($mapping_result)){
            $data=[];
            $role_id=$maping_row['role_id'];
            $role_name="";
            $role_array=explode(',',$role_id);
            $final_roles=[];
            foreach($role_array as $key=>$value){
                $s_query="select role from roles where id=$value";
                $s_result=mysqli_query($conn,$s_query);
                $s_data=mysqli_fetch_assoc($s_result);
                $final_roles[]=$s_data['role'];
            }

            $data['id']=$maping_row['id'];
            $data['format_id']=$maping_row['format_id'];
            $data['roles']=implode(",",$final_roles);;

            $format_mapping_data[$maping_row['format_name']]=$data;
        }

        
    }
    catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
}

else{
    header('location:../index.php');
}


?>