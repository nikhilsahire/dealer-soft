<?php $this->load->view('layouts/admin_header'); ?>
<div class="page-container">
   <!-- BEGIN SIDEBAR -->
    	<?php 
		
		if($this->session->userdata('userrole') == 'Sales'){
			$this->load->view('layouts/sales_sidebar');
		}else if($this->session->userdata('userrole') == 'Accounts'){
			$this->load->view('layouts/accounts_sidebar');
		}else if($this->session->userdata('userrole') == 'Purchase'){
			$this->load->view('layouts/purchase_sidebar');
		}else if($this->session->userdata('userrole') == 'Stores'){
			$this->load->view('layouts/stores_sidebar');
		}else if($this->session->userdata('userrole') == 'QC'){
			$this->load->view('layouts/qc_sidebar');
		}else {
			$this->load->view('layouts/admin_sidebar');
	    } ?> 
   <!-- END SIDEBAR MENU --> 
   <!-- BEGIN CONTENT --> 
   <div class="page-content-wrapper">
      <div class="page-content">  
        <?php //$this->load->view('layouts/admin_subheader'); ?>    
		<?php echo $template['body']; ?>
      </div>
   </div>     
   <!-- END CONTENT --> 
   <!-- BEGIN QUICK SIDEBAR -->
        <?php //$this->load->view('layouts/admin_quicksidebar'); ?> 
   <!-- END QUICK SIDEBAR -->  
</div> 
<?php $this->load->view('layouts/admin_footer'); ?> 