<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {  

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
		$this->load->model('user_model');
		$this->load->model('clients_model');
		$this->load->model('suppliers_model');
		
		
		$this->load->library('pagination');//load pagination library
		
		if (!is_admin_logged_in()) {
		   
            redirect('');
        } 
	}
	
	/*
	 Get the list of all users with their roles and status
	*/
	
	public function index()
	{    
			$data['customer_details'] = $this->user_model->getAllUsers();
			$data['menutitle'] = 'Users';
			$data['pagetitle'] = 'Manage Users';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Users</li></ul>';
			
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('users/users_manage',$data);
					
			}
					
	}
	
	/*
	View the user deta by user ID
	*/
	public function view($uid)
	{    
	   $data['user_details'] = $this->user_model->getUser($uid);
	   $data['menutitle'] = 'Users';
	   $data['pagetitle'] = 'View Users';
	   $data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'users/">Manage Users</a><i class="fa fa-angle-right"></i></li><li>View User</li></ul>';
	   if($data != false)
		{
			
			$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('users/view_user',$data);

					
		}
					
	}
	
	/*
	 Create user in software
	*/
	public function edit($uid = 0)
	{
		$data['menutitle'] = 'Users';
		$data['pagetitle'] = 'Edit User';
		//$data['states']			 = $this->customer_mod->get_all_state();	
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'users/">Manage Users</a><i class="fa fa-angle-right"></i></li><li>Edit User</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		if($this->input->post('uid') && $uid == 0)
		{
			$uid = $this->input->post('uid');
	    }
		$data['user_details'] = $this->user_model->getUser($uid);
		
		// get the role of user and get list of all suppliers or clients to assign 
		if($data['user_details'][0]['user_role']=='Sales'){
			$data['all_clients'] = $this->clients_model->getAllClients($uid);
			$data['assigned_clients'] = $this->clients_model->getAllClients($uid,'User');
		}else if($data['user_details'][0]['user_role']=='Purchase'){
			$data['all_suppliers'] = $this->suppliers_model->getAllSuppliers($uid);
			$data['assigned_suppliers'] = $this->suppliers_model->getAllSuppliers($uid,'User');
		}		
		// ends here 
		
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('users/edit_user',$data);
		}elseif(trim($this->input->post('submit')) == 'Edit User')
		{ 
		
			
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[20]');
			if(trim($this->input->post('pass')) !=''){
				$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[8]|max_length[8]');
			}
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[1]|max_length[20]');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[1]|max_length[20]');
			$this->form_validation->set_rules('email', ' Email', 'trim|required|max_length[100]|valid_email');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|max_length[13]');	
			$this->form_validation->set_rules('user_status', 'Status', 'required');
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
			  
				$user_detail['uid'] =  trim($this->input->post('uid'));
				$user_detail['username'] =  trim($this->input->post('username'));
				$user_detail['pass'] =  trim($this->input->post('pass'));
				$user_detail['first_name'] =  trim($this->input->post('first_name'));
				$user_detail['last_name'] =  trim($this->input->post('last_name'));
				$user_detail['email'] =  trim($this->input->post('email'));
				$user_detail['phone_number'] =  trim($this->input->post('phone_number'));
				$user_detail['user_status'] =  trim($this->input->post('user_status'));				
				
				$data['user_details'][0] = $user_detail;
				$this->template->set_layout('admin_default')->build('users/edit_user',$data);
		     }
			 else
			 {
				 
				 $uid = trim($this->input->post('uid'));
				 $data_insert['username'] = trim($this->input->post('username'));
				 if(trim($this->input->post('pass')) != ''){
				 	$data_insert['pass'] = md5(trim($this->input->post('pass')));
				 }
				 $data_insert['first_name'] = trim($this->input->post('first_name'));
				 $data_insert['last_name'] = trim($this->input->post('last_name'));
				 $data_insert['email'] = trim($this->input->post('email'));
				 $data_insert['phone_number'] = trim($this->input->post('phone_number'));
				 $data_insert['user_role'] = trim($this->input->post('user_role'));
				 $data_insert['user_status'] = trim($this->input->post('user_status'));
				 				 
				 $id = $this->user_model->updateUser($data_insert,$uid);
				 if($id > 0){
					 $arr_msg = array('suc_msg'=>'User updated successfully!!!','msg-type'=>'success');
				 }else{
					 $arr_msg = array('suc_msg'=>'Failed to update user','msg-type'=>'danger');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('users/edit/'.$uid);
			 }
		}		
		
	}
	
	/*
	 Create user in software
	*/
	public function add()
	{
		$data['menutitle'] = 'Users';
		$data['pagetitle'] = 'Add User';
		//$data['states']			 = $this->customer_mod->get_all_state();	
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'users/">Manage Users</a><i class="fa fa-angle-right"></i></li><li>Add User</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('users/add_user',$data);
		}elseif(trim($this->input->post('submit')) == 'Add User')
		{ 
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[20]');
			$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[8]|max_length[8]');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[1]|max_length[20]');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[1]|max_length[20]');
			$this->form_validation->set_rules('email', ' Email', 'trim|required|max_length[100]|valid_email');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|max_length[13]');	
			$this->form_validation->set_rules('user_status', 'Status', 'required');
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 $this->template->set_layout('admin_default')->build('users/add_user',$data);
		     }
			 else
			 {
				 $data_insert['username'] = trim($this->input->post('username'));
				 $data_insert['pass'] = md5(trim($this->input->post('pass')));
				 $data_insert['first_name'] = trim($this->input->post('first_name'));
				 $data_insert['last_name'] = trim($this->input->post('last_name'));
				 $data_insert['email'] = trim($this->input->post('email'));
				 $data_insert['phone_number'] = trim($this->input->post('phone_number'));
				 $data_insert['user_status'] = trim($this->input->post('user_status'));
				 				 
				 $id = $this->user_model->addUser($data_insert);
				 if($id > 0){
					 $arr_msg = array('suc_msg'=>'User added successfully!!!','msg-type'=>'success');
				 }else{
					 $arr_msg = array('suc_msg'=>'Failed to add user','msg-type'=>'danger');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('users');
			 }
		}		
		
	}
	
	/*
	 Delete user in software
	*/
	public function delete($uid = 0)
	{
		$deleteFlag = 0;
		if( $uid > 0)
		{
			$data['user_details'] = $this->user_model->getUser($uid);
			if(is_array($data['user_details'])){
				$this->user_model->delete_single_user($uid);
				$deleteFlag = 1;
			}else{
				$arr_msg = array('suc_msg'=>'Sorry, There is no such user to delete.');				
			}			
	    }		
		 echo $deleteFlag;
	}
	
	
	/*
	 add handliong person in for clients
	*/
	public function add_client_person()
	{
		$updateFlag = 0;
		$compnay_id = trim($this->input->post('compnay_id'));
		$handling_person = trim($this->input->post('handling_person'));
		$action = trim($this->input->post('action'));
		if($compnay_id > 0 && $handling_person > 0 && $action === 'add'){
			$updated = $this->clients_model->updateHandlingPerson($compnay_id, $handling_person );
			$updateFlag = 1;
		}
		echo $updateFlag;
	}
	/*
	 remove handliong person in for clients
	*/
	public function remove_client_person()
	{
		$updateFlag = 0;
		$compnay_id = trim($this->input->post('compnay_id'));
		$action = trim($this->input->post('action'));
		if($compnay_id > 0 && $action === 'update'){
			$updated = $this->clients_model->updateHandlingPerson($compnay_id);
			$updateFlag = 1;
		}
		echo $updateFlag;
	}
	
	/*
	 add handliong person in for supplier
	*/
	public function add_supplier_person()
	{
		$updateFlag = 0;
		$supplier_id = trim($this->input->post('supplier_id'));
		$handling_person = trim($this->input->post('handling_person'));
		$action = trim($this->input->post('action'));
		if($supplier_id > 0 && $handling_person > 0 && $action === 'add'){
			$updated = $this->suppliers_model->updateHandlingPerson($supplier_id, $handling_person );
			$updateFlag = 1;
		}
		echo $updateFlag;
	}
	
	/*
	 remove handliong person in for suppliers
	*/
	public function remove_supplier_person()
	{
		$updateFlag = 0;
		$supplier_id = trim($this->input->post('supplier_id'));
		$action = trim($this->input->post('action'));
		if($supplier_id > 0 && $action === 'update'){
			$updated = $this->suppliers_model->updateHandlingPerson($supplier_id);
			$updateFlag = 1;
		}
		echo $updateFlag;
	}
	
	/* update the notification read flag to "Read" */
	public function markasread()
	{
		$updateFlag = 0;
		$notificationId = trim($this->input->post('id'));
		$action = trim($this->input->post('action'));
		if($notificationId > 0 && $action === 'update'){
			$updated = $this->user_model->updateNotification($notificationId);
			if($updated == 1){
				$updateFlag = 1;
			}
		}
		echo $updateFlag;
	}
	
	
	
	
}
