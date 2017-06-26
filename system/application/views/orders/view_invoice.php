<!-- BEGIN PAGE CONTENT-->
<style>
td {   
    padding: 3px !important;
}
body{
	font-size:11px !important;
}
.well {
	padding:0px;
	margin-bottom:0px;
}
</style>

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
			
			if($orderDetails[0]['order_status'] == 'Completed'){
				$attributes = array('class' => 'horizontal-form', 'id' => 'myform', 'target' => '_blank');
			}
			
			echo form_open_multipart('orders/view_invoice/'.$order_type.'/'.$orderDetails[0]['order_id'],$attributes);
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => 'Confirm Invoice',
								'class' => 'btn green'
			);	
			
			$arr_save = array(
								'name' => 'submit',
								'value' => 'Save Invoice',
								'class' => 'btn green'
			);	
				  
	   ?>
<div class="invoice">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
					   
					   <div class="col-xs-12" >
							<strong style="font-weight:bold; font-size:13px"><?php if($orderDetails[0]['order_type'] == 'Tax' ){ echo 'TAX '; }?>INVOICE</strong>
						</div>
						<div class="col-xs-2">
							<img src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/img/logo_new.jpg" class="img-responsive" width="100" alt=""/>
						</div>
						<div class="col-xs-6">
						<span style="font-size:30px; color:#0077BD; font-weight:bold;"><?php  echo $orderDetails[0]['firm_name']; ?>&nbsp;</span><br/>
						<span style="font-size:13px; text-align:center; color:#0077BD; font-weight:bold;">Company Punchline here&nbsp;</span><br/>
						 
						</div>
						<div class="col-xs-2" style="text-align:right; font-size:10px; " >
							<strong style="font-weight:bold;">Mobile:</strong> &nbsp;7276447090<br/>
							<strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> &nbsp;9960490859<br/>
							<strong style="font-weight:bold;">Tel:</strong> (0253) 2699928<br/>
							
						</div>
						<div class="col-xs-12">
						Your address goes here Your address goes here Your address goes here, Nashik-10  <br/>
						<strong style="font-weight:bold;">Email:</strong> youremail@gmail.com
						</div>
					</div>
					
				</div>
				<hr/>
				<div class="row">
					<div class="col-xs-8">
						<!--<h3>Client:</h3>-->
						<ul class="list-unstyled">
							<li>
								 <strong><?php echo $orderDetails[0]['contact_person']; ?>   </strong>
							</li>
							<li>
								 <?php 
								
								 	$shippingAddress = $orderDetails[0]['shipping_address'];
								 
								 echo nl2br($shippingAddress);
								 ?>
								 
							</li>
							
							<?php if($clientInfo[0]['gstin_num'] != '' ){ ?>
							<li>
								<strong>GST #:</strong> <?php echo $clientInfo[0]['gstin_num']; ?>
							</li>							
							<?php } ?>
						</ul>
					</div>
					
					<div class="col-xs-4 invoice-payment">
						
						<ul class="list-unstyled">
							<li>
								<strong>Invoice #:</strong> <?php echo $orderDetails[0]['invoice_number']; ?>
							</li>
							<li>
								<strong>Invoice Date:</strong> <?php echo date('d M Y',strtotime($orderDetails[0]['order_date'])); ?>
							</li>
							<!--<li>
								<strong>Challan #:</strong> <?php //echo $orderDetails[0]['challan_number']; ?>
							</li>
							<li>
								<strong>Challan Date:</strong> <?php //echo date('d M Y',strtotime($orderDetails[0]['order_date'])); ?>
							</li>-->
							<li>
								<strong>State Code:</strong> <?php echo $orderDetails[0]['state_code']; ?>
							</li>
							
							
						</ul>
					</div>
				</div>
				<div class="row" style="min-height:500px;">
					<div class="col-xs-12">
						<table class="table table-bordered" border="0">
						<thead>
						<tr>
							
							<th width="20%" style="border-bottom:1px solid #DDDDDD">
								 Description 
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 HSN Code 
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 Quantity
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 Rate
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 Tax %
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 SGST 
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 CGST
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								 IGST
							</th>
							<th width="10%" style="border-bottom:1px solid #DDDDDD">
								Amount
							</th>
							
						</tr>
						</thead>
						<tbody>
						<?php 
						$cnt= 1;
						
						$orderTotal = $discountAmt = $forwardingAmt = 0.00;
						foreach($orderProducts as $product){
						 $prodTotal = 0.00;
						 $prodTotal = $product['order_qty']*$product['order_rate'];
						 $orderTotal +=$prodTotal;
						?>
						<tr>
							
							<td ><?php echo $product['prod_ref_name'];?></td>
							<td ><?php echo $product['hsn_code'];?></td>
							<td ><?php echo $product['order_qty'].' '.$product['prod_unit'];?></td>
							<td class="hidden-480" ><?php echo $product['order_rate']; ?></td>
							<td class="hidden-480" ><?php echo ($product['sgst_per']+$product['cgst_per']+$product['igst_per']); ?></td>
							<td class="hidden-480" >
							<?php  if($product['sgst_per'] > 0) { echo $sgstAmt = (($product['sgst_per']*$prodTotal)/100); }else{ echo $sgstAmt = 0.00; } ?></td>
							<td class="hidden-480" >
							<?php  if($product['cgst_per'] > 0) { echo $cgstAmt = (($product['cgst_per']*$prodTotal)/100); }else{ echo $cgstAmt = 0.00; } ?></td>
							<td class="hidden-480" >
							<?php  if($product['igst_per'] > 0) { echo $igstAmt = (($product['igst_per']*$prodTotal)/100); }else{ echo $igstAmt = 0.00; } ?></td>
							<td class="hidden-480" align="right"><?php echo number_format($prodTotal,2)?> </td>
						</tr>
						<?php 
							$cnt++;		
							
						} ?>
						
						
						
						
						
						
						<?php if($cnt <15 ){ 
							
							
						   for($k=$cnt; $k<=15; $k++){ ?>
						   	<tr>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							</tr>
						   
						<?php }
							
						}// EO if ?>
						
						<tr>
							<td colspan="8" align="right">Subtotal</td>							
							<td class="hidden-480" align="right"><?php 
							$subTotal = $orderTotal; 
							echo number_format($orderTotal,2);?> </td>
						</tr>
						
						
						
						<tr>
							<td colspan="8" align="right">Round Off</td>							
							<td class="hidden-480" align="right">
						<?php	
							$discountAmt = $orderDetails[0]['discount'];	
							if($orderDetails[0]['order_status'] == 'Pending'){ 
								$discount = $orderDetails[0]['discount'];
							?>
							<input type="text" name="discountAmt" style="text-align:right" id="discountAmt" value="<?php echo $discount; ?>" class="form-control invoiceCalc" />
							<?php } else { 
							$discount = $orderDetails[0]['discount'];
							echo $orderDetails[0]['discount']; } ?>
							</td>
						</tr>
						
						
						<tr>
							<td colspan="8" align="right">Total</td>							
							<td class="hidden-480" id="finalTotal" align="right" ><?php 
							$finalTotal = ($orderTotal + $forwardingAmt)-$discountAmt;
							
							echo number_format(round($finalTotal),2);?> </td>
						</tr>
						<tr>
							<td colspan="9" align="left" style=" text-align:left;  margin-bottom:-10px;">
								&nbsp;&nbsp;&nbsp; Rs: <?php  echo ucwords(amountToWards(round($finalTotal))); ?>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
				</div>
				<?php //if($firmDetails[0]['vat_num'] != ""){ ?>
				
				<div class="row" style="border:1px solid #000000; margin:20px 0;">
					<div class="col-xs-12">
						<div class="well123" style="background:#ffffff;">
							
							<span style="font-size:8px;">
							
								<span style="font-weight:bold;">GSTin No.</span> <?php echo $firmDetails[0]['gst_num']; ?> w.e.f. 01.07.2017<br/>
								<!--<span style="font-weight:bold;">CST TIN No.</span> < ?php echo $firmDetails[0]['cst_num']; ?> w.e.f. 17.04.2007 <br/>-->
								<span style="font-weight:bold;">SERVICE TAX No.</span> <?php echo 'ABCPB5502FST001'; ?> <br/>
							
							</span>
							
							
						</div>
					</div>
				</div>
				<?php //} ?>
				
				<div class="row" style="border:1px solid #D6D6D6; margin:10px 0;">
					<div class="col-xs-9">
						<div class="well123" style="background:#ffffff; text-align:justify;">
							<?php if($orderDetails[0]['order_type'] == 'Tax' ){ ?>
							<span style="font-size:7px !important;">Terms & Conditions.<br/>
							I/We hearby certify that my registration certificate under the GST Act, 2017 is in force on the date on which the sale of the goods specified in this tax invoice is made by me and that transaction of sale covered by this tax invoice has been effected by me and it shall be accounted for in the turnover of sales while filling of return and the due tax, if any, payble on the sale has been paid or shall be paid. </span>
							<?php } ?>
							<br/><br/> SUBJECT TO NASHIK JURISDICTION ONLY						
						</div>
					</div>
					<div class="col-xs-3 invoice-block" style="text-align:right;">
						<div class="well" style="background:#ffffff;">
							
							<span style="font-weight:bold;">For <?php echo $orderDetails[0]['firm_name']; ?></span><br/><br/><br/><br/>
							
							<span style="font-weight:bold;">Authorised Signatory</span>
						</div>
						
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-4">
						
					</div>
					<div class="col-xs-8 invoice-block" style="text-align:right;">
						
						<!--<a class="btn btn-lg blue hidden-print margin-bottom-5" onClick="javascript:window.print();">
						Print <i class="fa fa-print"></i>
						</a>-->
						 <input name="orderTotal" id="orderTotal" value="<?php echo round($orderTotal); ?>" type="hidden">
						 <input name="finalOrderTotal" id="finalOrderTotal" value="<?php echo round($finalTotal); ?>" type="hidden">
						
						<?php 
						if($orderDetails[0]['order_status'] == 'Pending' ){
							echo form_submit($arr_submit);
							
							//echo form_submit($arr_save);
						}else if($orderDetails[0]['order_status'] == 'Completed'){ ?>
							<input name="submit_challan" value="Print Invoice" class="btn blue hidden-print" type="submit">
						<?php } ?>
						
						
					</div>
				</div>
			</div>

<?php	echo form_close();	?>		

<script type="text/javascript"	>
$(function(){
		
        $(".invoiceCalc").blur(function() {
		     var forwardingAmtVal = discountAmtVal = 0.00;
		     var discountAmt = parseFloat($('#discountAmt').val());
			 var forwardingAmt = parseFloat($('#forwardingAmt').val());
			 var orderTotal = parseFloat($('#orderTotal').val());
			 if(forwardingAmt > 0){
			    forwardingAmtVal = forwardingAmt;
			 }
			 if(discountAmt > 0 && discountAmt < orderTotal ){
			    discountAmtVal = discountAmt;
			 }
			
		  	 var finalOrderTotal = (parseFloat(forwardingAmtVal)+parseFloat(orderTotal))-parseFloat(discountAmtVal);
			 $('#finalTotal').html(finalOrderTotal);
			 $('#finalOrderTotal').val(finalOrderTotal);
			  
        });
		
		
		
		
    });
</script>
			
<!-- END PAGE CONTENT-->