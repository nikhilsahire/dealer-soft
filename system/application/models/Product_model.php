<?php 
class Product_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	
	 
	 public function getAllProducts($excludePacking='No')
	 {
		 	$this->db->select("P.*, SUM(PS.inw_qty) AS inw_qty, SUM(PS.outw_qty) AS outw_qty");
			$this->db->from("product AS P");
			$this->db->join('product_stock AS PS', 'PS.pid = P.pid','left');
			if($excludePacking == 'Yes'){
				$this->db->where("P.prod_unit <>",'Packing Material');
			}
			$this->db->order_by('P.item_code ASC');
			$this->db->group_by('P.pid');
			//$this->db->limit(1);
			$query_product = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_product->num_rows()>0)
			{
				return $query_product->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /**/
	 
	 public function getProductInfo($id)
	 {
			$this->db->select("P.*");
			$this->db->from("product AS P");
			$this->db->where("P.pid",$id);
			$this->db->limit(1);
			$query_product = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_product->num_rows()>0)
			{
				return $query_product->result_array();
			}
			else
			{
				return false;
			}
	 }
	 public function getTotalStock($product_id,$firm_id=0)
	 {
		 	$this->db->select("SUM(PS.inw_qty) AS inw_qty, SUM(PS.outw_qty) AS outw_qty");
			$this->db->from('product_stock AS PS');
			$this->db->where("PS.pid",$product_id);
			if($firm_id > 0){
				$this->db->where("PS.firm_id",$firm_id);
			}
			//$this->db->limit(1);
			$query_total_stock = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_total_stock->num_rows()>0)
			{
				return $query_total_stock->result_array();
			}
			else
			{
				return array();
			}
	 }
	 // Add new product in database
	 public function addProduct($data_insert,$initial_stock=array('initial_stock'=>0,'rate'=>1 ))
	 {
		    $this->db->insert('product', $data_insert); 
			$pid =  $this->db->insert_id();
			// add initial stock
			   // get new batch number
			    $lot_no = 1;
				$row_lot_no = $this->db->query('SELECT MAX(lot_no)+1 AS `lot_no` FROM `product_stock`')->row();
				if ($row_lot_no) {
					$lot_no = $row_lot_no->lot_no; 
				}
				$data_stock['lot_no'] = $lot_no;
				$data_stock['pid'] = $pid;
				$data_stock['su_id'] = 1;
				$data_stock['inw_qty'] = $initial_stock['initial_stock'];
				$data_stock['rate'] = $initial_stock['initial_stock_rate'];
				$data_stock['amount'] = $initial_stock['initial_stock']*$initial_stock['initial_stock_rate'];
				$data_stock['instock'] = $initial_stock['initial_stock'];
				$data_stock['on_date'] = date('Y-m-d');
				$data_stock['batch_desc'] = 'Opening Stock';
                $this->db->insert('product_stock', $data_stock);
				
				$data_batch_desc['lot_no'] = $lot_no;
				$data_batch_desc['added_by'] = $this->session->userdata('userid');
				$data_batch_desc['invoice_firm'] = 1;
				$data_batch_desc['batch_remark'] = 'Opening Stock';
                $this->db->insert('product_batch_details', $data_batch_desc);
			 
			 return $pid;
		
	 }
	 //
	 public function updateProduct($data_update,$id)
	 {
		 if($id > 0){
			 $this->db->where("pid", $id);
			 $this->db->update("product", $data_update); 			 
			 return $id;
		}
	 }
	 
	 
	 public function getProductSpects($id)
	 {
			$this->db->select("PSF.*");
			$this->db->from("product_specifications AS PSF");
			$this->db->where("PSF.product_id",$id);
			$query_product_specs = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_product_specs->num_rows()>0)
			{
				return $query_product_specs->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 public function getProductSpectInfo($spec_id,$product_id)
	 {
			$this->db->select("PSF.*");
			$this->db->from("product_specifications AS PSF");
			$this->db->where("PSF.id",$spec_id);
			$this->db->where("PSF.product_id",$product_id);
			$query_product_specs = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_product_specs->num_rows()>0)
			{
				return $query_product_specs->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 public function add_pdf($data_insert)
	{
			$this->db->insert('product_specifications', $data_insert); 
			$pdf_id =  $this->db->insert_id();
			return $pdf_id;
	}
	
	public function update_pdf($data_update,$pdf_id,$course_id)
	{
		  	$this->db->where("id", $pdf_id);
			$this->db->where("course_id", $course_id);
			$this->db->update("course_pdf", $data_update); 
		 	return $pdf_id;
	}
	 
	 public function delete_pdf($product_id,$id)
	{
		   $query = $this->db->delete('product_specifications',array('id'=>$id,'product_id'=>$product_id));
		   return $query;
	}
	
	public function getProductDiseases($pid){
			$this->db->select("GROUP_CONCAT(D.diseases_name) AS diseases, GROUP_CONCAT(D.diseases_id) AS diseases_id",false);
			$this->db->from("disease_products AS DP");
			$this->db->join('diseases AS D', 'D.diseases_id = DP.disease_id');
			$this->db->where("DP.pid",$pid);
			$this->db->order_by('D.diseases_name ASC');
			$query_products_disease = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_products_disease->num_rows()>0)
			{
				return $query_products_disease->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	public function getProductCrops($pid){
			$this->db->select("GROUP_CONCAT(C.crop_name) AS crop_name, GROUP_CONCAT(C.crop_id) AS crop_id",false);
			$this->db->from("crop_products AS CP");
			$this->db->join('crops AS C', 'C.crop_id = CP.crop_id');
			$this->db->where("CP.pid",$pid);
			$this->db->order_by('C.crop_name ASC');
			$query_products_crops = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_products_crops->num_rows()>0)
			{
				return $query_products_crops->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function getProductStock($pid,$stardate='',$enddate='',$firm_id=0){
			$this->db->select('PS.*, P.item_code, P.product_name, P.prod_unit');
			$this->db->from('product_stock AS PS');
			$this->db->join('product AS P', 'P.pid = PS.pid');
			$this->db->where("P.pid",$pid);
			if($enddate != '' && $stardate !=''){
				$this->db->where("PS.on_date >=",$stardate);  
				$this->db->where("PS.on_date <=",$enddate);
			}
			if($firm_id > 0){
				$this->db->where("PS.firm_id ",$firm_id); 
			}
			$this->db->order_by('PS.on_date DESC, PS.id DESC');
			$query_products_stock = $this->db->get();
			// echo $this->db->last_query();die;
			if($query_products_stock->num_rows()>0)
			{
				return $query_products_stock->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/**/
	public function getOldStock($pid,$stardate='',$firm_id=0){
		$this->db->select('PS.*, P.item_code, P.product_name, P.prod_unit, (SUM( PS.`inw_qty` ) - SUM( PS.`outw_qty` )) AS stock ');
			$this->db->from('product_stock AS PS');
			$this->db->join('product AS P', 'P.pid = PS.pid');
			$this->db->where("P.pid",$pid);
			if($stardate !=''){
				$this->db->where("PS.on_date <",$stardate);  
				
			}
			if($firm_id > 0){
				$this->db->where("PS.firm_id ",$firm_id); 
			}
			$this->db->group_by('PS.lot_no');
			$this->db->having('stock > ',0);
			$this->db->order_by('PS.on_date DESC, PS.id DESC');
			$query_products_stock = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_products_stock->num_rows()>0)
			{
				return $query_products_stock->result_array();
			}
			else
			{
				return array();
			}
	}
	
	// Add new batch in the stock
	public function addStock($data_insert,$data_batch_details,$product_id, $paymentUpates = array(), $prod_ref_id = 0){
			   
			if(sizeof($data_insert) > 0){
				
			   // get new batch number and material inword number
			    $resultArray = $this->getNewLotNumber($data_batch_details['invoice_firm']); 
				$data_insert['lot_no'] = $resultArray['lot_no'];				
                $this->db->insert('product_stock', $data_insert);
				
				// add other details in product batch details table 
				$data_batch_details['lot_no'] = $resultArray['lot_no'];	
				if($data_batch_details['material_inward_no'] == '' || $data_batch_details['material_inward_no'] == NULL){	
					$resultDCIArray = $this->getInwardNumber($data_batch_details['invoice_firm']); 
					$data_batch_details['material_inward_no'] = $resultDCIArray['material_inward_no'];
				}
				
                $this->db->insert('product_batch_details', $data_batch_details);
				
				
				// update the total inward in purchase order products for the PO with pid
					$this->db->set('total_inword', 'total_inword+'.$data_insert['inw_qty'], FALSE);
					$this->db->where("id", $prod_ref_id ); 
					$this->db->update("purchase_order_products"); 
					$this->db->limit(1);
					// check for the PO is completed or not. If completed update status to "Completed"
					// SELECT (`purchase_qty` - `total_inword`) AS balance FROM `purchase_order_products` WHERE `purc_order_id` =9 GROUP BY `purchase_pid` HAVING balance >0
					$this->db->select('(`purchase_qty` - `total_inword`) AS balance');
					$this->db->from('purchase_order_products');
					$this->db->where("purc_order_id", $data_batch_details['purc_order_id']);
					$this->db->group_by('purchase_pid');
					$this->db->having('balance > "0" ');
					$query_products_pending = $this->db->get();
					if($query_products_pending->num_rows() == 0){
						$order_status['status'] = 'Completed';
						$this->db->where("purc_order_id", $data_batch_details['purc_order_id']);
						$this->db->update("purchase_orders", $order_status);
						$this->db->limit(1);
					}
				
				
				
				return $resultArray['lot_no'];
				
		    }else{
				return 'Something went wrong with you.';
			}
	}
	
	// get the material inward number based on the firm number
	public function getInwardNumber($firm_id){
			$row_inward_no = $this->db->query('SELECT firm_id, firm_code, current_year, MAX(material_inward_no)+1 AS `material_inward_no` 
			FROM `company_firms` WHERE firm_id = "'.$firm_id.'"')->row();
			if ($row_inward_no) {
				$inChalanNo = $row_inward_no->firm_code.'/'.$row_inward_no->current_year.'/DCI/'.$row_inward_no->material_inward_no; 
				//$inLotNo = $row_inward_no->firm_code.'-'.$row_inward_no->current_year.'-'.$row_inward_no->lot_no; 
				$resultArray = array('material_inward_no'=> $inChalanNo); // 'lot_no'=>$inLotNo ,
				// update the table
				$data_update['material_inward_no'] = $row_inward_no->material_inward_no;
				// $data_update['lot_no'] = $row_inward_no->lot_no;
				$this->db->where("firm_id", $firm_id);
			    $this->db->update("company_firms", $data_update);				
				return $resultArray;
			}else{
				return false;
			}
			
	}
	
	// get the material inward number based on the firm number
	public function getNewLotNumber($firm_id){
			$row_inward_no = $this->db->query('SELECT firm_id, firm_code, current_year, MAX(lot_no)+1 AS `lot_no` 
			FROM `company_firms` WHERE firm_id = "'.$firm_id.'"')->row();
			if ($row_inward_no) {
				// $inChalanNo = $row_inward_no->firm_code.'/'.$row_inward_no->current_year.'/DCI/'.$row_inward_no->material_inward_no; 
				$inLotNo = $row_inward_no->firm_code.'-'.$row_inward_no->current_year.'-'.$row_inward_no->lot_no; 
				$resultArray = array('lot_no'=>$inLotNo ); // ,'material_inward_no'=> $inChalanNo
				// update the table
				// $data_update['material_inward_no'] = $row_inward_no->material_inward_no;
				$data_update['lot_no'] = $row_inward_no->lot_no;
				$this->db->where("firm_id", $firm_id);
			    $this->db->update("company_firms", $data_update);				
				return $resultArray;
			}else{
				return false;
			}
			
	}
	
	
	
	// get the batch rows based on the batch/lot number for the clients distrubiton
	public function viewBatchDetails($lot_no){
			$this->db->select('PS.*, P.prod_unit');
			$this->db->from('product_stock AS PS');
			$this->db->join('product AS P', 'P.pid = PS.pid');
			$this->db->where("PS.lot_no",$lot_no);
			$this->db->where("PS.comp_id > ",'0'); 		
			$this->db->order_by('PS.on_date DESC');
			
			$query_batch_details = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_batch_details->num_rows()>0)
			{
				return $query_batch_details->result_array();
			}
			else
			{
				return array();
			}
			
	}
	
	// get the batch description based on the batch/lot number
	public function productBatchDescription($lot_no){
			$this->db->select('PBD.*, PS.inw_qty, P.prod_unit');
			$this->db->from('product_batch_details AS PBD');
			$this->db->join('product_stock AS PS', 'PBD.lot_no = PS.lot_no');
			$this->db->join('product AS P', 'PS.pid = P.pid');
			$this->db->where("PBD.lot_no",$lot_no);
			$this->db->limit(1);
			$query_batch_details = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_batch_details->num_rows()>0)
			{
				return $query_batch_details->result_array();
			}
			else
			{
				return array();
			}			
	}
	
	
	/* Get the parentbatch details based on the lot number*/
	public function productParentBatchDescription($lot_no){
			$this->db->select('PS.*, PBD.expiry_date,PBD.bag_no,PBD.packing, PBD.batch_remark, PBD.manufacturing_date , PBD.sample_no,  PBD.manufacturing_date, PBD.material_inward_no , P.prod_unit, P.product_name, CF.firm_name');
			$this->db->from('product_stock AS PS');
			$this->db->join('product_batch_details AS PBD', 'PBD.lot_no = PS.lot_no');
			$this->db->join('product AS P', 'PS.pid = P.pid');
			$this->db->join('company_firms AS CF', 'CF.firm_id = PS.firm_id');
			$this->db->where("PS.lot_no",$lot_no);
			$this->db->where("PS.inw_qty >",0);
			$this->db->limit(1);
			$query_batch_details = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_batch_details->num_rows()>0)
			{
				return $query_batch_details->result_array();
			}
			else
			{
				return array();
			}			
	}
	
	// get the batch description based on the batch/lot number
	public function getPackingProducts(){
			$this->db->select('P.*');
			$this->db->from('product AS P');
			$this->db->where("P.product_category",'Packing Material');
			$this->db->order_by('P.product_name ASC');
			$query_packing_products = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_packing_products->num_rows()>0)
			{
				return $query_packing_products->result_array();
			}
			else
			{
				return array();
			}			
	}
	
	
	/* get the products stock by the lot number  */
	 public function getBatchStock($lot_no,$product_id){
	 	$this->db->select('sum( `inw_qty` ) - sum( `outw_qty` ) AS instock');
		$this->db->from('product_stock');
		$this->db->where("lot_no",$lot_no);
		$this->db->where("pid",$product_id);		
		$query_prod_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_prod_stock->num_rows()>0){
			return $query_prod_stock->result_array();
		}else{
			return array();
		}
	 }
	
	
	/* Get all the batches/lots of product which has some balanced quantity */
	 public function getBalancedLots($pid,$firmId){
	 		//echo $pid.'==>'.$firmId; die();
	 		// get sister firms 
			$sisterFirmsStr = $this->getSisterFirms($firmId);
			$sisterFirmsArray = explode(',',substr($sisterFirmsStr,0,-1));
			// echo '<pre>'; print($sisterFirmsArray); die();
			//
	 		$this->db->select('sum( PS.inw_qty ) - sum( PS.outw_qty ) AS batchStock, PS.lot_no, PS.su_id, PBD.packing');
			$this->db->from('product_stock AS PS');
			$this->db->join('product_batch_details AS PBD', 'PBD.lot_no = PS.lot_no AND `PBD`.`invoice_firm` IN('.substr($sisterFirmsStr,0,-1).')');
			$this->db->where("PS.pid",$pid);
			
			//$this->db->where("PS.firm_id",$firmId);
			 $this->db->where_in("PS.firm_id",$sisterFirmsArray);
			
			$this->db->having("batchStock > ",0); 
			$this->db->group_by('PS.`lot_no`');		
			$this->db->order_by('PS.on_date ASC');
			
			$query_batch_details = $this->db->get();
			
			 echo $this->db->last_query();die;
			if($query_batch_details->num_rows()>0)
			{
				return $query_batch_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 
	 /* get all the sister firms based on the firm id*/
	 public function getSisterFirms($firmId){
	 	$sisterFirmsRes =  $this->db->query('SELECT `firm_id` FROM `company_firms` WHERE `parent_firm` IN (SELECT `parent_firm` FROM `company_firms` WHERE `firm_id` ="'.$firmId.'" )')->result_array();
		$str='';
		foreach($sisterFirmsRes as $row){
			$str .= $row['firm_id'].',';
		}
		return $str;
	 }
	 
	 
	 /* GET the sub-batch lot number based on the parent batch */ 
	 
	 public function getChildLotNumber($lot_no){
	 
	 		$this->db->select('COUNT(`id`) AS subBatchCnt');
			$this->db->from('product_stock AS PS');
			$this->db->like('PS.lot_no', $lot_no.'-', 'after');
			$this->db->where("PS.inw_qty > ",0);
						
			$query_child_batch_details = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_child_batch_details->num_rows()>0)
			{
				return $query_child_batch_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	
	 
	/* Function to add the repacking batch and deduct the packing units */ 
	public function addRepackBatchStock($data_insert,$data_batch_details,$usedProdArray){
			// echo '<pre>'; print_r($data_insert); echo '<pre>'; print_r($data_batch_details); echo '<pre>'; print_r($usedProdArray); die(); 
			if(sizeof($data_insert) > 0){
			  // Insert new batch in stock			    			
				$this->db->insert('product_stock', $data_insert);
			  // Insert the newly added batch details
			 $this->db->insert('product_batch_details', $data_batch_details);
			  // Insert the packing material batch details with used quantity	
			  foreach($usedProdArray as $usedProd){		    			
				$this->db->insert('product_stock', $usedProd);
			  }			
				
				return $data_insert['lot_no'];
				
		    }else{
				return 'Something went wrong with you.';
			}
	}
	
	
	/* Function to get the materials/products used for lot number based on lot number */ 
	public function getProductsUsedBatch($lot_no){
			   
			$this->db->select('PS.*, P.product_name, P.prod_unit');
			$this->db->from('product_stock AS PS');
			$this->db->join('product AS P', 'P.pid = PS.pid');
			$this->db->where("PS.invoice_no ",'SELF-'.$lot_no);
			$this->db->where("P.product_category ",'Packing Material');		
			
			$query_products_used_details = $this->db->get();
			//echo $this->db->last_query();die;
			
			if($query_products_used_details->num_rows()>0)
			{
				return $query_products_used_details->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* Function to add the packing material to existing batch */ 
	public function addBatchPackingMaterial($usedProdArray){
			   
			if(sizeof($usedProdArray) > 0){
			  
			  // Insert the packing material batch details with used quantity	
			  foreach($usedProdArray as $usedProd){		    			
				$this->db->insert('product_stock', $usedProd);
			  }			
			  return 1;
						
		    }else{
				return 'Something went wrong with you.';
			}
	}
	
	/* Function to get the firm wise product stock */ 
	public function firmProductStock($pid){
			
		$this->db->select('(SUM( PS.`inw_qty` ) - SUM( PS.`outw_qty` )) AS Stock, CF.`firm_id` , CF.firm_code');
		$this->db->from('product_stock AS PS');
		$this->db->join('company_firms AS CF', 'PS.firm_id = CF.firm_id');
		$this->db->where("PS.pid ",$pid);
		$this->db->group_by('PS.`firm_id`');		
		$query_firm_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_firm_stock->num_rows()>0)
		{
			return $query_firm_stock->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* get the QC report based on lot number */
	public function getQcReport($lot_no){
		$this->db->select('qc_report');
		$this->db->from('purchase_confirm_list AS PCL');
		$this->db->where("PCL.lot_no ",$lot_no);
		$this->db->limit(1);		
		$query_qc_report = $this->db->get();
		
		if($query_qc_report->num_rows()>0)
		{
			return $query_qc_report->result_array();
		}
		else
		{
			return array();
		}
	}
	
	/* Function to get booked value of the product*/ 
	public function firmProductBooked($pid){
			
		$this->db->select('(SUM( COP.`order_qty`) - SUM( COP.`dispatch_qty`)) AS bookedProdStock, CF.firm_code');
		$this->db->from('client_order_prodcts AS COP');
		$this->db->join('client_orders AS CO', 'COP.`order_id` = CO.`order_id`');
		$this->db->join('company_firms AS CF', 'CF.firm_id = CO.invoice_firm');
		$this->db->where("COP.`order_pid` ",$pid);
		$this->db->where("CO.`order_status` ",'Pending');
		$this->db->group_by('CO.invoice_firm');		
		$query_firm_booked_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_firm_booked_stock->num_rows()>0)
		{
			return $query_firm_booked_stock->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* Function to get booked value of the product */ 
	public function firmProductInProcess($pid){
			
		$this->db->select('(SUM( POP.`purchase_qty`) - SUM( POP.`total_inword`)) AS bookedProdStock, CF.firm_code');
		$this->db->from('purchase_order_products AS POP');
		$this->db->join('purchase_orders AS PO', 'POP.`purc_order_id` = PO.`purc_order_id`');
		$this->db->join('company_firms AS CF', 'CF.firm_id = PO.firm_id');
		$this->db->where("POP.`purchase_pid` ",$pid);
		$this->db->where("PO.`status` ",'Confirmed');
		$this->db->group_by('PO.firm_id');		
		$query_firm_purchased_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_firm_purchased_stock->num_rows()>0)
		{
			return $query_firm_purchased_stock->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* Get listing of all Batches having stocks for all products */
	
	public function getListingOfAllBatches($stardate='',$enddate='',$firm_id=0){	
		
		$this->db->select('PS.lot_no, PS.on_date, sum( PS.inw_qty ) AS  inw_qty, sum( PS.outw_qty ) AS outw_qty, PS.instock, P.product_name, P.item_code, P.prod_unit ');
		$this->db->from('product_stock AS PS');
		$this->db->join('product AS P', 'P.`pid` = PS.`pid`');
		if($enddate != '' && $stardate !=''){
				$this->db->where("PS.on_date >=",$stardate);  
				$this->db->where("PS.on_date <=",$enddate);
			}
			/*if($firm_id > 0){
				$this->db->where("PS.firm_id ",$firm_id); 
			}*/
		$this->db->group_by('PS.lot_no');
		$this->db->order_by('PS.id DESC');		
		$query_listing_all_batches = $this->db->get();
		// echo $this->db->last_query();die;
		if($query_listing_all_batches->num_rows()>0)
		{
			return $query_listing_all_batches->result_array();
		}
		else
		{
			return array();
		}
		
		
	}
	
	/* Get listing of all Batches having stocks for all products */
	
	public function getProductsUsedForFormulation($lot_no){	
		
		$this->db->select('PS.lot_no, PS.outw_qty, P.product_name, P.prod_unit ');
		$this->db->from('product_stock AS PS');
		$this->db->join('product AS P', 'P.`pid` = PS.`pid`');
		$this->db->where("PS.`invoice_no` ",'SELF-'.$lot_no);
		$this->db->order_by("P.`product_name` ASC");
		$query_products_used_formulation = $this->db->get();
		// echo $this->db->last_query();die;
		if($query_products_used_formulation->num_rows()>0)
		{
			return $query_products_used_formulation->result_array();
		}
		else
		{
			return array();
		}
		
		
	}
	
	/* Function to get booked order details of the product*/ 
	public function getProductBookedDetails($pid){
			
		$this->db->select('((COP.`order_qty`) - ( COP.`dispatch_qty`)) AS bookedProdStock, COP.order_rate, CO.order_number, CO.order_date, C.comp_name, U.first_name, U.last_name');
		$this->db->from('client_order_prodcts AS COP');
		$this->db->join('client_orders AS CO', 'COP.`order_id` = CO.`order_id`');
		$this->db->join('clients AS C', 'C.comp_id = CO.comp_id');
		$this->db->join('users AS U', 'U.uid = CO.uid');
		$this->db->where("COP.`order_pid` ",$pid);
		$this->db->where("CO.`order_status` ",'Pending');
		
		$query_product_booked_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_product_booked_stock->num_rows()>0)
		{
			return $query_product_booked_stock->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* Function to get booked value of the product */ 
	public function getProductProcessedDetails($pid){
			
		$this->db->select('(( POP.`purchase_qty`) - ( POP.`total_inword`)) AS bookedProdStock, POP.purchase_rate, PO.purc_order_number, PO.order_date, S.supl_comp, U.first_name, U.last_name');
		$this->db->from('purchase_order_products AS POP');
		$this->db->join('purchase_orders AS PO', 'POP.`purc_order_id` = PO.`purc_order_id`'); 
		$this->db->join('suppliers AS S', 'S.supl_id = PO.supplier_id');
		$this->db->join('users AS U', 'U.uid = PO.order_by');
		$this->db->where("POP.`purchase_pid` ",$pid);
		$this->db->where("PO.`status` ",'Confirmed');
		$query_firm_purchased_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_firm_purchased_stock->num_rows()>0)
		{
			return $query_firm_purchased_stock->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* Get the firm id based on lot number and Product Id*/
	public function getBatchFirmDetails($lot_no, $pid){
			
		$this->db->select('PS.firm_id');
		$this->db->from('product_stock AS PS');		 
		$this->db->where("PS.`lot_no` ",$lot_no);
		$this->db->where("PS.`pid` ",$pid); 
		$this->db->where("PS.`comp_id` ",0); 
		$query_firm_batch_details = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_firm_batch_details->num_rows()>0)
		{
			return $query_firm_batch_details->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* Get batchwise stock of products based on pid and firmid */
	 public function getBatchwiseStock($pid,$firmId){
	 		//echo $pid.'==>'.$firmId; die();
	 		// get sister firms 
			$sisterFirmsStr = $this->getSisterFirms($firmId);
			$sisterFirmsArray = explode(',',substr($sisterFirmsStr,0,-1));
			// echo '<pre>'; print($sisterFirmsArray); die();
			
			if($firmId > 0){
				 $this->db->select('sum( PS.inw_qty ) - sum( PS.outw_qty ) AS batchStock, PS.lot_no, PS.su_id, PBD.received_at, PBD.sample_no');
				 $this->db->join('product_batch_details AS PBD', 'PBD.lot_no = PS.lot_no AND `PBD`.`invoice_firm` IN('.substr($sisterFirmsStr,0,-1).')');
				 $this->db->where("PS.pid",$pid); 
				 $this->db->where_in("PS.firm_id",$sisterFirmsArray);
			}else {
				$this->db->select('sum( PS.inw_qty ) - sum( PS.outw_qty ) AS batchStock, PS.lot_no, PS.su_id, "-" as received_at, , "-" as sample_no');
				$this->db->from('product_stock AS PS');			 
				$this->db->where("PS.pid",$pid); 
			}
			$this->db->having("batchStock > ",0); 
			$this->db->group_by('PS.`lot_no`');		
			$this->db->order_by('PS.on_date ASC');
			
			$query_batch_details = $this->db->get();
			
			// echo $this->db->last_query();die;
			if($query_batch_details->num_rows()>0)
			{
				return $query_batch_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	
}
?>