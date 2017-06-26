<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->

<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item("global_url")?>plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />

<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo $this->config->item("global_url")?>plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/jquery-multi-select/css/multi-select.css"/>
<!-- END PAGE STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" href="<?php echo $this->config->item("global_url")?>plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>

<!-- BEGIN THEME STYLES -->
<link href="<?php echo $this->config->item("global_url")?>css/components.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("global_url")?>css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>

<div class="invoice">
				<div class="row invoice-logo" style="text-align:center;" >
					<div class="col-xs-12 invoice-logo-space">
						<div class="col-xs-12" style="text-align:center; font-size:40px; color:#0077BD; font-weight:bold;">
						<!--<img src="http://alligoagrovet.com/alligo-soft/images/horizon-agrotech-logo.jpg" class="img-responsive" alt=""/>-->
						<?php echo $challanDetails[0]['firm_name']; ?>
						</div>
						<div class="col-xs-12">
						<p>
							 Off.: Gat No. 232, Jaulke Village, 10th Mile, Nasik - Ozar Road, Tal. Dindori, Dist. Nashik.
						</p>
					</div>
					</div>
					
				</div>
				<hr/>
				<div class="row" style="border: 1px solid #e3e3e3;">
					<div class="col-xs-8" style="width:60%; float:left; background-color:#FF0000;">
						<!--<h3>Client:</h3>-->
						<ul class="list-unstyled">
							<li>
								 <strong>M/S: <?php echo $challanDetails[0]['comp_name']; ?></strong>
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
					
					<div class="col-xs-4 invoice-payment" style="width: 30%; float:right; background-color:#0000CC;">
						
						<ul class="list-unstyled">
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
								<strong>PO Date:</strong> <?php echo date('d M Y',strtotime($challanDetails[0]['po_date'])); ?>
							</li>
							<li>
								<strong>LR #:</strong> <?php $challanShippingDetails[0]['lr_no']; ?>
								
							</li>
							<li>
								<strong>Transport:</strong> <?php $challanShippingDetails[0]['transport'] ?>
								
							</li> 
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-striped table-bordered table-hover" border="0" style="border: 1px solid #e3e3e3;">
						<thead>
						<tr>
							<th width="5%">
								 #
							</th>
							<th width="45%">
								 Description 
							</th>
							<th width="15%">
								 Batch #
							</th>
							<th width="20%">
								 PACKING
							</th>
							<th width="15%">
								Total QTY.
							</th>
							
						</tr>
						</thead>
						<tbody>
						<?php 
						$cnt= 1;
						$prodId =0;
						foreach($challanProducts as $product){?>
						<tr>
							<td><?php echo $cnt;?></td>
							<td><?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'].' ('.$product['item_code'].')' : '';?></td>
							<td class="hidden-480"><?php echo $product['lot_no']; ?></td>
							<td class="hidden-480"><?php echo $product['qty_per_bag'].' '.$product['prod_unit'] ?> X <?php echo $product['no_bags'].' '.$product['packing_units'] ?>
							</td>
							<td class="hidden-480"><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							
						</tr>
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?>
						<?php 
						$cnt= 1;
						$prodId =0;
						foreach($challanProducts as $product){?>
						<tr>
							<td><?php echo $cnt;?></td>
							<td><?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'].' ('.$product['item_code'].')' : '';?></td>
							<td class="hidden-480"><?php echo $product['lot_no']; ?></td>
							<td class="hidden-480"><?php echo $product['qty_per_bag'].' '.$product['prod_unit'] ?> X <?php echo $product['no_bags'].' '.$product['packing_units'] ?>
							</td>
							<td class="hidden-480"><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							
						</tr>
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?>
						<?php 
						$cnt= 1;
						$prodId =0;
						foreach($challanProducts as $product){?>
						<tr>
							<td><?php echo $cnt;?></td>
							<td><?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'].' ('.$product['item_code'].')' : '';?></td>
							<td class="hidden-480"><?php echo $product['lot_no']; ?></td>
							<td class="hidden-480"><?php echo $product['qty_per_bag'].' '.$product['prod_unit'] ?> X <?php echo $product['no_bags'].' '.$product['packing_units'] ?>
							</td>
							<td class="hidden-480"><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							
						</tr>
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?>
						<?php 
						$cnt= 1;
						$prodId =0;
						foreach($challanProducts as $product){?>
						<tr>
							<td><?php echo $cnt;?></td>
							<td><?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'].' ('.$product['item_code'].')' : '';?></td>
							<td class="hidden-480"><?php echo $product['lot_no']; ?></td>
							<td class="hidden-480"><?php echo $product['qty_per_bag'].' '.$product['prod_unit'] ?> X <?php echo $product['no_bags'].' '.$product['packing_units'] ?>
							</td>
							<td class="hidden-480"><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							
						</tr>
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?><?php 
						$cnt= 1;
						$prodId =0;
						foreach($challanProducts as $product){?>
						<tr>
							<td><?php echo $cnt;?></td>
							<td><?php echo ($product['order_pid'] != $prodId) ? $product['prod_ref_name'].' ('.$product['item_code'].')' : '';?></td>
							<td class="hidden-480"><?php echo $product['lot_no']; ?></td>
							<td class="hidden-480"><?php echo $product['qty_per_bag'].' '.$product['prod_unit'] ?> X <?php echo $product['no_bags'].' '.$product['packing_units'] ?>
							</td>
							<td class="hidden-480"><?php echo number_format(($product['qty_per_bag']*$product['no_bags']),2)?> <?php echo $product['prod_unit'] ?></td>
							
						</tr>
						<?php 
							$cnt++;
							$prodId = $product['order_pid'];
						} ?>
						</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="well">
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
						
						
						
						
					</div>
				</div>
			</div>
<!-- END PAGE CONTENT-->