<!-- BEGIN PAGE CONTENT-->
<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('workers/add',$attributes);
			
			
			$emp_name = set_value('emp_name');				  
			$data_emp_name = array(
						  		 'name'         => 'emp_name',
								  'id'          => 'emp_name',
								  'value'       => $emp_name,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '50',
								  'placeholder' => 'Employee Name'
								 );
								 
			$emp_mobile = set_value('emp_mobile');				  
			$data_emp_mobile = array(
						  		 'name'         => 'emp_mobile',
								  'id'          => 'emp_mobile',
								  'value'       => $emp_mobile ,
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								  'placeholder' => 'Mobile Number',
								  'required' 	=> 'required',
								 );	
								 
			$emp_address = set_value('emp_address');				  
			$data_emp_address = array(
						  		 'name'         => 'emp_address',
								  'id'          => 'emp_address',
								  'value'       => $emp_address ,
								  'class'		=> 'form-control',
								  'cols' => 20,
								  'rows'=> 5,
								 );	
								 
								 					 
								 					  
			$data_status = array();
			$data_status['Active'] = 'Active';
			$data_status['In-Active'] = 'In-Active';
			$status_data = set_value('status');
		
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
						  
	   ?>
       


<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Employee Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">   
		   <?php if(validation_errors()){?>
          <div class="alert alert-danger display-hide" style="display: block;">
            <button class="close" data-close="alert"></button>
            You have some form errors. Please check below. </div>
          <?php } ?>
			<?php 
			
			if(isset($_SESSION['suc_msg'])){ ?>
			 <div class="col-md-12 col-sm-12"> 
				 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
				  <?php echo $_SESSION['suc_msg'];
						 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
				  ?>
				</div>
			</div>
        <?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Employee Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_emp_name); ?>
                   <span class="help-block help-block-error" for="emp_name" style="color:#F30;"><?php echo form_error('emp_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                 <label class="control-label">Contact Number<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_emp_mobile); ?>
                   <span class="help-block help-block-error" for="emp_mobile" style="color:#F30;"><?php echo form_error('emp_mobile'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>   						
			
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Address</label>
                  <?php echo form_textarea($data_emp_address); ?>
                  <span class="help-block help-block-error" for="emp_address" style="color:#F30;"><?php echo form_error('emp_address'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_dropdown('emp_status',$data_status,$status_data,'class="select2_category form-control" tabindex="0"');?>
                   <span class="help-block help-block-error" for="emp_status" style="color:#F30;"><?php echo form_error('emp_status'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>        
          </div>         
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="portlet-body form">
      <div class="form-actions right">
        <div class="row">
          <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url();?>workers">
            <button type="button" class="btn default">Cancel</button>
            </a> </div>
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
<!-- END PAGE CONTENT--> 