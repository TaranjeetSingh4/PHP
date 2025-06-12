<?php

require_once("config.php");

session_start();

if(isset($_SESSION['email'])){
   if (isset($_POST['formType'])) {
    $formType = $_POST['formType'];

    if ($formType == 'user') {
        // Output the User Form
        echo `
                <div class="col-md-12">
                    <form action="#" method="POST" id="add_user_form">
                    <div class="row">

                        <div id="show_user_section">

                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Division Name <span class="star">*</span></label><br>
                                <select name="division_id" id="selectDivision" class="form-control">
                                    <?php
                                    while($row=mysqli_fetch_assoc($division_result)){
                                      
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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

                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>User Role <span class="star">*</span></label><br>
                                <select style="width:100%">
                                   <option value="">CHC</option>
                                   <option value="">PHC</option>
                                   <option value="">DH</option>
                                </select>
                            </div>
                        </div>
                                                    
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>User role facility Name <span class="star">*</span></label>
                                <input required name="name" class="form-control" type="text">
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
                        <div class="col-md-3 col-xs-12">
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
                        </div>

                       


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
                        <div class="col-md-2 col-xs-12 mt-2">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-info" id="save_user_btn" value="Save">
                                <!-- <button type="button" class="btn btn-block btn-info" id="edit_profile_btn">Save</button> -->
                            </div>
                        </div>
               
                    </div>
                </form>
              </div>`;
    } elseif ($formType == 'subUser') {
        // Output the Sub-User Form
        echo '
        <form action="submit_sub_user.php" method="POST">
            <h2>Add Sub-User</h2>
            <label for="parentUser">Parent User:</label><br>
            <input type="text" id="parentUser" name="parentUser"><br>
            <label for="subUsername">Sub-User Username:</label><br>
            <input type="text" id="subUsername" name="subUsername"><br><br>
            <input type="submit" value="Add Sub-User">
        </form>';
    }
}
}

else{
    header('location:../index.php');
}

?>