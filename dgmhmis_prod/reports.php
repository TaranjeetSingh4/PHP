<?php include('dashboard-header.php')?>
<?php 
require_once('./controller/getReportListing.php'); 
require_once('./controller/fetch_districts.php'); 
require_once('./controller/all_formats.php');
session_start();
if(isset($_SESSION['user_role'])){
    $user_role=$_SESSION['user_role'];
}
else{
    header("Location:index.php");
    session_destroy();
}



?>



<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title" id="type-of-template-listing"><!-- InstanceBeginEditable name="Main Heading" -->All Reports <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <div style="float:left;" class="col-md-5">
                            <h4>Report <?php print_r($arr[0]); ?></h4>
                        </div>
                        </span> 
                    </div>

                    

                   

                    <div class="panel-body">
                        <div class="row" style="padding-left:10px;padding-right:10px">
                            <?php if(isset($user_role)) { ?>
                            <div class="col-md-12">
                                <form method="post" id="filter_report_form">
                                <div class="row">
                                    <?php if($user_role=="admin"){ ?>
                                    <div class="col-md-2">
                                        <select name="districts" id="districts">
                                            <option value="">All Districts</option>
                                            <?php while($row=mysqli_fetch_assoc($district_result)){ ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['district_name']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <?php } ?>

                                    <!-- <div class="col-md-4 form-group">
                                        <select name="format_id" id="format_id" class="form-control">
                                            <option value="default">All Formats</option>
                                            <?php while($format_row=mysqli_fetch_assoc($format_result)){ ?>
                                                <option value="<?php echo $format_row['id']; ?>"><?php echo $format_row['format_name']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                         -->
                                    <!-- <div class="col-md-2">
                                        <select name="listing_type" id="listing_type">
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
                                    </div> -->

                                    <div class="col-md-2">
                                        <input type="date" name="date" id="date" value="Select Date">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <!-- <button class="btn btn-info" id="filter_search">Search</button> -->
                                        <input type="submit" class="btn btn-info" value="Search" id="filter_search">
                                        <button type="button" class="btn  btn-primary" id="downloadBtn">Download</button>
                                    </div>
                                    
                                </div>
                                </form>
                            
                        
                            
                            </div>
                            <?php } ?>

                        </div>

                        <hr>
                       
                        <div>
                            <p id="alert-data">

                            </p>
                        </div>
                        <div id="response"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-center table-striped" id="default-filter-table">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                                <td><strong>S. No.</strong></td>
                                                <td><strong>Filled by User</strong></td>
                                                <td><strong>District Name</strong></td>
                                                <td><strong>Filled by Role </strong></td>
                                                <td><strong>Format Name</strong></td>
                                                
                                                <td><strong>Month Data</strong></td>

                                                <td><strong>Status</strong></td>
                                                
                                                <td><strong>Action(s)</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count=1;
                                            foreach($report_array as $key=>$value){
                                             
                                            ?>
                                           
                                            <tr>
                                                <td><strong><?php echo $count; ?></strong></td>
                                                <td><strong><?php echo $value['user_name']; ?></strong></td>
                                                <td><strong><?php echo $value['district_name']; ?></strong></td>
                                                <td><strong><?php echo $value['role']; ?></strong></td>
                                                <td><strong><?php echo $value['format_name']; ?></strong></td>
                                                
                                                <td><strong><?php echo $value['month']."-".$value['year']; ?></strong></td>
                                                <?php
                                                if($value['status']==1){
                                                    $status="Verified";
                                                }
                                                else if($value['status']==3){
                                                    $status="Semi-verified";
                                                }
                                                else{
                                                    $status="Unverified";
                                                }
                                                ?>
                                                <td><strong><?php echo $status; ?></strong></td>
                                                <td>
                                                <?php if(isset($user_role) && $user_role=="admin") { ?>
                                                    <a href="report-view.php?id=<?php echo $value['format_id']; ?>&role_id=<?php echo $value['role']; ?>&district_id=<?php echo $value['district_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <!-- <a href="edit-report.php?format_id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i> </a> -->
                                                    <!-- <a href="./controller/download-report.php?format_id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-download delete" aria-hidden="true" style="margin-right:20px"></i> </a> -->
                                                    <!-- <a href="./controller/hard-delete-template.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash delete" aria-hidden="true"></i></a> -->
                                                <?php } else{ ?>
                                                    <a href="report-view.php?id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <!-- <a href="format-template-view.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil edit" aria-hidden="true"></i> </a> -->
                                                    <a href="./controller/verify_data.php?id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-check-circle verified" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <a href="./controller/unverify_data.php?id=<?php echo $value['format_id']; ?>&user_id=<?php echo $value['user_id']; ?>&role_id=<?php echo $value['role_id']; ?>&month=<?php echo $value['month']; ?>&year=<?php echo $value['year']; ?>"><i class="fa fa-check-circle-o unverified" aria-hidden="true"></i> </a>
                                                <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $count=$count+1; } ?>
                                            
                                            
                                        </tbody>
                                    </table>


                                    <table class="table text-center table-striped hidden" id="filter-report-table">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                                <td><strong>S. No.</strong></td>
                                                <td><strong>Filled by User</strong></td>
                                                <td><strong>District Name</strong></td>
                                                <td><strong>Filled by Role </strong></td>
                                                <td><strong>Format Name</strong></td>
                                                <td><strong>Month Data</strong></td>
                                                <td><strong>Status</strong></td>
                                               
                                                <td><strong>Action(s)</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            
                                            
                                            
                                            
                                        </tbody>
                                        
                                    </table>

                                    <p id="alert-data" class="hidden text-center"></p>

                                    

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
            

            

                 
<?php include('dashboard-footer.php') ?>