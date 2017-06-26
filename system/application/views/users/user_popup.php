<?php 
//echo "<pre>";print_r($user_details); die();
//echo "<pre>";print_r($page_details);die;
//$correct=$user_details[0]['page_status']
?> 
	<div class="col-md-12">
		<div style="max-height: 800px;" data-always-visible="0" data-rail-visible="0" data-handle-color="#dae3e7"> 
		<!-- class="scroller" -->
				<!-- TASK HEAD -->
				<div class="form">
                 <h4 class="form-section">Full Namr</h4>
                 <div class="row">
                 <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label"></label>
                  <?php echo $user_details[0]['first_name'].' '.$user_details[0]['last_name']; ?>
                </div>
                </div>
            </div>
            <h4 class="form-section">Username</h4>
                 <div class="row">
                 <div class="col-md-12">
                  <div class="form-group">
                  <?php echo $user_details[0]['username']; ?>
                   
                </div>
                </div>
            </div>
         <h4 class="form-section">Page Status</h4>
            <div class="row">
                 <div class="col-md-12">
                  <div class="form-group">
                  <?php echo $user_details[0]['user_status']; ?>
                   
                </div>
                </div>
            </div>
				</div>
                </div>
		</div>
		</div>
	
<link href="<?php echo base_url();?>assets/admin/layout/css/custom1.css" rel="stylesheet" type="text/css"/>