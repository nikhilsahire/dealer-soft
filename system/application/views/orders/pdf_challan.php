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
  border-bottom:1px solid #D6D6D6;
  height:25px;
}
tr.border_top td {
  border-top:1px solid #D6D6D6;
}
tr.space_bottom td {
   height:18px;
}
</style>
<div class="invoice" style="background-color:#ffffff; ">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
					   <div class="col-xs-12" >
							<strong style="font-weight:bold; font-size:13px">DELIVERY CHALLAN</strong>
						</div>
						<div class="col-xs-1">
							Logo Here<!--<img src="< ?php echo $this->config->item("base_url_asset")?>assets/admin/layout/img/logo_new.jpg" class="img-responsive" width="50px" alt=""/>-->
						</div>
						<div class="col-xs-7">
						<span style="font-size:30px;  font-weight:bold;"><?php  echo $orderDetails[0]['firm_name']; ?>&nbsp;</span><br/>
						<span style="font-size:17px; text-align:center; font-weight:bold;">Sogan Here&nbsp;</span><br/>
						 
						</div>
						<div class="col-xs-2" style="text-align:right; font-size:10px; " >
							<strong style="font-weight:bold;">Mobile:</strong> &nbsp;7276447090<br/>
							<strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> &nbsp;9960490859<br/>
							<strong style="font-weight:bold;">Tel:</strong> (0253) 1234567<br/>
							
						</div>
						<div class="col-xs-12">
						Your Company address will goes here, Nashik-10 <br/>
						<strong style="font-weight:bold;">Email:</strong> youremail@gmail.com
						</div>
					</div>
					
				</div>				
				<div class="row" style=" border:1px solid #D6D6D6; margin:10px 0;" >
					<div class="col-xs-6" style="width:60%; float:left; ">
						<!--<h3>Client:</h3>-->
						<ul class="list-unstyled">
							<li>
								 <span style="font-weight:bold;"> <?php echo $orderDetails[0]['contact_person']; ?></span>
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
					
					<div class="col-xs-4 invoice-payment" style="width: 30%; float:right; font-size:12px; ">
						
						<ul class="list-unstyled">
							
							<li>
								<strong style="font-weight:bold;">Challan #:</strong> <?php echo $orderDetails[0]['challan_number']; ?>
							</li>
							<li>
								<strong style="font-weight:bold;">Challan Date:</strong> <?php echo date('d M Y',strtotime($orderDetails[0]['order_date'])); ?>
							</li>
							
							
						</ul>
					</div>
				</div>
				
				<div class="row" style=" border:1px solid #D6D6D6; margin:20px 0;" >
					<div >
						<table class="table table-striped " style="min-height:550px;S">
						
						<tr class="border_bottom">
							
							<th width="11%" style="border-bottom:1px solid #DDDDDD">
								&nbsp;Sr. No.
							</th>
							<th width="70%" style="border-bottom:1px solid #DDDDDD">
								 Description
							</th>
							
							<th width="19%" style="border-bottom:1px solid #DDDDDD; text-align:center;">
								 Quantity
							</th>
							
						</tr>
						
						<?php 
						$cnt= 1;
						$totalQty = 0;
						foreach($orderProducts as $product){
						 $totalQty += $product['order_qty'];
					  ?>
						<tr class="space_bottom" >
							
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;<?php echo $cnt;?></td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;<?php echo $product['prod_ref_name'];?></td>						
							<td class="hidden-480" align="right" style="border:none; ">&nbsp;<?php echo number_format($product['order_qty'],2)?>&nbsp;&nbsp;&nbsp; </td>
							
						</tr>
						
						<?php 
							$cnt++;
							
						} ?>
						
						<?php if($cnt <30 ){ 
							
							
						   for($k=$cnt; $k<=30; $k++){ ?>
						   	<tr>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none;">&nbsp;</td>
							</tr>
						   
						<?php } ?>
							<tr class="space_bottom" >
							
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD; text-align:right;">&nbsp;Total Quantity&nbsp;&nbsp;</td>						
							<td class="hidden-480" align="right" style="border:none; ">&nbsp;<?php echo number_format($totalQty,2); ?>&nbsp;&nbsp;&nbsp; </td>
							
						</tr>
						  	 
							
						<?php }// EO if ?>
						
						
						
						</table>
					</div>
				</div>
				
				
				
				
				<div class="row" style="border:1px solid #D6D6D6; margin:20px 0;">
					<div class="col-xs-7">
						<div class="well123" style="background:#ffffff; text-align:justify;">							
							<span style="font-size:11px"><strong style="font-weight:bold;">Terms & Conditions.</strong><br/>
							If any discrepancy is found in quantity, Quality it should be notified within  24 hours of delivery. No Claim will be entertained thereafter. </span><br/><span style="font-weight:bold;"><br/><br/>Received By:</span>	
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