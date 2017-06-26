<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	/** 
	 * Customer Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
	  	parent::__construct();
		$this->load->model('suppliers_model');
		$this->load->model('user_model');
				
		$this->load->library('pagination');//load pagination library
		if (!is_admin_logged_in()) {
		   
            redirect('');
        } 
	}
	
	public function index()
	{
	
		if($this->session->userdata('userid') != "")
		{
			$data['suppliers_details'] = $this->suppliers_model->getAllSuppliers();
			$data['menutitle'] = 'Supplier';
			$data['pagetitle'] = 'Suppliers Listing';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Suppliers</li></ul>';
			 
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('suppliers/suppliers_list',$data); // customer_manage
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	/*
	View Client based on client Id
	*/
	
	public function view($supplier_id = 0)
	{
		
		if($supplier_id > 0){
			$data['menutitle'] = 'Supplier';
			$data['pagetitle'] = 'View Supplier';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'supplier/">Manage Supplier</a><i class="fa fa-angle-right"></i></li><li>View Supplier</li></ul>';
					
			$data['supplier_details'] = $this->suppliers_model->getSupplierInfo($supplier_id); 
			
			if($data != false)
			{
				$this->template->set_layout('admin_default')->build('suppliers/view_supplier',$data);
				//$this->load->view('clients/view_client',$data);
						
			}
		
		}else {
				redirect('supplier');
		}	
		
	}
	
	public function add()
	{
		$data['menutitle'] = 'Supplier';
			$data['pagetitle'] = 'Add Supplier';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'supplier/">Manage Supplier</a><i class="fa fa-angle-right"></i></li><li>Add Supplier</li></ul>';
		
		
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('suppliers/add_supplier',$data);
		}elseif(trim($this->input->post('submit')) == 'Add Supplier')
		{ 
			$this->form_validation->set_rules('supl_comp', 'Supplier Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('supl_phone', 'Phone Number', 'trim|required|max_length[12]');
			$this->form_validation->set_rules('gstin_num', 'GSTin Number', 'trim|required|max_length[25]');
			//$this->form_validation->set_rules('supl_email', 'Email', 'trim|required|max_length[100]|valid_email');
			//$this->form_validation->set_rules('supl_city', 'City', 'trim|required');
			$this->form_validation->set_rules('supl_conperson', 'Contact Person', 'trim|required');
			//$this->form_validation->set_rules('supl_mobile', 'Mobile Number', 'trim|required|max_length[15]');
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 
				 $this->template->set_layout('admin_default')->build('suppliers/add_supplier',$data);
		     } 
			 else
			 {
				 
				 $data_insert = array();
				 $data_insert['supl_comp'] = trim($this->input->post('supl_comp'));
				 $data_insert['supl_conperson'] = trim($this->input->post('supl_conperson'));
				 $data_insert['supl_phone'] = trim($this->input->post('supl_phone'));
				 $data_insert['supl_mobile'] = trim($this->input->post('supl_mobile'));
				 $data_insert['supl_email'] = trim($this->input->post('supl_email'));
				 $data_insert['supl_website'] = trim($this->input->post('supl_website'));
				 $data_insert['supl_city'] = trim($this->input->post('supl_city'));
				 $data_insert['supl_address'] = trim($this->input->post('supl_address'));
				 $data_insert['tin_num'] = trim($this->input->post('tin_num'));
				 $data_insert['pan_no'] = trim($this->input->post('pan_no'));				 
				 $data_insert['vat_no'] = trim($this->input->post('vat_no'));
				 $data_insert['cst_no'] = trim($this->input->post('cst_no'));
				 $data_insert['gstin_num'] = trim($this->input->post('gstin_num'));
				 $data_insert['excise_no'] = trim($this->input->post('excise_no'));
				 $data_insert['special_comment'] = trim($this->input->post('special_comment'));
				 $data_insert['is_deleted'] = trim($this->input->post('is_deleted'));				 
				 $data_insert['updated_by'] = $this->session->userdata('userid');
				 $data_insert['updated_date'] = date('Y-m-d');
				 				 
				 $id = $this->suppliers_model->addSupplier($data_insert);
				 if($id > 0){
				  $arr_msg = array('suc_msg'=>'Supplier added successfully!!!','msg-type'=>'success');
				 }else{
					 $arr_msg = array('suc_msg'=>'Failed to add Supplier','msg-type'=>'danger');
				 }
				 
				 $this->session->set_userdata($arr_msg);
				 redirect('supplier');
			 }
		}
	}
	
	
	public function edit($supplier_id = 0)
	{
	  if($supplier_id > 0){
		$data['menutitle'] = 'Supplier';
		$data['pagetitle'] = 'Edit Supplier';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'supplier/">Manage Supplier</a><i class="fa fa-angle-right"></i></li><li>Edit Supplier</li></ul>';
		
		// get supplier information
		$data['supplier_details'] = $this->suppliers_model->getSupplierInfo($supplier_id); 
				
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('suppliers/edit_supplier',$data);
		}elseif(trim($this->input->post('submit')) == 'Edit Supplier')
		{ 
			$this->form_validation->set_rules('supl_comp', 'Supplier Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('supl_phone', 'Phone Number', 'trim|required|max_length[12]');
			$this->form_validation->set_rules('gstin_num', 'GSTin Number', 'trim|required|max_length[25]');
			//$this->form_validation->set_rules('supl_email', 'Email', 'trim|required|max_length[100]|valid_email');
			//$this->form_validation->set_rules('supl_city', 'City', 'trim|required');
			$this->form_validation->set_rules('supl_conperson', 'Contact Person', 'trim|required');
			//$this->form_validation->set_rules('supl_mobile', 'Mobile Number', 'trim|required|max_length[15]');
					
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 
				 $supplier_details['supl_comp'] = trim($this->input->post('supl_comp'));
				 $supplier_details['supl_conperson'] = trim($this->input->post('supl_conperson'));
				 $supplier_details['supl_phone'] = trim($this->input->post('supl_phone'));
				 $supplier_details['supl_mobile'] = trim($this->input->post('supl_mobile'));
				 $supplier_details['supl_email'] = trim($this->input->post('supl_email'));
				 $supplier_details['supl_website'] = trim($this->input->post('supl_website'));
				 $supplier_details['supl_country'] = trim($this->input->post('supl_country'));
				 $supplier_details['supl_state'] = trim($this->input->post('supl_state'));
				 $supplier_details['supl_district'] = trim($this->input->post('supl_district'));
				 $supplier_details['supl_city'] = trim($this->input->post('supl_city'));
				 $supplier_details['supl_address'] = trim($this->input->post('supl_address'));
				
				 $supplier_details['tin_num'] = trim($this->input->post('tin_num'));
				  $supplier_details['gstin_num'] = trim($this->input->post('gstin_num'));
				 $supplier_details['pan_no'] = trim($this->input->post('pan_no'));				 
				 $supplier_details['vat_no'] = trim($this->input->post('vat_no'));
				 $supplier_details['cst_no'] = trim($this->input->post('cst_no'));
				 $supplier_details['excise_no'] = trim($this->input->post('excise_no'));
				 $supplier_details['special_comment'] = trim($this->input->post('special_comment'));
				 $supplier_details['other_products'] = trim($this->input->post('other_products'));
				 
				 $supplier_details['is_deleted'] = trim($this->input->post('is_deleted'));
				 $supplier_details['supl_id'] = trim($supplier_id);
					 
				 $data['supplier_details'][0] = $supplier_details;
				 $this->template->set_layout('admin_default')->build('suppliers/edit_supplier',$data);
		     } 
			 else
			 {
				 
				 $data_update = array();
				 $data_update['supl_comp'] = trim($this->input->post('supl_comp'));
				 $data_update['supl_conperson'] = trim($this->input->post('supl_conperson'));
				 $data_update['supl_phone'] = trim($this->input->post('supl_phone'));
				 $data_update['supl_mobile'] = trim($this->input->post('supl_mobile'));
				 $data_update['supl_email'] = trim($this->input->post('supl_email'));
				 $data_update['supl_website'] = trim($this->input->post('supl_website'));
				 $data_update['supl_country'] = trim($this->input->post('supl_country'));
				 $data_update['supl_state'] = trim($this->input->post('supl_state'));
				 $data_update['supl_district'] = trim($this->input->post('supl_district'));
				 $data_update['supl_city'] = trim($this->input->post('supl_city'));
				 $data_update['supl_address'] = trim($this->input->post('supl_address'));
				 $data_update['tin_num'] = trim($this->input->post('tin_num'));
				 $data_update['gstin_num'] = trim($this->input->post('gstin_num'));
				 $data_update['pan_no'] = trim($this->input->post('pan_no'));				 
				 $data_update['vat_no'] = trim($this->input->post('vat_no'));
				 $data_update['cst_no'] = trim($this->input->post('cst_no'));
				 $data_update['excise_no'] = trim($this->input->post('excise_no'));
				 $data_update['special_comment'] = trim($this->input->post('special_comment'));
				 $data_update['other_products'] = trim($this->input->post('other_products'));
				 
				 $data_update['is_deleted'] = trim($this->input->post('is_deleted'));				 
				 $data_update['updated_by'] = $this->session->userdata('userid');
				 $data_update['updated_date'] = date('Y-m-d');
				 				 
				 $id = $this->suppliers_model->updateSupplier($data_update,$supplier_id);
				 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Supplier added successfully!!!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to add Supplier','msg-type'=>'danger');
					 }
				 $this->session->set_userdata($arr_msg);				 
				 redirect('supplier/edit/'.$supplier_id);
			 }
		}
		
	  }else {
	  	redirect('supplier');
	  }
	}
	
	

	
	
	
	
}
