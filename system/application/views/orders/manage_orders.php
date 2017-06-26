<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage <?php echo ucwords($order_type)?> Invoices</span></div>
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
 </style>
<!--<form class="form-inline">-->
<div class="col-md-12">
<?php  
       
	    	$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('orders/index/'.$order_type,$attributes);
				
			
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
  <div class="col-md-12">
  	<div class="form-group" style="float:right">
              <div class="btn-group">
                <a href="<?php echo base_url();?>orders/add/<?php echo $order_type?>"><button id="sample_editable_1_new" class="btn green"> Create Invoices <i class="fa fa-plus"></i> </button></a>
				
			  </div>
            </div>
  </div>
  <!--</form>-->
 
 </div>
        </div>
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>              
              <th width="10%"> Invoice Date </th>
			  <th width="25%"> Customer Name </th>
			  <th width="15%"> Invoice No</th>
              <th width="15%"> View Challan </th>
              <th width="10%"> Order Total </th>
			  <th width="10%"> Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_orders = count($orders);
				if($count_orders > 0)
				{ 
				  foreach($orders as $order_row )
				  {
				   
				   $class = 'green';
				   if($order_row['order_status'] == 'Pending'){
				   	 $class = 'short';
				   }
			   ?>
                    <tr class="odd gradeX <?php echo $class; ?>" >
                      <td><?php echo $order_row['order_date'];?></td>			   
                      <td><?php echo $order_row['comp_name']; ?></td>
					  <td><a href="<?php echo base_url()?>orders/view_invoice/<?php echo strtolower($order_row['order_type']).'/'.$order_row['order_id'] ?>">
							<?php echo $order_row['invoice'] ?>
						 </a>
					  </td>	 
					   <td>
						   <a href="<?php echo base_url()?>orders/view_challan/<?php echo strtolower($order_row['order_type']).'/'.$order_row['order_id'] ?>"><?php echo $order_row['chalans'] ?></a>
						</td>
					   <td><?php echo $order_row['orderTotal']; ?></td>
					   <td><?php if($order_row['order_status'] == 'Pending'){ ?>
					  <a href="<?php echo base_url();?>orders/edit/<?php echo $order_row['order_id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>
					  <a href="javascript:void(0)" onclick="close_order(<?php echo $order_row['order_id'];?>)" class="btn default btn-xs red" title="Close Order" alt="Close Order"><i class="fa fa-trash-o"></i></a>
					  <?php   } ?></td>
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