<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_orders extends CI_Controller {  

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
		$this->load->model('suppliers_model');
		$this->load->model('purchase_orders_model');
		//$this->load->model('purchase_enquires_model');
		$this->load->model('user_model');
		$this->load->model('orders_model');
		$this->load->library('pagination');//load pagination library
		
		if (!is_admin_logged_in()) {
		   
            redirect('');
        } 
	}
	
	/*
	 Get the list of all leads based on the type 
	*/
	public function index()
	{    
			$stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 	$enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
		 
			$data['menutitle'] = 'Purchase Orders';			
			$data['sdate']=$stardate ;
			$data['todate']=$enddate;
			$data['firm_id']= 0;
			  
			$data['pagetitle'] = 'Manage Purchase Orders';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Purchase Orders</li></ul>';
			
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
			$ordersArray = $this->purchase_orders_model->getAllPurchaseOrders($stardate,$enddate, $data['firm_id']); //$stardate,$enddate
			
			//echo '<pre>'; print_r($ordersArray); die();
			
			$data['purchase_orders'] = $ordersArray;
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
		     	 	 ->build('purchase_orders/manage_orders',$data);
					
			}
					
	}
	
	
	/* Add purcahse order and purchase t in database */
	public function create_order($enquiry_id){
	   if($enquiry_id > 0){
	 		$data['menutitle'] = 'Purchase Orders';			
			$data['pagetitle'] = 'Create Order';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Create Purchase Order</li></ul>';
			
			// get the order details and order products
			$enquiryDetails = $this->purchase_enquires_model->getEnquiryDetails($enquiry_id);
			$enquiryProducts = $this->purchase_enquires_model->getEnquiryProducts($enquiry_id);
			//echo '<pre>'; print_r($enquiryDetails); die();
			$data['enquiryDetails'] = $enquiryDetails;	
			$data['enquiryProducts'] = $enquiryProducts;
			
			// Get list of all tax(VAT/CST) entries
			$taxList = $this->orders_model->getTaxList('Both');
			$taxListArray = array('0'=>'Not Applicable');	
			foreach($taxList as $taxRow){
				 $taxListArray[$taxRow['tax_id']] = $taxRow['tax_per'].'% '.$taxRow['tax_type'];
			}
			$data['taxList'] = $taxListArray;
			
			// Get list of excise tax entries
			$exciseTaxList = $this->orders_model->getExciseTaxList('Excise');
			$exciseTaxListArray = array('0'=>'Not Applicable');	
			foreach($exciseTaxList as $exciseRow){
				 $exciseTaxListArray[$exciseRow['tax_per']] = $exciseRow['tax_per'].'% ';
			}
			$data['exciseTaxList'] = $exciseTaxListArray;
			// Get all transports
			 $transportsList = array(''=>'Not Sure');
			 $transportsArray = $this->orders_model->getTransportsList();
			 if(sizeof($transportsArray) > 0){
			 	foreach($transportsArray as $transport){
					//echo '<pre>'; print_r($transport);
					$transportsList[$transport['transport_name']] = $transport['transport_name'];
				}
			 }
			 $data['transportsList'] = $transportsList;	
			
			if(sizeof($enquiryDetails)> 0 && ($enquiryDetails[0]['enquiry_status'] == 'Open') ){
				//echo '<pre>'; print_r($data); die();
				if($data != false)
				{ 
					$this->template
						 ->set_layout('admin_default')
						 ->build('purchase_orders/add_order',$data);
						
				}
			}else{
			    $arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
				$this->session->set_userdata($arr_msg);
				redirect('purchase_enquires');
			}	
			// echo '<pre>'; print_r($data); die();			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			
			if(trim($this->input->post('submit')) == '')
			{
				
					$this->template->set_layout('admin_default')->build('purchase_orders/add_order',$data);
				
			}elseif(trim($this->input->post('submit')) == 'Create Order')
		    { 
					 
				 if(sizeof($enquiryDetails) > 0){
				 	
					 $data_pourc_order = array();
					 $data_pourc_order['enquiry_id'] = $enquiryDetails[0]['enquiry_id'];
					 $data_pourc_order['purc_order_number'] = ''; // to be filled at model level					 
					 $data_pourc_order['order_by'] = $this->session->userdata('userid');
					 $data_pourc_order['supplier_id'] = $enquiryDetails[0]['supli_id'];
					 $data_pourc_order['firm_id'] = $enquiryDetails[0]['firm_id'];
					 $tax_id =  trim($this->input->post('tax_id'));					 
					 // get the tax row details
					 $taxRow = $this->orders_model->getTaxRow($tax_id);
					 $data_pourc_order['tax_per'] = $taxRow[0]['tax_per'];
					 $data_pourc_order['tax_type'] = $taxRow[0]['tax_type'];
					 $data_pourc_order['tax_id'] = $taxRow[0]['tax_id'];
					 
					 $data_pourc_order['excise'] = trim($this->input->post('excise'));
					 $data_pourc_order['pay_term'] = trim($this->input->post('pay_term'));
					 $data_pourc_order['payment_reminder'] = trim($this->input->post('payment_reminder'));
					 $data_pourc_order['expected_delivery'] = trim($this->input->post('expected_delivery'));
					 $data_pourc_order['order_remark'] = trim($this->input->post('order_remark'));
				     $data_pourc_order['updated_by'] = $this->session->userdata('userid');
					 $data_pourc_order['updated_date'] = date('Y-m-d');
					 $data_pourc_order['order_date'] = date('Y-m-d');
					 $data_pourc_order['transport_name'] = trim($this->input->post('transport_name'));
					 $data_pourc_order['delivery_address'] = trim($this->input->post('delivery_address'));				 
					 // create a array of purchase product
					 $pid_array = $this->input->post('pid');
					 $prod_ref_name_array = $this->input->post('prod_ref_name');
					 $order_rate_array = $this->input->post('order_rate');  
					 $order_qty_array = $this->input->post('order_qty');
					 $packing_size_array = $this->input->post('packing_size'); 
					 $packing_array = $this->input->post('packing'); 
					 $notes_array = $this->input->post('notes'); 
					 
					  
					 $purchased_products = array();
					 if(sizeof($pid_array) > 0){
						$j= 0;
						foreach($pid_array as $pid){
							if($pid > 0){	
								$purchased_products[$j]['purc_order_id'] = ''; // to be filled at model level
								$purchased_products[$j]['purchase_pid'] = $pid;
								$purchased_products[$j]['purchase_qty'] = $order_qty_array[$j];
								$purchased_products[$j]['purchase_rate'] = $order_rate_array[$j];
								$purchased_products[$j]['notes'] = $notes_array[$j];
								$purchased_products[$j]['prod_ref_name'] = $prod_ref_name_array[$j];
								$purchased_products[$j]['packing_size'] = $packing_size_array[$j];
								$purchased_products[$j]['packing'] = $packing_array[$j];
								$purchased_products[$j]['updated_by'] = $this->session->userdata('userid');
								$purchased_products[$j]['updated_date'] = date('Y-m-d');
							}	
							$j++;
						}
					 }
					 
					 //echo '123<pre>'; print_r($data_pourc_order);
					 //echo '123<pre>'; print_r($purchased_products); die();
					 
					 							 
					 $id = $this->purchase_orders_model->createPurchaseOrder($data_pourc_order, $purchased_products);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Purchase Order created successfully!!!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to create purchase order','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('purchase_orders/'); // purchase_orders
			  }
			 
		}
			
			
		}else{
			redirect('purchase_enquires');
		}
	}
	
	/* Edit the purchase Order based on the order id */
	
	public function edit($purc_order_id){
		if($purc_order_id > 0){
			$data['menutitle'] = 'Purchase Orders';			
			$data['pagetitle'] = 'Update Order';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'purchase_orders/">Manage Purchase Orders</a> <i class="fa fa-angle-right"></i> </li><li>Edit Purchase Order</li></ul>';
		
		// get the purchase order details 
			$purchaseOrderDetails = $this->purchase_orders_model->getPurchaseOrderDetails($purc_order_id);
			$purchaseOrderProducts = $this->purchase_orders_model->getPurchaseOrderProducts($purc_order_id);			
			$data['purchaseOrderDetails'] = $purchaseOrderDetails;	
			$data['purchaseOrderProducts'] = $purchaseOrderProducts;
			
			// Get list of all tax  entries
			$sgstList = $this->orders_model->getTaxList('SGST');
			$sgstListArray = array('0'=>'Not Applicable');	
			foreach($sgstList as $sgstRow){
				 $sgstListArray[$sgstRow['tax_per']] = $sgstRow['tax_per'].'% '.$sgstRow['tax_type'] ;
			}
			$data['sgstList'] = $sgstListArray;
			
			$cgstList = $this->orders_model->getTaxList('CGST');
			$cgstListArray = array('0'=>'Not Applicable');	
			foreach($cgstList as $cgstRow){
				 $cgstListArray[$cgstRow['tax_per']] = $cgstRow['tax_per'].'% '.$cgstRow['tax_type'] ;
			}
			$data['cgstList'] = $cgstListArray;
			
			$igstList = $this->orders_model->getTaxList('IGST');
			$igstListArray = array('0'=>'Not Applicable');	
			foreach($igstList as $igstRow){
				 $igstListArray[$igstRow['tax_per']] = $igstRow['tax_per'].'% '.$igstRow['tax_type'] ;
			}
			$data['igstList'] = $igstListArray;
			
			
			// get list of all Products
			$allProducts = $this->product_model->getAllProducts();
			$products_data = array(''=>'Select Product');
			if(sizeof($allProducts) > 0){
				$i= 0;
				foreach($allProducts as $product){
					$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
				}
			}
			$data['products_data'] = $products_data;
			// Get all transports
			/*$transportsList = array(''=>'Not Sure');
			 $transportsArray = $this->orders_model->getTransportsList();
			 if(sizeof($transportsArray) > 0){
			 	foreach($transportsArray as $transport){
					//echo '<pre>'; print_r($transport);
					$transportsList[$transport['transport_name']] = $transport['transport_name'];
				}
			 }
			 $data['transportsList'] = $transportsList;	*/
				
			if(sizeof($purchaseOrderDetails)> 0 && ( $purchaseOrderDetails[0]['status'] == 'Open' || $purchaseOrderDetails[0]['status'] == 'Confirmed')){
				//echo '<pre>'; print_r($data); die();
				if($data != false)
				{ 
					$this->template
						 ->set_layout('admin_default')
						 ->build('purchase_orders/edit_order',$data);
						
				}
			}else{
			    $arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
				$this->session->set_userdata($arr_msg);
				redirect('purchase_orders');
			}
			
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('purchase_orders/edit_order',$data);
			}elseif(trim($this->input->post('submit')) == 'Update Order')
			{ 
					
						
						 $data_insert = array();
						 
						 // get the tax row details
						 $tax_id = trim($this->input->post('tax_id'));
						 $taxRow = $this->orders_model->getTaxRow($tax_id);
						 $data_pourc_order['tax_per'] = $taxRow[0]['tax_per'];
						 $data_pourc_order['tax_type'] = $taxRow[0]['tax_type'];
						 $data_pourc_order['tax_id'] = $taxRow[0]['tax_id'];
						 
						// $data_pourc_order['transport_name'] = trim($this->input->post('transport_name'));
						// $data_pourc_order['delivery_address'] = trim($this->input->post('delivery_address'));
						 $data_pourc_order['excise'] = trim($this->input->post('excise'));
						 $data_pourc_order['pay_term'] = trim($this->input->post('pay_term'));
						 $data_pourc_order['payment_reminder'] = trim($this->input->post('payment_reminder'));
						// $data_pourc_order['expected_delivery'] = trim($this->input->post('expected_delivery'));
						 $data_pourc_order['order_remark'] = trim($this->input->post('order_remark'));
						 $data_pourc_order['updated_by'] = $this->session->userdata('userid');
						 $data_pourc_order['updated_date'] = date('Y-m-d');
											 
						 $id = $this->purchase_orders_model->updateOrder($data_pourc_order,$purc_order_id);
						 
						 if($id > 0){
							 $arr_msg = array('suc_msg'=>'Order Updated successfully!','msg-type'=>'success');
						 }else{
							 $arr_msg = array('suc_msg'=>'Failed to update Order','msg-type'=>'danger');
						 }
						
						 $this->session->set_userdata($arr_msg);
						 redirect('purchase_orders/edit/'.$purc_order_id);
				
			}
			
			//echo '<pre>'; print_r($data); die();
		}else{
			$arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
			$this->session->set_userdata($arr_msg);
			redirect('purchase_orders/');
		}
	}
	
	/* Edit the purchase Order based on the order id */
	
	public function view($purc_order_id){
		if($purc_order_id > 0){
			$data['menutitle'] = 'Purchase Orders';			
			$data['pagetitle'] = 'View Order';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'purchase_orders">Manage Purchase Orders</a> <i class="fa fa-angle-right"></i> </li><li>View Purchase Order</li></ul>';
		
		// get the purchase order details 
			$purchaseOrderDetails = $this->purchase_orders_model->getPurchaseOrderDetails($purc_order_id);
			$purchaseOrderProducts = $this->purchase_orders_model->getPurchaseOrderProducts($purc_order_id);			
			$data['purchaseOrderDetails'] = $purchaseOrderDetails;	
			$data['purchaseOrderProducts'] = $purchaseOrderProducts;
			
			// Get list of all tax(VAT/CST) entries
			$taxList = $this->orders_model->getTaxList('Both');
			$taxListArray = array('0'=>'Not Applicable');	
			foreach($taxList as $taxRow){
				 $taxListArray[$taxRow['tax_id']] = $taxRow['tax_per'].'% '.$taxRow['tax_type'];
			}
			$data['taxList'] = $taxListArray;
			
			// Get list of excise tax entries
			$exciseTaxList = $this->orders_model->getExciseTaxList('Excise');
			$exciseTaxListArray = array('0'=>'Not Applicable');	
			foreach($exciseTaxList as $exciseRow){
				 $exciseTaxListArray[$exciseRow['tax_per']] = $exciseRow['tax_per'].'% ';
			}
			$data['exciseTaxList'] = $exciseTaxListArray;
			
			
			
			if(sizeof($purchaseOrderDetails)> 0 ){
				//echo '<pre>'; print_r($data); die();
				if($data != false)
				{ 
					$this->template
						 ->set_layout('admin_default')
						 ->build('purchase_orders/view_order',$data);
						
				}
			}else{
			    $arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
				$this->session->set_userdata($arr_msg);
				redirect('purchase_orders');
			}
			
			
			
			//echo '<pre>'; print_r($data); die();
		}else{
			$arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
			$this->session->set_userdata($arr_msg);
			redirect('purchase_orders/');
		}
	}
	
	/* Add product in purchase order */
	public function add_purchase_prod()
	{
		//echo '<pre>'; print_r($this->input->post()); die();  
		$this->form_validation->set_rules('purc_order_id', 'Purchase Order Number', 'trim|required|numeric|greater_than[0]'); // |is_unique[product.item_code]
		$this->form_validation->set_rules('pid', 'Purchase Product', 'trim|required|numeric|greater_than[0]');
		//$this->form_validation->set_rules('prod_ref_name', 'Product Reference Name', 'trim|required');
		$this->form_validation->set_rules('order_qty', 'Product Quantity', 'trim|required|numeric|greater_than[0]');
		$this->form_validation->set_rules('order_rate', 'Product Rate', 'trim|required|greater_than[0]');
		//$this->form_validation->set_rules('packing_size', 'Packing Size', 'trim|required|greater_than[0]');
		 if ($this->form_validation->run($this) == FALSE){
			echo validation_errors(); 
		}else{
		           $data_insert = array();
					
					 $data_insert['purc_order_id'] = trim($this->input->post('purc_order_id'));
					 $data_insert['purchase_pid'] = trim($this->input->post('pid'));
					 //$data_insert['prod_ref_name'] = trim($this->input->post('prod_ref_name'));
					 $data_insert['purchase_qty'] = trim($this->input->post('order_qty'));
					 $data_insert['purchase_rate'] = trim($this->input->post('order_rate'));
					 if($this->input->post('igst_per') > 0){
					 	 $data_insert['sgst_per'] = 0.00;
						 $data_insert['cgst_per'] = 0.00;
						 $data_insert['igst_per'] = trim($this->input->post('igst_per'));
					 }else{
						 $data_insert['sgst_per'] = trim($this->input->post('sgst_per'));
						 $data_insert['cgst_per'] = trim($this->input->post('cgst_per'));
						 $data_insert['igst_per'] = 0.00;
					 }
					 // $data_insert['notes'] = trim($this->input->post('notes'));
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');
					 
					
					 $id = $this->purchase_orders_model->updatePurchaseOrderProduct($data_insert);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Product added successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to add product','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 echo '1';
		}
	}
	
	/* Delete the purchased product based on the id*/
	public function remove_prod(){
		$id = $this->input->post('id');
		if($id > 0){
		  echo $deleted = $this->purchase_orders_model->deletePurchaseOrderProd($id);
		}else{
			echo 0;
		}
	}
	
	/* Delete the purchased product based on the id*/
	public function close_order(){
		$id = $this->input->post('orderId');
		if($id > 0){
		  echo $deleted = $this->purchase_orders_model->closePurchaseOrder($id);
		}else{
			echo 0;
		}
	}
	
	/* Confirm Purchase Order based on the order number a */
	
	public function confirm_po($purchase_order_number, $purc_order_id){
	// echo '<pre>'; print_r($this->input->post());
		if($purc_order_id > 0 && $purchase_order_number !=''){
		    $purchase_order_number = base64UrlDecode($purchase_order_number);
			$data['menutitle'] = 'Purchase Orders';			
			$data['pagetitle'] = 'View Order';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'purchase_orders/">Manage Purchase Orders</a> <i class="fa fa-angle-right"></i> </li><li>Confirm Purchase Order</li></ul>';
			
			// get the purchase order details 
			$purchaseOrderDetails = $this->purchase_orders_model->getPurchaseOrderDetails($purc_order_id);
			$purchaseOrderProducts = $this->purchase_orders_model->getPurchaseOrderProducts($purc_order_id);			
			$data['purchaseOrderDetails'] = $purchaseOrderDetails;	
			$data['purchaseOrderProducts'] = $purchaseOrderProducts;
			// get the firm details
			$firmDetails = $this->orders_model->getFirmDetails($purchaseOrderDetails[0]['firm_id']);
			$data['firmDetails'] = $firmDetails;
			// echo '<pre>'; print_r($data); die();
			if(sizeof($purchaseOrderDetails)> 0 && ( $purchaseOrderDetails[0]['status'] == 'Open')){
				//echo '<pre>'; print_r($data); die();
				if($data != false)
				{ 
					$this->template
						 ->set_layout('admin_default')
						 ->build('purchase_orders/confirm_po',$data);
						
				}
			}elseif(sizeof($purchaseOrderDetails)> 0 && ( $purchaseOrderDetails[0]['status'] == 'Completed'  || $purchaseOrderDetails[0]['status'] == 'Confirmed' )){
				//echo '<pre>'; print_r($data); die();
				if($data != false)
				{ 
					$this->template
						 ->set_layout('admin_default')
						 ->build('purchase_orders/confirm_po',$data);
						
				}
			}else{
			    $arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
				$this->session->set_userdata($arr_msg);
				redirect('purchase_orders');
			}
			
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('purchase_orders/confirm_po',$data);
			}elseif(trim($this->input->post('submit')) == 'Confirm PO')
			{		
				    //echo '<pre>'; print_r($this->input->post()); die();
					// Update the forwording amount and discount
					$invoiceArray = array();
					$invoiceArray['forwardingAmt'] = trim($this->input->post('forwardingAmt'));
					$invoiceArray['discountAmt'] = 0.00; //trim($this->input->post('discountAmt'));
					$invoiceArray['otherAdjustment'] = trim($this->input->post('otherAdjustment'));
					$invoiceArray['status'] = 'Confirmed';
					// message information 
					$notificationArray['purchase_order_number'] = $purchase_order_number;
					$notificationArray['expected_delivery'] = $purchaseOrderDetails[0]['expected_delivery'];
					
					
					// Update the database
					$id = $this->purchase_orders_model->updatePurchaseOrderData($invoiceArray,$purc_order_id, $notificationArray);
										 
					if($id == 1 ){
						$arr_msg = array('suc_msg'=>'Purcahse Order # '.$purchase_order_number.' is confirmed successfully','msg-type'=>'success');
					}else{
						$arr_msg = array('suc_msg'=>'Failed to confirmed purcahse order # '.$purchase_order_number,'msg-type'=>'danger');
					}	 
					$this->session->set_userdata($arr_msg);
					redirect('purchase_orders/confirm_po/'.base64UrlEncode($purchase_order_number).'/'.$purc_order_id);
				
			}elseif(trim($this->input->post('submit')) == 'Downlaod PO')
			{		
				    //echo '<pre>'; print_r($this->input->post()); die();
					//load the view, pass the variable and do not show it but "save" the output into $html variable
					$challan_html = $this->load->view('purchase_orders/download_po', $data, true);
					//echo $challan_html; die();
					//this the the PDF filename that user will get to download
					$pdfFilePath = $purchase_order_number .".pdf";				
					
					//actually, you can pass mPDF parameter on this load() function
					 $this->load->library('M_pdf');
					//generate the PDF!
					 $this->m_pdf->pdf->WriteHTML($challan_html);
					//$pdf->WriteHTML($challan_html);
					//offer it to user via browser download! (The PDF won't be saved on your server HDD)
					ob_clean(); 
				    $this->m_pdf->pdf->Output($pdfFilePath, "D");
					//$pdf->Output($pdfFilePath, "D");
				
			}else{
				// echo '<pre>'; print_r($this->input->post()); die();
			}
			
			
		}else{ 
			redirect('purchase_orders/');
		}
	}
	
	
	
	/* Add new product enquiery in to database */
	public function add(){
		    $data['menutitle'] = 'Purchase Orders';			
			$data['pagetitle'] = 'Create Order';
			
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Purchase Orders <i class="fa fa-angle-right"></i> </li><li>Create Purchase Order</li></ul>';
			
			// get the firm list 
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(''=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
			
			// get the list of all products 
			$allProducts = $this->product_model->getAllProducts(); 
			$products_data = array(''=>'Select Product');
			if(sizeof($allProducts) > 0){
				$i= 0;
				foreach($allProducts as $product){
					$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
				}
			}
			$data['products'] = $products_data;
			
			// Get list of all tax  entries
			$sgstList = $this->orders_model->getTaxList('SGST');
			$sgstListArray = array('0'=>'Not Applicable');	
			foreach($sgstList as $sgstRow){
				 $sgstListArray[$sgstRow['tax_per']] = $sgstRow['tax_per'].'% '.$sgstRow['tax_type'] ;
			}
			$data['sgstList'] = $sgstListArray;
			
			$cgstList = $this->orders_model->getTaxList('CGST');
			$cgstListArray = array('0'=>'Not Applicable');	
			foreach($cgstList as $cgstRow){
				 $cgstListArray[$cgstRow['tax_per']] = $cgstRow['tax_per'].'% '.$cgstRow['tax_type'] ;
			}
			$data['cgstList'] = $cgstListArray;
			
			$igstList = $this->orders_model->getTaxList('IGST');
			$igstListArray = array('0'=>'Not Applicable');	
			foreach($igstList as $igstRow){
				 $igstListArray[$igstRow['tax_per']] = $igstRow['tax_per'].'% '.$igstRow['tax_type'] ;
			}
			$data['igstList'] = $igstListArray;
			
			 
			// get the list of all suppliers 
			$allSuppliers = $this->suppliers_model->getAllSuppliers();
			$supplier_data = array(''=>'Select Supplier');
			foreach($allSuppliers as $supplier){
					$supplier_data[$supplier['supl_id']] = $supplier['supl_comp'];
				}
			$data['allSuppliers'] = $supplier_data;		
		     
		
			// echo '<pre>'; print_r($data); die();			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			
			if(trim($this->input->post('submit')) == '')
			{
				
					$this->template->set_layout('admin_default')->build('purchase_orders/add_enquiry',$data);
				
			}elseif(trim($this->input->post('submit')) == 'Create Order')
		    { 
			//echo '<pre>'; print_r($this->input->post()); die();
			
			$this->form_validation->set_rules('firm_id', 'Purchase Firm', 'trim|required|greater_than[0]');
			$this->form_validation->set_rules('supli_id', 'Supplier', 'trim|required|greater_than[0]');
					
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 $order_details['firm_id'] = trim($this->input->post('firm_id'));
				 $order_details['supli_id'] = trim($this->input->post('supli_id'));
				 $data = $order_details;
				 $this->template->set_layout('admin_default')->build('purchase_orders/add_enquiry',$data);
		     } 
			 else
			 {
				 			 
				     $data_pourc_order = array();
					 // $data_pourc_order['enquiry_id'] = $enquiryDetails[0]['enquiry_id'];
					 $data_pourc_order['purc_order_number'] = ''; // to be filled at model level					 
					 $data_pourc_order['order_by'] = $this->session->userdata('userid');
					 $data_pourc_order['supplier_id'] = trim($this->input->post('supli_id'));
					 $data_pourc_order['firm_id'] = trim($this->input->post('firm_id'));
					 $tax_id =  trim($this->input->post('tax_id'));	 
					 $data_pourc_order['pay_term'] = trim($this->input->post('pay_term'));
					 $data_pourc_order['payment_reminder'] = trim($this->input->post('payment_reminder'));
					// $data_pourc_order['expected_delivery'] = trim($this->input->post('expected_delivery'));
					 $data_pourc_order['order_remark'] = trim($this->input->post('order_remark'));
				     $data_pourc_order['updated_by'] = $this->session->userdata('userid');
					 $data_pourc_order['updated_date'] = date('Y-m-d');
					 $data_pourc_order['order_date'] = date('Y-m-d');
					// $data_pourc_order['transport_name'] = trim($this->input->post('transport_name'));
					 // $data_pourc_order['delivery_address'] = trim($this->input->post('delivery_address'));				 
					 // create a array of purchase product
					 $pid_array = $this->input->post('pid');
					 //$prod_ref_name_array = $this->input->post('prod_ref_name');
					 $order_rate_array = $this->input->post('order_rate');  
					 $order_qty_array = $this->input->post('order_qty');
					 
					 $igst_per_array = $this->input->post('igst_per');  
					 $cgst_per_array = $this->input->post('cgst_per'); 
					 $sgst_per_array = $this->input->post('sgst_per'); 
					 
					  
					 $purchased_products = array();
					 if(sizeof($pid_array) > 0){
						$j= 0;
						foreach($pid_array as $pid){
							if($pid > 0){	
								$purchased_products[$j]['purc_order_id'] = ''; // to be filled at model level
								$purchased_products[$j]['purchase_pid'] = $pid;
								$purchased_products[$j]['purchase_qty'] = $order_qty_array[$j];
								$purchased_products[$j]['purchase_rate'] = $order_rate_array[$j];	
								if($igst_per_array[$j] > 0){
									 $purchased_products[$j]['sgst_per'] = 0.00;
									 $purchased_products[$j]['cgst_per'] = 0.00;
									 $purchased_products[$j]['igst_per'] = $igst_per_array[$j];
								 }else{
									 $purchased_products[$j]['sgst_per'] = $sgst_per_array[$j];
									 $purchased_products[$j]['cgst_per'] = $cgst_per_array[$j];
									 $purchased_products[$j]['igst_per'] = 0.00;
								 }							 
								 
								$purchased_products[$j]['updated_by'] = $this->session->userdata('userid');
								$purchased_products[$j]['updated_date'] = date('Y-m-d');
							}	
							$j++;
						}
					 }
				 
				 
				 // echo '<pre>'; print_r($data_pourc_order); echo '<pre>'; print_r($purchased_products); die();
							 					 
				 $id = $this->purchase_orders_model->createPurchaseOrder($data_pourc_order, $purchased_products);
				 if($id > 0){
					 $arr_msg = array('suc_msg'=>'Purchase Order added successfully!!!','msg-type'=>'success');
				 }else{
					 $arr_msg = array('suc_msg'=>'Failed to add Purchase Order','msg-type'=>'danger');
				 }
				 
				 $this->session->set_userdata($arr_msg);
				 redirect('purchase_orders');
			 }
		}
			
	}
	
	/* Get supplier info based on supplier name */
	public function supplier_info(){
		$supplier_id = trim($this->input->post('supli_id'));
		$supplier_details = $this->suppliers_model->getSupplierInfo($supplier_id);
		$result['outcome'] = 0;
		if(sizeof($supplier_details) > 0){
			$result['outcome'] = 1;
			$result['supl_id'] = $supplier_details[0]['supl_id'];
			$result['supl_conperson'] = $supplier_details[0]['supl_conperson'];
			$result['supl_mobile'] = $supplier_details[0]['supl_mobile'];
			$result['supl_phone'] = $supplier_details[0]['supl_phone'];
			$result['email'] = $supplier_details[0]['supl_email'];
		}
		echo json_encode($result); die();
	}
	
	/* Add a new row of product in purchase enquiry */
	public function add_new_row(){
	
		// get list of all Products
		$allProducts = $this->product_model->getAllProducts();
		$products_data = array(''=>'Select Product');
		if(sizeof($allProducts) > 0){
			$i= 0;
			foreach($allProducts as $product){
				$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
			}
		}
		
		// Get list of all tax  entries
			$sgstList = $this->orders_model->getTaxList('SGST');
			$sgstListArray = array('0'=>'Not Applicable');	
			foreach($sgstList as $sgstRow){
				 $sgstListArray[$sgstRow['tax_per']] = $sgstRow['tax_per'].'% '.$sgstRow['tax_type'] ;
			}
			//$data['sgstList'] = $sgstListArray;
			
			$cgstList = $this->orders_model->getTaxList('CGST');
			$cgstListArray = array('0'=>'Not Applicable');	
			foreach($cgstList as $cgstRow){
				 $cgstListArray[$cgstRow['tax_per']] = $cgstRow['tax_per'].'% '.$cgstRow['tax_type'] ;
			}
			//$data['cgstList'] = $cgstListArray;
			
			$igstList = $this->orders_model->getTaxList('IGST');
			$igstListArray = array('0'=>'Not Applicable');	
			foreach($igstList as $igstRow){
				 $igstListArray[$igstRow['tax_per']] = $igstRow['tax_per'].'% '.$igstRow['tax_type'] ;
			}
			//$data['igstList'] = $igstListArray;
			
			
		//$data['products_data'] = $products_data;
		$rownums= trim($this->input->post('rownums'))+1;
		$rowHTml = '<tr class="gradeX short odd" id="tr_'.$rownums.'">
				<td width="25%">'.
					form_dropdown('pid[]',$products_data,'','class="form-control select2me" id="prod_'.$rownums.'" tabindex="0" placeholder= "Select Product" required="required" ').'  
					
				</td>
				
				<td width="20%"> <input type="number" min="0" step="any" class="form-control" name="order_rate[]" value= "" required="required" /></td>
				<td width="20%"> <input type="number" min="0" step="any" class="form-control" name="order_qty[]" value= "" required="required" /> </td>				
				 <td width="10%">'.
				form_dropdown('sgst_per[]',$sgstListArray,'','class="form-control select2me" id="prod_'.$rownums.'" tabindex="0" placeholder= "Select SGST" required="required" ').' 				</td>
				 <td width="10%">'.
			    form_dropdown('cgst_per[]',$cgstListArray,'','class="form-control select2me" id="prod_'.$rownums.'" tabindex="0" placeholder= "Select CGST" required="required" ').'   				</td>
				 <td width="10%">'.
				form_dropdown('igst_per[]',$igstListArray,'','class="form-control select2me" id="prod_'.$rownums.'" tabindex="0" placeholder= "Select IGST" required="required" ').' 				</td>
				<td width="5%">
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
	
	
	/* Create PRN and add the details in Product for confirmation of QC */
	public function create_prn($purc_order_id){
	
		if($purc_order_id > 0){
			$data['menutitle'] = 'Purchase Orders';			
			$data['pagetitle'] = 'Create PRN';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <i class="fa fa-home"></i> <a href="'.base_url().'purchase_orders">Manage Purchase Orders</a> <i class="fa fa-angle-right"></i> </li><li>Create PRN</li></ul>';
		
		// get the purchase order details 
			$purchaseOrderDetails = $this->purchase_orders_model->getPurchaseOrderDetails($purc_order_id);
			$pendingOrderProducts = $this->purchase_orders_model->getPurchaseOrderPendingProducts($purc_order_id);			
			$data['purchaseOrderDetails'] = $purchaseOrderDetails;
			$data['pendingOrderProducts'] = $pendingOrderProducts;	
			/*if(sizeof($pendingOrderProducts)>0){
				foreach($pendingOrderProducts as $pendingOrderProduct){
					$confirmedPendingProducts = $this->purchase_orders_model->getConfirmedPendingProducts($purc_order_id, $pendingOrderProduct['purchase_pid'], $pendingOrderProduct['id']);
					$pendingOrderProduct['confirmed_qty'] = $confirmedPendingProducts[0]['total_qty'];
					$data['pendingOrderProducts'][] = $pendingOrderProduct;
				}
			}*/
			/*echo '<pre>'; print_r($purchaseOrderDetails);
			echo '<pre>'; print_r($pendingOrderProducts); die();*/	 
			
			if(sizeof($pendingOrderProducts)> 0 ){
				
				if($data != false)
				{ 
					$this->template
						 ->set_layout('admin_default')
						 ->build('purchase_orders/create_prn',$data);
						
				}
			}else{
			    $arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
				$this->session->set_userdata($arr_msg);
				redirect('purchase_orders');
			}
			
			if($this->session->userdata('err_msg') != '')
				{
						$data['err_msg'] = $this->session->userdata('err_msg');
						$this->session->unset_userdata('err_msg');
				}
				
				if(trim($this->input->post('submit')) == '')
				{
					$this->template->set_layout('admin_default')->build('purchase_orders/create_prn',$data);
				}elseif(trim($this->input->post('submit')) == 'Create PRN')
				{ 
					//echo '<pre>'; print_r($this->input->post()); //die();					
				
				 					 
				 $data_confirm = $data_insert = $paymentUpates = array();
				 $date = date('Y-m-d');
				 // Order Challan Table
				 $p=0;
				
				 $invoice_num = trim($this->input->post('invoice_num'));
				 $rowPids = $this->input->post('rowPid');
				 $comments = $this->input->post('comment');
				 //$bagNo = $this->input->post('bagNo');
				 $qPbag = $this->input->post('qPbag');
				 //$packing_units = $this->input->post('packing');
				 $prod_ref_id = $this->input->post('prod_ref_id');
				  
				 foreach($rowPids as $rowPid){
				 	  $totalQty = $qPbag[$p]; // *$qPbag[$p]
					  if($totalQty > 0){
							/*$data_confirm[$p]['purc_order_id'] = $purc_order_id;
							$data_confirm[$p]['order_pid'] = $rowPid;
							$data_confirm[$p]['store_comment'] = $comments[$p];
							$data_confirm[$p]['invoice_num'] = $invoice_num ;
							$data_confirm[$p]['bags_drums'] = 1; //$bagNo[$p];
							$data_confirm[$p]['qty_per_bag'] = $qPbag[$p];
							$data_confirm[$p]['prod_ref_id'] = $prod_ref_id[$p] ;
							$data_confirm[$p]['total_qty'] = $qPbag[$p]; //  $bagNo[$p] *	
							$data_confirm[$p]['inword_by'] = $this->session->userdata('userid');	
							$data_confirm[$p]['inword_date'] = $date;	
							$data_confirm[$p]['packing_units'] = ''; //$packing_units[$p];*/
							
							
							
							 $data_insert = array();
							 $data_insert['on_date'] = $date;					 
							 $data_insert['su_id'] = $purchaseOrderDetails[0]['supplier_id'];					 
							 $data_insert['pid'] = $rowPid;
							 $data_insert['invoice_no'] = $invoice_num;
							 $data_insert['rate'] = $pendingOrderProducts[$p]['purchase_rate'];
							 $data_insert['lot_no'] = ''; // to be generated at model level
							 $data_insert['firm_id'] = $purchaseOrderDetails[0]['firm_id']; //$firmDetails[0]['parent_firm'];  // to be generated at model level	
							 $data_insert['inw_qty'] = $qPbag[$p];					 	
							 $data_insert['batch_desc'] = $comments[$p];		  
							 $data_insert['amount'] = round(($qPbag[$p]*$pendingOrderProducts[$p]['purchase_rate']),2);
							 $data_insert['instock'] = $qPbag[$p];
							 // Array of product_batch_details
							 $data_batch_details['bag_no'] = 1;	
							 //$data_batch_details['packing'] = $inwordProductInfo[0]['qty_per_bag'];
							 //$data_batch_details['sample_no'] = trim($this->input->post('sample_no'));
							 //$data_batch_details['received_at'] = trim($this->input->post('received_at'));
							 //$data_batch_details['transporter'] = $inwordProductInfo[0]['transport_name'];
							 $data_batch_details['batch_remark'] =  $comments[$p];
							 $data_batch_details['invoice_firm'] = $purchaseOrderDetails[0]['firm_id'];  // $firmDetails[0]['parent_firm']; //
							 //$data_batch_details['expiry_date'] = trim($this->input->post('expiry_date'));
							 //$data_batch_details['manufacturing_date'] = trim($this->input->post('manufacturing_date'));;
							 $data_batch_details['added_by'] = $this->session->userdata('userid');
							 $data_batch_details['material_inward_no'] = '';
							 $data_batch_details['purc_order_id'] = $purchaseOrderDetails[0]['purc_order_id'];
							 $this->product_model->addStock($data_insert,$data_batch_details,$rowPid, $paymentUpates, $pendingOrderProducts[$p]['id']);
							 
				
					  }	
					  $p++;
				 }
				 
																	
				
									
									
				if($prnNumber != 'False' ){
					$arr_msg = array('suc_msg'=>'Product Stock is updated successfully','msg-type'=>'success');
				}else{
					$arr_msg = array('suc_msg'=>'Failed to create PRN','msg-type'=>'danger');
				}	
				 $this->session->set_userdata($arr_msg);		 
				redirect('purchase_orders/');
						
			 }
			
			//echo '<pre>'; print_r($data); die();
		}else{
			$arr_msg = array('suc_msg'=>'Something went wrong with you','msg-type'=>'danger');
			$this->session->set_userdata($arr_msg);
			redirect('purchase_orders/');
		}
	}
	
}