<!-- BEGIN PAGE CONTENT-->

<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar"> <?php echo $bredcrumbs;?> </div>
<?php  
	    	//echo '<pre>'; print_r($interested_products[0]); die();
			$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('client/edit_interested_product/'.$interested_products[0]['id'].'/'.$pagename,$attributes);
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => 'Edit',
								'class' => 'btn green'
			);
			
			//echo '<pre>'; print_r($interested_products[0]['pid']); die();				
			
						  
	   ?>

	<?php if(isset($_SESSION['suc_msg'])){ ?> 
	 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
	  <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?>
	</div>
	<?php } ?>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Edit Product Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Name<span class="required" aria-required="true"> *</span></label>
                
				<?php 
				  
				  echo form_dropdown('pid',$products_data,$interested_products[0]['pid'],'class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required"');?>
                   <span class="help-block help-block-error" for="pid" style="color:#F30;"><?php echo form_error('pid'); ?></span>
				</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Quantity</label>
                <?php 
			  $quantity = set_value('quantity');				  
			  $data_quantity = array(
						  		 'name'         => 'quantity',
								  'id'          => 'quantity',
								  'value'       => $interested_products[0]['quantity'],
								  'class'		=> 'form-control',
								  'placeholder' => 'Expected Quantity'
								 );
		    
				
				echo form_input($data_quantity); ?>
                   <span class="help-block help-block-error" for="quantity" style="color:#F30;"><?php echo form_error('quantity'); ?></span>
              </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Season</label>
				
                <?php 
			  $season = set_value('season');				  
			  $data_season = array(
						  		 'name'         => 'season',
								  'id'          => 'season',
								  'value'       =>  $interested_products[0]['season'],
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder' => 'Products Required Months'
								 );
		    
				
				echo form_input($data_season); ?>
                   
				<span class="help-block help-block-error" for="season" style="color:#F30;"><?php echo form_error('season'); ?></span>
				</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Reminder Date<span class="required" aria-required="true"> *</span></label>
                <?php 
			  $reminder_date = set_value('reminder_date');	  
				$data_reminder_date = array(
					 'name'         => 'reminder_date',
					  'id'          => 'reminder_date',
					  'value'       => $interested_products[0]['reminder_date'],
					  'class'		=> 'form-control',
					  'required' 	=> 'required',
					  'readonly' 	=> 'readonly',
					  'maxlength' => '12',
					  'placeholder' => 'Date'
					 );
		    	?>
				<div class="input-group input-medium date date-picker" data-date-start-date="+0d" data-date-format="yyyy-mm-dd">
					  <?php echo form_input($data_reminder_date); ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
                <span class="help-block help-block-error" for="reminder_date" style="color:#F30;"><?php echo form_error('reminder_date'); ?></span>
              </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Notes</label>
                <?php 
			  $notes = set_value('notes');				  
			  $data_notes = array(
						  		 'name'         => 'notes',
								  'id'          => 'notes',
								  'value'       => $interested_products[0]['notes'],
								  'class'		=> 'form-control',
								  'placeholder' => 'Notes',
								  'rows' => 3,
								  'cols' => 10
								 );
		    
				echo form_textarea($data_notes); ?> 
				<span class="help-block help-block-error" for="notes" style="color:#F30;"><?php echo form_error('notes'); ?></span>
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
          <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> 
		  <a href="<?php echo base_url();?>leads">
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