<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

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
		$this->load->model('clients_model');		
		$this->load->model('user_model');
		$this->load->model('payments_model');
		$this->load->model('orders_model');
				
		$this->load->library('pagination');//load pagination library
		if (!is_admin_logged_in()) {
            redirect('');
        } 
	}
	
	public function index($client_id = 0){
		redirect('index_con');
	}
	
	public function transactions($client_id)
	{
	
		if($this->session->userdata('userid') != "" && $client_id > 0)
		{
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			
			// get product stock entries
			if($this->input->post('submit') == 'Filter')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $firm_id= $this->input->post('firm_id');
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']= $firm_id[0];
			}
			$client_info = $this->clients_model->getClientInfo($client_id);
			$data['client_name'] = $client_info[0]['comp_name'];
			$data['transactions'] = $this->payments_model->getClientTransactions($client_id,$stardate,$enddate, $data['firm_id']);
			$data['menutitle'] = 'Client';
			$data['client_id'] = $client_id;
			$data['pagetitle'] = 'Client Transactions';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> </li><li> <i class="fa fa-angle-right"></i> <a href="'.base_url().'client">Manage Clients</a> <i class="fa fa-angle-right"></i> </li><li>Manage Transactions</li></ul>';
			// get the total Credit and Debit amount 
			$cliFinalAmount = $this->payments_model->getClientFinalAmount($client_id,$stardate,$enddate, $data['firm_id']);
			$data['finalAmount'] = $cliFinalAmount;
			// echo '<pre>'; print_r($cliFinalAmount); die(); 
			
			// get the firm list 
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(0=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
			
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('payments/manage_transactions',$data); // customer_manage
					
			}
		}
		else
		{
			$this->load->view('index_con');
		}
	}
	/* Add new transaction payment in database for client */
	public function add($client_id)
	{
	
		$data['menutitle'] = 'Client';
		$data['pagetitle'] = 'Add Transaction';
			
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> </li><li> <i class="fa fa-angle-right"></i> <a href="'.base_url().'client">Manage Clients</a> <i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'payment/transactions/'.$client_id.'">Manage Transactions</a><i class="fa fa-angle-right"></i></li><li>Add Transaction</li></ul>';
		$data['client_details'] = array();
		if($client_id > 0){
			// get the client information
			$data['client_details'] = $this->clients_model->getClientInfo($client_id);		
			
		}
		if(sizeof($data['client_details']) > 0){
		
			// get the firm array
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array();	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
			
			// get the list of pending invocies for the client
			$invoiceList = $this->payments_model->getPendingInvoieslist($client_id);			
			$data['invoiceList'] = $invoiceList;
			
			// echo '<pre>'; print_r($data); die();
			//// 
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			
			if(trim($this->input->post('submit')) == '')
			{				
					$this->template->set_layout('admin_default')->build('payments/add_payment',$data);
				
			}elseif(trim($this->input->post('submit')) == 'Add Transaction')
			{ 
				//echo '<pre>'; print_r($this->input->post()); // die();
				
				$this->form_validation->set_rules('comp_id', 'Company', 'trim|required|greater_than[0]');
				$this->form_validation->set_rules('transaction_type', 'Transaction Type', 'trim|required');
				$this->form_validation->set_rules('transaction_amount', 'Transaction Amount', 'trim|required');
				// $this->form_validation->set_rules('transaction_id', 'Transaction Id', 'trim|required');
				$this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
				// $this->form_validation->set_rules('bank_id', 'Bank Name', 'trim|required|numeric|greater_than[0]');
				$this->form_validation->set_rules('payment_by', 'Payment By', 'trim|required');
				
				 if ($this->form_validation->run($this) == FALSE)
				 {
					 				 
					 $this->template->set_layout('admin_default')->build('payments/add_payment',$data);
				 } 
				 else
				 {
					// echo '<pre>'; print_r($this->input->post()); 
					 $data_bank_entry = array(); $data_bank = array();
					 $data_bank_entry['payment_ref_id'] = trim($this->input->post('comp_id'));
					 $data_bank_entry['transaction_id'] = trim($this->input->post('transaction_id'));
					 $data_bank_entry['transaction_date'] = trim($this->input->post('transaction_date'));
					// $data_bank_entry['bank_id'] = trim($this->input->post('bank_id'));
					 $data_bank_entry['payment_by'] = trim($this->input->post('payment_by'));
					 $data_bank_entry['notes'] = trim($this->input->post('notes'));
					 $data_bank_entry['payment_ref_type'] = 1;
					 $data_bank_entry['transaction_title'] = $this->input->post('transaction_title');
					 $data_bank_entry['updated_by'] = $this->session->userdata('userid');
					 $data_bank_entry['firm_id'] = trim($this->input->post('firm_name'));
					 
					 $data_bank['firm_id'] = trim($this->input->post('firm_name'));
					 $data_bank['transaction_type'] = trim($this->input->post('transaction_type'));
					 $data_bank['transaction_amount'] = trim($this->input->post('transaction_amount'));
					
					 $data_bank['order_date'] = date('Y-m-d');
					 
					 
					 $invBalArray = $this->input->post('balance_amount');
					 $paymentIdArray = $this->input->post('payment_id');					 
					 $invAmtArray = $this->input->post('amount');
					 
					 $totalAmt = 0.00;
					 $inv_update_amt = array();			 
					 if($data_bank['transaction_type'] === 'Credit'){
					 	 $data_bank_entry['credit_amount'] = $this->input->post('transaction_amount');
						 $cntArray = sizeof($paymentIdArray);
						 if($cntArray > 0){
							 for($i=0;$i < $cntArray ;$i++){
							     if( $invAmtArray[$i] != '' &&  $invAmtArray[$i] != 0.00){
									 $inv_update_amt[$i]['paid_amt'] = $invAmtArray[$i];
									 $inv_update_amt[$i]['id'] = $paymentIdArray[$i];
									 
									 if($invBalArray[$i] == $invAmtArray[$i]){
										$inv_update_amt[$i]['status'] = 'Paid';
									 }else {
										$inv_update_amt[$i]['status'] = 'Pending';								 
									 }
									 $totalAmt += $invAmtArray[$i];
								 }
							 }
						 }
					 
					 }else if($data_bank['transaction_type'] === 'Debit'){
					 	$data_bank_entry['debit_amount'] = $this->input->post('transaction_amount');
					 }
					  
					 //echo '<pre>'; print_r($this->input->post());  echo '<pre>'; print_r($data_bank_entry);  echo '<pre>'; print_r($inv_update_amt);  die();
					 if($totalAmt <= $data_bank['transaction_amount']){
					 	
						 $id = $this->payments_model->addPayment($data_bank_entry,$inv_update_amt);						 
						 
						 if($id > 0){
							 $arr_msg = array('suc_msg'=>'Transaction is added successfully','msg-type'=>'success');
						 }else{
							 $arr_msg = array('suc_msg'=>'Faild to add transaction','msg-type'=>'danger');
						 }
					 }else{
					 	$arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
					 }
					 		 
					
					 $this->session->set_userdata($arr_msg);
					 redirect('payment/transactions/'.$client_id);
				 }
			}
		
	  }else {
	  		redirect('index_con');
	  }	
	}
	
	
	/*
	
	/* Add new transaction payment in database */
	public function add_supl_payment($supplier_id)
	{
	
		$data['menutitle'] = 'Supplier';
		$data['pagetitle'] = 'Add Transaction';
			
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> </li><li> <i class="fa fa-angle-right"></i> <a href="'.base_url().'supplier">Manage Suppliers</a> <i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'payment/supplier_transactions/'.$supplier_id.'">Manage Transactions</a><i class="fa fa-angle-right"></i></li><li>Add Transaction</li></ul>';
		$data['client_details'] = array();
		if($supplier_id > 0){
			// get the client information
			$data['supplier_details'] = $this->suppliers_model->getSupplierInfo($supplier_id);		
			
		}
		if(sizeof($data['supplier_details']) > 0){
		
			// get the firm array
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array();	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
			
			/*// get the list of pending invocies for the client
			$invoiceList = $this->payments_model->getSupplierPendingInvoieslist($supplier_id);			
			$data['invoiceList'] = $invoiceList;*/
			
			// echo '<pre>'; print_r($data); die();
			//// 
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			
			if(trim($this->input->post('submit')) == '')
			{				
					$this->template->set_layout('admin_default')->build('payments/add_supl_payment',$data);
				
			}elseif(trim($this->input->post('submit')) == 'Add Transaction')
			{ 
				//echo '<pre>'; print_r($this->input->post()); // die();
				
				$this->form_validation->set_rules('supl_id', 'Supplier', 'trim|required|greater_than[0]');
				$this->form_validation->set_rules('transaction_type', 'Transaction Type', 'trim|required');
				$this->form_validation->set_rules('transaction_amount', 'Transaction Amount', 'trim|required');
				//$this->form_validation->set_rules('transaction_id', 'Transaction Id', 'trim|required');
				$this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
				//$this->form_validation->set_rules('bank_id', 'Bank Name', 'trim|required|numeric|greater_than[0]');
				$this->form_validation->set_rules('payment_by', 'Payment By', 'trim');
				
				 if ($this->form_validation->run($this) == FALSE)
				 {
					 				 
					 $this->template->set_layout('admin_default')->build('payments/add_supl_payment',$data);
				 } 
				 else
				 {
					// echo '<pre>'; print_r($this->input->post()); 
					 $data_bank_entry = array(); $data_bank = array();
					 $data_bank_entry['payment_ref_id'] = trim($this->input->post('supl_id'));
					 $data_bank_entry['transaction_id'] = trim($this->input->post('transaction_id'));
					 $data_bank_entry['transaction_date'] = trim($this->input->post('transaction_date'));
					// $data_bank_entry['bank_id'] = trim($this->input->post('bank_id'));
					 $data_bank_entry['payment_by'] = trim($this->input->post('payment_by'));
					 $data_bank_entry['notes'] = trim($this->input->post('notes'));
					 $data_bank_entry['payment_ref_type'] = 2;
					 $data_bank_entry['transaction_title'] = $this->input->post('transaction_title');
					 $data_bank_entry['updated_by'] = $this->session->userdata('userid');
					 $data_bank_entry['firm_id'] = trim($this->input->post('firm_name'));
					 
					 $data_bank['firm_id'] = trim($this->input->post('firm_name'));
					 $data_bank['transaction_type'] = trim($this->input->post('transaction_type'));
					 $data_bank['transaction_amount'] = trim($this->input->post('transaction_amount'));
					
					 $data_bank['order_date'] = date('Y-m-d');
					 
					 
					 $invBalArray = $this->input->post('balance_amount');
					 $paymentIdArray = $this->input->post('payment_id');					 
					 $invAmtArray = $this->input->post('amount');
					 
					 $totalAmt = 0.00;
					 $inv_update_amt = array();			 
					 if($data_bank['transaction_type'] === 'Credit'){
					 	 $data_bank_entry['credit_amount'] = $this->input->post('transaction_amount');
						 $cntArray = sizeof($paymentIdArray);
						 if($cntArray > 0){
							 for($i=0;$i < $cntArray ;$i++){
							     if( $invAmtArray[$i] != '' &&  $invAmtArray[$i] != 0.00){
									 $inv_update_amt[$i]['paid_amt'] = $invAmtArray[$i];
									 $inv_update_amt[$i]['id'] = $paymentIdArray[$i];
									 
									 if($invBalArray[$i] == $invAmtArray[$i]){
										$inv_update_amt[$i]['status'] = 'Paid';
									 }else {
										$inv_update_amt[$i]['status'] = 'Pending';								 
									 }
									 $totalAmt += $invAmtArray[$i];
								 }
							 }
						 }
					 
					 }else if($data_bank['transaction_type'] === 'Debit'){
					 	$data_bank_entry['debit_amount'] = $this->input->post('transaction_amount');
					 }
					  
					 //echo '<pre>'; print_r($this->input->post());  echo '<pre>'; print_r($data_bank_entry);  echo '<pre>'; print_r($inv_update_amt);  die();
					 if($totalAmt <= $data_bank['transaction_amount']){
					 	
						 $id = $this->payments_model->addSupplierPayment($data_bank_entry,$inv_update_amt);						 
						 
						 if($id > 0){
							 $arr_msg = array('suc_msg'=>'Transaction is added successfully','msg-type'=>'success');
						 }else{
							 $arr_msg = array('suc_msg'=>'Faild to add transaction','msg-type'=>'danger');
						 }
					 }else{
					 	$arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
					 }
					 		 
					
					 $this->session->set_userdata($arr_msg);
					 redirect('payment/supplier_transactions/'.$supplier_id);
				 }
			}
		
	  }else {
	  		redirect('index_con');
	  }	
	}
	
	
	/*
	
	View supplier based on client Id
	*/
	
	public function view($supplier_id = 0)
	{
		
		if($supplier_id > 0){
			$data['menutitle'] = 'Supplier';
			$data['pagetitle'] = 'View Supplier';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'supplier/">Manage Supplier</a><i class="fa fa-angle-right"></i></li><li>View Supplier</li></ul>';
					
			$data['supplier_details'] = $this->suppliers_model->getSupplierInfo($supplier_id); 
			$handling_person  = 'Admin';
			if($data['supplier_details'][0]['handling_person'] > 0){
				$handling_person_details = $this->user_model->getUser($data['supplier_details'][0]['handling_person']);
				$handling_person = $handling_person_details[0]['first_name'].' '.$handling_person_details[0]['last_name'];
			}
			$data['supplier_details'][0]['handling_person'] =  $handling_person;
			if($data != false)
			{
				$this->template->set_layout('admin_default')->build('suppliers/view_supplier',$data);
				//$this->load->view('clients/view_client',$data);
						
			}
		
		}else {
				redirect('supplier');
		}	
		
	}
	
	
	/**/
	public function transaction_details(){
		
	     $transaction_id = $this->input->post('id');
		// get the batch description details based on the batch number
		$transaction_row = $this->payments_model->transaction_details($transaction_id);
			
		// echo '<pre>'; print_r($qc_report); die();
		$html = '<div class="row">
					<div class="col-xs-6">
						<ul class="list-unstyled">
							<li>
								 <strong>Amount:</strong> '.number_format($transaction_row[0]['credit_amount'],2).' 
							</li>
							<li>
								 <strong>Transaction #:</strong> '.$transaction_row[0]['transaction_id'].' 
							</li>
							
							<li>
								 <strong>Transaction Date:</strong> '.date('d M Y',strtotime($transaction_row[0]['transaction_date'])).'
							</li>
							<li>
								 <strong>Transaction Title:</strong> '.$transaction_row[0]['transaction_title'].' 
							</li>
							
						</ul>
					</div>
					<div class="col-xs-6">
						<ul class="list-unstyled">							
							
							<li>
								 <strong>Payment By:</strong> '.$transaction_row[0]['payment_by'].'
							</li>
							<li>
								 <strong>Notes:</strong> '.$transaction_row[0]['notes'].'
							</li>
							
						</ul>
					</div>
					
				</div>';
		echo $html;
	
	}
	
    /* Show the all transactions of supplier id*/
	public function supplier_transactions($supplier_id){
		if($this->session->userdata('userid') != "" && $supplier_id > 0)
		{
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			
			// get product stock entries
			if($this->input->post('submit') == 'Filter')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $firm_id= $this->input->post('firm_id');
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']= $firm_id[0];
			}
			$client_info = $this->suppliers_model->getSupplierInfo($supplier_id);
			$data['supplier_name'] = $client_info[0]['supl_comp'];
			$data['transactions'] = $this->payments_model->getSupplierTransactions($supplier_id,$stardate,$enddate, $data['firm_id']);
			$data['menutitle'] = 'Supplier';
			$data['supplier_id'] = $supplier_id;
			$data['pagetitle'] = 'Supplier Transactions';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> </li><li> <i class="fa fa-angle-right"></i> <a href="'.base_url().'supplier">Manage Supplier</a> <i class="fa fa-angle-right"></i> </li><li>Manage Transactions</li></ul>';
			// get the total Credit and Debit amount 
			$suplFinalAmount = $this->payments_model->getSupplierFinalAmount($supplier_id,$stardate,$enddate, $data['firm_id']);
			$data['finalAmount'] = $suplFinalAmount;
						
			// get the firm list 
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(0=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
			
			// echo '<pre>'; print_r($data); die(); 
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('payments/supplier_transactions',$data); // customer_manage
					
			}
		}
		else
		{
			$this->load->view('index_con');
		}
	}
	
	
	/*
	 Get the list of all payments based on selected dates
	*/
	
	public function sales_statement()
	{    
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
		 
			$data['menutitle'] = 'Reports';			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			
			  
			$data['pagetitle'] = 'Sales Reports';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Sales Report</li></ul>';
			
			// get product stock entries
			if($this->input->post('submit') == 'Filter')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $firm_id= $this->input->post('firm_id');
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']= $firm_id[0];
			}
			$transactionArray = array();
			$ordersArray = $this->payments_model->getSalesReport($stardate,$enddate, $data['firm_id']); //$stardate,$enddate
			if(sizeof($ordersArray) > 0){
				$i=0;
				foreach($ordersArray as $orderRow){
					$transactionArray[$i] = $orderRow;
					$orderSubtotal = $this->orders_model->getOrderAmount($orderRow['order_id']);
					$transactionArray[$i]['sub_total'] = $orderSubtotal[0]['orderTotal'];
					$i++;
				}
			}
			
			// echo '<pre>'; print_r($transactionArray); die();
			$data['transactions'] = $transactionArray;
			
			/*// get the firm list 
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(0=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;*/
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('payments/sales_statement',$data);
					
			}
					
	}
	
	
	/*
	 Get the list of all supplier payments based on selected dates
	*/
	
	public function purchase_statement()
	{    
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
		 
			$data['menutitle'] = 'Reports';			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			
			  
			$data['pagetitle'] = 'purchase Reports';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Purchase Report</li></ul>';
			
			// get product stock entries
			if($this->input->post('submit') == 'Filter')
			{ 
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $firm_id= $this->input->post('firm_id');
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']= $firm_id[0];
			}
			$transactionArray = $ordersArray = array();
			$purchaseInvoices = $this->payments_model->getPurchaseInvoices($stardate,$enddate, $data['firm_id']); //$stardate,$enddate

			if(sizeof($purchaseInvoices) > 0){
				foreach($purchaseInvoices as $purchaseInvoice){
					// get the invoice details based on the invoice nnumber and supplier Id 
					$purchaseReportArray = $this->payments_model->getInvoiceStockProdcts($purchaseInvoice['invoice_no'],  $purchaseInvoice['su_id']); 
					 
					if(sizeof($purchaseReportArray) > 0){
					    $i=0; 
						foreach($purchaseReportArray as $purchaseReport){
							//echo '<pre>'; print_r($purchaseReport);
							$ordersArray[$i]['invoice_no'] = $purchaseInvoice['invoice_no'];
							$ordersArray[$i]['supl_comp'] = $purchaseReport['supl_comp'];
							$ordersArray[$i]['prod_ref_name'] = $purchaseReport['prod_ref_name'];
							$ordersArray[$i]['on_date'] = $purchaseReport['on_date'];
							// $ordersArray[$i]['tax_per'] = $purchaseReport['tax_per'];
							// $ordersArray[$i]['tax_type'] = $purchaseReport['tax_type'];
							// $ordersArray[$i]['excise'] = $purchaseReport['excise'];
							$ordersArray[$i]['amount'] = $purchaseReport['amount']; 
							$ordersArray[$i]['gstin_num'] = $purchaseReport['gstin_num'];
							
							$i++; 
						}
					}
				}
			}
				//	echo '<pre>'; print_r($ordersArray); die();
			$data['transactions'] = $ordersArray;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('payments/purchase_statement',$data);
					
			}
					
	}
	
	/*
	 Get the list of all supplier payments based on selected dates
	*/
	
	public function client_due_payments()
	{    
	 
			$data['menutitle'] = 'Reports';			
			$data['pagetitle'] = 'Client Pendning Amount';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Client Pendning Amount</li></ul>';
		
			$pendingAmountArray = $this->payments_model->getClientsTotalPendingAmount(); //$stardate,$enddate
					
			// echo '<pre>'; print_r($pendingAmountArray); die();
			$data['pendingAmount'] = $pendingAmountArray;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('payments/pending_client_amount',$data);
					
			}
					
	}
	
	public function hsn_statement()
	{    
	 
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
		 
			$data['menutitle'] = 'Reports';			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			
			  
			$data['pagetitle'] = 'Sales Reports';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>HSN Report</li></ul>';
			
			if($this->input->post('submit') == 'Filter')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $firm_id= $this->input->post('firm_id');
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']= $firm_id[0];
			}

			$transactionArray = array();
			// Get Outward data
			$clientArray = $this->payments_model->getClientHsnReport($stardate,$enddate, $data['firm_id']); 
			// Get Inward data
			$purchaseArray = $this->payments_model->getPurchaseHsnReport($stardate,$enddate, $data['firm_id']); 
			
			$sgst = 0;
			$cgst = 0;
			$igst = 0;

			if(sizeof($clientArray) > 0){
				$i=0;
				// echo "<pre>";
				// print_r($carr);
				// die;
				foreach($clientArray as $carr){

					$total = 0;
					$sgst = 0;
					$cgst = 0;
					$igst = 0;
					
					$total = $carr['order_qty'] * $carr['order_rate'];
					$sgst = $total * $carr['sgst_per'] / 100;
					$cgst = $total * $carr['cgst_per'] / 100;
					$igst = $total * $carr['igst_per'] / 100;

					if(!isset($transactionArray[$carr['hsn_code']]['out'])){
						$transactionArray[$carr['hsn_code']]['out']['sgst'] = $sgst;
						$transactionArray[$carr['hsn_code']]['out']['cgst'] = $cgst;
						$transactionArray[$carr['hsn_code']]['out']['igst'] = $igst;
					}
					else{
						$transactionArray[$carr['hsn_code']]['out']['sgst'] = $transactionArray[$carr['hsn_code']]['out']['sgst'] + $sgst;
						$transactionArray[$carr['hsn_code']]['out']['cgst'] = $transactionArray[$carr['hsn_code']]['out']['cgst'] + $cgst;
						$transactionArray[$carr['hsn_code']]['out']['igst'] = $transactionArray[$carr['hsn_code']]['out']['igst'] + $igst;
					}

				}
			}

			$sgst = 0;
			$cgst = 0;
			$igst = 0;

			if(sizeof($purchaseArray) > 0){
				$i=0;
				// echo "<pre>";
				// print_r($purchaseArray);
				// die;
				foreach($purchaseArray as $parr){

					$total = 0;
					$sgst = 0;
					$cgst = 0;
					$igst = 0;
					
					$total = $parr['purchase_qty'] * $parr['purchase_rate'];
					$sgst = $total * $parr['sgst_per'] / 100;
					$cgst = $total * $parr['cgst_per'] / 100;
					$igst = $total * $parr['igst_per'] / 100;

					if(!isset($transactionArray[$parr['hsn_code']]['in'])){
						$transactionArray[$parr['hsn_code']]['in']['sgst'] = $sgst;
						$transactionArray[$parr['hsn_code']]['in']['cgst'] = $cgst;
						$transactionArray[$parr['hsn_code']]['in']['igst'] = $igst;
					}
					else{
						$transactionArray[$parr['hsn_code']]['in']['sgst'] = $transactionArray[$parr['hsn_code']]['in']['sgst'] + $sgst;
						$transactionArray[$parr['hsn_code']]['in']['cgst'] = $transactionArray[$parr['hsn_code']]['in']['cgst'] + $cgst;
						$transactionArray[$parr['hsn_code']]['in']['igst'] = $transactionArray[$parr['hsn_code']]['in']['igst'] + $igst;
					}

				}
			}
			
			$data['transactions'] = $transactionArray;
					
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('payments/hsn_statement',$data);
					
			}

	}
}
