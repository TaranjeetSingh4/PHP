<?php

require_once("config.php");

session_start();

if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    
    $format_id=$_POST['format_id'];
    $format_name=$_POST['format_name'];
    $format_heading=$_POST['format_heading'];
    $field_name_array=$_POST['field_name'];
    $field_type_array=$_POST['field_type'];
    $section_name_array=$_POST['section_name'];
    $sub_field_name_array=$_POST['sub_field_name'];
    $sub_field_type_array=$_POST['sub_field_type'];
    $delete_field_ids=$_POST['delete_field_id'];
    $delete_sub_field_ids=$_POST['delete_sub_field_id'];
    $date=date("Y-m-d h:i:s");
    

    if(!empty($delete_field_ids)){
       
        $delete_field_ids_array=explode(',',$delete_field_ids);
    }
    else{
        
        $delete_field_ids_array=[];
    }
    
    if(!empty($delete_sub_field_ids)){
        $delete_sub_field_ids_array=explode(',',$delete_sub_field_ids);
    }
    else{
        $delete_sub_field_ids_array=[];
    }
    
   

    
    



    $format_update_query="UPDATE formats set `format_name`='$format_name', `format_heading`='$format_heading' where `id`=$format_id";

    mysqli_query($conn,$format_update_query);

    $field_id_array=$_POST['field_id'];
    foreach($field_id_array as $key=>$value){
        $field_id=$_POST['field_id'][$key];
        $field_name=$_POST['field_name'][$key];
        $field_type=$_POST['field_type'][$key];

        $field_update_query="UPDATE format_fields set `field_name`='$field_name',`field_type`='$field_type' where `format_id`=$format_id and `id`=$field_id";
        // print_r($field_update_query);
        mysqli_query($conn,$field_update_query);
    }

    $new_field_add=count($field_id_array);

    foreach($field_name_array as $key=>$value){
        if($key>=$new_field_add){

            $field_name=$_POST['field_name'][$key];
            $field_type=$_POST['field_type'][$key];
            
            $new_field_add_query="INSERT INTO format_fields(format_id,field_name,field_type) values($format_id,'$field_name','$field_type')";
            mysqli_query($conn,$new_field_add_query);
        }
    }

    $sub_field_id_array=$_POST['sub_field_id'];

    foreach($sub_field_id_array as $key=>$value){
        $sub_field_id=$_POST['sub_field_id'][$key];
        $sub_field_name=$_POST['sub_field_name'][$key];
        $sub_field_type=$_POST['sub_field_type'][$key];
        $section_name=$_POST['section_name'][$key];
        // print_r($section_name);
        $new_query="UPDATE `format_sections` SET `section_name` = '$section_name', `sub_field_name`='$sub_field_name', `sub_field_type`='$sub_field_type' WHERE `format_sections`.`id` = $sub_field_id;";
        // $sub_field_update_query="UPDATE format_sections set `section_name`='$section_name',`sub_field_name`='$sub_field_name',`sub_field_type`='$sub_field_type' where `format_id`=$format_id and `id`=$sub_field_id";
        // print_r($field_update_query);
        mysqli_query($conn,$new_query);
    }
    
    $new_sub_field_add=count($sub_field_id_array);

    
    foreach($sub_field_name_array as $key=>$value){
        
        if($key>=$new_sub_field_add){
            
            $sub_field_name=$_POST['sub_field_name'][$key];
            $sub_field_type=$_POST['sub_field_type'][$key];
            $section_name=$_POST['section_name'][$key];
            
            $new_sub_field_add_query="INSERT INTO format_sections(format_id,section_name,sub_field_name,sub_field_type,created_at) values($format_id,'$section_name','$sub_field_name','$sub_field_type','$date')";
            mysqli_query($conn,$new_sub_field_add_query);
        }
    }
    if($delete_field_ids_array){
        foreach($delete_field_ids_array as $delete_field_id){
            $delete_query="delete from format_fields where id=$delete_field_id";
            
            mysqli_query($conn,$delete_query);
        }
    }


    
   
    if($delete_sub_field_ids_array){
        foreach($delete_sub_field_ids_array as $delete_sub_field_id){
            $delete_sub_query="delete from format_sections where id=$delete_sub_field_id";
          
            mysqli_query($conn,$delete_sub_query);
        }
    }
    // header('location:../format-template-view.php?id'.$format_id);
    print_r('Format Updated Successfully!');
}

else{
    header('location:../index.php');
}

?>