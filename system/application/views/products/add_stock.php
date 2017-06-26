<!-- BEGIN PAGE CONTENT-->
<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('products/add_stock/'.$product_details[0]['pid'],$attributes);
			
			
			$on_date = set_value('on_date');				  
			$data_on_date = array(
						  		 'name'         => 'on_date',
								  'id'          => 'on_date',
								  'value'       => $on_date,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'readonly' 	=> 'readonly',
								  'maxlength' => '12',
								  'placeholder' => 'Date'
								 );
								  
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Add Stock Of <?php echo $product_details[0]['product_name']; ?></div>
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
		 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
		  <?php echo $_SESSION['suc_msg'];
				 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
		  ?>
		</div>
		<?php } ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Date Of Inward<span class="required" aria-required="true"> *</span></label>
					<div class="input-group input-medium date date-picker" data-date-end-date="+0d" data-date-format="yyyy-mm-dd">
					  <?php echo form_input($data_on_date); ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				  
                   <span class="help-block help-block-error" for="on_date" style="color:#F30;"><?php echo form_error('on_date'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name<span class="required" aria-required="true"> *</span></label>
                  <?php 
				  $su_id = set_value('su_id');
				  echo form_dropdown('su_id',$suppliers_details,$su_id,'class="form-control select2me" tabindex="0" placeholder= "Select Supplier" required="required"');?>
                   <span class="help-block help-block-error" for="su_id" style="color:#F30;"><?php echo form_error('su_id'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name<span class="required" aria-required="true"> *</span></label>
					<?php 
				  $invoice_firm = set_value('invoice_firm');
				  $invoice_firm_array  = array('0'=>'Select Firm','1'=>'Horizon Agrotech', '2'=> 'Alligo Agrovet PVt. Ltd','7'=>'Animal Health','8'=>'Alligo Animal Health Bulk', '10'=>'Alligo Agro Bulk');
				  // echo form_dropdown('invoice_firm',$invoice_firm_array,$invoice_firm,'class="form-control" tabindex="0" required="required"');
				  echo form_dropdown('invoice_firm',$firmList,$invoice_firm,'class="form-control select2me" tabindex="0" placeholder= "Select Firm" required="required"');
				  ?>
				  
                   <span class="help-block help-block-error" for="invoice_firm" style="color:#F30;"><?php echo form_error('invoice_firm'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Name<span class="required" aria-required="true"> *</span></label>
                  <?php 
				  
				  echo form_dropdown('pid',$products_data,$product_details[0]['pid'],'class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required"');?>
                   <span class="help-block help-block-error" for="pid" style="color:#F30;"><?php echo form_error('pid'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Invoice Number<span class="required" aria-required="true"> *</span></label>
					<?php 
						$invoice_no = set_value('invoice_no');				  
						$data_invoice_no = array(
							 'name'         => 'invoice_no',
							  'id'          => 'invoice_no',
							  'value'       => $invoice_no,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'maxlength' => '20',
							  'placeholder' => 'Invoice Number'
							 );
				  		echo form_input($data_invoice_no); 
				  ?>
				  
                   <span class="help-block help-block-error" for="invoice_no" style="color:#F30;"><?php echo form_error('invoice_no'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Sample Number</label>
                  <?php 
						$sample_no = set_value('sample_no');				  
						$data_sample_no = array(
							 'name'         => 'sample_no',
							  'id'          => 'sample_no',
							  'value'       => $sample_no,
							  'class'		=> 'form-control',
							  'maxlength' => '15',
							  'placeholder' => 'Sample Number'
							 );
				  		echo form_input($data_sample_no); 
				  ?>
                   <span class="help-block help-block-error" for="sample_no" style="color:#F30;"><?php echo form_error('sample_no'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>         
			
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Packing<span class="required" aria-required="true"> *</span></label>
					<?php 
						$packing = set_value('packing');				  
						$data_packing = array(
							 'name'         => 'packing',
							 
							  'id'          => 'packing',
							  'value'       => $packing,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'maxlength' => '5',
							  'min' => '0',
							  'type'         => 'number',
							  'step' => 'any',
							  'placeholder' => 'Packing'
							 );
				  		echo form_input($data_packing); 
				  ?>
				  
                   <span class="help-block help-block-error" for="packing" style="color:#F30;"><?php echo form_error('packing'); ?></span>
                </div>
              </div>
              <!--/span-->
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Bags / Drums Numbers<span class="required" aria-required="true"> *</span></label>
                  <?php 
						$bag_no = set_value('bag_no');				  
						$data_bag_no = array(
							 'name'         => 'bag_no',
							  'id'          => 'bag_no',
							  'value'       => $bag_no,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'maxlength' => '5',
							  'min' => '0',
							  'step' => 'any',
							  'type'         => 'number',
							  'placeholder' => 'Total Bags/Drums'
							 );
				  		echo form_input($data_bag_no); 
				  ?>
                   <span class="help-block help-block-error" for="bag_no" style="color:#F30;"><?php echo form_error('bag_no'); ?></span>
                </div>
              </div>
              
              <!--/span--> 
            </div>
            
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Purchase Rate<span class="required" aria-required="true"> *</span></label>
					<?php 
						$rate = set_value('rate');				  
						$data_rate = array(
							 'name'         => 'rate',
							  'id'          => 'rate',
							  'value'       => $rate,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'maxlength' => '10',
							  'min' => '0',
							  'step' => 'any',
							  'type'         => 'number',
							  'placeholder' => 'Purchase Rate'
							 );
				  		echo form_input($data_rate); 
				  ?>
				  
                   <span class="help-block help-block-error" for="rate" style="color:#F30;"><?php echo form_error('rate'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Weight<span class="required" aria-required="true"> *</span></label>
                  <?php 
						$inw_qty  = set_value('inw_qty');				  
						$data_inw_qty  = array(
							 'name'         => 'inw_qty',
							  'id'          => 'inw_qty',
							  'value'       => $inw_qty ,
							  'class'		=> 'form-control',
							  'maxlength' => '15',
							  'required' 	=> 'required',
							  'min' => '0',
							  'step' => 'any',
							  'type'         => 'number',
							  'placeholder' => 'Product Weight'
							 );
				  		echo form_input($data_inw_qty); 
				  ?>
                   <span class="help-block help-block-error" for="inw_qty" style="color:#F30;"><?php echo form_error('inw_qty'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Manufacturing Date</label>
					<?php 
						$manufacturing_date = set_value('manufacturing_date');				  
						$data_manufacturing_date = array(
											 'name'         => 'manufacturing_date',
											  'id'          => 'manufacturing_date',
											  'value'       => $manufacturing_date,
											  'class'		=> 'form-control',
											  'readonly' 	=> 'readonly',
											  'maxlength' => '12',
											  'placeholder' => 'Manufacturing Date'
											 );
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-end-date="+0d" data-date-format="mm-yyyy" data-date-viewmode="years" data-date-minviewmode="months">
					  <?php echo form_input($data_manufacturing_date); ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				  
                   <span class="help-block help-block-error" for="manufacturing_date" style="color:#F30;"><?php echo form_error('manufacturing_date'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Expiry Date</label>
					<?php 
						$expiry_date = set_value('expiry_date');				  
						$data_expiry_date = array(
											 'name'         => 'expiry_date',
											  'id'          => 'expiry_date',
											  'value'       => $expiry_date,
											  'class'		=> 'form-control',
											  'readonly' 	=> 'readonly',
											  'maxlength' => '12',
											  'placeholder' => 'Expiry Date'
											 );
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-start-date="+0d" data-date-format="mm-yyyy" data-date-viewmode="years" data-date-minviewmode="months">
					  <?php echo form_input($data_expiry_date); ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				  
                   <span class="help-block help-block-error" for="expiry_date" style="color:#F30;"><?php echo form_error('expiry_date'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			<div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                                
				  	 <label class="control-label">GST Applied <span class="required" aria-required="true"> *</span></label> 
				  <?php 
						$tax_id = set_value('tax_id');				  
						echo form_dropdown('tax_id',$taxList,$tax_id,'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');?>
				  <span class="help-block help-block-error" for="tax_id" style="color:#F30;"><?php echo form_error('tax_id'); ?></span> 
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">CGST Applied </label> 
				  <?php 
						$excise = set_value('excise');				  
						echo form_dropdown('excise',$exciseTaxList,$excise,'class="form-control select2me" tabindex="0" placeholder= "Select Excise" required="required"');?>
				  <span class="help-block help-block-error" for="excise" style="color:#F30;"><?php echo form_error('excise'); ?></span>                   
                </div>
              </div>
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