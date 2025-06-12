<?php include('dashboard-header.php') ?>
<?php
require_once './controller/format_view.php';
require_once './controller/get_user_filled_format_data.php';

$res=[];
while($row=mysqli_fetch_assoc($result)){
    $res[]=$row;
}
$section_array=array();

while($d=mysqli_fetch_assoc($result_section)){
    $j=array();
    
    $j['format_id']=$d['format_id'];
    $j['section_name']=$d['section_name'];
    $j['section_id']=$d['id'];
    $j['sub_field_name']=$d['sub_field_name'];
    $j['sub_field_type']=$d['sub_field_type'];
    
    $section_name=$d['section_name'];
    if (!isset($section_array[$section_name])) {
        // If it does not exist, initialize it as an empty array
        $section_array[$section_name] = [];
    }
    
    $section_array[$section_name][]=$j;
}

session_start();
if(isset($_SESSION['user_role'])){
    $user_role=$_SESSION['user_role'];
}
else{
    header("Location:index.php");
    session_destroy();
}

$month=$_GET['month'];
$year=$_GET['year'];
$format_id=$_GET['id'];
$role_id=$_GET['role_id'];
$user_id=$_GET['user_id'];
?>
<section id="main-content" style="min-height: 100vh">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" --><?php echo $normal_field_array[0]['format_name']; ?><!-- InstanceEndEditable --></h3>           
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
                        <div class="col-md-4 mt-1">
                            <h4>
                                <?php echo $res[0]['format_heading']; ?>
                            </h4>
                            
                        </div>

                        <?php if(isset($user_role) && $user_role!="admin") { ?>
                            <form <?php if(isset($user_role) && ($user_role!="admin")){ ?>action="./controller/format_form_data.php" method="post" enctype="multipart/form-data"<?php } ?> >
                            <div class="col-md-3 form-group" style="display:flex">
                                <label style="margin-right:20px; margin-top:10px"><b>Select Date</b> <span class="star">*</span></label>
                                <input type="text" name="filled_data_month_year" class="form-control" value="<?php echo date("$month/$year") ?>" />
                            
                            </div>
                           
                            <!-- <div class="col-md-3 form-group">
                                <select name="field_type[]" style="width:100%;">
                                    <option value="text">String</option>
                                    <option value="number">Integer</option>
                                    <option value="file">File</option>
                                </select>
                            </div> -->
                        <?php } ?>

                        
                        
                        </span> 
                    </div>
                    <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="text" class="hidden" name="format_id" value="<?php echo $normal_field_array[0]['format_id']; ?>" readonly>
                        </div>
                    </div>
                        
                            <div class="row mb-3">
                                <?php foreach($normal_field_array as $data) { ?>

                                    <div class="col-md-4 mb-3">
                                        <label><?php echo $data['field_name'] ?> <span class="star">*</span></label>
                                        <input class="hidden" type="text" name="field_ids[]" value="<?php echo $data['field_id']; ?>" readonly>
                                        <input name="field_names[]" class="form-control" type="<?php echo $data['field_type']; ?>" value="<?php echo $data['value']; ?>" required <?php if(isset($user_role) && (($user_role=="admin") || ($user_role=="DNO"))) { ?>readonly<?php } ?>>
                                    </div>  
                                <?php } ?>
                            </div>
                            <?php 
                                if($sub_field_array){
                                ?>
                                 <div style="height:1px; background:grey"></div>

                                 <?php foreach($sub_field_array as $key=>$value) { ?>
                                    <div class="row section-partition mt-3">
                                        <div class="col-md-12">
                                            <h5><?php echo $key; ?></h5>
                                        </div>
                                    <!-- </div>
                                    <div class="row"> -->
                                        <?php foreach($value as $sub_field_data){ ?>
                                            <div class="col-md-4 mb-3">
                                                <label><?php echo $sub_field_data['sub_field_name']; ?> <span class="star">*</span></label>
                                                <input class="hidden" type="text" name="section_sub_field_ids[]" value="<?php echo $sub_field_data['sub_field_id']; ?>" readonly>
                                                <input name="section_sub_field_names[]" class="form-control" type="<?php echo $sub_field_data['sub_field_type']; ?>" value="<?php echo $sub_field_data['value']; ?>" required <?php if(isset($user_role) && (($user_role=="admin") || ($user_role=="DNO"))) { ?>readonly<?php } ?>>
                                            </div>  
                                        <?php } ?>
                                    </div>
                                    <div style="height:1px; background:grey"></div>
                                 <?php } ?>
                                 
                             
                                <?php } ?>
                            

                             
                        </form> 

                        <div class="row mt-3">
                                <div class="col-md-2"></div>
                                <div class="col-md-4" >
                                    <a href="./controller/verify_data.php?id=<?php echo $format_id; ?>&user_id=<?php echo $user_id; ?>&role_id=<?php echo $role_id; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>">
                                        <button class="btn btn-success" style="width:100%" id="verify-btn">Verify</button>
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="./controller/verify_data.php?id=<?php echo $format_id; ?>&user_id=<?php echo $user_id; ?>&role_id=<?php echo $role_id; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>">
                                        <button class="btn btn-danger" style="width:100%" id="verify-btn">Reject Data</button>
                                    </a>
                                </div>
                                <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div> 
                   
<?php include('dashboard-footer.php') ?>