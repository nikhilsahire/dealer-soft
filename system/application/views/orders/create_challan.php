<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>




<?php  
       	$prodBatchAvailable = 'No';
		$attributes = array('class' => '', 'id' => 'myform');
			echo form_open('orders/create_challan/'.$orderDetails[0]['order_id'],$attributes);
				
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
        <div class="caption"> <i class="fa fa-gift"></i>Create Challan For Order # <?php echo $orderDetails[0]['order_number'] ?></div>
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
                  <label class="control-label">Firm Name</label>
                  <span class="form-control form-control-view"><?php echo $orderDetails[0]['firm_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <span class="form-control form-control-view"><?php echo $orderDetails[0]['comp_name'] ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Contact Person</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($orderDetails[0]['contact_person']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Peyment Terms</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['pay_term']; ?></span>
                  
                </div>
              </div>
			 </div>
			<div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">TAX Applied</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['tax_per'].'% '.$orderDetails[0]['tax_type']; ?> </span>
                 
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Excise Applied</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['excise']; ?>%</span>
                  
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">PO Date</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($orderDetails[0]['po_date']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">PO Number</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['po_ref']; ?></span>
                  
                </div>
              </div>
			 </div>
			 <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Billing Adress</label>
                  <span class="form-control form-control-view" style="height:133px !important;"><?php echo nl2br($orderDetails[0]['billing_address']); ?></span>
                  
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Shipping Adress<span class="required" aria-required="true"> *</span></label>
                   
					<?php 
							$shipping_address = set_value('shipping_address');				  
							$data_shipping_address = array(
								 'name'         => 'shipping_address',
								  'id'          => 'shipping_address',
								  'value'       => $orderDetails[0]['shipping_address'],
								  'class'		=> 'form-control',
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
                  <label class="control-label">Order Remark</label>                  
				  	<span class="form-control form-control-view" style="height:133px !important;"><?php echo nl2br($orderDetails[0]['order_remark']); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Logistics Remark</label>   
					  <?php 
							$logistic_remark = set_value('logistic_remark');				  
							$data_logistic_remark = array(
								 'name'         => 'logistic_remark',
								  'id'          => 'logistic_remark',
								  'value'       => $logistic_remark,
								  'class'		=> 'form-control',
								  'cols' => '20',
								  'rows' => '5',
								  'placeholder' => 'Logistic Remark'
								 );
							echo form_textarea($data_logistic_remark); 
					  ?>
					
                   <span class="help-block help-block-error" for="logistic_remark" style="color:#F30;"><?php echo form_error('logistic_remark'); ?></span> 
                </div>
              </div>
			  
			 </div>
            
            <!--/row--> 
          </div>
      </div>
    </div>
  </div>
  
</div>
<?php if(sizeof($pendingProducts) > 0){
		foreach($pendingProducts as $pendingProduct){		
		//echo '<pre>'; print_r(); die();
?>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i><?php echo $pendingProduct['product_name']; ?> (<?php echo number_format(($pendingProduct['order_qty']-$pendingProduct['dispatch_qty']),2);?> <?php echo $pendingProduct['prod_unit'];?> In <?php echo $pendingProduct['order_packing'].' '.$pendingProduct['prod_unit']; ?> Packing)</div>
		<input type="hidden" name="pid[]" id="pid<?php echo $pendingProduct['id'];?>" value="<?php echo $pendingProduct['order_pid'];?>" size="10" />					 
		<input type="hidden" name="usedQnty[]" id="usedQnty_<?php echo $pendingProduct['id'];?>_<?php echo $pendingProduct['order_pid'];?>" value="<?php echo ($pendingProduct['order_qty']-$pendingProduct['dispatch_qty']);?>"  />
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
       <?php if(sizeof($pendingProduct['batches']) > 0){  ?>
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th width="20%">Batch No</th>
				<th width="10%"># Units</th>
				<th width="10%">Qty/Unit</th>
				<th width="10%">Total Quantity</th>
				<th width="15%">Packed&nbsp;In&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				<th width="10%">Action</th>
            </tr>
          </thead>
         
            <?php 
			$lotCnt=0; 
			foreach($pendingProduct['batches'] as $batch){ 
			$prodBatchAvailable = 'Yes';
			?>
			 <tbody id="container_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"];?>">
			<tr >
				<td width="20%"> 
					<?php echo '<b>Lot #'.$batch['lot_no']; ?></b><br/><?php echo $batch['batchStock'].' In '.$batch["packing"].$pendingProduct['prod_unit'].' Packing'; ?>
					   <input type="hidden" name="batchId[]" value="<?php echo $batch["lot_no"];?>"  />
					   <input type="hidden" name="batchStock[]" id="batchStock_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"];?>" value="<?php echo $batch["batchStock"];?>"  />
					   <input type="hidden" name="batchGoingStock[]" id="batchGoingStock_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"];?>" value="0"  />
				</td>
				<td width="10%"> <input type="text"  class="calculate form-control" name="bagNo<?php echo $batch["lot_no"]?>[]" value="0" id="bagNo_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"].$lotCnt;?>" size="8" style="width:70%" />
				 	<input type="hidden" name="reffId<?php echo $batch["lot_no"]?>[]" value="<?php echo $pendingProduct['id'];?>" />
				 </td>
				<td width="10%"> <input type="text"  class="calculate form-control" name="qPbag<?php echo $batch["lot_no"]?>[]" value="<?php echo $batch["packing"] ?>" readonly="readonly" id="qPbag_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"].$lotCnt;?>" size="8" style="width:70%; float:left;" />&nbsp;<?php echo $pendingProduct['prod_unit'];?> </td>
				<td width="10%">  <span id="lotQty_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"].$lotCnt;?>" title="lot#_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"];?>">0</span> &nbsp;<?php echo $pendingProduct['prod_unit'];?> </td>
				<td width="15%"> <input type="text" class="form-control" name="packing<?php echo $batch["lot_no"]?>[]" value="" placeholder="Bags, Drums, Bottle, Box" id="packing_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"].$lotCnt;?>" size="8" style="width:100%" />
				 	
				 </td>
				<td width="10%">  <span style="text-align:center;color:#025B9F; padding-left:28px;" ><a href="javascript:void(0);" name="<?php echo $pendingProduct['order_pid'];?>" tabindex="5000" class="addMore" id="addRowLot_<?php echo $pendingProduct['id'];?>_<?php echo $batch["lot_no"];?>"></a></span> </td>
				
			</tr>
			</tbody>
			<?php 
				$lotCnt++;
			} ?>
          <tr>              
               <td>&nbsp;</td>
			  <td width="25%"><input type="hidden" name="addRow<?php echo $pendingProduct['order_pid'];?>" id="addRow_<?php echo $pendingProduct['id'];?>_<?php echo $pendingProduct['order_pid'];?>" value="<?php echo $lotCnt;?>" size="10" /></td>
			   <td width="25%"><strong>Total</strong></td> 
			   <td width="25%"><strong><span id="prdGrndSum_<?php echo $pendingProduct['id'];?>_<?php echo $pendingProduct['order_pid'];?>">0</span> Kg</strong></td>   
			   <td>&nbsp;</td>
			    <td>&nbsp;</td>       
            </tr>
        </table>
		<?php 
		  
		}?>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>

