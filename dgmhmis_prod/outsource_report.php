<?php include('dashboard_outsource_header.php')?>
<?php 
require_once('./controller/getOutsourceUserListingData.php'); 
require_once('./controller/fetch_districts.php'); 
require_once('./controller/all_formats.php');
session_start();
if(isset($_SESSION['user_role'])){
    $user_role=$_SESSION['user_role'];
}
else{
    header("Location:index.php");
    session_destroy();
}



?>



<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title" id="type-of-template-listing"><!-- InstanceBeginEditable name="Main Heading" -->All Reports <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <div style="float:left;" class="col-md-5">
                            <h4>Report <?php print_r($arr[0]); ?></h4>
                        </div>
                        </span> 
                    </div>

                    

                   

                    <div class="panel-body">
                        <div class="row" style="padding-left:10px;padding-right:10px">
                            <?php if(isset($user_role)) { ?>
                            <div class="col-md-12">
                                <form method="post" id="filter_outsource_report_form">
                                <div class="row">
                                    <?php if($user_role=="admin"){ ?>
                                    <div class="col-md-2">
                                        <select name="districts" id="districts">
                                            <option value="">All Districts</option>
                                            <?php while($row=mysqli_fetch_assoc($district_result)){ ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['district_name']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <?php } ?>

                                    <!-- <div class="col-md-4 form-group">
                                        <select name="format_id" id="format_id" class="form-control">
                                            <option value="default">All Formats</option>
                                            <?php while($format_row=mysqli_fetch_assoc($format_result)){ ?>
                                                <option value="<?php echo $format_row['id']; ?>"><?php echo $format_row['format_name']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                         -->
                                    <!-- <div class="col-md-2">
                                        <select name="listing_type" id="listing_type">
                                            <option value="default">Select Month</option>
                                            <?php 
                                            $month=01;
                                            
                                            while($month<=12){ 
                                                $formattedMonth = ""; 
                                                while (strlen($formattedMonth) != 2) {
                                                    $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
                                                }
                                            ?>

                                                <option value="<?php echo $formattedMonth; ?>"><?php echo $formattedMonth; ?></option>
                                            <?php 
                                            $month++;
                                            } 
                                            ?>
                                        </select>
                                    </div> -->

                                    <div class="col-md-2">
                                        <input type="date" name="date" id="date" value="Select Date">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <!-- <button class="btn btn-info" id="filter_search">Search</button> -->
                                        <input type="submit" class="btn btn-info" value="Search" id="filter_search">
                                        <button type="button" class="btn  btn-primary" id="downloadOutsouceDataBtn">Download</button>
                                    </div>
                                    
                                </div>
                                </form>
                            
                        
                            
                            </div>
                            <?php } ?>

                        </div>

                        <hr>
                       
                        <div>
                            <p id="alert-data">

                            </p>
                        </div>
                        <div id="response"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-center table-striped" id="default-outsource-filter-table">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                                <td><strong>S. No.</strong></td>
                                                <td><strong>Filled by User</strong></td>
                                                <td><strong>District Name</strong></td>
                                                <td><strong>Filled by Role </strong></td>
                                                <td><strong>Format Name</strong></td>
                                                
                                                <td><strong>Month Data</strong></td>

                                                <td><strong>Employee Name</strong></td>
                                                <td><strong>Hospital Name</strong></td>
                                                <td><strong>Hospital Address</strong></td>
                                                <td><strong>Employee Father/Husband Name</strong></td>
                                                <td><strong>Aadhar Card Number</strong></td>
                                                <td><strong>Mobile Number</strong></td>
                                                <td><strong>Designation</strong></td>
                                                <td><strong>Gender</strong></td>
                                                <td><strong>Grade</strong></td>
                                                <td><strong>Employee Category GN/OBC/SC/ST</strong></td>
                                                <td><strong>Employee Sub Category</strong></td>
                                                <td><strong>Employee EPF No.</strong></td>
                                                <td><strong>Employee ESIC No.</strong></td>
                                                <td><strong>Category Skilled/Unskilled</strong></td>
                                                <td><strong>Date of Joining</strong></td>
                                                <td><strong>Outsourcing Agency Name</strong></td>
                                                <td><strong>Outsourcing Agency Mobile</strong></td>
                                                <td><strong>Outsourcing Agency Email</strong></td>
                                                <td><strong>Outsourcing Agency Address</strong></td>
                                                <td><strong>Outsourcing Agency Contact Person Name</strong></td>
                                                <td><strong>Outsourcing Agency Contact Person Mobile</strong></td>
                                                <td><strong>Minimum wage per Month</strong></td>
                                                <td><strong>EPF @13%</strong></td>
                                                <td><strong>ESI @3.25</strong></td>
                                                <td><strong>Gross</strong></td>
                                                <td><strong>Total Cost</strong></td>
                                                <td><strong>Agency Service Charge</strong></td>
                                                <td><strong>GST</strong></td>
                                                <td><strong>Grand Total</strong></td>
                                                <td><strong>Employee Status</strong></td>
                                                <td><strong>Status Reason</strong></td>
                                                <td><strong>Employee post against</strong></td>
                                                <td><strong>Number of Sanctioned post</strong></td>
                                                <td><strong>Remarks</strong></td>
                                                <td><strong>Government Orders</strong></td>
                                                
                                                <td><strong>Action(s)</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count=1;
                                            foreach($report_array as $key=>$value){
                                                $filePaths = explode(',', $value['government_orders']);
                                             
                                            ?>
                                           
                                            <tr>
                                                <td><strong><?php echo $count; ?></strong></td>
                                                <td><strong><?php echo $value['name']; ?></strong></td>
                                                <td><strong><?php echo $value['district_name']; ?></strong></td>
                                                <td><strong><?php echo $value['role']; ?></strong></td>
                                                <td><strong><?php echo "Outsource Data" ?></strong></td>

                                                <td><strong><?php echo $value['created_at']; ?></strong></td>
                                                <td><strong><?php echo $value['employee_name']; ?></strong></td>
                                                <td><strong><?php echo $value['hospital_name']; ?></strong></td>
                                                <td><strong><?php echo $value['hospital_address']; ?></strong></td>
                                                <td><strong><?php echo $value['father_husband_name']; ?></strong></td>
                                                <td><strong><?php echo $value['aadhar_card']; ?></strong></td>
                                                <td><strong><?php echo $value['mobile_no']; ?></strong></td>
                                                <td><strong><?php echo $value['designation']; ?></strong></td>
                                                <td><strong><?php echo $value['gender']; ?></strong></td>
                                                <td><strong><?php echo "Grade ".$value['grade']; ?></strong></td>
                                                <td><strong><?php echo strtoupper($value['employee_category']); ?></strong></td>
                                                <td><strong><?php echo !empty($value['sub_category']) ? strtoupper($value['sub_category']) : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['emp_epf_no']) ? $value['emp_epf_no'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['emp_esic_no']) ? $value['emp_esic_no'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo ucfirst($value['skilled_unskilled']); ?></strong></td>
                                                <td><strong><?php echo $value['joining_date']; ?></strong></td>
                                                <td><strong><?php echo !empty($value['agency_name']) ? $value['agency_name'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['agency_mobile']) ? $value['agency_mobile'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['agency_email']) ? $value['agency_email'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['agency_address']) ? $value['agency_address'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['agency_cp_name']) ? $value['agency_cp_name'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['agency_cp_mobile']) ? $value['agency_cp_mobile'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo $value['minimum_wage']; ?></strong></td>
                                                <td><strong><?php echo $value['epf']; ?></strong></td>
                                                <td><strong><?php echo $value['esi']; ?></strong></td>
                                                <td><strong><?php echo $value['gross']; ?></strong></td>
                                                <td><strong><?php echo $value['total_cost']; ?></strong></td>
                                                <td><strong><?php echo $value['agency_charge_percent']; ?></strong></td>
                                                <td><strong><?php echo $value['gst_percent']; ?></strong></td>
                                                <td><strong><?php echo $value['grand_total']; ?></strong></td>
                                                <td><strong><?php echo !empty($value['employee_status']) ? $value['employee_status'] : 'Active'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['emp_status_reason']) ? $value['emp_status_reason'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo $value['post_type']; ?></strong></td>
                                                <td><strong><?php echo !empty($value['sanctioned_post']) ? $value['sanctioned_post'] : 'NA'; ?></strong></td>
                                                <td><strong><?php echo !empty($value['remarks']) ? $value['remarks'] : 'NA'; ?></strong></td>
                                                <td>
                                                <?php
                                                    foreach ($filePaths as $file) {
                                                        // echo $filePaths;
                                                        $filePath = "/uploads/" . $file; // Assuming files are stored in the 'uploads' directory
                                                        // print_r($filePath);
                                                        // echo "<a href='http:// . " . __DIR__  . $filePath . "' target='_blank'>$file</a><br>"; // Displaying as a link
                                                        echo "<a href='http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $file . "' target='_blank'>$file</a><br>";

                                                    }
                                                ?>
                                                </td>
                                                <!-- <td><strong><?php echo !empty($value['remarks']) ? $value['remarks'] : 'NA'; ?></strong></td> -->

                                              
                                                <td>
                                                <?php if(isset($user_role) && ($user_role=="admin" || $user_role=="CMO")) { ?>
                                                    <a href="report-view.php?id=<?php echo $value['format_id']; ?>&role_id=<?php echo $value['role']; ?>&district_id=<?php echo $value['district_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <!-- <a href="edit-report.php?format_id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i> </a> -->
                                                    <!-- <a href="./controller/download-report.php?format_id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-download delete" aria-hidden="true" style="margin-right:20px"></i> </a> -->
                                                    <!-- <a href="./controller/hard-delete-template.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash delete" aria-hidden="true"></i></a> -->
                                                <?php } else{ ?>
                                                    <!-- <a href="report-view.php?id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a> -->
                                                    <a href="edit-outsource-user-data.php?id=<?php echo $value['row_id']; ?>"><i class="fa fa-pencil edit" aria-hidden="true"></i> </a>
                                                    <!-- <a href="./controller/verify_data.php?id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-check-circle verified" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <a href="./controller/unverify_data.php?id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-check-circle-o unverified" aria-hidden="true"></i> </a> -->
                                                <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $count=$count+1; } ?>
                                            
                                            
                                        </tbody>
                                    </table>


                                    <table class="table text-center table-striped hidden" id="filter-outsource-report-table">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                            <td><strong>S. No.</strong></td>
                                                <td><strong>Filled by User</strong></td>
                                                <td><strong>District Name</strong></td>
                                                <td><strong>Filled by Role </strong></td>
                                                <td><strong>Format Name</strong></td>
                                                
                                                <td><strong>Month Data</strong></td>


                                                <td><strong>Hospital Name</strong></td>
                                                <td><strong>Hospital Address</strong></td>
                                                <td><strong>Employee Father/Husband Name</strong></td>
                                                <td><strong>Aadhar Card Number</strong></td>
                                                <td><strong>Mobile Number</strong></td>
                                                <td><strong>Designation</strong></td>
                                                <td><strong>Gender</strong></td>
                                                <td><strong>Grade</strong></td>
                                                <td><strong>Employee Category GN/OBC/SC/ST</strong></td>
                                                <td><strong>Employee Sub Category</strong></td>
                                                <td><strong>Employee EPF No.</strong></td>
                                                <td><strong>Employee ESIC No.</strong></td>
                                                <td><strong>Category Skilled/Unskilled</strong></td>
                                                <td><strong>Date of Joining</strong></td>
                                                <td><strong>Outsourcing Agency Name</strong></td>
                                                <td><strong>Outsourcing Agency Mobile</strong></td>
                                                <td><strong>Outsourcing Agency Email</strong></td>
                                                <td><strong>Outsourcing Agency Address</strong></td>
                                                <td><strong>Outsourcing Agency Contact Person Name</strong></td>
                                                <td><strong>Outsourcing Agency Contact Person Mobile</strong></td>
                                                <td><strong>Minimum wage per Month</strong></td>
                                                <td><strong>EPF @13%</strong></td>
                                                <td><strong>ESI @3.25</strong></td>
                                                <td><strong>Gross</strong></td>
                                                <td><strong>Total Cost</strong></td>
                                                <td><strong>Agency Service Charge</strong></td>
                                                <td><strong>GST</strong></td>
                                                <td><strong>Grand Total</strong></td>
                                                <td><strong>Employee Status</strong></td>
                                                <td><strong>Status Reason</strong></td>
                                                <td><strong>Employee post against</strong></td>
                                                <td><strong>Number of Sanctioned post</strong></td>
                                                <td><strong>Remarks</strong></td>
                                                <td><strong>Government Orders</strong></td>
                                                
                                                <td><strong>Action(s)</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            
                                            
                                            
                                            
                                        </tbody>
                                        
                                    </table>

                                    <p id="alert-data" class="hidden text-center"></p>

                                    

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
            

            

                 
<?php include('dashboard-footer.php') ?>