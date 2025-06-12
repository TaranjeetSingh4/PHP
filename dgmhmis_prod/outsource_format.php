<?php include('dashboard_outsource_header.php') ?>
<?php


require_once './controller/format_view.php';


session_start();
if(isset($_SESSION['user_role'])){
    $user_role=$_SESSION['user_role'];
}
else{
    header("Location:index.php");
    session_destroy();
}

?>
<section id="main-content" style="min-height: 100vh">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->Outsourcing Data<!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">

               
                        
                    <div class="panel-heading format-edit-panel"> <span class="title elipsis">

                        <?php if($_SESSION['alert-msg'] && isset($user_role) && $user_role!="admin") { ?>
                            <div class="col-md-12">
                                <p class="alert alert-<?php echo $_SESSION['alert-type']; ?>"><?php echo $_SESSION['alert-msg']; ?></p>
                            </div>
                        <?php } ?>
                        <div class="col-md-9 mt-1">
                            <h4>
                                Details of State Budget Outsource Manpower in Healthcare Facilities of Uttar Pradesh
                            </h4>
                            
                        </div>

                        <?php if(isset($user_role) && $user_role!="admin") { ?>
                            <form <?php if(isset($user_role) && $user_role!="admin"){ ?>action="./controller/outsource_form_data.php" method="post" enctype="multipart/form-data"<?php } ?> >
                            <!-- <div class="col-md-3 form-group" style="display:flex">
                                <label style="margin-right:20px; margin-top:10px"><b>Select Date</b> <span class="star">*</span></label>
                                <input type="text" name="filled_data_month_year" class="form-control" value="<?php echo date('m/25',strtotime('-1')) ?>" />
                            
                            </div> -->
                           
                            <!-- <div class="col-md-3 form-group">
                                <select name="field_type[]" style="width:100%;">
                                    <option value="text">String</option>
                                    <option value="number">Integer</option>
                                    <option value="file">File</option>
                                </select>
                            </div> -->
                        <?php } ?>

                        <?php if(isset($user_role) && $user_role=="admin") { ?>
                        
                        <!-- <div class="col-md-1">
                            <a href="edit-template.php?id=<?php echo $res[0]['format_id']; ?>"><button class="btn btn-block btn-primary"><i class="fa fa-pencil-square" aria-hidden="true"></i></button></a>
                        </div>

                        <div class="col-md-1">
                            <a href="./controller/delete-template.php?id=<?php echo $res[0]['format_id']; ?>"><button class="btn btn-block btn-primary"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                        </div> -->
                        <?php } ?>

                        <!-- <div class="col-md-1">
                            <a href="delete-template.php?id=<?php echo $res[0]['format_id']; ?>"><button class="btn btn-block btn-primary"><i class="fa fa-toggle-on" aria-hidden="true"></i></button></a>
                        </div> -->
                        
                        </span> 
                    </div>
                    <div class="panel-body">


                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="hospital_name">Hospital Name <span class="star">*</span></label>
                                <input type="text" id="hospital_name" name="hospital_name"  class="form-control" value="<?php echo $_SESSION['hospital_name']; ?>" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="hospital_address">Hospital Address <span class="star">*</span></label>
                                <input type="text" id="hospital_address" name="hospital_address" class="form-control" value="<?php echo $_SESSION['hospital_address']; ?>" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="employee_name">Employee Name <span class="star">*</span></label>
                                <input type="text" id="employee_name" name="employee_name" class="form-control" >
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="father_husband_name">Employee Father/Husband Name <span class="star">*</span></label>
                                <input type="text" id="father_husband_name" name="father_husband_name"  class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="aadhar_card">Aadhar Card Number <span class="star">*</span></label>
                                <input type="number" id="aadhar_card" name="aadhar_card" class="form-control" >
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="mobile_no">Mobile No. <span class="star">*</span></label>
                                <input type="text" id="mobile_no" name="mobile_no" class="form-control" >
                            </div>

                            <div class="col-md-4 form-group">
                                    <label for="designation">Designation <span class="star">*</span></label>
                                    <input type="text" id="designation" name="designation" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="gender">Employee Gender <span class="star">*</span></label>
                                <!-- <input type="text" id="employee_category" name="employee_category"  > -->
                                
                                <select id="gender" name="gender"  class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="employee_category">Employee Category <span class="star">*</span></label>
                                <!-- <input type="text" id="employee_category" name="employee_category"  > -->
                                
                                <select id="employee_category" name="employee_category"  class="form-control">
                                    <option value="">Select Category</option>
                                    <option value="general">General</option>
                                    <option value="sc">SC</option>
                                    <option value="st">ST</option>
                                    <option value="obc">OBC</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sub_category">Enter Employee Sub-category <span class="star">*</span></label>
                                <input type="text" id="sub_category" name="sub_category" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="emp_epf_no">Enter Employee EPF No. </label>
                                <input type="number" id="emp_epf_no" name="emp_epf_no" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="emp_esic_no">Enter Employee ESIC No.</label>
                                <input type="text" id="emp_esic_no" name="emp_esic_no" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="skilled_unskilled">Category <span class="star">*</span></label>
                                <select id="skilled_unskilled" name="skilled_unskilled" class="form-control" >
                                    <option value="">Select Category Type</option>
                                    <option value="skilled">Skilled</option>
                                    <option value="unskilled">Unskilled</option>
                                
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Employee Grade <span class="star">*</span></label>
                                <select id="grade" name="grade"  >
                                    <option value="">Select Employee Grade</option>
                                    <option value="A">Grade A</option>
                                    <option value="B">Grade B</option>
                                    <option value="C">Grade C</option>
                                    <option value="D">Grade D</option>
                                </select>
                            </div>
                                
                            <div class="col-md-4 form-group">
                                <label for="joining_date">Date of Joining <span class="star">*</span></label>
                                <input type="date" id="joining_date" name="joining_date" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_name">Outsourcing Agency Name <span class="star">*</span></label>
                                <input type="text" id="agency_name" name="agency_name" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_mobile">Outsourcing Agency Mobile <span class="star">*</span></label>
                                <input type="number" id="agency_mobile" name="agency_mobile" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_email">Outsourcing Agency Email <span class="star">*</span></label>
                                <input type="email" id="agency_email" name="agency_email" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_address">Outsourcing Agency Address <span class="star">*</span></label>
                                <input type="text" id="agency_address" name="agency_address" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_validity_from">Outsourcing Agency Validity From Date <span class="star">*</span></label>
                                <input type="date" id="agency_validity_from" name="agency_validity_from" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_validity_to">Outsourcing Agency Validity To Date <span class="star">*</span></label>
                                <input type="date" id="agency_validity_to" name="agency_validity_to" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_cp_name">Outsourcing Agency Contact Person Name <span class="star">*</span></label>
                                <input type="text" id="agency_cp_name" name="agency_cp_name" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_cp_mobile">Outsourcing Agency Contact Person Mobile <span class="star">*</span></label>
                                <input type="number" id="agency_cp_mobile" name="agency_cp_mobile" class="form-control" >
                            </div>
                           
                            <div class="col-md-4 form-group">
                                <label for="minimum_wage">Minimum Wage per Month <span class="star">*</span></label>
                                <input type="number" id="minimum_wage" name="minimum_wage" class="form-control" >
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="epf">EPF @13% <span class="star">*</span></label>
                                <input type="number" id="epf" name="epf" class="form-control"  readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="esi">ESI @3.25% <span class="star">*</span></label>
                                <input type="number" id="esi" name="esi" class="form-control"   readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="gross">Gross <span class="star">*</span></label>
                                <input type="number" id="gross" name="gross" class="form-control"   readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="total_cost">Total Cost <span class="star">*</span></label>
                                <input type="number" id="total_cost" name="total_cost" class="form-control"   readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="agency_charge_percent">Agency Service Charge (in %) <span class="star">*</span></label>
                                <input type="number" id="agency_charge_percent" class="form-control" name="agency_charge_percent"  >
                            </div>        
                            <div class="col-md-4 form-group">
                                <label for="gst_percent">GST (in %) <span class="star">*</span></label>
                                <input type="number" id="gst_percent" name="gst_percent" class="form-control" >
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="agency_charge_amount">Agency Service Charge Amount <span class="star">*</span></label>
                                <input type="number" id="agency_charge_amount" name="agency_charge_amount" class="form-control" readonly>
                            </div>

                            <!-- GST Amount -->
                            <div class="col-md-4 form-group">
                                <label for="gst_amount">GST Amount <span class="star">*</span></label>
                                <input type="number" id="gst_amount" class="form-control" name="gst_amount" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="grand_total">Grand Total <span class="star">*</span></label>
                                <input type="number" id="grand_total" class="form-control" name="grand_total"   readonly>
                            </div>




                            <div class="col-md-4 form-group">
                                <label>Employee Post Against <span class="star">*</span></label>
                                <select id="post_type" name="post_type"  >
                                    <option value="">Select Post Type</option>
                                    <!-- <option value="sanctioned">Outsource Sanctioned Post</option> -->
                                    <option value="non-sanctioned">Non-Sanctioned Post</option>
                                </select>
                            </div>


                            <div class="col-md-4 form-group hidden" id="sanctioned_post_group">
                                <label for="sanctioned_post">Number of Sanctioned Post <span class="star">*</span></label>
                                <input type="number" id="sanctioned_post" name="sanctioned_post" class="form-control">
                            </div>
                            <div class="col-md-4 form-group hidden" id="remarks_group">
                                <label for="remarks">Remarks <span class="star">*</span></label>
                                <textarea id="remarks" name="remarks" class="form-control"></textarea>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="government_order">Approval Orders <span class="star">*</span></label>
                                <input type="file" id="government_order" name="government_orders[]" class="form-control" multiple accept=".pdf,image/jpeg,image/png"  required>
                            </div>
                            
                        </div>

                       


                            
                                <?php if(isset($user_role) && $user_role!="admin") { ?>                                            
                                <div class="row mt-3">
                                    <!-- <div class="col-md-4"></div> -->
                                    <div class="col-md-3">
                                        <input type="submit" value="Submit Form" class="btn btn-block btn-primary">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="reset" value="Reset Form" class="btn btn-block btn-info">
                                    </div>
                                   

                        </form> 
                        <!-- <div class="col-md-3">
                            <a href="edit-format-data.php?id=<?php print_r($id); ?>&user_id=<?php echo $_SESSION['id']; ?>&role_id=<?php echo $_SESSION['login_user_role'] ?>&date=<?php echo date('m'); ?>/25/<?php echo date('Y'); ?>"><button class="btn btn-block btn-warning">Edit Form</button></a>
                        </div> -->
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div> 
                   
<?php include('dashboard-footer.php') ?>