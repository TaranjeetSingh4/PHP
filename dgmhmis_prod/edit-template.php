<?php include('dashboard-header.php')?>
<?php
require_once './controller/format_view.php';
$res=[];
while($row=mysqli_fetch_assoc($result)){
    $res[]=$row;
}

$section_array=array();

while($d=mysqli_fetch_assoc($result_section)){
    $j=array();
    
    $j['format_id']=$d['format_id'];
    $j['section_name']=$d['section_name'];
    $j['sub_field_id']=$d['id'];
    $j['sub_field_name']=$d['sub_field_name'];
    $j['sub_field_type']=$d['sub_field_type'];
    
    
    $section_name=$d['section_name'];
    if (!isset($section_array[$section_name])) {
        // If it does not exist, initialize it as an empty array
        $section_array[$section_name] = [];
    }
    
    $section_array[$section_name][]=$j;
}

$section_array_final=array_values($section_array);
$count=0;
?>

<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->Edit Format <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <h4>Edit Information</h4>
                        </span> 
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-success hidden" id="show_alert"></div>
                        <form action="#" method="post" id="edit_form">
                            <div class="row">
                                <div class="col-md-1 hidden">
                                    <input type="text" name="format_id" value="<?php echo $format_name_row['id']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Format Name <span class="star">*</span></label>
                                    <input name="format_name" class="form-control" type="text" value="<?php echo $format_name_row['format_name']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Format Heading <span class="star">*</span></label>
                                    <input name="format_heading" class="form-control" type="text" value="<?php echo $format_name_row['format_heading'];?>" required>
                                </div>
                            </div>
                            <div id="show_item">
                            <?php foreach($res as $data){ ?>
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Field Name <span class="star">*</span></label>
                                            <input name="field_name[]" class="form-control" type="text" value="<?php echo $data['field_name']; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Field Type <span class="star">*</span></label>
                                            <select name="field_type[]" style="width:100%;">
                                                <option value="text" <?=$data['field_type'] == 'text' ? ' selected="selected"' : '';?>>String</option>
                                                <option value="number" <?=$data['field_type'] == 'number' ? ' selected="selected"' : '';?>>Integer</option>
                                                <option value="file" <?=$data['field_type'] == 'file' ? ' selected="selected"' : '';?>>File</option>
                                            </select>
                                            <!-- <input name="field_type[]" class="form-control" type="text" value="<?php echo $data['field_type']; ?>" required> -->
                                        </div>
                                    </div>

                                    <div class="col-md-1 mt-2 hidden">
                                        <div class="form-group">
                                        <input name="field_id[]" class="form-control" type="text" value="<?php echo $data['field_id']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-2">
                                        <div class="form-group">
                                            <button class="remove_item_btn btn btn-danger" id="<?php echo $data['field_id']; ?>">Remove Field</button>
                                        </div>
                                    </div>

                                   
                                    
                                </div>
                                <?php } ?>
                            
                                <?php foreach($section_array as $k) {
                                    foreach($k as $a){
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Section Name <span class="star">*</span></label>
                                            <input name="section_name[]" class="form-control" type="text" value="<?php echo $a['section_name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Sub Field Name <span class="star">*</span></label>
                                            <input name="sub_field_name[]" class="form-control" type="text" value="<?php echo $a['sub_field_name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Sub Field Type <span class="star">*</span></label>
                                            <select name="sub_field_type[]" style="width:100%;">
                                                <option value="text" <?=$a['sub_field_type'] == 'text' ? ' selected="selected"' : '';?>>String</option>
                                                <option value="number" <?=$a['sub_field_type'] == 'number' ? ' selected="selected"' : '';?>>Integer</option>
                                                <option value="file" <?=$a['sub_field_type'] == 'file' ? ' selected="selected"' : '';?>>File</option>
                                            </select>
                                            <!-- <input name="field_type[]" class="form-control" type="text" value="<?php echo $data['field_type']; ?>" required> -->
                                        </div>
                                    </div>
                                    <div class="col-md-1 hidden">
                                        <div class="form-group">
                                            <input name="sub_field_id[]" class="form-control" type="text" value="<?php echo $a['sub_field_id']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <div class="form-group">
                                            <button class="remove_sub_field_btn btn btn-danger" id="<?php echo $a['sub_field_id']; ?>">Remove Field</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                    }
                                ?>
                                <?php } ?>

                                


                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <div class="form-group">
                                            <button class="add_item_btn btn btn-success">Add More Fields</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <div class="form-group">
                                            <button class="add_section_btn btn btn-info">Add More Section</button>
                                        </div>
                                    </div>
                                </div>
                                   
                            </div>

                            <div class="row hidden">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input name="delete_field_id" class="form-control" id="delete_field_id" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="row hidden">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input name="delete_sub_field_id" class="form-control" id="delete_sub_field_id" type="text">
                                    </div>
                                </div>
                            </div>


                            <div id="show_section"></div>
                            

                            <div class="row mt-3">
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-4">
                                        <input type="submit" value="Save Changes" id="edit_btn" class="btn btn-block btn-success">
                                    </div>
                                    <!-- <div class="col-md-2">
                                        <input type="reset" class="btn btn-block btn-danger">  
                                    </div>                                             -->
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div> 
                    
                 
                 
<?php include('dashboard-footer.php') ?>