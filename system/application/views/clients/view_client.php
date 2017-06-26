<!-- BEGIN PAGE CONTENT-->
<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>

       


<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Client Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">
		  <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Company Name</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['comp_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
               
              </div>
              <!--/span--> 
            </div>            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Contact Name</label>
                   <span class="form-control form-control-view"><?php echo $client_details[0]['primary_contact'] ?></span>
                </div>
              </div>
              <!--/span-->
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <span class="form-control form-control-view"><a href="mailto:<?php echo $client_details[0]['primary_email'] ?>;"><?php echo $client_details[0]['primary_email'] ?></a></span>
                </div>
              </div>
              
              <!--/span--> 
            </div>
			
			<div class="row">
			  
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Phone Number</label>
                   <span class="form-control form-control-view"><?php echo $client_details[0]['primary_phone'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Mobile</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['primary_mobile'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
						
			<div class="row">
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">City</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['city'] ?></span>
                </div>
              </div>
              <!--/span-->
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label" > Address</label>
                  <span class="form-control form-control-view" style="min-height:100px;"><?php echo nl2br($client_details[0]['shipping_address']) ?></span>
                </div>
              </div> 
            </div>
			
			
                       
            <!--/row-->
             <div class="row">
              
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Notes</label>
                  <span class="form-control form-control-view" style="min-height:100px;"><?php echo nl2br($client_details[0]['notes']) ?></span>
                </div>
              </div>
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Other Information</label>
                  <span class="form-control form-control-view"  style="min-height:100px;"><?php echo nl2br($client_details[0]['other_information']) ?></span>
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
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">TIN Number</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['tin_num'] ?></span>
                </div>
              </div>
              <!--/span-->
			 
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">PAN Number<span class="required" aria-required="true"> *</span></label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['pan_no'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>
			
			<div class="row">
			   <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">VAT Number</label>
                   <span class="form-control form-control-view"><?php echo $client_details[0]['vat_no'] ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">CST Number</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['cst_no'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>	
			<div class="row">
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Excise Number</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['excise_no'] ?></span>
                </div>
              </div>
              
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                  <span class="form-control form-control-view"><?php echo $client_details[0]['status'] ?></span>
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