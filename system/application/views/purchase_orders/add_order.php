<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('purchase_orders/create_order/'.$enquiryDetails[0]['enquiry_id'],$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Create Purchase Order </div>
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
				   <span class="form-control form-control-view"><?php echo $enquiryDetails[0]['firm_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name<span class="required" aria-required="true"> *</span> </label>
					 <span class="form-control form-control-view"><?php echo $enquiryDetails[0]['supl_comp'] ?></span>
				  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Contact Person</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($enquiryDetails[0]['supl_conperson']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Email</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($enquiryDetails[0]['supl_email']); ?></span>
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Phone Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($enquiryDetails[0]['supl_phone']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Mobile Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($enquiryDetails[0]['supl_mobile']); ?></span>
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Phone Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($enquiryDetails[0]['supl_phone']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Mobile Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($enquiryDetails[0]['supl_mobile']); ?></span>
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                   <label class="control-label">Payment Terms</label> 
				  <?php 
						$pay_term = set_value('pay_term');				  
						$data_pay_term = array(
							 'name'         => 'pay_term',
							  'id'          => 'pay_term',
							  'value'       => $pay_term,
							  'class'		=> 'form-control',
							  'maxlength' => '30',
							  'placeholder' => 'Payment Terms'
							 );
				  		echo form_input($data_pay_term); 
				  ?>
				  
                   <span class="help-block help-block-error" for="pay_term" style="color:#F30;"><?php echo form_error('pay_term'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Payment Reminder After</label> 
				  <?php 
						$payment_reminder = set_value('payment_reminder');				  
						$paymentOptions = array('30'=>'30 Days','15'=>'15 Days','45'=>'45 Days','60'=>'60 Days','75'=>'75 Days','0'=>'Advance', '-1'=>'PDC Payment','-2'=>'Part Payment');
						echo form_dropdown('payment_reminder',$paymentOptions,$payment_reminder,'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');
				  ?>
				  
                   <span class="help-block help-block-error" for="payment_reminder" style="color:#F30;"><?php echo form_error('payment_reminder'); ?></span>                   
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                                
				  	 <label class="control-label">TAX Applied <span class="required" aria-required="true"> *</span></label> 
				  <?php 
						$tax_id = set_value('tax_id');				  
						echo form_dropdown('tax_id',$taxList,$tax_id,'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');?>
				  <span class="help-block help-block-error" for="tax_id" style="color:#F30;"><?php echo form_error('tax_id'); ?></span> 
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Excise Applied </label> 
				  <?php 
						$excise = set_value('excise');				  
						echo form_dropdown('excise',$exciseTaxList,$excise,'class="form-control select2me" tabindex="0" placeholder= "Select Excise" required="required"');?>
				  <span class="help-block help-block-error" for="excise" style="color:#F30;"><?php echo form_error('excise'); ?></span>                   
                </div>
              </div>
			 </div>
			 
            <!--/row--> 
			<div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                   <label class="control-label">Transport Name<span class="required" aria-required="true"> *</span></label> 
				 <?php 
						$transport = set_value('transport_name');				  
						echo form_dropdown('transport_name',$transportsList,$transport,'class="form-control select2me" tabindex="0" placeholder= "Select Transport" ');?>
				  <span class="help-block help-block-error" for="transport_name" style="color:#F30;"><?php echo form_error('transport_name'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Delivery Address</label> 
				  <?php 
						$delivery_address = set_value('delivery_address');				  
						$data_delivery_address = array(
							 'name'         => 'delivery_address',
							  'id'          => 'delivery_address',
							  'value'       => $delivery_address,
							  'class'		=> 'form-control',
							  'maxlength' => '100',
							  'placeholder' => 'Delivery Address'
							 );
				  		echo form_input($data_delivery_address); 
				  ?>
				  
                   <span class="help-block help-block-error" for="payment_reminder" style="color:#F30;"><?php echo form_error('delivery_address'); ?></span>                   
                </div>
              </div>
			 </div>
			 <!--/row--> 
			 
			<div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Expected Delivery</label>                  
				  	<?php 
						$expected_delivery = set_value('expected_delivery');				  
						$data_expected_delivery = array(
							 'name'         => 'expected_delivery',
							  'id'          => 'expected_delivery',
							  'value'       => $expected_delivery,
							  'class'		=> 'form-control',
							  'maxlength' => '30',
							  'placeholder' => 'expected_delivery'
							 );
				  		
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-start-date="+0d" data-date-format="yyyy-mm-dd">
					  <?php echo form_input($data_expected_delivery);  ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
                   <span class="help-block help-block-error" for="expected_delivery" style="color:#F30;"><?php echo form_error('expected_delivery'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Order Remark</label>
				  <?php 
						$order_remark = set_value('order_remark');				  
						$data_order_remark = array(
							 'name'         => 'order_remark',
							  'id'          => 'order_remark',
							  'value'       => $order_remark,
							  'class'		=> 'form-control',
							  'cols' => '20',
							  'rows' => '5',
							  'placeholder' => 'Order Remark'
							 );
				  		echo form_textarea($data_order_remark); 
				  ?>
					
                   <span class="help-block help-block-error" for="order_remark" style="color:#F30;"><?php echo form_error('order_remark'); ?></span>                   
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
        <div class="caption"> <i class="fa fa-globe"></i>Manage Enquires Products</div>
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
			    <th width="20%"> Product Name</th>
				<th width="15%"> Reference Name</th>
				<th width="10%"> Rate	</th>
				<th width="10%"> Quantity</th>
				<th width="10%"> Packing Size</th>
				<th width="10%"> Packing</th>
				<th width="25%"> Notes</th>
				<th width="5%"> Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
		  <?php $totalProducts = sizeof($enquiryProducts);?>
           <input type="hidden" class="form-control" id="rownums" name="rownums" value= "<?php echo $totalProducts; ?>" required="required" />
		   <?php 
		    if($totalProducts > 0){
			$i=1;
			foreach($enquiryProducts as $enquiryProduct){  ?>
			<tr class="gradeX short odd" id="tr_<?php echo $i;?>">
				<td width="20%"> 
					<?php echo $enquiryProduct['product_name']?>
				</td>
				<td width="15%"> 
					<input type="text" class="form-control" name="prod_ref_name[]" value= "<?php echo $enquiryProduct['prod_ref_name']?>" id="ref_main_prod" required="required" />
					<input type="hidden" class="form-control" name="pid[]" value= "<?php echo $enquiryProduct['pid']?>" required="required" />
				</td>
				<td width="10%"> <input type="number" min="0" step="any"  class="form-control" name="order_rate[]" value= "<?php echo $enquiryProduct['purc_rate']?>" required="required" /></td>
				<td width="10%"> <input type="number" min="0" step="any"  class="form-control" Placeholder="Ex. 500.00" name="order_qty[]" value= "<?php echo $enquiryProduct['quantity']?>" required="required" /> </td>
				<td width="10%"> <input type="number" min="0" step="any"  class="form-control" Placeholder="Ex. 25" name="packing_size[]" value= "<?php echo $enquiryProduct['packing_size']?>" required="required" /> </td>
				<td width="10%"> <input type="text" class="form-control" Placeholder="Bags, Drums" name="packing[]" value= "<?php echo $enquiryProduct['packing']?>" required="required" /> </td>
				<td width="25%"> <textarea name="notes[]" class="form-control" cols="20" rows="2.5"><?php echo nl2br($enquiryProduct['remark']); ?></textarea></td>
				<td width="5%"><a class="btn default btn-xs red Delete" href="javascript:void(0)" alt="Delete" title="Delete" data_row="<?php echo $i;?>"><i class="fa fa-trash-o"></i></a></td>
			</tr> 
			<?php 
			  $i++;
			   } // EO foreach 
			  } // EO if 
			 ?>
			
			
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<?php if($totalProducts > 0){ ?>
<div class="row">
			  <div class="col-md-12">
				<div class="portlet-body form">
				  <div class="form-actions right">
					<div class="row">
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url()?>purchase_enquires">
						<button type="button" class="btn default">Cancel</button>
						</a> </div>
					  <div class="col-md-6"> </div>
					</div>
				  </div>
				  
				  <!-- END FORM-->
				</div>
			  </div>
			</div>
<?php echo form_close(); 

 } // EO if
?>

<script type="text/javascript">
$(function(){
		
        $(".add_new_row").click(function() {
		     var rownums = $('#rownums').val();
		  	$.ajax({
				url: SITE_URL+"purchase_enquires/add_new_row/",
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
					
		$("#supli_id").change(function() {
		  	var supli_id = $('#supli_id').val();
			$.ajax({
				url: SITE_URL+"purchase_enquires/supplier_info/",
				type:'POST',
				data:{supli_id:supli_id},
				async:false,
				dataType: "json",
				success: function(response){
					var outcome = response.outcome;
					if(outcome == 1){
						var supl_id = response.supl_id; 
						$('#contact_person').html(response.supl_conperson);
						$('#email').html(response.supl_email);
						$('#phone_number').html(response.supl_phone);
						$('#mobile_number').html(response.supl_mobile);
						
					}else{
						alert('Something went wrong with you');
						$('#contact_person').html('');
						$('#email').html('');
						$('#phone_number').html('');
						$('#mobile_number').html('');
					}
					
					
				}
			});	
        });
		
		
    });
</script>