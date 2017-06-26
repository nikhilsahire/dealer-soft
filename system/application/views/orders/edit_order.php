<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>


<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Edit Invoice # <?php echo $orderDetails[0]['invoice_number'] ?></div>
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
		<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('orders/edit/'.$orderDetails[0]['order_id'],$attributes);
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);		  
	   ?>
		
          <div class="form-body">		
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name <span class="required" aria-required="true"> *</span></label>
				  <?php 
						$firm_name = set_value('firm_name');				  
						echo form_dropdown('firm_name',$firmList,$orderDetails[0]['invoice_firm'],'class="form-control select2me" disabled="disabled"  tabindex="0" placeholder= "Select Product" required="required"');?>
				  		
				  
                   <span class="help-block help-block-error" for="firm_name" style="color:#F30;"><?php echo form_error('firm_name'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $orderDetails[0]['comp_name'] ?></span>
                  
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
							  'value'       => $orderDetails[0]['billing_address'],
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
                  	<label class="control-label">Invoice State<span class="required" aria-required="true"> *</span></label>
                  <?php 
				  
				  $state_id = set_value('state_code');
				  echo form_dropdown('state_code',$gst_state_codes,$orderDetails[0]['state_code'],'class="select2me form-control" tabindex="0"');?> 
                  <span class="help-block help-block-error" for="state_code" style="color:#F30;"><?php echo form_error('state_code'); ?></span>
				                  
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
							  'value'       => $orderDetails[0]['contact_person'],
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
						// $payment_reminder = set_value('payment_reminder');				  
						// $paymentOptions = array('30'=>'30 Days','15'=>'15 Days','45'=>'45 Days','60'=>'60 Days','75'=>'75 Days','0'=>'Advance', '-1'=>'PDC Payment','-2'=>'Part Payment');
					//	echo form_dropdown('payment_reminder',$paymentOptions,$orderDetails[0]['payment_reminder'],'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');
					$payment_reminder = set_value('payment_reminder');				  
						$data_payment_reminder = array(
							 'name'         => 'payment_reminder',
							  'id'          => 'payment_reminder',
							  'value'       => $orderDetails[0]['payment_reminder'],
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
            <?php 
			$i = 1; 
			foreach ($orderProducts as $orderProduct){ ?>
			<tr class="gradeX short odd">
				
				<td width="50%"> 
				<?php	echo form_dropdown('pid[]',$products_data,$orderProduct['order_pid'],'class="form-control select2me" tabindex="0" id="ref_main_prod" placeholder= "Select Product" required="required"'); ?>
					
				</td>
				<td width="20%"> <input type="number" min="0" step="any"  class="form-control" Placeholder="Ex. 500.00" name="order_qty[]" value= "<?php echo $orderProduct['order_qty']; ?>" required="required" /> </td>
				<td width="20%"> <input type="number" min="0" step="any"  class="form-control" name="order_rate[]" value= "<?php echo $orderProduct['order_rate']; ?>" required="required" /></td>
				<td width="10%"></td>
			</tr> 
			<?php $i++; } ?>
			<input type="hidden" class="form-control" id="rownums" name="rownums" value= "<?php echo $i-1; ?>" required="required" />
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
		  </div>
		<?php	
			
			echo form_close();
		?>
          
      </div>
    </div>
  </div>
  
</div>



<div class="modal fade" id="delete_prod" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Delete</h4>
        </div>
        <div class="modal-body">
			  Are you sure to delete this product from list?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" id="yes">Yes</button>
        	<button type="button" class="btn default" id="no" data-dismiss="modal">No</button>
        </div>
    </div>
   </div>
</div>
<div id="ajax1">
	<div id="appts_popup" class="modal fade" tabindex="-1" data-width="400">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:closePopup()"></button>
				<h4 class="modal-title" ><b id="popup_title"></b></h4>
			</div>
			<div id="appts-details" class="modal-body row" style="padding:3%;"></div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn" 	onclick="javascript:closePopup()">Close</button>
			</div>
		</div>
	</div>	
	</div>
</div>






<script type="text/javascript">
function delete_product(id) //
{
	$('#delete_prod').modal();
	$('#delete_prod #yes').click(function(){	
		var url = base_url+'orders/del_prod';
		 $.post(url,
		  {
			  id:id
		  },function(responseText){
			  if(responseText == 1){				  
				   location.href = base_url+'orders/edit/<?php echo $orderDetails[0]['order_id'];?>';
			  }else {
			  	alert('Something went wrong with you');
			  }
		  }
		 );
	      
	});
}

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
		
		
	   
	    $("#myform_addprod").submit(function(event) {
		   var url = base_url+'orders/add_order_prod';
		   $.ajax({
           type: "POST",
           url: url,
           data: $("#myform_addprod").serialize(), // serializes the form's elements.
           success: function(data)
           {
               if(data == 1){
			   	location.href = base_url+'orders/edit/<?php echo $orderDetails[0]['order_id'];?>';
			   }else{
			   	$('#error_msg').html(data)
			   }
           }
         });
         event.preventDefault(); // avoid to execute the actual submit of the form 
			  
        });
		
		// fuction for get the order product details
		$('.product_details').click(function () {
   		var prod_row_id = $(this).attr('id');
		$.ajax({
				url: SITE_URL+"orders/order_prod_details/",
				data: { 
					"id": prod_row_id
				}, 
				type:'POST',
				async:false,
				success: function(result){
					$("#popup_title").html("Order Product Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});		
			
    });
    });
</script>