<?php 
class Orders_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getAllOrders($stardate='',$enddate='', $firm_id = 0, $order_type = ''){
	
		  $this->db->select('CO.*, C.comp_name, U.first_name, U.last_name');
			$this->db->from('client_orders AS CO');
			$this->db->join('users AS U','U.uid = CO.uid');
			$this->db->join('clients AS C','C.comp_id = CO.comp_id');
			
			if($this->session->userdata('userrole') == 'Sales'){
				$this->db->where("CO.uid",$this->session->userdata('userid'));
			}
			if($order_type != ''){
				$this->db->where("CO.order_type ",$order_type);
			}
			
			if($firm_id > 0){
				$this->db->where("CO.invoice_firm ",$firm_id);
			}
			
			if($enddate != '' && $stardate !=''){
				$this->db->where("CO.order_date >=",$stardate);  
				$this->db->where("CO.order_date <=",$enddate);
			}
			
			$this->db->order_by('CO.order_status DESC');
			$this->db->order_by('CO.order_date DESC');
			$this->db->order_by('CO.order_id DESC');
			$query_products_stock = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_products_stock->num_rows()>0)
			{
				return $query_products_stock->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* Get list of all sample orders */
	public function getAllSamples($stardate='',$enddate='', $firm_id = 0){
	
		   $this->db->select('CO.order_id,CO.order_number, CO.uid, CO.order_status, CO.order_remark, CO.po_ref, CO.po_date, CO.order_date, C.comp_name, U.first_name, U.last_name');
			$this->db->from('client_orders AS CO');
			$this->db->join('users AS U','U.uid = CO.uid');
			$this->db->join('clients AS C','C.comp_id = CO.comp_id');
			$this->db->where("CO.order_type ",'Sample');
			if($this->session->userdata('userrole') != 'Admin'){
				$this->db->where("CO.uid",$this->session->userdata('userid'));
			}
			if($firm_id > 0){
				$this->db->where("CO.invoice_firm ",$firm_id);
			}
			if($enddate != '' && $stardate !=''){
				$this->db->where("CO.order_date >=",$stardate);  
				$this->db->where("CO.order_date <=",$enddate);
			}
			
			$this->db->order_by('CO.order_status DESC');
			$this->db->order_by('CO.order_date DESC');
			$query_products_stock = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_products_stock->num_rows()>0)
			{
				return $query_products_stock->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* Get the order amount and total dispacth amount */
	public function getOrderAmount($order_id)
	 {
		 	$this->db->select("SUM(COP.`order_qty` * COP.`order_rate`) AS orderTotal");
			$this->db->from("client_order_prodcts AS COP");
			//$this->db->join('client_order_prodcts AS COP','COP.order_id = OC.order_id');
			$this->db->where("COP.order_id",$order_id);	
			//$this->db->group_by('OC.challan_no');
			$query_order_amount = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_order_amount->num_rows()>0)
			{
				return $query_order_amount->result_array();
			}
			else
			{
				return array();
			}
	 }
	
	/* Get the order Chalan and Invoice numbers */
	public function getOrderChallans($order_id)
	 {
			$this->db->select("OC.challan_no, OC.invoice_no");
			$this->db->from("order_challan AS OC");
			$this->db->where("OC.order_id",$order_id);	
			$this->db->group_by('OC.challan_no');
			$query_order_challans = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_order_challans->num_rows()>0)
			{
				return $query_order_challans->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /* Get order Details based on the order number */
	 
	 public function getOrderDetails($order_id){
	 
	 		$this->db->select("CO.*, C.comp_name, CF.firm_name");
			$this->db->from("client_orders AS CO");
			$this->db->join("clients AS C", "C.comp_id = CO.comp_id");
			$this->db->join("company_firms AS CF ", "CF.firm_id = CO.invoice_firm ");
			$this->db->where("CO.order_id",$order_id);
			
			$query_order_details = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_order_details->num_rows()>0)
			{
				return $query_order_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 
	/* Get order products based on order id */
	 
	 public function getOrderProducts($order_id){
	 
	 		$this->db->select("COP.*, P.hsn_code, P.prod_unit");
			$this->db->from("client_order_prodcts AS COP");
			$this->db->join('product AS P', 'P.pid = COP.order_pid');
			$this->db->where("COP.order_id",$order_id);
			$query_order_details = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_order_details->num_rows()>0)
			{
				return $query_order_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	/* Get the list of the firm */
	 
	 public function getFirmList(){
	 
	 		$this->db->select("CF.firm_id,  CF.firm_name");
			$this->db->from("company_firms AS CF");
			$this->db->where("CF.status",'Active');
			$query_firm_array = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_firm_array->num_rows()>0)
			{
				return $query_firm_array->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 /* Get the firm row of the firm id */
	 
	 public function getFirmRow($firm_id, $field_name ='order_id'){ 
	 
	 		$this->db->select("(CF.order_id)+1 AS order_id, (CF.current_challan)+1 AS current_challan, (CF.current_invoice)+1 AS current_invoice,(CF.po_number)+1 AS po_number,  CF.firm_code,  CF.current_year,  CF.state_code");
			$this->db->from("company_firms AS CF");
			$this->db->where("CF.firm_id",$firm_id);
			$query_firm_array = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_firm_array->num_rows()>0)
			{
				return $query_firm_array->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 /* Get the list of the taxes 
	   Both = CST + VAT
	   Excise = Excise
	 */
	 
	 public function getTaxList($type ='Both'){
	 
	 		$this->db->select("TS.tax_id, TS.tax_per, TS.tax_type");
			$this->db->from("tax_structure AS TS");
			if($type == 'Both'){
				$this->db->where_in('TS.tax_type', array('SGST','IGST'));
			}else{
				$this->db->where('TS.tax_type', $type);
			}
			$this->db->where("TS.status",'Active');
			$query_tax_array = $this->db->get();
			// echo '<br/>'. $this->db->last_query(); // die;
			if($query_tax_array->num_rows()>0)
			{
				return $query_tax_array->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 /* Get the list of the excise taxes 
	 */
	 
	 public function getExciseTaxList($type ='CGST'){
	 
	 		$this->db->select("TS.tax_id, TS.tax_per, TS.tax_type");
			$this->db->from("tax_structure AS TS");
			//$this->db->where("TS.tax_type",'Active');
			$this->db->where('TS.tax_type', 'CGST');
			$this->db->where("TS.status",'Active');
			$query_tax_array = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_tax_array->num_rows()>0)
			{
				return $query_tax_array->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 /* Get the tax entry based on the tax id */
	 
	 public function getTaxRow($tax_id){
	 
	 		$this->db->select("TS.tax_id, TS.tax_per, TS.tax_type");
			$this->db->from("tax_structure AS TS");						
			$this->db->where("TS.tax_id",$tax_id);
			
			$query_tax_row = $this->db->get();
			
			if($query_tax_row->num_rows()>0)
			{
				return $query_tax_row->result_array();
			}
			else
			{
				return array('0'=> array('tax_id'=>'0','tax_per'=>'0','tax_type'=>'None'));
			}
	 
	 }
	 
	 /*
	 Update order into database
	 */ 
	 
	  public function updateOrder($data_insert,$order_id, $data_order_prod)
	 {
		 $this->db->where("order_id", $order_id);
		 $this->db->where("order_status", 'Pending');
		 $this->db->update("client_orders", $data_insert); 
		 //echo $this->db->last_query();die;
		 $this->db->limit(1);
		 // Delete all order products and insert products again 
		 $isDeleted = $this->deleteAllOrderProducts($order_id); 
		 // load the product model
		 $this->load->model('Product_model', 'product_model');  
		 
		 if( $isDeleted == 1){
		 	//$this->updateOrderProduct($data_products);
			// insert the order products
			$totalRows = sizeof($data_order_prod['pid']); // prod_ref_name
			for($i=0; $i < $totalRows; $i++){
				if($data_order_prod['pid'][$i] != '' && $data_order_prod['order_rate'][$i] != '' && $data_order_prod['order_qty'][$i] != '' && $data_order_prod['order_rate'][$i] != 0 && $data_order_prod['order_qty'][$i] != 0){
					$order_prod = array();
					$order_prod['order_id'] = $order_id;
					$productInfo = $this->product_model->getProductInfo($data_order_prod['pid'][$i]);
					$order_prod['prod_ref_name'] = $productInfo[0]['product_name'];
					$order_prod['order_pid'] = $data_order_prod['pid'][$i];
					$order_prod['order_rate'] = $data_order_prod['order_rate'][$i];
					$order_prod['order_qty'] = $data_order_prod['order_qty'][$i];
					$order_prod['updated_by'] = $data_order_prod['updated_by'];
					$order_prod['updated_date'] = $data_order_prod['updated_date'];	
					if($productInfo[0]['tax_free'] === 'No'){
				
					$order_prod['tax_free'] = $productInfo[0]['tax_free'];
					if($firmRow[0]['state_code'] === $data_order['state_code']){
						$order_prod['sgst_per'] = $productInfo[0]['sgst_per'];
						$order_prod['cgst_per'] = $productInfo[0]['cgst_per'];
						$order_prod['igst_per'] = 0.00;
					}else{
						$order_prod['sgst_per'] = 0.00;
						$order_prod['cgst_per'] = 0.00;
						$order_prod['igst_per'] = $productInfo[0]['igst_per'];
					}
					}else {
						$order_prod['tax_free'] = 'Yes';
						$order_prod['sgst_per'] = 0.00;
						$order_prod['cgst_per'] = 0.00;
						$order_prod['igst_per'] = 0.00;
					}				
							
					$order_prod_id = $this->updateOrderProduct($order_prod);
				}
			} 
		 
		 }
		 return $order_id;
	 }
	 
	 /*
	 Add order into database
	 */ 
	 
	  public function addOrder($data_order,$data_order_prod)
	 {
	 
		 $firmRow = $this->getFirmRow($data_order['invoice_firm']);
		  $data_order['order_number'] = $firmRow[0]['firm_code'].'/'.$firmRow[0]['current_year'].'/'.$firmRow[0]['order_id'];
		  $data_order['challan_number'] = $firmRow[0]['firm_code'].'/'.$firmRow[0]['current_year'].'/D/'.$firmRow[0]['current_challan'];
		  $data_order['invoice_number'] = $firmRow[0]['firm_code'].'/'.$firmRow[0]['current_year'].'/I/'.$firmRow[0]['current_invoice'];
			
			// update the order id field in firm table			
			$data_firm['current_challan'] = $firmRow[0]['current_challan'];
			$data_firm['current_invoice'] = $firmRow[0]['current_invoice'];
			$this->db->where("firm_id", $data_order['invoice_firm']);
			$this->db->update("company_firms", $data_firm); 
			
		 $this->db->insert("client_orders", $data_order); 
		 $orderId =  $this->db->insert_id();
		 // update the order id field in firm table
		  $data_firm['order_id'] = $firmRow[0]['order_id'];
		  $this->db->where("firm_id", $data_order['invoice_firm']);
		  $this->db->update("company_firms", $data_firm); 
		 // insert the order products
		 // $totalRows = sizeof($data_order_prod['prod_ref_name']);
		 
		 // load the product model
		 $this->load->model('Product_model', 'product_model');  
		 
		 $totalRows = sizeof($data_order_prod['pid']);
		 for($i=0; $i < $totalRows; $i++){
		 	//if($data_order_prod['prod_ref_name'][$i] != '' && $data_order_prod['order_rate'][$i] != '' && $data_order_prod['order_qty'][$i] != '')
			if($data_order_prod['pid'][$i] != '' && $data_order_prod['order_rate'][$i] != '' && $data_order_prod['order_qty'][$i] != ''){
				$order_prod = array();
				$order_prod['order_id'] = $orderId;
				$productInfo = $this->product_model->getProductInfo($data_order_prod['pid'][$i]);
				//$order_prod['prod_ref_name'] = $data_order_prod['prod_ref_name'][$i];
				$order_prod['prod_ref_name'] = $productInfo[0]['product_name'];
				$order_prod['order_pid'] = $data_order_prod['pid'][$i];
				$order_prod['order_rate'] = $data_order_prod['order_rate'][$i];
				$order_prod['order_qty'] = $data_order_prod['order_qty'][$i];
				$order_prod['updated_by'] = $data_order_prod['updated_by'];
				$order_prod['updated_date'] = $data_order_prod['updated_date'];	
				if($productInfo[0]['tax_free'] === 'No'){
				
					$order_prod['tax_free'] = $productInfo[0]['tax_free'];
					if($firmRow[0]['state_code'] === $data_order['state_code']){
						$order_prod['sgst_per'] = $productInfo[0]['sgst_per'];
						$order_prod['cgst_per'] = $productInfo[0]['cgst_per'];
						$order_prod['igst_per'] = 0.00;
					}else{
						$order_prod['sgst_per'] = 0.00;
						$order_prod['cgst_per'] = 0.00;
						$order_prod['igst_per'] = $productInfo[0]['igst_per'];
					}
				}else {
					$order_prod['tax_free'] = 'Yes';
					$order_prod['sgst_per'] = 0.00;
					$order_prod['cgst_per'] = 0.00;
					$order_prod['igst_per'] = 0.00;
				}			
				$order_prod_id = $this->updateOrderProduct($order_prod);
			}
		 }
		 
		   
	 }
	 
	 /* Delete the order product based on the id */
	 public function deleteOrderProd($id){
	 	$query = $this->db->delete('client_order_prodcts',array('id'=>$id));
		return 1;
	 }
	 
	 /* Delete the order product based on the id */
	 public function deleteAllOrderProducts($order_id){
	 	$this->db->query("DELETE FROM `client_order_prodcts` WHERE `order_id`= '".$order_id."'");
		return 1;
	 }
	 
	 /* Add order products in database */
	 public function updateOrderProduct($data_insert){
	 	$this->db->insert("client_order_prodcts", $data_insert); 
		   return $this->db->insert_id();
	 }
	 
	 /*
	 Update order into database
	 */ 
	 
	  public function getOrderProduct($id)
	 {
		 $this->db->select("COP.*");
		 $this->db->from("client_order_prodcts AS COP");
		 $this->db->where("COP.id", $id);
		 $this->db->limit(1);
		 $query_order_prod_row = $this->db->get();
			
			if($query_order_prod_row->num_rows()>0)
			{
				return $query_order_prod_row->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /* Get dispatch pending products based on order id
	    We will fetch all the products which has dispatched qty less than ordered Qty
	  */
	 
	 public function getOrderPendingProducts($order_id){
	 
	 		$this->db->select("COP.`id` , COP.`order_pid` , COP.`order_qty` , P.product_name, P.prod_unit, COP.`dispatch_qty`, COP.`order_packing`");
			$this->db->from("client_order_prodcts AS COP");
			$this->db->join("product AS P", "P.pid = COP.order_pid");
			$this->db->where("COP.order_id",$order_id);
			$this->db->where('`dispatch_qty` < `order_qty`');
			$query_order_details = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_order_details->num_rows()>0)
			{
				return $query_order_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 /* Get all the batches/lots of product which has some balanced quantity */
	 public function getProductBalancedLots($pid,$packing = 0, $firmId){
	 
	 		$this->db->select('sum( PS.inw_qty ) - sum( PS.outw_qty ) AS batchStock, PS.lot_no, PS.su_id, PBD.packing');
			$this->db->from('product_stock AS PS');
			$this->db->join('product_batch_details AS PBD', 'PBD.lot_no = PS.lot_no');
			$this->db->where("PS.pid",$pid);
			$this->db->where("PS.firm_id",$firmId);
			if($packing > 0){
				$this->db->where("PBD.packing",$packing);
			}
			$this->db->having("batchStock > ",0); 
			$this->db->group_by('PS.`lot_no`');		
			$this->db->order_by('PS.on_date ASC');
			
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
	 
	 /* get the pid by batch/lot number */
	 public function getPidByBatch($lot_no){
	 	$this->db->select('PS.pid');
		$this->db->from('product_stock AS PS');
		$this->db->where("PS.lot_no",$lot_no);
		$this->db->limit(1);
		
		$query_batch_details = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_batch_details->num_rows()>0){
			return $query_batch_details->result_array();
		}else{
			return array();
		}
	 }
	 
	 /* get the products ordered rate with pid and reference id  */
	 public function getProdSaleRateByReff($pid, $reffId){
	 	$this->db->select('COP.order_rate');
		$this->db->from('client_order_prodcts AS COP');
		$this->db->where("COP.order_pid",$pid);
		$this->db->where("COP.id",$reffId);
		$this->db->limit(1);
		
		$query_prod_rate = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_prod_rate->num_rows()>0){
			return $query_prod_rate->result_array();
		}else{
			return array();
		}
	 }
	 
	 /* get the products stock by the lot number  */
	 public function getStockByBatch($lot_no){
	 	$this->db->select('sum( `inw_qty` ) - sum( `outw_qty` ) AS instock');
		$this->db->from('product_stock');
		$this->db->where("lot_no",$lot_no);		
		$query_prod_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_prod_stock->num_rows()>0){
			return $query_prod_stock->result_array();
		}else{
			return array();
		}
	 }
	 
	 /*
	   This function creates the final challan based on the data.
	 */
	 public function createChallan($data_order,$order_challan_shipping){
	 	if(sizeof($data_order) > 0){
		    // get the challan number
			$firmRow = $this->getFirmRow($order_challan_shipping['firm_id'], 'current_challan');
			$challan_number = $firmRow[0]['firm_code'].'/'.$firmRow[0]['current_year'].'/DC/'.$firmRow[0]['current_challan'];
			// get the Invoiice  number
			$firmInvoiceRow = $this->getFirmRow($order_challan_shipping['firm_id'], 'current_invoice');
			$invoice_number = $firmInvoiceRow[0]['firm_code'].'/'.$firmInvoiceRow[0]['current_year'].'/IN/'.$firmInvoiceRow[0]['current_invoice'];
			// update the order id field in firm table			
			$data_firm['current_challan'] = $firmRow[0]['current_challan'];
			$data_firm['current_invoice'] = $firmInvoiceRow[0]['current_invoice'];
			$this->db->where("firm_id", $order_challan_shipping['firm_id']);
			$this->db->update("company_firms", $data_firm); 
		  	// add notification
				$notificationArray = array();
				$today = date("Y-m-d");
				$notificationArray['uid'] = $order_challan_shipping['order_by'];
				$notificationArray['message_text'] = 'Take follow up of invoice # '.$invoice_number;
				$notificationArray['added_on'] = $today;
				$notificationArray['reminder_date'] = date('Y-m-d',strtotime($today."+ 8 days"));
				$notificationArray['read_flag'] = 'Pending';
				$this->add_notification($notificationArray);
				$ntf_id = $this->db->insert_id();
			
				  
			foreach($data_order as $orderData){
			   // echo '<pre>'; print_r($orderData['insert_stock']);
			    // insert into order_challan table
				foreach($orderData['order_challan'] as $order_challan){
					$order_challan['challan_no'] = $challan_number; 
					$order_challan['invoice_no'] = $invoice_number; 
					$order_challan['invoice_date'] = $today; 
					$order_challan['invoice_by'] = $this->session->userdata('userid'); 
					$order_challan['notification_id'] = $ntf_id ;
					$this->db->insert("order_challan", $order_challan); 
		   			//return $this->db->insert_id();
					
				}				
					
				// update the dispatch quantity for the order
				$this->db->set('dispatch_qty', 'dispatch_qty+'.$orderData['insert_stock']['outw_qty'], FALSE);
				$this->db->where("order_id", $orderData['insert_stock']['order_id']); 
				$this->db->where("order_pid", $orderData['insert_stock']['pid']); 
				$this->db->where("id", $orderData['insert_stock']['id']); 
				$this->db->update("client_order_prodcts"); 
				$this->db->limit(1);
				
				// insert into product_stock table	
				unset($orderData['insert_stock']['id']); // because in table id is primary key			
				$orderData['insert_stock']['challan_no'] = $challan_number; 
				$orderData['insert_stock']['invoice_no'] = $invoice_number; 
				$orderData['insert_stock']['firm_id'] = $order_challan_shipping['firm_id']; 
				$this->db->insert("product_stock", $orderData['insert_stock']); 
				//return $this->db->insert_id();
			
			//  check for order status
			//$orderStatus = mysql_query('SELECT (order_qty - `dispatch_qty` ) AS balQty FROM `client_order_prodcts` WHERE `order_id`="'.$orderNum.'" HAVING balQty > 0');
			$this->db->select('sum( `order_qty` ) - sum( `dispatch_qty` ) AS balQty');
			$this->db->from('client_order_prodcts');
			$this->db->where("order_id",$orderData['insert_stock']['order_id']);	
			$this->db->having("balQty > ",'0'); 	
			$query_pending_prods = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_pending_prods->num_rows() == 0){
				$order_status['order_status'] = 'Completed';
				$this->db->where("order_id", $orderData['insert_stock']['order_id']);
				$this->db->update("client_orders", $order_status);
			}
			
			
		}
		// update shipping address and logistic remark
		$update_order_remark['challan_no'] = $challan_number; 
		$update_order_remark['shipping_address'] = $order_challan_shipping['shipping_address']; 
		$update_order_remark['logistic_remark'] = $order_challan_shipping['logistic_remark']; 
		$this->db->insert("order_challan_shipping", $update_order_remark);
			
			
		return $challan_number;
		
		}else{ // EO sizeof($data_order)
		  return 'False';
		}
		
	 }
	 
		
	/* Get challan details based on the challan number */
	 public function getChallanDetails($challan_number, $order_id){
	 
	 		$this->db->select("OC.`challan_no`, OC.`chalan_date`,OC.`invoice_no`, OC.`invoice_date`, OC.`notification_id`, NF.`reminder_date` , CO.shipping_address,CO.order_type, C.comp_name, C.vat_no, C.cst_no, CF.firm_name, CF.vat_num, CF.excise_num, CF.cst_num, CO.po_ref, CO.po_date, CO.order_id, CO.`invoice_firm`");
			$this->db->from("order_challan AS OC, client_orders CO, company_firms CF, clients C");
			$this->db->join('notifications AS NF', 'NF.id = OC.notification_id', 'left');
			$this->db->where("CO.order_id",$order_id);
			$this->db->where("OC.`challan_no`",$challan_number);
			$this->db->where("CF.firm_id = CO.`invoice_firm`");
			$this->db->where("C.comp_id = CO.`comp_id`");
			$this->db->limit(1); 
			$query_challan_details = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_challan_details->num_rows()>0)
			{
				return $query_challan_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 // get challan shipping details
	 public function getChallanShippingDetails($challan_number){
	 
	 		$this->db->select("*");
			$this->db->from("order_challan_shipping");
			$this->db->where("`challan_no`",$challan_number);
			$this->db->limit(1); 
			$query_challan_details = $this->db->get();
			
			if($query_challan_details->num_rows()>0)
			{
				return $query_challan_details->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	 
	 // get challan product details
	 public function getChallanProducts($challan_number, $order_id){
	 
	 		$this->db->select("OC.`order_pid` , OC.`no_bags`, OC.`qty_per_bag` ,OC.`lot_no` , P.product_name, P.prod_unit, P.item_code, OC.`packing_units`, COP.prod_ref_name, COP.order_rate, COP.notes, OC.id, OC.`sample_remark`");
			$this->db->from("order_challan OC, product P, `client_order_prodcts` COP");
			$this->db->where("OC.`challan_no`",$challan_number);
			$this->db->where("OC.`order_pid` = P.pid");
			$this->db->where("COP.order_id", $order_id);
			$this->db->where("OC.`order_pid` = COP.order_pid");
			$this->db->group_by('OC.`qty_per_bag` , OC.`no_bags`, OC.`order_pid`');	
			$this->db->order_by('OC.`order_pid` DESC');	
			
			$query_challan_products = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_challan_products->num_rows()>0)
			{
				return $query_challan_products->result_array();
			}
			else
			{
				return array();
			}
	 
	 }
	 
	  /*
	   This function to update lr_no and Transport.
	 */
	 public function updateChallan($data_update_challan,$challan_no){ // , $data_notification
	 	if(sizeof($data_update_challan) > 0 && trim($challan_no) != ''){
			// update lr_no and Transport			
			$this->db->where("challan_no", $challan_no);
			$this->db->update("order_challan_shipping", $data_update_challan);
			$this->db->limit(1);
			
			// update the notification table				
			/*$notification['reminder_date'] = $data_notification['reminder_date'];
			$notification['read_flag'] = 'Pending';			 	
			$this->db->where("id", $data_notification['notification_id']);
			$this->db->update("notifications", $notification);
			$this->db->limit(1);*/
			
			
				
			return $challan_no;
			
		}
	 }
	 
	  /*
	 Add Sample order into database
	 */ 
	 
	  public function addSample($data_order,$data_order_prod)
	 {
	     $firmRow = $this->getFirmRow($data_order['invoice_firm'], 'sample_id');
		 $data_order['order_number'] = $firmRow[0]['firm_code'].'/'.$firmRow[0]['current_year'].'/'.$firmRow[0]['sample_id'];
		 $data_order['order_category'] = $firmRow[0]['firm_code'];
		 $this->db->insert("client_orders", $data_order); 
		 $orderId =  $this->db->insert_id();
		 // update the order id field in firm table
		  $data_firm['sample_id'] = $firmRow[0]['sample_id'];
		  $this->db->where("firm_id", $data_order['invoice_firm']);
		  $this->db->update("company_firms", $data_firm); 
		 // insert the order products
		 $totalRows = sizeof($data_order_prod['pid']);
		 for($i=0; $i < $totalRows; $i++){
		 	if($data_order_prod['pid'][$i] != ''  && $data_order_prod['order_qty'][$i] != ''){
				$order_prod = array();
				$order_prod['order_id'] = $orderId;
				$order_prod['order_pid'] = $data_order_prod['pid'][$i];
				$order_prod['prod_ref_name'] = $data_order_prod['prod_ref_name'][$i];
				$order_prod['order_rate'] = 0.00;
				$order_prod['order_qty'] = $data_order_prod['order_qty'][$i];
				$order_prod['order_packing'] = $data_order_prod['packing'][$i];
				$order_prod['notes'] = $data_order_prod['notes'][$i];
				$order_prod['updated_by'] = $data_order_prod['updated_by'];
				$order_prod['updated_date'] = $data_order_prod['updated_date'];
				
				$order_prod_id = $this->updateOrderProduct($order_prod);
			}
		 }
		 
		   
	 }
	 
	 /*
	   This function creates the final challan for sample order based on the data.
	 */
	 public function createSampleChallan($data_order,$order_challan_shipping){
	 	if(sizeof($data_order) > 0){
		    // get the challan number
			$firmRow = $this->getFirmRow($order_challan_shipping['firm_id'], 'sample_challan');
			$challan_number = $firmRow[0]['firm_code'].'/'.$firmRow[0]['current_year'].'/SMP/'.$firmRow[0]['sample_challan'];
			
			// update the order id field in firm table			
			$data_firm['sample_challan'] = $firmRow[0]['sample_challan'];
			$this->db->where("firm_id", $order_challan_shipping['firm_id']);
			$this->db->update("company_firms", $data_firm); 
			
			// add notification
			$notificationArray = array();
			$today = date("Y-m-d");
			$notificationArray['uid'] = $this->session->userdata('userid');
			$notificationArray['message_text'] = 'Check the sample result with client for sample order # '.$challan_number;
			$notificationArray['added_on'] = $today;
			$notificationArray['reminder_date'] = date('Y-m-d',strtotime($today."+ 8 days"));
			$notificationArray['read_flag'] = 'Pending';
		  	$this->add_notification($notificationArray);
			$ntf_id = $this->db->insert_id(); 	
			  
			foreach($data_order as $orderData){
			   // echo '<pre>'; print_r($orderData['insert_stock']);
			    // insert into order_challan table
				foreach($orderData['order_challan'] as $order_challan){
					$order_challan['challan_no'] = $challan_number; 
					$order_challan['notification_id'] = $ntf_id ;
					$this->db->insert("order_challan", $order_challan); 
		   			//return $this->db->insert_id();
					
				}				
					
				// update the dispatch quantity for the order
				$this->db->set('dispatch_qty', 'dispatch_qty+'.$orderData['insert_stock']['outw_qty'], FALSE);
				$this->db->where("order_id", $orderData['insert_stock']['order_id']); 
				$this->db->where("order_pid", $orderData['insert_stock']['pid']); 
				$this->db->where("id", $orderData['insert_stock']['id']); 
				$this->db->update("client_order_prodcts"); 
				$this->db->limit(1);
				
				// insert into product_stock table	
				unset($orderData['insert_stock']['id']); // because in table id is primary key			
				$orderData['insert_stock']['challan_no'] = $challan_number; 
				
				$this->db->insert("product_stock", $orderData['insert_stock']); 
				//return $this->db->insert_id();
			}	
				
			//  check for order status
			//$orderStatus = mysql_query('SELECT (order_qty - `dispatch_qty` ) AS balQty FROM `client_order_prodcts` WHERE `order_id`="'.$orderNum.'" HAVING balQty > 0');
			$this->db->select('sum( `order_qty` ) - sum( `dispatch_qty` ) AS balQty');
			$this->db->from('client_order_prodcts');
			$this->db->where("order_id",$orderData['insert_stock']['order_id']);	
			$this->db->having("balQty > ",'0'); 	
			$query_pending_prods = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_pending_prods->num_rows() == 0){
				$order_status['order_status'] = 'Completed';
				$this->db->where("order_id", $orderData['insert_stock']['order_id']);
				$this->db->update("client_orders", $order_status);
			}
			
			// update shipping address and logistic remark
			$update_order_remark['challan_no'] = $challan_number; 
			$update_order_remark['shipping_address'] = $order_challan_shipping['shipping_address']; 
			$update_order_remark['logistic_remark'] = $order_challan_shipping['logistic_remark']; 
			$this->db->insert("order_challan_shipping", $update_order_remark); 
			
			return $challan_number;
			
		}
	 }
	 
	 /* 
	 Add Notification message to notification table 
	 Parameter: an array of elements 
	 */ 
	 public function add_notification($notificationData){
	 	if(sizeof($notificationData) > 0){
			$this->db->insert("notifications", $notificationData); 
			return 1;
		}else {
			return 0;
		}
	 }
	 
	 /* Get the list of all active transports*/
	 public function getTransportsList(){
	 	    $this->db->select("T.transport_name");
			$this->db->from("transports AS T");	
			$this->db->where("T.status","Active");			
			$this->db->order_by('T.transport_name DESC');
			$query_transport = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_transport->num_rows()>0)
			{
				return $query_transport->result_array();
			}
			else
			{
				return array();
			}
	 } 
	 
	 /* Update the feedback of sample products */
    
	 public function updateFeedback($feedbackArray, $rowidArray){
	 	    if(sizeof($feedbackArray) > 0 ){
			  $cnt = sizeof($feedbackArray);
			  for($i=0; $i< $cnt; $i++){
			  		$remark['sample_remark'] = $feedbackArray[$i];
					$this->db->where("id", $rowidArray[$i]);
					$this->db->update("order_challan", $remark);
					$this->db->limit(1);
			  }
			  $result = 1;
			}else{
				$result = 0;
			}
			return $result;
	 }
	 
	 /* Update the invoice payment, discount and fwd charges */
    
	 public function updateInvoicePayments($invoiceArray,$order_id,$insertPayment){
	 	    if(sizeof($invoiceArray) > 0 ){
			  	
				// get the all order products and add record in product stock table
				$orderProductsList = $this->getOrderProducts($order_id);
				if(sizeof($orderProductsList) > 0){
					foreach($orderProductsList as $orderProduct){
						$prodStkArray = array();
						$prodStkArray['comp_id'] = $insertPayment['client_id'];
						$prodStkArray['pid'] = $orderProduct['order_pid'];
						$prodStkArray['invoice_no'] = $insertPayment['invoice_number'];
						$prodStkArray['order_id'] = $order_id;
						$prodStkArray['outw_qty'] = $orderProduct['order_qty'];
						$prodStkArray['rate'] = $orderProduct['order_rate'];
						$prodStkArray['amount'] = $orderProduct['order_rate']*$orderProduct['order_qty'];
						$prodStkArray['on_date'] = date('Y-m-d');
						$prodStkArray['firm_id'] = $insertPayment['firm_id'];
						$this->db->insert("product_stock", $prodStkArray); 
						//echo $this->db->last_query();die;
					}
					
				}
				
				// update discount and frignt
				$this->db->where("order_id",$order_id );
				$this->db->update("client_orders", $invoiceArray);
			    $this->db->limit(1);
				
			    // insert record into invoice_payment table				
			    $this->db->insert("invoice_payments", $insertPayment); 
				$payment_ref_id = $this->db->insert_id();
								
				// insert record into payments table
				$paymentArray = array();
				$paymentArray['payment_ref_id'] = $insertPayment['client_id']; //$payment_ref_id;
				$paymentArray['payment_ref_type'] = 1; // This is sales order
				$paymentArray['debit_amount'] = $insertPayment['invoice_amount'];
				$paymentArray['firm_id'] = $insertPayment['firm_id'];
				$paymentArray['transaction_title'] = 'Payment of Invoice #'.$insertPayment['invoice_number'];
				$paymentArray['transaction_date'] = $insertPayment['updated_date'];
				$paymentArray['payment_id'] = $payment_ref_id;
				$paymentArray['updated_by'] = $this->session->userdata('userid');
				$this->db->insert("payment_details", $paymentArray); 
			    // add notification if remider date is not blank
				if($insertPayment['reminder_date'] != '0000-00-00' && $insertPayment['reminder_date'] !=''){
					// get the company name
					$this->db->select("c.*");
					$this->db->from("clients AS c");
					$this->db->where("c.comp_id",$insertPayment['client_id']);
					$this->db->limit(1);
					$query_client = $this->db->get();
					$client_info = $query_client->result_array();
					
					$notificationArray = array();
					$today = date("Y-m-d");
					$notificationArray['uid'] = $insertPayment['order_by'];
					$notificationArray['message_text'] = 'Your payment is due on '.$insertPayment['reminder_date'].' for invoice # '.$insertPayment['invoice_number'].' from '. $client_info[0]['comp_name'] ;
					$notificationArray['added_on'] = $today;
					$notificationArray['reminder_date'] = $insertPayment['reminder_date'];
					$notificationArray['read_flag'] = 'Pending';
					$this->add_notification($notificationArray);
			   }
			  $result = 1;
			}else{
				$result = 0;
			}
			return $result;
	 }
	 
	 /* Update the invoice payment, discount and fwd charges */
    
	 public function updateInvoiceData($invoiceArray,$challan_no){
	 	    if(sizeof($invoiceArray) > 0 ){
			  	// update discount and frignt
				$this->db->where("challan_no",$challan_no );
				$this->db->update("order_challan_shipping", $invoiceArray);
			    $this->db->limit(1);	
				//echo $this->db->last_query();die;	     
			    $result = 1;
			}else{
				$result = 0;
			}
			return $result;
	 }
	 
	 /*
	 Get all pending confirmation invoices for account and admin	
	 
	 */
	 public function getPendingInvoices(){
	 	    $this->db->select("OSC.*, OC.invoice_no, OC.order_id, CO.order_number");
			$this->db->from("order_challan_shipping AS OSC");
			$this->db->join('order_challan AS OC', 'OC.challan_no = OSC.challan_no');	
			$this->db->join('client_orders AS CO', 'CO.order_id = OC.order_id');	
			$this->db->where("OSC.account_confirmed","0");
			$this->db->where("OC.invoice_no <>","0");
			$this->db->group_by('OC.challan_no');			
			$this->db->order_by('OSC.id DESC');
			$query_pending_invoices = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_pending_invoices->num_rows()>0)
			{
				return $query_pending_invoices->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /*
	 Get all  invoices for account and admin	
	 
	 */
	 public function getAllInvoices($stardate,$enddate,$firm_id){
	 	    $this->db->select("OSC.*, OC.invoice_no, OC.order_id, CO.order_number, C.comp_name, U.first_name, U.last_name");
			$this->db->from("order_challan_shipping AS OSC");
			$this->db->join('order_challan AS OC', 'OC.challan_no = OSC.challan_no');	
			$this->db->join('client_orders AS CO', 'CO.order_id = OC.order_id');
			$this->db->join('clients AS C', 'CO.comp_id = C.comp_id');
			$this->db->join('users AS U', 'CO.uid = U.uid');
			$this->db->where("CO.order_type ",'Order');
			if($firm_id > 0){
				$this->db->where("CO.invoice_firm ",$firm_id);
			}
			if($enddate != '' && $stardate !=''){
				$this->db->where("OC.chalan_date >=",$stardate);  
				$this->db->where("OC.chalan_date <=",$enddate);
			}
			
			//$this->db->where("OC.invoice_no <>","0");
			$this->db->group_by('OC.challan_no');			
			$this->db->order_by('OSC.account_confirmed ASC');
			$query_all_invoices = $this->db->get();
			/// echo $this->db->last_query();die;
			if($query_all_invoices->num_rows()>0)
			{
				return $query_all_invoices->result_array();
			}
			else
			{
				return array();
			}
	 }
   
   /*
	 get the firm details based on firm Id
	 
	 */
	 public function getFirmDetails($firmId){
	 	    $this->db->select("CF.*");
			$this->db->from("company_firms AS CF");			
			$this->db->where("CF.firm_id", $firmId);
			$this->db->limit(1);			
			
			$query_firm_details = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_firm_details->num_rows()>0)
			{
				return $query_firm_details->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 
	 /*
	 get the firm details based on firm Id
	 
	 */
	 public function getFirmBankDetails($firmId){
	 	    $this->db->select("CFB.*");
			$this->db->from("company_firm_banks AS CFB");			
			$this->db->where("CFB.firm_id", $firmId);
			$this->db->where("CFB.status", 'Active');
			$this->db->limit(1);			
			
			$query_firm_details = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_firm_details->num_rows()>0)
			{
				return $query_firm_details->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 /* Get gst state id list  */
	function gst_state_codes_list(){
		$this->db->select("GSC.*");
		$this->db->from("gst_state_codes AS GSC"); 		
		$query_state_list = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_state_list->num_rows()>0)
		{
			return $query_state_list->result_array();
		}
		else
		{
			return array();
		}
	}
	
}
?>