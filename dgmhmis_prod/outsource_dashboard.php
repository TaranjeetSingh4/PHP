<?php include('dashboard-home-header.php') ?>
<?php

if(isset($_SESSION['user_role'])){
    $user_role=$_SESSION['user_role'];
}
else{
    header("Location:index.php");
    session_destroy();
}

require_once('./controller/get_role_wise_formats.php');
require_once('./controller/config.php');

$district_id=$_SESSION['district_id'];
$query="select * from master_division join master_district on master_division.id=master_district.division_id where master_district.id=$district_id";
$district_result=mysqli_query($conn,$query);
$district_row=mysqli_fetch_assoc($district_result);

$color=['red','lighblue','orange','bluegrey','green','indigo'];
$icon_classes=['fa-heartbeat','fa-plus-square','fa-h-square','fa-medkit','fa-heart','fa-certificate'];
?>
            <div class="row">
                <!-- page title -->
                
                <div class="col-md-3  col-sm-12 ">
                <div class="content-left">
      <div class="cntnt-img"> </div>
      <div class="bnr-img"> <img src="images/default-image.jpg" alt=""/> </div>
      <div class="bnr-text">
        <h1><?php echo $_SESSION['username']; ?></h1>
        <?php if($_SESSION['user_role']!="admin") { ?>
        <p>Division: <?php echo $district_row['name']; ?></p>
        <p>District: <?php echo $district_row['district_name']; ?></p>
        <?php } ?>
        <p>Role: <?php echo $_SESSION['user_role']; ?></p>
        <!-- <p> <strong> Last login </strong> 25-08-2015</p> -->
      </div>
      <div class="btm-icon">
      <div class="col-md-6 col-sm-12">
          <div class="row"> <a href="my-profile.php?id=<?php echo $_SESSION['id']; ?>" class="btn btn-green"> <i class="fa fa-user"></i>
            <h5>My Profile</h5>
            </a> </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="row"> <a href="change-password.php" class="btn btn-green"> <i class="fa fa-unlock-alt"></i>
            <h5> Change Passwrd</h5>
            </a> </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="row"> <a href="#" class="btn btn-green"> <i class="fa fa-envelope-o"></i>
            <h5> Message</h5>
            </a> </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="row"> <a href="./controller/logout.php" class="btn btn-green"> <i class="fa fa-sign-out"></i>
            <h5> Logout</h5>
            </a> </div>
        </div>
        
      </div>
      </div>
    </div>
                <div class="col-md-9">
                <div class="col-md-12 col-sm-12 col-xs-12 mesg">
                     <div class="panel panel-info">
            <div class="panel-heading">Message  </div>
            <div class="panel-body">
             <ul class="news">
                <li class="item"><h4>DGMIS</h4>
                    <p>The Director General provides leadership in the development and implementation of MIS strategies that align with the organization’s objectives. This includes evaluating current systems, identifying areas for improvement, and planning for future technology needs.</p></li>
                     <li class="item"><h4>DGMIS</h4>
                    <p>The Director General provides leadership in the development and implementation of MIS strategies that align with the organization’s objectives. This includes evaluating current systems, identifying areas for improvement, and planning for future technology needs.</p></li>
                </ul>

            </div>
          </div>
                    </div>
                     <ul class="circle">
                        <li class="col-md-3 col-sm-6 col-xs-12">
                            <a href="outsource_format.php" class="<?php echo $color[1]; ?>">
                            <i class="fa <?php echo $icon_classes[1]; ?>"></i>Outsource Format
                            </a>
                        </li>

                        <li class="col-md-3 col-sm-6 col-xs-12">
                            <a href="all_filled_outsource.php" class="<?php echo $color[2]; ?>">
                            <i class="fa <?php echo $icon_classes[2]; ?>"></i> Filled Data
                            </a>
                        </li>
          
                    </ul>
                        
                </div>
                </div>
            </section>
            
            


        </div>
        
       
 
    </div>
<?php include('dashboard-home-footer.php') ?>