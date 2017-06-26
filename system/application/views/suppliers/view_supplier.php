<!-- BEGIN PAGE CONTENT-->
<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>

       
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Supplier Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Supplier Name</label>
                  <span class="form-control form-control-view"><?php echo $supplier_details[0]['supl_comp'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Contact Person</label>
                  <span class="form-control form-control-view"><?php echo $supplier_details[0]['supl_conperson'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Phone Number</label>
                     <span class="form-control form-control-view"><?php echo $supplier_details[0]['supl_phone'] ?></span> 
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Mobile Number</label>
                      <span class="form-control form-control-view"><?php echo $supplier_details[0]['supl_mobile'] ?></span>
					 
                </div>
              </div>
              <!--/span supl_fax --> 
            </div>
            <!--/row-->
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email</label>
                     <span class="form-control form-control-view"><a href="mailto:<?php echo $supplier_details[0]['supl_email'] ?>;"><?php echo $supplier_details[0]['supl_email'] ?></a></span> 
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
				  <label class="control-label">Website</label>
                      <span class="form-control form-control-view"><a href="<?php echo $supplier_details[0]['supl_website'] ?>" target="_blank" ><?php echo $supplier_details[0]['supl_website'] ?></a></span>
                  
					 
                </div>
              </div>
              <!--/span--> 
            </div>
			
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Office Address </label>
                  <span class="form-control form-control-view" style="min-height:100px;"><?php echo nl2br($supplier_details[0]['supl_address']); ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">City</label>
                     <span class="form-control form-control-view"><?php echo nl2br($supplier_details[0]['supl_city']); ?></span>
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
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Other Details</div>
        <div class="tools"><a href="javascript:;" class="expand"></a></div>
      </div>
      <div class="portlet-body form" style="display: none;"> 
        <!-- BEGIN FORM-->
          <div class="form-body">            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">TIN Number</label>
                  <span class="form-control form-control-view"><?php echo $supplier_details[0]['tin_num'] ?></span>
                </div>
              </div>
              <!--/span-->
			 
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">PAN Number</label>
                  <span class="form-control form-control-view"><?php echo $supplier_details[0]['pan_no'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
			   <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">VAT Number</label>
                   <span class="form-control form-control-view"><?php echo $supplier_details[0]['vat_no'] ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">CST Number</label>
                  <span class="form-control form-control-view"><?php echo $supplier_details[0]['cst_no'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>	
			<div class="row">
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Excise Number</label>
                  <span class="form-control form-control-view"><?php echo $supplier_details[0]['excise_no'] ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Notes</label>
                  <span class="form-control form-control-view" style="min-height:100px;"><?php echo nl2br($supplier_details[0]['special_comment']) ?></span>
                </div>
              </div>
              <!--/span handling_person --> 
            </div>
			
			
					
			
                       
            <!--/row-->
          </div>
         
          
          
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT--> 