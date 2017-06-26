<link href="<?php echo $this->config->item("base_url_asset")?>/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="icon-users"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php //echo $total_customers;?>
							</div>
							<div class="desc">
								 Customers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>client">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="icon-docs"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php //echo $total_courses;?>
							</div>
							<div class="desc">
								 Suppliers
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>supplier">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="icon-briefcase"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php //echo $total_bundle; ?>
							</div>
							<div class="desc">
								Reports
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>payment/sales_statement">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="icon-basket-loaded"></i>
						</div>
						<div class="details">
							<div class="number">
								 
							</div>
							<div class="desc">
								 Invoices
							</div>
						</div>
						<a class="more" href="<?php echo base_url();?>orders/index/tax">
						View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
			<div class="clearfix"></div>
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
					<div class="portlet light tasks-widget">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-share font-green-haze hide"></i>
								<span class="caption-subject font-green-haze bold uppercase">Notifications</span>
								<span class="caption-helper"><!--tasks summary...--></span>
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="task-content">
								<div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="1">
									<!-- START TASK LIST -->
									<ul class="task-list">
									  <?php if(sizeof($notifications) > 0){ 
									      foreach( $notifications as $notification){
									  ?>
										<li id="notif_<?php echo $notification['id']; ?>">
											
											<div class="task-title">
												<span class="task-title-sp"><?php echo $notification['first_name'].' '.$notification['last_name'].', '.$notification['message_text'];?> </span>
												
											</div>
											<div class="task-config">
												<div class="task-config-btn btn-group">
													<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
													<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
													</a>
													<ul class="dropdown-menu pull-right">
														<li>
															<a href="javascript:;" class="markread" id="rem_<?php echo $notification['id']; ?>"><i class="fa fa-check"></i> Mark As Read </a>
														</li>														
													</ul>
												</div>
											</div>
										</li>
									  <?php 
									    } // EO foreach 
									  } else { ?> 
									  <li ><div class="task-title">
												No Records Found !!!
											</div>
										</li>
									  
									  <?php  } ?>	
									</ul>
									<!-- END START TASK LIST -->
								</div>
							</div>
							<div class="task-footer">
								<div class="btn-arrow-link pull-right">
									&nbsp;
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
					<div class="portlet light tasks-widget">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-share font-green-haze hide"></i>
								<span class="caption-subject font-green-haze bold uppercase">Pending Invoice Payments</span>
								<span class="caption-helper"><!--tasks summary...--></span>
							</div>
							
						</div>
						<div class="portlet-body">
							<div class="task-content">
								<table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>              
              
			  <th width="30%"> Client Name </th>
			  <th width="15%"> Contact Number </th>
			  <th width="15%"> Invoice Number</th>
			  <th width="15%"> Invoice Amount</th>
			  <th width="15%"> Due Date </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_transactions = count($overDueInvoices);
				if($count_transactions > 0)
				{ 
				  foreach($overDueInvoices as $transactionInv )
				  {
				   
				   
			   ?>
                    <tr class="odd gradeX " >
						<td><a href="<?php echo base_url()?>payment/transactions/<?php echo $transactionInv['comp_id']; ?>"><?php echo $transactionInv['comp_name']; ?></a></td> 
						<td><?php echo $transactionInv['primary_phone']; ?></td>	  
						<td><?php echo $transactionInv['invoice_number']; ?></td>
						<td><?php echo number_format($transactionInv['invoice_amount'],2); ?></td>
						<td><?php echo $transactionInv['reminder_date']; ?></td>
					   
                    </tr>
            <?php
				 }
			}?>
          </tbody>
        </table>
							</div>
							<div class="task-footer">
								<div class="btn-arrow-link pull-right">
									&nbsp;
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			
<script type="text/javascript">
$( document ).ready(function(){
    $('.markread').click(function(){
		var id = $(this).attr('id');
		var notif_id = id.substring(4);
		$.ajax({
				url: SITE_URL+"users/markasread/",
				data: { 
					"id": notif_id,
					"action": 'update'
				}, 
				type:'POST',
				async:false,
				success: function(result){
				   // alert(result);
					if(result == 1){
						$("#notif_"+notif_id).remove();
					}else{
						alert('Something went wrong with you...');
					}
				}
			});	
	});
});
</script>