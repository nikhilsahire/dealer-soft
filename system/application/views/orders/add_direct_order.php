<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('orders/add/',$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Create Order </div>
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
                  <label class="control-label">Company Name<span class="required" aria-required="true"> *</span> </label>
                 <?php 
						$comp_id = set_value('comp_id');				  
						echo form_dropdown('comp_id',$client_data,$client_details[0]['comp_id'],'class="form-control select2me" id="comp_id" tabindex="0" placeholder= "Select Product" required="required"');?>
				  		
				  
                   <span class="help-block help-block-error" for="firm_name" style="color:#F30;"><?php echo form_error('comp_id'); ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Billing Adress <span class="required" aria-required="true"> *</span></label>
				  <?php 
						$billing_address = set_value('billing_address');				  
						$data_billing_address = array(
							 'name'         => 'billing_address',
							  'id'          => 'billing_address',
							  'value'       => $client_details[0]['shipping_address'],
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
                    <label class="control-label">Shipping Adress <span class="required" aria-required="true"> *</span></label>
                    <?php 
						$shipping_address = set_value('shipping_address');				  
						$data_shipping_address = array(
							 'name'         => 'shipping_address',
							  'id'          => 'shipping_address',
							  'value'       => $client_details[0]['shipping_address'],
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
							  'value'       => $client_details[0]['primary_contact'],
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
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">PO Date</label>                  
				  	<?php 
						$po_date = set_value('po_date');				  
						$data_po_date = array(
							 'name'         => 'po_date',
							  'id'          => 'po_date',
							  'value'       => $po_date,
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
							  'value'       => $po_ref,
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
            
            <!--/row--> 
			
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
			    <th width="20%"> Product Name</th>
				<th width="15%"> Reference Name</th>
				<th width="10%"> Rate	</th>
				<th width="10%"> Quantity</th>
				<th width="10%"> Packing</th>
				<th width="25%"> Notes</th>
				<th width="10%"> Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
           
			<tr class="gradeX short odd">
				<td width="20%"> 
					<?php 
					$pid = set_value('pid');				  
					echo form_dropdown('pid[]',$products_data,$pid,'class="form-control select2me" tabindex="0" id="main_prod" placeholder= "Select Product" required="required" style="width:200px;"');?>
				</td>
				<td width="15%"> 
					<input type="text" class="form-control" name="prod_ref_name[]" value= "" id="ref_main_prod" required="required" />
					<input type="hidden" class="form-control" id="rownums" name="rownums" value= "1" required="required" />
				</td>
				<td width="10%"> <input type="text" class="form-control" name="order_rate[]" value= "" required="required" /></td>
				<td width="10%"> <input type="text" class="form-control" name="order_qty[]" value= "" required="required" /> </td>
				<td width="10%"> <input type="text" class="form-control" name="packing[]" value= "" required="required" /> </td>
				<td width="25%"> <textarea name="notes[]" class="form-control" cols="20" rows="2.5"></textarea></td>
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
					
		$("#comp_id123").change(function() {
		  	var comp_id = $('#comp_id').val();
			$.ajax({
				url: SITE_URL+"orders/client_info/",
				type:'POST',
				data:{comp_id:comp_id},
				async:false,
				dataType: "json",
				success: function(response){
					var outcome = $.parseJSON(response.outcome); 
					if(outcome == 1){
						var comp_data = $.parseJSON(response.comp_data); 
						alert(comp_data);
						//var shipping_address = $.parseJSON(response.shipping_address); 
						//$('#contact_person').val(contact_person);
						$('#shipping_address').val(comp_data);
						//$('#billing_address').val(shipping_address);
					}else{
						alert('Something went wrong with you');
					}
					
					
				}
			});	
        });
		
		
    });
</script>