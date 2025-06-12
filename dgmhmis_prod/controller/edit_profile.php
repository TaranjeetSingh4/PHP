<?php

require_once("config.php");
session_start();
if(isset($_SESSION['email'])){
    $conn=get_db_connection();
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $designation=$_POST['designation'];


    $alternate_email=$_POST['alternate_email'];
    $alternate_phone=$_POST['alternate_phone'];
    $employment_type=$_POST['employment_type'];
    $employee_type=$_POST['employee_type'];

    $hospital_name=$_POST['hospital_name'];
    $hospital_address=$_POST['hospital_address'];
    $sanctioned_beds=$_POST['sanctioned_beds'];
    $functional_beds=$_POST['functional_beds'];
    $cleaning_area=$_POST['cleaning_area'];
    $gardening_area=$_POST['gardening_area'];
    // $go_sanctioned_posts=$_FILES['go_sanctioned_posts'];

 
    
    // Basic validation
    $errors = [];
   
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($phone) || !ctype_digit($phone)) {
        $errors[] = "Phone number must contain only digits.";
    }
    if(isset($alternate_email) && !empty($alternate_email)){
        if (!filter_var($alternate_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Alternate email is invalid.";
        }
    }
    if(isset($alternate_phone) && !empty($alternate_phone)){
        if (!ctype_digit($alternate_phone)) {
            $errors[] = "Alternate phone must contain only digits.";
        }
    }
    
    // If there are validation errors, show them and exit
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        $_SESSION['alert-msg']=implode(" ",$errors);
        exit;
    }

    $first_time_login=1;

    $is_added_by_cmo=$_SESSION['added_by_cmo'];
    
    





    if(isset($is_added_by_cmo) && ($is_added_by_cmo!="1")){
        $sql="update user set `name`='$name', `email`='$email', `phone`='$phone',`designation`='$designation',`alternate_email`='$alternate_email',`alternate_phone`='$alternate_phone',`employment_type`='$employment_type',`employee_type`='$employee_type' where id=$id";
    }
    else{
        if (empty($hospital_name)) {
            $errors[] = "Hospital name is required.";
        }
        if (empty($hospital_address)) {
            $errors[] = "Hospital address is required.";
        }
        if (empty($cleaning_area) || !is_numeric($cleaning_area)) {
            $errors[] = "Cleaning area is required and must be a valid number.";
        }
        if (empty($gardening_area) || !is_numeric($gardening_area)) {
            $errors[] = "Gardening area is required and must be a valid number.";
        }

        if (empty($sanctioned_beds) || !is_numeric($sanctioned_beds)) {
            $errors[] = "Sanctioned Beds is required and must be a valid number.";
        }
        if (empty($functional_beds) || !is_numeric($functional_beds)) {
            $errors[] = "Functional beds is required and must be a valid number.";
        }

        $go_sanctioned_posts_path = null;
        if (isset($_FILES['go_sanctioned_posts']) && $_FILES['go_sanctioned_posts']['error'] === 0) {
            $uploads_dir = dirname(__DIR__) . '/uploads/';
        
            // Create the uploads directory if it doesn't exist
            if (!is_dir($uploads_dir)) {
                mkdir($uploads_dir, 0777, true);
            }
        
            // Get the original file name and its extension
            $file_name = basename($_FILES['go_sanctioned_posts']['name']);
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        
            // Generate a unique name for the file using timestamp and uniqid()
            $unique_name = time() . '_' . uniqid() . '.' . $file_extension;
        
            // Set the path for saving the uploaded file
            $go_sanctioned_posts_path = $uploads_dir . $unique_name;
        
            // Move the uploaded file to the target directory with the unique name
            if (!move_uploaded_file($_FILES['go_sanctioned_posts']['tmp_name'], $go_sanctioned_posts_path)) {
                $errors[] = "Failed to upload the GO sanctioned posts file.";
            }
        } else {
            $errors[] = "GO sanctioned posts file is required.";
        }

        // If there are validation errors, display them and exit
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            // $_SESSION['alert-msg']=implode(" ",$errors);
            print_r(implode(" ",$errors));
            exit;
        }

        

        $sql = "UPDATE user SET 
                name = '$name', 
                email = '$email', 
                phone = '$phone', 
                designation = '$designation', 
                alternate_email = '$alternate_email', 
                alternate_phone = '$alternate_phone', 
                hospital_name = '$hospital_name', 
                hospital_address = '$hospital_address', 
                sanctioned_beds = " . (int)$sanctioned_beds . ", 
                functional_beds = " . (int)$functional_beds . ", 
                cleaning_area = " . (float)$cleaning_area . ", 
                gardening_area = " . (float)$gardening_area . ", 
                employment_type='$employment_type',
                employee_type='$employee_type',
                go_sanctioned_posts = " . ($unique_name ? "'$unique_name'" : "NULL") . ", 
                first_time_login = $first_time_login
            WHERE id = $id";
    }

    // print_r($sql);



    
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);

    print("Profile Updated Successfully!");


}

else{
    header('location:../index.php');
}


?>