<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {  

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
		$this->load->model('product_model');
		$this->load->model('clients_model');
		$this->load->model('orders_model');
		$this->load->model('user_model');
		$this->load->library('pagination');//load pagination library
		
		if (!is_admin_logged_in()) {
		   
            redirect('');
        } 
	}
	
	/*
	 Get the list of all leads based on the type 
	*/
	
	public function index($order_type= 'tax')
	{    
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
		 
			$data['menutitle'] = 'Invoices';			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			$data['order_type']= $order_type;
			  
			$data['pagetitle'] = 'Manage '.$order_type.' Invoices';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage '.$order_type.' Invoices</li></ul>';
			
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
			$ordersArray = $this->orders_model->getAllOrders($stardate,$enddate, $data['firm_id'],$order_type); //$stardate,$enddate
			
			$i= 0;
			$orderData = array();
			if(sizeof($ordersArray) > 0){
				foreach($ordersArray as $order){
					$orderAmount = $this->orders_model->getOrderAmount($order['order_id']); // 
					$orderData[$i] = $order;
					$orderData[$i]['orderTotal'] = number_format(round(($orderAmount[0]['orderTotal']+$order['forwardingAmt'])-$order['discount']),2); 
					// get the invoices and challans
					$orderData[$i]['chalans'] = $order['challan_number'];
					$orderData[$i]['invoice'] = $order['invoice_number'];
					$i++;
				}
			}
			$data['orders'] = $orderData;
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
		     	 	 ->build('orders/manage_orders',$data);
					
			}
					
	}
	
	
	
	public function add_new_row(){
	
		// get list of all Products
		$allProducts = $this->product_model->getAllProducts('Yes');
		$products_data = array(''=>'Select Product');
		if(sizeof($allProducts) > 0){
			$i= 0;
			foreach($allProducts as $product){
				$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
			}
		}
		$rownums= trim($this->input->post('rownums'))+1;
		$rowHTml = '<tr class="gradeX short odd" id="tr_'.$rownums.'">
				<td width="50%">'.
					form_dropdown('pid[]',$products_data,'','class="form-control select2me" id="prod_'.$rownums.'" tabindex="0" placeholder= "Select Product" required="required"').'  
					
				</td>
						
				<td width="20%"> <input type="number" min="0" step="any" class="form-control" name="order_qty[]" value= "" required="required" /> </td>
				<td width="20%"> <input type="number" min="0" step="any" class="form-control" name="order_rate[]" value= "" required="required" /></td>
				<td width="10%">
					<a class="btn default btn-xs red Delete" href="javascript:void(0)" alt="Delete" title="Delete" data_row="'.$rownums.'"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr> ';
			
			$rowHTml .= '<script>
			$(function(){
				$(".Delete").click(function() {
					 var data_row = $(this).attr("data_row");
			 		$("#tr_"+data_row).remove();
				});	
				
				$(".select2me").change(function(){
					 var pfield_id = $(this).attr("id");
					 var txt = $("#"+pfield_id+" option:selected").text();
					 $("#ref_"+pfield_id).val(txt);
				});
            });
			</script>';
		echo $rowHTml;
	}
	/*
	 Add a new rder in the database
	*/
	public function add($order_type= 'tax')
	{
		$data['menutitle'] = 'Invoices';
		$data['pagetitle'] = 'Add Invoice';
		$data['order_type'] = $order_type;
			
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'orders/index/'.$order_type.'">Manage Invoices</a><i class="fa fa-angle-right"></i></li><li>Add '.$order_type.' Invoice</li></ul>';
		
		// get the firm list 
		
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(0=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
		
		// Get list of all state code entries
		$stateList = $this->orders_model->gst_state_codes_list();
		// $taxListArray = array('0'=>'Not Applicable');	
		foreach($stateList as $taxRow){
			 $stateListArray[$taxRow['state_code']] = $taxRow['state_name'];
		}
		$data['gst_state_codes'] = $stateListArray;
		
		// get list of all Products
		$allProducts = $this->product_model->getAllProducts('Yes');
		$products_data = array(''=>'Select Product');
		if(sizeof($allProducts) > 0){
			$i= 0;
			foreach($allProducts as $product){
				$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
			}
		}
		$data['products_data'] = $products_data;
		
		// get the list of all clients assigned to user
		$clientList = $this->clients_model->getAllClients();
		$client_data = array('0'=>'Select Client');
		foreach($clientList as $client){
				$client_data[$client['comp_id']] = $client['comp_name'];
			}
		$data['client_data'] = $client_data;
		
		////
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			
				$this->template->set_layout('admin_default')->build('orders/add_order',$data);
			
		}elseif(trim($this->input->post('submit')) == 'Add Invoice')
		{ 
			// echo '<pre>'; print_r($this->input->post()); die(); 
			$this->form_validation->set_rules('firm_name', 'Firm Name', 'trim|required|greater_than[0]');
			$this->form_validation->set_rules('comp_id', 'Billing Address', 'trim|required|greater_than[0]');
			$this->form_validation->set_rules('billing_address', 'Billing Address', 'trim|required');
			//$this->form_validation->set_rules('shipping_address', 'Shipping Address', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
			$this->form_validation->set_rules('order_date', 'Challan/Invoice Date', 'trim|required');
			//$this->form_validation->set_rules('payment_reminder', 'Payment Reminder', 'trim|required');
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 
				 
				 $this->template->set_layout('admin_default')->build('orders/add_order',$data);
		     } 
			 else
			 {
				 $data_order = array();
				 $data_order['comp_id'] = trim($this->input->post('comp_id'));
				 if(trim($this->input->post('payment_reminder')) != ''){
				 	$data_order['payment_reminder'] = trim($this->input->post('payment_reminder'));
				 }else {
				 	$data_order['payment_reminder'] = '0000-00-00';
				 }
				 
				 $data_order['order_type'] = trim($order_type);
				 $data_order['invoice_firm'] = trim($this->input->post('firm_name'));
				 $data_order['billing_address'] = trim($this->input->post('billing_address'));
				 $data_order['shipping_address'] = trim($this->input->post('billing_address'));
				 $data_order['contact_person'] = trim($this->input->post('contact_person'));
				 $data_order['state_code'] = trim($this->input->post('state_code'));				 
				 $data_order['uid'] = $this->session->userdata('userid');
				 $data_order['order_date'] = trim($this->input->post('order_date'));// date('Y-m-d');				 
      			 $data_order['updated_by'] = $this->session->userdata('userid');
				 $data_order['updated_date'] = date('Y-m-d');				 
				
				 //$data_order_prod['prod_ref_name'] = $this->input->post('prod_ref_name');
				 $data_order_prod['pid'] = $this->input->post('pid');
				 $data_order_prod['order_rate'] = $this->input->post('order_rate');
				 $data_order_prod['order_qty'] = $this->input->post('order_qty');
				 $data_order_prod['updated_by'] = $this->session->userdata('userid');
				 $data_order_prod['updated_date'] = date('Y-m-d');
				 // echo '<pre>'; print_r($data_order);  echo '<pre>'; print_r($data_order_prod);  die();		 
				 $id = $this->orders_model->addOrder($data_order, $data_order_prod);
				 if($id > 0){
					 $arr_msg = array('suc_msg'=>'Order added successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to add Order');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('orders/index/'.$order_type);
			 }
		}
	}
	
	/*
	 View the order details based on the order number and user_id
	*/
	
	public function view($order_id = 0)
	{    
		 
		if($order_id > 0){	
			$data['menutitle'] = 'Invoices';
		    $data['pagetitle'] = 'Add Invoice';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'orders">Manage Orders</a> <i class="fa fa-angle-right"></i> </li><li>View Order</li></ul>';
			// get the order details and order products
			$orderDetails = $this->orders_model->getOrderDetails($order_id);
			$orderProducts = $this->orders_model->getOrderProducts($order_id);
			$data['orderDetails'] = $orderDetails;	
			$data['orderProducts'] = $orderProducts;	
			//echo '<pre>'; print_r($data); die();
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('orders/view_order',$data);
					
			}
		}else {
				redirect('orders');
		}			
	}
	
	/*
	 View the order details based on the order number and user_id
	*/
	
	public function edit($order_id)
	{    
		 
		if($order_id > 0){	
			$data['menutitle'] = 'Invoices';
		    $data['pagetitle'] = 'Edit Invoice';
			$orderDetails = $this->orders_model->getOrderDetails($order_id);
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'orders/index/'.strtolower($orderDetails[0]['order_type']).'">Manage Invoices</a> <i class="fa fa-angle-right"></i> </li><li>Edit Invoice</li></ul>';
			// get the order details and order products
			
			$orderProducts = $this->orders_model->getOrderProducts($order_id);
			//echo '<pre>'; print_r($orderDetails); die();
			$data['orderDetails'] = $orderDetails;	
			$data['orderProducts'] = $orderProducts;
			// get the firm array
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array();	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
			// Get list of all state code entries
			$stateList = $this->orders_model->gst_state_codes_list(); 
			foreach($stateList as $taxRow){
				 $stateListArray[$taxRow['state_code']] = $taxRow['state_name'];
			}
			$data['gst_state_codes'] = $stateListArray;	
			
			// get list of all Products
		$allProducts = $this->product_model->getAllProducts('Yes');
		$products_data = array(''=>'Select Product');
		if(sizeof($allProducts) > 0){
			$i= 0;
			foreach($allProducts as $product){
				$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
			}
		}
		$data['products_data'] = $products_data;	
			
			// Get list of all companies/clients
			/*$clientArray[] = '';
			$allClients = $this->clients_model->getAllClients();
			foreach($allClients as $client){
				 $clientArray[$client['comp_id']] = $client['comp_name'];
			}
			$data['client_list'] = $clientArray;*/
			
			// echo '<pre>'; print_r($data ); die();
			
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('orders/edit_order',$data);
			}elseif(trim($this->input->post('submit')) == 'Edit Invoice')
			{ 
						
				//$this->form_validation->set_rules('firm_name', 'Firm Name', 'trim|required|numeric|greater_than[0]'); // |is_unique[product.item_code]
				$this->form_validation->set_rules('billing_address', 'Billing Address', 'trim|required');
				//$this->form_validation->set_rules('shipping_address', 'Shipping Address', 'trim|required');
				$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
				// echo '<pre>'; print_r($this->input->post()); die();
				 if ($this->form_validation->run($this) == FALSE)
				 {
					 $order_details['firm_name'] = trim($this->input->post('firm_name'));
					 $order_details['billing_address'] = trim($this->input->post('billing_address'));
					 // $order_details['shipping_address'] = trim($this->input->post('shipping_address'));
					 $order_details['contact_person'] = trim($this->input->post('contact_person'));
					 //$order_details['tax_id'] = trim($this->input->post('tax_id'));
					 // $order_details['contact_person'] = trim($this->input->post('contact_person'));
					 //$order_details['excise'] = trim($this->input->post('excise'));
					// $order_details['po_date'] = trim($this->input->post('po_date'));
					 //$order_details['po_ref'] = trim($this->input->post('po_ref'));
					 //$order_details['party_challan_no'] = trim($this->input->post('party_challan_no'));
					 //$order_details['party_challan_date'] = trim($this->input->post('party_challan_date'));
					 $order_details['order_number'] = $orderDetails[0]['order_number'];
					 $order_details['order_id'] = trim($order_id);
					 $order_details['comp_name'] = $orderDetails[0]['comp_name'];
					 //$order_details['payment_reminder'] = trim($this->input->post('payment_reminder'));
					 	
					 $data['orderDetails'][0] = $order_details;
					 $this->template->set_layout('admin_default')->build('orders/edit_order',$data);
				 }
				 else
				 {
					 $data_insert = array();
					 $data_insert['billing_address'] = trim($this->input->post('billing_address'));
					 $data_insert['shipping_address'] = trim($this->input->post('shipping_address'));
					 $data_insert['contact_person'] = trim($this->input->post('contact_person'));
					 $data_insert['state_code'] = trim($this->input->post('state_code'));
					// $data_insert['po_date'] = trim($this->input->post('po_date'));
					 //$data_insert['po_ref'] = trim($this->input->post('po_ref'));
					 //$data_insert['party_challan_no'] = trim($this->input->post('party_challan_no'));
				 	// $data_insert['party_challan_date'] = trim($this->input->post('party_challan_date'));
				     $data_insert['payment_reminder'] = trim($this->input->post('payment_reminder'));  				 	
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');	
					 // create the order products array 
					 
					 $data_order_prod['pid'] = $this->input->post('pid');
					 $data_order_prod['order_rate'] = $this->input->post('order_rate');
					 $data_order_prod['order_qty'] = $this->input->post('order_qty');
					 $data_order_prod['updated_by'] = $this->session->userdata('userid');
					 $data_order_prod['updated_date'] = date('Y-m-d');
					  
					 // echo '<pre>'; print_r($data_insert);  echo '<pre>'; print_r($order_id);   echo '<pre>'; print_r($data_order_prod); die(); 
					 $id = $this->orders_model->updateOrder($data_insert,$order_id, $data_order_prod);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Invoice Updated successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to update Invoice','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('orders/edit/'.$order_id);
				 }
			}	
			
		}else {
				redirect('orders/index/'.strtolower($orderDetails[0]['order_type']));
		}			
	}
	
	/* Delete the order product based on the id*/
	function del_prod(){
		$id = $this->input->post('id');
		if($id > 0){
		  echo $deleted = $this->orders_model->deleteOrderProd($id);
		}else{
			echo 0;
		}
	}
	
	/* Add product in order */
	public function add_order_prod()
	{
		//echo '<pre>'; print_r($this->input->post()); die();  
		$this->form_validation->set_rules('order_id', 'Order Number', 'trim|required|numeric|greater_than[0]'); // |is_unique[product.item_code]
		$this->form_validation->set_rules('order_pid', 'Order Product', 'trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules('prod_ref_name', 'Product Reference Name', 'trim|required');
		$this->form_validation->set_rules('order_qty', 'Product Quantity', 'trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules('order_rate', 'Product Rate', 'trim|required|greater_than[0]');
		$this->form_validation->set_rules('order_packing', 'Product Packing', 'trim|required|greater_than[0]');
		 if ($this->form_validation->run($this) == FALSE){
			echo validation_errors(); 
		}else{
		           $data_insert = array();
					 $order_id = trim($this->input->post('order_id'));
					 $data_insert['order_id'] = trim($this->input->post('order_id'));
					 $data_insert['order_pid'] = trim($this->input->post('order_pid'));
					 $data_insert['prod_ref_name'] = trim($this->input->post('prod_ref_name'));
					 $data_insert['order_qty'] = trim($this->input->post('order_qty'));
					 $data_insert['order_rate'] = trim($this->input->post('order_rate'));
					 $data_insert['order_packing'] = trim($this->input->post('order_packing'));
					 $data_insert['notes'] = trim($this->input->post('notes'));
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');	 
					 $id = $this->orders_model->updateOrderProduct($data_insert);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Product added successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to add product','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 echo '1';
		}
	}
	
	
	
	// get batch details based on the batch number
	public function order_prod_details(){
	     $order_prod_id = $this->input->post('id');
		// get the product row description details based on the id
		$order_prod_description = $this->orders_model->getOrderProduct($order_prod_id);
		if(sizeof($order_prod_description[0]) > 0){		
		$html = '<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Product Name</label>
                  <span class="form-control form-control-view">'.$order_prod_description[0]['prod_ref_name'].'</span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Order Quantity</label>
                  <span class="form-control form-control-view">'.$order_prod_description[0]['order_qty'].'</span>
                </div>
              </div>
              <!--/span--> 
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Order Rate</label>
                  <span class="form-control form-control-view">'.$order_prod_description[0]['order_rate'].'</span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Dispatch Quantity</label>
                  <span class="form-control form-control-view">'.$order_prod_description[0]['dispatch_qty'].'</span>
                </div>
              </div>
              <!--/span--> 
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Order Packing</label>
                  <span class="form-control form-control-view">'.$order_prod_description[0]['order_packing'].'</span>
                </div>
              </div>
              <!--/span-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Notes</label>
                  <span class="form-control form-control-view">'.nl2br($order_prod_description[0]['notes']).'</span>
                </div>
              </div>
              <!--/span--> 
            </div>';
		}else{
			$html = '<div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <span class="form-control form-control-view">No Such Record Found.</span>
                </div>
              </div>
			 </div>';
		}	
		echo $html;
	}
	
	/* Get the client information based on the client id*/
	public function client_info(){
		$comp_id = $this->input->post('comp_id');
		if($comp_id > 0){
		   $client_info = $this->clients_model->getClientInfo($comp_id);
		   
		  /* $result = array('outcome'=>1,'contact_person'=>$client_info[0]['primary_contact'],'shipping_address'=>$client_info[0]['shipping_address'],'billing_address'=>$client_info[0]['shipping_address']);*/
			$result['outcome'] = 1;
			// $result['supl_id'] = trim($client_info[0]['comp_id']);
			$result['contact_person'] = trim($client_info[0]['primary_contact']);
			$result['shipping_address'] = trim($client_info[0]['shipping_address']);
			$result['billing_address'] = trim($client_info[0]['shipping_address']);
				
		   //$result = array('outcome'=>1,'comp_data'=>$client_info[0]['primary_contact'].'##'.$client_info[0]['shipping_address'].'##'.$client_info[0]['shipping_address']);
		   
		}else{
			$result = array('outcome'=>0,'result'=>'Something Went wrong');
		}
		echo json_encode($result); die();
	}
	
	
	
	/*
	 Update the order status to "Close" based on the order_id
	*/
	
	public function close()
	{    
		$order_id = $this->input->post('orderId'); 
		if($order_id > 0){	
			 
			 $data_insert['order_status'] = 'Closed';	
			 $data_insert['updated_by'] = $this->session->userdata('userid');
			 $data_insert['updated_date'] = date('Y-m-d');	 
			 $id = $this->orders_model->updateOrder($data_insert,$order_id);
			 if($id > 0){
				 $arr_msg = array('suc_msg'=>'Order Closed successfully!','msg-type'=>'success');
			 }else{
				 $arr_msg = array('suc_msg'=>'Failed to Close Order','msg-type'=>'danger');
			 }	
			 echo 1;
			
		}else {
				echo 0;
		}			
	}
	
	/* Create Order Challan */
	public function create_challan($order_id = 0){
	   //echo $order_id.'<pre>'; print_r($this->input->post()); die();
		if($order_id > 0){
			$data['menutitle'] = 'Orders';			
			$data['pagetitle'] = 'Create Challan';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'orders">Manage Orders</a> <i class="fa fa-angle-right"></i> </li><li>Create Challan</li></ul>';
			// get the order details and order products
			$orderDetails = $this->orders_model->getOrderDetails($order_id);
			$orderProducts = $this->orders_model->getOrderProducts($order_id);
			//$packingProducts = $this->orders_model->getPackingProducts();
			$data['orderDetails'] = $orderDetails;	
			$data['orderProducts'] = $orderProducts;
			// get all the products of particular order based on the order id
			$pendingProducts = array();
			$orderPendingProducts = $this->orders_model->getOrderPendingProducts($order_id);
			foreach($orderPendingProducts as $orderPendingProduct){
				$pendingProducts[$orderPendingProduct['id']] = $orderPendingProduct;
		      $balancedLots = $this->orders_model->getProductBalancedLots($orderPendingProduct['order_pid'],round($orderPendingProduct['order_packing'],2),$orderDetails[0]['invoice_firm']);
				$pendingProducts[$orderPendingProduct['id']]['batches'] = $balancedLots; 
				
			}
			$data['pendingProducts'] = $pendingProducts;
			//echo '<pre>'; print_r($data['pendingProducts']); die();
			// get the packing material products
			$packingProducts = array();
			$orderPackingProducts = $this->product_model->getPackingProducts();
			foreach($orderPackingProducts as $orderPackingProduct){
				$packingProducts[$orderPackingProduct['pid']] = $orderPackingProduct;
				$packingBalancedLots = $this->orders_model->getProductBalancedLots($orderPackingProduct['pid'],0,$orderDetails[0]['invoice_firm']);
				$packingProducts[$orderPackingProduct['pid']]['batches'] = $packingBalancedLots; 
				
			}
			$data['packingProducts'] = $packingProducts;
			//echo '<pre>'; print_r($data['packingProducts']); die();
				if($this->session->userdata('err_msg') != '')
				{
						$data['err_msg'] = $this->session->userdata('err_msg');
						$this->session->unset_userdata('err_msg');
				}
				
				if(trim($this->input->post('submit')) == '')
				{
					$this->template->set_layout('admin_default')->build('orders/create_challan',$data);
				}elseif(trim($this->input->post('submit')) == 'Create Challan')
				{ 
					//echo '<pre>'; print_r($this->input->post()); die();					
					$this->form_validation->set_rules('shipping_address', 'Shipping Address', 'trim|required');
					
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  	
					 $data['orderDetails'] = $orderDetails;	
					 $data['orderDetails'][0]['shipping_address'] = trim($this->input->post('shipping_address'));					 
					 $data['orderDetails'][0]['logistic_remark'] = trim($this->input->post('logistic_remark'));
					 $data['orderProducts'] = $orderProducts;
					$this->template->set_layout('admin_default')->build('orders/create_challan',$data);
				 }
				 else
				 {					 
						 $data_order = array();
						 $date = date('Y-m-d');
						 // Order Challan Table
						 $j=0;
						 $lot_no = $this->input->post('batchId');
						 
						 foreach($lot_no as $lotId){
						
						 	$productStock = array();
							$totalDispatchQty =0;
							$totalProdAmt =0;
							$bagNo = $this->input->post('bagNo'.$lotId);
							$packingUnits = $this->input->post('packing'.$lotId);		
							$qtyPerBag = $this->input->post('qPbag'.$lotId);
							$reffIdArray = $this->input->post('reffId'.$lotId);
							$pid_array = $this->orders_model->getPidByBatch($lotId);
							$pid = $pid_array[0]['pid'];
							
							
							//echo $pid; 
							//echo '<pre>'; print_r($bagNo); 
							//echo '<pre>'; print_r($qtyPerBag); 
							//echo '<pre>'; print_r($reffIdArray); 
							
							for($i=0;$i < sizeof($bagNo); $i++){					
								if($bagNo[$i] >0 && $qtyPerBag[$i] > 0){
									$saleRate = $this->orders_model->getProdSaleRateByReff($pid, $reffIdArray[$i]);	
									//echo 'bagNo=>'.$bagNo[$i].'====>'.'qtyPerBag=>'.$qtyPerBag[$i];
									$dispatchQty = ($bagNo[$i] * $qtyPerBag[$i]);														
									$totalDispatchQty += $dispatchQty;	
									$totalAmt = $saleRate[0]['order_rate'] * $dispatchQty;	
									$totalProdAmt += $totalAmt;	
									$reffId = $reffIdArray[$i];
									
									$data_order_challan['order_id'] = $order_id;
									$data_order_challan['order_pid'] = $pid;
									$data_order_challan['no_bags'] = $bagNo[$i];
									$data_order_challan['qty_per_bag'] = $qtyPerBag[$i];
									$data_order_challan['lot_no'] = $lotId;
									$data_order_challan['chalan_date'] = $date;	
									$data_order_challan['packing_units'] = $packingUnits[$i];																	
									$data_order_challan['challan_by'] = $this->session->userdata('userid');
									//$data_order_challan['updated_by'] = $this->session->userdata('userid');
									//$data_order_challan['updated_date'] = $date;
									$data_order_challan['ref_id'] = $reffId;
									
									if(array_key_exists($reffId,$productStock)){
										 $productStock[$reffId] = $totalDispatchQty;
										 $prodRate[$reffId] = $saleRate[0]['order_rate'];
										 $prodAmount[$reffId] = $totalProdAmt;
									 }else {
										 $productStock[$reffId] = $dispatchQty;
										 $prodRate[$reffId] = $saleRate[0]['order_rate'];
										 $prodAmount[$reffId] = $totalAmt;										 
										 $totalProdAmt = $totalAmt;	
										 $totalDispatchQty = $dispatchQty;				 
									 }
									 $data_order[$j]['order_challan'][] = $data_order_challan;									 
									 
								  // 									
								}
								
							}
							//echo '<pre>'; print_r($productStock); echo '<pre>'; print_r($prodRate);echo '<pre>'; print_r($prodAmount);die();
							 //echo '<pre>'; print_r($data_order); 
							//
							if(sizeof($productStock) > 0){			 
								foreach($productStock as $key => $value){
									//echo '<br/>'.$key.'==>'.$value;
									$prodStock = $this->orders_model->getStockByBatch($lotId);
									$currentStock = $prodStock[0]['instock'] - $value;	
									$prodSaleRate = $prodRate[$key];
									$prodSaleAmt = $prodAmount[$key];	
									
									$data_insert_stock['id'] = $key;
									$data_insert_stock['pid'] = $pid;
									$data_insert_stock['comp_id'] = $orderDetails[0]['comp_id'];
									$data_insert_stock['order_id'] = $order_id;
									$data_insert_stock['challan_no'] = '';
									$data_insert_stock['outw_qty'] = $value;
									$data_insert_stock['lot_no'] = $lotId;
									$data_insert_stock['rate'] = $prodSaleRate;
									$data_insert_stock['amount'] = $prodSaleAmt;
									$data_insert_stock['instock'] = $currentStock;
									$data_insert_stock['on_date'] = $date;
									$data_insert_stock['batch_desc'] = 'batch_desc here';
									$data_order[$j]['insert_stock'] = $data_insert_stock;		
								 }	
								 	
							  }
							   
							  $j++;
						 	 
							 
							  
						 }
						
						 $data_other_details['shipping_address'] = trim($this->input->post('shipping_address'));
						 $data_other_details['logistic_remark'] = trim($this->input->post('logistic_remark'));
						 $data_other_details['firm_id'] = trim($orderDetails[0]['invoice_firm']);
						 $data_other_details['order_by'] = trim($orderDetails[0]['uid']);
						 
						 		  
						 // update the database						 
						 $chalanNumber = $this->orders_model->createChallan($data_order,$data_other_details);
						if($chalanNumber != 'False' ){
							$arr_msg = array('suc_msg'=>'New Challan # is:'.$chalanNumber,'msg-type'=>'success');
						}else{
							$arr_msg = array('suc_msg'=>'Failed to create a new challan number','msg-type'=>'danger');
						}	
						 $this->session->set_userdata($arr_msg);		 
						redirect('orders');
						
				  }		
						
			 }
		
		
		}else{ 
			redirect('orders');
		}
		//echo '<pre>'; print_r($pendingProducts); die();	
	}
	
	/* View Order Challan */
	public function view_challan($order_type, $order_id){
	   //echo $order_id.'<pre>'; print_r($this->input->post()); die();
		if($order_id > 0 && $order_type != ''){
		   
			$data['menutitle'] = 'Invoices';			
			$data['pagetitle'] = 'View Challan';
			$data['order_type'] = $order_type;
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'orders/index/'.$order_type.'">Manage '.$order_type.' Invoices</a> <i class="fa fa-angle-right"></i> </li><li>View Challan</li></ul>';
			
			// get the order details 
			$orderDetails = $this->orders_model->getOrderDetails($order_id);	
			$data['orderDetails'] = $orderDetails;
			// get order products 
			$orderProducts = $this->orders_model->getOrderProducts($order_id);
			$data['orderProducts'] = $orderProducts;
			// get client details 
			$clientInfo = $this->clients_model->getClientInfo($orderDetails[0]['comp_id']);
			$data['clientInfo'] = $clientInfo;
			// get the firm CST AND VAT no.
			$firmDetails = $this->orders_model->getFirmDetails($orderDetails[0]['invoice_firm']);
			$data['firmDetails'] = $firmDetails;
			
			
				if(sizeof($orderDetails) > 0 && sizeof($orderProducts) > 0){
					if($this->session->userdata('err_msg') != '')
					{
							$data['err_msg'] = $this->session->userdata('err_msg');
							$this->session->unset_userdata('err_msg');
					}
				
					/* For update the LR and Transport start here */
					if(trim($this->input->post('submit')) == '')
					{
						$this->template->set_layout('admin_default')->build('orders/view_challan',$data);
					}
				
				/* For update the LR and Transport ends here */
				
				/* For downlaod challan PDF start here */
					if(trim($this->input->post('submit_challan')) == 'Print Challan')
					{
						
						 $this->load->library('M_pdf');
					 	
						//load the view, pass the variable and do not show it but "save" the output into $html variable
						$challan_html = $this->load->view('orders/pdf_challan', $data, true);
						//echo $challan_html; die();
						//this the the PDF filename that user will get to download
						$pdfFilePath = $orderDetails[0]['challan_number'].".pdf";				
						
						//actually, you can pass mPDF parameter on this load() function
						 //$this->load->library('M_pdf');
						 //generate the PDF!
						 $this->m_pdf->pdf->WriteHTML($challan_html);
						//$pdf->WriteHTML($challan_html);
						//offer it to user via browser download! (The PDF won't be saved on your server HDD)
						ob_clean(); 
						$this->m_pdf->pdf->Output($pdfFilePath, "D"); //  $pdfFilePath, "D"
						
						//$pdf->Output($pdfFilePath, "D");
					}
				/* For downlaod challan PDF end here */
			  } else {
			   
					$arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');				 
					$this->session->set_userdata($arr_msg);
					redirect('orders/index/'.$order_type);
			  }	
				
		}else{ 
			redirect('orders/index/'.$order_type);
		}
		//echo '<pre>'; print_r($pendingProducts); die();	
	}
	
	// Add a new row for batch so that dispatcher can add new row with # of bags and Quantity
	public function add_new_quantity_row(){
	    // $order_prod_id = $this->input->post('id');
		 $lotId = $this->input->post('lotId');
		 $lotCnt = $this->input->post('lotCnt');
		 $lotNum = $this->input->post('lotNum');
		 $reffNum = $this->input->post('reffNum');
		if($lotId != '') {	
		$html = '<tr>              
              <td >&nbsp;</td>  
			  <td width="25%"><input type="text" required="required" class="calculate form-control" style="width:70%; float:left;" name="bagNo'.$lotNum.'[]" value="0" id="bagNo'.$lotId.$lotCnt.'" size="8" />
			   <input type="hidden" name="reffId'.$lotNum.'[]" value="'.$reffNum.'" />
			  </td>
			   <td width="25%"><input required="required" type="text" class="calculate form-control" style="width:70%; float:left;" name="qPbag'.$lotNum.'[]" value="0" id="qPbag'.$lotId.$lotCnt.'" size="8" /></td>
			   <td width="25%"><span id="lotQty'.$lotId.$lotCnt.'" title="lot#'.$lotId.'">0</span></td>
			   <td width="25%"><input required="required" type="text" class="form-control" style="width:100%; float:left;" name="packing'.$lotNum.'[]" value="" placeholder="Bags, Drums, Bottle, Box" id="packing'.$lotId.$lotCnt.'" size="8" /></td> 
			   <td >&nbsp;</td>         
            </tr>';
		}else{
			$html = '<div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <span class="form-control form-control-view">No Such Record Found.</span>
                </div>
              </div>
			 </div>';
		}	
		echo $html;
	}
	
	
	
	/* View Order invoice */
	public function view_invoice($order_type, $order_id){
	   //echo $order_id.'<pre>'; print_r($this->input->post()); die();
		if($order_id > 0 && $order_type != ''){
		    
			$data['menutitle'] = 'Invoices';			
			$data['pagetitle'] = 'View Invoice';
			$data['order_type'] = $order_type;
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'orders/index/'.$order_type.'">Manage '.$order_type.' Invoices</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'orders/view_challan/'.$order_type.'/'.$order_id.'">View Challan</a> <i class="fa fa-angle-right"></i> </li><li>View Invoice</li></ul>';
			
			// get the order details 
			$orderDetails = $this->orders_model->getOrderDetails($order_id);	
			$data['orderDetails'] = $orderDetails;
			// get order products 
			$orderProducts = $this->orders_model->getOrderProducts($order_id);
			$data['orderProducts'] = $orderProducts;
			// get client details 
			$clientInfo = $this->clients_model->getClientInfo($orderDetails[0]['comp_id']);
			$data['clientInfo'] = $clientInfo;	
			// get the firm CST AND VAT no.
			$firmDetails = $this->orders_model->getFirmDetails($orderDetails[0]['invoice_firm']);
			$data['firmDetails'] = $firmDetails;
			 // echo '<pre>'; print_r($data); die();
			
			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			 
			/* For update the LR and Transport start here */
				if(trim($this->input->post('submit')) == '')
				{
					$this->template->set_layout('admin_default')->build('orders/view_invoice',$data);
				}elseif(trim($this->input->post('submit')) == 'Confirm Invoice')
				{
					// Insert entry in invoice_payments and update the forwording amount and discount table after confirmation of invoice from Account/Admin
					
					$invoiceArray = array();
					// $invoiceArray['forwardingAmt'] = trim($this->input->post('forwardingAmt'));
					$invoiceArray['discount'] = trim($this->input->post('discountAmt'));
					$invoiceArray['order_status'] = 'Completed';
					
					$insertPayment = array();
					$insertPayment['invoice_number'] = $orderDetails[0]['invoice_number'];
					$insertPayment['client_id'] = $orderDetails[0]['comp_id'];
					$insertPayment['invoice_amount'] = trim($this->input->post('finalOrderTotal'));
					$insertPayment['firm_id'] = $orderDetails[0]['invoice_firm'];
					$insertPayment['order_by'] = $orderDetails[0]['uid'];
					$insertPayment['reminder_date'] = $orderDetails[0]['payment_reminder']; //date('Y-m-d', strtotime($challanDetails[0]['invoice_date']. ' + '.$orderDetails[0]['payment_reminder'].' days')); //;
					$insertPayment['updated_by'] = $this->session->userdata('userid');
					$insertPayment['updated_date'] = date('Y-m-d');
					// Update the database
					// echo '<pre>'; print_r($insertPayment); echo '<pre>'; print_r($invoiceArray); die();
					
				 	$id = $this->orders_model->updateInvoicePayments($invoiceArray,$order_id,$insertPayment);
										 
					if($id == 1 ){
						$arr_msg = array('suc_msg'=>'Invoice # '.$orderDetails[0]['invoice_number'].' is updated successfully','msg-type'=>'success');
					}else{
						$arr_msg = array('suc_msg'=>'Failed to update invoice number '.$challanDetails[0]['invoice_number'],'msg-type'=>'danger');
					}	 
					$this->session->set_userdata($arr_msg);
					redirect('orders/view_invoice/'.$order_type.'/'.$order_id);
					
				}
			
			/* For update the LR and Transport ends here */
			
			/* For downlaod challan PDF start here */
				if(trim($this->input->post('submit_challan')) == 'Print Invoice')
				{
					
					//load the view, pass the variable and do not show it but "save" the output into $html variable
					/*if($orderDetails[0]['invoice_firm'] == 1){
						$invoice_html = $this->load->view('orders/pdf_invoice', $data, true);
					}else{
						$invoice_html = $this->load->view('orders/pdf_invoice_excise', $data, true);
					}*/
					//actually, you can pass mPDF parameter on this load() function
					 $this->load->library('M_pdf');
					
					$invoice_html = $this->load->view('orders/pdf_invoice', $data, true);
					//echo $invoice_html; die();
					//this the the PDF filename that user will get to download
					$pdfFilePath = $orderDetails[0]['invoice_number'].".pdf";				
					
					
					//generate the PDF!
					 $this->m_pdf->pdf->WriteHTML($invoice_html);
					//$pdf->WriteHTML($challan_html);
					//offer it to user via browser download! (The PDF won't be saved on your server HDD)
					ob_clean(); 
				    $this->m_pdf->pdf->Output($pdfFilePath, "D"); //  $pdfFilePath, "D"
					//$pdf->Output($pdfFilePath, "D");
				}
			/* For downlaod challan PDF end here */
			
				
		}else{ 
			redirect('orders');
		}
		//echo '<pre>'; print_r($pendingProducts); die();	
	}
	
	
	
	
	
}
