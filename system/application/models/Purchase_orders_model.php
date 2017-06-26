<?php 
class Purchase_orders_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getAllPurchaseOrders($stardate='',$enddate='', $firm_id = 0){
	
		   // purchase_enquires
		    $this->db->select('PO.*, S.supl_comp, S.supl_phone, S.supl_mobile, U.first_name, U.last_name, F.firm_name ');
			$this->db->from('purchase_orders AS PO');
			$this->db->join('users AS U','U.uid = PO.order_by');
			$this->db->join('suppliers AS S','S.supl_id = PO.supplier_id');			
			$this->db->join('company_firms AS F','F.firm_id = PO.firm_id');			
			if($this->session->userdata('userrole') == 'Purchase'){
				//$this->db->where("PO.order_by",$this->session->userdata('userid'));
			}
			
			if($firm_id > 0){
				$this->db->where("PO.firm_id ",$firm_id);
			}
			if($enddate != '' && $stardate !=''){
				$this->db->where("PO.order_date >=",$stardate);  
				$this->db->where("PO.order_date <=",$enddate);
			}
			
			$this->db->order_by('PO.status ASC');
			$this->db->order_by('PO.order_date DESC');
			$query_products_enquiries = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_products_enquiries->num_rows()>0)
			{
				return $query_products_enquiries->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* Create Purchase order based on enquiry, Complete the enquiry after order is created */
	public function createPurchaseOrder($data_pourc_order, $purchased_products){
		$return = -1;
		if(sizeof($data_pourc_order) > 0 && sizeof($purchased_products) > 0){
			// create a purchse order based on submitted array
			$this->load->model('Orders_model', 'orders_model');
            $firmRow = $this->orders_model->getFirmRow($data_pourc_order['firm_id'], 'po_number');
			//echo '<pre>'; print_r($firmRow); die();
			$data_pourc_order['purc_order_number'] = $firmRow[0]['firm_code'].'/PO/'.$firmRow[0]['current_year'].'/'.$firmRow[0]['po_number'];
			
			$this->db->insert("purchase_orders", $data_pourc_order); 
			$purchaseOrderId =  $this->db->insert_id();
			
			 // update the order id field in firm table
			  $data_firm['po_number'] = $firmRow[0]['po_number'];
			  $this->db->where("firm_id", $data_pourc_order['firm_id']);
			  $this->db->update("company_firms", $data_firm); 
			  
			 // insert the order products
			// echo '<pre>'; print_r($purchased_products); die();
		     $totalRows = sizeof($purchased_products);
			 foreach($purchased_products as $purchased_product){
			 	$purchased_product['purc_order_id'] = $purchaseOrderId;
				$this->db->insert("purchase_order_products", $purchased_product);
				
			 }
			
			  
			$return = $purchaseOrderId; 
		}
		return $return;
	}
	
	/* get the purchase order details */
	public function getPurchaseOrderDetails($purchase_orderId){
		    $this->db->select("PO.*, S.supl_comp, S.supl_conperson, S.supl_email, S.supl_phone, S.supl_mobile, S.supl_address, S.pan_no, S.gstin_num,  CF.firm_name");
			$this->db->from("purchase_orders AS PO");
			$this->db->join("suppliers AS S", "S.supl_id = PO.supplier_id");
			$this->db->join("company_firms AS CF ", "CF.firm_id = PO.firm_id ");
			$this->db->where("PO.purc_order_id",$purchase_orderId);
			if($this->session->userdata('userrole') == 'Purchase'){
				$this->db->where("PO.order_by",$this->session->userdata('userid'));
			}
			$this->db->limit(1);
			$query_purchase_order_details = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_purchase_order_details->num_rows()>0)
			{
				return $query_purchase_order_details->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	/* get purchase order products based on the purchase order Id */
	public function getPurchaseOrderProducts($purchase_orderId){
			$this->db->select("POP.*, P.product_name, P.prod_unit, P.item_code, P.hsn_code");
			$this->db->from("purchase_order_products AS POP");
			$this->db->join("product AS P", "P.pid = POP.purchase_pid");
			$this->db->where("POP.purc_order_id",$purchase_orderId);
			
			$query_purchase_order_products = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_purchase_order_products->num_rows()>0)
			{
				return $query_purchase_order_products->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/*Add new product with details in purchase order */
	public function updatePurchaseOrderProduct($data_insert){
	 	$this->db->insert("purchase_order_products", $data_insert); 
		return $this->db->insert_id();
	 }
	
	 /* Delete the enquiry product based on the id */
	 public function deletePurchaseOrderProd($id){
	 	$query = $this->db->delete('purchase_order_products',array('id'=>$id));
		return 1;
	 }
	 
	 /*
	 Update order into database
	 */ 
	 
	  public function updateOrder($data_update,$purc_order_id)
	 {
		 
		 $this->db->where("purc_order_id", $purc_order_id);
		 $this->db->where("status", 'Open');
		 if($this->session->userdata('userrole') == 'Purchase' ){
			$this->db->where("order_by",$this->session->userdata('userid'));
		 }
		 $this->db->update("purchase_orders", $data_update); 
		 //echo $this->db->last_query();die;
		 $this->db->limit(1);
		 return $purc_order_id;
	 }
	 
	 /*
	 Close the purchase order if order status is Pending 
	 */
	 
	  public function closePurchaseOrder($purc_order_id)
	 {
	 	 $data_close['status'] = 'Closed';
		 $this->db->where("purc_order_id", $purc_order_id);
		// $this->db->where("status", 'Open');
		 if($this->session->userdata('userrole') == 'Purchase'){
			$this->db->where("order_by",$this->session->userdata('userid'));
		 } 
		 $this->db->limit(1);
		 $query_close_purc_order =  $this->db->update("purchase_orders", $data_close); 
		 //echo $this->db->last_query();die;
		
		 if( $this->db->affected_rows() >0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
			
	}
	
	/* Update the invoice payment, discount and fwd charges */
    
	 public function updatePurchaseOrderData($invoiceArray,$purc_order_id, $notificationArray ){
	 	    if(sizeof($invoiceArray) > 0 ){
			  	// update discount and frignt
				$this->db->where("purc_order_id",$purc_order_id );
				$this->db->update("purchase_orders", $invoiceArray);
			    $this->db->limit(1);
				// add notification
				if(sizeof($notificationArray) > 0){
					$this->load->model('Orders_model', 'orders_model');           		
					$notificationDataArray = array();
					$today = date("Y-m-d");
					$notificationDataArray['uid'] = $this->session->userdata('userid');
					$notificationDataArray['message_text'] = 'Take follow-up of PO # '.$notificationArray['purchase_order_number'].' for receiving material.';
					$notificationDataArray['added_on'] = $today;
					$notificationDataArray['reminder_date'] = $notificationArray['expected_delivery'];
					$notificationDataArray['read_flag'] = 'Pending';
					$this->orders_model->add_notification($notificationDataArray);
				}
						     
			  $result = 1;
			}else{
				$result = 0;
			}
			return $result;
	 }
	 
	 /* get all POs pending for account confirmation */
	 public function getAccountPendingPOs(){
	 	    $this->db->select("PO.*, S.supl_comp, S.supl_conperson, S.supl_email, S.supl_phone, S.supl_mobile, S.supl_address, S.pan_no,  CF.firm_name");
			$this->db->from("purchase_orders AS PO");
			$this->db->join("suppliers AS S", "S.supl_id = PO.supplier_id");
			$this->db->join("company_firms AS CF ", "CF.firm_id = PO.firm_id ");
			$this->db->where("PO.status", 'Confirmed');
			$this->db->where("PO.account_confirmed", '0');
			
			$query_pending_purchase_orders = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_pending_purchase_orders->num_rows()>0)
			{
				return $query_pending_purchase_orders->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	/* Get all inword challans (PRN/DCI) based on the purchase order */
	public function getAllInwordChallans($purc_order_id){
			$this->db->select("PCL.material_inward_no");
			$this->db->from("purchase_confirm_list AS PCL");
			$this->db->where("PCL.purc_order_id", $purc_order_id );	
			//$this->db->where("PCL.qc_status <>", "Pending" );	
			$this->db->group_by('PCL.material_inward_no');
			$query_inword_challan = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_inword_challan->num_rows()>0)
			{
				return $query_inword_challan->result_array();
			}
			else
			{
				return array();
			}
	}
	 
	 /* Get all inword invoices based on the purchase order */
	public function getAllInwordInvoices($purc_order_id){
			$this->db->select("PBD.material_inward_no");
			$this->db->from("product_batch_details AS PBD");
			$this->db->where("PBD.purc_order_id", $purc_order_id);
			
			$query_inword_invoices = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_inword_invoices->num_rows()>0)
			{
				return $query_inword_invoices->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	/* Get all pending purchase products from a purchase order id */
	public function getPurchaseOrderPendingProducts($purchase_orderId){
			$this->db->select("POP.*, P.product_name, P.prod_unit, P.item_code");
			$this->db->from("purchase_order_products AS POP");
			$this->db->join("product AS P", "P.pid = POP.purchase_pid");
			$this->db->join("purchase_orders AS PO", "PO.purc_order_id = POP.purc_order_id");
			$this->db->where("POP.purc_order_id",$purchase_orderId);
			$this->db->where("POP.total_inword < POP.purchase_qty ");
			$this->db->where("PO.status NOT IN ('Completed','Closed') ");			
			$query_pending_products = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_pending_products->num_rows()>0)
			{
				return $query_pending_products->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* Create PRN */
	public function createPRN($data_confirm, $purc_order_number, $po_firm_id){
	   // echo '<pre>'; print_r($data_confirm); echo $purc_order_number; die();
		if(sizeof($data_confirm) > 0){
		    // get the inwordnumber(DCI) for the inword products.
			$this->load->model('product_model', 'product_model');
			$resultDCIArray = $this->product_model->getInwardNumber($po_firm_id);			 
			foreach($data_confirm as $confirmRow){
				$confirmRow['material_inward_no'] = $resultDCIArray['material_inward_no'];
				$this->db->insert("purchase_confirm_list", $confirmRow); 
			}
			
			$this->load->model('Orders_model', 'orders_model');           		
			$notificationDataArray = array();
			$today = date("Y-m-d");
			$notificationDataArray['uid'] = 1;
			$notificationDataArray['message_text'] = 'Material recived for purchase order number '.$purc_order_number;
			$notificationDataArray['added_on'] = $today;
			$notificationDataArray['reminder_date'] = $today;
			$notificationDataArray['read_flag'] = 'Pending';
			$this->orders_model->add_notification($notificationDataArray);
			
			return 'True';
		}else{
			return 'False';
		}
	}
	
	// get pending/confirmed quantity for the PO
	public function getConfirmedPendingProducts($purc_order_id, $pid, $prod_ref_id){
		$this->db->select("SUM(PCL.total_qty) as total_qty");
		$this->db->from("purchase_confirm_list AS PCL");
		$this->db->where("PCL.prod_ref_id",$prod_ref_id);
		$this->db->where("PCL.purc_order_id",$purc_order_id);
		$this->db->where("PCL.order_pid ", $pid);
		$this->db->where("PCL.qc_status <> 'Rejected' ");			
		$query_all_prod_qty = $this->db->get();
		
		//echo $this->db->last_query();die;
		if($query_all_prod_qty->num_rows()>0)
		{
			return $query_all_prod_qty->result_array();
		}
		else
		{
			return array();
		}
	}
	
	/*Get all inwords entries for QC */
	
	public function getAllInwords($stardate='',$enddate='', $firm_id = 0){
	
		    $this->db->select('PCL.*, P.product_name, P.prod_unit, PO.purc_order_number');
			$this->db->from('purchase_confirm_list AS PCL');
			$this->db->join("product AS P", "P.pid = PCL.order_pid");
			$this->db->join("purchase_orders AS PO", "PO.purc_order_id = PCL.purc_order_id");					
			if($enddate != '' && $stardate !=''){
				$this->db->where("PCL.inword_date >=",$stardate);  
				$this->db->where("PCL.inword_date <=",$enddate);
			}
			
			$this->db->order_by('PCL.qc_status ASC');
			$this->db->order_by('PCL.inword_date DESC');
			$query_products_inwords = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_products_inwords->num_rows()>0)
			{
				return $query_products_inwords->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* get the inward Product details base */
	public function getInwordProductInfo($qc_id){
			$this->db->select('PCL.*, P.product_name, P.prod_unit, PO.purc_order_number, PO.supplier_id, PO.firm_id, PO.transport_name, POP.purchase_rate, POP.purchase_qty, POP.packing_size, POP.packing, POP.notes, PO.order_by, PO.payment_reminder');
			$this->db->from('purchase_confirm_list AS PCL');
			$this->db->join("product AS P", "P.pid = PCL.order_pid");
			$this->db->join("purchase_orders AS PO", "PO.purc_order_id = PCL.purc_order_id");
			$this->db->join("purchase_order_products AS POP", "POP.id = PCL.prod_ref_id");	
			$this->db->where('PCL.qc_id',$qc_id);
			$this->db->limit(1);
			$query_products_inwords_info = $this->db->get();
			//echo $this->db->last_query();die; // 
			if($query_products_inwords_info->num_rows()>0)
			{
				return $query_products_inwords_info->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	/* Update the product row after QC confirmation */
	public function updateConfirmedInward($data_confirm, $data_update_po, $qc_id, $purc_order_id){
		 $this->db->where("qc_id", $qc_id);
		 $this->db->where("qc_status", 'Pending');
		 $this->db->update("purchase_confirm_list", $data_confirm); 
		 $this->db->limit(1);
		 $affectedRows = $this->db->affected_rows();
		 if($affectedRows > 0 ){
				if($data_confirm['qc_status'] == 'Confirmed'){
					// update the total inward in purchase order products for the PO with pid
					$this->db->set('total_inword', 'total_inword+'.$data_update_po['total_inword_qty'], FALSE);
					$this->db->where("id", $data_update_po['prod_ref_id']); 
					$this->db->update("purchase_order_products"); 
					$this->db->limit(1);
					// check for the PO is completed or not. If completed update status to "Completed"
					// SELECT (`purchase_qty` - `total_inword`) AS balance FROM `purchase_order_products` WHERE `purc_order_id` =9 GROUP BY `purchase_pid` HAVING balance >0
					$this->db->select('(`purchase_qty` - `total_inword`) AS balance');
					$this->db->from('purchase_order_products');
					$this->db->where("purc_order_id", $purc_order_id);
					$this->db->group_by('purchase_pid');
					$this->db->having('balance > "0" ');
					$query_products_pending = $this->db->get();
					if($query_products_pending->num_rows() == 0){
						$order_status['status'] = 'Completed';
						$this->db->where("purc_order_id", $purc_order_id);
						$this->db->update("purchase_orders", $order_status);
						$this->db->limit(1);
					}
					
					
					// notify to store person
					$this->load->model('Orders_model', 'orders_model');           		
					$notificationDataArray = array();
					$today = date("Y-m-d");
					$notificationDataArray['uid'] = $data_update_po['notify_to'];
					$notificationDataArray['message_text'] = 'A product is confirmed by QC Dept. for the order '.$data_update_po['purc_order_number'].'. The lot # is '.$data_confirm['lot_no'];
					$notificationDataArray['added_on'] = $today;
					$notificationDataArray['reminder_date'] = $today;
					$notificationDataArray['read_flag'] = 'Pending';
					$this->orders_model->add_notification($notificationDataArray);
					
				}else if($data_confirm['qc_status'] == 'Rejected'){
					// notify to store person
					$this->load->model('Orders_model', 'orders_model');           		
					$notificationDataArray = array();
					$today = date("Y-m-d");
					$notificationDataArray['uid'] = $data_update_po['notify_to'];
					$notificationDataArray['message_text'] = 'A product is Rejected by QC Dept. for the order #'.$data_update_po['purc_order_number'];
					$notificationDataArray['added_on'] = $today;
					$notificationDataArray['reminder_date'] = $today;
					$notificationDataArray['read_flag'] = 'Pending';
					$this->orders_model->add_notification($notificationDataArray);
					
				}
				
		 	return 1;
			
		 }else {
		 	return 0;
		 }
	}
	
	/* Get the products which are below min quantity */
	public function getThresholdProducts(){
		
		$this->db->select('(SUM(inw_qty) - SUM(outw_qty)) AS prod_stock, P.product_name, P.pid, P.min_qty');
		$this->db->from('product_stock AS PS');
		$this->db->join("product AS P", "P.pid = PS.pid");
		$this->db->group_by('PS.pid');
		$this->db->having('prod_stock < P.`min_qty`');
		$query_products_outof_stock = $this->db->get();
		//echo $this->db->last_query();die;
		if($query_products_outof_stock->num_rows()>0)
		{
			return $query_products_outof_stock->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	
	/* Get pending payments for purchase orders */
	public function getPaindingPurchasePayments(){
		
		$this->db->select('PP.*, PO.purc_order_number, S.supl_comp');
		$this->db->from('purchase_order_payments AS PP');
		$this->db->join("purchase_orders AS PO", "PP.purc_order_id = PO.purc_order_id");
		$this->db->join("suppliers AS S", "S.supl_id = PP.supplier_id");
		$this->db->where("PP.status", 'Pending');
		$this->db->order_by('PP.reminder_date');
		$query_pending_payments = $this->db->get();
		// echo $this->db->last_query();die;
		if($query_pending_payments->num_rows()>0)
		{
			return $query_pending_payments->result_array();
		}
		else
		{
			return array();
		}
		
	}
	
	/* Get the order details like subamount, Tax%, FWD, Discount and otherAdjustment amount, */
	
	public function orderFinalAmountElements($purc_order_id){
		$this->db->select('SUM((POP.`purchase_qty`) * (POP.`purchase_rate`)) AS subTotal, PO.tax_per, PO.excise, PO.forwardingAmt, PO.otherAdjustment, PO.discountAmt');
		$this->db->from('purchase_order_products AS POP');
		$this->db->join("purchase_orders AS PO", "POP.purc_order_id = PO.purc_order_id");
		$this->db->where("POP.`purc_order_id` ", $purc_order_id);
		
		$query_final_order_payments = $this->db->get();
		// echo $this->db->last_query();die;
		if($query_final_order_payments->num_rows()>0)
		{
			return $query_final_order_payments->result_array();
		}
		else
		{
			return array();
		}
	}
	
	
	/* Get all inward products based on DCI and purchase order */
	public function getInwardChallanDetails($material_inward_no, $purchase_orderId){
			$this->db->select("PCL.*, P.product_name, P.prod_unit, P.item_code");
			$this->db->from("purchase_confirm_list AS PCL");
			$this->db->join("product AS P", "P.pid = PCL.order_pid");
			$this->db->join("purchase_orders AS PO", "PO.purc_order_id = PCL.purc_order_id");
			$this->db->where("PCL.material_inward_no",$material_inward_no);	
			$this->db->where("PCL.purc_order_id",$purchase_orderId);		
			$query_pending_products = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_pending_products->num_rows()>0)
			{
				return $query_pending_products->result_array();
			}
			else
			{
				return array();
			}
	}
}
?>