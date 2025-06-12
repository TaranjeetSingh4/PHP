<?php include('dashboard-header.php'); ?>

            <section id="main-content" style="min-height: 579px;">
                <!-- page title -->
                <div class="content-title">
                    <h3 class="main-title"><!-- InstanceBeginEditable name="Main Heading" -->
Welcome To <strong> Change Password</strong><!-- InstanceEndEditable --></h3>
                    
                </div>
                <div id="content" class="dashboard padding-20 margin-bottom-50">
                <div class="row">
                 <!-- InstanceBeginEditable name="content" -->
                <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="panel-heading"> <span class="title elipsis">
                      <h4>Change Password</h4>
                    </span> </div>
                    <div class="panel-body">
                    <?php 
                        if($message){
                    ?>
                    <div id="show_alert"></div>
                    <?php
                        }
                    ?>
                    <div id="show_alert"></div>
                    <form action="#" method="post" id="change_password_form">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Old Password</label>
                                <input required name="old_password" class="form-control" type="password">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input required name="new_password" class="form-control" type="password">
                                </div>
                            </div>
                        <div class="clearfix"></div>
                
                        <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input required name="confirm_password" class="form-control" type="password">
                            </div>
                        </div>
          
                 
                        <div class="clearfix hidden"></div>

                        <div class="col-md-2 col-xs-12 hidden">
                            <div class="form-group">
                                <input required name="id" class="form-control" type="integer" value="<?php echo $_SESSION['id']; ?>">
                            </div>
                        </div>
          
                 
                        <div class="clearfix"></div>
             
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                 <input type="submit" value="Change Password" class="btn btn-block btn-info" id="change_password_btn">
                                <!-- <button type="button" class="btn btn-block btn-info">Change Password</button> -->
                            </div>
                        </div>
                 
                    </div>

                    </form>
                     
                 <p>&nbsp;</p>   
                 <p>&nbsp;</p>
                 <p>&nbsp;</p> 
                     
                    </div>
                  </div>
              </div> 
                   
                 <div class="clearfix"></div>
                 <div class="foot">
Design &amp; Developed by: Omni-Net Technologies (p) Limited through UPDESCO . Data on this portal is maintained &amp; managed  by Nagar Palika Parishad Lalitpur, Uttar Pradesh.
</div>
                 
<?php require_once('dashboard-footer.php'); ?>
