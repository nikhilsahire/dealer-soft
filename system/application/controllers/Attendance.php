<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {

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
		$this->load->model('attendance_model');
				
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
			$data['worker_details'] = $this->attendance_model->getAllActiveEmployees();
			$data['menutitle'] = 'Attendance';
			$data['date'] = date('Y-m-d');
			$data['pagetitle'] = 'Fill Attendance';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Fill Attendance</li></ul>';
			
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('workers/add_attendance',$data);
					
			}
			
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('workers/add_attendance',$data);
			}elseif(trim($this->input->post('submit')) == 'Submit')
			{		
				    
					$attendanceDate = trim($this->input->post('attendanceDate'));
					$empidArray = $this->input->post('emp_id');
					$intimeArray = $this->input->post('in_time');
					$outtimeArray = $this->input->post('out_time');
					
					$arraySize = sizeof($empidArray);
					$insertArray = array();
					for($p=0; $p < $arraySize; $p++ ){
						if($intimeArray[$p] != '' && $outtimeArray[$p] != ''){
							$insertArray[$p]['emp_id'] = $empidArray[$p];
							$insertArray[$p]['in_time'] = date('H:i:s',strtotime($intimeArray[$p]));
							$insertArray[$p]['out_time'] = date('H:i:s',strtotime($outtimeArray[$p]));
							$insertArray[$p]['atn_date'] = $attendanceDate; 
						}
					}
					 
					$id = $this->attendance_model->addAttendanceEntries($insertArray, $attendanceDate);
					// echo '<pre>'; print_r($insertArray); die();
					// Update the forwording amount and discount
					
										 
					if($id == 1 ){
						$arr_msg = array('suc_msg'=>'Attendance is submitted successfully for the date # '.date('d m Y', strtotime($attendanceDate)).'.','msg-type'=>'success');
					}else{
						$arr_msg = array('suc_msg'=>'Failed to update the attanedance','msg-type'=>'danger');
					}	 
					$this->session->set_userdata($arr_msg);
					redirect('attendance/index/'.base64UrlEncode($attendanceDate));
				
			}
					
	}
	
	
	
	/*
	 Get the list of all users with their roles and status
	*/
	
	public function edit($atnDate = '')
	{       
			
			$atn_date = base64UrlDecode($atnDate);
			$data['menutitle'] = 'Attendance';
			$data['date'] = $atn_date; 
			$data['atnDate'] = $atnDate; 
			$data['pagetitle'] = 'Update Attendance';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Update Attendance</li></ul>';
			
			if(trim($atnDate) != ''){				
				$worker_details = $this->attendance_model->getAllActiveEmployees();
				$k =0 ;
				foreach($worker_details as $workerAtn){
					$workerDetailsArray[$k] = $workerAtn;
					$workingHrs = $this->attendance_model->getWorkingHrs($workerAtn['emp_id'], $atn_date);
					//echo '<pre>'; print_r($workingHrs ); 
					if($workingHrs[0]['in_time'] == '00:00:00' || $workingHrs[0]['out_time'] == '00:00:00'){
						$workerDetailsArray[$k]['in_time'] = '';
						$workerDetailsArray[$k]['out_time'] = '';
					}else{
						$workerDetailsArray[$k]['in_time'] = date('g:i A',strtotime($workingHrs[0]['in_time']));
						$workerDetailsArray[$k]['out_time'] = date('g:i A',strtotime($workingHrs[0]['out_time']));
					}
					$k++;
				} 
				$data['worker_details'] = $workerDetailsArray;
			}
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('workers/edit_attendance',$data);
					
			}
			
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('workers/edit_attendance',$data);
			}elseif(trim($this->input->post('submit')) == 'Update Attendance')
			{		
				    //echo '<pre>'; print_r($this->input->post() ); die();
					$attendanceDate = trim($this->input->post('attendanceDate'));
					$empidArray = $this->input->post('emp_id');
					$intimeArray = $this->input->post('in_time');
					$outtimeArray = $this->input->post('out_time');
					
					$arraySize = sizeof($empidArray);
					$insertArray = array();
					for($p=0; $p < $arraySize; $p++ ){
						if($intimeArray[$p] != '' && $outtimeArray[$p] != ''){
							$insertArray[$p]['emp_id'] = $empidArray[$p];
							$insertArray[$p]['in_time'] = date('H:i:s',strtotime($intimeArray[$p]));
							$insertArray[$p]['out_time'] = date('H:i:s',strtotime($outtimeArray[$p]));
							$insertArray[$p]['atn_date'] = $attendanceDate; 
						}
					}
					 
					$id = $this->attendance_model->addAttendanceEntries($insertArray, $attendanceDate);
											 
					if($id == 1 ){
						$arrmsg = array('suc_msg'=>'Attendance is updated successfully for the date '.date('d m Y', strtotime($attendanceDate)).'.','msg-type'=>'success');
					}else{
						$arrmsg = array('suc_msg'=>'Failed to update the attanedance','msg-type'=>'danger');
					}
					 
					 $this->session->set_userdata($arrmsg);
					redirect('attendance/edit/'.base64UrlEncode($attendanceDate));
			}
					
	}
	
	
	public function urlDecode(){
	    $attendanceDate = trim($this->input->post('attendanceDate'));
		if($attendanceDate !=''){
			echo base64UrlEncode($attendanceDate);
		}else {
			echo 0;
		}
	}
	
}
