<!-- BEGIN PAGE CONTENT-->

<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar"> <?php echo $bredcrumbs;?> </div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('client/edit/'.$client_details[0]['comp_id'],$attributes);
			
			
			$comp_name = set_value('comp_name');				  
			$data_comp_name = array(
						  		 'name'         => 'comp_name',
								  'id'          => 'comp_name',
								  'value'       => $client_details[0]['comp_name'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '100',
								  'placeholder' => 'Company Name'
								 );
								 
			
								  
				$notes = set_value('notes');				  
			$data_notes = array(
						  		 'name'         => 'notes',
								  'id'          => 'notes',
								  'value'       => $client_details[0]['notes'] ,
								  'class'		=> 'form-control',
								  'cols' => 20,
								  'rows'=> 5,
								 );
								 
			$other_information = set_value('other_information');				  
			$data_other_information = array(
						  		 'name'         => 'other_information',
								  'id'          => 'other_information',
								  'value'       => $client_details[0]['other_information'] ,
								  'class'		=> 'form-control',
								  'cols' => 20,
								  'rows'=> 5,
								 );	
								 				  
			$data_status = array();
			$data_status['Active'] = 'Active';
			$data_status['In-Active'] = 'In-Active';
			$status_data = set_value('status');
			////			
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
	   
			
			$primary_contact = set_value('primary_contact');				  
			$data_primary_contact = array(
						  		 'name'         => 'primary_contact',
								  'id'          => 'primary_contact',
								  'value'       => $client_details[0]['primary_contact'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '30',
								 );
								 
			$primary_phone = set_value('primary_phone');				  
			$data_primary_phone = array(
						  		 'name'         => 'primary_phone',
								  'id'          => 'primary_phone',								  
								  'value'       => $client_details[0]['primary_phone'],
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'maxlength' => '12',
								 );					 	
								 
			$primary_mobile = set_value('primary_mobile');				  
			$data_primary_mobile = array(
						  		 'name'         => 'primary_mobile',
								  'id'          => 'primary_mobile',
								  'value'       => $client_details[0]['primary_mobile'] ,
								  'class'		=> 'form-control',
								  'maxlength' => '12',
								 );	
			$primary_email = set_value('primary_email');				  
			$data_primary_email = array(
						  		 'name'         => 'primary_email',
								  'type' => 'email',
								  'id'          => 'primary_email',
								  'value'       => $client_details[0]['primary_email'] ,
								  'class'		=> 'form-control',
								 // 'required' 	=> 'required',
								  'maxlength' => '100',
								  );
								  
		    $primary_fax = set_value('primary_fax');				  
			$data_primary_fax = array(
						  		 'name'         => 'primary_fax',
								  'id'          => 'primary_fax',
								  'value'       => $client_details[0]['primary_fax']  ,
								  'class'		=> 'form-control',
								  'maxlength' => '12',
								 );	
			$state = set_value('state');									 
			$city = set_value('city');				  
			$data_city = array(
						  		 'name'         => 'city',
								  'id'          => 'city',
								  'value'       => $client_details[0]['city'] ,
								  'class'		=> 'form-control',
								  'maxlength' => '30',
								 );	
			$shipping_address = set_value('shipping_address');				  
			$data_shipping_address = array(
						  		 'name'         => 'shipping_address',
								  'id'          => 'shipping_address',
								  'value'       => $client_details[0]['shipping_address'] ,
								  'class'		=> 'form-control',
								  'cols' => 20,
								  'rows'=> 5,
								 );	
						  
	   ?>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Company Details</div>
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
			<?php if(isset($_SESSION['suc_msg'])){ ?>
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
                <label class="control-label">Company Name<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_comp_name); ?> <span class="help-block help-block-error" for="comp_name" style="color:#F30;"><?php echo form_error('comp_name'); ?></span> </div>
            </div>
            <!--/span-->
            
          </div>
      
          <!--/row-->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Contact Name<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_primary_contact); ?> <span class="help-block help-block-error" for="primary_contact" style="color:#F30;"><?php echo form_error('primary_contact'); ?></span> </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Email<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_primary_email); ?> <span class="help-block help-block-error" for="primary_phone" style="color:#F30;"><?php echo form_error('primary_email'); ?></span> </div>
            </div>
            <!--/span-->
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Phone Number<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_primary_phone); ?> <span class="help-block help-block-error" for="primary_phone" style="color:#F30;"><?php echo form_error('primary_phone'); ?></span> </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Mobile</label>
                <?php echo form_input($data_primary_mobile); ?> <span class="help-block help-block-error" for="primary_mobile" style="color:#F30;"><?php echo form_error('primary_mobile'); ?></span> </div>
            </div>
            <!--/span-->
          </div>
          
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">City</label>
                <?php echo form_input($data_city); ?> <span class="help-block help-block-error" for="city" style="color:#F30;"><?php echo form_error('city'); ?></span> </div>
            </div>
           
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Address</label>
                <?php echo form_textarea($data_shipping_address); ?> <span class="help-block help-block-error" for="shipping_address" style="color:#F30;"><?php echo form_error('shipping_address'); ?></span> </div>
            </div>
            <!--/span-->
          </div>
          <!--/row-->
         <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Notes</label>
                <?php echo form_textarea($data_notes); ?> <span class="help-block help-block-error" for="notes" style="color:#F30;"><?php echo form_error('notes'); ?></span> </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Other Information</label>
                <?php echo form_textarea($data_other_information); ?> <span class="help-block help-block-error" for="other_information" style="color:#F30;"><?php echo form_error('other_information'); ?></span> </div>
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
								  'value'       => $client_details[0]['tin_num'] ,
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								 );
								 
			$vat_no = set_value('vat_no');				  
			$data_vat_no = array(
						  		 'name'         => 'vat_no',
								  'id'          => 'vat_no',								  
								  'value'       => $client_details[0]['vat_no'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								 );					 	
								 
			
			$excise_no = set_value('excise_no');				  
			$data_excise_no = array(
						  		 'name'         => 'excise_no',
								  'id'          => 'excise_no',
								  'value'       => $client_details[0]['excise_no'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								  );
			$cst_no = set_value('cst_no');				  
			$data_cst_no = array(
						  		 'name'         => 'cst_no',
								  'id'          => 'cst_no',
								  'value'       => $client_details[0]['cst_no'],
								  'class'		=> 'form-control',
								  'maxlength' => '25',
								  );
								  
		    $pan_no = set_value('pan_no');				  
			$data_pan_no = array(
						  		 'name'         => 'pan_no',
								  'id'          => 'pan_no',
								  'value'       => $client_details[0]['pan_no'] ,
								  'class'		=> 'form-control',
								  'maxlength' => '12',
								 );
				$gstin_num = set_value('gstin_num');				  
			$data_gstin_num = array(
						  		 'name'         => 'gstin_num',
								  'id'          => 'gstin_num',
								  'value'       => $client_details[0]['gstin_num'],
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
                <?php echo form_input($data_tin_num); ?> <span class="help-block help-block-error" for="tin_num" style="color:#F30;"><?php echo form_error('tin_num'); ?></span> </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">PAN Number<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_pan_no); ?> <span class="help-block help-block-error" for="pan_no" style="color:#F30;"><?php echo form_error('pan_no'); ?></span> </div>
            </div>
            <!--/span-->
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">VAT Number</label>
                <?php echo form_input($data_vat_no); ?> <span class="help-block help-block-error" for="vat_no" style="color:#F30;"><?php echo form_error('vat_no'); ?></span> </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">CST Number</label>
                <?php echo form_input($data_cst_no); ?> <span class="help-block help-block-error" for="cst_no" style="color:#F30;"><?php echo form_error('cst_no'); ?></span> </div>
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
                <?php echo form_input($data_excise_no); ?> <span class="help-block help-block-error" for="excise_no" style="color:#F30;"><?php echo form_error('excise_no'); ?></span> </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Status<span class="required" aria-required="true"> *</span></label>
                <?php echo form_dropdown('status',$data_status,$client_details[0]['status'],'class="select2_category form-control" tabindex="0"');?> <span class="help-block help-block-error" for="status" style="color:#F30;"><?php echo form_error('status'); ?></span> </div>
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