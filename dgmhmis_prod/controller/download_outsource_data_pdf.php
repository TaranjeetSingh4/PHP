<?php
require_once("config.php");
session_start();

if (isset($_SESSION['email'])) {
    $conn = get_db_connection();

    // Prepare the SQL query
    $district_id = 38;
    $formattedDate = '2025-01-02';

    $query = "
        SELECT 
            u.name AS 'Filled by User',
            m.district_name AS 'District Name',
            r.role AS 'Filled by Role',
            o.created_at as 'month_data',
            o.employee_name AS 'Employee Name',
            o.hospital_name AS 'Hospital Name',
            o.hospital_address AS 'Hospital Address',
            o.father_husband_name AS 'Employee Father/Husband Name',
            o.aadhar_card AS 'Aadhar Card Number',
            o.mobile_no AS 'Mobile Number',
            o.designation AS 'Designation',
            o.grade AS 'Grade',
            o.employee_category AS 'Employee Category GN/OBC/SC/ST',
            o.skilled_unskilled AS 'Category Skilled/Unskilled',
            o.joining_date AS 'Date of Joining',
            o.agency_name AS 'Outsourcing Agency Name',
            o.minimum_wage AS 'Minimum wage per Month',
            o.epf AS 'EPF @13%',
            o.esi AS 'ESI @3.25%',
            o.gross AS 'Gross',
            o.total_cost AS 'Total Cost',
            o.agency_charge_percent AS 'Agency Service Charge',
            o.gst_percent AS 'GST',
            o.grand_total AS 'Grand Total',
            o.post_type AS 'Employee post against',
            o.sanctioned_post AS 'Number of Sanctioned post',
            o.remarks AS 'Remarks',
            'Outsource Data' AS 'Format Name'
        FROM 
            outsourcing_data o
        JOIN 
            user u ON o.added_by_user_id = u.id
        JOIN 
            master_district m ON o.district_id = m.id
        JOIN 
            roles r ON o.role_id = r.id
        WHERE 
            o.district_id = $district_id
            AND DATE(o.created_at) = '$formattedDate'
        ORDER BY 
            o.created_at DESC
    ";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Output the PDF header
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename=Outsource_Report_" . date('Ymd') . ".pdf");

    // Start generating the HTML table content
    echo '<html><head>';
    echo '<style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        </style>';
    echo '</head><body>';

    echo '<h2>Outsource Report</h2>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>
            <th>Filled by User</th>
            <th>District Name</th>
            <th>Filled by Role</th>
            <th>Month Data</th>
            <th>Employee Name</th>
            <th>Hospital Name</th>
            <th>Hospital Address</th>
            <th>Employee Father/Husband Name</th>
            <th>Aadhar Card Number</th>
            <th>Mobile Number</th>
            <th>Designation</th>
            <th>Grade</th>
            <th>Employee Category GN/OBC/SC/ST</th>
            <th>Category Skilled/Unskilled</th>
            <th>Date of Joining</th>
            <th>Outsourcing Agency Name</th>
            <th>Minimum wage per Month</th>
            <th>EPF @13%</th>
            <th>ESI @3.25%</th>
            <th>Gross</th>
            <th>Total Cost</th>
            <th>Agency Service Charge</th>
            <th>GST</th>
            <th>Grand Total</th>
            <th>Employee post against</th>
            <th>Number of Sanctioned post</th>
            <th>Remarks</th>
            <th>Format Name</th>
        </tr>';
    echo '</thead><tbody>';

    // Output data rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($row as $value) {
            echo '<td>' . ($value ? $value : 'NA') . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</body></html>';

    exit();
} else {
    header('location:../index.php');
}
?>
