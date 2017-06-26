<!-- BEGIN PAGE CONTENT-->
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i><?php echo $pagetitle;?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
       
          <div class="form-body">
		 	
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">User Name<span class="required" aria-required="true"></span></label>
				  <span class="form-control form-control-view"><?php echo $user_details[0]['username'] ?></span>
                   
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Full Name<span class="required" aria-required="true"></span></label>
                  <span class="form-control form-control-view"><?php echo $user_details[0]['first_name'].' '.$user_details[0]['last_name'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email<span class="required" aria-required="true"></span></label>
                     <span class="form-control form-control-view"><?php echo $user_details[0]['email']; ?></span>
                     
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Phone Number<span class="required" aria-required="true"></span></label>
                     <span class="form-control form-control-view"><?php echo $user_details[0]['phone_number']; ?></span>
                 	 
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                      <label class="control-label">User Role<span class="required" aria-required="true"></span></label>
                     <span class="form-control form-control-view"><?php echo $user_details[0]['user_role']; ?></span>  
                   </div>
              </div>
			  
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status<span class="required" aria-required="true"></span></label>
                   <span class="form-control form-control-view"><?php echo $user_details[0]['user_status']; ?></span> 
                </div>
              </div>
             </div>
             
             
            <!--/row--> 
          </div>
         
          
          <?php	
			echo form_fieldset_close(); 
			
		  ?>
        <!-- END FORM--> 
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT--> 