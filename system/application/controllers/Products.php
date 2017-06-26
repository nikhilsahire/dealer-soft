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
	Add product in database
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
				$this->form_validation->set_rules('hsn_code', 'HSN Number', 'trim|required|max_length[50]');
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[150]');
				//$this->form_validation->set_rules('product_desc', 'product Description', 'trim|required');				
				$this->form_validation->set_rules('prod_unit', 'Product Unit', 'trim|required|max_length[4]');
				$this->form_validation->set_rules('min_qty', 'Minimum Quantity', 'trim|required');
				$this->form_validation->set_rules('initial_stock', 'Initial Stock', 'trim|required|numeric');
				$this->form_validation->set_rules('initial_stock_rate', 'Initial Rate', 'trim|required|numeric');
				$this->form_validation->set_rules('sgst_per', 'State GST %', 'trim|required|numeric');
				$this->form_validation->set_rules('cgst_per', 'Central GST %', 'trim|required|numeric');
				$this->form_validation->set_rules('igst_per', 'Intra State GST %', 'trim|required|numeric');
				$this->form_validation->set_rules('selling_price', 'Max Selling Price', 'trim|required|numeric|greater_than[0]');
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  
					 $product_details['item_code'] = trim($this->input->post('item_code'));
					 $product_details['hsn_code'] = trim($this->input->post('hsn_code'));
					 $product_details['product_name'] = trim($this->input->post('product_name'));
					 $product_details['product_desc'] = trim($this->input->post('product_desc'));
					 $product_details['prod_unit'] = trim($this->input->post('prod_unit'));
					// $product_details['prod_gravity'] = trim($this->input->post('prod_gravity'));
					 $product_details['min_qty'] = trim($this->input->post('min_qty'));	
					// $product_details['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $product_details['product_keywords'] = trim($this->input->post('product_keywords'));					 					 				 			
					 $product_details['initial_stock'] = $this->input->post('initial_stock');
					 $product_details['initial_stock_rate'] =$this->input->post('initial_stock_rate');
					 $product_details['sgst_per'] = trim($this->input->post('sgst_per'));
					 $product_details['cgst_per'] = trim($this->input->post('cgst_per'));
					 $product_details['igst_per'] = trim($this->input->post('igst_per'));
					 $product_details['selling_price'] = trim($this->input->post('selling_price'));
					 $product_details['tax_free'] = trim($this->input->post('tax_free'));
					 
					 $data['product_details'][0] = $product_details;
					 $this->template->set_layout('admin_default')->build('products/add_product',$data);
				 }
				 else
				 {
					 $data_insert = array();
					 $data_insert['item_code'] = trim($this->input->post('item_code'));
					 $data_insert['hsn_code'] = trim($this->input->post('hsn_code'));
					 $data_insert['product_name'] = trim($this->input->post('product_name'));
					 $data_insert['product_desc'] = trim($this->input->post('product_desc'));
					 $data_insert['prod_unit'] = trim($this->input->post('prod_unit'));
					 //$data_insert['prod_gravity'] = trim($this->input->post('prod_gravity'));
					 $data_insert['min_qty'] = trim($this->input->post('min_qty'));	
					// $data_insert['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $data_insert['product_keywords'] = trim($this->input->post('product_keywords'));
					 $data_insert['sgst_per'] = trim($this->input->post('sgst_per'));
					 $data_insert['cgst_per'] = trim($this->input->post('cgst_per'));
					 $data_insert['igst_per'] = trim($this->input->post('igst_per'));
					 $data_insert['selling_price'] = trim($this->input->post('selling_price'));
					 $data_insert['tax_free'] = trim($this->input->post('tax_free'));
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
				$this->form_validation->set_rules('hsn_code', 'HSN Number', 'trim|required|max_length[50]');			
				$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|max_length[20]'); 				
				$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[150]');
				//$this->form_validation->set_rules('product_desc', 'product Description', 'trim|required');				
				$this->form_validation->set_rules('prod_unit', 'Product Unit', 'trim|required|max_length[4]');
				$this->form_validation->set_rules('min_qty', 'Minimum Quantity', 'trim|required');
				$this->form_validation->set_rules('sgst_per', 'State GST %', 'trim|required|numeric');
				$this->form_validation->set_rules('cgst_per', 'Central GST %', 'trim|required|numeric');
				$this->form_validation->set_rules('igst_per', 'Intra State GST %', 'trim|required|numeric');
				$this->form_validation->set_rules('selling_price', 'Max Selling Price', 'trim|required|numeric|greater_than[0]');
				 if ($this->form_validation->run($this) == FALSE)
				 {
				  
					 $product_details['item_code'] = trim($this->input->post('item_code'));					 
					 $product_details['product_name'] = trim($this->input->post('product_name'));
					 $product_details['hsn_code'] = trim($this->input->post('hsn_code'));					 
					 $product_details['product_desc'] = trim($this->input->post('product_desc'));
					 $product_details['prod_unit'] = trim($this->input->post('prod_unit'));
					 $product_details['min_qty'] = trim($this->input->post('min_qty'));	
					 $product_details['hsn_code'] = trim($this->input->post('hsn_code'));
					 $product_details['sgst_per'] = trim($this->input->post('sgst_per'));
					 $product_details['cgst_per'] = trim($this->input->post('cgst_per'));
					 $product_details['igst_per'] = trim($this->input->post('igst_per'));
					 $product_details['selling_price'] = trim($this->input->post('selling_price'));
					 $product_details['tax_free'] = trim($this->input->post('tax_free'));
					// $product_details['marketing_talk'] = trim($this->input->post('marketing_talk'));
					// $product_details['product_keywords'] = trim($this->input->post('product_keywords'));					 					 				 			
					 $product_details['pid'] = trim($product_id);
					 
					$data['product_details'][0] = $product_details;
					$this->template->set_layout('admin_default')->build('products/edit_product',$data);
				 }
				 else
				 {
					 $data_insert = array();
					 $data_insert['hsn_code'] = trim($this->input->post('hsn_code'));					 
					 $data_insert['product_name'] = trim($this->input->post('product_name'));
					 $data_insert['product_desc'] = trim($this->input->post('product_desc'));
					 $data_insert['prod_unit'] = trim($this->input->post('prod_unit'));
					// $data_insert['prod_gravity'] = trim($this->input->post('prod_gravity'));
					 $data_insert['min_qty'] = trim($this->input->post('min_qty'));	
					 $data_insert['sgst_per'] = trim($this->input->post('sgst_per'));
					 $data_insert['cgst_per'] = trim($this->input->post('cgst_per'));
					 $data_insert['igst_per'] = trim($this->input->post('igst_per'));
					 $data_insert['selling_price'] = trim($this->input->post('selling_price'));
					 $data_insert['tax_free'] = trim($this->input->post('tax_free'));
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
				force_download($_SERVER['DOCUMENT_ROOT'].'/'.SITE_FOLDER.'uploads/pdf/'.$specData[0]['document_name'], NULL);
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
		   // echo '<pre>'; print_r($data['product_stock_old']); die();		
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
			
			// Get list of all tax(VAT/CST) entries
			$taxList = $this->orders_model->getTaxList('Both');
			$taxListArray = array('0'=>'Not Applicable');	
			foreach($taxList as $taxRow){
				 $taxListArray[$taxRow['tax_id']] = $taxRow['tax_per'].'% '.$taxRow['tax_type'];
			}
			$data['taxList'] = $taxListArray;
			
			// Get list of excise tax entries
			$exciseTaxList = $this->orders_model->getExciseTaxList('CGST');
			$exciseTaxListArray = array('0'=>'Not Applicable');	
			foreach($exciseTaxList as $exciseRow){
				 $exciseTaxListArray[$exciseRow['tax_per']] = $exciseRow['tax_per'].'% '.$exciseRow['tax_type'];
			}
			$data['exciseTaxList'] = $exciseTaxListArray;
			// get the firm list
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(0=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray;	
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
				//$this->form_validation->set_rules('received_at', 'Received At', 'trim|required');	
				//$this->form_validation->set_rules('batch_desc', 'Batch Description', 'trim|required');	
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
					 //$data_batch_details['received_at'] = trim($this->input->post('received_at'));
					 //$data_batch_details['transporter'] = trim($this->input->post('transporter'));
					 //$data_batch_details['batch_remark'] = trim($this->input->post('batch_remark'));
					 $data_batch_details['invoice_firm'] = trim($this->input->post('invoice_firm'));
					 $data_batch_details['expiry_date'] = trim($this->input->post('expiry_date'));
					 $data_batch_details['manufacturing_date'] = trim($this->input->post('manufacturing_date'));
					 $data_batch_details['added_by'] = $this->session->userdata('userid');
					 $data_batch_details['material_inward_no'] = ''; // to be generated at model level
					 
					 /// 
					 $data_batch_details['excise'] = trim($this->input->post('excise'));
					 $tax_id = trim($this->input->post('tax_id'));
					 // get the tax row details
					 $taxRow = $this->orders_model->getTaxRow($tax_id);
					 $data_batch_details['tax_per'] = $taxRow[0]['tax_per'];
					 $data_batch_details['tax_type'] = $taxRow[0]['tax_type'];
					 $data_batch_details['tax_id'] = $taxRow[0]['tax_id'];
					 
					 	
					  
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
	
	
	
}
