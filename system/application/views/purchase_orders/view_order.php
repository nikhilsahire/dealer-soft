<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>

<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Products Of Purchase Order # <?php echo $purchaseOrderDetails[0]['purc_order_number'] ?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
	  
	<?php if(isset($_SESSION['suc_msg'])){ ?> 
	 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
	  <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?>
	</div>
	<?php } ?>
      <div class="portlet-body">
	       
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th width="20%"> Product Name</th>
				<th width="10%"> Rate	</th>
				<th width="10%"> Quantity</th>
				<th width="10%"> Total Inword</th>
            </tr>
          </thead>
          <tbody id="tableBody">
		  <?php $totalProducts = sizeof($purchaseOrderProducts);?>
           <input type="hidden" class="form-control" id="rownums" name="rownums" value= "<?php echo $totalProducts; ?>" required="required" />
		   <?php 
		    if($totalProducts > 0){
			$i=1;
			   
			foreach($purchaseOrderProducts as $purchaseProduct){  
			
				$class = 'success';
			  if(($purchaseProduct['purchase_qty'] - $purchaseProduct['total_inword']) > 0){
			  
			  	$class = 'danger';
			  }
			?>
			<tr class="gradeX <?php echo $class;?> odd" id="tr_<?php echo $i;?>">
				<td width="20%"> 
					<?php echo $purchaseProduct['product_name']?>
				</td>
				
				<td width="10%"><?php echo $purchaseProduct['purchase_rate']?></td>
				<td width="10%"><?php echo $purchaseProduct['purchase_qty'].' '.$purchaseProduct['prod_unit']?> </td>
				<td width="10%"> <?php echo $purchaseProduct['total_inword'].' '.$purchaseProduct['prod_unit']?></td>
				
			</tr> 
			<?php 
			  $i++;
			   } // EO foreach 
			  } // EO if 
			 ?>
			
			
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>View Purchase Order # <?php echo $purchaseOrderDetails[0]['purc_order_number'] ?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
	  
	
        <!-- BEGIN FORM-->
		
		
          <div class="form-body">		
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name</label>
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['firm_name'] ?></span>
                </div>
              </div>
              <!--/span-->	
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name</label>
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['supl_comp'] ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            
            <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Contact Person</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_conperson']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Email</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_email']); ?></span>
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
				    <label class="control-label">Phone Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_phone']); ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  
                  <label class="control-label">Mobile Number</label>                  
				  	  <span class="form-control form-control-view"><?php echo ($purchaseOrderDetails[0]['supl_mobile']); ?></span>
                </div>
              </div>
			 </div>
			
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                   <label class="control-label">Payment Terms</label> 
				  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['pay_term'] ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">Payment Reminder After</label> 
				
				    <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['payment_reminder'] ?></span>                   
                </div>
              </div>
			 </div>
			 <div class="row">              
                 
                 <div class="col-md-6">
                   <div class="form-group">
                                
				  	 <label class="control-label">S/I GST Applied <span class="required" aria-required="true"> *</span></label> 
				  
                  <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['tax_per'].'%'.$purchaseOrderDetails[0]['tax_type']  ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                   <div class="form-group">
                  <label class="control-label">CGST Applied </label> 
				  
				   <span class="form-control form-control-view"><?php echo $purchaseOrderDetails[0]['excise'].'%';  ?></span>                
                </div>
              </div>
			 </div>
            <!--/row--> 
			 
			<div class="row">              
                 
                 
			  <div class="col-md-12">
                   <div class="form-group">
                  <label class="control-label">Order Remark</label>
				  <span class="form-control form-control-view"><?php echo nl2br($purchaseOrderDetails[0]['order_remark']);  ?></span>                  
                </div>
              </div>
			 </div>
            
            <!--/row--> 
          </div>
		
          
      </div>
    </div>
  </div>
  
</div>