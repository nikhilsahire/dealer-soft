<!-- BEGIN PAGE CONTENT-->
<div class="page-bar"><?php echo $bredcrumbs; ?></div>
<?php  
	    	$attributes = array('class' => 'horizontal-form', 'id' => 'child_batch');
			echo form_open_multipart('orders/creare_child_batch/',$attributes);
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);		  
	   ?>
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Create Sub Batch </div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form"> 
	  <?php if(validation_errors()){?>
          <div class="alert alert-danger display-hide" style="display: block;">
            <button class="close" data-close="alert"></button>
            You have some form errors. Please check below. </div>
	<?php } ?>
	<?php if(isset($_SESSION['suc_msg'])){ ?> 
	 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
	  <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?>
	</div>
	<?php } ?>
	
        <!-- BEGIN FORM-->
		
		
          <div class="form-body">		
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Name <span class="required" aria-required="true"> *</span></label>
				  
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Firm Name<span class="required" aria-required="true"> *</span> </label>
                   
                  
                </div>
              </div>
              <!--/span--> 
            </div>
            
            
            <!--/row-->
            <div class="row">
              <div class="col-md-6">
			    <div class="form-group">
                  <label class="control-label">Batch Number</label>
				  
                  
                  
                   </div>
                
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Batch Stock <span class="required" aria-required="true"> *</span></label>
                     
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
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Packing Material</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<div class="btn green add_new_row">
												Add Packing Material <i class="fa fa-plus"></i>
											</div>
										</div>
									</div>
									
								</div>
							</div>
        <table class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
			    <th> Product Name</th>
				<th width="15%"> Batch #</th>
				<th width="10%"> Quantity</th>
				
            </tr>
          </thead>
          <tbody id="tableBody">
           
			<tr class="gradeX short odd">
				<td> 
					<input type="text" class="form-control" name="prod_ref_name[]" value= "" id="ref_main_prod" required="required" />
				</td>
				<td width="15%"> 
					<input type="text" class="form-control" name="prod_ref_name[]" value= "" id="ref_main_prod" required="required" />
					<input type="hidden" class="form-control" id="rownums" name="rownums" value= "1" required="required" />
				</td>
				
				<td width="10%"> <input type="text" class="form-control" name="order_qty[]" value= "" required="required" /> </td>
				
			</tr> 
			
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>

<div class="row">
			  <div class="col-md-12">
				<div class="portlet-body form">
				  <div class="form-actions right">
					<div class="row">
					  <div class="col-md-offset-3 col-md-9"> <?php echo form_submit($arr_submit)?> <a href="<?php echo base_url();?>client">
						<button type="button" class="btn default">Cancel</button>
						</a> </div>
					  <div class="col-md-6"> </div>
					</div>
				  </div>
				  
				  <!-- END FORM-->
				</div>
			  </div>
			</div>
<?php echo form_close(); ?>

<script type="text/javascript">
$(function(){
		
        $(".add_new_row").click(function() {
		     var rownums = $('#rownums').val();
		  	$.ajax({
				url: SITE_URL+"orders/add_new_row/",
				type:'POST',
				data:{rownums:rownums},
				async:false,
				success: function(result){
					$('#tableBody').append(result);
					rownums = parseInt(rownums)+1;
					$('#rownums').val(rownums);
				}
			});	
        });
		
		$("#main_prod").change(function(){
			 var main_prod = $(this).attr("id");
			 var txt = $("#"+main_prod+" option:selected").text();
			 $("#ref_"+main_prod).val(txt);
		});
					
		$("#comp_id123").change(function() {
		  	var comp_id = $('#comp_id').val();
			$.ajax({
				url: SITE_URL+"orders/client_info/",
				type:'POST',
				data:{comp_id:comp_id},
				async:false,
				dataType: "json",
				success: function(response){
					var outcome = $.parseJSON(response.outcome); 
					if(outcome == 1){
						var comp_data = $.parseJSON(response.comp_data); 
						alert(comp_data);
						//var shipping_address = $.parseJSON(response.shipping_address); 
						//$('#contact_person').val(contact_person);
						$('#shipping_address').val(comp_data);
						//$('#billing_address').val(shipping_address);
					}else{
						alert('Something went wrong with you');
					}
					
					
				}
			});	
        });
		
		
    });
</script>