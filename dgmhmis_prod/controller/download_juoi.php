<?php

require_once("config.php");
session_start();



if(isset($_SESSION['email'])){
    $conn=get_db_connection();

    $currentYear= date('Y');
    $currentMonth=date('m');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['districts']) && $_POST['districts']){
            $district_id=$_POST['districts'];
        }
        else{
            if($_SESSION['user_role']=="DNO"){
                $district_id=$_SESSION['district_id'];
            }
            else{
                $district_id="";
            }
            
        }
        // $district_id=$_POST['districts'];
        
        $format_id=$_POST['format_id'];
      
      
        // $date = new DateTime($_POST['date']);

        //     // Extract the year and month
        // $year = $date->format('Y');
        // $month = $date->format('m');

        if(isset($_POST['date']) && $_POST['date']){
            $date = new DateTime($_POST['date']);

            // Extract the year and month
            $year = $date->format('Y');
            $month = $date->format('m');
        }
        else{
            $month=date('m');
            $year=date('Y');
        }

       

        if(($district_id) && (!empty($district_id))  && empty($_POST['date'])){

            $query="SELECT m.district_name, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year and ufd.district_id=$district_id GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "user_name";
            $columns1[] = "format_name";
            $filename = "district_data.csv";

        }
        else if(empty($district_id) && $_POST['date']){
            
            $query="SELECT m.district_name, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year 
            FROM user_filled_data ufd 
            JOIN user u ON ufd.user_id = u.id 
            JOIN master_district m ON ufd.district_id = m.id 
            LEFT JOIN formats as f ON ufd.format_id=f.id 
            LEFT JOIN format_fields ff ON ufd.field_id = ff.id 
            LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id 
            WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year 
            GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "format_name";
            $filename = "DNO_data.csv";
        }
        else if(($district_id) && (!empty($district_id)) && $_POST['date']){

            $query="SELECT m.district_name, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year and ufd.district_id=$district_id GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "user_name";
            $columns1[] = "format_name";

            $filename = "district_data.csv";

        }
        else{
          
            $query="SELECT m.district_name, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year 
            FROM user_filled_data ufd 
            JOIN user u ON ufd.user_id = u.id 
            JOIN master_district m ON ufd.district_id = m.id 
            LEFT JOIN formats as f ON ufd.format_id=f.id 
            LEFT JOIN format_fields ff ON ufd.field_id = ff.id 
            LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id 
            WHERE ufd.format_id = 15 AND ufd.month=$month AND ufd.year=$year 
            GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "format_name";

            $filename = "DNO_data.csv";

        }
    }

  
    
    $format_normal_field_query = "SELECT * FROM format_fields WHERE format_id=15";
    $format_sub_section_field_query = "SELECT * FROM format_sections WHERE format_id=15";
    
    // Fetch field names for columns
    $result_normal = mysqli_query($conn, $format_normal_field_query);
    $result_sub = mysqli_query($conn, $format_sub_section_field_query);
    
    
    
    // Add dynamic field names
    while ($row_normal = mysqli_fetch_assoc($result_normal)) {
        $field_name = $row_normal['field_name'];
        if ($field_name) {
            $columns1[] = $field_name;
        }
    }
    
    // Add dynamic sub-field names
    while ($row_sub = mysqli_fetch_assoc($result_sub)) {
        $sub_field_name = $row_sub['sub_field_name'];
        if ($sub_field_name) {
            $columns1[] = $sub_field_name;
        }
    }
    
    $columns1 = array_unique($columns1); // Ensure unique columns
    
    // Initialize row data
    $row_data2 = [];
    $result = mysqli_query($conn, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $district_name = $row['district_name'];

        if($row['name']){
            $user_name = $row['name'];
            $user_id = $row['user_id'];
            $district_name=$row['district_name'];
            $data = array(
                "date" => $row['month'] . "-" . $row['year'],
                "district_name" => $district_name,
                "user_name"=>$user_name,
                "format_name" => $row['format_name']
            );
            $filename="$district_name"."_data.csv";
        }
        else{
            $data = array(
                "date" => $row['month'] . "-" . $row['year'],
                "district_name" => $district_name,
                "format_name" => $row['format_name']
            );
        }
        // Create row data with default 'NULL'
        
        
        
        // Populate data for field names
        if ($row['field_name']) {
            $data[$row['field_name']] = $row['total_value'];
        }
        
        // Populate data for sub-field names
        if ($row['sub_field_name']) {
            $data[$row['sub_field_name']] = $row['total_value'];
        }
    
        // Initialize row data for each district
        if($row['name']){
            if (!isset($row_data2[$user_id])) {
                $row_data2[$user_id] = array_fill_keys($columns1, 'NULL');
            }
        
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $row_data2[$user_id])) {
                    $row_data2[$user_id][$key] = $value;
                }
            }
        }
        else{
            if (!isset($row_data2[$district_name])) {
                $row_data2[$district_name] = array_fill_keys($columns1, 'NULL');
            }
        
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $row_data2[$district_name])) {
                    $row_data2[$district_name][$key] = $value;
                }
            }
        }
        
    }
    

    
    
    // Set headers to download the file as a CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Write the header
    fputcsv($output, $columns1);
    
    // Write data rows
    foreach ($row_data2 as $district_name => $data) {
        // Write the row to the CSV
        fputcsv($output, $data);
    }
    
    // Close the output stream
    fclose($output);
    exit;
    // Close database connection
    $conn->close();

   
}

else{
    header('location:../index.php');
}


?>
