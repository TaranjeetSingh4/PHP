<?php include('dashboard-header.php')?>

<section id="main-content" style="min-height: 100vh;">
                <!-- page title -->
    <div class="content-title">
        <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->Create New Format <!-- InstanceEndEditable --></h3>           
    </div>
    <div id="content" class="dashboard padding-20 margin-bottom-50">
        <div class="row">
                    <!-- InstanceBeginEditable name="content" -->
            <div class="col-md-12">
                <div class="panel panel-default">
                        
                    <div class="panel-heading"> <span class="title elipsis">
                        <h4>Add Information</h4>
                        </span> 
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-success hidden" id="show_alert"></div>
                        <form action="./controller/login.php" method="post" id="add_form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Format Name <span class="star">*</span></label>
                                    <input name="format_name" class="form-control" type="text" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Format Heading <span class="star">*</span></label>
                                    <input name="format_heading" class="form-control" type="text" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="add_item_btn btn btn-success">Add More Fields</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="add_disclaimer_btn btn btn-secondary">Add Disclaimer</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button class="add_section_btn btn btn-info">New Section</button>
                                    </div>
                                </div>
                            </div>
                            <div id="show_item"></div>
                            <div id="show_section">
                                
                                
                            </div>

                            <div id="show_sub_field"></div>

                            
                           
                            

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-2 col-md-offset-4">
                                        <input type="submit" id="add_btn" class="btn btn-block btn-success">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="reset" class="btn btn-block btn-danger">  
                                    </div>                                            
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div> 
                    
                 
                 
<?php include('dashboard-footer.php') ?>