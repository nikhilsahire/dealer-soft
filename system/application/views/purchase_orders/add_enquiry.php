<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('purchase_orders/add/',$attributes);
			
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
						$firm_id = set_value('firm_id');				  
						echo form_dropdown('firm_id',$firmList,$firm_id,'class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required"');?>
				  		
				  
                   <span class="help-block help-block-error" for="firm_name" style="color:#F30;"><?php echo form_error('firm_id'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name<span class="required" aria-required="true"> *</span> </label>
                 <?php 
						$supli_id = set_value('supli_id');				  
						echo form_dropdown('supli_id',$allSuppliers,$supli_id,'class="form-control select2me" id="supli_id" tabindex="0" placeholder= "Select Product" required="required"');?>
				  		
				  
                   <span class="help-block help-block-error" for="firm_name" style="color:#F30;"><?php echo form_error('supli_id'); ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Contact Person</label>
                   <span class="form-control form-control-view" id="contact_person"></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Email</label>
                    <span class="form-control form-control-view" id="email"></span>                
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Phone Number</label>
                   <span class="form-control form-control-view" id="phone_number"></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Mobile Number</label>
                    <span class="form-control form-control-view" id="mobile_number"></span>                
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
			 
            <!--/row--> 
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
        <div class="caption"> <i class="fa fa-globe"></i>Manage Products</div>
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
			    <th width="25%"> Product Name</th>
				<th width="20%"> Rate	</th>
				<th width="20%"> Quantity</th>
				<th width="10%"> SGST %</th> 
				<th width="10%"> CGST %</th> 
				<th width="10%"> IGST %</th> 
				<th width="5%"> Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
           
			<tr class="gradeX short odd">
				<td width="25%"> 
					<?php 
					$pid = set_value('pid');				  
					echo form_dropdown('pid[]',$products,$pid,'class="form-control select2me" tabindex="0" id="main_prod" placeholder= "Select Product" required="required" ');?>
					<input type="hidden" class="form-control" id="rownums" name="rownums" value= "1" required="required" />
				</td>
				
				<td width="20%"> <input type="number" min="0" step="any"  class="form-control" name="order_rate[]" value= "" required="required" /></td>
				<td width="20%"> <input type="number" min="0" step="any"  class="form-control" Placeholder="Ex. 500.00" name="order_qty[]" value= "" required="required" /> </td>
				<td width="10%"> <?php 
					$sgst_per = set_value('sgst_per');				  
					echo form_dropdown('sgst_per[]',$sgstList,$sgst_per,'class="form-control select2me" tabindex="0" id="main_prod" placeholder= "Select SGST %" required="required" ');?> </td>
				<td width="10%">  <?php 
					$cgst_per = set_value('cgst_per');				  
					echo form_dropdown('cgst_per[]',$cgstList,$cgst_per,'class="form-control select2me" tabindex="0" id="main_prod" placeholder= "Select CGST %" required="required" ');?> </td>
				<td width="10%">  <?php 
					$igst_per = set_value('igst_per');				  
					echo form_dropdown('igst_per[]',$igstList,$igst_per,'class="form-control select2me" tabindex="0" id="main_prod" placeholder= "Select IGST %" required="required" ');?> </td>
				<td width="5%"></td>
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
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url() ?>purchase_enquires">
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
				url: SITE_URL+"purchase_orders/add_new_row/",
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
				url: SITE_URL+"purchase_orders/supplier_info/",
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