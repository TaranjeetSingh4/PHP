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

$currentDate = new DateTime();
$currentDate->modify('-1 month');
$j = $currentDate->format('Y');
$y = $currentDate->format('m');





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
                                <?php echo $name_row['format_heading']; ?>
                            </h4>
                            
                        </div>

                        <?php if(isset($user_role) && $user_role!="admin") { ?>
                            <form>
                                <div class="col-sm-2 hidden">
                                    <input type="text" name="user_id" value="<?php echo $_SESSION['id']; ?>">
                                </div>
                                <div class="col-sm-2 hidden">
                                    <input type="text" name="role_id" value="<?php echo $_SESSION['login_user_role']; ?>">
                                </div>
                                <div class="col-sm-2 hidden">
                                    <input type="text" name="id" value="<?php echo $_GET['id']; ?>">
                                </div>
                                <div class="col-sm-2">
                                    <input type="date" name="date" id="dateInput">
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-info" id="editFormDataButton">Search</button>
                                </div>
                            </form>
                            <!-- <div class="col-md-3 form-group" style="display:flex">
                                <label style="margin-right:20px; margin-top:10px"><b>Select Date</b> <span class="star">*</span></label>
                                <input type="text" name="filled_data_month_year" class="form-control" value="<?php echo date('m/25') ?>" />
                            
                            </div> -->
                            <!-- <form action="./controller/search_edit_user_filled_data.php" method="post">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="month" id="month">
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
                                </div>

                                <div class="col-md-2">
                                    <select name="year" id="year">
                                        <option value="default">Select Year</option>
                                            <?php 
                                            $currentYear = date('Y');
                                            $startYear = 2000;
                                            
                                            for ($year = $startYear; $year <= $currentYear; $year++){ 
                                               
                                            ?>
                                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                            <?php 
                                            
                                            } 
                                            ?>
                                    </select>
                                </div>

                                
                                <div class="col-md-2">
                                    <input type="text" class="hidden" name="format_id" value="<?php echo $format_name_row['id']; ?>" readonly>
                                </div>
                                

                                

                                <div class="col-md-2">
                                    <input type="submit" value="Search" class="btn btn-info">
                                </div>
                            </div>

                            </form> -->
                            
                           
                            <!-- <div class="col-md-3 form-group">
                                <select name="field_type[]" style="width:100%;">
                                    <option value="text">String</option>
                                    <option value="number">Integer</option>
                                    <option value="file">File</option>
                                </select>
                            </div> -->
                        <?php } ?>
                        <form <?php if(isset($user_role) && $user_role!="admin"){ ?>action="./controller/edit_user_form_data.php" method="post" enctype="multipart/form-data"<?php } ?> >
                        <?php if(isset($user_role) && $user_role=="admin") { ?>
                        
                           
                        
                        <div class="col-md-1">
                            <a href="edit-template.php?id=<?php echo $normal_field_array[0]['format_id']; ?>"><button class="btn btn-block btn-primary"><i class="fa fa-pencil-square" aria-hidden="true"></i></button></a>
                        </div>

                        <div class="col-md-1">
                            <a href="./controller/delete-template.php?id=<?php echo $normal_field_array[0]['format_id']; ?>"><button class="btn btn-block btn-primary"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                        </div>
                        <?php } ?>

                        <!-- <div class="col-md-1">
                            <a href="delete-template.php?id=<?php echo $normal_field_array[0]['format_id']; ?>"><button class="btn btn-block btn-primary"><i class="fa fa-toggle-on" aria-hidden="true"></i></button></a>
                        </div> -->
                        
                        </span> 
                    </div>
                    <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="text" class="hidden" name="format_id" value="<?php echo $format_name_row['id']; ?>" readonly>
                        </div>
                    </div>

                    <div class="row hidden">
                        <div class="col-md-12 form-group">
                            <input type="text" class="hidden" name="month" value="<?php echo $y; ?>" readonly>
                        </div>
                    </div>


                    <?php if(isset($_GET['date']) && $_GET['date']) { 
                        $dateTime = new DateTime($_GET['date']);

                        // Get the current month and year
                        $month = $dateTime->format('m'); // Current month in MM format
                        $year = $dateTime->format('Y');
                    }
                    else{
                        $month='08';
                        $year=2024;
                    }
                    ?>

                    <div class="col-sm-2 hidden">
                                <input type="text" name="month" id="monthInput" value="<?php echo $month; ?>" placeholder="Month" readonly>
                            </div>
                            <div class="col-sm-2 hidden">
                                <input type="text" name="year" id="yearInput" value="<?php echo $year; ?>" placeholder="Year" readonly>
                            </div>

                    <div class="row hidden">
                        <div class="col-md-12 form-group">
                            <input type="text" class="hidden" name="year" value="<?php echo $j; ?>" readonly>
                        </div>
                    </div>
                        
                            <div class="row mb-3">
                                <?php foreach($normal_field_array as $data) { ?>

                                    <div class="col-md-4 mb-3">
                                        <label><?php echo $data['field_name']; ?> <span class="star">*</span></label>
                                        <input class="hidden" type="text" name="field_ids[]" value="<?php echo $data['field_id']; ?>" readonly>
                                        <input name="field_names[]" class="form-control" type="<?php echo $data['field_type']; ?>" value="<?php echo $data['value']; ?>" required <?php if(isset($user_role) && $user_role=="admin") { ?>readonly<?php } ?>>
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
                                                <input name="section_sub_field_names[]" class="form-control" type="<?php echo $sub_field_data['sub_field_type']; ?>" value="<?php echo $sub_field_data['value']; ?>" required <?php if(isset($user_role) && $user_role=="admin") { ?>readonly<?php } ?>>
                                            </div>  
                                        <?php } ?>
                                    </div>
                                    <div style="height:1px; background:grey"></div>
                                 <?php } ?>
                                 
                             
                                <?php } ?>
                                <?php if(isset($user_role) && $user!="admin") { ?>                                            
                                <div class="row mt-3">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-3">
                                        <input type="submit" value="Submit Form" class="btn btn-block btn-primary">
                                    </div>
                                </div>
                                <?php } ?>

                        </form> 
                    </div>
                </div>
            </div> 
                   
<?php include('dashboard-footer.php') ?>