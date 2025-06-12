<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $user_id=$_SESSION['id'];
    $role_id=$_SESSION['login_user_role'];
    $division_id = $_SESSION['division_id'];
    $district_id=$_SESSION['district_id'];
    $currentDate = date('Y-m-d H:i:s');

    $uploadDir = dirname(__DIR__) . '/uploads/';
   
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    


    $requiredFields = [
        'hospital_name', 'hospital_address', 'employee_name', 'father_husband_name',
        'aadhar_card', 'mobile_no', 'designation','gender','grade', 'employee_category','sub_category',
        'agency_mobile','skilled_unskilled', 'joining_date', 'agency_name','agency_email','agency_address','agency_validity_from',
        'agency_validity_to', 'agency_cp_name','agency_cp_mobile','minimum_wage',
        'agency_charge_percent', 'gst_percent', 'post_type','government_orders'
    ];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {

            $_SESSION['alert-msg']="This '$field' is required.";
            $_SESSION['alert-type']="warning";

        }
    }


    $hospital_name = $_POST['hospital_name'];
    $hospital_address = $_POST['hospital_address'];
    $employee_name = $_POST['employee_name'];
    $father_husband_name = $_POST['father_husband_name'];
    $aadhar_card = $_POST['aadhar_card'];
    $mobile_no = $_POST['mobile_no'];
    $designation = $_POST['designation'];
    $gender = $_POST['gender'];
    $grade = $_POST['grade'];
    $employee_category = $_POST['employee_category'];
    $employee_sub_category = $_POST['sub_category'];
    $employee_epf_no = $_POST['emp_epf_no'];
    $emp_esic_no=$_POST['emp_esic_no'];
    $skilled_unskilled = $_POST['skilled_unskilled'];
    $joining_date = $_POST['joining_date'];
    $agency_name = $_POST['agency_name'];
    $agency_mobile = $_POST['agency_mobile'];
    $agency_email = $_POST['agency_email'];
    $agency_address = $_POST['agency_address'];
    $agency_validity_from = $_POST['agency_validity_from'];
    $agency_validity_to = $_POST['agency_validity_to'];
    $agency_cp_name = $_POST['agency_cp_name'];
    $agency_cp_mobile = $_POST['agency_cp_mobile'];
    $minimum_wage = $_POST['minimum_wage'];
    $epf = $_POST['epf'];
    $esi = $_POST['esi'];
    $gross = $_POST['gross'];
    $total_cost = $_POST['total_cost'];
    $agency_charge_percent = $_POST['agency_charge_percent'];
    $agency_charge_amount = $_POST['agency_charge_amount'];
    $gst_percent = $_POST['gst_percent'];
    $gst_amount = $_POST['gst_amount'];
    $grand_total = $_POST['grand_total'];
    $post_type = $_POST['post_type'];
    // $sanctioned_post = $_POST['sanctioned_post'];
    // $sanctioned_post = isset($_POST['sanctioned_post']) ? $_POST['sanctioned_post'] : 0;
    // Assuming you are handling $_POST['sanctioned_post'] as empty or not provided
    $sanctioned_post = isset($_POST['sanctioned_post']) && $_POST['sanctioned_post'] !== '' ? $_POST['sanctioned_post'] : NULL;

    
    
    

    $remarks = $_POST['remarks'];

    $government_order = $_FILES['government_orders'];



    if (isset($_FILES['government_orders']) && !empty($_FILES['government_orders']['name'][0])) {
        $files = $_FILES['government_orders'];
        $fileCount = count($files['name']);
        $uploadedFiles = [];
        
       
    
        for ($i = 0; $i < $fileCount; $i++) {
            // Extract file details
            $fileName = basename($files['name'][$i]);
            $fileTmpName = $files['tmp_name'][$i];
            $fileSize = $files['size'][$i];
            $fileError = $files['error'][$i];
            $fileType = $files['type'][$i];

            
    
            // Check for errors
            if ($fileError === UPLOAD_ERR_OK) {
                // Optional: Validate file type and size (example: max 5MB, only images)
                $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                $maxFileSize = 5 * 1024 * 1024; // 5MB
    
                if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
                    // Define the file path to save
                    // $filePath = $uploadDir . $fileName;
                    $file_extension = pathinfo($fileName, PATHINFO_EXTENSION);

                    $unique_name = time() . '_' . uniqid() . '.' . $file_extension;
        
                    // Set the path for saving the uploaded file
                    $filePath = $uploadDir . $unique_name;
                    
                //     echo "$fileTmpName";
                //  print_r($filePath);
                //         die;
    
                    // Move the uploaded file to the directory
                    if(move_uploaded_file($fileTmpName, $filePath)) {
                        // $uploadedFiles[] = $fileName;
                        $uploadedFiles[]=$unique_name;
                      
                        
                    } else {
                        $_SESSION['alert-msg']="Error uploading file: $fileName<br>";
                        $_SESSION['alert-type']="danger";
                       
                        // exit;
                        // echo "Error uploading file: $fileName<br>";
                    }
                } else {
                    $_SESSION['alert-msg']="File $fileName is not valid (type/size issue).<br>";
                    $_SESSION['alert-type']="danger";
                   
                    // echo "File $fileName is not valid (type/size issue).<br>";
                }
            } else {
                $_SESSION['alert-msg']="Error with file: $fileName<br>";
                $_SESSION['alert-type']="danger";
               
                // echo "Error with file: $fileName<br>";
            }
        }
    
        // Check if any files were successfully uploaded
        if (!empty($uploadedFiles)) {
            $_SESSION['alert-msg']="Successfully Uploaded Files!";
            $_SESSION['alert-type']="success";
            $filePaths = implode(',', $uploadedFiles);
            $query = "
            INSERT INTO outsourcing_data (
                added_by_user_id, role_id, division_id, district_id, 
                hospital_name, hospital_address, employee_name, 
                father_husband_name, aadhar_card, mobile_no, designation, gender, grade,
                employee_category,sub_category,emp_epf_no,emp_esic_no, skilled_unskilled, joining_date, 
                agency_name, agency_mobile, agency_email, agency_address, 
                agency_validity_from, agency_validity_to, agency_cp_name, 
                agency_cp_mobile, minimum_wage, epf, esi, gross, total_cost, 
                agency_charge_percent, agency_charge_amount, gst_percent, 
                gst_amount, grand_total, post_type, sanctioned_post, remarks, government_orders
            ) VALUES (
                '$user_id', '$role_id', '$division_id', '$district_id', 
                '$hospital_name', '$hospital_address', '$employee_name', 
                '$father_husband_name', '$aadhar_card', '$mobile_no', '$designation', '$gender', '$grade',
                '$employee_category','$employee_sub_category','$emp_epf_no','$emp_esic_no', '$skilled_unskilled', '$joining_date', 
                '$agency_name', '$agency_mobile', '$agency_email', '$agency_address', 
                '$agency_validity_from', '$agency_validity_to', '$agency_cp_name', 
                '$agency_cp_mobile', '$minimum_wage', '$epf', '$esi', '$gross', '$total_cost', 
                '$agency_charge_percent', '$agency_charge_amount', '$gst_percent', 
                '$gst_amount', '$grand_total', '$post_type', '$sanctioned_post', '$remarks', '$filePaths'
            )";

         
           
            if (mysqli_query($conn, $query)) {
                // echo "Data inserted successfully!";
                $_SESSION['alert-msg']="Form Submitted Successfully!";
                $_SESSION['alert-type']="success";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        
          
            // echo "Successfully uploaded files: " . implode(", ", $uploadedFiles);
        } else {
            $_SESSION['alert-msg']="No Files Uploaded!";
            $_SESSION['alert-type']="danger";
            // echo "No files were uploaded.";
        }
    } else {
        $_SESSION['alert-msg']="Please upload at least one file!";
        $_SESSION['alert-type']="warning";
        // echo "Please upload at least one file.";
    }


    // // date data starts
    // $dateString=$_POST['filled_data_month_year'];
    // $date = DateTime::createFromFormat('m/d/Y', $dateString);
    // if ($date) {
    //     // Extract the month
    //     $month = $date->format('m');
    //     // Extract the year
    //     $year = $date->format('Y');
    // }






    // header("location:../format-template-view.php?id=". urlencode($format_id));
    header("Location:../outsource_format.php");
    exit();
    


   
}
else{
    header('location:../index.php');
}


?>