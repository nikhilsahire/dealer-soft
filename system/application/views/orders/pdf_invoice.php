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
 font-size:12px;
 font-family: Georgia, FontAwesome;
}
tr.border_bottom th {
  border-bottom:1px solid #000000;
  height:25px;
}
tr.border_top td {
  border-top:1px solid #000000;
}
tr.space_bottom td {
   height:18px;
}
</style>
<div class="invoice" style="background-color:#ffffff; ">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
					   <div class="col-xs-12" >
							<strong style="font-weight:bold; font-size:13px"><?php if($orderDetails[0]['order_type'] == 'Tax' ){ echo 'TAX '; }?>INVOICE</strong>
						</div>
						<div class="col-xs-1">
							Logo Here<!--<img src="< ?php echo $this->config->item("base_url_asset")?>assets/admin/layout/img/logo_new.jpg" class="img-responsive" width="50px" alt=""/>-->
						</div>
						<div class="col-xs-7">
						<span style="font-size:30px; font-weight:bold;"><?php  echo $orderDetails[0]['firm_name']; ?>&nbsp;</span><br/>
						<span style="font-size:17px; text-align:center; font-weight:bold;">Your slogan here&nbsp;</span><br/>
						 
						</div>
						<div class="col-xs-2" style="text-align:right; font-size:10px; " >
							<strong style="font-weight:bold;">Mobile:</strong> &nbsp;7276447090<br/>
							<strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> &nbsp;9960490859<br/>
							<strong style="font-weight:bold;">Tel:</strong> (0253) 1234567<br/>
							
						</div>
						<div class="col-xs-12">
						Your address goes here, Nashik-10 <br/>
						<strong style="font-weight:bold;">Email:</strong> youremail@gmail.com
						</div>
					</div>
					
				</div>				
				<div class="row" style=" border:1px solid #000000; margin:10px 0;" >
					<div class="col-xs-6" style="width:60%; float:left; ">
						<!--<h3>Client:</h3>-->
						<ul class="list-unstyled">
							<li>
								 <span style="font-weight:bold;">M/S: <?php echo $orderDetails[0]['contact_person']; ?></span>
							</li>
							<li>
								 <?php 
								 
								 	$shippingAddress = $orderDetails[0]['shipping_address'];
								 echo nl2br($shippingAddress);
								 ?>
								 
							</li>
							<?php if($clientInfo[0]['gstin_num'] != '' ){ ?>
							<li>
								<strong style="font-weight:bold;">GST #:</strong> <?php echo $clientInfo[0]['gstin_num']; ?>
							</li>							
							<?php } ?>
						</ul>
					</div>
					
					<div class="col-xs-4 invoice-payment" style="width: 30%; float:right; font-size:12px; ">
						
						<ul class="list-unstyled">
							<li>
								<strong style="font-weight:bold;">Invoice #:</strong> <?php echo $orderDetails[0]['invoice_number']; ?>
							</li>
							<li>
								<strong style="font-weight:bold;">Invoice Date:</strong> <?php echo date('d M Y',strtotime($orderDetails[0]['order_date'])); ?>
							</li>
							
							<li>
								<strong style="font-weight:bold;">State Code:</strong> <?php echo $orderDetails[0]['state_code']; ?>
							</li>							
							
							 
							
						</ul>
					</div>
				</div>
				
				<div class="row" style="min-height:500px; border:1px solid #000000; margin:20px 0;" >
					<div >
						<table class="table table-striped ">
						
						<tr class="border_bottom">
							
							<th width="20%" style="border-bottom:1px solid #000000">
								&nbsp;Description
							</th>
							<th width="10%" style="border-bottom:1px solid #000000">
								 HSN Code 
							</th>
							<th width="10%" style="border-bottom:1px solid #000000">
								 Quantity
							</th>
							<th width="10%" style="border-bottom:1px solid #000000">
								 Rate
							</th>
							
							<th width="10%" style="border-bottom:1px solid #000000">
								 Tax %
							</th>
							<th width="10%" style="border-bottom:1px solid #000000">
								 SGST
							</th>
							<th width="10%" style="border-bottom:1px solid #000000">
								 CGST
							</th>
							<th width="10%" style="border-bottom:1px solid #000000">
								IGST
							</th>
							<th width="15%" style="border-bottom:1px solid #000000">
								Amount
							</th>
							
						</tr>
						<br/><br/>
						<?php 
						$cnt= 1;
						
						$orderTotal = $discountAmt = $forwardingAmt = 0.00;
						foreach($orderProducts as $product){
						 $prodTotal = 0.00;
						 $prodTotal = $product['order_qty']*$product['order_rate'];
						 $orderTotal +=$prodTotal;
					  ?>
						<tr class="space_bottom" >
							
							<td style="border:none; border-right:1px solid #000000;">&nbsp;<?php echo $product['prod_ref_name'];?></td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;<?php echo $product['hsn_code'];?></td>
							<td style="border:none; border-right:1px solid #000000;" align="right">&nbsp;<?php echo $product['order_qty'].' '.$product['prod_unit'];?></td>
							<td style="border:none; border-right:1px solid #000000;" align="right">&nbsp;<?php echo number_format($product['order_rate'],2); ?></td>
							
							<td style="border:none; border-right:1px solid #000000;" >&nbsp;<?php echo ($product['sgst_per']+$product['cgst_per']+$product['igst_per']); ?></td>
							<td style="border:none; border-right:1px solid #000000;" align="right">&nbsp;<?php  if($product['sgst_per'] > 0) { echo $sgstAmt = number_format((($product['sgst_per']*$prodTotal)/100),2); }else{ echo $sgstAmt = number_format(0.00,2); } ?></td>
							<td style="border:none; border-right:1px solid #000000;" align="right">&nbsp;<?php  if($product['cgst_per'] > 0) { echo $cgstAmt = number_format((($product['cgst_per']*$prodTotal)/100),2); }else{ echo $cgstAmt =  number_format(0.00,2); } ?></td>
							<td style="border:none; border-right:1px solid #000000;" align="right">&nbsp;<?php  if($product['igst_per'] > 0) { echo $igstAmt = number_format((($product['igst_per']*$prodTotal)/100),2); }else{ echo $igstAmt =  number_format(0.00,2); } ?></td>
							 
							<td class="hidden-480" align="right" style="border:none; ">&nbsp;<?php echo number_format($prodTotal,2)?>&nbsp;&nbsp;&nbsp; </td>
							
						</tr>
						
						<?php 
							$cnt++;
							
						} ?>
						
						<?php if($cnt <24 ){ 
							
							
						   for($k=$cnt; $k<=24; $k++){ ?>
						   	<tr>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #000000;">&nbsp;</td>
							<td style="border:none;">&nbsp;</td>
							</tr>
						   
						<?php }
							
						}// EO if ?>
						<tr style="border:solid 0px #ffffff;"><td colspan="9"><br/>&nbsp;</td></tr>
						<tr class="border_top">
							<td colspan="8" align="right" style="font-weight:bold;" >Subtotal&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php echo number_format($orderTotal,2); $subTotal = $orderTotal;?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						
						
						<?php 
						
						
						if($orderDetails[0]['discount'] != 0){?>
						<tr class="space_bottom">
							<td colspan="8" align="right" style="font-weight:bold;">Round Off&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php  $discountAmt = $orderDetails[0]['discount'];
							  echo number_format($orderDetails[0]['discount'],2);
							?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
						
						
					    <tr class="border_top" >
							<td colspan="8" style="border-bottom:1px solid #000000; font-weight:bold;" align="right">Total&nbsp;&nbsp;&nbsp;</td>							
							<td style="border-bottom:1px solid #000000;" id="finalTotal" align="right"><?php 
							$finalTotal = ($orderTotal + $forwardingAmt)-$discountAmt;
							
							echo number_format(round($finalTotal),2);?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr class="space_bottom">
							<td colspan="9" align="left" style=" text-align:left;  margin-bottom:-10px;">
								&nbsp;&nbsp;&nbsp; Rs: <?php  echo ucwords(amountToWards(round($finalTotal))); ?>
							</td>
						</tr>
						</table>
					</div>
				</div>
				
				<?php if($firmDetails[0]['vat_num'] != ""){ ?>
				
				<div class="row" style="border:1px solid #000000; margin:20px 0;">
					<div class="col-xs-12">
						<div class="well123" style="background:#ffffff;">
							
							<span style="font-size:8px;">
							
								<span style="font-weight:bold;">GST TIN No.</span> <?php echo $firmDetails[0]['gst_num']; ?> w.e.f. 01.07.2017<br/> 
								<span style="font-weight:bold;">SERVICE TAX No.</span> <?php echo 'ABCPB551234567'; ?> <br/>
							
							</span>
							
							
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="row" style="border:1px solid #000000; margin:20px 0;">
					<div class="col-xs-7">
						<div class="well123" style="background:#ffffff; text-align:justify;">
							<?php if($orderDetails[0]['order_type'] == 'Tax' ){ ?>
							<span style="font-size:7px;"><span style="font-weight:bold;">Terms & Conditions.</span><br/>
							I/We hearby certify that my registration certificate under the GST Act, 2017 is in force on the date on which the sale of the goods specified in this tax invoice is made by me and that transaction of sale covered by this tax invoice has been effected by me and it shall be accounted for in the turnover of sales while filling of return and the due tax, if any, payble on the sale has been paid or shall be paid.</span><?php }else { echo '<br/>';} ?><br/><br/><br/><br/> SUBJECT TO NASHIK JURISDICTION ONLY					
						</div>
					</div>
					<div class="col-xs-3 invoice-block" style="text-align:right;">
						<div class="well123" style="background:#ffffff;">
							
							<span style="font-weight:bold;">For <?php echo $orderDetails[0]['firm_name']; ?></span><br/><br/><br/><br/><br/>
							 
							<span style="font-weight:bold;">Authorised Signatory</span>
						</div>
						
					</div>
				</div>
			</div>
<!-- END PAGE CONTENT-->