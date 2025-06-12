<?php
require_once("config.php");

$conn=get_db_connection();
$query="select * from user";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
    $delimiter = ","; 
    $filename = "members-data_" . date('Y-m-d') . ".csv"; 
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
    // Set column headers 
    $fields = array('ID', 'NAME', 'EMAIL', 'PHONE', 'ROLE', 'PASSWORD', 'CREATED_AT'); 
    fputcsv($f, $fields, $delimiter); 
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = mysqli_fetch_assoc($result)){ 
        $lineData = array($row['id'], $row['name'], $row['email'], $row['phone'], $row['role'], $row['password'], $row['created_at']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
    
    // Move back to beginning of file 
    fseek($f, 0); 
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
    
    //output all remaining data on a file pointer 
    fpassthru($f); 
    
}

?>