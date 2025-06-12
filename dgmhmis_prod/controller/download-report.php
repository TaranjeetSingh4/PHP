<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $user_id=$_GET['user_id'];
    $role_id=$_GET['role_id'];

   
    $format_id=$_GET['format_id'];
    $month=$_GET['month'];
    $year=$_GET['year'];
   
    $normal_field_query="select * from (SELECT uf.*,f.format_name as format_name FROM `user_filled_data` as uf join formats as f on uf.format_id=f.id where uf.user_id='$user_id' and uf.role_id='$role_id' and uf.format_id='$format_id' and uf.month='$month' and uf.year='$year') as t join format_fields as ff on t.field_id=ff.id";
    $sub_field_query="select * from (SELECT uf.*,f.format_name as format_name FROM `user_filled_data` as uf join formats as f on uf.format_id=f.id where uf.user_id='$user_id' and uf.role_id='$role_id' and uf.format_id='$format_id' and uf.month='$month' and uf.year='$year') as t join format_sections as fs on t.sub_field_id=fs.id";
    
    $normal_field_result=mysqli_query($conn,$normal_field_query);
    $normal_field_array=[];
    // while($row=mysqli_fetch_assoc($normal_field_result)){
    //     $normal_field_array[]=$row;
    // }


    $sub_field_result=mysqli_query($conn,$sub_field_query);
    $sub_field_array=array();

    // while($sub_field_row=mysqli_fetch_assoc($sub_field_result)){

    //     $sub_field_sub_array=array();
        
    //     $sub_field_sub_array['format_id']=$sub_field_row['format_id'];
    //     $sub_field_sub_array['section_name']=$sub_field_row['section_name'];
    //     $sub_field_sub_array['sub_field_id']=$sub_field_row['sub_field_id'];
    //     $sub_field_sub_array['sub_field_name']=$sub_field_row['sub_field_name'];
    //     $sub_field_sub_array['sub_field_type']=$sub_field_row['sub_field_type'];
    //     $sub_field_sub_array['value']=$sub_field_row['value'];
        
    //     $section_name=$sub_field_row['section_name'];
    //     if (!isset($sub_field_array[$section_name])) {
    //         // If it does not exist, initialize it as an empty array
    //         $sub_field_array[$section_name] = [];
    //     }
        
    //     $sub_field_array[$section_name][]=$sub_field_sub_array;

        
    // }


    
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 

 
// Column names 
$fields = array('s.no','date', 'format_name', 'field_name', 'value'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
// $query = $db->query("SELECT * FROM members ORDER BY id ASC"); 
if(mysqli_num_rows($normal_field_result)>0){ 
    // Output each row of the data 
    $count=1;
    while($row=mysqli_fetch_assoc($normal_field_result)){ 
        
        // $status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array($count, $row['month']."-".$row['year'], $row['format_name'], $row['field_name'], $row['value']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        $count=$count+1;
        // Excel file name for download 
        $fileName = $row['format_name']."-data_" . $row['month']."-".$row['year'] . ".xls"; 
    } 

    while($row=mysqli_fetch_assoc($sub_field_result)){ 
        
        // $status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array($count, $row['month']."-".$row['year'], $row['format_name'], $row['sub_field_name'], $row['value']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        $count=$count+1;
    } 
    

}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 



}
else{
    header('location:../index.php');
}


?>