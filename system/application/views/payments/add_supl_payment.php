<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('payment/add_supl_payment/'.$supplier_details[0]['supl_id'],$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Add Transaction Payment to <?php echo $supplier_details[0]['supl_comp'] ?> </div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
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
	
        <!-- BEGIN FORM-->
		
		
          <div class="form-body">		
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name <span class="required" aria-required="true"> *</span></label>
				  <?php 
						$firm_name = set_value('firm_name');				  
						echo form_dropdown('firm_name',$firmList,$firm_name,'class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required"');?>
				  		
				  
                   <span class="help-block help-block-error" for="firm_name" style="color:#F30;"><?php echo form_error('firm_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name</label>
                 <span class="form-control form-control-view"><?php echo $supplier_details[0]['supl_comp'] ?></span>
                  <input type="hidden" name="supl_id" id="supl_id" value="<?php echo $supplier_details[0]['supl_id'] ?>" required="required" />
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label"> Transaction Type <span class="required" aria-required="true"> *</span></label>
				  <?php 
						$firm_name = set_value('transaction_type');				  
						echo form_dropdown('transaction_type',array(''=>'Select Transaction Type','Credit'=>'Credit','Debit'=>'Debit'),$firm_name,'class="form-control select2me" tabindex="0" placeholder= "Select Transaction Type" required="required"');?>
				  		
				  
                   <span class="help-block help-block-error" for="transaction_type" style="color:#F30;"><?php echo form_error('transaction_type'); ?></span>
                  
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Transaction Amount <span class="required" aria-required="true"> *</span></label>
                    <?php 
						$transaction_amount = set_value('transaction_amount');				  
						$data_transaction_amount = array(
							 'name'         => 'transaction_amount',
							  'id'          => 'transaction_amount',
							  'value'       => $transaction_amount,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'type' => 'integer',
							  'maxlength' => '10',
							  'placeholder' => 'Transaction Amount'
							 );
				  		echo form_input($data_transaction_amount); 
				  ?>
					
                   <span class="help-block help-block-error" for="transaction_amount" style="color:#F30;"><?php echo form_error('transaction_amount'); ?></span>  
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Transaction Id<span class="required" aria-required="true"> *</span></label>                  
				  	<?php 
						$transaction_id = set_value('transaction_id');				  
						$data_transaction_id = array(
							 'name'         => 'transaction_id',
							  'id'          => 'transaction_id',
							  'value'       => $transaction_id,
							  'class'		=> 'form-control',
							  'maxlength' => '20',
							  'placeholder' => 'Transaction Id'
							 );
				  		echo form_input($data_transaction_id); 
				  ?>
				  
                   <span class="help-block help-block-error" for="contact_person" style="color:#F30;"><?php echo form_error('contact_person'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
				   <label class="control-label">Transaction Date<span class="required" aria-required="true"> *</span></label>
                       <?php 
					
						$transaction_date = set_value('transaction_date');				  
						$data_transaction_date = array(
							 'name'         => 'transaction_date',
							  'id'          => 'transaction_date',
							  'value'       => $transaction_date,
							  'class'		=> 'form-control',
							  'maxlength' => '15',
							  'placeholder' => 'Transaction Date'
							 );
				  		
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-end-date="+0d" data-date-format="yyyy-mm-dd">
					  <?php echo form_input($data_transaction_date);  ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				  
                   <span class="help-block help-block-error" for="transaction_date" style="color:#F30;"><?php echo form_error('transaction_date'); ?></span>             
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Transaction Title<span class="required" aria-required="true"> *</span></label>
				  <?php 
						$transaction_title = set_value('transaction_title');				  
						$data_transaction_title = array(
							 'name'         => 'transaction_title',
							  'id'          => 'transaction_title',
							  'value'       => $transaction_title,
							  'class'		=> 'form-control',
							  'maxlength' => '50',
							 ' required' => "required",
							  'placeholder' => 'Transaction Title'
							 );
				  		echo form_input($data_transaction_title); 
				  ?>
					
                   <span class="help-block help-block-error" for="data_transaction_title" style="color:#F30;"><?php echo form_error('data_transaction_title'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Payment By<span class="required" aria-required="true"> *</span></label> 
				  <?php 
						$payment_by = set_value('payment_by');				  
						$paymentOptions = array(''=>'Select Option', 'Bank Deposit'=>'Bank Deposit','Cash Deposit'=>'Cash Deposit','Bank Transfer- RTGS/NEFT'=>'Bank Transfer- RTGS/NEFT','Cash'=>'Cash', 'Cheque'=>'Cheque');
						echo form_dropdown('payment_by',$paymentOptions,$payment_by,'class="form-control select2me" tabindex="0" placeholder= "Payment By" ');			
										  		
				  ?>
				  <span class="help-block help-block-error" for="payment_by" style="color:#F30;"><?php echo form_error('payment_by'); ?></span>                   
                </div>
              </div>
			 </div>
			 
			 
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Payment Note</label>
				  <?php 
						$notes = set_value('notes');				  
						$data_notes = array(
							 'name'         => 'notes',
							  'id'          => 'notes',
							  'value'       => $notes,
							  'class'		=> 'form-control',
							  'cols' => '20',
							  'rows' => '5',
							  'placeholder' => 'Payment Notes'
							 );
				  		echo form_textarea($data_notes); 
				  ?>
					
                   <span class="help-block help-block-error" for="notes" style="color:#F30;"><?php echo form_error('notes'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   
                  
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
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url();?>supplier">
						<button type="button" class="btn default">Cancel</button>
						</a> </div>
					  <div class="col-md-6"> </div>
					</div>
				  </div>
				  
				  <!-- END FORM-->
				</div>
			  </div>
			</div>
			
			
			

<?php echo form_close(); ?>

<script type="text/javascript">
$(function(){
		
      	$(".checkAmt").blur(function() {
		  	var amt = parseFloat($(this).attr("value"));
			
			var id = $(this).attr("id");
			var payment_id = id.slice(7);
			var balance_amount = parseFloat($('#balance_amount_'+payment_id).val());
			
			if(balance_amount < amt){
				alert('Balance Amount is less than entered amount');
				$('#amount_'+payment_id).val('');
				$("#amount_"+payment_id).css("border-color", "red");
			}else{
				$("#amount_"+payment_id).css("border-color", "#CCCCCC")
			}
			
        });
		
		
    });
</script>