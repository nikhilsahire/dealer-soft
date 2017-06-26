<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>






<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>View Order # <?php echo $orderDetails[0]['order_number'] ?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">		
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name</label>
                  <span class="form-control form-control-view"><?php echo $orderDetails[0]['firm_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <span class="form-control form-control-view"><?php echo $orderDetails[0]['comp_name'] ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Billing Address</label>
                  <span class="form-control form-control-view"><?php echo nl2br($orderDetails[0]['billing_address']); ?></span>
                  
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Shipping Address</label>
                    <span class="form-control form-control-view"><?php echo nl2br($orderDetails[0]['shipping_address']); ?></span>
                     
                </div>
              </div>
              <!--/span--> 
            </div>
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Contact Person</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($orderDetails[0]['contact_person']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Peyment Terms</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['pay_term']; ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Payment Reminder After (Days)</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['payment_reminder']; ?> </span>
                  
                </div>
              </div>
			 </div>
			<div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">TAX Applied</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['tax_per'].' '.$orderDetails[0]['tax_type']; ?> </span>
                  <!--<label class="control-label">Contact Person</label>                  
				  	<span class="form-control form-control-view"><?php echo ($orderDetails[0]['contact_person']); ?></span>-->
                  
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Excise Applied</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['excise']; ?></span>
                  
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">PO Date</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($orderDetails[0]['po_date']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">PO Number</label>                  
				  	<span class="form-control form-control-view"><?php echo $orderDetails[0]['po_ref']; ?> </span>
                  
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Order Remark</label>                  
				  	<span class="form-control form-control-view"><?php echo nl2br($orderDetails[0]['order_remark']); ?></span>
                  
                </div>
              </div>
			  
			 </div>
            
            <!--/row--> 
          </div>
      </div>
    </div>
  </div>
  
</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage <?php echo $pagetitle;?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th>Product Name</th>
				<th> Order Rate	</th>
				<th> Order Qty</th>
				<th> Packing</th>
				<th> Dispatched</th>
				<th> Balance</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orderProducts as $orderProduct){
			
			  $class = 'success';
			  if(($orderProduct['order_qty'] - $orderProduct['dispatch_qty']) > 0){
			  
			  	$class = 'danger';
			  }
			  ?>
			<tr class="<?php echo $class; ?>">
				<td> <?php echo $orderProduct['prod_ref_name']; ?></td>
				<td> <?php echo number_format($orderProduct['order_rate'],2); ?> </td>
				<td> <?php echo number_format($orderProduct['order_qty'],2).' '. $orderProduct['prod_unit']; ?> </td>
				<td> <?php echo $orderProduct['order_packing']; ?> </td>
				<td> <?php echo number_format($orderProduct['dispatch_qty'],2).' '. $orderProduct['prod_unit']; ?> </td>
				<td> <?php echo number_format(($orderProduct['order_qty'] - $orderProduct['dispatch_qty']),2).' '. $orderProduct['prod_unit']; ?> </td>
			</tr>
			<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>