<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu page-sidebar-menu-closed" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
				<li class="sidebar-search-wrapper">
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
					<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
					<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<li class="start <?php if(isset($menutitle) && $menutitle == 'Dashboard'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php echo base_url();?>index_con">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Dashboard'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
				</li>
				<li class="<?php if(isset($menutitle) && $menutitle == 'Invoices'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
						<i class="icon-basket-loaded"></i>
						<span class="title">Invoices</span>	
						<span class="arrow "></span>				
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php  echo base_url();?>orders/add/tax">Add Invoice</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>orders/index/tax"> Tax Invoices</a>
						</li>
					</ul>
				</li>
				<li class="<?php if(isset($menutitle) && $menutitle == 'Products'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php echo base_url();?>products">
					<i class="icon-users"></i>
					<span class="title">Products</span>
					</a>					
				</li>
				
				
				<li class="<?php if(isset($menutitle) && $menutitle == 'Client'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php echo base_url();?>client">
					<i class="icon-users"></i>
					<span class="title">Clients</span>
					</a>					
				</li>
				
				<li class="<?php if(isset($menutitle) && $menutitle == 'Supplier'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php echo base_url();?>supplier">
					<i class="fa fa-users"></i>
					<span class="title">Suppliers</span>
					<span class="arrow <?php if(isset($menutitle) && $menutitle == 'Supplier'){ echo 'open';}else{ echo '';}?>"></span>
					</a>
					
				</li>
				<li class="<?php if(isset($menutitle) && $menutitle == 'Purchase Orders'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php echo base_url();?>purchase_orders">
					<i class="icon-user"></i>
					<span class="title">Purchase Orders</span>
					
					</a>
					
				</li>
				<!--<li class="<?php //if(isset($menutitle) && $menutitle == 'Employees'){ echo 'active open';}else{ echo '';}?>">
					<a href="<?php // echo base_url();?>workers">
					<i class="icon-users"></i>
					<span class="title">Employees</span>
					</a>					
				</li>
				<li class="<?php //if(isset($menutitle) && $menutitle == 'Attendance'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
						<i class="fa fa-calendar"></i>
						<span class="title">Attendance</span>	
						<span class="arrow "></span>				
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php //echo base_url();?>attendance">Today's Attendance</a>
						</li>
						<li>
							<a href="<?php //echo base_url();?>attendance/edit">Update Attendance</a>
						</li>
					</ul>
				</li>-->
				<li class="<?php if(isset($menutitle) && $menutitle == 'Reports'){ echo 'active open';}else{ echo '';}?>">
					<a href="javascript:;">
						<i class="fa fa-calendar"></i>
						<span class="title">Reports</span>	
						<span class="arrow "></span>				
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo base_url();?>payment/sales_statement">Sales Statement</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>payment/purchase_statement">Purchase Statement</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>payment/hsn_statement">HSN Statement</a>
						</li>
						<li>
							<a href="<?php echo base_url();?>payment/client_due_payments">Client Pendning Amount</a>
						</li>
						<!--<li>
							<a href="<?php // echo base_url();?>attendance/edit">Pending Invoices</a>
						</li>-->
					</ul>
				</li>
			</ul>
            
		</div>
	</div>