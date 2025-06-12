<?php include('dashboard-header.php')?>

<?php 

require_once './controller/config.php';
// require_once './controller/get_roles.php';
require_once './controller/get_active_roles.php';

session_start();

$conn=get_db_connection();

$query="select * from roles order by role asc";
$result=mysqli_query($conn,$query);

$result_filter=mysqli_query($conn,$query);

require_once './controller/fetch_division.php';
require_once './controller/fetch_districts.php';

$id=$_SESSION['id'];
$get_user_query="select user.id,user.name as username,user.email,user.division_id,user.district_id,master_division.name as division_name,master_district.district_name from user join master_division on user.division_id=master_division.id join master_district on user.district_id = master_district.id where user.id=$id";
$get_user_data_result=mysqli_query($conn,$get_user_query);
$get_user_data_row=mysqli_fetch_assoc($get_user_data_result);





?>

            <section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
                <div class="content-title">
                    <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->
Welcome <strong> <?php echo $_SESSION['username'] ?></strong><!-- InstanceEndEditable --></h3>
                    
                </div>
                <div id="content" class="dashboard padding-20 margin-bottom-50">
                <div class="row">
                 <!-- InstanceBeginEditable name="content" -->
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading"> <span class="title elipsis">
                      <h4>Add User(s)</h4>
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
                    <form action="#" method="POST" id="add_user_form">
                    <div class="row">

                        <div id="show_user_section">
                        <?php if($_SESSION['user_role'] == "admin") { ?>
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Division Name <span class="star">*</span></label><br>
                                <select name="division_id" id="selectDivision" class="form-control" onchange="getDistrict(this.value)">
                                    <option value="">------- Select Division ------------</option>
                                    <?php
                                    while($row=mysqli_fetch_assoc($division_result)){
                                      
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3 col-xs-12">
                          
                            <div class="form-group">
                                <label>District Name <span class="star">*</span></label><br>
                                <select name="district_id" id="selectDistrict" class="form-control">
                                    <option value="">------- Select District ------------</option>
                                </select>
                            </div>
                        </div>
                        <?php } else{ ?>

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
                                    <?php
                                    while($row=mysqli_fetch_assoc($final_active_roles_result)){
                                      
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"  ><?php echo $row['role']; print_r($role_array) ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                      
                                                    
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>User Role / Facility Name <span class="star">*</span></label>
                                <input required name="facility_name" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Name <span class="star">*</span></label>
                                <input required name="name" class="form-control" type="text">
                            </div>
                        </div>
               
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Email ID <span class="star">*</span></label>
                                <input required name="email" class="form-control" type="email">
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Mobile No. <span class="star">*</span></label>
                                <input required name="phone" class="form-control" type="number" maxlength="10">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Designation <span class="star">*</span></label>
                                <input required name="designation" class="form-control" type="text">
                            </div>
                        </div>
                        <!-- <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Role <span class="star">*</span></label><br>
                                <select name="role[]" class="form-control multiselect" id="multiple-roles" role="multiselect" multiple="multiple">
                                    <?php
                                    while($row=mysqli_fetch_assoc($result)){
                                      
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['role']; ?></option>
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
                        <?php if($_SESSION['user_role']=='admin') { ?>
                        <div class="col-md-2 col-xs-12 mt-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-info" id="save_user_btn" value="Add User">
                                <!-- <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button> -->
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <?php if($_SESSION['user_role']=='DNO' || $_SESSION['user_role']=='CMO') { ?>
                        <div class="col-md-2 col-xs-12 mt-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-info" id="save_sub_user_btn" value="Add Sub user">
                                <!-- <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button> -->
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </form>
              </div>
              </div>

              <div class="row" >
                <div class="col-md-12">
                        <div class="panel-heading" style="margin-top:20px"> 
                            <h4>User Listing</h4>
                        </div>
                </div>

                <div class="col-md-12">
                        <form action="#" method="post" id="filter_form">
                        <!-- <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Designation <span class="star">*</span></label>
                                <input name="designation" class="form-control" type="text">
                            </div>
                        </div> -->
                        <?php if($_SESSION['user_role']=="admin"){ ?>
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>District Name <span class="star">*</span></label>
                                <select name="district_id" class="form-control">
                                    <option value="null" id="choose-role" style="color:grey">------- Choose District -------</option>
                                   
                                    <?php
                                    while($row=mysqli_fetch_assoc($district_result)){
                                      
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['district_name']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Role <span class="star">*</span></label>
                                <select name="role" class="form-control">
                                    <option value="null" id="choose-role" style="color:grey">------- Choose Role -------</option>
                                   
                                    <?php
                                    while($row_filter=mysqli_fetch_assoc($result_filter)){
                                      
                                    ?>
                                    <option value="<?php echo $row_filter['id'] ?>"><?php echo $row_filter['role']; ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12 mt-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-primary" id="filter_user_btn" value="Search">
                                <!-- <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button> -->
                            </div>
                        </div>
                        <?php } ?>
                        

                       

                        
                        </form>

                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table text-center" style="justify-content:center;align-item:center;" id="userTable">
                                    <thead class="thead-dark padding-top-10">
                                        <tr style="font-weight:bold">
                                            <td>S. No.</td>
                                            <td>Name</td>
                                            <td>Username</td>
                                            <td>Password</td>
                                            <td>Phone</td>
                                            <td>District</td>
                                            <td>Designation</td>
                                            <td>Role</td>
                                            
                                            <td>Total Users</td>
                                            <td>Data Filled</td>
                                            
                                            <td>Status</td>
                                            <!-- <td>Last Login</td>
                                            <td>Last Logout</td> -->
                                            <td>Action(s)</td>
                                            <td>Message</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                                <table class="table text-center hidden" style="justify-content:center;align-item:center;" id="userTableFilter">
                                    <thead class="thead-dark padding-top-10">
                                        <tr style="font-weight:bold">
                                            <td>S. No.</td>
                                            <td>Name</td>
                                            <td>Username</td>
                                            <td>Password</td>
                                            <td>Phone</td>
                                            <td>District</td>
                                            <td>Designation</td>
                                            <td>Role</td>
                                            <td>status</td>
                                            <!-- <td>Last Login</td>
                                            <td>Last Logout</td> -->
                                            <td>Action(s)</td>
                                            <td>Message</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                    <p id="error_show" class="hidden">No Data Found</p>
                                </table>
                            </div>
                        </div>
                </div>

                
                
              </div>

                     
                    </div>
                  </div>
              </div> 
                   
               
                 
<?php include('dashboard-footer.php'); ?>
