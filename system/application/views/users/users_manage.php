<div class="page-bar">
<?php //echo '<pre>'; print_r($arr_msg); die();?>
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
                <a href="<?php echo base_url();?>users/add"><button id="sample_editable_1_new" class="btn green"> Add New User <i class="fa fa-plus"></i> </button></a>
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
		 
			<?php 			
			  if(isset($_SESSION['suc_msg'])){ ?> 
				 <div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
				  <?php echo $_SESSION['suc_msg'];
						 unset($_SESSION['suc_msg']); unset($_SESSION['msg-type']);
				  ?>
				</div>
				<?php } ?>
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
              
              <th> Name </th>
			  <th> Email </th>
              <th> Phone # </th>
              <th> Role </th>
			  <th> Status </th>
              <th> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_customer = count($customer_details);
				if($count_customer > 0)
				{ 
				  foreach($customer_details as $row )
				  {
			   ?>
                    <tr class="odd gradeX">
                     <!-- <td><?php //echo $row['id']?></td>-->
                      <td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
					  <td><?php echo trim($row['email']);?></td>	  
                      <td><?php echo trim($row['phone_number']);?></td>	  
                      <td> <?php echo trim($row['user_role']);?></td>
					  <td> <?php echo trim($row['user_status']);?></td>
                      <td>
					  <a href="<?php echo base_url();?>users/view/<?php echo $row['uid'];?>" class="btn default btn-xs purple" title="View" alt="View"> <i class="fa fa-eye"></i></a>&nbsp;&nbsp;
                        <a href="<?php echo base_url();?>users/edit/<?php echo $row['uid'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<!--<a class="btn default btn-xs red del" href="javascript:void(0)" id="<?php echo $row['uid'];?>" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a>&nbsp;&nbsp;-->
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
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/users.js"></script>