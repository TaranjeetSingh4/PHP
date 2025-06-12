<?php include('dashboard-header.php') ?>
<?php

$id=$_GET['id'];
require_once './controller/format_view.php';


$res=[];
while($res_row=mysqli_fetch_assoc($result)){
    $res[]=$res_row;
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

?>
<section id="main-content" style="min-height: 100vh">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" --><?php echo $format_name_row['format_name']; ?><!-- InstanceEndEditable --></h3>           
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
                                <?php echo $format_name_row['format_heading']; ?>
                            </h4>
                            
                        </div>

                        <?php if(isset($user_role) && $user_role!="admin") { ?>
                            <form <?php if(isset($user_role) && $user_role!="admin"){ ?>action="./controller/format_form_data.php" method="post" enctype="multipart/form-data"<?php } ?> >
                            <div class="col-md-3 form-group" style="display:flex">
                                <label style="margin-right:20px; margin-top:10px"><b>Select Date</b> <span class="star">*</span></label>
                                <input type="text" name="filled_data_month_year" class="form-control" value="<?php echo date('m/25',strtotime('-1')) ?>" />
                            
                            </div>
                           
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

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="text" class="hidden" name="format_id" value="<?php echo $format_name_row['id']; ?>" readonly>
                        </div>
                    </div>
                        <?php if($res){ ?>
                            <div class="row mb-3">
                                <?php foreach($res as $data) { ?>

                                    <div class="col-md-4 mb-3">
                                        <label><?php echo $data['field_name']; ?> <span class="star">*</span></label>
                                        <input class="hidden" type="text" name="field_ids[]" value="<?php echo $data['field_id']; ?>" readonly>
                                        <input name="field_names[]" class="form-control" type="<?php echo $data['field_type']; ?>" placeholder="<?php echo $data['field_type']; ?>" required <?php if(isset($user_role) && $user_role=="admin") { ?>readonly<?php } ?>>
                                    </div>  
                                <?php } ?>
                            </div>
                            <div style="height:1px; background:grey"></div>
                        <?php } ?>
                            <?php 
                                if($section_array){
                                ?>
                                

                                 <?php foreach($section_array as $key=>$value) { $count=0;?>
                                    <div class="row section-partition <?php if($res) { ?>mt-3<?php } ?>">
                                        <div class="col-md-12">
                                            <h5><?php echo $key; ?></h5>
                                        </div>
                                    <!-- </div>
                                    <div class="row"> -->
                                        <div class="row" style="padding-left:15px;padding-right:15px">
                                        <?php foreach($value as $sub_field_data){ $count=$count+1;?>
                                            <div class="col-md-3 mb-3">
                                                <label><?php echo $sub_field_data['sub_field_name']; ?> <span class="star">*</span></label>
                                                <input class="hidden" type="text" name="section_sub_field_ids[]" value="<?php echo $sub_field_data['section_id']; ?>" readonly>
                                                <input name="section_sub_field_names[]" class="form-control" type="<?php echo $sub_field_data['sub_field_type']; ?>" placeholder="<?php echo $sub_field_data['sub_field_type']; ?>" required <?php if(isset($user_role) && $user_role=="admin") { ?>readonly<?php } ?>>
                                            </div> 
                                            <?php        if (($count) % 4 == 0 && $count != count($value) - 1) {?>
                                                </div><div class="row" style="padding-left:15px;padding-right:15px">
                                            <?php } ?>

                                        <?php  } ?>

                                        </div>
                                    </div>
                                    <div style="height:1px; background:grey"></div>
                                 <?php } ?>
                                 
                             
                                <?php } ?>
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
                        <div class="col-md-3">
                            <a href="edit-format-data.php?id=<?php print_r($id); ?>&user_id=<?php echo $_SESSION['id']; ?>&role_id=<?php echo $_SESSION['login_user_role'] ?>&date=<?php echo date('m'); ?>/25/<?php echo date('Y'); ?>"><button class="btn btn-block btn-warning">Edit Form</button></a>
                        </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div> 
                   
<?php include('dashboard-footer.php') ?>