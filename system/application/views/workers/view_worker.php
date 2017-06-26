<!-- BEGIN PAGE CONTENT-->
<h3 class="page-title"><?php echo $pagetitle;?></h3>
<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>

       


<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Employee Details</div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
          <div class="form-body">
		  <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Employee Name</label>
                  <span class="form-control form-control-view"><?php echo $employee_details[0]['emp_name'] ?></span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
               	<div class="form-group">
                  <label class="control-label">Contact Number</label>
                   <span class="form-control form-control-view"><?php echo $employee_details[0]['emp_mobile'] ?></span>
                </div>
              </div>
              <!--/span--> 
            </div>            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Address</label>
                   <span class="form-control form-control-view"><?php echo $employee_details[0]['emp_address'] ?></span>
                </div>
              </div>
              <!--/span-->
			  <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Status</label>
                  <span class="form-control form-control-view"><?php echo $employee_details[0]['emp_status'] ?></span>
                </div>
              </div>
              
              <!--/span--> 
            </div>
          </div>
         
          
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT--> 