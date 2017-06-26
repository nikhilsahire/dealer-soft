<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {   

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
		$this->load->model('clients_model');		
		
		$this->load->model('orders_model');
		$this->load->helper('download');		
		$this->load->library('ckeditor');
		$this->load->library('pagination');//load pagination library
		
		
		if (!is_admin_logged_in()) {
		   
            redirect('');
        } 
	}
	
	/*
	 Get the list of all products with min and instock qty.
	*/
	
	public function index()
	{    
			$data['product_details'] = $this->product_model->getAllProducts();
			
			// get the product stock as per the firms
			$i = 0;
			foreach($data['product_details'] as $product){
				$firmStock = $this->product_model->firmProductStock($product['pid']);
				$productArray[$i] = $product;
				$productArray[$i]['firm_stock'] = $firmStock;
				// get the total booked value for the product
				$productBookedStock = $this->product_model->firmProductBooked($product['pid']);  // $product['pid']			
				$bookedStockVal = 0.00;
				if(sizeof($productBookedStock) > 0){
					foreach($productBookedStock as $bookedStock){
						$bookedStockVal += $bookedStock['bookedProdStock']; 
						$productArray[$i]['booked_firm_stock'][$bookedStock['firm_code']] = $bookedStock['bookedProdStock'];
					}
				}
				$productArray[$i]['booked_stock'] = $bookedStockVal;
				
				// get the total purchased value for the product
				$productInProcess = $this->product_model->firmProductInProcess($product['pid']);  // $product['pid']
				$processStockVal = 0.00; 
				
				if(sizeof($productInProcess) > 0){
					foreach($productInProcess as $processStock){
						$processStockVal += $processStock['bookedProdStock']; 
						$productArray[$i]['purchased_firm_stock'][$processStock['firm_code']] = $processStock['bookedProdStock'];
					}
				}
				$productArray[$i]['process_stock'] = $processStockVal;
				
				// get the QC pending product value for the product  
				$productsInQc = $this->purchase_orders_model->getConfirmationPendingQty($product['pid']);  // $product['pid']
				$qcStockVal = 0.00; 
				
				if(sizeof($productsInQc) > 0){
					foreach($productsInQc as $productInQc){
						$qcStockVal += $productInQc['total_qty']; 
						$productArray[$i]['productsInQc'] = $productInQc['total_qty'];
					}
				}
				$productArray[$i]['productsInQc'] = $qcStockVal;
				
				
				
				$i++;
			}
			$data['product_details'] = $productArray;
		//	echo '<pre>'; print_r($data['product_details']); die();
			//$this->product_model->query_firm_stock
			$data['menutitle'] = 'Products';
			$data['pagetitle'] = 'Products';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Products</li></ul>';
			
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('products/manage_products',$data);
					
			}
					
	}
	
	/*
	Edit product based on product Id
	*/
	
	public function add()
	{
			$data['menutitle'] = 'Products';
			$data['pagetitle'] = 'Add Product';
				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'products/">Manage Products</a><i class="fa fa-angle-right"></i></li><li>Add Product</li></ul>';
			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			
			//echo '<pre>'; print_r($productOnCrops);die();
			
			$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
			$this->ckeditor->config['toolbar'] = array(
				array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','Source','-','Undo','Redo','Table','-','NumberedList','BulletedList','Indent','Outdent',"Styles",'JustifyRight','JustifyLeft','JustifyCenter', 'Format', 'Font', 'FontSize','Link','Unlink')
				);
			$this->ckeditor->config['language'] = 'en';
			$this->ckeditor->config['width'] = '100%';
			$this->ckeditor->config['height'] = '250px';
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('products/add_product',$data);
			}elseif(trim($this->input->post('submit')) == 'Add Product')
			{ 
						
				$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|max_length[20]|is_unique[product.item_code]'); // |is_unique[product.item_code]
				// $this->form_validation->set_rules('product_packing', 'Product Packing', 'trim|required|max_length[4]|numeric');
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[150]');
				$this->form_validation->set_rules('product_desc', 'product Description', 'trim|required');				
				$this->form_validation->set_rules('prod_unit', 'Product Unit', 'trim|required|max_length[4]');
				$this->form_validation->set_rules('min_qty', 'Minimum Quantity', 'trim|required');
				$this->form_validation->set_rules('initial_stock', 'Initial Stock', 'trim|required|numeric|greater_than[0]');
				$this->form_validation->set_rules('initial_stock_rate', 'Initial Rate', 'trim|required|numeric|greater_than[0]');
				
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  
					 $product_details['item_code'] = trim($this->input->post('item_code'));
					// $product_details['product_packing'] = trim($this->input->post('product_packing'));
					 $product_details['product_name'] = trim($this->input->post('product_name'));
					 $product_details['product_desc'] = trim($this->input->post('product_desc'));
					 $product_details['prod_unit'] = trim($this->input->post('prod_unit'));
					// $product_details['prod_gravity'] = trim($this->input->post('prod_gravity'));
					 $product_details['min_qty'] = trim($this->input->post('min_qty'));	
					// $product_details['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $product_details['product_keywords'] = trim($this->input->post('product_keywords'));					 					 				 			
					 $product_details['initial_stock'] = $this->input->post('initial_stock');
					 $product_details['initial_stock_rate'] =$this->input->post('initial_stock_rate');
					 $data['product_details'][0] = $product_details;
					 $this->template->set_layout('admin_default')->build('products/add_product',$data);
				 }
				 else
				 {
					 $data_insert = array();
					 $data_insert['item_code'] = trim($this->input->post('item_code'));
					 //$data_insert['product_packing'] = trim($this->input->post('product_packing'));
					 $data_insert['product_name'] = trim($this->input->post('product_name'));
					 $data_insert['product_desc'] = trim($this->input->post('product_desc'));
					 $data_insert['prod_unit'] = trim($this->input->post('prod_unit'));
					 //$data_insert['prod_gravity'] = trim($this->input->post('prod_gravity'));
					 $data_insert['min_qty'] = trim($this->input->post('min_qty'));	
					// $data_insert['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $data_insert['product_keywords'] = trim($this->input->post('product_keywords'));
					
					 $initial_stock_info['initial_stock'] = $this->input->post('initial_stock');
					 $initial_stock_info['initial_stock_rate'] = $this->input->post('initial_stock_rate');	
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');	 
					 $id = $this->product_model->addProduct($data_insert,$initial_stock_info);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Product added successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to add product','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('products');
				 }
			}		
	}
	
	/*
	Edit product based on product Id
	*/
	
	public function edit($product_id = 0)
	{
		if($product_id > 0){
		    
			$data['menutitle'] = 'Products';
			$data['pagetitle'] = 'Edit Product';				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'products/">Manage Products</a><i class="fa fa-angle-right"></i></li><li>Edit Product</li></ul>';
			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			// get product details
			$data['product_details'] = $this->product_model->getProductInfo($product_id);		
			
			//echo '<pre>'; print_r($productOnCrops);die();
			
			$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
			$this->ckeditor->config['toolbar'] = array(
				array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','Source','PasteFromWord','-','Undo','Redo','-','Table','NumberedList','BulletedList','Indent','Outdent',"Styles",'JustifyRight','JustifyLeft','JustifyCenter', 'Format', 'Font', 'FontSize','Link','Unlink')
				);
			$this->ckeditor->config['language'] = 'en';
			$this->ckeditor->config['width'] = '100%';
			$this->ckeditor->config['height'] = '250px';
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('products/edit_product',$data);
			}elseif(trim($this->input->post('submit')) == 'Edit Product')
			{ 
							
				$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|max_length[20]'); 
				
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[150]');
				$this->form_validation->set_rules('product_desc', 'product Description', 'trim|required');				
				$this->form_validation->set_rules('prod_unit', 'Product Unit', 'trim|required|max_length[4]');
				$this->form_validation->set_rules('min_qty', 'Minimum Quantity', 'trim|required');
				
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  
					 $product_details['item_code'] = trim($this->input->post('item_code'));					 
					 $product_details['product_name'] = trim($this->input->post('product_name'));
					// $product_details['product_packing'] = trim($this->input->post('product_packing'));					 
					 $product_details['product_desc'] = trim($this->input->post('product_desc'));
					 $product_details['prod_unit'] = trim($this->input->post('prod_unit'));
					 $product_details['min_qty'] = trim($this->input->post('min_qty'));	
					// $product_details['prod_gravity'] = trim($this->input->post('prod_gravity'));
					// $product_details['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $product_details['product_keywords'] = trim($this->input->post('product_keywords'));					 					 				 			
					 $product_details['pid'] = trim($product_id);
					 
					$data['product_details'][0] = $product_details;
					$this->template->set_layout('admin_default')->build('products/edit_product',$data);
				 }
				 else
				 {
					 $data_insert = array();
					// $data_insert['product_packing'] = trim($this->input->post('product_packing'));					 
					 $data_insert['product_name'] = trim($this->input->post('product_name'));
					 $data_insert['product_desc'] = trim($this->input->post('product_desc'));
					 $data_insert['prod_unit'] = trim($this->input->post('prod_unit'));
					// $data_insert['prod_gravity'] = trim($this->input->post('prod_gravity'));
					 $data_insert['min_qty'] = trim($this->input->post('min_qty'));	
					// $data_insert['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $data_insert['product_keywords'] = trim($this->input->post('product_keywords'));
					 						 				 				 			
					 $data_insert['pid'] = trim($product_id);
					 //echo '<pre>'; print_r($product_crops); die();
					 $data_insert['updated_by'] = $this->session->userdata('userid');
					 $data_insert['updated_date'] = date('Y-m-d');	 
					 $id = $this->product_model->updateProduct($data_insert,$product_id);
					 if($id > 0){
						 $arr_msg = array('suc_msg'=>'Product updated successfully!','msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to update product','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('products/edit/'.$product_id);
				 }
			}	
		
		}else {
				redirect('products');
		}	
		
	}
	
	/*
	View product based on product Id
	*/
	
	public function view($product_id = 0)
	{
		if($product_id > 0){
		    
			$data['menutitle'] = 'Products';
			$data['pagetitle'] = 'View Product';				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'products/">Manage Products</a><i class="fa fa-angle-right"></i></li><li>View Product</li></ul>';
			
			// get product details
			$data['product_details'] = $this->product_model->getProductInfo($product_id);
					
			//  get all product specifications
			$productSpecification = $this->product_model->getProductSpects($product_id);
			$data['product_specification'] = array();
			if($productSpecification != ''){
				$data['product_specification'] = explode(',',$productSpecification[0]['spec_name']);
			}
			$this->template->set_layout('admin_default')->build('products/view_product',$data);
		
		}else {	
				redirect('products');
		}	
		
	}
	
	// listing of uploaded product material
	public function manage_material($product_id=0)
	{
		 if($product_id > 0){
		 $data['menutitle'] = 'Products';
		 $data['pagetitle'] = 'Manage Specifications';	
		 $data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <a href="'.base_url().'products">Manage Products</a> <i class="fa fa-angle-right"></i> </li><li>Specification</li></ul>';
		 $data['product_details'] = $this->product_model->getProductInfo($product_id);
		 $data['product_pdf_details'] = $this->product_model->getProductSpects($product_id);
		//echo '<pre>'; print_r($_SERVER); die();		
		 if($this->session->userdata('suc_msg') != '')
	     {
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
		 }
		 
		 if($this->session->userdata('err_msg') != '')
		 {
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		 }
		
		
		 if($data != false)
	     {
					$this->template
						 ->set_layout('admin_default')
						 ->build('products/manage_product_material',$data);
						
		 }
		}else {
				redirect('products');
		}
		 
	}
	
	public function add_pdf_material()
	{
		if($this->input->post('submit') == '')
		{
		}else if($this->input->post('submit') == 'Add')
		{
			$product_id = $this->input->post('product_id');
			$spec_name = $this->input->post('spec_name');
			
			 if($_FILES['specification_pdf']['name'] && $spec_name!='')
			 {
				    $course_pdf = $_FILES['specification_pdf']['name'];
					$course_title = str_replace('/', '_', strtolower($spec_name));
					$upload_filename = $course_title.'_'.$course_pdf;
					$upload_filename = str_replace(' ', '_', strtolower($upload_filename));
					$upload_filename = preg_replace('/\'/','',$upload_filename);
					
				    $config['upload_path'] = './uploads/pdf/';
        			$config['allowed_types'] = 'pdf|csv|xls|xlsx';
					$config['file_name']	= $upload_filename;
        			$config['max_size']    = 0;
					$this->load->library('upload', $config);
					
					if (!$this->upload->do_upload('specification_pdf'))
        			{
						$file_error = 1;
						$arr_msg = array('err_msg'=> $this->upload->display_errors());
						
         			}
        			else
        			{
						$data_insert['document_name'] = $upload_filename;
						$data_insert['product_id'] = $product_id;
						$data_insert['spec_name'] = $spec_name;
						$pdf_id = $this->product_model->add_pdf($data_insert);
						if($pdf_id > 0){
							$arr_msg = array('suc_msg'=>'PDF uploaded successfully..!');
						}
        			}
					
			 }else{
				  $file_error = 1;
				  $arr_msg = array('err_msg'=> 'Please select pdf file..!');
			 }
			   $this->session->set_userdata($arr_msg);
			  redirect('products/manage_material/'.$product_id);
			 
		}  
	}
	
	public function delete_specification_pdf()
	{
		 $product_id = $this->input->get('product_id');
		 $id = $this->input->get('pdf_id');
		 echo $deleted = $this->product_model->delete_pdf($product_id,$id);
	}
	
	public function download_specification_pdf($spec_id=0,$product_id=0)
	{
		if($spec_id > 0 && $product_id > 0){ 
			 $specData = $this->product_model->getProductSpectInfo($spec_id,$product_id);		 
			 if(sizeof($specData) > 0 ){
				force_download($_SERVER['DOCUMENT_ROOT'].'/'.SITE_FOLDER.'admin/uploads/pdf/'.$specData[0]['document_name'], NULL);
			 }
		}else{
			redirect('products');
		} 
	}
	
	/*Get the stock of the product */
	public function stock($product_id = 0)
	{
		 $stardate = (date('m')<'04') ? date('Y-04-01',strtotime('-1 year')) : date('Y-04-01');
		 $enddate = (date('m')>='04') ? date('Y-03-31',strtotime('+1 year')) : date('Y-03-31');
		 
		if($product_id > 0){
		    
		    $data['menutitle'] = 'Products';
			$data['pagetitle'] = 'Product Stock';				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'products/">Manage Products</a><i class="fa fa-angle-right"></i></li><li>Product Stock</li></ul>';			
			
			// get product details
			$data['product_details'] = $this->product_model->getProductInfo($product_id);
					
			// get product stock entries
			if($this->input->post('submit') == 'Filter')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $firm_id = $this->input->post('firm_id');
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']=$firm_id[0];
			  
			  $data['product_stock'] = $this->product_model->getProductStock($product_id,$stardate,$enddate,$data['firm_id']);
			}else{
			   $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  $data['firm_id']=0;
			  $data['product_stock'] = $this->product_model->getProductStock($product_id,$stardate,$enddate,$data['firm_id']);
			  
			}
			
			// get total stock
			$total_stock = $this->product_model->getTotalStock($product_id,$data['firm_id']);
			$data['total_stock'] = $total_stock[0]['inw_qty'] - $total_stock[0]['outw_qty'];
			// get the older stock for the product
			$data['product_stock_old'] = $this->product_model->getOldStock($product_id,$stardate,$data['firm_id']);
			// get the firm list 
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(0=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;
		  //  echo '<pre>'; print_r($data); die();		
			$this->template->set_layout('admin_default')->build('products/products_stock',$data);
		}else{
			redirect('products');
		}
	}
	
	/*Add the stock of the product */
	public function add_stock($product_id = 0)
	{
		if($product_id > 0){
		    
		    $data['menutitle'] = 'Products';
			$data['pagetitle'] = 'Add Stock';				
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'products/">Manage Products</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'products/stock/'.$product_id.'">View Stock</a><i class="fa fa-angle-right"></i></li><li>Add Stock</li></ul>';			
			if($this->session->userdata('err_msg') != '')
			{
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
			}
			// get product details
			$data['product_details'] = $this->product_model->getProductInfo($product_id);
			
			// get the list of all suppliers for add stock pop-up
			$supplierArray[] = '';
			$allSuppliers = $this->suppliers_model->getAllSuppliers();
			foreach($allSuppliers as $supplier){
				 $supplierArray[$supplier['supl_id']] = $supplier['supl_comp'];
			}
			$data['suppliers_details'] = $supplierArray;
				
			// get list of all Products
			$allProducts = $this->product_model->getAllProducts();
			$products_data = array();
			if(sizeof($allProducts) > 0){
			    $i= 0;
				foreach($allProducts as $product){
				    $products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
				}
			}
			$data['products_data'] = $products_data;
			//echo '<pre>'; print_r($data['products_data']); die();			
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('products/add_stock',$data);
			}elseif(trim($this->input->post('submit')) == 'Add Stock')
			{ 
							
				$this->form_validation->set_rules('on_date', 'Inward Date', 'trim|required'); 
				$this->form_validation->set_rules('su_id', 'Supplier', 'trim|required|greater_than[0]|numeric');
				$this->form_validation->set_rules('invoice_firm', 'Firm Name', 'trim|required|greater_than[0]|numeric');
				$this->form_validation->set_rules('pid', 'Product Name', 'trim|required|greater_than[0]|numeric');				
				$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|max_length[20]');
				$this->form_validation->set_rules('bag_no', 'Bags/Drums', 'trim|required|numeric');
				$this->form_validation->set_rules('packing', 'Packing', 'trim|required|numeric');	
				$this->form_validation->set_rules('received_at', 'Received At', 'trim|required');	
				$this->form_validation->set_rules('batch_desc', 'Batch Description', 'trim|required');	
				$this->form_validation->set_rules('rate', 'Purchase Rate', 'trim|required|greater_than[0]|numeric');	
				$this->form_validation->set_rules('inw_qty', 'Product Weight', 'trim|required|greater_than[0]');
				
				
				 if ($this->form_validation->run($this) == FALSE)
				 {				
					$this->template->set_layout('admin_default')->build('products/add_stock',$data);
				 }
				 else
				 {
					 // Array of product stock
					 $data_insert = array();
					 $data_insert['on_date'] = trim($this->input->post('on_date'));					 
					 $data_insert['su_id'] = trim($this->input->post('su_id'));					 
					 $data_insert['pid'] = trim($this->input->post('pid'));
					 $data_insert['invoice_no'] = trim($this->input->post('invoice_no'));
					 $data_insert['rate'] = trim($this->input->post('rate'));
					 $data_insert['lot_no'] = ''; // to be generated at model level
					 $data_insert['firm_id'] = trim($this->input->post('invoice_firm')); // to be generated at model level	
					 $data_insert['inw_qty'] = trim($this->input->post('inw_qty'));					 	
					 $data_insert['batch_desc'] = trim($this->input->post('batch_desc'));					  
					 $data_insert['amount'] = $data_insert['inw_qty']*$data_insert['rate'];
					 $data_insert['instock'] = $data_insert['inw_qty'];
					 // Array of product_batch_details
					 $data_batch_details['bag_no'] = trim($this->input->post('bag_no'));	
					 $data_batch_details['packing'] = trim($this->input->post('packing'));
					 $data_batch_details['sample_no'] = trim($this->input->post('sample_no'));
					 $data_batch_details['received_at'] = trim($this->input->post('received_at'));
					 $data_batch_details['transporter'] = trim($this->input->post('transporter'));
					 $data_batch_details['batch_remark'] = trim($this->input->post('batch_remark'));
					 $data_batch_details['invoice_firm'] = trim($this->input->post('invoice_firm'));
					 $data_batch_details['expiry_date'] = trim($this->input->post('expiry_date'));
					 $data_batch_details['manufacturing_date'] = trim($this->input->post('manufacturing_date'));
					 $data_batch_details['added_by'] = $this->session->userdata('userid');
					 $data_batch_details['material_inward_no'] = ''; // to be generated at model level	
					  
					 $id = $this->product_model->addStock($data_insert,$data_batch_details,$product_id);
					
					 if($id != ''){
						 $arr_msg = array('suc_msg'=>'Product batch added successfully!, New batch number is '.$id,'msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to create product batch','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('products/stock/'.$product_id);
				 }
			}
		}
	}
	
	
	// get batch details based on the batch number
	public function batch_details(){
	     $lot_no = $this->input->post('lot_no');
		// get the batch description details based on the batch number
		$batch_description = $this->product_model->productBatchDescription($lot_no);
		// get the batch details based on the lot number
		 $batch_details = $this->product_model->viewBatchDetails($lot_no); 
		// check for batch is formulated or not
		$productsUsedForFormulation = $this->product_model->getProductsUsedForFormulation($lot_no);
		// get the batch QC report based on the lot number
		$qc_report_str = '-';
		$qc_report = $this->product_model->getQcReport($lot_no); 
		if(sizeof($qc_report) > 0){
			$qc_report_str = '<a href="'.base_url().'products/download_qc_report/'.base64UrlEncode($lot_no).'">Download Report</a>';
		}
		
		// echo '<pre>'; print_r($qc_report); die();
		$html = '<div class="row">
					<div class="col-xs-6">
						<ul class="list-unstyled">
							<li>
								 <strong>Batch #:</strong> ';
								 if(sizeof($productsUsedForFormulation) > 0){
								 	$html .='<a href="javascript:void(0)" class="showformulated">'.$batch_description[0]['lot_no'].'</a>';
								 }else {
								 	$html .= $batch_description[0]['lot_no'];
								 } 
							$html .='</li>
							<li>
								 <strong>Bag #:</strong> '.$batch_description[0]['bag_no'].' 
							</li>
							<li>
								 <strong>Packing:</strong> '.$batch_description[0]['packing'].' '.$batch_description[0]['prod_unit'].' 
							</li>
							<li>
								 <strong>Inword Qty:</strong> '.$batch_description[0]['inw_qty'].' '.$batch_description[0]['prod_unit'].'
							</li>
							<li>
								 <strong>QC Report:</strong> '.$qc_report_str.'
							</li>
							
						</ul>
					</div>
					<div class="col-xs-6">
						<ul class="list-unstyled">
							<li>
								 <strong>Sample #:</strong> '.$batch_description[0]['sample_no'].'
							</li>
							<li>
								 <strong>Inward #:</strong> '.$batch_description[0]['material_inward_no'].'
							</li>
							<li>
								 <strong>Manufacturing:</strong> '.$batch_description[0]['manufacturing_date'].'
							</li>
							<li>
								 <strong>Expiry:</strong> '.$batch_description[0]['expiry_date'].'
							</li>
							
							
						</ul>
					</div>
					
				</div>
		<table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>              
              <th width="10%"> Date</th>
			  <th width="30%"> Client Name </th>
              <th width="15%"> Invoice # </th>
              <th width="12%"> Quantity </th>
			  <th width="12%"> Rate </th>
              <th width="15%"> Order Amount </th>
            </tr>
          </thead>
          <tbody>';
		if(sizeof($batch_details) > 0){
			foreach($batch_details as $batch_row){
			   $client_info = $this->clients_model->getClientInfo($batch_row['comp_id']);
				$html .='<tr>
					<td>'.date('d M Y',strtotime($batch_row['on_date'])).'</td>
					<td> '.$client_info[0]['comp_name'].' </td>
					<td> '.$batch_row['invoice_no'].' </td>
					<td> '.$batch_row['outw_qty'].' '.$batch_row['prod_unit'].' </td>
					<td> '.$batch_row['rate'].' </td>
					<td> '.number_format($batch_row['amount'],2).' </td>
				</tr>';
			}
		}else{
				$html .='<tr>
					<td colspan="6" align="center">There are no records found. </td>
				</tr>';
		}
		$html .= ' </tbody>
        </table>';
		
		// for the formulated batches
		if($this->session->userdata('userrole') == 'Admin'){
			if(sizeof($productsUsedForFormulation) > 0){
				$html .= '<table class="table table-striped table-bordered table-hover" id="formulated_row" style="display:none;">
				  <thead>
					<tr>              
					  <th> Batch #</th>
					  <th> Product Name </th>
					  <th> Quantity </th>
					</tr>
				  </thead>
				  <tbody>';
				  foreach($productsUsedForFormulation as $product_used){
				 $html .= ' <tr>
							<td> '.$product_used['lot_no'].'</td>
							<td> '.$product_used['product_name'].' </td>
							<td> '.$product_used['outw_qty'].' '.$product_used['prod_unit'].'</td>
							
						</tr>';
				 }
				 $html .= '</tbody>
				</table>
				<script type="text/javascript">
				$(".showformulated").click(function(){
					$("#formulated_row").toggle();
				});
				</script>';
			}
		}
		
		
		
		echo $html;
	}
	
	
	
	
	/*Ajax call add new row of packing material for child batch */
	public function add_new_packing_row(){
	
		// get list of all Products
		$allPackingProducts = $this->product_model->getPackingProducts();
		$products_data = array(''=>'Select Product');
		if(sizeof($allPackingProducts) > 0){
			$i= 0;
			foreach($allPackingProducts as $product){
				$products_data[$product['pid']] = $product['product_name'].' ('.$product['item_code'].')';
			}
		}
		//$data['products_data'] = $products_data;
		$rownums= trim($this->input->post('rownums'))+1;
		$rowHTml = '<tr class="gradeX short odd" id="tr_'.$rownums.'">
				<td width="50%">'.
					form_dropdown('packing_pid[]',$products_data,'','class="form-control select2me" id="prod_'.$rownums.'" tabindex="0" placeholder= "Select Product" required="required" style="width:100%;" id="prod_'.$rownums.'"').'  
					
				</td>
				<td width="20%" id="td_'.$rownums.'">&nbsp; </td>
				<td width="20%"> <input type="text" class="form-control used_qty" name="used_qty[]" value= "" required="required"  id="used_qty_'.$rownums.'" />
				 <input type="hidden" class="form-control" id="batch_value_'.$rownums.'" name="batch_value[]" value= ""  />
				</td>
				
				<td width="10%">
					<a class="btn default btn-xs red Delete" href="javascript:void(0)" alt="Delete" title="Delete" data_row="'.$rownums.'"><i class="fa fa-trash-o"></i></a>
				</td>
			</tr> ';
			
			
		echo $rowHTml;
	}
	
	
	
	
	
	

	
	/* Get balanced amount of each batch for the product and firm id  */
	public function get_batchwise_stock(){
		$prodId= trim($this->input->post('prodId')); 
		$firmId= trim($this->input->post('firmId'));
		
		$balancedLots = $this->product_model->getBatchwiseStock($prodId,$firmId);
		//echo '<pre>'; print_r($balancedLots ); die();
		$html ='<table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>              
              <th> Batch #</th>
			  <th> Supplier Name </th>
              <th> Batch Stock </th>
              <th> Sample # </th>
			  <th> Location </th>
            </tr>
          </thead>
          <tbody>';
		if(sizeof($balancedLots) > 0){
			foreach($balancedLots as $batch_row){
			   $supplierData = $this->suppliers_model->getSupplierInfo($batch_row['su_id']); 
				$html .='<tr>
					<td>'. $batch_row['lot_no'] .'</td>
					<td> '.$supplierData[0]['supl_comp'].' </td>
					<td> '. $batch_row['batchStock'] .' </td>
					<td> '. $batch_row['sample_no'] .' </td>
					<td>  '. $batch_row['received_at'] .' </td>
				</tr>';
			}
		}else{
				$html .='<tr>
					<td colspan="5" align="center">No Records found. </td>
				</tr>';
		}
		$html .= ' </tbody>
        </table>';
		echo $html;
		
	}
}
