<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
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
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open_multipart('purchase/purchase_orders/confirm_po/'.base64UrlEncode($purchaseOrderDetails[0]['purc_order_number']).'/'.$purchaseOrderDetails[0]['purc_order_id'],$attributes);
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => 'Confirm PO',
								'class' => 'btn green'
			);	
			
			/*$arr_save = array(
								'name' => 'submit',
								'value' => 'Save Invoice',
								'class' => 'btn green'
			);	*/
				  
	   ?>
<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-xs-6 invoice-logo-space">
						<img src="../../assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
					</div>
					<div class="col-xs-6">
						<p>
							Purchase Order <span class="muted"></span>
						</p>
					</div>
				</div>
				<hr/>
				<div class="row" style="border: 1px solid; margin-bottom: 30px;">
					<div class="col-xs-6" style="border-right: 1px solid;">
						<h3 >Buyer</h3>
						<ul class="list-unstyled">
							<li>
								<strong> M/S: <?php echo $purchaseOrderDetails[0]['firm_name']?></strong>
							</li>
							<li>
								 GAT NO.232, JAULKE VILLAGE,10TH MILE, NASIK-OZAR <br/>
								 ROAD,TAL - DINDORI, DIST - NASIK-422206
							</li>
							<li>
								 Tel:0253- 2571577/2318786
							</li>
							<li>
								 Mobile: 9049494455
							</li>
							<li>
								Mail: purchase@horizonagrotech.com
							</li>
							
						</ul>
					</div>
					<div class="col-xs-6">
						<h3>Supplier</h3>
						<ul class="list-unstyled">
							<li>
								 <strong>M/S: <?php echo $purchaseOrderDetails[0]['supl_comp']?></strong>
							</li>
							<li>
								<?php echo nl2br($purchaseOrderDetails[0]['supl_address']); ?>
							</li>
							
						</ul>
					</div>
					
				</div>
				
				<div class="row" style="border: 1px solid; padding-top: 15px;">
					<div class="col-xs-6" style="border-right: 1px solid;">
						
						<ul class="list-unstyled">
							<li>
								 <strong>Transport: </strong><?php echo $purchaseOrderDetails[0]['transport_name']?>
							</li>
							<li>
								 <strong>Delivery Address: </strong><?php echo $purchaseOrderDetails[0]['delivery_address']?>
							</li>
							<li>
								 <strong>Payment Terms:</strong> <?php echo $purchaseOrderDetails[0]['payment_reminder']?> Days <?php echo $purchaseOrderDetails[0]['pay_term']?>
							</li>
							
							
						</ul>
					</div>
					<div class="col-xs-6">
						<ul class="list-unstyled">
							<li>
								 <strong>Purchase Order No:</strong> <?php echo $purchaseOrderDetails[0]['purc_order_number']?>
							</li>
							<li>
								<strong>Purchase Order Date:</strong> <?php echo date('d M Y',strtotime($purchaseOrderDetails[0]['order_date']))?>
							</li>
							<li>
								 <strong>Delivery Date:</strong> <?php echo date('d M Y',strtotime($purchaseOrderDetails[0]['expected_delivery']))?>
							</li>
							<li>
								<strong>Freight:</strong> -
							</li>
							
						</ul>
					</div>
					
				</div>
				<div class="row" style="border:1px solid; margin-top:30px;">
					<div class="col-xs-12">
						<table class="table table-striped table-hover" >
						<thead>
						<tr>
							<th>
								 #
							</th>
							<th>
								 Product Description
							</th>
							<th class="hidden-480">
								 Quantity
							</th>
							<th class="hidden-480">
								 Rate
							</th>
							<th class="hidden-480">
								 Packing
							</th>
							<th style="text-align:center">
								 Total
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						 $k= 1;
						 $subtotal = $finalTotal = $tax = $excise = $fwdAmt = $discount = $otherAdjustment = 0.00;
						 foreach($purchaseOrderProducts as $orderProduct){ $rowTotal = 0.00; ?>
						<tr>
							<td>
								 <?php echo $k;?>
							</td>
							<td>
								 <?php echo $orderProduct['prod_ref_name'];?>
							</td>
							<td class="hidden-480">
								 <?php echo $orderProduct['purchase_qty'].' '.$orderProduct['prod_unit'];?>
							</td>
							<td class="hidden-480">
								 <?php echo $orderProduct['purchase_rate'];?>
							</td>
							<td class="hidden-480">
								 <?php echo $orderProduct['packing_size'].' '.$orderProduct['prod_unit'].' '.$orderProduct['packing'];?>
							</td>
							<td style="text-align:right">
								 <?php $rowTotal =  ($orderProduct['purchase_qty']*$orderProduct['purchase_rate']);
								       $subtotal += $rowTotal;
									   echo  number_format($rowTotal,2);
								 ?>
							</td>
						</tr>
						<?php } ?>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong>Sub - Total amount:</strong>
							</td>
							<td style="text-align:right">
								 <?php echo number_format($subtotal,2);?>
							</td>
						</tr>
						<?php if( $purchaseOrderDetails[0]['excise'] != 0.00 ){?>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong>Excise: <?php echo $purchaseOrderDetails[0]['excise'] ?>%</strong>
							</td>
							<td style="text-align:right">
								 <?php $excise =  (($subtotal*$purchaseOrderDetails[0]['excise'])/100);
								       $subtotal += $excise;
									   echo  number_format($excise,2);
								 ?>
							</td>
						</tr>
						<?php } ?>
						<?php if( $purchaseOrderDetails[0]['tax_id'] != 0 ){?>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong><?php echo $purchaseOrderDetails[0]['tax_type'].' '.$purchaseOrderDetails[0]['tax_per'].'%' ?>:</strong>
							</td>
							<td style="text-align:right">
								<?php $tax =  (($subtotal*$purchaseOrderDetails[0]['tax_per'])/100);
								       $subtotal += $tax;
									   echo  number_format($tax,2);
								 ?>
							</td>
						</tr>
						<?php } ?>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong>Forwarding Amount:</strong>
							</td>
							<td style="text-align:right">
							<?php if($purchaseOrderDetails[0]['status'] == 'Open'){ ?>
								 <input type="text" name="forwardingAmt" id="forwardingAmt" value="0.00" class="form-control invoiceCalc" style="width:125px; text-align:right;float: right;" />                 
							<?php }else { 
							$fwdAmt = $purchaseOrderDetails[0]['forwardingAmt'] ;
							echo number_format($purchaseOrderDetails[0]['forwardingAmt'],2);  } ?>
							</td>
						</tr>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong>Discount:</strong>
							</td>
							<td style="text-align:right">
							<?php if($purchaseOrderDetails[0]['status'] == 'Open'){ ?> 
								 <input type="text" name="discountAmt" id="discountAmt" value="0.00" class="form-control invoiceCalc" style="width:125px; text-align:right;float: right;"  />                 <?php }else { 
								 $discount = $purchaseOrderDetails[0]['discountAmt']; 
								 echo number_format($purchaseOrderDetails[0]['discountAmt'],2);  } ?>
							</td>
						</tr>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong>Other Charges:</strong>
							</td>
							<td style="text-align:right">
							<?php if($purchaseOrderDetails[0]['status'] == 'Open'){ ?> 
							<input type="text" name="otherAdjustment" id="otherAdjustment" value="0.00" class="form-control invoiceCalc" style="width:125px; text-align:right;float: right;" />                     <?php }else { 
							    $otherAdjustment = $purchaseOrderDetails[0]['otherAdjustment'];
							echo number_format($purchaseOrderDetails[0]['otherAdjustment'],2);  } ?>
							</td>
						</tr>
						<tr>
							
							<td class="hidden-480" colspan="5" style="text-align:right;">
								<strong>Total:</strong>
							</td>
							<td style="text-align:right" id="finalTotal">
								 <?php  $finalTotal = round((($subtotal+$fwdAmt + $otherAdjustment)-$discount));
								 		echo number_format($finalTotal,2);
								  ?>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
					
					<div class="col-xs-12 invoice-block" style="border-top:1px solid; font-weight:bold; text-align:left; padding:10px;">
						<!--Rs: Twelve Thousand Four Hundred Eight Nine Only-->
					</div>
				</div>
				
				<div class="row" style="border: 1px solid; margin-top: 30px;">
					<div class="col-xs-8">
						<div class="well" style="background:#ffffff;">
							<address>
							<strong style="font-size:10px">Subject to Nashik Jurisdiction.</strong><br/>
							VAT TIN No. <?php echo $firmDetails[0]['vat_num'] ?> w.e.f. 30.03.2008<br/>
							CST TIN No. <?php echo $firmDetails[0]['cst_num'] ?> w.e.f. 30.03.2008<br/>
							<span  style="font-size:10px">Received goods in good conditions.</span>
							</address>
							<address>
							<strong>Terms and Conditions</strong><br/>
							<span style="font-size:10px"> 	
								1. Please send COA (Certificate Of Analysis) along with material. For <?php echo $firmDetails[0]['firm_name'] ?><br/>
								2. Please mention our PO No. & Date on your INVOICE COPY.<br/>
								3. Material will be accepted after QC approval.<br/>
								4. Our quality control analysis would be final and binding and rebate will be deducted accordingly.<br/>
								5. Payment will be made as per actual quantity / quality at our end.<br/>
								6. Rejected goods should taken back within 8 days from information.<br/>
							</span>	
								<strong>Note: Kindly attached consinee copy along with material</strong>
							</address>
						</div>
					</div>
					<div class="col-xs-4 invoice-block" style="text-align:right;">
					<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						<br/>
						
						<ul class="list-unstyled amounts">
							<input name="orderTotal" id="orderTotal" value="<?php echo $subtotal; ?>" type="hidden">
						 	<input name="finalOrderTotal" id="finalOrderTotal" value="<?php echo $finalTotal; ?>" type="hidden">
							<li>
								<strong>For <?php echo $firmDetails[0]['firm_name'] ?></strong> <br/><br/><br/><br/><br/>
							</li>
							
							<li>
								<strong>Authorised Signatory</strong>
							</li>
						</ul>
						
						
					</div>
				</div>
				<div class="row" style="margin-top: 10px; text-align:right;">
					<div class="col-xs-12">
				
						
						
						<?php 
						if($purchaseOrderDetails[0]['status'] == 'Open'){  
							echo form_submit($arr_submit); 
						}else { ?>
						<a class="btn btn-primary red hidden-print" onClick="javascript:window.print();">
						Print <i class="fa fa-print"></i></a>&nbsp;
						
						<input type="submit" name="submit" value="Downlaod PO" class="btn blue hidden-print" >
						<?php } ?>
				</div>
			  </div>
			</div>

<?php	echo form_close();	?>		

<script type="text/javascript"	>
$(function(){
		
        $(".invoiceCalc").blur(function() {
		     var forwardingAmtVal = discountAmtVal = otherAdjustment = 0.00;
		     var discountAmt = parseFloat($('#discountAmt').val());
			 var forwardingAmt = parseFloat($('#forwardingAmt').val());
			 var orderTotal = parseFloat($('#orderTotal').val());
			 var otherAdjustment = parseFloat($('#otherAdjustment').val());
			 if(forwardingAmt > 0){
			    forwardingAmtVal = forwardingAmt;
			 }
			 if(otherAdjustment > 0){
			    otherAdjustment = otherAdjustment;
			 }
			 if(discountAmt > 0 && discountAmt < orderTotal ){
			    discountAmtVal = discountAmt;
			 }
			
		  	 var finalOrderTotal = (parseFloat(forwardingAmtVal)+parseFloat(orderTotal)+parseFloat(otherAdjustment))-parseFloat(discountAmtVal);
			 $('#finalTotal').html(finalOrderTotal);
			 $('#finalOrderTotal').val(finalOrderTotal);
			  
        });
		
		
		
		
    });
</script>
			
<!-- END PAGE CONTENT-->