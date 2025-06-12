<?php include('dashboard-header.php')?>

<?php require_once('./controller/view_profile.php'); ?>
<?php 



session_start();
$logged_in_user_role=$_SESSION['user_role'];
$is_added_by_cmo=$_SESSION['added_by_cmo'];


?>
            <section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
                <div class="content-title">
                    <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->
Welcome To <strong> Profile</strong><!-- InstanceEndEditable --></h3>
                    
                </div>
                <div id="content" class="dashboard padding-20 margin-bottom-50">
                <div class="row">
                 <!-- InstanceBeginEditable name="content" -->
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading"> <span class="title elipsis">
                      <h4>My Profile</h4>
                    </span> </div>
                    <div class="panel-body">
                 <div class="row">
                 <div class="col-md-10">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if(isset($_SESSION['alert-msg'])) { ?>
                                <p><?php echo $_SESSION['alert-msg']; ?></p>
                            <?php } ?>
                        </div>
                    </div>


                    <form action="#" method="POST" id="edit_profile_form" enctype="multipart/form-data">
                    <div class="row">


                        
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Your Name</label>
                                <input required name="name" class="form-control" type="text" value="<?php echo $row['name']; ?>">
                            </div>
                        </div>
               
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Email ID <span class="star">*</span></label>
                                <input  name="email" class="form-control" type="email" value="<?php echo $row['email']; ?>" required readonly>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Alternate Email ID </label>
                                <input name="alternate_email" class="form-control" type="email" value="<?php echo $row['alternate_email']; ?>">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Mobile No. <span class="star">*</span></label>
                                <input required name="phone" class="form-control" value="<?php echo $row['phone']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Alternate Mobile No. </label>
                                <input name="alternate_phone" class="form-control" value="<?php echo $row['alternate_phone']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Designation <span class="star">*</span></label>
                                <input required name="designation" class="form-control" value="<?php echo $row['designation']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Employment Type <span class="star">*</span></label>
                                <!-- <input required name="hospital_address" class="form-control" value="<?php echo $row['hospital_address']; ?>" type="text"> -->
                                <select name="employment_type" id="">
                                    <option value="" > Select Employment Type </option>
                                    <option value="permanent" <?= $row['employment_type'] == 'permanent' ? 'selected' : '' ?>>Permanent</option>
                                    <option value="contractual" <?= $row['employment_type'] == 'contractual' ? 'selected' : '' ?>>Contractual</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Employee Type <span class="star">*</span></label>
                                <!-- <input required name="hospital_address" class="form-control" value="<?php echo $row['hospital_address']; ?>" type="text"> -->
                                <select name="employee_type" id="">
                                    <option value="" >Select Employee Type </option>
                                    <option value="doctor_surgeon" <?= $row['employee_type'] == 'doctor_surgeon' ? 'selected' : '' ?>>Doctor Surgeon</option>
                                    <option value="hygienist" <?= $row['employee_type'] == 'hygienist' ? 'selected' : '' ?>>Hygienist</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Role <span class="star">*</span></label>
                                <input required name="role" class="form-control" value="<?php echo $row_role['role']; ?>" type="text" readonly>
                            </div>
                        </div>

                        <?php if(isset($logged_in_user_role) && !in_array($logged_in_user_role, ["admin","DNO", "CMO"]) && $is_added_by_cmo==1) { ?>
                        
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Hospital Name <span class="star">*</span></label>
                                <input required name="hospital_name" class="form-control" value="<?php echo $row['hospital_name']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Hospital Address <span class="star">*</span></label>
                                <input required name="hospital_address" class="form-control" value="<?php echo $row['hospital_address']; ?>" type="text">
                            </div>
                        </div>

                        



                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>No. of Sanctioned Beds <span class="star">*</span></label>
                                <input required name="sanctioned_beds" class="form-control" value="<?php echo $row['sanctioned_beds']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>No. of Functional Beds <span class="star">*</span></label>
                                <input required name="functional_beds" class="form-control" value="<?php echo $row['functional_beds']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Total Cleaning Area (in square-meter)<span class="star">*</span></label>
                                <input required name="cleaning_area" class="form-control" value="<?php echo $row['cleaning_area']; ?>" type="text">
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Total Gardening Area (in square-meter)<span class="star">*</span></label>
                                <input required name="gardening_area" class="form-control" value="<?php echo $row['gardening_area']; ?>" type="text">
                            </div>
                        </div>


                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Upload GO for Sanctioned Posts<span class="star">*</span></label>
                                <input required name="go_sanctioned_posts" class="form-control" value="<?php echo $row['go_sanctioned_posts']; ?>" type="file">
                            </div>

                            <?php if (!empty($row['go_sanctioned_posts'])):
                                $file=$row['go_sanctioned_posts'];
                                $filePath = "/uploads/" . $row['go_sanctioned_posts'];
                                echo "<a href='http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $file . "' target='_blank'>$file</a><br>";

                            ?>
                                
                               

                            <?php endif; ?>

                        </div>

                        <?php } ?>

                       

                        <div class="col-md-1 hidden">
                            <div class="form-group">
                                <input required name="id" class="form-control" value="<?php echo $row['id']; ?>" type="text">
                            </div>
                        </div>
           
               
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-info" id="edit_profile_btn" value="Save">
                                <!-- <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button> -->
                            </div>
                        </div>
                    </div>
                </form>
              </div>
              <div class="col-md-2">
              <img src="images/default-image.jpg" class="img-responsive profilepic" />
              </div>
              </div>
                     
                 <p>&nbsp;</p>   
                 <p>&nbsp;</p>
                 <p>&nbsp;</p> 
                     
                    </div>
                  </div>
              </div> 
                   
               
                 
<?php include('dashboard-footer.php'); ?>
