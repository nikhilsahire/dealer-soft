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
  height:18px;
}
tr.space_bottom td {
   height:18px;
}
</style>
<div class="invoice" style="background-color:#ffffff; ">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
						<div class="col-xs-12" style="text-align:center; font-size:40px; color:#0077BD; font-weight:bold;">
						<!--<img src="http://alligoagrovet.com/alligo-soft/images/horizon-agrotech-logo.jpg" class="img-responsive" alt=""/>-->
						<?php // echo $challanDetails[0]['firm_name']; ?>&nbsp;
						</div>
						<div class="col-xs-12">
						<p>
							&nbsp; <!--Off.: Gat No. 232, Jaulke Village, 10th Mile, Nasik - Ozar Road, Tal. Dindori, Dist. Nashik.-->
						</p>
					</div>
					</div>
					
				</div>				
				<div class="row" style=" border:1px solid #D6D6D6; margin:10px 0;" >
					<div class="col-xs-6" style="width:60%; float:left; ">
						<!--<h3>Client:</h3>-->
						<ul class="list-unstyled">
							<li>
								 <span style="font-weight:bold;">M/S: <?php echo $challanDetails[0]['comp_name']; ?></span>
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
								<span style="font-weight:bold;">VAT #:</span> <span style="font-size:8px;"><?php echo $challanDetails[0]['vat_no']; ?></span>
							</li>
							<li>
								<span style="font-weight:bold;">CST #:</span>  <span style="font-size:11px;"><?php echo $challanDetails[0]['cst_no']; ?></span>
							</li>
						</ul>
					</div>
					
					<div class="col-xs-4 invoice-payment" style="width: 30%; float:right; font-size:10px; ">
						
						<ul class="list-unstyled">
							<li>
								<strong style="font-weight:bold;">Invoice #:</strong> <?php echo $challanDetails[0]['invoice_no']; ?>
							</li>
							<li>
								<strong style="font-weight:bold;">Invoice Date:</strong> <?php echo date('d M Y H:i',strtotime($challanDetails[0]['invoice_date'])); ?>
							</li>
							<li>
								<strong style="font-weight:bold;">Challan #:</strong> <?php echo $challanDetails[0]['challan_no']; ?>
							</li>
							<li>
								<strong style="font-weight:bold;">Challan Date:</strong> <?php echo date('d M Y',strtotime($challanDetails[0]['chalan_date'])); ?>
							</li>
							<li>
								<strong style="font-weight:bold;">PO #:</strong> <?php echo $challanDetails[0]['po_ref']; ?>
							</li>							
							<li>
								<strong style="font-weight:bold;">Transport:</strong> <?php echo $challanShippingDetails[0]['transport']; ?>								
							</li> 
							<li>
								<strong style="font-weight:bold;">Vehicle #:</strong> <?php echo $challanShippingDetails[0]['vehicle_no']; ?>							
							</li>
							<li>
								<strong style="font-weight:bold;">Destination:</strong> <?php echo $challanShippingDetails[0]['destination']; ?>								
							</li> 
							<li>
								<strong style="font-weight:bold;">Goods Dispatched:</strong> <?php echo date('d M Y H:i',strtotime($challanShippingDetails[0]['goods_dispatched'])); ?>							
							</li>
							<!--<li>
								<strong style="font-weight:bold;">Delivery Date:</strong> <?php // echo date('d M Y',strtotime($challanShippingDetails[0]['delivery_date'])); ?>								
							</li>--> 
						</ul>
					</div>
				</div>
				
				<div class="row" style="min-height:500px; border:1px solid #D6D6D6; margin:10px 0;" >
					<div >
						<table class="table table-striped ">
						
						<tr class="border_bottom">
							
							<th width="24%" style="border-bottom:1px solid #DDDDDD">
								&nbsp; Description 
							</th>
							<th width="14%" style="border-bottom:1px solid #DDDDDD">
								 Batch
							</th>
							<th width="12%" style="border-bottom:1px solid #DDDDDD">
								 MFG Date
							</th>
							<th width="15%" style="border-bottom:1px solid #DDDDDD">
								 Packing
							</th>
							<th width="14%" style="border-bottom:1px solid #DDDDDD">
								 Quantity
							</th>
							<th width="9%" style="border-bottom:1px solid #DDDDDD">
								 Rate
							</th>
							<th width="12%" style="border-bottom:1px solid #DDDDDD">
								Amount
							</th>
							
						</tr>
						<br/><br/>
						<?php 
						$cnt= 1;
						$prodId =0;
						$orderTotal = $discountAmt = $forwardingAmt = 0.00;
						foreach($challanProducts as $product){
						 $prodTotal = 0.00;
						 $prodTotal = ($product['qty_per_bag']*$product['no_bags'])*$product['order_rate'];
						 $orderTotal +=$prodTotal;
					  ?>
						<tr class="space_bottom" >
							
							<td >&nbsp;<?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'] : '';?></td>
							<td ><?php echo $product['lot_no'];?></td>
							<td ><?php echo $product['manufacturing_date'];?></td>
							<td ><?php echo $product['qty_per_bag'].$product['prod_unit'].' X '.$product['no_bags'].$product['packing_units'];?></td>
							<td ><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							<td ><?php echo $product['order_rate']; ?></td>
							<td ><?php echo number_format($prodTotal,2)?> &nbsp;&nbsp;&nbsp;</td>
							
						</tr>
						
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?>
						
						<?php 
							for($k=$cnt; $k<=9; $k++){ ?>
							<tr style="border:solid 0px #ffffff;"><td colspan="7"><br/>&nbsp;</td></tr>
							
						 <?php	} ?>
						<tr style="border:solid 0px #ffffff;"><td colspan="7"><br/>&nbsp;</td></tr>
						<tr class="border_top">
							<td colspan="6" align="right" style="font-weight:bold;" >Subtotal&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right"  ><?php echo number_format($orderTotal,2);?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<?php if($orderDetails[0]['excise'] !=0.00){?>
						<tr class="space_bottom">
							<td colspan="6" align="right" style="font-weight:bold;"><?php echo 'Excise - '.$orderDetails[0]['excise'].'%';?>&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php $exciseTax = ($orderDetails[0]['excise']*$orderTotal)/100; 
							$orderTotal += $exciseTax;
							 echo number_format($exciseTax,2);
							?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
						<?php if($orderDetails[0]['tax_per'] !=0.00){?>
						<tr class="border_bottom">
							<td colspan="6" align="right" style="font-weight:bold;"><?php echo $orderDetails[0]['tax_type'].'-'.$orderDetails[0]['tax_per'].'%';?>&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php $tax =  ($orderDetails[0]['tax_per']*$orderTotal)/100; 
							  $orderTotal += $tax;
							  echo number_format($tax,2);
							?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
						
						<?php if($challanShippingDetails[0]['forwardingAmt'] != 0){?>
						<tr class="space_bottom">
							<td colspan="6" align="right" style="font-weight:bold;">Forwarding Charges&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php  $orderTotal += $challanShippingDetails[0]['forwardingAmt'];
							  echo number_format($challanShippingDetails[0]['forwardingAmt'],2);
							?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
						<?php if($challanShippingDetails[0]['discountAmt'] != 0){?>
						<tr class="space_bottom">
							<td colspan="6" align="right" style="font-weight:bold;">Discount&nbsp;&nbsp;&nbsp;</td>							
							<td class="hidden-480" align="right" ><?php  $discountAmt = $challanShippingDetails[0]['discountAmt'];
							  echo number_format($challanShippingDetails[0]['discountAmt'],2);
							?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
						
					    <tr class="space_bottom" >
							<td colspan="6" style="border-bottom:1px solid #D6D6D6; font-weight:bold;" align="right">Total&nbsp;&nbsp;&nbsp;</td>							
							<td style="border-bottom:1px solid #D6D6D6;" id="finalTotal" align="right" ><?php 
							$finalTotal = ($orderTotal + $forwardingAmt)-$discountAmt;
							
							echo number_format(round($finalTotal),2);?> &nbsp;&nbsp;&nbsp;</td>
						</tr>
						<tr class="space_bottom">
							<td colspan="7" align="left" style=" text-align:left;  margin-bottom:-10px;">
								&nbsp;&nbsp;&nbsp; Rs: <?php  echo ucwords(amountToWards(round($finalTotal))); ?>
							</td>
						</tr>
						
						</table>
					</div>
				</div>
				
				<div class="row" style=" border:1px solid #D6D6D6; margin:10px 0;" >
				<div class="col-xs-10" ><span style="font-weight:bold;">Payment Terms:  </span></div>
					<div class="col-xs-5" >
						
						<ul class="list-unstyled">
							
							<li>
								 <span style="font-weight:bold;">Bank Details </span>
							</li>
							<li>
								<span style="font-weight:bold;">Bank Name:</span> <?php echo $firmBankDetails[0]['bank_name']; ?>
							</li>
							<li>
								<span style="font-weight:bold;">Account No:</span> <?php echo $firmBankDetails[0]['account_no']; ?>
							</li>
						</ul>
					</div>
					
					<div class="col-xs-5 invoice-payment" >
						
						<ul class="list-unstyled">
							
							<li>
								 <span style="font-weight:bold;"> &nbsp;</span>
							</li>
							<li>
								<strong style="font-weight:bold;">Bank Branch:</strong> <?php echo $firmBankDetails[0]['bank_address']; ?>
							</li>
							<li>
								<strong style="font-weight:bold;">IFSC Code:</strong> <?php echo $firmBankDetails[0]['ifsc_code']; ?>
							</li>
							
						</ul>
					</div>
				</div>
				
				<div class="row" style="border:1px solid #D6D6D6; margin:10px 0;">
					<div class="col-xs-5">
						<div class="well123" style="background:#ffffff;">
							
							<span style="font-size:8px;">
							<span style="font-weight:bold;">VAT TIN No.</span> <?php echo $challanDetails[0]['vat_num']; ?> w.e.f. 30.03.2008<br/>
							<span style="font-weight:bold;">CST TIN No.</span> <?php echo $challanDetails[0]['cst_num']; ?> w.e.f. 30.03.2008<br/>
							<span style="font-weight:bold;">Excise Reg No.</span> <?php echo $challanDetails[0]['excise_num']; ?> <br/>
							<?php if($orderDetails[0]['excise'] > 0){ ?>
						<span style="font-weight:bold;">Notification No:</span> <?php if($orderDetails[0]['excise'] == 1.00){  echo '12/2012 No.128'; }else { echo '- ';} ?><br/>
							<span style="font-weight:bold;">Serial # in PLA/RG-23:</span> <?php if($orderDetails[0]['excise'] == 1.00){ echo '12/2012 No.128'; }else { echo '- ';} ?><br/>
							<?php } ?>
							<span style="font-weight:bold;">Range:</span> Range T&R-II (Dindori)/ Takli Road, Dwarka, Nashik <br/>
							<span style="font-weight:bold;">Division:</span> Nashik Town & Rural Division / Takli Road Dwarka, Nashik	
							</span>
							
							
						</div>
					</div>
					<div class="" >
						<div style="background:#ffffff;width:100%;">
							
							<span style="font-weight:bold;font-size:7px;">VAT Declaration</span><br/>
							
							<span style="font-size:7px; ">I/we hereby certified that my/our registration certificate under the MVAT Act 2002 is in force of the date on which the sale of the goods specified in the TAX INVOICE is made by me/us and that the trasection of the sale covered by this TAX INVOICE has been effected by me/us and it shall be accounted for in the turnover of the sales while filling of return and the due tax. If any payable on the sale has been paid or shall be paid.</span>
							<span style="font-size:8px"><br/>
							<span style="font-weight:bold;">Commissionerate:</span> Nashik-1/ Old Agra Road, R G Gadkari Chowk, Nashik <br/>
							<span style="font-weight:bold;">PAN/Income tax No:</span> AAHCA8881H	<br/>	
											
							</span>
						</div>
						
					</div>
					
					
					
					
				</div>
				<div class="row" style="border:1px solid #D6D6D6; margin:10px 0;">
					<div class="col-xs-7">
						<div class="well123" style="background:#ffffff; text-align:justify;">
							
							<span style="font-size:7px">Terms & Conditions.<br/>
							1) we reserve our right to demand and recover the full amount of this bill whenever we choose as all our For <?php echo $challanDetails[0]['firm_name']; ?> transactions are to be treated on terms strictly payment against delivery. 2) Our responsibility ceases on dispatch of the goods from our godown. The goods are dispatched at buyer's risk as such no claim will be entertained for any loss what soever in future. 3) The above sales in subject to addition of Sales Tax & Central Sales Tax. If any to be borne by the purchaser. 4) This bill must be paid within due date otherwise interest @30% per annum will be charged from the date of maturity 5) Any complaint regarding quality of goods must be made within three days on receipt of goods by customers. 6) Goods once will not be taken back under circumstances. 7) The material sold under this bill is exclusively for industrial purpose only. 8) All goods must be tested and approved before use. 9) Items are not subject to any claim of excise under modvat. 10) "The products offered are of chemical grade only." 11) The above products are to be used strictly after your QC approval and per law of various government depts.</span>							
						</div>
					</div>
					<div class="col-xs-3 invoice-block" style="text-align:right;">
						<div class="well123" style="background:#ffffff;">
							
							<span style="font-weight:bold;">For <?php echo $challanDetails[0]['firm_name']; ?></span><br/><br/><br/><br/><br/>
							
							<span style="font-weight:bold;">Authorised Signatory</span>
						</div>
						
					</div>
				</div>
			</div>
<!-- END PAGE CONTENT-->