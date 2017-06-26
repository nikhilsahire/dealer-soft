<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'child_batch');
			echo form_open_multipart('products/add_packing/'.$batchDetails[0]['lot_no'].'/'.$batchDetails[0]['pid'],$attributes);
			
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
        <div class="caption"> <i class="fa fa-gift"></i>Create Child Batch </div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
	  <?php if(validation_errors()){
	  	 echo validation_errors(); 
	  ?>
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
                  <label class="control-label">Product Name </label>
				   <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['product_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name </label>
                   <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['product_name'] ?></span>
                  <input type="hidden" value="<?php echo $batchDetails[0]['firm_id'] ?>" name="firm_id" id="firm_id" maxlength="10" />
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Batch Number</label>
				  <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['lot_no'] ?></span>           
                  
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Batch Stock </label>
                     <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchStock[0]['instock'] ?></span> 
					 <input type="hidden" value="<?php echo $batchStock[0]['instock'] ?>" name="instock" id="instock" maxlength="10" />
                </div>
              </div>
              <!--/span--> 
            </div>
           
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Packing (<span style="font-size:12px;"></span>)</label>
					<span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['packing'] ?> <?php echo $batchDetails[0]['prod_unit'] ?></span> 
                </div>
              </div>
              <!--/span-->
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Unit Numbers<span class="required" aria-required="true"> *</span></label>
                  <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['bag_no'] ?></span>
                </div>
              </div>
              
              <!--/span--> 
            </div>
			<div class="row">              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Batch Inward Quantity</label>
                    <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['inw_qty'] ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Expiry Date </label>
                      <span class="form-control form-control-view" style="background-color:#EEEEEE"><?php echo $batchDetails[0]['expiry_date'] ?></span>
					 
					 
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
							  'value'       =>  ($batchDetails[0]['batch_desc']),
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
							  'value'       => ($batchDetails[0]['batch_remark'] ),
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

<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Packing Material</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<div class="btn green add_new_packing_row">
												Add Packing Material <i class="fa fa-plus"></i>
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
           
			<?php 
			 
			 
			 if(sizeof($products_used) > 0){
			 
			foreach($products_used as $product_used){ ?>
			<tr class="gradeX odd">
				<td width="15%" ><?php  echo $product_used['product_name']; ?> </td>
				<td width="15%" ><?php  echo $product_used['lot_no']; ?> </td>
				<td width="10%"> <?php  echo $product_used['outw_qty'].' '.$product_used['prod_unit']; ?></td>
				<td width="10%"> </td>
			</tr>
			<?php }	
			   }
			?>
			
			
			<tr class="gradeX short odd">
				<td> 
					<?php 
				  //echo '<pre>'; print_r($packingProducts); die();
				  if(sizeof($packingProducts) > 0){
				  	$packingProducts_array = array(''=>'Select Packing Product');
				  	foreach($packingProducts as $packingProduct){
						$packingProducts_array[$packingProduct['pid']] = $packingProduct['product_name'];
					}
				  }
				  echo form_dropdown('packing_pid[]',$packingProducts_array,'','class="form-control select2me" tabindex="0" placeholder= "Select Packing Product" required="required" id="prod_1"');?>
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
		
        $(".add_new_packing_row").click(function() {
		     var rownums = $('#rownums').val();
		  	$.ajax({
				url: SITE_URL+"products/add_new_packing_row/",
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
		
		$(".calc_weight").change(function(){			
			 var bag_no = $('#bag_no').val();
			 var packing = $('#packing').val();
			
			 if(bag_no !='' && packing != ''){
			  var instock = parseFloat($('#instock').val());
				 
				 var totalQty = parseFloat(parseFloat(bag_no)*parseFloat(packing));
				 if(totalQty <= instock){
					 $('#inw_qty').val(totalQty);
					 $(this).css("border-color", "");
				 }else{
					alert('Inward Quantity is more than Batch Quantity');
					$('#inw_qty').val('');
					$(this).val('');
					$(this).css("border-color", "#D64635");
				 }
			 }
			 
		});
					
		$("#tableBody").on("change",".select2me", function(){
			var prodId = $(this).val();
			var rowIdStr = $(this).attr('id');
			var rowId = rowIdStr.split('_');
			var firmId = $('#firm_id').val(); 
				$.ajax({
				url: SITE_URL+"products/get_product_batches/",
				type:'POST',
				data:{prodId:prodId, rownums:rowId[1], firmId:firmId},
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
			var qtyBatchVal = parseInt($('#batch_value_'+qtyLotNo).val());
			var usedQty  = $(this).val();	
			if(usedQty > qtyBatchVal){
				alert('Using Quantity is more than Batch Quantity');
				$(this).val('');
			    $(this).css("border-color", "#D64635");
			}
			
		});
		
		
		
		
    });
</script>