<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN GLOBAL MANDATORY STYLES 

<link href="<?php //echo $this->config->item("global_url")?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php //echo $this->config->item("global_url")?>plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>-->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo $this->config->item("global_url")?>css/components.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>

<style>
 hr{
 	margin: 5px 0 !important;
 }
 body {
 background-color:#ffffff;
 font-size:11px;
}
tr.border_bottom th {
  border-bottom:1px solid #D6D6D6;
  height:25px;
}
tr.border_top td {
  border-top:1px solid #D6D6D6;
  height:25px;
}
tr.space_bottom td {
   height:18px;
   vertical-align:top;
}
</style>
<div class="invoice" style="background-color:#ffffff; ">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
						<div class="col-xs-12" style="text-align:center; font-size:40px; color:#0077BD; font-weight:bold;">
						<!--<img src="http://alligoagrovet.com/alligo-soft/images/horizon-agrotech-logo.jpg" class="img-responsive" alt=""/>-->
						<?php echo $firmDetails[0]['firm_name']; ?>
						</div>
						<div class="col-xs-12">
						<p>
							&nbsp; Off.: Gat No. 232, Jaulke Village, 10th Mile, Nasik - Ozar Road, Tal. Dindori, Dist. Nashik.
						</p>
					</div>
					</div>
					
				</div>				
				<div class="row" style=" border:1px solid #D6D6D6; margin:10px 0;" >
					<div class="col-xs-5" style="width:42%; float:left; ">
						<span style=" font-size:13px;" >Buyer</span>
						<ul class="list-unstyled">
							<li>
								 <span style="font-weight:bold;">M/S: <?php echo $firmDetails[0]['firm_name']?></span>
							</li>
							<li>
								 GAT NO.232, Jaulke Village,10th Mile, Nashik-Ozar <br/>
								 Road, Tal - Dindori, Dist - Nashik-422206
							</li>
							<li>
								 Tel:0253- 2318788/98
							</li>
							<li>
								 Mobile: 9049494455
							</li>
							<li>
								Mail: purchase@horizonagrotech.com
							</li>
						</ul>
					</div>
					
					<div class="col-xs-5 invoice-payment" style="width: 48%; float:right; font-size:10px; ">
						
						<span style=" font-size:13px;" >Supplier</span>
						<ul class="list-unstyled">
							<li>
								 <strong style="font-weight:bold;" >M/S: <?php echo $purchaseOrderDetails[0]['supl_comp']?></strong>
							</li>
							<li>
								<?php echo nl2br($purchaseOrderDetails[0]['supl_address']); ?>
							</li>
							<li>
								 <strong>GSTin #:</strong> <?php echo $purchaseOrderDetails[0]['gstin_num']?>
							</li>
							
							
						</ul>
					</div>
				</div>
				<div class="row" style="min-height:500px; border:1px solid #D6D6D6; margin:10px 0;">
					<div class="col-xs-5" style="border-right: 1px solid #D6D6D6 ;">
						
						<ul class="list-unstyled">
							
							<li>
								 <strong style="font-weight:bold;">Payment Terms:</strong> <?php echo $purchaseOrderDetails[0]['pay_term']?>
							</li>
							
							
						</ul>
					</div>
					<div class="col-xs-5">
						<ul class="list-unstyled">
							<li>
								 <strong style="font-weight:bold;">Purchase Order No:</strong> <?php echo $purchaseOrderDetails[0]['purc_order_number']?>
							</li>
							<li>
								<strong style="font-weight:bold;">Purchase Order Date:</strong> <?php echo date('d M Y',strtotime($purchaseOrderDetails[0]['order_date']))?>
							</li>
							
							
							
						</ul>
					</div>
					
				</div>
				<div class="row" style="min-height:500px; border:1px solid #D6D6D6; margin:10px 0;" >
					<div >
						<table class="table table-striped ">
						
						<tr class="border_bottom">
													
							<th width="20%" style="border-bottom:1px solid #DDDDDD">
								 Product Description
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
							
							<th width="15%" style="border-bottom:1px solid #DDDDDD; text-align:right">
								Total&nbsp;&nbsp;&nbsp;
							</th>
							
						</tr>
						<br/><br/>
						<?php 
						 $cnt= 1;
						 $subtotal = $finalTotal = $tax = $excise = $fwdAmt = $discount = $otherAdjustment = 0.00;
						 foreach($purchaseOrderProducts as $orderProduct){ 
						 	$rowTotal = 0.00; 
							$rowTotal =  ($orderProduct['purchase_qty']*$orderProduct['purchase_rate']);
						 
						  ?>
						<tr class="space_bottom">
							
							<td>
								 <?php echo $orderProduct['product_name'];?>
							</td>
							<td>
								 <?php echo $orderProduct['hsn_code'];?>
							</td>
							<td class="hidden-480">
								 <?php echo $orderProduct['purchase_qty'].' '.$orderProduct['prod_unit'];?>
							</td>
							<td class="hidden-480">
								 <?php echo $orderProduct['purchase_rate'];?>
							</td>
							<td class="hidden-480">
								 <?php echo $orderProduct['sgst_per']+$orderProduct['cgst_per']+$orderProduct['igst_per'].'%';?>
							</td>
							<td class="hidden-480">
								  <?php 
								 $sgstAmt = (($orderProduct['sgst_per']* $rowTotal)/100);
								 echo number_format($sgstAmt,2);?>
							</td>
							<td class="hidden-480">
								 <?php 
								 $cgstAmt = (($orderProduct['cgst_per']* $rowTotal)/100);
								 echo number_format($cgstAmt,2);?>
							</td>
							<td class="hidden-480">
								 <?php 
								 $igstAmt = (($orderProduct['igst_per']* $rowTotal)/100);
								 echo number_format($igstAmt,2);?>
							</td>
							
							<td style="text-align:right">
								 <?php 
								       $rowTotal = $rowTotal+$sgstAmt+$cgstAmt+$igstAmt;
									   $subtotal = $subtotal+$rowTotal;
									   echo  number_format($rowTotal,2);
								 ?>&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
						<?php 
							$cnt++;
						} ?>
						
						<?php 
							for($k=$cnt; $k<=12; $k++){ ?>
							<tr style="border:solid 0px #ffffff;"><td colspan="7"><br/>&nbsp;</td></tr>
							
						 <?php	} ?>
						<tr style="border:solid 0px #ffffff;"><td colspan="7"><br/>&nbsp;</td></tr>
						<tr class="border_top">
							<td colspan="8" align="right" style="font-weight:bold;" >Subtotal:&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php 
							 
							echo number_format($subtotal,2);?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						
						
						
						<tr class="space_bottom">
							<td colspan="8" align="right" style="font-weight:bold;">Forwarding Charges:&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php  
							$fwdAmt = $purchaseOrderDetails[0]['forwardingAmt'] ;
							echo number_format($purchaseOrderDetails[0]['forwardingAmt'],2);   ?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
											
						<tr class="space_bottom">
							<td colspan="8" align="right" style="font-weight:bold;">Other Charges:&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right"><?php 
							    $otherAdjustment = $purchaseOrderDetails[0]['otherAdjustment'];
							echo number_format($purchaseOrderDetails[0]['otherAdjustment'],2);  ?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
					
						
					    <tr class="space_bottom" >
							<td colspan="8" style="border-bottom:1px solid #D6D6D6; font-weight:bold;" align="right">Total:&nbsp;&nbsp;&nbsp;</td>							
							<td style="border-bottom:1px solid #D6D6D6;" id="finalTotal" align="right">
							<?php  $finalTotal = round((($subtotal+$fwdAmt + $otherAdjustment)-$discount));
								 		echo number_format($finalTotal,2);
								  ?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr class="space_bottom">
							<td colspan="9" align="left" style=" text-align:left;  margin-bottom:-10px;">
								&nbsp;&nbsp;&nbsp; Rs: <?php  echo ucwords(amountToWards(round($finalTotal))); ?>
							</td>
						</tr>
						</table>
					</div>
				</div>
				
				<div class="row" style="border:1px solid #D6D6D6; margin:10px 0;">
					<div class="col-xs-7">
						<div class="well123" style="background:#ffffff;">
							<br/>
							<span style="font-size:8px;">
							<span style="font-weight:bold;">GST TIN No.<?php echo $firmDetails[0]['gst_num'] ?> w.e.f. 01.07.2017<br/>
								
							</span>
							<br/>
							
						</div>
					</div>
					<div class="" >
						<div style="background:#ffffff;width:100%;">
							
						</div>
						
					</div>
					
				</div>
				<div class="row" style="border:1px solid #D6D6D6; margin:10px 0;"><br/>
					<div class="col-xs-7">
						<div class="well123" style="background:#ffffff; text-align:justify;">							
							<span style="font-size:7px; font-weight:bold;">Terms & Conditions</span>.<br/>
							<span style="font-size:7px;">	1. Please send COA (Certificate Of Analysis) along with material. For <?php echo $firmDetails[0]['firm_name'] ?><br/>
								2. Please mention our PO No. & Date on your INVOICE COPY.<br/>
								3. Material will be accepted after QC approval.<br/>
								4. Our quality control analysis would be final and binding and rebate will be deducted accordingly.<br/>
								5. Payment will be made as per actual quantity / quality at our end.<br/>
								6. Rejected goods should taken back within 8 days from information.<br/>
								<strong style="font-weight:bold;">Note: Kindly attached consinee copy along with material</strong>
								</span>							
						</div>
					</div>
					<div class="col-xs-3 invoice-block" style="text-align:right;">
						<div class="well123" style="background:#ffffff;">
							
							<span style="font-weight:bold;">For <?php echo $firmDetails[0]['firm_name'] ?></span><br/><br/><br/><br/><br/>
							
							<span style="font-weight:bold;">Authorised Signatory</span>
						</div>
						
					</div>
				</div>
			</div>
<!-- END PAGE CONTENT-->