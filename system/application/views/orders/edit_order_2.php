<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>

<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Order Products # <?php echo $orderDetails[0]['order_number'] ?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											 <a href="#add_prod" data-toggle="modal">
												 <button id="sample_editable_1_new" class="btn green">
												Add New Product <i class="fa fa-plus"></i>
												</button>
											</a>
										</div>
									</div>
									
								</div>
							</div>
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th>Product Name</th>
				<th> Order Rate	</th>
				<th> Order Qty</th>
				<th> Packing</th>
				<th> Dispatched</th>
				<th> Balance</th>
				<th> Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orderProducts as $orderProduct){
			
			  $class = 'success';
			  if(($orderProduct['order_qty'] - $orderProduct['dispatch_qty']) > 0){
			  
			  	$class = 'danger';
			  }
			  ?>
			<tr class="<?php echo $class; ?>">
				<td> <?php echo $orderProduct['prod_ref_name']; ?></td>
				<td> <?php echo number_format($orderProduct['order_rate'],2); ?> </td>
				<td> <?php echo number_format($orderProduct['order_qty'],2).' '. $orderProduct['prod_unit']; ?> </td>
				<td> <?php echo $orderProduct['order_packing']; ?> </td>
				<td> <?php echo number_format($orderProduct['dispatch_qty'],2).' '. $orderProduct['prod_unit']; ?> </td>
				<td> <?php echo number_format(($orderProduct['order_qty'] - $orderProduct['dispatch_qty']),2).' '. $orderProduct['prod_unit']; ?> </td>
				<td> 
				
					<a href="javascript:void();" id="<?php echo $orderProduct['id'];?>" class="btn default btn-xs purple product_details" title="View" alt="View"><i class="fa fa-eye"></i></a>
					<?php if($orderProduct['dispatch_qty'] === '0.00'){ ?>
					<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_product(<?php echo $orderProduct['id'];?>)" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
					<?php } ?>
				 </td>
			</tr>
			<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Edit Order # <?php echo $orderDetails[0]['order_number'] ?></div>
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
						echo form_dropdown('firm_name',$firmList,$orderDetails[0]['firm_name'],'class="form-control select2me" disabled="disabled"  tabindex="0" placeholder= "Select Product" required="required"');?>
				  		
				  
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
                    <label class="control-label">Shipping Address <span class="required" aria-required="true"> *</span></label>
                    <?php 
						$shipping_address = set_value('shipping_address');				  
						$data_shipping_address = array(
							 'name'         => 'shipping_address',
							  'id'          => 'shipping_address',
							  'value'       => $orderDetails[0]['shipping_address'],
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
							  'cols' => '20',
							  'rows' => '5',
							  'placeholder' => 'Shipping Address'
							 );
				  		echo form_textarea($data_shipping_address); 
				  ?>
					
                   <span class="help-block help-block-error" for="shipping_address" style="color:#F30;"><?php echo form_error('shipping_address'); ?></span>  
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
							  'value'       => $orderDetails[0]['pay_term'],
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
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">TAX Applied <span class="required" aria-required="true"> *</span></label> 
				  <?php 
						$tax_id = set_value('tax_id');				  
						echo form_dropdown('tax_id',$taxList,$orderDetails[0]['tax_id'],'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');?>
				  <span class="help-block help-block-error" for="tax_id" style="color:#F30;"><?php echo form_error('tax_id'); ?></span>                   
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Excise Applied </label> 
				  <?php 
						$excise = set_value('excise');				  
						echo form_dropdown('excise',$exciseTaxList,$orderDetails[0]['excise'],'class="form-control select2me" tabindex="0" placeholder= "Select Excise" required="required"');?>
				  <span class="help-block help-block-error" for="excise" style="color:#F30;"><?php echo form_error('excise'); ?></span>                   
                </div>
              </div>
			 </div>
			 
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">PO Date</label>                  
				  	<?php 
						$po_date = set_value('po_date');				  
						$data_po_date = array(
							 'name'         => 'po_date',
							  'id'          => 'po_date',
							  'value'       => $orderDetails[0]['po_date'],
							  'class'		=> 'form-control',
							  'maxlength' => '30',
							  'placeholder' => 'PO Date'
							 );
				  		
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-end-date="+0d" data-date-format="yyyy-mm-dd">
					  <?php echo form_input($data_po_date);  ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
                   <span class="help-block help-block-error" for="po_date" style="color:#F30;"><?php echo form_error('po_date'); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">PO Number</label> 
				  <?php 
						$po_ref = set_value('po_ref');				  
						$data_po_ref = array(
							 'name'         => 'po_ref',
							  'id'          => 'po_ref',
							  'value'       => $orderDetails[0]['po_ref'],
							  'class'		=> 'form-control',
							  'maxlength' => '30',
							  'placeholder' => 'PO Number'
							 );
				  		echo form_input($data_po_ref); 
				  ?>
				  
                   <span class="help-block help-block-error" for="po_ref" style="color:#F30;"><?php echo form_error('po_ref'); ?></span>                   
                </div>
              </div>
			 </div>
			 
			 
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Order Remark</label>
				  <?php 
						$order_remark = set_value('order_remark');				  
						$data_order_remark = array(
							 'name'         => 'order_remark',
							  'id'          => 'order_remark',
							  'value'       => ($orderDetails[0]['order_remark']),
							  'class'		=> 'form-control',
							  'required' 	=> 'required',
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
            
            <!--/row--> 
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

<div class="modal fade" id="add_prod" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="row">
	 	 <div class="col-md-12 col-sm-12">
		 	<div class="alert alert-danger" id="error_msg">
			</div>
		 </div>
	 </div>
	 <form action="#" class="horizontal-form" id="myform_addprod" method="post" >
	 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Add Order Product</h4>
      </div>
      <div class="modal-body">
        <input type="hidden"  name="order_id" value="<?php echo $orderDetails[0]['order_id'];?>" />
        
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Product Name<span class="required" aria-required="true"> *</span></label>
                
				<?php 
				  
				  echo form_dropdown('order_pid',$products_data,'','class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required"');?>
                   <span class="help-block help-block-error" for="order_pid" style="color:#F30;"><?php echo form_error('order_pid'); ?></span>
				</div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Reference Name <span class="required" aria-required="true"> *</span></label>
                <?php 
			  $prod_ref_name = set_value('prod_ref_name');				  
			  $data_ref_name = array(
						  		 'name'         => 'prod_ref_name',
								  'id'          => 'prod_ref_name',
								  'value'       => $prod_ref_name,
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder' => 'Product Reference Name'
								 );
		    
				
				echo form_input($data_ref_name); ?>
                   <span class="help-block help-block-error" for="prod_ref_name" style="color:#F30;"><?php echo form_error('prod_ref_name'); ?></span>
              </div>
            </div>
          </div>
		  <div class="row">
		    <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Quantity <span class="required" aria-required="true"> *</span></label>
                <?php 
			  $order_qty = set_value('order_qty');				  
			  $data_order_qty = array(
						  		 'name'         => 'order_qty',
								  'id'          => 'order_qty',
								  'value'       => $order_qty,
								  'required'		=> 'required',
								  'class'		=> 'form-control',
								  'placeholder' => 'Order Quantity'
								 );
		    
				
				echo form_input($data_order_qty); ?>
                   <span class="help-block help-block-error" for="order_qty" style="color:#F30;"><?php echo form_error('order_qty'); ?></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Rate<span class="required" aria-required="true"> *</span></label>
				
                <?php 
			  $order_rate = set_value('order_rate');				  
			  $data_order_rate = array(
						  		 'name'         => 'order_rate',
								  'id'          => 'order_rate',
								  'value'       => $order_rate,
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder' => 'Product Rate'
								 );
		    
				
				echo form_input($data_order_rate); ?>
                   
				<span class="help-block help-block-error" for="order_rate" style="color:#F30;"><?php echo form_error('order_rate'); ?></span>
				</div>
            </div>			
            
          </div>
		  
		  <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Packing <span class="required" aria-required="true"> *</span></label>
                <?php 
			  $order_packing = set_value('order_packing');				  
			  $data_order_packing = array(
						  		 'name'         => 'order_packing',
								  'id'          => 'order_packing',
								  'value'       => $order_packing,
								  'class'		=> 'form-control',
								  'required'		=> 'required',
								  'placeholder' => 'Order Packing',
								 );
		    
				echo form_input($data_order_packing); ?> 
				<span class="help-block help-block-error" for="order_packing" style="color:#F30;"><?php echo form_error('order_packing'); ?></span>
				</div>
            </div>
			<div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Notes </label>
                <?php 
			  $notes = set_value('notes');				  
			  $data_order_notes = array(
						  		 'name'         => 'notes',
								  'id'          => 'notes',
								  'value'       => $notes,
								  'class'		=> 'form-control',
								  'cols' => '20',
							  	  'rows' => '5',
								  'placeholder' => 'Order Notes',
								 );
		    
				echo form_textarea($data_order_notes); ?> 
				<span class="help-block help-block-error" for="notes" style="color:#F30;"><?php echo form_error('notes'); ?></span>
				</div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn green" value="Add" name="submit" id="mysubmit"/>
      </div>
    
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
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