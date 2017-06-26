<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_con extends CI_Controller {

	/**
	 * Login Page for this controller.
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
		$this->load->model('login_mod');
		$this->load->helper('cookie');
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		
		if($this->session->userdata('userid')=="")
		{
			$this->load->view('index');
		}
		else
		{
			redirect('index_con');
		}
	}
	
	public function check_login()
	{
		
	    $this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		 
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('index');
		}else{
			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$return   = $this->login_mod->check_login($username,$password);
			
			
			if($return or $return == true)
			{
				/*if(trim($this->input->post('remember')) == 1)
				{
					setcookie('username',$username, time()+(30*60*60*24));
				 	setcookie('user_pwd',$password, time()+(30*60*60*24)); 				   
				}
				else
				{
					setcookie('username','', time()-(30*60*60*24));
				 	setcookie('user_pwd','', time()-(30*60*60*24)); 	
				}*/
				switch($this->session->userdata('userrole')){
				 	    
						case "Admin":
					          $path = 'index_con';
        					  break; 
						case "Accounts":
					          $path = 'accounts/index_con';
        					  break;
						
							  
						default:
						      $path = '';
        					  break;
				}
				
				redirect($path);
			}else{
				$error_array = array("error_text"=>'Username or Password is incorrect!');
				$this->load->view('index',$error_array);
			}
		}
		 
	}
	
	public function logout()
	{
		if($this->session->userdata('userid') != "")
		{
			$array_items = array('username' => '', 'userid' => '');
			$this->session->unset_userdata($array_items);
			unset($_SESSION);
			$this->session->set_userdata($array_items);
			$this->session->sess_destroy();
			redirect('login_con');	
		}
		else
		{
			redirect('login_con');
		}
	}
	
	public function change_password()
	{ 
		 if($this->session->userdata('userid')!="")
		 {
			$data['pagetitle'] = 'Change Password'; 
			$userid = $this->session->userdata('userid');
			
			if($this->input->post('submit')=='Save')
			{
				$old_pwd = trim($this->input->post('old_pwd'));
				$new_pwd = trim($this->input->post('new_pwd'));
				$confirm_pwd = trim($this->input->post('confirm_pwd'));
				if($new_pwd == $confirm_pwd)
				{
					$return   = $this->login_mod->change_password($userid,$old_pwd,$new_pwd);
					if($return == true)
					{
						$data['suc_msg'] = 'Password changed successfully!';
					}
					else
					{
						$data['err_msg'] = 'Old password is incorrect!';
					}
					
				}else
				{
					$data['err_msg'] = 'New password and Confirm password is not same!';
				}
				$this->template->set_layout('admin_default')->build('login/change_password',$data); 
			}else{
				$this->template->set_layout('admin_default')->build('login/change_password',$data);
			}
		 }else{
			 redirect('login_con');
		 }
	}
	
}
