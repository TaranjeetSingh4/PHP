<?php
// Database connection (update with your actual connection details)
$conn = new mysqli('localhost', 'dev', 'sUUR2mZM1fR5WfKp', 'template');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Queries to get format fields and sections
// $query = "SELECT u.id AS user_id, u.name AS user_name, m.district_name, ff.field_name, fsf.sub_field_name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year 
// FROM user_filled_data ufd 
// JOIN user u ON ufd.user_id = u.id 
// JOIN master_district m ON ufd.district_id = m.id 
// LEFT JOIN formats as f ON ufd.format_id=f.id 
// LEFT JOIN format_fields ff ON ufd.field_id = ff.id 
// LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id 
// WHERE ufd.format_id = 15 AND ufd.month=05 AND ufd.year=2024 
// GROUP BY ufd.user_id, ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year 
// ORDER BY ufd.user_id";




$query=$_SESSION['execute_query'];

if($_SESSION['execute_query']){
    $query=$_SESSION['execute_query'];
}
else{
$query="SELECT m.district_name, ff.field_name, fsf.sub_field_name,ufd.user_id,user.name, SUM(ufd.value) AS total_value, f.format_name as format_name, ufd.month, ufd.year FROM user_filled_data ufd JOIN user u ON ufd.user_id = u.id JOIN master_district m ON ufd.district_id = m.id LEFT JOIN formats as f ON ufd.format_id=f.id LEFT JOIN format_fields ff ON ufd.field_id = ff.id LEFT JOIN format_sections fsf ON ufd.sub_field_id = fsf.id left join user on ufd.user_id=user.id WHERE ufd.format_id = 15 AND ufd.month=05 AND ufd.year=2024 and ufd.district_id=9 GROUP BY ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year,ufd.user_id";
}

$format_normal_field_query = "SELECT * FROM format_fields WHERE format_id=15";
$format_sub_section_field_query = "SELECT * FROM format_sections WHERE format_id=15";

// Fetch field names for columns
$result_normal = mysqli_query($conn, $format_normal_field_query);
$result_sub = mysqli_query($conn, $format_sub_section_field_query);

$columns1 = array();
$columns1[] = "date";
$columns1[] = "district_name";
$columns1[] = "user_name";
$columns1[] = "format_name";

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
    $user_name = $row['name'];
    
    // Create row data with default 'NULL'
    $data = array(
        "date" => $row['month'] . "-" . $row['year'],
        "district_name" => $district_name,
        "user_name"=>$user_name,
        "format_name" => $row['format_name']
    );
    
    // Populate data for field names
    if ($row['field_name']) {
        $data[$row['field_name']] = $row['total_value'];
    }
    
    // Populate data for sub-field names
    if ($row['sub_field_name']) {
        $data[$row['sub_field_name']] = $row['total_value'];
    }

    // Initialize row data for each district
    if (!isset($row_data2[$user_name])) {
        $row_data2[$user_name] = array_fill_keys($columns1, 'NULL');
    }

    foreach ($data as $key => $value) {
        if (array_key_exists($key, $row_data2[$user_name])) {
            $row_data2[$user_name][$key] = $value;
        }
    }
}

// Output file
$filename = "district_data.csv";

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

// Close database connection
$conn->close();
?>
