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
		  <?php 			
			  if(isset($_SESSION['suc_msg'])){ ?> 
				 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
				  <?php echo $_SESSION['suc_msg'];
						 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
				  ?>
				</div>
				<?php } ?>
            <div class="col-md-6">
              <div class="btn-group">
                <a href="<?php echo base_url();?>supplier/add"><button id="sample_editable_1_new" class="btn green"> Add Supplier <i class="fa fa-plus"></i> </button></a>
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
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
             <!-- <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
              </th>
              <th> #ID </th>-->
              <th> Supplier Name </th>
              <th> Contact Person </th>
			  <th> Phone #</th>
              <th> Mobile # </th>
              <!--<th> State/City</th>-->
              <th> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_customer = count($suppliers_details);
				if($count_customer > 0)
				{ 
				  foreach($suppliers_details as $row )
				  {
					  
			?>
                    <tr class="odd gradeX">
                     <!-- <td><input type="checkbox" class="checkboxes" value="1"/></td>
                      <td><?php //echo $row['id']?></td>-->
                      <td><a href="<?php echo base_url();?>supplier/view/<?php echo $row['supl_id'];?>" ><?php echo $row['supl_comp'];?></a></td>
                      <td><?php echo trim($row['supl_conperson']);?></td>	  
                      <td><?php echo $row['supl_phone'];?> </td>
					  <td ><?php echo $row['supl_mobile'];?> </td>
					  <!--<td>< ?php echo $row['state'].'/'.$row['city'];?> </td>-->
                      <td width="10%">
                         <a href="<?php echo base_url();?>supplier/view/<?php echo $row['supl_id'];?>" class="btn default btn-xs purple" title="View" alt="View"> <i class="fa fa-eye"></i></a>
						<a href="<?php echo base_url();?>supplier/edit/<?php echo $row['supl_id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>
						<a href="<?php echo base_url();?>payment/supplier_transactions/<?php echo $row['supl_id'];?>" class="btn default btn-xs red" title="Transactions" alt="Transactions"><i class="fa fa-inr"></i></a>
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
<div class="modal fade" id="delete_record" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Delete</h4>
        </div>
        <div class="modal-body">
          Are you sure want delete?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" id="yes">Yes</button>
        	<button type="button" class="btn default" id="no" data-dismiss="modal">No</button>
        </div>
    </div>
   </div>
</div>