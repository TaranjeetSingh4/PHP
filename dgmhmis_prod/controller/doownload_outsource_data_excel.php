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
            if($_SESSION['user_role']=="CMO"){
                $district_id=$_SESSION['district_id'];
            }
            else if($_SESSION['user_role']=="admin"){
                $district_id="";
            }
            else{
                $district_id=$_SESSION['district_id'];  
                $user_id=$_SESSION['id'];            
            }
            
        }
        // $district_id=$_POST['districts'];
        
        $format_id=$_POST['format_id'];
      
      
        // $date = new DateTime($_POST['date']);

        //     // Extract the year and month
        // $year = $date->format('Y');
        // $month = $date->format('m');

        if(isset($_POST['date']) && $_POST['date']){
            $formattedDate = $_POST['date']; 
            // $dateObj = DateTime::createFromFormat('d-m-Y', $selectedDate);
            // $formattedDate = $dateObj->format('Y-m-d');
        }
        else{
            $formattedDate = date('Y-m-d');
        }


       

        if(($district_id) && (!empty($district_id))  && empty($_POST['date']) && empty($user_id)){

            $query="SELECT 
             u.name AS 'Filled by User',
                m.district_name AS 'District Name',
                r.role AS 'Filled by Role',
                'Outsource Data' AS 'Format Name',
                o.created_at AS 'Month Data',
                o.employee_name AS 'Employee Name',
                o.hospital_name AS 'Hospital Name',
                o.hospital_address AS 'Hospital Address',
                o.father_husband_name AS 'Employee Father/Husband Name',
                o.aadhar_card AS 'Aadhar Card Number',
                o.mobile_no AS 'Mobile Number',
                o.designation AS 'Designation',
                o.gender AS 'Gender',
                o.grade AS 'Grade',
                o.employee_category AS 'Employee Category GN/OBC/SC/ST',
                o.sub_category AS 'Employee Sub Category',
                o.emp_epf_no AS 'Employee EPF No.',
                o.emp_esic_no AS 'Employee ESIC No',
                o.skilled_unskilled AS 'Category Skilled/Unskilled',
                o.joining_date AS 'Date of Joining',
                o.agency_name AS 'Outsourcing Agency Name',
                o.agency_mobile AS 'Outsourcing Agency Mobile',
                o.agency_email AS 'Outsourcing Agency Email',
                o.agency_address AS 'Outsourcing Agency Address',
                o.agency_cp_name AS 'Outsourcing Agency Contact Person Name',
                o.agency_cp_mobile AS 'Outsourcing Agency Contact Person Mobile',
                o.minimum_wage AS 'Minimum wage per Month',
                o.epf AS 'EPF @13%',
                o.esi AS 'ESI @3.25%',
                o.gross AS 'Gross',
                o.total_cost AS 'Total Cost',
                o.agency_charge_percent AS 'Agency Service Charge',
                o.gst_percent AS 'GST',
                o.grand_total AS 'Grand Total',
                o.employee_status as 'Employee Status',
                o.emp_status_reason as 'Employee Status Reason',
                o.post_type AS 'Employee post against',
                o.sanctioned_post AS 'Number of Sanctioned post',
                o.remarks AS 'Remarks'
        FROM 
            outsourcing_data o
        JOIN 
            user u ON o.added_by_user_id=u.id
        JOIN 
            master_district m ON o.district_id = m.id
        JOIN 
            roles r ON o.role_id = r.id
        WHERE 
            o.district_id  = $district_id
            AND DATE(o.created_at) = '$formattedDate'
        ORDER BY 
            o.created_at DESC  ";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "user_name";
            $columns1[] = "format_name";
            $filename = "district_data.csv";

        }
        else if(empty($district_id) && ($_POST['date']) && (empty($user_id))){
            
            $query="SELECT 
             u.name AS 'Filled by User',
                m.district_name AS 'District Name',
                r.role AS 'Filled by Role',
                'Outsource Data' AS 'Format Name',
                o.created_at AS 'Month Data',
                o.employee_name AS 'Employee Name',
                o.hospital_name AS 'Hospital Name',
                o.hospital_address AS 'Hospital Address',
                o.father_husband_name AS 'Employee Father/Husband Name',
                o.aadhar_card AS 'Aadhar Card Number',
                o.mobile_no AS 'Mobile Number',
                o.designation AS 'Designation',
                o.gender AS 'Gender',
                o.grade AS 'Grade',
                o.employee_category AS 'Employee Category GN/OBC/SC/ST',
                o.sub_category AS 'Employee Sub Category',
                o.emp_epf_no AS 'Employee EPF No.',
                o.emp_esic_no AS 'Employee ESIC No',
                o.skilled_unskilled AS 'Category Skilled/Unskilled',
                o.joining_date AS 'Date of Joining',
                o.agency_name AS 'Outsourcing Agency Name',
                o.agency_mobile AS 'Outsourcing Agency Mobile',
                o.agency_email AS 'Outsourcing Agency Email',
                o.agency_address AS 'Outsourcing Agency Address',
                o.agency_cp_name AS 'Outsourcing Agency Contact Person Name',
                o.agency_cp_mobile AS 'Outsourcing Agency Contact Person Mobile',
                o.minimum_wage AS 'Minimum wage per Month',
                o.epf AS 'EPF @13%',
                o.esi AS 'ESI @3.25%',
                o.gross AS 'Gross',
                o.total_cost AS 'Total Cost',
                o.agency_charge_percent AS 'Agency Service Charge',
                o.gst_percent AS 'GST',
                o.grand_total AS 'Grand Total',
                o.employee_status as 'Employee Status',
                o.emp_status_reason as 'Employee Status Reason',
                o.post_type AS 'Employee post against',
                o.sanctioned_post AS 'Number of Sanctioned post',
                o.remarks AS 'Remarks'
        FROM 
            outsourcing_data o
        JOIN 
            user u ON o.added_by_user_id=u.id
        JOIN 
            master_district m ON o.district_id = m.id
        JOIN 
            roles r ON o.role_id = r.id
        WHERE 
           DATE(o.created_at) = '$formattedDate'
        ORDER BY 
            o.created_at DESC ";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "format_name";
            $filename = "All_data.csv";
        }
        else if(($district_id) && (!empty($district_id)) && $_POST['date'] && empty($user_id)){

            $query="SELECT 
                u.name AS 'Filled by User',
                m.district_name AS 'District Name',
                r.role AS 'Filled by Role',
                'Outsource Data' AS 'Format Name',
                o.created_at AS 'Month Data',
                o.employee_name AS 'Employee Name',
                o.hospital_name AS 'Hospital Name',
                o.hospital_address AS 'Hospital Address',
                o.father_husband_name AS 'Employee Father/Husband Name',
                o.aadhar_card AS 'Aadhar Card Number',
                o.mobile_no AS 'Mobile Number',
                o.designation AS 'Designation',
                o.gender AS 'Gender',
                o.grade AS 'Grade',
                o.employee_category AS 'Employee Category GN/OBC/SC/ST',
                o.sub_category AS 'Employee Sub Category',
                o.emp_epf_no AS 'Employee EPF No.',
                o.emp_esic_no AS 'Employee ESIC No',
                o.skilled_unskilled AS 'Category Skilled/Unskilled',
                o.joining_date AS 'Date of Joining',
                o.agency_name AS 'Outsourcing Agency Name',
                o.agency_mobile AS 'Outsourcing Agency Mobile',
                o.agency_email AS 'Outsourcing Agency Email',
                o.agency_address AS 'Outsourcing Agency Address',
                o.agency_cp_name AS 'Outsourcing Agency Contact Person Name',
                o.agency_cp_mobile AS 'Outsourcing Agency Contact Person Mobile',
                o.minimum_wage AS 'Minimum wage per Month',
                o.epf AS 'EPF @13%',
                o.esi AS 'ESI @3.25%',
                o.gross AS 'Gross',
                o.total_cost AS 'Total Cost',
                o.agency_charge_percent AS 'Agency Service Charge',
                o.gst_percent AS 'GST',
                o.grand_total AS 'Grand Total',
                o.employee_status as 'Employee Status',
                o.emp_status_reason as 'Employee Status Reason',
                o.post_type AS 'Employee post against',
                o.sanctioned_post AS 'Number of Sanctioned post',
                o.remarks AS 'Remarks'
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

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "user_name";
            $columns1[] = "format_name";

            $filename = "district_data.csv";

        }

        else if(($district_id) && (!empty($district_id)) && ($_POST['date']) && ($user_id)){

            $query="SELECT 
                u.name AS 'Filled by User',
                m.district_name AS 'District Name',
                r.role AS 'Filled by Role',
                'Outsource Data' AS 'Format Name',
                o.created_at AS 'Month Data',
                o.employee_name AS 'Employee Name',
                o.hospital_name AS 'Hospital Name',
                o.hospital_address AS 'Hospital Address',
                o.father_husband_name AS 'Employee Father/Husband Name',
                o.aadhar_card AS 'Aadhar Card Number',
                o.mobile_no AS 'Mobile Number',
                o.designation AS 'Designation',
                o.gender AS 'Gender',
                o.grade AS 'Grade',
                o.employee_category AS 'Employee Category GN/OBC/SC/ST',
                o.sub_category AS 'Employee Sub Category',
                o.emp_epf_no AS 'Employee EPF No.',
                o.emp_esic_no AS 'Employee ESIC No',
                o.skilled_unskilled AS 'Category Skilled/Unskilled',
                o.joining_date AS 'Date of Joining',
                o.agency_name AS 'Outsourcing Agency Name',
                o.agency_mobile AS 'Outsourcing Agency Mobile',
                o.agency_email AS 'Outsourcing Agency Email',
                o.agency_address AS 'Outsourcing Agency Address',
                o.agency_cp_name AS 'Outsourcing Agency Contact Person Name',
                o.agency_cp_mobile AS 'Outsourcing Agency Contact Person Mobile',
                o.minimum_wage AS 'Minimum wage per Month',
                o.epf AS 'EPF @13%',
                o.esi AS 'ESI @3.25%',
                o.gross AS 'Gross',
                o.total_cost AS 'Total Cost',
                o.agency_charge_percent AS 'Agency Service Charge',
                o.gst_percent AS 'GST',
                o.grand_total AS 'Grand Total',
                o.employee_status as 'Employee Status',
                o.emp_status_reason as 'Employee Status Reason',
                o.post_type AS 'Employee post against',
                o.sanctioned_post AS 'Number of Sanctioned post',
                o.remarks AS 'Remarks'
            FROM 
                outsourcing_data o
            JOIN 
                user u ON o.added_by_user_id = u.id
            JOIN 
                master_district m ON o.district_id = m.id
            JOIN 
                roles r ON o.role_id = r.id
            
            WHERE 
                o.district_id = $district_id AND
                o.added_by_user_id = $user_id
                AND DATE(o.created_at) = '$formattedDate'
            ORDER BY 
                o.created_at DESC
        
         ";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "user_name";
            $columns1[] = "format_name";

            $filename = "district_data.csv";

        }

        else if(($district_id) && (!empty($district_id)) && (empty($_POST['date'])) && ($user_id)){

            $query="SELECT 
                u.name AS 'Filled by User',
                m.district_name AS 'District Name',
                r.role AS 'Filled by Role',
                'Outsource Data' AS 'Format Name',
                o.created_at AS 'Month Data',
                o.employee_name AS 'Employee Name',
                o.hospital_name AS 'Hospital Name',
                o.hospital_address AS 'Hospital Address',
                o.father_husband_name AS 'Employee Father/Husband Name',
                o.aadhar_card AS 'Aadhar Card Number',
                o.mobile_no AS 'Mobile Number',
                o.designation AS 'Designation',
                o.gender AS 'Gender',
                o.grade AS 'Grade',
                o.employee_category AS 'Employee Category GN/OBC/SC/ST',
                o.sub_category AS 'Employee Sub Category',
                o.emp_epf_no AS 'Employee EPF No.',
                o.emp_esic_no AS 'Employee ESIC No',
                o.skilled_unskilled AS 'Category Skilled/Unskilled',
                o.joining_date AS 'Date of Joining',
                o.agency_name AS 'Outsourcing Agency Name',
                o.agency_mobile AS 'Outsourcing Agency Mobile',
                o.agency_email AS 'Outsourcing Agency Email',
                o.agency_address AS 'Outsourcing Agency Address',
                o.agency_cp_name AS 'Outsourcing Agency Contact Person Name',
                o.agency_cp_mobile AS 'Outsourcing Agency Contact Person Mobile',
                o.minimum_wage AS 'Minimum wage per Month',
                o.epf AS 'EPF @13%',
                o.esi AS 'ESI @3.25%',
                o.gross AS 'Gross',
                o.total_cost AS 'Total Cost',
                o.agency_charge_percent AS 'Agency Service Charge',
                o.gst_percent AS 'GST',
                o.grand_total AS 'Grand Total',
                o.employee_status as 'Employee Status',
                o.emp_status_reason as 'Employee Status Reason',
                o.post_type AS 'Employee post against',
                o.sanctioned_post AS 'Number of Sanctioned post',
                o.remarks AS 'Remarks'
            FROM 
                outsourcing_data o
            JOIN 
                user u ON o.added_by_user_id = u.id
            JOIN 
                master_district m ON o.district_id = m.id
            JOIN 
                roles r ON o.role_id = r.id
            
            WHERE 
                o.district_id = $district_id AND
                o.added_by_user_id = $user_id AND
                MONTH(o.created_at) = (SELECT MONTH(max(created_at)) from outsourcing_data) AND
                YEAR(o.created_at) = (SELECT YEAR(max(created_at)) from outsourcing_data)
                -- AND DATE(o.created_at) = '$formattedDate'
            ORDER BY 
                o.created_at DESC
        
         ";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "user_name";
            $columns1[] = "format_name";

            $filename = "district_data.csv";

        }
        
        else{
          
            $query="SELECT 
                u.name AS 'Filled by User',
                m.district_name AS 'District Name',
                r.role AS 'Filled by Role',
                'Outsource Data' AS 'Format Name',
                o.created_at AS 'Month Data',
                o.employee_name AS 'Employee Name',
                o.hospital_name AS 'Hospital Name',
                o.hospital_address AS 'Hospital Address',
                o.father_husband_name AS 'Employee Father/Husband Name',
                o.aadhar_card AS 'Aadhar Card Number',
                o.mobile_no AS 'Mobile Number',
                o.designation AS 'Designation',
                o.gender AS 'Gender',
                o.grade AS 'Grade',
                o.employee_category AS 'Employee Category GN/OBC/SC/ST',
                o.sub_category AS 'Employee Sub Category',
                o.emp_epf_no AS 'Employee EPF No.',
                o.emp_esic_no AS 'Employee ESIC No',
                o.skilled_unskilled AS 'Category Skilled/Unskilled',
                o.joining_date AS 'Date of Joining',
                o.agency_name AS 'Outsourcing Agency Name',
                o.agency_mobile AS 'Outsourcing Agency Mobile',
                o.agency_email AS 'Outsourcing Agency Email',
                o.agency_address AS 'Outsourcing Agency Address',
                o.agency_cp_name AS 'Outsourcing Agency Contact Person Name',
                o.agency_cp_mobile AS 'Outsourcing Agency Contact Person Mobile',
                o.minimum_wage AS 'Minimum wage per Month',
                o.epf AS 'EPF @13%',
                o.esi AS 'ESI @3.25%',
                o.gross AS 'Gross',
                o.total_cost AS 'Total Cost',
                o.agency_charge_percent AS 'Agency Service Charge',
                o.gst_percent AS 'GST',
                o.grand_total AS 'Grand Total',
                o.employee_status as 'Employee Status',
                o.emp_status_reason as 'Employee Status Reason',
                o.post_type AS 'Employee post against',
                o.sanctioned_post AS 'Number of Sanctioned post',
                o.remarks AS 'Remarks'
            FROM 
                outsourcing_data o
            JOIN 
                user u ON o.added_by_user_id = u.id
            JOIN 
                master_district m ON o.district_id = m.id
            JOIN 
                roles r ON o.role_id = r.id
            
            WHERE 
                MONTH(o.created_at) = (SELECT MONTH(max(created_at)) from outsourcing_data) AND
                YEAR(o.created_at) = (SELECT YEAR(max(created_at)) from outsourcing_data)
            ORDER BY 
                o.created_at DESC";

            $columns1 = array();
            $columns1[] = "date";
            $columns1[] = "district_name";
            $columns1[] = "format_name";

            $filename = "All_data.csv";

        }
    }

    $result = mysqli_query($conn, $query);

    // print_r($query);
    // die;

    // // print_r($query);
    // // die;

    

    
    
    // Set headers to download the file as a CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Write the header
    $fields = mysqli_fetch_fields($result);
   $header = [
                'Filled by User', 'District Name', 'Filled by Role', 'Format Name', 'Month Data', 
                'Employee Name', 'Hospital Name', 'Hospital Address', 'Employee Father/Husband Name', 
                'Aadhar Card Number', 'Mobile Number', 'Designation','Gender', 'Grade', 
                'Employee Category GN/OBC/SC/ST','Employee Sub Category','Employee EPF No.','Employee ESIC No.', 'Category Skilled/Unskilled', 'Date of Joining', 
                'Outsourcing Agency Name','Outsourcing Agency Mobile','Outsourcing Agency Email','Outsourcing Agency Address','Outsourcing Agency Contact Person Name','Outsourcing Agency Contact Person Mobile', 'Minimum wage per Month', 'EPF @13%', 'ESI @3.25%', 
                'Gross', 'Total Cost', 'Agency Service Charge', 'GST', 'Grand Total', 'Employee Status','Employee Status Reason',
                'Employee post against', 'Number of Sanctioned post', 'Remarks'
            ];
    fputcsv($output, $header);

   
    while ($row = mysqli_fetch_assoc($result)) {
        
        fputcsv($output, $row);
    }

    fclose($output);
    
    
    exit;
    

   
}

else{
    header('location:../index.php');
}


?>
