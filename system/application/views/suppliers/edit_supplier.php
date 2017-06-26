<!-- BEGIN PAGE CONTENT-->
<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('supplier/edit/'.$supplier_details[0]['supl_id'],$attributes);
			
			
			$supl_comp = set_value('supl_comp');				  
			$data_supl_comp = array(
						  		 'name'         => 'supl_comp',
								  'id'          => 'supl_comp',
								  'value'       => $supplier_details[0]['supl_comp'],
								  'class'		=> 'form-control',
								 // 'required' 	=> 'required',
								  'maxlength' => '100',
								  'placeholder' => 'Supplier Name'
								 );
								 
			$supl_conperson = set_value('supl_conperson');				  
			$data_supl_conperson = array(
						  		 'name'         => 'supl_conperson',
								  'id'          => 'supl_conperson',								  
								  'value'       => $supplier_details[0]['supl_conperson'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '50',
								  'placeholder' => 'Contact Person'
								 );	
								 
			$supl_phone = set_value('supl_phone');				  
			$data_supl_phone = array(
						  		 'name'         => 'supl_phone',
								  'id'          => 'supl_phone',								  
								  'value'       => $supplier_details[0]['supl_phone'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '15',
								  'placeholder' => 'Phone Number'
								 );					 	
								 
			
			$supl_mobile = set_value('supl_mobile');				  
			$data_supl_mobile = array(
						  		 'name'         => 'supl_mobile',
								  'id'          => 'supl_mobile',								  
								  'value'       => $supplier_details[0]['supl_mobile'],
								  'class'		=> 'form-control',
								  // 'required' 	=> 'required',
								  'maxlength' => '15',
								  'placeholder' => 'Mobile Number'
								 );					 	
								 
			$supl_email = set_value('supl_email');				  
			$data_supl_email = array(
						  		 'name'         => 'supl_email',
								  'id'          => 'supl_email',
								  'value'       => $supplier_details[0]['supl_email'],
								  'class'		=> 'form-control',
								 // 'required' 	=> 'required',
								  'maxlength' => '100',
								  'placeholder'		=> 'Corporate Email'
								  );
								  
			
								  
			$supl_state = set_value('supl_state');				  
			$data_supl_state = array(
						  		 'name'         => 'supl_state',
								  'id'          => 'supl_state',
								  'value'       => $supplier_details[0]['supl_state'],
								  'class'		=> 'form-control',
								 // 'required' 	=> 'required',
								  'maxlength' => '100',
								  'placeholder'		=> 'State'
								  );
			$supl_city = set_value('supl_city');				  
			$data_supl_city = array(
						  		 'name'         => 'supl_city',
								  'id'          => 'supl_city',
								  'value'       => $supplier_details[0]['supl_city'],
								  'class'		=> 'form-control',
								  // 'required' 	=> 'required',
								  'maxlength' => '100',
								  'placeholder'		=> 'City'
								  );
								  
								  
			$supl_address = set_value('supl_address');				  
			$data_supl_address = array(
						  		 'name'         => 'supl_address',
								  'id'          => 'supl_address',
								  'value'       => $supplier_details[0]['supl_address'] ,
								  'class'		=> 'form-control',
								  'cols' => 20,
								  'rows'=> 5,
								 // 'required' 	=> 'required',
								  'placeholder' => 'Office Address'
								 );				
			
			$supl_email = set_value('supl_email');				  
			$data_supl_email = array(
						  		 'name'         => 'supl_email',
								  'id'          => 'supl_email',
								  'value'       => $supplier_details[0]['supl_email'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '100',
								  'placeholder'		=> 'Email'
								  );
			$supl_website = set_value('corp_website');				  
			$data_supl_website = array(
						  		 'name'         => 'supl_website',
								  'id'          => 'supl_website',
								  'value'       => $supplier_details[0]['supl_website'],
								  'class'		=> 'form-control',
								  'maxlength' => '100',
								  'placeholder'		=> 'Website'
								  );
								  
								  
			$data_status = array();
			$data_status[0] = 'Active';
			$data_status[1] = 'In-Active';
			$status_data = set_value('is_deleted');
		
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
        <div class="caption"> <i class="fa fa-gift"></i>Supplier Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">
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
                  <label class="control-label">Company Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_supl_comp); ?>
                   <span class="help-block help-block-error" for="supl_comp" style="color:#F30;"><?php echo form_error('supl_comp'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Contact Person<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_supl_conperson); ?>
                   <span class="help-block help-block-error" for="supl_conperson" style="color:#F30;"><?php echo form_error('supl_conperson'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Phone Number<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_supl_phone); ?>
                   <span class="help-block help-block-error" for="supl_phone" style="color:#F30;"><?php echo form_error('supl_phone'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Mobile Number<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_supl_mobile); ?>
                   <span class="help-block help-block-error" for="supl_mobile" style="color:#F30;"><?php echo form_error('supl_mobile'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row-->
			
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_input($data_supl_email); ?>
                     <span class="help-block help-block-error" for="corp_email" style="color:#F30;"><?php echo form_error('supl_email'); ?></span> 
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Website</label>
                     <?php echo form_input($data_supl_website); ?>
                 	 <span class="help-block help-block-error" for="supl_website" style="color:#F30;"><?php echo form_error('supl_website'); ?></span>
					 
                </div>
              </div>
              <!--/span--> 
            </div>
            <!--/row--> 
			          
            <div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Office Address</label>
                  <?php echo form_textarea($data_supl_address); ?>
                  <span class="help-block help-block-error" for="supl_address" style="color:#F30;"><?php echo form_error('supl_address'); ?></span>
                </div>
              </div>
              <!--/span--> 
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">City</label>
                     <?php echo form_input($data_supl_city); ?>
                 	 <span class="help-block help-block-error" for="supl_website" style="color:#F30;"><?php echo form_error('supl_city'); ?></span>
					 
                </div>
              </div>
              <!--/span-->
            </div>
            
          </div>
         
          
      </div>
    </div>
  </div>
</div>


<?php  
			
			$tin_num = set_value('tin_num');				  
			$data_tin_num = array(
						  		 'name'         => 'tin_num',
								  'id'          => 'tin_num',
								  'value'       => $supplier_details[0]['tin_num'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								 );
								 
			$vat_no = set_value('vat_no');				  
			$data_vat_no = array(
						  		 'name'         => 'vat_no',
								  'id'          => 'vat_no',								  
								  'value'       => $supplier_details[0]['vat_no'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								 );					 	
								 
			
			$excise_no = set_value('excise_no');				  
			$data_excise_no = array(
						  		 'name'         => 'excise_no',
								  'id'          => 'excise_no',
								  'value'       => $supplier_details[0]['excise_no'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								  );
			$cst_no = set_value('cst_no');				  
			$data_cst_no = array(
						  		 'name'         => 'cst_no',
								  'id'          => 'cst_no',
								  'value'       => $supplier_details[0]['cst_no'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								  );
								  
		    $pan_no = set_value('pan_no');				  
			$data_pan_no = array(
						  		 'name'         => 'pan_no',
								  'id'          => 'pan_no',
								  'value'       => $supplier_details[0]['pan_no'] ,
								  'class'		=> 'form-control',
								  'maxlength' => '12',
								 );	
			
			$special_comment = set_value('special_comment');				  
			$data_special_comment = array(
						  		 'name'         => 'special_comment',
								  'id'          => 'special_comment',
								  'value'       => $supplier_details[0]['special_comment'] ,
								  'class'		=> 'form-control',
								  'cols' => 20,
								  'rows'=> 5,
								 );
								 
			$gstin_num = set_value('gstin_num');				  
			$data_gstin_num = array(
						  		 'name'         => 'gstin_num',
								  'id'          => 'gstin_num',
								  'value'       => $supplier_details[0]['gstin_num'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '25',
								  );
								 
									  
	   ?>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Other Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">TIN Number</label>
                  <?php echo form_input($data_tin_num); ?>
                   <span class="help-block help-block-error" for="tin_num" style="color:#F30;"><?php echo form_error('tin_num'); ?></span>
                </div>
              </div>
              <!--/span-->
			 
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">PAN Number<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_pan_no); ?>
                   <span class="help-block help-block-error" for="pan_no" style="color:#F30;"><?php echo form_error('pan_no'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
			   <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">VAT Number</label>
                  <?php echo form_input($data_vat_no); ?>
                   <span class="help-block help-block-error" for="vat_no" style="color:#F30;"><?php echo form_error('vat_no'); ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">CST Number</label>
                  <?php echo form_input($data_cst_no); ?>
                   <span class="help-block help-block-error" for="cst_no" style="color:#F30;"><?php echo form_error('cst_no'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>	
			 <div class="row">
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">GSTin Number<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_gstin_num); ?>
                   <span class="help-block help-block-error" for="gstin_num" style="color:#F30;"><?php echo form_error('gstin_num'); ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                   
                </div>
              </div>
              <!--/span--> 
            </div>
			<div class="row">
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Excise Number</label>
                  <?php echo form_input($data_excise_no); ?>
                   <span class="help-block help-block-error" for="excise_no" style="color:#F30;"><?php echo form_error('excise_no'); ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_dropdown('is_deleted',$data_status,$supplier_details[0]['is_deleted'],'class="select2_category form-control" tabindex="0"');?>
                   <span class="help-block help-block-error" for="status" style="color:#F30;"><?php echo form_error('is_deleted'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			
					
			<div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Notes</label>
                  <?php echo form_textarea($data_special_comment); ?>
                  <span class="help-block help-block-error" for="special_comment" style="color:#F30;"><?php echo form_error('special_comment'); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                <div class="form-group">
                  
                </div>
              </div>
              <!--/span--> 
            </div>                      
            <!--/row-->
			
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
          <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url();?>client">
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