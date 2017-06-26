<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

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
		$this->load->model('clients_model');
		$this->load->model('user_model');
		//$this->load->model('product_model');
		$this->load->model('payments_model');
		
		$this->load->library('pagination');//load pagination library
		if (!is_admin_logged_in()) {
		   
            redirect('');
        } 
	}
	
	public function index()
	{
	
		if($this->session->userdata('userid') != "")
		{
			$data['customer_details'] = $this->clients_model->getAllClients();
			$data['menutitle'] = 'Client';
			$data['pagetitle'] = 'Clients Listing';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Clients</li></ul>';
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('clients/clients_list',$data); // customer_manage
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add()
	{
		$data['menutitle'] = 'Client';
		$data['pagetitle'] = 'Add Client';
			
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'client/">Manage Client</a><i class="fa fa-angle-right"></i></li><li>Add Client</li></ul>';
		
		
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('clients/add_client',$data);
		}elseif(trim($this->input->post('submit')) == 'Add Client')
		{ 
			$this->form_validation->set_rules('comp_name', 'Company Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('primary_contact', 'Primary Contact', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('primary_phone', 'Primary Phone', 'trim|required|max_length[12]');
			$this->form_validation->set_rules('primary_mobile', 'Primary Mobile', 'trim|max_length[12]');
			$this->form_validation->set_rules('gstin_num', 'GST in Number', 'trim|required|max_length[50]');
			// $this->form_validation->set_rules('primary_email', 'Primary Email', 'trim|required|max_length[100]|valid_email');
			
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 
				  	 $client_details['comp_name'] = trim($this->input->post('comp_name'));
					 $client_details['status'] = trim($this->input->post('status'));
					 
					 $client_details['primary_contact'] = trim($this->input->post('primary_contact'));
					 $client_details['primary_phone'] = trim($this->input->post('primary_phone'));
					 $client_details['primary_mobile'] = trim($this->input->post('primary_mobile'));
					 $client_details['primary_email'] = trim($this->input->post('primary_email'));
					 $client_details['city'] = trim($this->input->post('city'));
					 $client_details['shipping_address'] = trim($this->input->post('shipping_address'));
					 					 			 
					 $client_details['gstin_num'] = trim($this->input->post('gstin_num'));
					 $client_details['tin_num'] = trim($this->input->post('tin_num'));
					 $client_details['vat_no'] = trim($this->input->post('vat_no'));
					 $client_details['excise_no'] = trim($this->input->post('excise_no'));
					 $client_details['cst_no'] = trim($this->input->post('cst_no'));
					 $client_details['pan_no'] = trim($this->input->post('pan_no'));
					 $client_details['notes'] = trim($this->input->post('notes'));
					 $client_details['other_information'] = trim($this->input->post('other_information'));
					 					 			 
					 $data = $client_details;
				 $this->template->set_layout('admin_default')->build('clients/add_client',$data);
		     } 
			 else
			 {
				 $data_insert = array();
				 $data_insert['comp_name'] = trim($this->input->post('comp_name'));
				 $data_insert['status'] = trim($this->input->post('status'));
				 
				 $data_insert['primary_contact'] = trim($this->input->post('primary_contact'));
				 $data_insert['primary_phone'] = trim($this->input->post('primary_phone'));
				 $data_insert['primary_mobile'] = trim($this->input->post('primary_mobile'));
				 $data_insert['primary_email'] = trim($this->input->post('primary_email'));
				 $data_insert['city'] = trim($this->input->post('city'));
				 $data_insert['shipping_address'] = trim($this->input->post('shipping_address'));
							 		 
				 $data_insert['tin_num'] = trim($this->input->post('tin_num'));
				 $data_insert['gstin_num'] = trim($this->input->post('gstin_num'));
				 $data_insert['vat_no'] = trim($this->input->post('vat_no'));
				 $data_insert['excise_no'] = trim($this->input->post('excise_no'));
				 $data_insert['cst_no'] = trim($this->input->post('cst_no'));
				 $data_insert['pan_no'] = trim($this->input->post('pan_no'));
				 $data_insert['notes'] = trim($this->input->post('notes'));
				 $data_insert['other_information'] = trim($this->input->post('other_information'));
				 $data_insert['handling_person'] = trim($this->input->post('handling_person'));
				 
				 $data_insert['updated_by'] = $this->session->userdata('userid');
				 $data_insert['updated_date'] = date('Y-m-d');
				 				 
				 $id = $this->clients_model->addClient($data_insert);
				
			    if($id > 0){
					 $arr_msg = array('suc_msg'=>'Client added successfully!','msg-type'=>'success');
				 }else{
					 $arr_msg = array('suc_msg'=>'Failed to added client','msg-type'=>'danger');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('client');
			 }
		}
	}
	
	
	/*
	Edit Client based on client Id
	*/
	
	public function edit($client_id = 0)
	{
		
		if($client_id > 0){
			$data['menutitle'] = 'Client';
			$data['pagetitle'] = 'Edit Client';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'client/">Manage Client</a><i class="fa fa-angle-right"></i></li><li>Edit Client</li></ul>';
			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			// get list of sales team
			
			$data['client_details'] = $this->clients_model->getClientInfo($client_id);
			
					
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('clients/edit_client',$data);
			}elseif(trim($this->input->post('submit')) == 'Edit Client')
			{ 
			
				$this->form_validation->set_rules('comp_name', 'Company Name', 'trim|required|max_length[100]');
				$this->form_validation->set_rules('primary_contact', 'Primary Contact', 'trim|required|max_length[30]');
				$this->form_validation->set_rules('primary_phone', 'Primary Phone', 'trim|required|max_length[12]');
				$this->form_validation->set_rules('primary_mobile', 'Primary Mobile', 'trim|max_length[12]');
				$this->form_validation->set_rules('gstin_num', 'GST in Number', 'trim|required|max_length[50]');
				// $this->form_validation->set_rules('primary_email', 'Primary Email', 'trim|required|max_length[100]|valid_email');
				
				
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  
					 $client_details['comp_name'] = trim($this->input->post('comp_name'));				 
					 $client_details['status'] = trim($this->input->post('status'));					 
					 $client_details['primary_contact'] = trim($this->input->post('primary_contact'));
					 $client_details['primary_phone'] = trim($this->input->post('primary_phone'));
					 $client_details['primary_mobile'] = trim($this->input->post('primary_mobile'));
					 $client_details['primary_email'] = trim($this->input->post('primary_email'));
					 $client_details['primary_fax'] = trim($this->input->post('primary_fax'));
					 $client_details['city'] = trim($this->input->post('city'));
					 $client_details['shipping_address'] = trim($this->input->post('shipping_address'));				 
					 $client_details['tin_num'] = trim($this->input->post('tin_num'));
					 $client_details['gstin_num'] = trim($this->input->post('gstin_num'));
					 $client_details['vat_no'] = trim($this->input->post('vat_no'));
					 $client_details['excise_no'] = trim($this->input->post('excise_no'));
					 $client_details['cst_no'] = trim($this->input->post('cst_no'));
					 $client_details['pan_no'] = trim($this->input->post('pan_no'));
					 $client_details['notes'] = trim($this->input->post('notes'));
					 $client_details['other_information'] = trim($this->input->post('other_information'));					 	
					 		
					 $client_details['comp_id'] = trim($client_id);
					 
					$data['client_details'][0] = $client_details;
					$this->template->set_layout('admin_default')->build('clients/edit_client',$data);
				 }
				 else
				 {
					 
					 $data_insert['comp_name'] = trim($this->input->post('comp_name'));
					
					 $data_insert['status'] = trim($this->input->post('status'));
					 
					 $data_insert['primary_contact'] = trim($this->input->post('primary_contact'));
					 $data_insert['primary_phone'] = trim($this->input->post('primary_phone'));
					 $data_insert['primary_mobile'] = trim($this->input->post('primary_mobile'));
					 $data_insert['primary_email'] = trim($this->input->post('primary_email'));
					 $data_insert['primary_fax'] = trim($this->input->post('primary_fax'));
					 $data_insert['city'] = trim($this->input->post('city'));
					 $data_insert['shipping_address'] = trim($this->input->post('shipping_address'));					 
					 $data_insert['tin_num'] = trim($this->input->post('tin_num'));
					 $data_insert['gstin_num'] = trim($this->input->post('gstin_num'));
					 $data_insert['vat_no'] = trim($this->input->post('vat_no'));
					 $data_insert['excise_no'] = trim($this->input->post('excise_no'));
					 $data_insert['cst_no'] = trim($this->input->post('cst_no'));
					 $data_insert['pan_no'] = trim($this->input->post('pan_no'));
					 $data_insert['notes'] = trim($this->input->post('notes'));
					 $data_insert['other_information'] = trim($this->input->post('other_information'));				
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');
					 //echo '<pre>'; print_r($data_insert); die();	 
					 $id = $this->clients_model->updateClient($data_insert,$client_id);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Client updated successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to update client','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('client/edit/'.$client_id);
				 }
			}	
		
		}else {
				redirect('client');
		}	
		
	}
	
	
	/*
	View Client based on client Id
	*/
	
	public function view($client_id = 0)
	{
		
		if($client_id > 0){
			$data['menutitle'] = 'Client';
			$data['pagetitle'] = 'View Client';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'client/">Manage Client</a><i class="fa fa-angle-right"></i></li><li>View Client</li></ul>';
					
			$data['client_details'] = $this->clients_model->getClientInfo($client_id); 
			
			if($data != false)
			{
				$this->template->set_layout('admin_default')->build('clients/view_client',$data);
				//$this->load->view('clients/view_client',$data);
						
			}
		
		}else {
				redirect('client');
		}	
		
	}
	
	public function delete_customer()
	{
		$cust_id = $this->input->post('cust_id');
		echo $deleted = $this->client_mod->delete_single_customer($cust_id);	
	}
	
	
	public function getstatelist(){
		$cityOptions = '<option value="">Select District</option>';
		$stateName = trim($this->input->post('state_id'));
		if($stateName != ''){
			$stateCities = $this->clients_model->getStateCities($stateName);
			foreach($stateCities as $city ){
				$cityOptions .= '<option value="'.$city['district_name'].'">'.$city['district_name'].'</option>';
			}
		}
		echo $cityOptions;
	}
	
	
	
}
