<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>



<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Product Description</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">
		   <div class="row">              
                 
                 <div class="col-md-12">
                   <div class="form-group">                  
                  	<span class="form-control form-control-view"><?php echo ($product_details[0]['product_desc']); ?></span>				  
                </div>
              </div>
			  
			  
             </div>		  		
          </div>
      </div>
    </div>
  </div>
</div>




<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i><?php echo 'Specifications';?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">
		   <div class="row">
            <?php 
								
			if(sizeof($product_specification) > 0){	
					  
				foreach($product_specification as $specification){ ?>
				<div class="col-md-6">
				  <div class="form-group">
				  
					<input type="checkbox"  value="" checked="checked" /><?php echo $specification;?>
				  </div>
				</div>
			<?php 
			  }
			}else{  ?>			
			  <div class="col-md-12">
				  <div class="form-group">				  
					There are no specifications assigned yet.
				  </div>
				</div>
			<?php } ?>
          </div>		  		
          </div>
      </div>
    </div>
  </div>
</div>		
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Other Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
       
          <div class="form-body">		
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Code</label>
                  <span class="form-control form-control-view"><?php echo $product_details[0]['item_code'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Name</label>
                  <span class="form-control form-control-view"><?php echo $product_details[0]['product_name'] ?></span>
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Min. Quantity</label>
                  <span class="form-control form-control-view"><?php echo $product_details[0]['min_qty'] ?>/<?php echo $product_details[0]['prod_unit'] ?></span>
                  
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    
                     
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row--> 
          </div>
 
          
      </div>
    </div>
  </div>
</div>