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
       <?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('users/edit',$attributes);
			
			
			$username = set_value('username');				  
			$data_username = array(
						  		 'name'         => 'username',
								  'id'          => 'username',
								  'value'       => $user_details[0]['username'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '12',
								  'placeholder' => 'User Name'
								 );
								 
			$pass = set_value('pass');				  
			$data_pass = array(
						  		 'name'         => 'pass',
								  'id'          => 'pass',
								  'type'          => 'password',
								  'value'       => '',
								  'class'		=> 'form-control',
								  'max_length' => '8',
								  'min_length' => '8',
								  'placeholder' => 'Password'
								 );					 
			
			$first_name = set_value('first_name');				  
			$data_first_name = array(
						  		 'name'         => 'first_name',
								  'id'          => 'first_name',
								  'value'       => $user_details[0]['first_name'] ,
								  'max_length' => '12',
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder' => 'First Name'
								 );	
								 
			$last_name = set_value('last_name');				  
			$data_last_name = array(
						  		 'name'         => 'last_name',
								  'id'          => 'last_name',
								  'value'       => $user_details[0]['last_name'] ,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '12',
								  'placeholder' => 'Last Name'
								 );	
			
		     $email = set_value('email');				  
			$data_email = array(
						  		 'name'         => 'email',
								  'id'          => 'email',
								  'value'       => $user_details[0]['email'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '100',
								  'placeholder' => 'Email Id'
								 );			
			
			$phone_number = set_value('phone_number');				  
			$data_phone_number = array(
						  		 'name'         => 'phone_number',
								  'id'          => 'phone_number',
								  'value'       => $user_details[0]['phone_number'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '13',
								  'placeholder'		=> 'phone Number'
								  );
								  
			$data_user_role = array();
			$data_user_role['Accounts'] = 'Accounts';
			$data_user_role['Admin'] = 'Admin';
			$data_user_role['Logistics'] = 'Logistics';
			$data_user_role['Purchase'] = 'Purchase';
			$data_user_role['QC'] = 'QC';
			$data_user_role['Sales'] = 'Sales';
			$user_role = set_value('user_role');					  
			// enum('Admin','Sales','Purchase','QC','Logistics','Accounts')				
			$data_status = array();
			$data_status['Active'] = 'Active';
			$data_status['In-Active'] = 'In-Active';
			$status_data = set_value('user_status');
		
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
						  
	   ?>
          <div class="form-body">
		  <input type="hidden" name="uid" id="uid" value="<?php echo $user_details[0]['uid']?>"  />
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php }  ?>
			<?php 			
			  if(isset($_SESSION['suc_msg'])){ ?> 
				 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
				  <?php echo $_SESSION['suc_msg'];
						 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
				  ?>
				</div>
				<?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">User Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_username); ?>
                   <span class="help-block help-block-error" for="username" style="color:#F30;"><?php echo form_error('username'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Password<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_pass); ?>
                   <span class="help-block help-block-error" for="pass" style="color:#F30;"><?php echo form_error('pass'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">First Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_first_name); ?>
                  <span class="help-block help-block-error" for="first_name" style="color:#F30;"><?php echo form_error('first_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Last Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_last_name); ?>
                  <span class="help-block help-block-error" for="last_name" style="color:#F30;"><?php echo form_error('last_name'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_email); ?>
                     <span class="help-block help-block-error" for="email" style="color:#F30;"><?php echo form_error('email'); ?></span> 
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Phone Number<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_phone_number); ?>
                 	 <span class="help-block help-block-error" for="phone_number" style="color:#F30;"><?php echo form_error('phone_number'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">              
                 
                 	  
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status<span class="required" aria-required="true"> *</span></label>
                   <?php echo form_dropdown('user_status',$data_status,$user_details[0]['user_status'],'class="select2_category form-control" tabindex="0"');?>
                   <span class="help-block help-block-error" for="user_status" style="color:#F30;"><?php echo form_error('user_status'); ?></span> 
                </div>
              </div>
             </div>
             
             
            <!--/row--> 
          </div>
         
          <div class="form-actions right">
            <div class="row">
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>users"><button type="button" class="btn default">Cancel</button></a>
                  </div>
              <div class="col-md-6"> </div>
            </div>
          </div>
          <?php	
			echo form_fieldset_close(); 
			echo form_close();
		  ?>
        <!-- END FORM--> 
      </div>
    </div>
  </div>
</div>

<!-- END PAGE CONTENT--> 
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/users.js"></script>