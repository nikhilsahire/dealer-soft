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
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
						<div class="col-xs-12" style="text-align:center; font-size:40px; color:#0077BD; font-weight:bold;">
						<!--<img src="http://alligoagrovet.com/alligo-soft/images/horizon-agrotech-logo.jpg" class="img-responsive" alt=""/>-->
						<?php echo $purchaseOrderDetails[0]['firm_name']; ?>
						</div>
						<div class="col-xs-12">
						<p>
							 Off.: Gat No. 232, Jaulke Village, 10th Mile, Nasik - Ozar Road, Tal. Dindori, Dist. Nashik.
						</p>
					</div>
					</div>
					
				</div>
				<hr/>
				<div class="row">
					<div class="col-xs-8">
						<!--<h3>Client:</h3>-->
						<ul class="list-unstyled">
							<li>
								 <strong>M/S: <?php echo $purchaseOrderDetails[0]['comp_name']; ?></strong>
							</li>
							<li>
								 <?php 
								 if(trim($challanShippingDetails[0]['shipping_address']) != ''){
								 	$shippingAddress = $challanShippingDetails[0]['shipping_address'];
								 }else {
								 	$shippingAddress = $challanDetails[0]['shipping_address'];
								 }
								 echo nl2br($shippingAddress);
								 ?>
								 
							</li>
							<li>
								<strong>VAT #:</strong> <?php echo $challanDetails[0]['vat_no']; ?>
							</li>
							<li>
								<strong>CST #:</strong> <?php echo $challanDetails[0]['cst_no']; ?>
							</li>
						</ul>
					</div>
					
					<div class="col-xs-4 invoice-payment">
						
						<ul class="list-unstyled">
							<li>
								<strong>Invoice #:</strong> <?php echo $challanDetails[0]['invoice_no']; ?>
							</li>
							<li>
								<strong>Invoice Date:</strong> <?php echo date('d M Y',strtotime($challanDetails[0]['invoice_date'])); ?>
							</li>
							<li>
								<strong>Challan #:</strong> <?php echo $challanDetails[0]['challan_no']; ?>
							</li>
							<li>
								<strong>Challan Date:</strong> <?php echo date('d M Y',strtotime($challanDetails[0]['chalan_date'])); ?>
							</li>
							<li>
								<strong>PO #:</strong> <?php echo $challanDetails[0]['po_ref']; ?>
							</li>
							
							<li>
								<strong>Transport:</strong> <?php echo $challanShippingDetails[0]['transport']; ?>								
							</li> 
						</ul>
					</div>
				</div>
				<div class="row" style="min-height:500px;">
					<div class="col-xs-12">
						<table class="table table-bordered" border="0">
						<thead>
						<tr>
							
							<th width="25%" style="border-bottom:1px solid #DDDDDD">
								 Description 
							</th>
							<th width="13%" style="border-bottom:1px solid #DDDDDD">
								 Batch
							</th>
							<th width="12%" style="border-bottom:1px solid #DDDDDD">
								 MFG Date
							</th>
							<th width="15%" style="border-bottom:1px solid #DDDDDD">
								 Packing
							</th>
							<th width="13%" style="border-bottom:1px solid #DDDDDD">
								 Quantity
							</th>
							<th width="9%" style="border-bottom:1px solid #DDDDDD">
								 Rate
							</th>
							<th width="12%" style="border-bottom:1px solid #DDDDDD">
								Amount
							</th>
							
						</tr>
						</thead>
						<tbody>
						<?php 
						$cnt= 1;
						$prodId =0;
						$orderTotal = $discountAmt = $forwardingAmt = 0.00;
						foreach($challanProducts as $product){
						 $prodTotal = 0.00;
						 $prodTotal = ($product['qty_per_bag']*$product['no_bags'])*$product['order_rate'];
						 $orderTotal +=$prodTotal;
						?>
						<tr >
							
							<td style="border:none;"><?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'].' ('.$product['item_code'].')' : '';?></td>
							<td style="border:none;"><?php echo $product['lot_no'];?></td>
							<td style="border:none;"><?php echo $product['lot_no'];?></td>
							<td style="border:none;"><?php echo $product['qty_per_bag'].' '.$product['prod_unit'].' X '.$product['no_bags'].' '.$product['packing_units'];?></td>
							<td class="hidden-480" style="border:none;"><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							<td class="hidden-480" style="border:none;"><?php echo $product['order_rate']; ?>
							</td>
							<td class="hidden-480" style="border:none;"><?php echo number_format($prodTotal,2)?> </td>
							
						</tr>
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?>
						
						<?php if($cnt <10 ){ 
						   for($k=$cnt; $k<=10; $k++){ ?>
						   	<tr><td colspan="7" style="border:none;">&nbsp;</td></tr>
						   
						<?php }
						}// EO if ?>
						
						<tr>
							<td colspan="6" align="right">Subtotal</td>							
							<td class="hidden-480" ><?php echo number_format($orderTotal,2);?> </td>
						</tr>
						<?php if($orderDetails[0]['tax_per'] !=0.00){?>
						<tr>
							<td colspan="6" align="right"><?php echo $orderDetails[0]['tax_type'].'-'.$orderDetails[0]['tax_per'].'%';?></td>							
							<td class="hidden-480" ><?php $tax =  ($orderDetails[0]['tax_per']*$orderTotal)/100; 
							  $orderTotal += $tax;
							  echo number_format($tax,2);
							?> </td>
						</tr>
						<?php } ?>
						<?php if($orderDetails[0]['excise'] !=0.00){?>
						<tr>
							<td colspan="6" align="right"><?php echo 'Excise - '.$orderDetails[0]['excise'].'%';?></td>							
							<td class="hidden-480" ><?php $exciseTax = ($orderDetails[0]['excise']*$orderTotal)/100; 
							$orderTotal += $exciseTax;
							 echo number_format($exciseTax,2);
							?> </td>
						</tr>
						<?php } ?>
						
						<tr>
							<td colspan="6" align="right">Forwarding Charges</td>							
							<td class="hidden-480" >
						<?php	if($challanShippingDetails[0]['account_confirmed'] == '0'){ ?>
							<input type="text" name="forwardingAmt" id="forwardingAmt" value="0.00" class="form-control invoiceCalc" />
							<?php } else { 
							$forwardingAmt = $challanShippingDetails[0]['forwardingAmt'];
							echo $challanShippingDetails[0]['forwardingAmt']; } ?>
							</td>
						</tr>
						<tr>
							<td colspan="6" align="right">Discount</td>							
							<td class="hidden-480" >
							<?php	if($challanShippingDetails[0]['account_confirmed'] == '0'){ ?>
							<input type="text" name="discountAmt" id="discountAmt" value="0.00" class="form-control invoiceCalc" />
							<?php } else { 
							$discountAmt = $challanShippingDetails[0]['discountAmt'];
							echo $challanShippingDetails[0]['discountAmt']; } ?>
							</td>
						</tr>
						
						<tr>
							<td colspan="6" align="right">Total</td>							
							<td class="hidden-480" id="finalTotal" ><?php 
							$finalTotal = ($orderTotal + $forwardingAmt)-$discountAmt;
							
							echo number_format(round($finalTotal),2);?> </td>
						</tr>
						</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="well" style="background:#ffffff;">
							<address>
							<strong style="font-size:10px">Subject to Nashik Jurisdiction.</strong><br/>
							VAT TIN No. <?php echo $challanDetails[0]['vat_num']; ?> w.e.f. 30.03.2008<br/>
							CST TIN No. <?php echo $challanDetails[0]['cst_num']; ?> w.e.f. 30.03.2008<br/>
							<span  style="font-size:10px">Received goods in good conditions.</span>
							</address>
							<address>
							<strong>RECEIVED BY</strong><br/>
							
							</address>
						</div>
					</div>
					<div class="col-xs-8 invoice-block" style="text-align:right;">
						<ul class="list-unstyled amounts">
							<li>
								<strong>For <?php echo $challanDetails[0]['firm_name']; ?></strong> <br/><br/><br/><br/><br/>
							</li>
							
							<li>
								<strong>Authorised Signatory</strong>
							</li>
						</ul>
						<br/>
						<!--<a class="btn btn-lg blue hidden-print margin-bottom-5" onClick="javascript:window.print();">
						Print <i class="fa fa-print"></i>
						</a>-->
						 <input name="orderTotal" id="orderTotal" value="<?php echo round($orderTotal); ?>" type="hidden">
						 <input name="finalOrderTotal" id="finalOrderTotal" value="<?php echo round($finalTotal); ?>" type="hidden">
						<input name="submit_challan" value="Downlaod Invoice" class="btn blue hidden-print" type="submit">
						<?php 
						if($challanShippingDetails[0]['account_confirmed'] == '0' && ($this->session->userdata('userrole') == 'Admin' || $this->session->userdata('userrole') == 'Accounts') ){
							echo form_submit($arr_submit);
							
							//echo form_submit($arr_save);
						}else if( $challanShippingDetails[0]['account_confirmed'] == '0' || ($this->session->userdata('userrole') == 'Purchase')){
							echo form_submit($arr_save);
						}
						?>
						
						
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