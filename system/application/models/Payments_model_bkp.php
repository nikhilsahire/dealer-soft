<?php 
class Payments_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	/* Get the list of all bank accounts */
	public function getBanklist(){
		$this->db->select('CFB.*');
		$this->db->from('company_firm_banks CFB');
		$this->db->where("CFB.status",'Active');
		$query_firm_banks = $this->db->get();		
		//echo $this->db->last_query();die;
		if($query_firm_banks->num_rows()>0)
		{
			return $query_firm_banks->result_array();
		}
		else
		{
			return array();
		}
	}
	/* function to get sum of credit and debit payment sum based on client id*/
	public function getClientFinalAmount($client_id, $stardate='',$enddate='', $firm_id = 0){
		// SELECT SUM( `invoice_amount` ) AS `invoice_amount` , SUM( `paid_amount` ) AS `paid_amount` FROM `invoice_payments` WHERE `client_id` =741
			$this->db->select('COALESCE(SUM(debit_amount),0.00) AS `invoice_amount`, COALESCE(SUM(credit_amount),0.00) AS paid_amount');
			$this->db->from('payment_details');
			$this->db->where("payment_ref_id",$client_id);
			$this->db->where("payment_ref_type 	",1);
			if($firm_id > 0){
				$this->db->where("firm_id ",$firm_id);
			}
			
			if($enddate != '' && $stardate !=''){
				$this->db->where("transaction_date >=",$stardate);  
				$this->db->where("transaction_date <=",$enddate);
			}
			$query_final_amount = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_final_amount->num_rows()>0)
			{
				return $query_final_amount->result_array();
			}
			else
			{
				return array('invoice_amount'=>0.00, 'paid_amount'=>0.00);
			}
	}
	
	/* function to get sum of credit and debit payment sum based on supplier id*/
	public function getSupplierFinalAmount($supplier_id, $stardate='',$enddate='', $firm_id = 0){
		// SELECT SUM( `invoice_amount` ) AS `invoice_amount` , SUM( `paid_amount` ) AS `paid_amount` FROM `invoice_payments` WHERE `client_id` =741
			$this->db->select('COALESCE(SUM(debit_amount),0.00) AS `po_amount`, COALESCE(SUM(credit_amount),0.00) AS `paid_amount`');
			$this->db->from('payment_details');
			$this->db->where("payment_ref_id",$supplier_id);
			$this->db->where("payment_ref_type 	",2);
			if($firm_id > 0){
				$this->db->where("firm_id ",$firm_id);
			}
			
			if($enddate != '' && $stardate !=''){
				$this->db->where("transaction_date >=",$stardate);  
				$this->db->where("transaction_date <=",$enddate);
			}
			$query_supplier_amount = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($query_supplier_amount->num_rows()>0)
			{
				return $query_supplier_amount->result_array();
			}
			else
			{
				return array('invoice_amount'=>0.00, 'paid_amount'=>0.00);
			}
	}
	
	
	/* function to get list of all transactions for the current financial year based on client id*/
	public function getClientTransactions($client_id, $stardate='',$enddate='', $firm_id = 0){
		// SELECT SUM( `invoice_amount` ) AS `invoice_amount` , SUM( `paid_amount` ) AS `paid_amount` FROM `invoice_payments` WHERE `client_id` =741
			$this->db->select('PD.*');
			$this->db->from('payment_details PD');
			//$this->db->join('invoice_payments IP','PD.payment_ref_id = IP.payment_id');
			$this->db->where("PD.payment_ref_id",$client_id);
			$this->db->where("PD.payment_ref_type",1);
			if($firm_id > 0){
				$this->db->where("PD.firm_id ",$firm_id);
			}
			
			if($enddate != '' && $stardate !=''){
				$this->db->where("PD.transaction_date >=",$stardate);  
				$this->db->where("PD.transaction_date <=",$enddate);
			}
			
			$this->db->order_by('PD.transaction_date DESC');
			$this->db->order_by('PD.id DESC');
			
			$query_transactions = $this->db->get();
			// echo $this->db->last_query();die;
			if($query_transactions->num_rows()>0)
			{
				return $query_transactions->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* function to get list of all transactions for the current financial year based on supplier id*/
	public function getSupplierTransactions($supplier_id, $stardate='',$enddate='', $firm_id = 0){
		// SELECT SUM( `invoice_amount` ) AS `invoice_amount` , SUM( `paid_amount` ) AS `paid_amount` FROM `invoice_payments` WHERE `client_id` =741
			$this->db->select('PD.*');
			$this->db->from('payment_details PD');
			//$this->db->join('invoice_payments IP','PD.payment_ref_id = IP.payment_id');
			$this->db->where("PD.payment_ref_id",$supplier_id);
			$this->db->where("PD.payment_ref_type",2);
			if($firm_id > 0){
				$this->db->where("PD.firm_id ",$firm_id);
			}
			
			if($enddate != '' && $stardate !=''){
				$this->db->where("PD.transaction_date >=",$stardate);  
				$this->db->where("PD.transaction_date <=",$enddate);
			}
			
			$this->db->order_by('PD.transaction_date DESC');
			$this->db->order_by('PD.id DESC');
			
			$query_transactions = $this->db->get();
			// echo $this->db->last_query();die;
			if($query_transactions->num_rows()>0)
			{
				return $query_transactions->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	
	/* Get the list of all pending invoices based on client id */ 
	public function getPendingInvoieslist($client_id){
		$this->db->select('IP.*');
		$this->db->from('invoice_payments IP');
		$this->db->where("IP.client_id",$client_id);
		$this->db->where("IP.status",'Pending');
		$query_pending_invoies = $this->db->get();		
		// echo $this->db->last_query();die;
		if($query_pending_invoies->num_rows()>0)
		{
			return $query_pending_invoies->result_array();
		}
		else
		{
			return array();
		}
	}
	
	/* Get the list of all pending invoices based on client id */ 
	public function getSupplierPendingInvoieslist($supplier_id){
		$this->db->select('POP.*');
		$this->db->from('purchase_order_payments POP');
		$this->db->where("POP.supplier_id",$supplier_id);
		$this->db->where("POP.status",'Pending');
		$query_supplier_pending_invoies = $this->db->get();		
		// echo $this->db->last_query();die;
		if($query_supplier_pending_invoies->num_rows()>0)
		{
			return $query_supplier_pending_invoies->result_array();
		}
		else
		{
			return array();
		}
	}
	
	
	/*Add amount into database for the transaction */
	public function addPayment($data_bank_entry,$inv_update_amt){
		$id = 0;
		if(sizeof($data_bank_entry) > 0){
			
			// update the paid amount for the invoice
			if(sizeof($inv_update_amt) > 0){
			  foreach($inv_update_amt as $value){				
				$this->db->set('paid_amount', 'paid_amount+'.$value['paid_amt'], FALSE);				
				$this->db->where("payment_id", $value['id']); 
				$this->db->update("invoice_payments"); 
				$this->db->limit(1);
				// update status 
				$data=array('status'=>$value['status']);
				$this->db->where('payment_id', $value['id']);
				$this->db->update('invoice_payments',$data);
				$this->db->limit(1);
				
				
			  }
			}	
			// Add the payment entry in database
			$this->db->insert("payment_details", $data_bank_entry); 
		    $id = $this->db->insert_id();
					
		}
		return $id;
	}
	
	/*Add amount into database for the transaction of supplier payment*/
	public function addSupplierPayment($data_bank_entry,$inv_update_amt){
		$id = 0;
		if(sizeof($data_bank_entry) > 0){
			
			// update the paid amount for the invoice
			if(sizeof($inv_update_amt) > 0){
			  foreach($inv_update_amt as $value){				
				$this->db->set('paid_amount', 'paid_amount+'.$value['paid_amt'], FALSE);				
				$this->db->where("payment_id", $value['id']); 
				$this->db->update("purchase_order_payments"); 
				$this->db->limit(1);
				// update status 
				$data=array('status'=>$value['status']);
				$this->db->where('payment_id', $value['id']);
				$this->db->update('purchase_order_payments',$data);
				$this->db->limit(1);
				
				
			  }
			}	
			// Add the payment entry in database
			$this->db->insert("payment_details", $data_bank_entry); 
		    $id = $this->db->insert_id();
					
		}
		return $id;
	}
	
	
	/**/
	public function transaction_details($transaction_id){
		$this->db->select('PD.*');
		$this->db->from('payment_details PD');
		//$this->db->join('company_firm_banks CFB', 'PD.bank_id = CFB.bank_id');
		$this->db->where("PD.id",$transaction_id);
		$query_transaction_details = $this->db->get();		
		// echo $this->db->last_query();die;
		if($query_transaction_details->num_rows()>0)
		{
			return $query_transaction_details->result_array();
		}
		else
		{
			return array();
		}
	}
	
	public function getSalesReport($stardate='',$enddate='', $firm_id = 0){
	
		  $this->db->select('IP.*, CO.order_id, CO.order_type, CO.order_id, CO.tax_per, CO.tax_type, CO.excise, CO.discount, CO.forwardingAmt, CO.order_date, C.comp_name, C.vat_no, C.cst_no, C.gstin_num');
			$this->db->from('invoice_payments AS IP');
			$this->db->join('client_orders AS CO','CO.invoice_number = IP.invoice_number');
			$this->db->join('clients AS C','C.comp_id = CO.comp_id'); 
			$this->db->where('CO.order_status','Completed');			
			/*if($firm_id > 0){
				$this->db->where("CO.invoice_firm ",$firm_id);
			}*/			
			if($enddate != '' && $stardate !=''){
				$this->db->where("CO.order_date >=",$stardate);  
				$this->db->where("CO.order_date <=",$enddate);
			}			
			$this->db->order_by('CO.order_date DESC');
			$query_products_stock = $this->db->get();
			// echo $this->db->last_query();die; // 
			if($query_products_stock->num_rows()>0)
			{
				return $query_products_stock->result_array();
			}
			else
			{
				return array();
			}
	}
	
	/* get the invocies list based on invoice numbers */
	public function getPurchaseInvoices($stardate='',$enddate='', $firm_id = 0){
	
		  $this->db->select('PS.invoice_no, PS.su_id');
			$this->db->from('product_stock AS PS');			 
			$this->db->where('PS.su_id <>',0);	 
			$this->db->where_not_in('PS.invoice_no', array('Self', 'Self-Formulated', ''));		
			/*if($firm_id > 0){
				$this->db->where("CO.invoice_firm ",$firm_id);
			}*/			
			if($enddate != '' && $stardate !=''){
				$this->db->where("PS.`on_date` >=",$stardate);  
				$this->db->where("PS.`on_date` <=",$enddate);
			}
			$this->db->group_by('PS.invoice_no'); 
			$query_purchase_invoices = $this->db->get();
			// echo $this->db->last_query();die; // 
			if($query_purchase_invoices->num_rows()>0)
			{
				return $query_purchase_invoices->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function getInvoiceStockProdcts($invoice_no, $su_id){
	
		  $this->db->select('PS. * , S.supl_comp, S.gstin_num, PBD.tax_per, PBD.tax_type, PBD.excise');
			$this->db->from('product_stock AS PS');
			$this->db->join('product_batch_details AS PBD','PBD.lot_no = PS.lot_no'); 
			$this->db->join('suppliers AS S','S.supl_id = PS.su_id');  		
			$this->db->where("PS.invoice_no ",$invoice_no);  
			$this->db->where("PS.su_id ",$su_id); 
			$query_stock_prodcts = $this->db->get();
			// echo $this->db->last_query(); // die;
			if($query_stock_prodcts->num_rows()>0)
			{
				return $query_stock_prodcts->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	/**/
	public function getPurchaseReport($stardate='',$enddate='', $firm_id = 0){
	
		  $this->db->select('PD.*, S.supl_comp, S.vat_no, S.cst_no');
			$this->db->from('payment_details AS PD');
			$this->db->join('suppliers AS S','S.supl_id = PD.payment_ref_id'); 
			$this->db->where('PD.payment_ref_type','2');	
			$this->db->where('PD.credit_amount >',0);			
			/*if($firm_id > 0){
				$this->db->where("CO.invoice_firm ",$firm_id);
			}*/			
			if($enddate != '' && $stardate !=''){
				$this->db->where("PD.transaction_date >=",$stardate);  
				$this->db->where("PD.transaction_date <=",$enddate);
			}			
			$this->db->order_by('PD.transaction_date DESC');
			$query_purchase_transactions = $this->db->get();
			 echo $this->db->last_query();die; // 
			if($query_purchase_transactions->num_rows()>0)
			{
				return $query_purchase_transactions->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	public function getClientsTotalPendingAmount(){
	
		  $this->db->select('(SUM( PD.`debit_amount` ) - SUM( PD.`credit_amount` )) AS balanceAmt, C.comp_name, C.primary_phone, C.primary_mobile, C.primary_contact, C.comp_id');
			$this->db->from('payment_details AS PD');
			$this->db->join('clients AS C','C.comp_id = PD.payment_ref_id'); 
			$this->db->where('PD.payment_ref_type',1);
			$this->db->group_by('PD.payment_ref_id');
			$this->db->having('balanceAmt >0');
			$query_pending_amt = $this->db->get();
			// echo $this->db->last_query();die; // 
			if($query_pending_amt->num_rows()>0)
			{
				return $query_pending_amt->result_array();
			}
			else
			{
				return array();
			}
	}
	
}
?>