<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
       	$prodBatchAvailable = 'No';
		$attributes = array('class' => '', 'id' => 'myform');
			echo form_open('purchase_orders/create_prn/'.$purchaseOrderDetails[0]['purc_order_id'],$attributes);
				
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
        <div class="caption"> <i class="fa fa-gift"></i>Create Inword Challan For Order # <?php echo $purchaseOrderDetails[0]['purc_order_number']; ?></div>
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
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['firm_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['supl_comp'] ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            
            
			
			 
			 
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Order Remark</label>                  
				  	<span class="form-control form-control-view" style="height:133px !important;"><?php echo nl2br($purchaseOrderDetails[0]['order_remark']); ?></span>
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
				   <label class="control-label">Invoice Number*</label>      
                  	
					<?php 
						$invoice_num = set_value('invoice_num');				  
						$data_invoice_num = array(
							 'name'         => 'invoice_num',
							  'id'          => 'invoice_num',
							  'value'       => $invoice_num,
							  'class'		=> 'form-control',
							  'required'		=> 'required',
							  'maxlength' => '30',
							  'placeholder' => 'Invoice Number'
							 );
				  		echo form_input($data_invoice_num); 
				  ?>
				  
                   <span class="help-block help-block-error" for="invoice_num" style="color:#F30;"><?php echo form_error('invoice_num'); ?></span>
                </div>
              </div>
			  
			 </div>
            
            <!--/row--> 
          </div>
      </div>
    </div>
  </div>
  
</div>
<?php if(sizeof($pendingOrderProducts) > 0){
		$lotCnt=0;
		foreach($pendingOrderProducts as $pendingProduct){		
		//echo '<pre>'; print_r(); die();
		if(round($pendingProduct['total_inword'],2) < round($pendingProduct['purchase_qty'],2)){
?>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i><?php echo $pendingProduct['product_name']; ?> (<?php echo number_format($pendingProduct['purchase_qty'],2);?> <?php echo $pendingProduct['prod_unit'];?>) Pending Qty: <?php echo ($pendingProduct['purchase_qty']-$pendingProduct['total_inword']);?><?php echo $pendingProduct['prod_unit'];?></div>
		<input type="hidden" name="pid[]" id="pid<?php echo $pendingProduct['id'];?>" value="<?php echo $pendingProduct['purchase_pid'];?>" size="10" />					 
		<input type="hidden" name="usedQnty[]" id="usedQnty_<?php echo $pendingProduct['id'];?>_<?php echo $pendingProduct['purchase_pid'];?>" value="<?php echo ($pendingProduct['purchase_qty']-$pendingProduct['total_inword']);?>"  />
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
       
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    
				
				<th>Inward Unit </th>
				<th >Total Quantity</th>				
				<th >Comment</th>
				<th >Action</th>
            </tr>
          </thead>
         
            
			 <tbody id="container_<?php echo $pendingProduct['id'];?>">
			<tr >
			
				<td width="20%"> 
				<input type="hidden"  class="calculate form-control" name="bagNo[]" value="1" id="bagNo_<?php echo $pendingProduct['id'];?>_<?php echo $lotCnt;?>" size="8" style="width:70%" />
				 	<input type="hidden" name="rowPid[]" value="<?php echo $pendingProduct['purchase_pid'];?>" size="10" />	
					<input type="hidden" name="prod_ref_id[]" value="<?php echo $pendingProduct['id'];?>" size="10" />
				<input type="text"  class="calculate form-control" name="qPbag[]" value=""  id="qPbag_<?php echo $pendingProduct['id'];?>_<?php echo $lotCnt;?>" size="8" style="width:70%; float:left;" />&nbsp;<?php echo $pendingProduct['prod_unit'];?> </td>
				<td width="15%">  <span id="lotQty_<?php echo $pendingProduct['id'];?>_<?php echo $lotCnt;?>" title="lot#_<?php echo $pendingProduct['id'];?>">0</span> &nbsp;<?php echo $pendingProduct['prod_unit'];?> </td>
				
				
				<td width="20%"> <textarea class="form-control" name="comment[]" cols="10" rows="1" style="width: 201px; height:34px;"></textarea>
				 	
				 </td>
				<td width="10%">  <span><a href="javascript:void(0);" name="<?php echo $pendingProduct['purchase_pid'];?>" tabindex="5000" class="addMore" id="addRowLot_<?php echo $pendingProduct['id'];?>"></a></span> </td>
				
			</tr>
			</tbody>
			
          <tr>              
              
			  
			   <td width="20%">
			   <input type="hidden" name="addRow<?php echo $pendingProduct['purchase_pid'];?>" id="addRow_<?php echo $pendingProduct['id'];?>_<?php echo $pendingProduct['purchase_pid'];?>" value="<?php echo $lotCnt;?>" size="10" />
			   <strong>Total</strong></td> 
			   <td width="15%"><strong><span id="prdGrndSum_<?php echo $pendingProduct['id'];?>_<?php echo $pendingProduct['purchase_pid'];?>">0.00</span> <?php echo $pendingProduct['prod_unit'];?></strong></td>   
			   <td  width="45%" colspan="3" class="short"></td>
            </tr>
        </table>
		
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>

<?php
      } // EO if 
	} // EO foreach
} // EO if lloop  ?>


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
	
			echo form_close();
		  ?>
<script type="text/javascript">
$().ready(function(){	
	//$('.calculate').change(function(){
	$(document).on('change', ".calculate", function () {
	var id = $(this).attr("id");
	var lotRowdata = id.slice(5);
	
	
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
	// Check pending stock 
	var batchPendingStockTemp = $("#usedQnty"+getLotNo+"_"+getProdId).val();
		batchPendingStockTemp = Number(batchPendingStockTemp);//- Number(rowTotalTemp);	
	/// Check total Qty and Ordered Qty
	var grandTotalTemp = $("#prdGrndSum_"+refNum+'_'+getProdId).html();
	    grandTotalTemp = Number(grandTotalTemp)- Number(rowTotalTemp);
		
	//var rowTotal = Math.round(bagQty*qtyPerBag);
	var rowTotal = (bagQty*qtyPerBag).toFixed(2);
	var grandTotal = Number(grandTotalTemp)+Number(rowTotal);
	
	if((grandTotal <= batchPendingStockTemp)){
			$("#"+id).css("border-color", " #CCCCCC")
			$("#lotQty"+lotRow).html(rowTotal);	
			$("#prdGrndSum_"+refNum+'_'+getProdId).html(grandTotal);
			$("#batchGoingStock"+getLotNo).val(batchGoingStock);
			$("#createChallan").show();
		}else {
			$("#createChallan").hide();			
			alert("Inword Qty is exceeding pending Qty.");
			$("#batchGoingStock"+getLotNo).val(0);
			$("#prdGrndSum_"+refNum+'_'+getProdId).html(grandTotalTemp);
			$("#lotQty"+lotRow).html(0.00);		
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
	// alert(refNum);
	//lotCnt = (lotCnt*100);
	$.post(SITE_URL+"stores/purchase_orders/add_new_quantity_row/", {
			lotId: lotId,
			lotCnt : lotCnt1,
			lotNum : lotRowArray[2],
			reffNum : lotRowArray[1],
			prId : prodId,
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