<?php 
	} // EO foreach
} // EO if lloop  ?>

<?php if($prodBatchAvailable === 'Yes'){ ?>
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
<?php	
		} // EO if loop 	
			echo form_close();
		  ?>
<script type="text/javascript">
$().ready(function(){	
	//$('.calculate').change(function(){
	$(document).on('change', ".calculate", function () {
	var id = $(this).attr("id");
	/*var lotRowdata = id.slice(5);
	alert(lotRowdata);*/
	
	var lotRow = id.slice(5);
	
	var lotRowArray = lotRow.split("_"); 
	//alert(lotRowArray[0]+'==>'+lotRowArray[1]+'===>'+lotRowArray[2]);
	var refNum = lotRowArray[1];
	var bagQty = $('#bagNo'+lotRow).val();	
	var qtyPerBag = $("#qPbag"+lotRow).val();
	//alert(bagQty+'==>'+qtyPerBag); 
	// get lot # and then prodId 
	var getLotNo = $("#lotQty"+lotRow).attr("title");
		getLotNo = getLotNo.slice(4);
		
	var getProdId = $("#addRowLot"+getLotNo).attr("name");
	var rowTotalTemp = $("#lotQty"+lotRow).html();
	
	/// Check batch stock and Batch outgoing
	var batchGoingStockTemp = $("#batchGoingStock"+getLotNo).val();
		batchGoingStockTemp = Number(batchGoingStockTemp)- Number(rowTotalTemp);	
	
	/// Check total Qty and Ordered Qty
	var grandTotalTemp = $("#prdGrndSum_"+refNum+'_'+getProdId).html();
		grandTotalTemp = Number(grandTotalTemp)- Number(rowTotalTemp);
		//alert(grandTotalTemp);
	//var rowTotal = Math.round(bagQty*qtyPerBag);
	var rowTotal = (bagQty*qtyPerBag).toFixed(2);
	
	var batchStock = $("#batchStock"+getLotNo).val();
	var OrderQty = $("#usedQnty_"+refNum+'_'+getProdId).val();
	var batchGoingStock = Number(batchGoingStockTemp)+Number(rowTotal);
	var grandTotal = Number(grandTotalTemp)+Number(rowTotal);
	
		if((grandTotal <= OrderQty) && (batchGoingStock <= batchStock)){
			$("#"+id).css("border-color", " #CCCCCC")
			$("#lotQty"+lotRow).html(rowTotal);	
			$("#prdGrndSum_"+refNum+'_'+getProdId).html(grandTotal);
			$("#batchGoingStock"+getLotNo).val(batchGoingStock);
			$("#createChallan").show();
		}else {
			$("#createChallan").hide();
			if((grandTotal > OrderQty)){
				alert("Outgoing Qty is exceeding ordered Qty.");
				$("#batchGoingStock"+getLotNo).val(0);
				$("#prdGrndSum_"+refNum+'_'+getProdId).html(0.00);
				$("#lotQty"+lotRow).html(0.00);
			}else {
				alert("Batch stock is not enough to fulfill order");
				$("#batchGoingStock"+getLotNo).val(0);
				$("#prdGrndSum_"+refNum+'_'+getProdId).html(0.00);
				$("#lotQty"+lotRow).html(0.00);
			}
			
			$("#"+id).val(0);
			//$("#lotQty"+lotRow).html(0);
			//alert(lotRow);
			$("#"+id).css("border-color", "red")
		}
			
	//bagNo10  qtyPbag10 prdGrndSum
	});
	
	$('.addMore').click(function(){
	var id = $(this).attr("id");
	var lotId = id.slice(9);
	var lotRowArray = lotId.split("_"); 
	//alert(lotRowArray[0]+'==>'+lotRowArray[1]+'===>'+lotRowArray[2]);
	var refNum = lotRowArray[1];
	var prodId = $(this).attr("name");
	var lotCnt = $('#addRow_'+refNum+'_'+prodId).val();
	var lotCnt1 = Number(lotCnt)+1;//Number($(this).val());
	//lotCnt = (lotCnt*100);
	$.post(SITE_URL+"orders/add_new_quantity_row/", {
			lotId: lotId,
			lotCnt : lotCnt,
			lotNum : lotRowArray[2],
			reffNum : lotRowArray[1],
			action: "addQtyRow"
		  },
		  function(data) { 
		  	$('#container'+lotId).append(data);
			//lotCnt = (lotCnt+1);
			$('#addRow_'+refNum+'_'+prodId).val(lotCnt1);
			 //$("#prodRow").val(prodRow);
		  },
		  "text");
		  
	  return false;	
	});
});
</script>