<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){

    try{
        $conn=get_db_connection();
        $district_id=$_POST['districts'];
        $date=$_POST['date'];
        $format_id=$_POST['format_id'];
        
        if($_POST['districts']){
            $district_id=$_POST['districts'];
        }
        else{
            $district_id="";
        }

        if($_POST['date']){
            $date = new DateTime($_POST['date']);

            // Extract the year and month
            $year = $date->format('Y');
            $month = $date->format('m');
        }
        else{
            $date = "";
            $month="";
            $year="";
        }

        if($_POST['format_id']){
            $format_id=$_POST['format_id'];
        }
        else{
            $format_id="";
        }

        


        if((($district_id) && ($district_id!="default")) && empty($date) && ((empty($format_id)) || ($format_id=="default"))){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id where ufd.user_id in (select id from user where district_id=$district_id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id) t3 join master_district on master_district.id = t3.district_id";
        } //only district

        else if(((empty($district_id)) || ($district_id=="default")) && $date && ((empty($format_id)) || ($format_id=="default"))){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year) t3 join master_district on master_district.id = t3.district_id";
        }//only date

        else if(((empty($district_id)) || ($district_id=="default")) && empty($date) && $format_id && ($format_id!="default")){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where format_id=$format_id) t3 join master_district on master_district.id = t3.district_id";        
        }//only format

        else if(($district_id && ($district_id!="default")) && $date && ((empty($format_id)) || ($format_id=="default"))){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id where ufd.user_id in (select id from user where district_id=$district_id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year) t3 join master_district on master_district.id = t3.district_id"; 
        }//only district and date

        else if(($district_id && ($district_id!="default")) && empty($date) && $format_id && ($format_id!="default")){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id where ufd.user_id in (select id from user where district_id=$district_id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where format_id=$format_id) t3 join master_district on master_district.id = t3.district_id";
        } //only district and format

        else if(((empty($district_id)) || ($district_id=="default")) && $date && $format_id && ($format_id!="default")){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year and format_id=$format_id) t3 join master_district on master_district.id = t3.district_id";
        }//only format and date

        else if(($district_id && ($district_id!="default")) && $date && ((empty($format_id)) || ($format_id=="default") )){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id where ufd.user_id in (select id from user where district_id=$district_id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year) t3 join master_district on master_district.id = t3.district_id";
        } //only district and date

        

        else{
            $query="select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id where ufd.user_id in (select id from user where district_id=$district_id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year and format_id=$format_id";
        }


        if($district_id=="default" && ((empty($format_id)) || $format_id=="null") || ($format_id=="default")){
            if($date){
                $month=$month;
                $year=$year;
            }
            else{
                $month=date('m');
                $year=date('Y');
            }
            
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year) t3 join master_district on master_district.id = t3.district_id";
        }

        if(((empty($format_id)) || ($format_id=="null") || ($format_id=="default")) && ($district_id!="default")){
            if($date){
                $month=$month;
                $year=$year;
            }
            else{
                $month=07;
                $year=date('Y');
            }
            
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id where ufd.user_id in (select id from user where district_id=$district_id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year) t3 join master_district on master_district.id = t3.district_id";
        } //district and default format
        
        if(($format_id && ($format_id !="default")) && ((empty($district_id)) || ($district_id=="default"))){
            $query="select t3.*,master_district.district_name from (select t1.*,roles.role from (select formats.id as format_id,t.user_id,t.name as user_name,formats.format_name,formats.format_heading,t.role_id ,t.month,t.year,t.status,t.district_id from (SELECT ufd.user_id,ufd.format_id,u.name,ufd.role_id,ufd.month,ufd.year,ufd.status,u.district_id FROM `user_filled_data`as ufd join user as u on ufd.user_id=u.id) group by ufd.user_id,ufd.format_id,ufd.role_id,ufd.month,ufd.year,ufd.status) as t join formats on formats.id=t.format_id) as t1 join roles on t1.role_id=roles.id where t1.month=$month and t1.year=$year and t1.format_id=$format_id) t3 join master_district on master_district.id = t3.district_id";

        }
        //format and default districts
        
        // print_r($_POST);
        // print_r($query);

        $filter_result=mysqli_query($conn,$query);
        $filter_report_result=[];
        while($report_row=mysqli_fetch_assoc($filter_result)){
            $filter_report_result[]=$report_row;
        }
    
        // print_r($_POST);
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