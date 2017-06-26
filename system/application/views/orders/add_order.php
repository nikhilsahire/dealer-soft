<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('orders/add/'.$order_type,$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Create <?php echo ucfirst($order_type) ?> Invoice </div>
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
                  <label class="control-label">Client Name<span class="required" aria-required="true"> *</span> </label>
                 <?php 
						$comp_id = set_value('comp_id');				  
						echo form_dropdown('comp_id',$client_data,$comp_id,'class="form-control select2me" id="comp_id" tabindex="0" placeholder= "Select Product" required="required"');?>				  
                   <span class="help-block help-block-error" for="comp_id" style="color:#F30;"><?php echo form_error('comp_id'); ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Billing Address <span class="required" aria-required="true"> *</span></label>
				  <?php 
						$billing_address = set_value('billing_address');				  
						$data_billing_address = array(
							 'name'         => 'billing_address',
							  'id'          => 'billing_address',
							  'value'       => $billing_address,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'cols' => '20',
							  'rows' => '5',
							  'placeholder' => 'Billing Address'
							 );
				  		echo form_textarea($data_billing_address); 
				  ?>
                   <span class="help-block help-block-error" for="billing_address" style="color:#F30;"><?php echo form_error('billing_address'); ?></span>
                  
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
                  <label class="control-label">Contact Person<span class="required" aria-required="true"> *</span></label>                  
				  	<?php 
						$contact_person = set_value('contact_person');				  
						$data_contact_person = array(
							 'name'         => 'contact_person',
							  'id'          => 'contact_person',
							  'value'       => $contact_person,
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'maxlength' => '30',
							  'placeholder' => 'Contact Person'
							 );
				  		echo form_input($data_contact_person); 
				  ?>
				  
                   <span class="help-block help-block-error" for="contact_person" style="color:#F30;"><?php echo form_error('contact_person'); ?></span>
                  
                </div>
              </div>
			 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Payment Reminder</label> 
				  <?php 
					//	$payment_reminder = set_value('payment_reminder');				  
						// $paymentOptions = array('30'=>'30 Days','15'=>'15 Days','45'=>'45 Days','60'=>'60 Days','75'=>'75 Days','0'=>'Advance', '-1'=>'PDC Payment','-2'=>'Part Payment');
						// echo form_dropdown('payment_reminder',$paymentOptions,$payment_reminder,'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');
					
						$payment_reminder = set_value('payment_reminder');				  
						$data_payment_reminder = array(
							 'name'         => 'payment_reminder',
							  'id'          => 'payment_reminder',
							  'value'       => $payment_reminder,
							  'class'		=> 'form-control',
							  'maxlength' => '30',
							  'placeholder' => 'Payment Reminder'
							 );
				  		
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-start-date="+0d" data-date-format="yyyy-mm-dd">
					  <?php echo form_input($data_payment_reminder);  ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				 
				  
                   <span class="help-block help-block-error" for="payment_reminder" style="color:#F30;"><?php echo form_error('payment_reminder'); ?></span>                   
                </div>
              </div>
			 </div>
			 
			 <!--/row--> 
			<div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">SET Invoice Date</label>                  
				  	<?php 
						$order_date = set_value('order_date');				  
						$data_order_date = array(
							 'name'         => 'order_date',
							  'id'          => 'order_date',
							  'value'       => date('Y-m-d'),
							  'class'		=> 'form-control',
							  'maxlength' => '14',
							  'required'=> 'required',
							  'placeholder' => 'SET Challan/Invoice Date'
							 );
				  		
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d');?>">
					  <?php echo form_input($data_order_date);  ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
                   <span class="help-block help-block-error" for="order_date" style="color:#F30;"><?php echo form_error('order_date'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  	<label class="control-label">Invoice State<span class="required" aria-required="true"> *</span></label>
                  <?php 
				  
				  $state_id = set_value('state_code');
				  echo form_dropdown('state_code',$gst_state_codes,27,'class="select2me form-control" tabindex="0"');?> 
                  <span class="help-block help-block-error" for="state_code" style="color:#F30;"><?php echo form_error('state_code'); ?></span>
				                  
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
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Order Products</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<div class="btn green add_new_row">
												Add New Product <i class="fa fa-plus"></i>
											</div>
										</div>
									</div>
									
								</div>
							</div>
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th width="50%"> Product Name</th>				
				<th width="20%"> Quantity</th>
				<th width="20%"> Rate	</th>
				<th width="10%"> Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
           
			<tr class="gradeX short odd">
				
				<td width="50%"> 
					<?php 
					$pid = set_value('pid');	// prod_ref_name			  
					echo form_dropdown('pid[]',$products_data,$pid,'class="form-control select2me" tabindex="0" id="ref_main_prod" placeholder= "Select Product" required="required"');?>
					<!--<input type="text" class="form-control" name="prod_ref_name[]" value= "" id="ref_main_prod" required="required" />-->
					<input type="hidden" class="form-control" id="rownums" name="rownums" value= "1" required="required" />
				</td>
				<td width="20%"> <input type="number" min="0" step="any"  class="form-control" Placeholder="Ex. 500.00" name="order_qty[]" value= "" required="required" /> </td>
				<td width="20%"> <input type="number" min="0" step="any"  class="form-control" name="order_rate[]" value= "" required="required" /></td>
				<td width="10%"></td>
			</tr> 
			
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>

<div class="row">
			  <div class="col-md-12">
				<div class="portlet-body form">
				  <div class="form-actions right">
					<div class="row">
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url();?>orders/index/<?php echo $order_type?>">
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
		
        $(".add_new_row").click(function() {
		     var rownums = $('#rownums').val();
		  	$.ajax({
				url: SITE_URL+"orders/add_new_row/",
				type:'POST',
				data:{rownums:rownums},
				async:false,
				success: function(result){
					$('#tableBody').append(result);
					rownums = parseInt(rownums)+1;
					$('#rownums').val(rownums);
				}
			});	
        });
		
		$("#main_prod").change(function(){
			 var main_prod = $(this).attr("id");
			 var txt = $("#"+main_prod+" option:selected").text();
			 $("#ref_"+main_prod).val(txt);
		});
					
		$("#comp_id").change(function() {
		  	var comp_id = $('#comp_id').val();
			$.ajax({
				url: SITE_URL+"orders/client_info/",
				type:'POST',
				data:{comp_id:comp_id},
				async:false,
				dataType: "json",
				success: function(response){
					// var outcome = $.parseJSON(response.outcome); 
					var outcome = response.outcome;
					if(outcome == 1){					
						var contact_person =  response.contact_person; // $.parseJSON(response.contact_person); 
						var shipping_address = response.shipping_address; 
						$('#contact_person').val(contact_person);
						$('#shipping_address').val(shipping_address);
						$('#billing_address').val(shipping_address);
					}else{
						alert('Something went wrong with you');
					}
					
					
				}
			});	
        });
		
		
    });
</script>