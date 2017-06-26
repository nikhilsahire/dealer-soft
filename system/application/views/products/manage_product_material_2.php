<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i>Specificatins for - <?php echo $product_details[0]['product_name'];?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group"> <a href="#coursepdf" data-toggle="modal">
                <button id="sample_editable_1_new" class="btn green"> Add Specificatin <i class="fa fa-plus"></i> </button>
                </a> </div>
              
            </div>
          </div>
        </div>
         <?php if(isset($suc_msg) && $suc_msg!=''){ ?> 
             <div class="alert alert-success">
              <?php echo $suc_msg;?>
            </div>
        <?php } ?>
        <?php if(isset($err_msg) && $err_msg!=''){ ?> 
             <div class="alert alert-danger">
              <?php echo $err_msg;?>
            </div>
        <?php } ?>
        <div class="row">
          <div class="col-md-12"> 
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
              <div class="portlet-title">
                <div class="caption">Product Specifications</div>
                <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
              </div>
              <div class="portlet-body">
                <div class="table-scrollable">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        
                        <th class="col-md-9"> Specification Name </th>
                        <th class="col-md-3"> Actions </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
						    
							if(count($product_pdf_details) > 0 && $product_pdf_details != '')
							{
						      foreach($product_pdf_details as $rows)
							  {
					  ?>
                      <tr>
                        
                        <td><?php echo $rows['spec_name'];?></td>
                        <td><a href="javascript:void(0);" class="btn default btn-xs purple" title="Edit" alt="Edit" onClick="edit_pdf(<?php echo $rows['product_id'];?>,<?php echo $rows['id'];?>)"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_pdf(<?php echo $rows['product_id'];?>,<?php echo $rows['id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a></td>
                      </tr>
                      <?php
							 }
					      }else{
						    echo '<tr><td colspan="2">No record found...!</td></tr>';
					        }
					  ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET--> 
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delete_record" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Delete</h4>
        </div>
        <div class="modal-body">
          Are you sure to delete this specification?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" id="yes">Yes</button>
        	<button type="button" class="btn default" id="no" data-dismiss="modal">No</button>
        </div>
    </div>
   </div>
</div>  
  
<div class="modal fade" id="coursepdf" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php $attributes = array('class' => 'horizontal-form', 'id' => 'myform_pdf');
			echo form_open_multipart('products/add_pdf_material',$attributes);
	 ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $product_details[0]['product_name'];?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="product_id" value="<?php echo $product_details[0]['pid'];?>" />
        <input type="hidden" name="pdf_id" value="" id="pdf_id"/>
        <input type="hidden" name="old_pdf" value="" id="old_pdf"/>
        <?php 
			  $spec_name = set_value('spec_name');				  
			  $data_spec_namef = array(
						  		 'name'         => 'spec_name',
								  'id'          => 'spec_name',
								  'value'       => $spec_name,
								  'class'		=> 'form-control',
								  'required'  => 'required',
								  'placeholder' => 'Specification Name'
								 );
		     ?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Specification Name<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_spec_namef); ?> </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">PDF<span class="required" aria-required="true"> *</span></label>
                <input type="file" name="specification_pdf" id="specification_pdf"/>
                <div id="pdf_url" style="display:none"><a href="" target="_blank"></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn green" value="Add" name="submit" id="mysubmit"/>
      </div>
    </div>
    <?php	
			echo form_fieldset_close(); 
			echo form_close();
     ?>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<!-- END PAGE CONTENT--> 
<script type="text/javascript">
function delete_pdf(product_id,pdf_id) //
{
	
	
	$('#delete_record #yes').click(function(){
	    var url = base_url+'products/delete_specification_pdf';
		 $.get(url,
		  {
			  product_id:product_id,
			  pdf_id:pdf_id
		  },function(responseText){		      
			  if(responseText == 1){
				   location.href = base_url+'products/manage_material/'+product_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}

</script>