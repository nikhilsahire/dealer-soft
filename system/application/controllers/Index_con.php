<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_con extends CI_Controller {

	/**
	 * Index Page for this controller.
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
		//$this->load->model('client_mod');
		$this->load->model('user_model');
		//$this->load->model('course_mod');
		//$this->load->model('bundle_mod');
		
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
			
			$data['menutitle'] = 'Dashboard';
			$data['pagetitle'] = 'Dashboard';
			// Get all pending notifications as per login user, Admin will see all notifications
			$notifications = $this->user_model->getUserNotifications();
			$data['notifications']= $notifications;
			
			// Get all pending invoices which are over due 
			$overDueInvoices = $this->user_model->getTodaysDuePayments();
			$data['overDueInvoices']= $overDueInvoices;
			
			// echo '<pre>'; print_r($data['overDueInvoices']); die();
			$this->template
				 ->set_layout('admin_default')
		     	 ->build('admin_index', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
}
