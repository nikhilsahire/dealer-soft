<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>

<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Products Of <?php echo $purchaseOrderDetails[0]['purc_order_number'] ?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
	  
	
      <div class="portlet-body">
	 	<?php if(isset($_SESSION['suc_msg'])){ ?> 
	 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
	  <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?>
	</div>
	<?php } ?>
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
			    <th width="20%"> Product Name</th>
				<th width="11%"> Rate	</th>
				<th width="11%"> Quantity</th>
				<th width="10%"> SGST %</th>
				<th width="10%"> CGST %</th>
				<th width="10%"> IGST %</th>				
				<th width="12%"> Total Inword</th>
				<th width="5%"> Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
		  <?php $totalProducts = sizeof($purchaseOrderProducts);?>
           <input type="hidden" class="form-control" id="rownums" name="rownums" value= "<?php echo $totalProducts; ?>" required="required" />
		   <?php 
		    if($totalProducts > 0){
			$i=1;
			foreach($purchaseOrderProducts as $purchaseProduct){  ?>
			<tr class="gradeX short odd" id="tr_<?php echo $i;?>">
				<td width="20%"> 
					<?php echo $purchaseProduct['product_name'];?>
					
				</td>
				
				<td width="11%"><?php echo $purchaseProduct['purchase_rate']?></td>
				<td width="11%"><?php echo $purchaseProduct['purchase_qty'].' '.$purchaseProduct['prod_unit']?> </td>
				<td width="10%"> <?php echo $purchaseProduct['sgst_per'].' %'?></td>
				<td width="10%"> <?php echo $purchaseProduct['cgst_per'].' %'?></td>
				<td width="10%"> <?php echo $purchaseProduct['igst_per'].' %'?></td>
				<td width="12%"> <?php echo $purchaseProduct['total_inword'].' '.$purchaseProduct['prod_unit']?></td>
				<td width="5%"><a href="javascript:void(0);" id="<?php echo $purchaseProduct['id'];?>" class="btn default btn-xs purple product_details" title="View" alt="View"><i class="fa fa-eye"></i></a>
					<?php if($purchaseProduct['total_inword'] == 0.00 ){ ?>
					<a class="btn default btn-xs red" href="javascript:void(0);" onclick="delete_product(<?php echo $purchaseProduct['id'];?>)" alt="Delete" title="Delete"><i class="fa fa-trash-o"></i></a>
					<?php } ?>
					  </td>
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
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Edit Purchase Order # <?php echo $purchaseOrderDetails[0]['purc_order_number'] ?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
	  
	
        <!-- BEGIN FORM-->
		<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('purchase_orders/edit/'.$purchaseOrderDetails[0]['purc_order_id'],$attributes);
			
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
                  <label class="control-label">Firm Name</label>
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['firm_name'] ?></span>
                </div>
              </div>
              <!--/span-->	
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name</label>
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['supl_comp'] ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Contact Person</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_conperson']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Email</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_email']); ?></span>
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Phone Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_phone']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Mobile Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_mobile']); ?></span>
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
							  'value'       => $purchaseOrderDetails[0]['pay_term'],
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
						echo form_dropdown('payment_reminder',$paymentOptions,$purchaseOrderDetails[0]['payment_reminder'],'class="form-control select2me" tabindex="0" placeholder= "Select Tax" required="required"');
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
							  'value'       => $purchaseOrderDetails[0]['order_remark'],
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
            <div class="row">
			  <div class="col-md-12">
				<div class="portlet-body form">
				  <div class="form-actions right">
					<div class="row">
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo $this->config->item('base_url_purchase')?>purchase_enquires">
						<button type="button" class="btn default">Cancel</button>
						</a> </div>
					  <div class="col-md-6"> </div>
					</div>
				  </div>
				  
				  <!-- END FORM-->
				</div>
			  </div>
			</div>
            <!--/row--> 
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
        <h4 class="modal-title">Add Product</h4>
      </div>
      <div class="modal-body">
        <input type="hidden"  name="purc_order_id" value="<?php echo $purchaseOrderDetails[0]['purc_order_id'];?>" />
        
        <div class="form-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Product Name<span class="required" aria-required="true"> *</span></label>
                
				<?php 
				  
				  echo form_dropdown('pid',$products_data,'','class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required"');?>
                   <span class="help-block help-block-error" for="order_pid" style="color:#F30;"><?php echo form_error('order_pid'); ?></span>
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
                <label class="control-label">SGST % <span class="required" aria-required="true"> *</span></label>
                <?php 
				  
				  echo form_dropdown('sgst_per',$sgstList,'','class="form-control select2me" tabindex="0" placeholder= "Select SGST" required="required"');?>
                   <span class="help-block help-block-error" for="sgst_per" style="color:#F30;"><?php echo form_error('sgst_per'); ?></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">CGST %<span class="required" aria-required="true"> *</span></label>
				
               <?php 
				  
				  echo form_dropdown('cgst_per',$cgstList,'','class="form-control select2me" tabindex="0" placeholder= "Select CGST" required="required"');?>
                   
				<span class="help-block help-block-error" for="cgst_per" style="color:#F30;"><?php echo form_error('cgst_per'); ?></span>
				</div>
            </div>			
            
          </div>
		  
		  <div class="row">
            
			<div class="col-md-6">
              <div class="form-group">
                <label class="control-label">IGST % </label>
                <?php 
				  
				  echo form_dropdown('igst_per',$igstList,'','class="form-control select2me" tabindex="0" placeholder= "Select IGST" required="required"');?>
                   
				<span class="help-block help-block-error" for="igst_per" style="color:#F30;"><?php echo form_error('igst_per'); ?></span>
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
		var url = base_url+'purchase_orders/remove_prod';
		 $.post(url,
		  {
			  id:id
		  },function(responseText){
			  if(responseText == 1){				  
				   location.href = base_url+'purchase_orders/edit/<?php echo $purchaseOrderDetails[0]['purc_order_id'];?>';
			  }else {
			  	alert('Something went wrong with you');
			  }
		  }
		 );
	      
	});
	
	
}

$(function(){
		
        $("#myform_addprod").submit(function(event) {
		   //alert($("#myform_addprod").serialize());
		   var url = base_url+'purchase_orders/add_purchase_prod';
		   $.ajax({
           type: "POST",
           url: url,
           data: $("#myform_addprod").serialize(), // serializes the form's elements.
           success: function(data)
           {
               if(data == 1){
			   	location.href = base_url+'purchase_orders/edit/<?php echo $purchaseOrderDetails[0]['purc_order_id'];?>';
			   }else{
			   	$('#error_msg').html(data)
			   }
           }
         });
         event.preventDefault(); // avoid to execute the actual submit of the form 
			  
        });
		
		// fuction for get the order product details
		$('.product_details').click(function () {
		 var enq_row_id = $(this).attr('id');
		 $.ajax({
				url: SITE_URL+"purchase_orders/enquiry_prod_details/",
				data: { 
					"id": enq_row_id
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