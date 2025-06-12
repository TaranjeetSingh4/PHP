<?php 
    include('header.php');
    session_start();

    require './controller/config.php';

    $conn=get_db_connection();

    $query="select * from roles order by role asc";
    $result=mysqli_query($conn,$query);

?>


<header>
<div class="col-md-4 col-sm-12 d-flex">
    <img src="images/logoEng.png" class="img-responsive" alt="logo" width="12%" />
    <span class="ml-1 mt-1">
        <p class="heading">Department of Medical, Health & Family Welfare
            <br><b>Government of Uttar Pradesh</b>
        </p>

    </span>
</div>
<div class="col-md-5 col-sm-12 main-head">Director General Management Infomation System<br>
    <span>Directorate General and Medical Health Services, Uttar Pradesh</span>
</div>
<!-- <div class="col-md-1 col-sm-12 hidden-sm hidden-xs up-logo"><img src="images/amrut.png" class="img-responsive" alt="AMRUT" /></div> -->
<div class="col-md-1 col-sm-12 hidden-sm hidden-xs up-logo"><img src="images/up-logo.png" height="100%" class="img-responsive"
        alt="logo" /></div>
</header>
<div class="col-md-7 text-area">

<div class="row">
    <div class="col-md-12">
        <h3>Directorate General and Medical Health Services Medical Health Management System<br> Uttar Pradesh
        </h3>
        <p>To avail the benefits of medical services of DGMH<br> Uttar Pradesh.</p>
        <!-- <img src="images/bg-image.png" class="pull-right" /> -->
        <ul>
            <li>Format Preparation</li>
            <li>Reports &amp; Lists</li>
            <li>Issuance of Licence</li>
            <li>Advertisement Tax </li>
            <li>Building Permission </li>
            <li>Mutation</li>
            <li>Complaints &amp; Grievances</li>
        </ul>

    </div>
</div>



</div>
<div class="col-md-5 custom-class">
<div class="loginwrap">

    <div id="login">
        <h3>Login</h3>
        <?php if($_SESSION['alert_msg']) { ?>
        <div id="show_alert">
            <h5><?php echo $_SESSION['alert_msg']; ?></h5>
        </div>
        <?php } session_destroy();?>
        <p>&nbsp;</p>

        
        
        <form action="./controller/login.php" id="login-form" method="post">

            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label>User Role</label>
                        <select name="role" class="form-control">
                            <option value="null" id="choose-role" style="color:grey">------ Choose Role ---------</option>
                            <!-- <option value="SHASAN" disabled>Shasan</option>
                            <option value="DG_FAMILY_WELFARE" disabled>DG Family Welfare</option>
                            <option value="DG_TRAINING" disabled>DG Training</option>
                            <option value="1">Administrator</option>
                            <option value="DGMH" disabled>DGMH</option>
                            <option value="CSE" disabled>CSE</option>
                            <option value="PHC" disabled>PHC</option>
                            <option value="DH_CMS" disabled>District Hospital (CMS)</option>
                            <option value="AD_OFFICE" disabled>AD Office</option>
                            <option value="CMO_OFFICE" disabled>CMO Office</option> -->

                            <?php
                            while($row=mysqli_fetch_assoc($result)){
                                if($row['status']==0){
                                    $status="disabled";
                                }
                                else{
                                    $status="";
                                }
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo $status; ?> ><?php echo $row['role_alternate_name']; ?></option>
                            <?php    
                            }
                            ?>
                        </select>
                        <span class="focus-border"><i></i></span>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label>User Name</label>
                        <input required name="email" id="email" type="email" class="form-control effect-8" />
                        <span class="focus-border"><i></i></span>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label>Password</label>
                        <input required name="password" id="password" type="password" class="form-control effect-8" />
                        <span class="focus-border"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-success" id="login-submit">
                        <!-- <a class="btn btn-success btn-block" id="login-submit" onclick="return validateForm();">Submit</a> -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <a href="#" class="btn btn-danger btn-block" onclick="return reset();">Reset</a>

                    </div>
                </div>
            </div>

            <p>
                <!-- <a href="#" id="showregister"> New user click here </a>&nbsp;&nbsp;|&nbsp;&nbsp; -->
                <a href="#" id="showforgot">Forgot Password ?</a>
            </p>

        </form>
        
    </div>

</div>
</div>
<div class="clearfix"></div>

<?php
    include('footer.php');
?>