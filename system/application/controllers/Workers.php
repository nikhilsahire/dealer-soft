<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workers extends CI_Controller {

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
		$this->load->model('workers_model');
		$this->load->model('payments_model');
		
		if (!is_admin_logged_in()) {
            redirect('');
        } 
	}
	
	/*
	 Get the list of all users with their roles and status
	*/
	
	public function index()
	{    
			$data['worker_details'] = $this->workers_model->getAllWorkers();
			$data['menutitle'] = 'Employees';
			$data['pagetitle'] = 'Employees';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Employees</li></ul>';
			
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('workers/workers_list',$data);
					
			}
					
	}
	
	
	/*
	 Add new employee to system
	*/
	
	public function add()
	{
		$data['menutitle'] = 'Employees';
		$data['pagetitle'] = 'Add Employee';
			
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'workers/">Manage Employees</a><i class="fa fa-angle-right"></i></li><li>Add Employee</li></ul>';
		
		
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('workers/add_worker',$data);
		}elseif(trim($this->input->post('submit')) == 'Add Employee')
		{ 
			
			$this->form_validation->set_rules('emp_name', 'Empoyee Name', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('emp_mobile', 'Contact Number', 'trim|required|max_length[25]');
			
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 	  	 
				 $this->template->set_layout('admin_default')->build('clients/add_client',$data);
		     } 
			 else
			 {
				 $data_insert = array();
				 $data_insert['emp_name'] = trim($this->input->post('emp_name'));
				 $data_insert['emp_status'] = trim($this->input->post('emp_status'));
				 $data_insert['emp_mobile'] = trim($this->input->post('emp_mobile'));
				 $data_insert['emp_address'] = trim($this->input->post('emp_address'));							 
				 $data_insert['updated_by'] = $this->session->userdata('userid');
				 $data_insert['updated_date'] = date('Y-m-d');
				 				 
				 $id = $this->workers_model->addWorker($data_insert);
				
			    if($id > 0){
					 $arr_msg = array('suc_msg'=>'Employee added successfully!','msg-type'=>'success');
				 }else{
					 $arr_msg = array('suc_msg'=>'Failed to added Employee','msg-type'=>'danger');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('workers');
			 }
		}
	}
	
	
	/*
	Edit Employee based on emp Id
	*/
	
	public function edit($emp_id = 0)
	{
		
		if($emp_id > 0){
			$data['menutitle'] = 'Employees';
			$data['pagetitle'] = 'Update Employee';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'workers/">Manage Employees</a><i class="fa fa-angle-right"></i></li><li>Update Employee</li></ul>';
			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
					
			$data['employee_details'] = $this->workers_model->getWorkerInfo($emp_id);
			
					
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('workers/edit_worker',$data);
			}elseif(trim($this->input->post('submit')) == 'Update Employee')
			{ 
			
				$this->form_validation->set_rules('emp_name', 'Empoyee Name', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('emp_mobile', 'Contact Number', 'trim|required|max_length[25]');
				
				
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  
					 $employee_details['emp_name'] = trim($this->input->post('emp_name'));				 
					 $employee_details['emp_status'] = trim($this->input->post('emp_status'));					 
					 $employee_details['emp_mobile'] = trim($this->input->post('emp_mobile'));
					 $employee_details['emp_address'] = trim($this->input->post('emp_address'));			 		
					 $employee_details['emp_id'] = trim($emp_id);
					 
					$data['employee_details'][0] = $employee_details;
					$this->template->set_layout('admin_default')->build('workers/edit_worker',$data);
				 }
				 else
				 {
					 $data_insert= array();
					 $data_insert['emp_name'] = trim($this->input->post('emp_name'));
					 $data_insert['emp_status'] = trim($this->input->post('emp_status'));
					 $data_insert['emp_mobile'] = trim($this->input->post('emp_mobile'));
					 $data_insert['emp_address'] = trim($this->input->post('emp_address'));							 
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');			
					 //echo '<pre>'; print_r($this->input->post()); die();	 
					 $id = $this->workers_model->updateWorker($data_insert,$emp_id);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Employee updated successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to update employee','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('workers/edit/'.$emp_id);
				 }
			}	
		
		}else {
				redirect('workers');
		}	
		
	}
	
	
	/*
	View Client based on client Id
	*/
	
	public function view($emp_id = 0)
	{
		
		if($emp_id > 0){
			$data['menutitle'] = 'Employees';
			$data['pagetitle'] = 'View Employee';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'workers/">Manage Employees</a><i class="fa fa-angle-right"></i></li><li>View Employee</li></ul>';
					
			$data['employee_details'] = $this->workers_model->getWorkerInfo($emp_id); 
			
			if($data != false)
			{
				$this->template->set_layout('admin_default')->build('workers/view_worker',$data);
				//$this->load->view('clients/view_client',$data);
						
			}
		
		}else {
				redirect('workers');
		}	
		
	}
	
	
	/*
	View Client based on client Id
	*/
	
	public function attendance($emp_id = 0)
	{
		
		if($emp_id > 0){
			$data['sdate']=  date('Y-m-01') ;
			$data['todate']= date('Y-m-d');
			$data['menutitle'] = 'Employees';
			$data['pagetitle'] = 'View Attendance';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'workers/">Manage Employees</a><i class="fa fa-angle-right"></i></li><li>View Employee Attendance</li></ul>';
			
			if($this->input->post('submit') == 'Filter')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			}
			
			// echo "<pre>";print_r($data);die;	
			$data['employee_details'] = $this->workers_model->getWorkerInfo($emp_id); 		
			$data['attendance'] = $this->workers_model->getWorkerAttendance($data['sdate'], $data['todate'], $emp_id); 
			
			if($data != false)
			{
				$this->template->set_layout('admin_default')->build('workers/manage_attendance',$data);
						
			}
		
		}else {
				redirect('workers');
		}	
		
	}
	
	
	
	
}
