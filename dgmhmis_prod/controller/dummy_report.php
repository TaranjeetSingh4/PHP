<?php
// Database connection
$conn = new mysqli('localhost', 'dev', 'sUUR2mZM1fR5WfKp', 'template');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all data
$query = "
    SELECT 
        ufd.user_id,
        m.district_name, 
        f.format_name, 
        ufd.month, 
        ufd.year,
        ff.field_name, 
        fsf.sub_field_name, 
        SUM(ufd.value) AS total_value
    FROM 
        user_filled_data ufd
    JOIN 
        user u ON ufd.user_id = u.id
    JOIN 
        master_district m ON ufd.district_id = m.id
    LEFT JOIN 
        formats f ON ufd.format_id = f.id
    LEFT JOIN 
        format_fields ff ON ufd.field_id = ff.id
    LEFT JOIN 
        format_sections fsf ON ufd.sub_field_id = fsf.id
    WHERE 
        ufd.format_id = 15 
        AND ufd.month = 05 
        AND ufd.year = 2024
    GROUP BY 
        ufd.user_id, ufd.district_id, ufd.field_id, ufd.sub_field_id, ufd.month, ufd.year
    ORDER BY 
        ufd.user_id
";

// Execute the query
$result = mysqli_query($conn, $query);

// Initialize arrays to store column names and row data
$columns1 = array("date", "district_name", "format_name");
$row_data2 = [];

// Process the result
while ($row = mysqli_fetch_assoc($result)) {
    $district_name = $row['district_name'];
    $field_name = $row['field_name'];
    $sub_field_name = $row['sub_field_name'];
    $total_value = $row['total_value'];

    // Initialize row data for each district if not already set
    if (!isset($row_data2[$district_name])) {
        $row_data2[$district_name] = array_fill_keys($columns1, 'NULL');
        $row_data2[$district_name]['date'] = $row['month'] . "-" . $row['year'];
        $row_data2[$district_name]['district_name'] = $district_name;
        $row_data2[$district_name]['format_name'] = $row['format_name'];
    }

    // Add field name and sub-field name dynamically
    if ($field_name) {
        if (!in_array($field_name, $columns1)) {
            $columns1[] = $field_name;
        }
        $row_data2[$district_name][$field_name] = $total_value;
    }

    if ($sub_field_name) {
        if (!in_array($sub_field_name, $columns1)) {
            $columns1[] = $sub_field_name;
        }
        $row_data2[$district_name][$sub_field_name] = $total_value;
    }
}

// Output file
$filename = "district_data.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=' . $filename);

// Open output stream
$output = fopen('php://output', 'w');

// Write the header
fputcsv($output, $columns1);

// Write data rows
foreach ($row_data2 as $data) {
    fputcsv($output, $data);
}

// Close the output stream and database connection
fclose($output);
$conn->close();
?>
