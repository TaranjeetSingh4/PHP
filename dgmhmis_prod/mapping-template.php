<?php include('dashboard-header.php')?>
<?php 
require './controller/fetch_format_mapping_info.php'; 

require './controller/get_roles.php';
require './controller/fetch_info.php';

$format_result=getAllFormatListing();


?>



<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->All Templates <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
                    <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <div style="float:left;">
                            <h4>Add Format Mapping</h4>
                        </div>
                        </span> 
                       
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <?php if($_SESSION['alert-msg']) { ?>
                            <div class="col-md-12">
                                <p class="alert alert-success"><?php echo $_SESSION['alert-msg']; ?></p>
                            </div>
                            <?php } ?>
                            <div class="col-sm-12">
                                <form action="#" method="post" id="format-mapping-form">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Format(s)</label>
                                            <select name="format" class="form-control">
                                                <option value="null" id="choose-role" style="color:grey">------ Choose Format ---------</option>
                                                <?php while($format_row=mysqli_fetch_assoc($format_result)) { ?>
                                                    <option value="<?php echo $format_row['id']; ?>"><?php echo $format_row['format_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Allocate Role(s)</label><br>
                                            <select name="roles[]" class="form-control multiselect" id="formats" role="multiselect" multiple="multiple">
                                                <!-- <option value="null" id="choose-role" style="color:grey">------ Choose Role ---------</option> -->
                                                <?php foreach ($role_result as $role_value){
                                                ?>
                                                <option value="<?php echo $role_value['id'] ?>"><?php echo $role_value['role']; ?></option>
                                                        
                                                <?php    
                                                } ?>
                                            </select>
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <input type="submit" class="btn btn-block btn-danger" value="Submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
                    
            
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <div style="float:left;">
                            <h4>Format Mapping Lisitng</h4>
                        </div>
                        </span> 
                       
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-center table-striped">
                                        <thead class="thead-dark p-1">
                                            <tr>
                                                <td><strong>S. No.</strong></td>
                                                <td><strong>Format Name</strong></td>
                                                <td><strong>Alloted to roles</strong></td>
                                                <td><strong>Action</strong></td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count=1;
                                            foreach($format_mapping_data as $key=>$value){
                                            ?>
                                            <tr>
                                                <td><strong><?php echo $count."."; ?></strong></td>
                                                <td><strong><?php echo $key; ?></strong></td>
                                                <td><strong><?php echo $value['roles']; ?></strong></td>
                                                <td>
                                                    <a href="edit-mapping.php?id=<?php echo $value['format_id']; ?>"><i class="fa fa-pencil-square edit" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                </td>
                                            </tr>
                                            <?php $count=$count+1; } ?>
                                            
                                            
                                        </tbody>
                                    </table>

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> 
                    
                 
            <script>
    $("#listing_type").on('change', function(){
    var val = $(this).val();  
    if(val=="active"){
        $.ajax({ url: './controller/fetch_info.php',
            data: {function2call: 'getActiveFormatListing'},
            type: 'get',
            success: function(output) {
                        $.ajax({
                            url:"edit-template-all.php",
                            data:{output_data=output},
                            type:'get'
                        })
            }
        });
    }
    else if(val=="inactive"){
        $.ajax({ url: './controller/fetch_info.php',
            data: {function2call: 'getDeactiveFormatListing'},
            type: 'get',
            success: function(output) {
                    let result=output;
            }
        });
    }  
    else{
        $.ajax({ url: './controller/fetch_info.php',
            data: {function2call: 'getAllFormatListing'},
            type: 'get',
            success: function(output) {
                let result=output;
            }
        });
    }
    alert(val);
});
</script>

                 
<?php include('dashboard-footer.php') ?>