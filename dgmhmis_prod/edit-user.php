<?php include('dashboard-header.php')?>

<?php 

require_once './controller/config.php';
require_once './controller/get_active_roles.php';
require_once './controller/fetch_division.php';

session_start();

$conn=get_db_connection();
$userid=$_GET['id'];
$query="select * from roles order by role asc";
$result=mysqli_query($conn,$query);



$user_query="SELECT user.*,role_mapping.role_id from user join role_mapping on user.id=role_mapping.user_id where user.id=$userid";
$user_res=mysqli_query($conn,$user_query);
$row_user=mysqli_fetch_assoc($user_res);

$roles_array=explode(",",$row_user['role_id']);

//$id=$_SESSION['id'];
$get_user_query="select user.id,user.name as username,user.email,user.division_id,user.district_id,master_division.name as division_name,master_district.district_name from user join master_division on user.division_id=master_division.id join master_district on user.district_id = master_district.id where user.id=$userid";
$get_user_data_result=mysqli_query($conn,$get_user_query);
$get_user_data_row=mysqli_fetch_assoc($get_user_data_result);

$selectedDivision = $get_user_data_row['division_id'];
$selectedDistrict = $get_user_data_row['district_id'];

// Fetch districts based on selected division
$districtsQuery = "SELECT * FROM master_district WHERE division_id = '$selectedDivision'";

$filteredDistrictsResult=mysqli_query($conn,$districtsQuery);

?>

            <section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
                <div class="content-title">
                    <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->
Welcome To <strong> Admin</strong><!-- InstanceEndEditable --></h3>
                    
                </div>
                <div id="content" class="dashboard padding-20 margin-bottom-50">
                <div class="row">
                 <!-- InstanceBeginEditable name="content" -->
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading"> <span class="title elipsis">
                      <h4>Edit User</h4>
                    </span> </div>
                    <div class="panel-body">
                 <div class="row">
                 <?php if(isset($_SESSION['alert_msg'])){ ?>
                 <div class="col-md-12">
                    <div class="alert alert-<?php echo $_SESSION['alert-type']; ?>" id="show_alert_user">
                        <strong><?php echo $_SESSION['alert_msg']; ?></strong> 
                    </div>
                 </div>
                 <?php } ?>


                   
                
                 <div class="col-md-12">
                    <form action="./controller/edit_user.php" method="POST">
                    <div class="row">



                        <div id="show_user_section">


                        <?php if($_SESSION['user_role'] == "admin") { ?>
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Division Name <span class="star">*</span></label><br>
                                <select name="division_id" id="selectDivision" class="form-control" onchange="fetchDistricts(this.value)">
                                    <option value="">------- Select Division ------------</option>
                                    <?php
                                    while($row=mysqli_fetch_assoc($division_result)){
                                      
                                    ?>
                                    <option value="<?php echo $row['id'] ?>" <?php if($row['id'] == $row_user['division_id']) {?> selected <?php } ?> ><?php echo $row['name']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3 col-xs-12">
                          
                            <div class="form-group">
                                <label>District Name <span class="star">*</span></label><br>
                                <select name="district_id" id="district" class="form-control">
                                    <!-- <option value="">------- <?php print_r($filteredDistricts) ?>------------</option> -->
                                    <?php
                                    while($filteredDistricts=mysqli_fetch_assoc($filteredDistrictsResult)){
                                    ?>
                                    <option value="<?= $filteredDistricts['id']; ?>" <?= $selectedDistrict == $filteredDistricts['id'] ? 'selected' : ''; ?>>
                <?= $filteredDistricts['district_name']; ?>
                                    </option>
                                    <?php } ?>
                                    
                                  
                                </select>
                            </div>
                        </div>

                        <?php } else { ?>
                            <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Division Name <span class="star">*</span></label><br>
                                <input type="text" class="form-control hidden" name="division_id" value="<?php echo $get_user_data_row['division_id'] ?>" readonly/>
                                <input type="text" class="form-control" name="division_name" value="<?php echo $get_user_data_row['division_name'] ?>" readonly/>
                            </div>
                        </div>


                        <div class="col-md-3 col-xs-12">
                          
                            <div class="form-group">
                                <label>District Name <span class="star">*</span></label><br>
                                <input type="text" class="form-control hidden" name="district_id" value="<?php echo $get_user_data_row['district_id'] ?>" readonly>
                                <input type="text" class="form-control" name="district_name" value="<?php echo $get_user_data_row['district_name'] ?>" readonly/>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Role<span class="star">*</span></label><br>
                                <select name="role" id="selectDistrict" class="form-control">
                                    <option value="">------- Select Role ------------</option>
                                    <?php
                                    while($row=mysqli_fetch_assoc($final_active_roles_result)){
                                      
                                    ?>
                                    <option value="<?php echo $row['id'] ?>" <?php if($row['id'] == $row_user['role_id']) { ?> selected <?php } ?> ><?php echo $row['role']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                      
                                                    
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>User Role Facility Name <span class="star">*</span></label>
                                <input required name="facility_name" class="form-control" type="text" value="<?php if($row_user['facility_name']) { echo $row_user['facility_name'];} else{ echo "NA"; }?>">
                            </div>
                        </div>

                       

                        <div class="col-md-1 col-xs-12 hidden">
                            <div class="form-group">
                                <input required name="id" class="form-control" value="<?php echo $userid; ?>" type="text">
                            </div>
                        </div>
                                                    
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Name <span class="star">*</span></label>
                                <input required name="name" class="form-control" value="<?php echo $row_user['name']; ?>" type="text">
                            </div>
                        </div>
               
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Email ID <span class="star">*</span></label>
                                <input required readonly name="email" class="form-control" value="<?php echo $row_user['email']; ?>" type="email">
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Mobile No. <span class="star">*</span></label>
                                <input required name="phone" class="form-control" type="number" value="<?php echo $row_user['phone']; ?>" maxlength="10">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Designation <span class="star">*</span></label>
                                <input required name="designation" class="form-control" value="<?php echo $row_user['designation']; ?>" type="text">
                            </div>
                        </div>
                        <!-- <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Role <span class="star">*</span></label><br>
                                <select name="role[]" class="form-control multiselect" role="multiselect" multiple="multiple" id="roles">
                                    
                                    <?php
                                    while($row=mysqli_fetch_assoc($result)){
                                        $role_id=$row['id'];
                                    ?>
                                    <option value="<?php echo $row['id'] ?>" <?php if(in_array($role_id,$roles_array)){ ?>selected<?php } ?>><?php echo $row['role']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> -->


                        <!-- <div class="col-md-1 mt-2">
                            <button><i class="fa fa-trash" aria-hidden="true" style="font-size:2rem; background:red; color:white; padding:10px"></i></button>
                        </div> -->
                        </div>

                      
                        <!-- <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-block btn-danger add_user_btn">Add More User</button>
                                <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button>
                            </div>
                        </div> -->
                        
               
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-info" value="Save">
                                <!-- <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button> -->
                            </div>
                        </div>
                    </div>
                </form>
              </div>
              </div>

          

              
                     
                 <p>&nbsp;</p>   
                 <p>&nbsp;</p>
                 <p>&nbsp;</p> 
                     
                    </div>
                  </div>
              </div> 
                   
               
                 
<?php include('dashboard-footer.php'); ?>
