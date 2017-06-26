<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Stock of <?php echo $product_details[0]['product_name'];?> is <span style="color:#D64635;text-decoration: underline;"><?php echo $total_stock.' '.$product_details[0]['prod_unit']; ?></span></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          
		  <div class="filter-form hidden-xs">
 <style>
 .form-inline .input-parent {
  display: inline-block;
}
.filter-form .form-control {
  background-color: #fff;
  border:1px solid #979797 !important;
  background-image: none !important;
  
}
.beatpicker-clear beatpicker-clearButton button{ display:none !important;
	}
 </style>
<!--<form class="form-inline">-->
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
<div class="col-md-12">
<?php  
       
	    	$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('products/stock/'.$product_details[0]['pid'],$attributes);
				
			
			 ?>

  <div class="form-group">
       <label class="control-label">From</label>
                  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
				  <input type="text" class="form-control" id="fromdate" name="fromdate" required="required" value="<?php echo $sdate; ?>" readonly >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>
  </div>
  
  <div class="form-group">
  <label class="control-label">To</label>
                  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
				  <input type="text" class="form-control" id="todate" name="todate" required="required" value="<?php echo $todate; ?>" readonly >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>

  </div>
  <div class="form-group">
       <label class="control-label">Firm</label>
                 <?php echo form_dropdown('firm_id[]',$firmList,$firm_id,'class="form-control select2me" tabindex="0" placeholder= "Select Firmd" required="required" id="prod_1"');?> 
  </div>
  <div class="form-group">
  <input  type="submit" name="submit" value="Filter"   class="btn green"/>
  <input  type="submit" name="reset" value="Reset"   class="btn btn-wht"/>
  </div>
  <?php if($this->session->userdata('userid')== 1 || $this->session->userdata('userid')== 2){ ?>
	<div class="form-group" style="float:right">              
                <a href="<?php echo base_url();?>formulated/formulated_stock/<?php echo $product_details[0]['pid'];?>" class="btn green">Formulate Stock <i class="fa fa-plus"></i> </button></a>
				<a href="<?php echo base_url();?>products/add_stock/<?php echo $product_details[0]['pid'];?>"  class="btn green">Add Stock <i class="fa fa-plus"></i></a>
            </div>
	<?php } ?>
  </div>
       <?php	
			
			echo form_close();
		  ?>
	
  <!--</form>-->
  
 </div>
        </div>
		
		<?php 
			  if(isset($suc_msg) && $suc_msg!=''){ ?> 
				 <div class="alert alert-success">
				  <?php echo $suc_msg;?>
				</div>
        	<?php } ?>
		 
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>              
             
			  <th> Date</th>
              <th> Client/Supplier</th>
              <th> Invoice </th>
              <th> Inward </th>
			  <th> Outward </th>
			  
			  <?php if($this->session->userdata('userrole') == 'Admin'){ ?>
			  <th> Rate </th>
              <th> Amount </th>
			  <th > Action </th>
			  <?php } ?>
			  
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_stock = count($product_stock);
				if($count_stock > 0)
				{ 
				  foreach($product_stock as $stock_row )
				  {
				   
				   $class = 'short';
				   if($stock_row['inw_qty'] == 0.00){
				   	 $class = 'green';
					 
				   }
			   ?>
                    <tr class="odd gradeX <?php echo $class; ?>" >
                      
					  <td><?php echo date('d M Y',strtotime($stock_row['on_date']));?></td>	  
                      <td><?php 
					  		if($stock_row['comp_id'] == 0){
								$supplierData = $this->suppliers_model->getSupplierInfo($stock_row['su_id']); echo $supplierData[0]['supl_comp']; 
							}else{
								$clientData = $this->clients_model->getClientInfo($stock_row['comp_id']); echo $clientData[0]['comp_name']; 
							}
					  		
					  
					  ?></td>
					  <td><?php echo $stock_row['invoice_no']; ?></td>
					   <td><?php echo $stock_row['inw_qty']; ?></td>
					   <td><?php echo $stock_row['outw_qty']; ?></td>
					   
					   
					   <?php if($this->session->userdata('userrole') == 'Admin'){ ?>
					   <td><?php echo $stock_row['rate']; ?></td>
					   <td><?php echo number_format($stock_row['amount'],2); ?></td>	                     
					  <td>
					  <?php if($stock_row['inw_qty'] > 0 ){ ?>
					  <a href="<?php echo base_url();?>products/create_child_batch/<?php echo $stock_row['lot_no']?>/<?php echo $stock_row['pid'];?>" class="btn default btn-xs purple" title="Create Batch" alt="Create Batch"> <i class="fa fa-clipboard"></i></a><a href="<?php echo base_url();?>products/add_packing/<?php echo $stock_row['lot_no']?>/<?php echo $stock_row['pid'];?>" alt="Add Packing Material" title="Add Packing Material" class="btn default btn-xs purple"><i class="fa fa-plus-square "></i></a>
					  <?php }?>
                      </td>
					  <?php } ?>
					  
                    </tr>
            <?php
				 }
			}?>
			
			<?php 
				// echo '<pre>'; print_r($product_stock_old);
				$count_stock_old = count($product_stock_old);
				if($count_stock_old > 0)
				{ 
				  foreach($product_stock_old as $stock_old_row )
				  {
				   
				   $class = 'short';
				   if($stock_old_row['inw_qty'] == 0.00){
				   	 $class = 'green';
					 
				   }
			   ?>
                    <tr class="odd gradeX <?php echo $class; ?>" >
                      
					  <td><?php echo date('d M Y',strtotime($stock_old_row['on_date']));?></td>	  
                      <td><?php 
					  		if($stock_old_row['comp_id'] == 0){
								$supplierData = $this->suppliers_model->getSupplierInfo($stock_old_row['su_id']); echo $supplierData[0]['supl_comp']; 
							}else{
								$clientData = $this->clients_model->getClientInfo($stock_old_row['comp_id']); echo $clientData[0]['comp_name']; 
							}
					  		
					  
					  ?></td>
					  <td><?php echo $stock_old_row['invoice_no']; ?></td>
					   <td><?php echo $stock_old_row['inw_qty']; ?></td>
					   <td><?php echo $stock_old_row['outw_qty']; ?></td>
						<?php if($this->session->userdata('userrole') == 'Admin'){ ?>
					   <td><?php echo $stock_old_row['rate']; ?></td>
					   <td><?php echo number_format($stock_old_row['amount'],2); ?></td>	                    
					  <td>
					 <?php if($stock_old_row['inw_qty'] > 0 ){ ?>
					  <a href="<?php echo base_url();?>products/create_child_batch/<?php echo $stock_old_row['lot_no']?>/<?php echo $stock_old_row['pid'];?>" class="btn default btn-xs purple" title="Create Batch" alt="Create Batch"> <i class="fa fa-clipboard"></i></a><a href="<?php echo base_url();?>products/add_packing/<?php echo $stock_old_row['lot_no']?>/<?php echo $stock_old_row['pid'];?>" alt="Add Packing Material" title="Add Packing Material" class="btn default btn-xs purple"><i class="fa fa-plus-square "></i></a>
					  <?php } ?>
                      </td>
					  <?php } ?>
                    </tr>
            <?php
				 }
			}?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<script type="text/javascript">

$(document).ready(function() {
   $('.batch_details').click(function () {
   		var lot_no = $(this).attr('id');
		$.ajax({
				url: SITE_URL+"products/batch_details/",
				data: { 
					"lot_no": lot_no
				}, 
				type:'POST',
				async:false,
				success: function(result){
					$("#popup_title").html("Batch Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});		
			
    });
})


</script>
<div id="ajax1">
	<div id="appts_popup" class="modal fade" tabindex="-1" data-width="400">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:closePopup()"></button>
				<h4 class="modal-title" ><b id="popup_title"></b></h4>
			</div>
			<div id="appts-details" class="modal-body row" style="padding:3%;"></div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn" 	onclick="javascript:closePopup()">Close</button>
			</div>
		</div>
	</div>	
	</div>
</div>