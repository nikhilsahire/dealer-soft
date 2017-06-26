<div class="page-bar">
				<?php echo $bredcrumbs;?>
				
			</div>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage <?php echo $pagetitle;?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group">
                <a href="<?php echo base_url();?>products/add"><button id="sample_editable_1_new" class="btn green"> Add New Product <i class="fa fa-plus"></i> </button></a>
              </div>
            </div>
            <!--<div class="col-md-6">
              <div class="btn-group pull-right">
                <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i> </button>
                <ul class="dropdown-menu pull-right">
                  <li> <a href="#"> Print </a> </li>
                  <li> <a href="#"> Save as PDF </a> </li>
                  <li> <a href="#"> Export to Excel </a> </li>
                </ul>
              </div>
            </div>-->
          </div>
        </div>
		<div class="alert alert-success" style="display:none;" id="delmsg">
        <span class="msg">msg</span>
        </div>
		 <?php if(isset($_SESSION['suc_msg'])){ ?> 
	 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
	  <?php echo $_SESSION['suc_msg'];
			 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
	  ?>
	</div>
	<?php } ?>
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
              
              <th width="15%"> Product code </th>
			  <th width="36%"> Product Name </th>
              <th width="15%"> Min Qty </th>
              <th width="15%"> In Stock </th> 
              <th width="12%"> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_product = count($product_details);
				if($count_product > 0)
				{ 
				  foreach($product_details as $row )
				  {
				   $inStock= round($row['inw_qty'] - $row['outw_qty'],3);
				   $class = $stockStr =  $bookedClass = $processClass = '';
				   if($row['min_qty'] > 0 && $inStock < $row['min_qty']){
				   	 $class = 'short';
				   }
				   if(sizeof($row['firm_stock']) > 0){
				   	  foreach($row['firm_stock'] as $fstock){
					  	$stockStr .= $fstock['firm_code'].':'.$fstock['Stock'].", ";
					  }
				   }
				   
				   
			   ?>
                    <tr class="odd gradeX <?php echo $class;?>">
                     
                      <td><a href="<?php echo base_url();?>products/view/<?php echo $row['pid'];?>" title="View" alt="View"><?php echo $row['item_code'];?></a></td>
					  <td><a href="<?php echo base_url();?>products/stock/<?php echo $row['pid'];?>" title="View" alt="View"><?php echo trim($row['product_name']);?></td>	  
                      <td><?php echo trim($row['min_qty']).' '.ucfirst(strtolower($row['prod_unit']));?></td>	  
                      <td> <a href="javascript:;" class="popovers" data-container="body" data-trigger="hover" data-content="<?php echo $stockStr; ?>" data-original-title="Firm Stock">  <?php echo number_format($inStock,2).' '.ucfirst(strtolower($row['prod_unit']));?> </a></td>
					 
                      <td>
					 <a href="<?php echo base_url();?>products/edit/<?php echo $row['pid'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a><a href="<?php echo base_url();?>products/manage_material/<?php echo $row['pid'];?>" alt="Add Details" title="Add Details" class="btn default btn-xs purple"><i class="fa fa-file-movie-o"></i></a>
					 <?php if($this->session->userdata('userrole') == 'Admin') {?>
					 <a href="<?php echo base_url();?>formulated/products/<?php echo $row['pid'];?>" alt="Child Products" title="Child Products" class="btn default btn-xs purple"><i class="fa fa-sitemap"></i></a>
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

    <script>
    $( document ).ready(function() {
        $('.booked_stock').click(function(){
			var pid = $(this).attr('data-id');
			$.ajax({
				url: SITE_URL+"products/get_product_orders/",
				type:'POST',
				data:{pid:pid},
				async:false,
				success: function(result){
				 // alert(result);
					$("#popup_title").html("Product Order Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});	
		});
		
		
		$('.process_stock').click(function(){
			var pid = $(this).attr('data-id');
			$.ajax({
				url: SITE_URL+"products/get_product_process_orders/",
				type:'POST',
				data:{pid:pid},
				async:false,
				success: function(result){
				 // alert(result);
					$("#popup_title").html("Purchase Order Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});	
		});
		
		
    });
 
   
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