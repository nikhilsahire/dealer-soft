<?php 

/* Add formulated products with new batch created in stock */
	public function formulated_stock($product_id, $firmId = 0){
	  // echo $firmId; die();
	  if($product_id > 0){
		$data['menutitle'] = 'Products';
		$data['pagetitle'] = 'Add Formulated Stock';
		$data['firmId'] = $firmId;			
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.$this->config->item('base_url_stores').'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.$this->config->item('base_url_stores').'products/">Manage Products</a><i class="fa fa-angle-right"></i></li><li><a href="'.$this->config->item('base_url_stores').'products/stock/'.$product_id.'">View Stock</a><i class="fa fa-angle-right"></i></li><li>Add Formulated Product</li></ul>';			
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
			
			// get the firm list 
			$firmList = $this->orders_model->getFirmList();
			$firmListArray = array(''=>'Select Firm');	
			foreach($firmList as $firm){
				 $firmListArray[$firm['firm_id']] = $firm['firm_name'];
			}
			$data['firmList'] = $firmListArray ;
			//$firmId = $firmList[0]['firm_id'];
			// get the list of all chield products and their batches
			$allChildProducts = $this->formulated_product_model->getChildProducts($product_id);
			$allChildProductsList = array();	
			foreach($allChildProducts as $childProduct){
				$allChildProductsList[$childProduct['child_pid']] = $childProduct;
				$balancedLots = $this->orders_model->getProductBalancedLots($childProduct['child_pid'],0,$firmId);
				$allChildProductsList[$childProduct['child_pid']]['batches'] = $balancedLots; 
				
			}
			$data['allChildProductsList'] = $allChildProductsList;
			
			// echo '<pre>'; print_r($data['allChildProductsList']); die();
			// Get the packing material batches
			$packingProducts = $this->product_model->getPackingProducts();
			$data['packingProducts'] = $packingProducts;
			$data['product_id'] = $product_id;	
			$productInfo = $this->product_model->getProductInfo($product_id);
			$data['product_name'] = $productInfo[0]['product_name'];
			
			//echo '<pre>'; print_r($data['batchDetails']); die();
			if(trim($this->input->post('submit')) == '')
			{
				$this->template->set_layout('admin_default')->build('stores/products/formulated_add_stock',$data);
			}elseif(trim($this->input->post('submit')) == 'Add Formulated Stock')
			{ 
				//echo '<pre>'; print_r($this->input->post()); die();
				$id = '';				
				$this->form_validation->set_rules('batch_desc', 'Batch Description', 'trim|required');
				$this->form_validation->set_rules('invoice_firm', 'Invoice Firm', 'trim|required|numeric');	
				$this->form_validation->set_rules('inw_qty', 'Formulated Quantity', 'trim|required|numeric');
				
				
				 if ($this->form_validation->run($this) == FALSE)
				 {				
					$this->template->set_layout('admin_default')->build('stores/products/formulated_add_stock',$data);
				 }
				 else
				 {
					// echo '<pre>'; print_r($this->input->post()); die();
					 // Array of formulated product which is created
					 $invoice_firm_id = trim($this->input->post('invoice_firm'));
					 $firmDetails =  $this->orders_model->getFirmDetails($invoice_firm_id);
					 $data_insert = array();
					 $data_insert['on_date'] = date('Y-m-d');					 
					 $data_insert['su_id'] =  $firmDetails[0]['asso_supplier_id'];					 
					 $data_insert['pid'] = trim($product_id);
					 $data_insert['invoice_no'] = 'Self-Formulated';
					 
					 $data_insert['lot_no'] = ''; // to be generated at model level
					 $data_insert['firm_id'] = trim($this->input->post('invoice_firm')); // to be generated at model level	
					 $data_insert['inw_qty'] = trim($this->input->post('inw_qty'));					 	
					 $data_insert['batch_desc'] = trim($this->input->post('batch_desc'));			 
					 $data_insert['instock'] = trim($this->input->post('inw_qty'));
					 // Array of product_batch_details
					 $data_batch_details = array();
					 $data_batch_details['bag_no'] = 1;	
					 $data_batch_details['packing'] = trim($this->input->post('inw_qty'));
					 $data_batch_details['sample_no'] = '';
					 $data_batch_details['received_at'] = '';
					 $data_batch_details['batch_remark'] = trim($this->input->post('batch_remark'));
					 $data_batch_details['invoice_firm'] = trim($this->input->post('invoice_firm'));
					 $data_batch_details['expiry_date'] = trim($this->input->post('expiry_date'));
					 $data_batch_details['manufacturing_date'] = trim($this->input->post('manufacturing_date'));
					 $data_batch_details['added_by'] = $this->session->userdata('userid');
					 $data_batch_details['material_inward_no'] = 'Self Formulated batch'; // to be generated at model level	
					 
					 
					 // Array of child products and quantity used in formulation
					 $outgoingProductsCnt = sizeof($this->input->post('formulated_pid'));	
					 if($outgoingProductsCnt > 0){
					    $i = 0;
						$totalAmountLoaded = 0.00;
					 	$formulated_pid = $this->input->post('formulated_pid');						
						$batch_value = $this->input->post('batch_value');
						$lot_nums = $this->input->post('lot_nums');						
						$used_qty = $this->input->post('used_qty');
						
						for($j=0; $j<$outgoingProductsCnt; $j++){
							if(($used_qty[$j] <= $batch_value[$j]) && $used_qty[$j] > 0){
								$childProdBatchDetails = $this->product_model->productParentBatchDescription($lot_nums[$j]);
								$batchFirmDetails = $this->product_model->getBatchFirmDetails($lot_nums[$j],$childProdBatchDetails[0]['pid']);
								$usedChildProdArray[$i]['pid'] = $childProdBatchDetails[0]['pid'];
								$usedChildProdArray[$i]['comp_id'] =  $firmDetails[0]['asso_client_id'];//trim($this->input->post('invoice_firm'));
								$usedChildProdArray[$i]['invoice_no'] =  'SELF-Formulated'; // later part will be attached at model level
								$usedChildProdArray[$i]['outw_qty'] =  $used_qty[$j];
								$usedChildProdArray[$i]['lot_no'] =  $lot_nums[$j];
								$usedChildProdArray[$i]['rate'] =  $childProdBatchDetails[0]['rate'];
								$usedChildProdArray[$i]['amount'] =  $childProdBatchDetails[0]['rate']*$used_qty[$j];
								$usedChildProdArray[$i]['instock'] =  $batch_value[$j]-$used_qty[$j];
								$usedChildProdArray[$i]['on_date'] = date('Y-m-d'); 
								$usedChildProdArray[$i]['firm_id'] = $batchFirmDetails[0]['firm_id']; // $invoice_firm_id ;
								$usedChildProdArray[$i]['batch_desc'] =  'Used in Formulation';	
								$totalAmountLoaded += $usedChildProdArray[$i]['amount'];
								$i++;
							}
						}
						// Final product rate and Amount
						$finalProdCost = round(($totalAmountLoaded/$data_insert['inw_qty']),2);
						$data_insert['rate'] = $finalProdCost;
					    $data_insert['amount'] = $data_insert['inw_qty']*$finalProdCost;
						echo '<pre>'; print_r($data_insert); echo '<pre>'; print_r($data_batch_details); echo '<pre>'; print_r($usedChildProdArray); die();
						// insert the records in database
						$id = $this->formulated_product_model->add_formulated_stock($data_insert,$data_batch_details,$usedChildProdArray);
					 }		 
					 
					 
					
					 if($id != ''){
						 $arr_msg = array('suc_msg'=>'Formulated Product is added successfully. Batch # is '.$id,'msg-type'=>'success');
					 }else{
						 $arr_msg = array('suc_msg'=>'Failed to formulate the product','msg-type'=>'danger');
					 }
					 
					 $this->session->set_userdata($arr_msg);
					 redirect('stores/products/stock/'.$product_id);
				 }
			}
			
		}else{
			redirect('stores/products/');
		}
		
	}