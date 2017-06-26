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
			echo form_open_multipart('products/add/',$attributes);
			
			
			$item_code = set_value('item_code');				  
			$data_item_code = array(
						  		 'name'         => 'item_code',
								  'id'          => 'item_code',
								  'value'       => $item_code,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '20',
								  'placeholder' => 'Item Code'
								 );
								 
		/*	$product_brand = set_value('product_brand');				  
			$data_product_brand = array(
						  		 'name'         => 'product_brand',
								  'id'          => 'product_brand',
								  'value'       => $product_brand,
								  'class'		=> 'form-control',
								  'max_length' => '150',
								  'placeholder' => 'Product Brand'
								 );	*/
								 
			$initial_stock = set_value('initial_stock');				  
			$data_initial_stock = array(
						  		 'name'         => 'initial_stock',
								  'id'          => 'initial_stock',
								  'value'       => $initial_stock,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '8',
								  'placeholder' => 'Initial Stock'
								 );	
								 
			$initial_stock_rate = set_value('initial_stock_rate');				  
			$data_initial_stock_rate = array(
						  		 'name'         => 'initial_stock_rate',
								  'id'          => 'initial_stock_rate',
								  'value'       => $initial_stock_rate,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '8',
								  'placeholder' => 'Initial Stock Rate'
								 );					 
			
			$product_name = set_value('product_name');				  
			$data_product_name = array(
						  		 'name'         => 'product_name',
								  'id'          => 'product_name',
								  'value'       => $product_name ,
								  'max_length' => '150',
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder' => 'Product Name'
								 );	
								 
			$hsn_code = set_value('hsn_code');				  
			$data_hsn_code = array(
						  		 'name'         => 'hsn_code',
								  'id'          => 'hsn_code',
								  'value'       => $hsn_code ,
								  'max_length' => '50',
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder' => 'HSN Code'
								 );	
								 
			$product_desc = set_value('product_desc');				  
			$data_product_desc = array(
						  		 'name'         => 'product_desc',
								  'id'          => 'product_desc',
								  'cols' => 40,
								  'rows'=> 5,
								  'value'       => '',
								  'class'		=> 'form-control',
								  'placeholder' => 'Product Description'
								 );	
			
		     $prod_unit = set_value('prod_unit');				  
				$data_prod_unit = array();
				$data_prod_unit['Grm'] = 'Grm';
				$data_prod_unit['Kg'] = 'Kg';
				$data_prod_unit['Lit'] = 'Lit';	
				$data_prod_unit['Ml'] = 'Ml';				
				$data_prod_unit['Nos'] = 'Nos';		
				
			
			
			$min_qty = set_value('min_qty');				  
			$data_min_qty = array(
						  		 'name'         => 'min_qty',
								  'id'          => 'min_qty',
								  'value'       => $min_qty,
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'max_length' => '13',
								  'placeholder'		=> 'Minimum Quantity'
								  );
								  
			
				
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			
						  
	   ?>
          <div class="form-body">
		  
            <?php if(validation_errors()){?>
                <div class="alert alert-danger display-hide" style="display: block;">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
            <?php } ?>
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
                  <label class="control-label">Product Code<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_item_code); ?>
                   <span class="help-block help-block-error" for="item_code" style="color:#F30;"><?php echo form_error('item_code'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Name<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_product_name); ?>
                   <span class="help-block help-block-error" for="product_name" style="color:#F30;"><?php echo form_error('product_name'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                       <label class="control-label">Min. Quantity<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_min_qty); ?>
                  <span class="help-block help-block-error" for="min_qty" style="color:#F30;"><?php echo form_error('min_qty'); ?></span>
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Product Unit<span class="required" aria-required="true"> *</span></label>
                     <?php echo form_dropdown('prod_unit',$data_prod_unit,$prod_unit,'class="select2_category form-control" tabindex="0"');?>
                      <span class="help-block help-block-error" for="prod_unit" style="color:#F30;"><?php echo form_error('prod_unit'); ?></span> 
                </div>
              </div>
              <!--/span--> 
            </div>
			<div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Initial Stock<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_initial_stock); ?>
                  <span class="help-block help-block-error" for="initial_stock" style="color:#F30;"><?php echo form_error('initial_stock'); ?></span>
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Initial Stock Rate<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_initial_stock_rate); ?>
                  <span class="help-block help-block-error" for="initial_stock_rate" style="color:#F30;"><?php echo form_error('initial_stock_rate'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">HSN Code<span class="required" aria-required="true"> *</span></label>
                  <?php echo form_input($data_hsn_code); ?>
                  <span class="help-block help-block-error" for="hsn_code" style="color:#F30;"><?php echo form_error('hsn_code'); ?></span>
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Is Tax Free?<span class="required" aria-required="true"> *</span></label>
                  <?php 
				  
				  $tax_free = set_value('tax_free');				  
					$data_tax_free = array();
					$data_tax_free['No'] = 'No'; 
					$data_tax_free['Yes'] = 'Yes';
									  
				  echo form_dropdown('tax_free',$data_tax_free,$tax_free,'class="select2_category form-control" tabindex="0"');?> 
                  <span class="help-block help-block-error" for="tax_free" style="color:#F30;"><?php echo form_error('tax_free'); ?></span>
                   </div>
                </div>
              </div>
              <!--/span--> 
           
			<div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">SGST %<span class="required" aria-required="true"> *</span></label>
                  <?php 
					$sgst_per = set_value('sgst_per');				  
					$data_sgst_per = array(
										 'name'         => 'sgst_per',
										  'id'          => 'sgst_per',
										  'value'       => $sgst_per ,
										  'max_length' => '4',
										  'class'		=> 'form-control',
										  'required' 	=> 'required',
										  'type' 	=> 'number',
										  'min' 	=> 0,
										  'step' 	=> 'any',
										  'placeholder' => 'SGST Percentage'
										 );	
				  
				  echo form_input($data_sgst_per); ?>
                  <span class="help-block help-block-error" for="sgst_per" style="color:#F30;"><?php echo form_error('sgst_per'); ?></span>
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">IGST %<span class="required" aria-required="true"> *</span></label>
                  <?php 
				  $igst_per = set_value('igst_per');				  
					$data_igst_per = array(
										 'name'         => 'igst_per',
										  'id'          => 'igst_per',
										  'value'       => $igst_per ,
										  'max_length' => '4',
										  'class'		=> 'form-control',
										  'required' 	=> 'required',
										  'type' 	=> 'number',
										  'min' 	=> 0,
										  'step' 	=> 'any',
										  'placeholder' => 'IGST Percentage'
										 );
				  
				  
				  echo form_input($data_igst_per); ?>
                  <span class="help-block help-block-error" for="igst_per" style="color:#F30;"><?php echo form_error('igst_per'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">CGST %<span class="required" aria-required="true"> *</span></label>
                  <?php 
					$cgst_per = set_value('cgst_per');				  
					$data_cgst_per = array(
										 'name'         => 'cgst_per',
										  'id'          => 'cgst_per',
										  'value'       => $cgst_per ,
										  'max_length' => '4',
										  'class'		=> 'form-control',
										  'required' 	=> 'required',
										  'type' 	=> 'number',
										  'min' 	=> 0,
										  'step' 	=> 'any',
										  'placeholder' => 'CGST Percentage'
										 );	
				  
				  echo form_input($data_cgst_per); ?>
                  <span class="help-block help-block-error" for="cgst_per" style="color:#F30;"><?php echo form_error('cgst_per'); ?></span>
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Max Selling Price <span class="required" aria-required="true"> *</span></label>
                  <?php 
					$selling_price = set_value('selling_price');				  
					$data_selling_price = array(
										 'name'         => 'selling_price',
										  'id'          => 'selling_price',
										  'value'       => $selling_price ,
										  'max_length' => '10',
										  'class'		=> 'form-control',
										  'required' 	=> 'required',
										  'type' 	=> 'number',
										  'min' 	=> 0,
										  'step' 	=> 'any',
										  'placeholder' => 'Max Selling Price'
										 );	
				  
				  echo form_input($data_selling_price); ?>
                  <span class="help-block help-block-error" for="selling_price" style="color:#F30;"><?php echo form_error('selling_price'); ?></span>
                   </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">              
                 
                 <div class="col-md-12">
                   <div class="form-group">
                  <label class="control-label">Product Description</label>
                  <?php // echo form_textarea($data_product_desc); ?>
				  <?php echo $this->ckeditor->editor("product_desc",$product_desc); ?>
                  <span class="help-block help-block-error" for="product_desc" style="color:#F30;"><?php echo form_error('product_desc'); ?></span>
                </div>
              </div>
			  
			  
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
                  <div class="col-md-offset-3 col-md-9">
                    <?php echo form_submit($arr_submit)?>
                    <a href="<?php echo base_url();?>products"><button type="button" class="btn default">Cancel</button></a>
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