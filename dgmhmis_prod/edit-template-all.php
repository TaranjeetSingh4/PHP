<?php include('dashboard-header.php')?>



<?php 
require './controller/fetch_info.php'; 

session_start();
if(isset($_SESSION['user_role'])){
    $user_role=$_SESSION['user_role'];
}
else{
    header("Location:index.php");
    session_destroy();
}


$result=getAllFormatListing();


?>



<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title" id="type-of-template-listing"><!-- InstanceBeginEditable name="Main Heading" -->All Templates <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <div style="float:left;">
                            <h4>Format Listing</h4>
                        </div>
                        </span> 
                        <?php if(isset($user_role) && $user_role=="admin") { ?>
                        <div style="float:right">
                        
                            <select name="listing_type" id="listing_type">
                                <option value="default">All Templates</option>
                                <option value="active">Active Templates</option>
                                <option value="inactive">Inactive Templates</option>
                            </select>
                       
                           
                        </div>
                        <?php } ?>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-center table-striped" id="default-listing-table">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                                <td><strong>S. No.</strong></td>
                                                <td><strong>Format Name</strong></td>
                                                <td><strong>Format Heading</strong></td>
                                                <?php if(isset($user_role) && $user_role=="admin") { ?>
                                                <td><strong>Status</strong></td>
                                                <?php } else{?>
                                                <td><strong>Monthly Data</strong></td>
                                                <td><strong>Active From Date</strong></td>
                                                <td><strong>Active To Date</strong></td>
                                                <?php } ?>
                                                <td><strong>Action(s)</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count=1;
                                            while($row=mysqli_fetch_assoc($result)){
                                                if($row['format_status']==1){
                                                    $status="fa-toggle-on";
                                                    $active="active";
                                                }
                                                else{
                                                    $status="fa-toggle-off";
                                                    $active="inactive";
                                                }
                                            ?>
                                            <tr>
                                                <td><strong><?php echo $count; ?></strong></td>
                                                <td><strong><?php echo $row['format_name']; ?></strong></td>
                                                <td><strong><?php echo $row['format_heading']; ?></strong></td>
                                                <?php if(isset($user_role) && $user_role=="admin") { ?><td><a href="./controller/delete-template.php?id=<?php echo $row['id']; ?>&status=<?php echo $row['format_status']; ?>"><i class="fa <?php echo $status; ?> <?php echo $active; ?>" aria-hidden="true"></i></a></td><?php } else{?>
                                                <td><strong><?php echo date("M-Y",strtotime("-1 Month")); ?></strong></td>
                                                <td><strong><?php echo "25-".date("M-Y"); ?></strong></td>
                                                <td><strong><?php echo date("t-M-Y"); ?></strong></td>
                                                <?php } ?>
                                                <td>
                                                <?php if(isset($user_role) && $user_role=="admin") { ?>
                                                    <a href="format-template-view.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <a href="edit-template.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <a href="./controller/hard-delete-template.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash delete" aria-hidden="true"></i></a>
                                                <?php } else{ ?>
                                                    <a href="format-template-view.php?id=<?php echo $row['id']; ?>"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <a href="format-template-view.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil edit" aria-hidden="true"></i> </a>
                                                <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $count=$count+1; } ?>
                                            
                                            
                                        </tbody>
                                    </table>


                                    <table class="table text-center table-striped hidden" id="filter-listing-table">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                                <td><strong>S. No.</strong></td>
                                                <td><strong>Format Name</strong></td>
                                                <td><strong>Format Heading</strong></td>
                                                <td><strong>Status</strong></td>
                                                <td><strong>Action(s)</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            
                                            
                                            
                                            
                                        </tbody>
                                        
                                    </table>

                                    <p id="no-data" class="hidden text-center"></p>

                                    

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
                    
                 
            

                 
<?php include('dashboard-footer.php') ?>