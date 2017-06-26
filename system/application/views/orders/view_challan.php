<!-- BEGIN PAGE CONTENT-->
<style>
td {   
    padding: 3px !important;
}
body{
	font-size:13px;
}
</style>
<div class="page-bar"><?php echo $bredcrumbs; ?></div>

<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			
			if($orderDetails[0]['order_status'] == 'Completed'){
				$attributes = array('class' => 'horizontal-form', 'id' => 'myform', 'target' => '_blank');
			}
			echo form_open_multipart('orders/view_challan/'.$order_type.'/'.$orderDetails[0]['order_id'],$attributes);
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => 'Update Challan',
								'class' => 'btn green'
			);		  
	   ?>
<div class="invoice">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
					   <div class="col-xs-12" >
							<strong style="font-weight:bold; font-size:13px">DELIVERY CHALLAN</strong>
						</div>
						<div class="col-xs-2">
							Logo Here<!--<img src="< ?php echo $this->config->item("base_url_asset")?>assets/admin/layout/img/logo_new.jpg" class="img-responsive" width="50px" alt=""/>-->
						</div>
						<div class="col-xs-6">
						<span style="font-size:30px; color:#0077BD; font-weight:bold;"><?php  echo $orderDetails[0]['firm_name']; ?>&nbsp;</span><br/>
						<span style="font-size:13px; text-align:center; color:#0077BD; font-weight:bold;">Slogan Here&nbsp;</span><br/>
						 
						</div>
						<div class="col-xs-2" style="text-align:right; font-size:10px; " >
							<strong style="font-weight:bold;">Mobile:</strong> &nbsp;7276447090<br/>
							<strong style="font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> &nbsp;9960490859<br/>
							<strong style="font-weight:bold;">Tel:</strong> (0253) 1234567<br/>
							
						</div>
						<div class="col-xs-12">
						Your Address goes here, Nashik-10 <br/>
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
								 <strong>M/S: <?php echo $orderDetails[0]['contact_person']; ?></strong>
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
								<strong>Challan #:</strong> <?php echo $orderDetails[0]['challan_number']; ?>
							</li>
							<li>
								<strong>Challan Date:</strong> <?php echo date('d M Y',strtotime($orderDetails[0]['order_date'])); ?>
							</li>
							
							
							
							
						</ul>
					</div>
				</div>
				<div class="row" style="min-height:500px;" >
					<div class="col-xs-12">
						<table class="table table-bordered" border="0" bgcolor="#FF0000" >
						<thead>
						<tr>
							<th width="5%" style="border-bottom:1px solid #DDDDDD">
								 #
							</th>
							<th width="70%" style="border-bottom:1px solid #DDDDDD">
								 Particular 
							</th>
							<!--<th width="15%" style="border-bottom:1px solid #DDDDDD">
								 Part #
							</th>-->
							<th width="25%" style="border-bottom:1px solid #DDDDDD">
								 Quantity
							</th>
							<!--<th width="15%" style="border-bottom:1px solid #DDDDDD">
								Remark.
							</th>-->
							
						</tr>
						</thead>
						<tbody>
						<?php 
						$cnt= 1;
						$totalQty = 0;
						foreach($orderProducts as $product){
							$totalQty += $product['order_qty'];
						?>
						<tr >
							<td ><?php echo $cnt;?></td>
							<td ><?php echo $product['prod_ref_name']; ?></td>
							<!--<td class="hidden-480" ><?php //echo $product['part_no']; ?></td>-->
							<td class="hidden-480" ><?php echo $product['order_qty'];  ?></td>
							<!--<td class="hidden-480" ><?php // echo $product['remark'] ?></td>-->
							
						</tr>
						
						
						<?php 
							$cnt++;
							
						} ?>
						
						
						<?php for($k=$cnt;$k <16;$k++){?>
						<tr >
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<!--<td class="hidden-480" style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							<td class="hidden-480" style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>-->
							<td class="hidden-480" style="border:none; border-right:1px solid #DDDDDD;">&nbsp;</td>
							
						</tr>
						<?php } ?>
						<tr >
							<td colspan="2" align="right" >Total Quantity &nbsp;&nbsp;</td>
							<!--<td class="hidden-480" ></td>
							<td class="hidden-480" ></td>-->
							<td class="hidden-480" ><?php echo number_format($totalQty,2);?></td>
							
						</tr>
						 
						
						</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6">
						<div class="well" style="background:#ffffff;">
							<address>
							<strong style="font-size:10px">If any discrepancy is found in quantity, Quality it should be notified within  24 hours of delivery. No Claim will be entertained thereafter.<br/>
							</strong>
							<span  style="font-size:10px">Received goods in good conditions.</span>
							<address>
							<strong><br/><br/>RECEIVED BY:</strong><br/>
							
							</address>
						</div>
					</div>
					<div class="col-xs-6 invoice-block" style="text-align:right;">
						<ul class="list-unstyled amounts">
							<li>
								<strong>For <?php echo $orderDetails[0]['firm_name']; ?></strong> <br/><br/><br/><br/><br/>
							</li>
							
							<li>
								<strong>Authorised Signatory</strong>
							</li>
						</ul>
						<br/>
						<!--<a class="btn btn-lg blue hidden-print margin-bottom-5" onClick="javascript:window.print();">
						Print <i class="fa fa-print"></i>
						</a>-->
						 
			
							<?php if($orderDetails[0]['order_status'] == 'Completed'){ ?>
								<input name="submit_challan" value="Print Challan" class="btn btn-lg blue hidden-print margin-bottom-5" type="submit">
							<?php } ?>
							
							 
							<a href="<?php echo base_url()?>orders/view_invoice/<?php echo $order_type.'/'.$orderDetails[0]['order_id'] ?>" class="btn  blue hidden-print">
							View Your Invoice <i class="fa fa-check"></i>
							</a>		
						
						
					</div>
				</div>
			</div>

<?php	echo form_close();	?>			
			
<!-- END PAGE CONTENT-->