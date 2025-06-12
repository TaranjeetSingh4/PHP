<?php include('dashboard-header.php')?>
<?php 
session_start();
require('./controller/config.php');
$conn=get_db_connection();
$format_id=$_GET['id'];
// $query="select role from roles";
// $result=mysqli_query($conn,$query);
// $row=mysqli_fetch_assoc($result);


$format_query="select * from formats where id=$format_id";
$result_format_jy=mysqli_query($conn,$format_query);
$row_data=mysqli_fetch_assoc($result_format_jy);

require('./controller/get_roles.php');
require('./controller/fetch_format_id_mapping.php');

?>



<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->Edit Format Mapping <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <div style="float:left;">
                            <h4>Edit Format Mapping</h4>
                        </div>
                        </span> 
                       
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="#" method="post" id="edit_format_mapping_form">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label>Format Name <span class="star">*</span></label>
                                                <input name="format_name" class="form-control" value="<?php echo $row_data['format_name']; ?>" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 hidden">
                                            <div class="form-group">
                                                <label>Format Id <span class="star">*</span></label>
                                                <input name="format_id" class="form-control" value="<?php echo $format_id; ?>" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label>Allocated To <span class="star">*</span></label>
                                                <div class="" style="height:auto;">
                                                    <select name="roles[]" class="form-control multiselect" id="roles" role="multiselect" multiple="multiple">
                                                        <!-- <option value="null" id="choose-role" style="color:grey">------ Choose Role ---------</option> -->
                                                        <?php foreach($role_result as $role_value_data){
                                                           $role_id=$role_value_data['id']
                                                        ?>
                                                        <option value="<?php echo $role_value_data['id'] ?>" <?php if(in_array($role_id,$roles_array)){ ?>selected<?php } ?>><?php echo $role_value_data['role']; ?></option>
                                                        
                                                        <?php    
                                                        } ?>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-12">
                                            <input type="submit" name="submit" value="Submit" class="btn btn-block btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
                    
                 
            
                 
<?php include('dashboard-footer.php') ?>