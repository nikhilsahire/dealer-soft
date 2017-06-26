<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'child_batch');
			echo form_open_multipart('formulated/formulated_stock/'.$product_id,$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Add Formulated Product's Stock </div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
	  <?php if(validation_errors()){  ?>
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
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name<span class="required" aria-required="true"> *</span></label>
					<?php 
				  $invoice_firm = set_value('invoice_firm');
				  $invoice_firm_array  = array(''=>'Select Firm','1'=>'Horizon Agrotech', '2'=> 'Animal Health','3'=>'Ganesh Enterprises');
				  echo form_dropdown('invoice_firm',$firmList,$firmId,'class="form-control" id="invoice_firm" tabindex="0" required="required"');?>
				  
                   <span class="help-block help-block-error" for="invoice_firm" style="color:#F30;"><?php echo form_error('invoice_firm'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Name</label>
				  <span class="form-control form-control-view"><?php echo ($product_name); ?></span>                  
                </div>
              </div>
              <!--/span--> 
            </div>
           
            <div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Formulated Quantity<span class="required" aria-required="true"> *</span></label>
                  <?php 
						$inw_qty  = set_value('inw_qty');				  
						$data_inw_qty  = array(
							 'name'         => 'inw_qty',
							  'id'          => 'inw_qty',
							  'value'       => $inw_qty ,
							  'class'		=> 'form-control',
							  'maxlength' => '15',
							  'required' 	=> 'required',
							  'placeholder' => 'Product Weight'
							 );
				  		echo form_input($data_inw_qty); 
				  ?>
                   <span class="help-block help-block-error" for="inw_qty" style="color:#F30;"><?php echo form_error('inw_qty'); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                
              </div>
              <!--/span-->
              <!--/span--> 
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Manufacturing Date</label>
					<?php 
						$manufacturing_date = set_value('manufacturing_date');				  
						$data_manufacturing_date = array(
											 'name'         => 'manufacturing_date',
											  'id'          => 'manufacturing_date',
											  'value'       => $manufacturing_date,
											  'class'		=> 'form-control',
											  'readonly' 	=> 'readonly',
											  'maxlength' => '12',
											  'placeholder' => 'Manufacturing Date'
											 );
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-end-date="+0d" data-date-format="mm-yyyy" data-date-viewmode="years" data-date-minviewmode="months">
					  <?php echo form_input($data_manufacturing_date); ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				  
                   <span class="help-block help-block-error" for="manufacturing_date" style="color:#F30;"><?php echo form_error('manufacturing_date'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Expiry Date</label>
					<?php 
						$expiry_date = set_value('expiry_date');				  
						$data_expiry_date = array(
											 'name'         => 'expiry_date',
											  'id'          => 'expiry_date',
											  'value'       => $expiry_date,
											  'class'		=> 'form-control',
											  'readonly' 	=> 'readonly',
											  'maxlength' => '12',
											  'placeholder' => 'Expiry Date'
											 );
				  ?>
				  <div class="input-group input-medium date date-picker" data-date-start-date="+0d" data-date-format="mm-yyyy" data-date-viewmode="years" data-date-minviewmode="months">
					  <?php echo form_input($data_expiry_date); ?>
					  <span class="input-group-btn">
					  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					</div>
				  
                   <span class="help-block help-block-error" for="expiry_date" style="color:#F30;"><?php echo form_error('expiry_date'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			
			
            <!--/row--> 
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Batch Description<span class="required" aria-required="true"> *</span></label>
					<?php 
						$batch_desc = set_value('batch_desc');				  
						$data_batch_desc = array(
							 'name'         => 'batch_desc',
							  'id'          => 'batch_desc',
							  'value'       =>  $batch_desc,
							  'class'		=> 'form-control',
							  'rows'        => '4',
						      'cols'        => '10',
							  'required' 	=> 'required',
							  'placeholder' => 'Batch Description'
							 );
				  		echo form_textarea($data_batch_desc,$batch_desc); 
				  ?>
				  
                   <span class="help-block help-block-error" for="batch_desc" style="color:#F30;"><?php echo form_error('batch_desc'); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Batch Remark</label>
                  <?php 
						$batch_remark  = set_value('batch_remark');				  
						$data_batch_remark = array(
							 'name'         => 'batch_remark',
							  'id'          => 'batch_remark',
							  'value'       => ($batch_remark ),
							  'class'		=> 'form-control',
							  'rows'        => '4',
						  	  'cols'        => '10',
							  'placeholder' => 'Batch Remark'
							 );
				  		echo form_textarea($data_batch_remark,$batch_remark); 
				  ?>
                   <span class="help-block help-block-error" for="batch_remark" style="color:#F30;"><?php echo form_error('batch_remark'); ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
		  </div>
		
          
      </div>
    </div>
  </div>
  
</div>
<?php if(sizeof($allChildProductsList) > 0){
		
		//echo '<pre>'; print_r($childProduct); die();
?>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Child Products</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<div class="btn green add_new_packing_row">
												Add Material <i class="fa fa-plus"></i>
											</div>
										</div>
									</div>
									
								</div>
							</div>
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th width="50%"> Product Name</th>
				<th width="20%"> Batch #</th>
				<th width="20%"> Quantity</th>
				<th width="10%"> Remove</th>
            </tr>
          </thead>
          <tbody id="tableBody">
           
			<tr class="gradeX short odd">
				<td> 
					<?php 
				  //echo '<pre>'; print_r($packingProducts); die();
				 
				  	$packingProducts_array = array(''=>'Select Product');
				  	foreach($allChildProductsList as $childProduct){
						$packingProducts_array[$childProduct['child_pid']] = $childProduct['product_name'];
					}
				  
				  echo form_dropdown('formulated_pid[]',$packingProducts_array,'','class="form-control select2me" tabindex="0" placeholder= "Select Product" required="required" id="prod_1"');?>
                   <span class="help-block help-block-error" for="order_pid" style="color:#F30;"><?php echo form_error('order_pid'); ?></span>
				   <input type="hidden" class="form-control" id="rownums" name="rownums" value= "1" required="required" />
				   <input type="hidden" class="form-control" id="batch_value_1" name="batch_value[]" value= ""  />
				</td>
				<td width="15%" id="td_1">&nbsp; </td>
				
				<td width="10%"> <input type="text" class="form-control used_qty" name="used_qty[]" value= "" required="required" id="used_qty_1" /> </td>
				<td width="10%"> </td>
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
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?>  </div>
					  <div class="col-md-6"> </div>
					</div>
				  </div>
				  
				  <!-- END FORM-->
				</div>
			  </div>
			</div>
<?php } // EO if lloop  ?>




<?php echo form_close(); ?>

<script type="text/javascript">
$(function(){
		
        $(".add_new_packing_row").click(function() {
		     var rownums = $('#rownums').val();
		  	$.ajax({
				url: SITE_URL+"formulated/add_new_formulated_row/<?php echo $product_id;?>",
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
		
		
					
		$("#tableBody").on("change",".select2me", function(){
			var prodId = $(this).val();
			var rowIdStr = $(this).attr('id');
			var rowId = rowIdStr.split('_');
			var firm_id = $('#invoice_firm').val();
			//alert(prodId);
				$.ajax({
				url: SITE_URL+"formulated/get_child_product_batches/",
				type:'POST',
				data:{prodId:prodId, rownums:rowId[1], firmId:firm_id,},
				async:false,
				success: function(result){				  	
					$('#td_'+rowId[1]).html(result);
					$('#used_qty_'+rowId[1]).val('');
					$('#batch_value_'+rowId[1]).val('');
				}
			});
		});
		
		$("#tableBody").on("click",".Delete", function(){
		 	var data_row = $(this).attr("data_row");			
			$("#tr_"+data_row).remove();
		});
		
		$("#tableBody").on("change",".lot_nums", function(){
		 	var dataId = $(this).attr('id');
			var saw = '#'+dataId;
			var dataCnt = ($('#'+dataId+' option:selected').attr('data-cnt'));	
			var lotNo = dataId.substr(9);
			$('#batch_value_'+lotNo).val(dataCnt);
			// batch_value_1, lot_nums_1
		});
		
		$("#tableBody").on("change",".used_qty", function(){
		 	var qtyId = $(this).attr('id');	
			$(this).css("border-color", "");
			var qtyLotNo = qtyId.substr(9);
			var qtyBatchVal = parseFloat($('#batch_value_'+qtyLotNo).val());
			var usedQty  = $(this).val();	
			if(usedQty > qtyBatchVal){
				alert('Using Quantity is more than Batch Quantity');
				$(this).val('');
			    $(this).css("border-color", "#D64635");
			}
			
		});
		
		// function for checking the child products qty
		$(".chdProds").on("change",".calculate_stock", function(){
			
		 	var usedQtyId = $(this).attr('id');	
			$(this).css("border-color", "");			
			var prodLotNo = usedQtyId.substr(9);
			var prodBatchVal = parseFloat($('#batchStock_'+prodLotNo).val());
			var usedQty  = $(this).val();	
			if(usedQty > prodBatchVal){
				alert('Used Quantity is more than Batch Quantity');
				$(this).val('');
			    $(this).css("border-color", "#D64635");
			}
			
		});
		
		// reload the page based on selected firm so that we can select firm
		$("#invoice_firm").on("change","", function(){
			
		 	var invoiceFirm = $(this).val();
			window.location.href=SITE_URL+'formulated/formulated_stock/'+<?php echo $product_id; ?>+'/'+invoiceFirm; 
			
		});
		
		
		
    });
</script>