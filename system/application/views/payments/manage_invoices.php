<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('accounts/payment/manage_invoices/'.$client_details[0]['comp_id'],$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Manage Invoices Payment </div>
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
                  <label class="control-label">Company Name</label>
                 <span class="form-control form-control-view"><?php echo $client_details[0]['comp_name'] ?></span>
                  <input type="hidden" name="comp_id" id="comp_id" value="<?php echo $client_details[0]['comp_id'] ?>" required="required" />
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
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
<?php if(sizeof($invoiceList) > 0){?>

<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Invoice Payments</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th width="30%"> Invoice #</th>
				<th width="20%"> Invoice Amount</th>
				<th width="20%"> Balance Amount	</th>
				<th width="20%"> Add Amount</th>
				
            </tr>
          </thead>
          <tbody id="tableBody">
           <?php foreach($invoiceList as $invoice){ ?>
			<tr class="gradeX odd">
				<td width="20%"> <?php echo $invoice['invoice_number']; ?></td>
				<td width="15%"> <?php echo number_format($invoice['invoice_amount'],2); ?>
				<input type="hidden" min="0" class="form-control" name="payment_id[]" id="payment_<?php echo $invoice['payment_id']; ?>" value= "<?php echo $invoice['payment_id']; ?>" />
				<input type="hidden" min="0" class="form-control" name="balance_amount[]" id="balance_amount_<?php echo $invoice['payment_id']; ?>"  value= "<?php echo ($invoice['invoice_amount']- $invoice['paid_amount']); ?>" />
				
				</td>
				<td width="10%"> <?php echo number_format(($invoice['invoice_amount']- $invoice['paid_amount']),2); ?></td>
				<td width="10%"> <input type="number" min="0" step="any" id="amount_<?php echo $invoice['payment_id']; ?>"  class="checkAmt form-control" Placeholder="Ex. 5000.00" name="amount[]" value= "" /> </td>
				
			</tr> 
			<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<?php } ?>
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
				  
				  <!-- END FORM-->
				</div>
			  </div>
			</div>
			
			
			

<?php echo form_close(); ?>

<script type="text/javascript">
$(function(){
		
      	$(".checkAmt").blur(function() {
		  	var amt = parseFloat($(this).attr("value"));
			alert(amt);
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