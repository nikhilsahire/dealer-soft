<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage Purchase Orders</span></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
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
	
.input-medium {
    width: 200px !important;
}
 </style>
<!--<form class="form-inline">-->
<div class="col-md-9">
<?php  
       
	    	$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('purchase_orders/',$attributes);
				
			
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
  <input  type="submit" name="submit" value="Filter"   class="btn green"/>
  <input  type="submit" name="reset" value="Reset"   class="btn btn-wht"/>
  
       <?php	
			
			echo form_close();
		  ?>
  </div>
  <!--</form>-->
  <div class="col-md-3">
  <div class="form-group" style="float:right">
              <div class="btn-group">
                <a href="<?php echo base_url() ?>purchase_orders/add"><button id="sample_editable_1_new" class="btn green"> Add PO <i class="fa fa-plus"></i> </button></a>
				
			  </div>
            </div>
  </div>
 </div>
        </div>
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>              
              <th width="5%"> Order Number </th>
			  <th width="25%"> Supplier Name </th>
			  <th width="16%"> Firm Name </th>
			  <th width="12%"> Date</th>
			  <th width="15%"> Order By </th>	
			  <th width="10%"> PO Status </th> 
              <th width="12%"> Action </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$purchase_orders_cnt = count($purchase_orders);
				if($purchase_orders_cnt > 0)
				{ 
				  foreach($purchase_orders as $purchase_order )
				  {
				   
				   $class = 'green';
				   if($purchase_order['status'] == 'Open'){
				   	 $class = 'short';
				   }
			   ?>
                    <tr class="odd gradeX <?php echo $class; ?>" >
                      <td><a href="<?php echo base_url() ?>purchase_orders/view/<?php echo $purchase_order['purc_order_id'];?>" title="View" class="batch_details"> <?php echo $purchase_order['purc_order_number'];?></a></td>			   
                      <td><?php echo $purchase_order['supl_comp']; ?></td>
					  
					   <td><?php echo $purchase_order['firm_name']; ?></td>
					   <td><?php echo date('d M Y', strtotime($purchase_order['order_date']));?></td>
					   <td> <?php echo $purchase_order['first_name'].' '.$purchase_order['last_name'];?> </td>
					   <td> <?php echo $purchase_order['status'];?> </td>
					   <td>
					  <?php if($purchase_order['status'] == 'Open' ){ ?>
					  <a href="<?php echo base_url() ?>purchase_orders/edit/<?php echo $purchase_order['purc_order_id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>
					   
					  <a href="javascript:void(0)" onclick="close_order(<?php echo $purchase_order['purc_order_id'];?>)" class="btn default btn-xs red" title="Close Order" alt="Close Order"><i class="fa fa-trash-o"></i></a>					
					  <?php } ?>
					  <?php if($purchase_order['status'] == 'Confirmed' ){ ?>
					   
					  <a href="javascript:void(0)" onclick="close_order(<?php echo $purchase_order['purc_order_id'];?>)" class="btn default btn-xs red" title="Close Order" alt="Close Order"><i class="fa fa-trash-o"></i></a>
					   <a href="<?php echo base_url() ?>purchase_orders/create_prn/<?php echo $purchase_order['purc_order_id'] ?>" class="btn default btn-xs purple" title="Material Inward" alt="Material Inward"><i class="fa fa-suitcase"></i></a>					
					  <?php } ?>
					  <?php if($purchase_order['status'] != 'Closed' ){ ?>
					  <a href="<?php echo base_url() ?>purchase_orders/confirm_po/<?php echo base64UrlEncode($purchase_order['purc_order_number']).'/'.$purchase_order['purc_order_id'] ?>" class="btn default btn-xs purple" title="Confirm PO" alt="Confirm PO"><i class="fa fa-download "></i></a>
					  <?php } ?>
                      </td>
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

<div class="modal fade" id="close_order" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Close Order</h4>
        </div>
        <div class="modal-body">
			  Are you sure to close this order?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" id="yes">Yes</button>
        	<button type="button" class="btn default" id="no" data-dismiss="modal">No</button>
        </div>
    </div>
   </div>
</div>

<script type="text/javascript">
function close_order(orderId) //
{
	$('#close_order').modal();
	$('#close_order #yes').click(function(){
	    	
		var url = base_url+'purchase_orders/close_order';
		
		 $.post(url,
		  {
			  orderId:orderId,
		  },function(responseText){
			  if(responseText == 1){				  
				   location.href = base_url+'purchase_orders';
			  }else {
			  	alert('Something went wrong with you');
			  }
		  }
		 );
	      
	});
}

</script>